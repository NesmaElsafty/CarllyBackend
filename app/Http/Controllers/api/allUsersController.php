<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\allUsersModel;
use App\Models\SparePart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserShopResource;
use App\Models\Package;
use App\Models\UserPackageSubscription;
use Storage;
class allUsersController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            "email"       => ["required", "email", Rule::unique('allusers')->where('usertype', 'user')],
            'fname'       => 'required',
            'phone'       => ["required", Rule::unique('allusers')->where('usertype', 'user')],
            'password'    => 'required|min:6',
            'company_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image
        ]);

        $imagePath = null;

        if ($request->hasFile('company_img')) {
            // Check if the "user" folder exists in "public", and create it if it doesn't
            $uploadPath = public_path('users');
            if (! file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Save the image
            $image     = $request->file('company_img');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

            $path = Storage::disk('r2')->put('users/' . $imageName, file_get_contents($image));   

            // $image->move($uploadPath, $imageName);

            // Store the image path to save in the database
            $imagePath = 'users/' . $imageName;
        }

        $user = allUsersModel::create([
            'fname'    => $request['fname'],
            'lname'    => $request['lname'],
            'phone'    => $request['phone'],
            'email'    => $request['email'],
            'password' => bcrypt($request['password']),
            'city'     => $request['city'] ?? '',
            'lat'      => $request['lat'] ?? '',
            'lng'      => $request['lng'] ?? '',
            'userType' => "user",
            'image'    => $imagePath, // Save the image path in the database
        ]);

        if ($request->package_id) {
            $package = Package::findOrFail($request->package_id);

            $start = now();
            if ($package->period_type == 'Years') {
                $period = $package->period * 12;
                $end    = $start->copy()->addMonths($period);
            } else {
                $end = $start->copy()->addMonths($package->period);
            }

            $subscription = UserPackageSubscription::create([
                'user_id'    => $user->id,
                'package_id' => $package->id,
                'price'      => $package->price,
                'starts_at'  => $start,
                'ends_at'    => $end,
                'status'     => 'active',
                'renewed'    => false,
            ]);
        }else{
            $package = Package::where('title', 'free Car Provider')->first();
            $start = now();
            if ($package->period_type == 'Years') {
                $period = $package->period * 12;
                $end    = $start->copy()->addMonths($period);
            } else {
                $end = $start->copy()->addMonths($package->period);
            }

            $subscription = UserPackageSubscription::create([
                'user_id'    => $user->id,
                'package_id' => $package->id,
                'price'      => $package->price,
                'starts_at'  => $start,
                'ends_at'    => $end,
                'status'     => 'active',
                'renewed'    => false,
            ]);
        }


        if ($user) {
            return [
                'status'  => true,
                'message' => 'Account created successfully!',
                'data'    => [
                    "auth_token" => $user->createToken('tokens')->plainTextToken,
                    "user"       => new UserResource($user),
                ],
            ];
        }

        return response()->json([
            'status'  => false,
            'message' => 'Unable to create account!',
        ], 500);
    }

    public function login(Request $request)
    {
        if (isset($request->firebase_auth) && $request->firebase_auth == true) {
            return $this->phoneLogin($request);
        }
        $request->validate([
            "email"    => 'required|email',
            'password' => 'required',
        ]);

        $user = allUsersModel::where(['email' => $request['email'], "userType" => "user"])
            ->first();
        if ($user == null) {
            return [
                'status'  => false,
                'message' => 'Email is wronged or not registered!',
                'data'    => null,
            ];
        }
        $validCredentials = Hash::check($request['password'], $user->password);
        if ($validCredentials) {
            return [
                'status'  => true,
                'message' => 'Login Success!',
                'data'    => [
                    "auth_token" => $user->createToken('tokens')->plainTextToken,
                    "user"       => new UserResource($user),
                ],
            ];
            session(['user' => $user]);
        } else {
            return [
                'status'  => false,
                'message' => 'Password is wronged!',
                'data'    => null,
            ];

        }

    }

    public function phoneLogin(Request $request)
    {

        $request->validate([
            "phone" => 'required',
        ]);

        $user = allUsersModel::where(['phone' => $request['phone'], "userType" => "user"])
            ->first();
        if ($user == null) {
            return [
                'status'  => false,
                'message' => 'Phone is wronged or not registered!',
                'data'    => null,
            ];
        } else {
            return [
                'status'  => true,
                'message' => 'Login Success!',
                'data'    => [
                    "auth_token" => $user->createToken('tokens')->plainTextToken,
                    "user"       => new UserResource($user),
                ],
            ];
        }

    }

    public function updateProfile(Request $request)
    {

        $data = [];
        if ($request->fname) {
            $data['fname'] = $request->fname;
        }
        if ($request->lname) {
            $data['lname'] = $request->lname;
        }
        if ($request->city) {
            $data['city'] = $request->city;
        }
        if ($request->lat) {
            $data['lat'] = $request->lat;
        }
        if ($request->lng) {
            $data['lng'] = $request->lng;
        }
        if ($request->location) {
            $data['location'] = $request->location;
        }
        if ($request->email) {
            $request->validate([
                "email" => [Rule::unique('allusers')->ignore(auth()->user()->id)->where('usertype', auth()->user()->usertype)],
            ]);
            $data['email'] = $request->email;
        }
        if ($request->phone) {
            $request->validate([
                "phone" => [Rule::unique('allusers')->ignore(auth()->user()->id)->where('usertype', auth()->user()->usertype)],
            ]);
            $data['phone'] = $request->phone;
        }
        $image = $request->file('image');
        if ($image) {
            $imgname1 = time() . '.' . $image->getClientOriginalExtension();
            
            $path = Storage::disk('r2')->put('users/' . $imgname1, file_get_contents($image));   

            // $image->move(public_path('users'), $imgname1);
            $data['image'] = 'users/' . $imgname1;
        }

        $user = allUsersModel::findOrFail(auth()->user()->id);
        // dd(gettype($user->lat));
        $user->update($data);
        if ($user) {
            return [
                'status'  => true,
                'message' => "Profile updated successfully!",
                'data'    => new UserResource($user),
            ];
        }
    }

    public function getUsersApiF()
    {
        $allusers = allUsersModel::orderBy('id', 'desc')->get();
        if ($allusers->count() > 0) {
            return response()->json([
                "status" => true,
                "data"   => UserResource::collection($allusers)
            ], 200);
        } else {
            return response()->json([
                "status"  => false,
                "Message" => "Users Records is Empty",
            ], 404);
        }
    }
    ////// get method check user by phone
    public function checkUserByPhoneApiF($phone)
    {
        if (! $phone) {
            return response()->json([
                "status"              => false,
                "required Parameters" => [
                    'phone',
                ],
                "Message"             => "Required get Parameters Like /phoneNumber",
            ], 404);
        } else {
            // Assuming 'phone' is the column name in the 'all_users' table
            $check = allUsersModel::where('phone', $phone)->first();

            if ($check) {
                return response()->json([
                    "status"        => true,
                    "isHaveAccount" => true,
                    "data"          => new UserResource($check)
                ], 200);
            } else {
                return response()->json([
                    "status"        => false,
                    "isHaveAccount" => false,
                    "Message"       => "User Not Registered",
                ], 404);
            }
        }
    }

    /////////// update Password
    public function UpdatePasswordApiF(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id'       => 'required',
            'password' => 'required',
            // 'brandimg' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status"          => false,
                "required fields" => [
                    'id',
                    'password',
                ],
                "Message"         => "Required All Fields",
            ], 404);
        } else {
            $check = allUsersModel::find($req->id);
            if ($check) {
                $check->update([
                    'password' => $req->password,
                ]);
                return response()->json([
                    "status" => true,
                    "data"   => 'Password is Updated',
                ], 200);
            } else {
                return response()->json([
                    "status"  => false,
                    "Message" => "Password Can Not Changed",
                ], 404);
            }
        }
    }
    /////////// update email
    public function UpdateEmailApiF(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id'    => 'required',
            'email' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status"          => false,
                "required fields" => [
                    'id',
                    'email',
                ],
                "Message"         => "Required All Fields",
            ], 404);
        } else {
            $check = allUsersModel::find($req->id);
            if ($check) {
                $check->update([
                    'email' => $req->email,
                ]);
                return response()->json([
                    "status" => true,
                    "data"   => 'Email is Updated',
                ], 200);
            } else {
                return response()->json([
                    "status"  => false,
                    "Message" => "Email Can Not Changed",
                ], 404);
            }
        }
    }

    /////////// update email
    public function UpdateProfileApiF(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'id'    => 'required',
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required',
            // 'brandimg' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status"          => false,
                "required fields" => [
                    'id',
                    'profile',
                    'fname',
                    'lname',
                    'email',
                ],
                "optional fields" => [
                    'profile',
                ],
                "Message"         => "Required All Fields",
            ], 404);
        } else {
            $check = allUsersModel::find($req->id);
            if ($check) {
                if ($req->hasFile('profile')) {
                    $doc     = $req->file('profile');
                    $docname = time() . '.' . $doc->getClientOriginalExtension();
                    $doc->move(public_path('icon'), $docname);
                    $profileimage = 'icon/' . $docname;
                } else {
                    $profileimage = $check->image;
                }

                $check->update([
                    'image' => $profileimage,
                    'fname' => $req->fname,
                    'lname' => $req->lname,
                    'email' => $req->email,
                ]);
                return response()->json([
                    "status" => true,
                    "data"   => 'Profile is Updated',
                ], 200);
            } else {
                return response()->json([
                    "status"  => false,
                    "Message" => "Profile Can Not Update",
                ], 404);
            }
        }
    }
    /////////// add user
    public function addUserF(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required',
            // 'brandimg' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status"          => false,
                "required fields" => [
                    'fname',
                    'lname',
                    'email',
                ],
                "optional fields" => [
                    'profile',
                ],
                "Message"         => "Required All Fields",
            ], 404);
        } else {
            if ($req->hasFile('profile')) {
                $doc     = $req->file('profile');
                $docname = time() . '.' . $doc->getClientOriginalExtension();
                $doc->move(public_path('icon'), $docname);
                $profileimage = 'icon/' . $docname;
            } else {
                $profileimage = 'icon/profile.png';
            }

            $result = allUsersModel::update([
                'image' => $profileimage,
                'fname' => $req->fname,
                'lname' => $req->lname,
                'email' => $req->email,
            ]);
            if ($result) {
                return response()->json([
                    "status" => true,
                    "data"   => 'Profile is added',
                ], 200);
            } else {
                return response()->json([
                    "status"  => false,
                    "Message" => "Profile Can Not Added",
                ], 404);
            }
        }
    }

    public function searchSpareParts(Request $request)
    {
        $spareParts = SparePart::with(['images', 'user.dealer'])
            ->whereHas('user')
            ->latest('id');

        // Apply the title search filter
        if (isset($request->search) && $request->search != '') {
            $spareParts->where(function ($query) use ($request) {
                $query->where('title', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('desc', 'LIKE', '%' . $request->search . '%');
            });
        }
        if (isset($request->brand) && $request->brand != '') {
            $spareParts->where('brand', $request->brand);
        }

        // Apply other filters that can be handled in SQL
        if (isset($request->year) && ! empty($request->year)) {
            $spareParts->whereJsonContains('year', $request->year);
        }
        if (isset($request->part_type) && $request->part_type != '') {
            $spareParts->where('part_type', $request->part_type);
        }
        if (isset($request->city) && $request->city != '') {
            $spareParts->where('city', $request->city);
        }

        // Execute the query and fetch results
        $spareParts = $spareParts->get();

        // Concatenate model and year from the request
        $deleteKeyToCheck = isset($request->model, $request->year) ? $request->model . $request->year : null;

        if ($deleteKeyToCheck) {
            // Exclude spare parts whose deleteKey matches the concatenated model and year
            $spareParts = $spareParts->filter(function ($part) use ($deleteKeyToCheck) {
                $deleteKeys = json_decode($part->deleteKey, true);

                // Check if deleteKeys contains the concatenated value
                return ! (is_array($deleteKeys) && in_array($deleteKeyToCheck, $deleteKeys));
            })->values();
        }

        // Retrieve unique dealers based on the user field
        $dealers = $spareParts->map(function ($part) {
            return $part->user;
        })->unique('id')->values();

        return [
            'status'  => true,
            'message' => "Matched data retrieved successfully!",
            'data'    => UserShopResource::collection($dealers),
        ];
    }

    public function deleteUser(Request $request)
    {
        $authUserId = auth()->id();

        // Get the user ID from the request
        $userIdToDelete = $request->id;

        // Find the user to delete
        $user = allUsersModel::find($userIdToDelete);

        // Check if the user exists and the authenticated user is the same as the requested user
        if ($user && $authUserId == $userIdToDelete && $user->usertype == 'user') {

            // Delete the user
            $user->delete();

            // Return success message
            return response()->json([
                'status'  => true,
                'message' => 'Account deleted successfully!',
                'data'    => [
                    'user' => $user,
                ],
            ]);
        }

        // If the user doesn't exist or the condition fails
        return response()->json([
            'status'  => false,
            'message' => 'User not found or unauthorized action!',
        ], 400);
    }

    public function getCurrentUser()
    {
        // Check if the user is authenticated by checking the auth()->check() value
        if (auth()->check()) {
            // Retrieve the authenticated user using auth()->user()
            $user = auth()->user();

            return response()->json([
                'status'  => true,
                'message' => 'User found.',
                'data'    => new UserResource($user),
            ], 200); // 200 OK status for success
        }

        // If the user is not authenticated (token invalid or missing)
        return response()->json([
            'status'  => false,
            'message' => 'User not authenticated.',
        ], 401); // 401 Unauthorized status
    }

}
