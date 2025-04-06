<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImageResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\WorkshopResource;
use App\Models\allUsersModel;
use App\Models\CustomersCars;
use App\Models\CustomerService;
use App\Models\Image;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\WorkshopAppointments;
use App\Models\WorkshopCategory;
use App\Models\WorkshopCustomer;
use App\Models\WorkshopExpenses;
use App\Models\WorkshopProvider;
use App\Models\WorkshopService;
use App\Models\WorkshopServices;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

// Add this at the top

class WorkShopController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'fname'         => 'required',
            'lname'         => 'required',
            "email"         => 'required|email|unique:allusers,email,NULL,id,userType,workshop_provider',
            "phone"         => 'required|unique:allusers,phone,NULL,id,userType,workshop_provider',
            'password'      => 'required|min:6',
            'workshop_name' => 'required',
            'owner'         => 'max:245',
            'location'      => 'max:245',
            'city'          => 'max:245',
            'lat'           => 'max:245',
            'lng'           => 'max:245',
            'tax_number'    => 'max:245',
            'legal_number'  => 'max:245',
            'employee'      => 'max:245',
            'workshop_logo' => 'nullable|image|mimes:png,jpeg,gif,jpg',
            // Image array validation
            'images'        => 'nullable|array|max:5|min:1',
            'images.*'      => 'image|mimes:jpg,jpeg,png,gif', // Optional: limit file size to 2MB per image

        ]);

        $user = allUsersModel::create([
            'fname'    => $request['fname'],
            'lname'    => $request['lname'],
            'phone'    => $request['phone'],
            'email'    => $request['email'],
            'location' => $request['location'],
            'lat'      => $request['lat'],
            'lng'      => $request['lng'],
            'city'     => $request['city'],
            'password' => bcrypt($request['password']),
            "usertype" => "workshop_provider",
        ]);

        if ($request->hasFile('workshop_logo')) {
            $img1     = $request->file('workshop_logo');
            $imgname1 = time() . '.' . $img1->getClientOriginalExtension();
            $img1->move(public_path('workshops'), $imgname1);
            $company_img = 'workshops/' . $imgname1;
            $user->update(['image' => $company_img]);
        } else {
            $company_img = null;
        }

        $wsData = [
            "workshop_name" => $request->workshop_name,
            "workshop_logo" => $company_img,
            "owner"         => $request->owner,
            "user_id"       => $user->id,
            "address"       => $user->location,
            "branch"        => $user->city,
            "latitude"      => $user->lat,
            "longitude"     => $user->lng,
            "tax_number"    => $request->tax_number,
            "legal_number"  => $request->legal_number,
            "employee"      => $request->employee,
        ];

        $workshop_provider = WorkshopProvider::create($wsData);

        // Step 1: Create 5 placeholder images
        for ($i = 0; $i < 5; $i++) {
            Image::create([
                'image'                => null, // or 'icons/notfound.png'
                'workshop_provider_id' => $workshop_provider->id,
            ]);
        }

        // Step 2: Replace the placeholders with actual uploaded images (max 5)
        if ($request->hasFile('images')) {
            $uploadedImages = $request->file('images');
            $images         = $workshop_provider->images()->take(5)->get(); // Get first 5 placeholder records

            foreach ($uploadedImages as $index => $uploadedImage) {
                if ($index >= 5) {
                    break;
                }
                // Safety check

                $imgName = time() . '_' . $index . '.' . $uploadedImage->getClientOriginalExtension();
                $uploadedImage->move(public_path('workshops'), $imgName);
                $imagePath = 'workshops/' . $imgName;

                $images[$index]->update([
                    'image' => $imagePath,
                ]);
            }
        }
        if ($request->brands) {
            $workshop_provider->brands()->sync($request->brands);
        }

        if ($request->categories) {
            $workshop_provider->categories()->sync($request->categories);
        }

        if ($request->days) {
            for ($i = 0; $i <= count($request->days); $i++) {

                if (isset($request->days[$i]['day']) && isset($request->days[$i]['from']) && isset($request->days[$i]['to'])) {
                    $workshop_provider->days()->create([
                        'day'  => $request->days[$i]['day'],
                        'from' => $request->days[$i]['from'],
                        'to'   => $request->days[$i]['to'],
                    ]);
                }
            }
        }

        if ($user) {
            return [
                'status'  => true,
                'message' => 'Accounted created Successfully!',
                'data'    => [
                    "auth_token"    => $user->createToken('tokens')->plainTextToken,
                    "user"          => new UserResource($user),
                    "workshop_data" => new WorkshopResource($user->workshop_provider),
                ],
            ];
        } else {
            return [
                'status'  => false,
                'message' => 'Password is wronged!',
                'data'    => null,
            ];

        }

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

        $user = allUsersModel::where(['email' => $request['email'], 'usertype' => 'workshop_provider'])->first();
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

        $user = allUsersModel::where(['phone' => $request['phone'], 'usertype' => 'workshop_provider'])->first();
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

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            "status"  => true,
            'message' => 'You Logout successfully',
            "data"    => [],
        ];
    }

    public function uploadWorkshopImages(Request $request)
    {
        try {
            $user = auth()->user();

            if ($request->images) {
                foreach ($request->images as $image) {
                    $img1     = $image;
                    $imgname1 = time() . '.' . $img1->getClientOriginalExtension();
                    $img1->move(public_path('workshops'), $imgname1);
                    $company_img = 'workshops/' . $imgname1;

                    $image                       = new Image();
                    $image->image                = $company_img;
                    $image->workshop_provider_id = $user->workshop_provider->id;
                    $image->save();
                }
            }

            return [
                'status'  => true,
                'message' => 'Images Uploaded Successfully!',
                'data'    => ImageResource::collection($user->workshop_provider->images),
            ];
        } catch (Exception $e) {

        }
    }

    public function index()
    {
        $workshops = WorkshopProvider::get();
        return [
            "status" => true,
            "data"   => WorkshopResource::collection($workshops),
        ];
    }

    public function update(Request $request)
    {
        try {
            // ✅ Validate request directly
            $validatedData = $request->validate([
                'workshop_name' => 'required|string',
                'owner'         => 'required|string',
                'tax_number'    => 'required|string',
                'legal_number'  => 'required|string',
                'employee'      => 'required|integer',
                'categories'    => ['required', 'array', 'min:1'],
                'categories.*'  => ['integer', 'exists:workshop_categories,id'], // Ensure categories exist
                'brands'        => ['required', 'array', 'min:1'],
                'brands.*'      => ['integer', 'exists:car_brands,id'], // Ensure brands exist
            ]);

            // ✅ Find the workshop linked to the authenticated user
            $workshop = WorkshopProvider::where('user_id', auth()->user()->id)->firstOrFail();

            // ✅ Assign validated data
            $workshop->workshop_name = $request['workshop_name'];
            $workshop->owner         = $request['owner'] ?? $workshop->owner;

            if($request['tax_number'] != null  || $request['tax_number'] != ''){
                $workshop->tax_number    =  $workshop->tax_number;
            }

            $workshop->legal_number  = $request['legal_number'] ?? $workshop->legal_number;
            $workshop->employee      = $request['employee'] ?? $workshop->employee;

            // ✅ Handle file upload (if provided)
            if ($request->hasFile('workshop_logo')) {
                $img1     = $request->file('workshop_logo');
                $imgname1 = time() . '.' . $img1->getClientOriginalExtension();
                $img1->move(public_path('workshops'), $imgname1);
                $workshop->workshop_logo = 'workshops/' . $imgname1;
            }

            $workshop->save();

            if ($request->hasFile('images')) {
                $uploadedImages = $request->file('images');
                $images         = $workshop->images()->take(5)->get(); // Get first 5 placeholder records
    
                foreach ($uploadedImages as $index => $uploadedImage) {
                    if ($index >= 5) {
                        break;
                    }
                    // Safety check
    
                    $imgName = time() . '_' . $index . '.' . $uploadedImage->getClientOriginalExtension();
                    $uploadedImage->move(public_path('workshops'), $imgName);
                    $imagePath = 'workshops/' . $imgName;
    
                    $images[$index]->update([
                        'image' => $imagePath,
                    ]);
                }
            }
            
            //  Sync brands and categories (only if they exist in DB)
            $workshop->brands()->sync($request['brands']);
            $workshop->categories()->sync($request['categories']);

            if ($request->days) {

                $workshop->days()->delete();

                for ($i = 0; $i <= count($request->days); $i++) {
                    if (isset($request->days[$i]['day']) && isset($request->days[$i]['from']) && isset($request->days[$i]['to'])) {
                        $workshop->days()->create([
                            'day'  => $request->days[$i]['day'],
                            'from' => $request->days[$i]['from'],
                            'to'   => $request->days[$i]['to'],
                        ]);
                    }
                }
            }

            return response()->json([
                'status'  => true,
                'message' => 'Workshop updated Successfully!',
                'data'    => new WorkshopResource($workshop),
            ]);

        } catch (Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function getWorkshopCategories(Request $request)
    {
        $data = WorkshopCategory::latest('id');
        if ($request->search) {
            $data = $data->where('name', 'LIKE', '%' . $request->search . '%');
        }
        $data = $data->get();

        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => $data,
        ];
    }

    public function getProfile(Request $request)
    {
        $workshop = WorkshopProvider::where('user_id', auth()->user()->id)->first();

        return [
            'status'        => true,
            'message'       => "Data get successfully!",
            'user'          => new UserResource(auth()->user()),
            'workshop_data' => new WorkshopResource($workshop),
        ];
    }
// ====================================================================================================
    public function myCustomers(Request $request)
    {
        $customers = WorkshopCustomer::where('workshop_id', auth()->user()->id)
            ->with(['customerService', 'customersCars'])
            ->latest('id')
            ->paginate(15);

        // Transform the data to include the necessary attributes
        $customersData = $customers->items();

        foreach ($customersData as $customer) {
            // $customer->customer_cars = $customer->customersCars->pluck('car');
            $customer->customer_service = $customer->customerService->pluck('service');
        }

        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => [
                "customers"  => $customersData,
                "pagination" => [
                    'current_page' => $customers->currentPage(),
                    'per_page'     => $customers->perPage(),
                    'total'        => $customers->total(),
                    'last_page'    => $customers->lastPage(),
                ],
            ],
        ];
    }

    public function addCustomer(Request $request)
    {
        $validatedData = $request->validate([
            "cust_no"        => "required|max:50",
            "name"           => "required",
            "image"          => "required|image|mimes:png,jpeg,gif,jpg",
            "phone"          => "max:25",
            "address"        => "required",
            "vehicle_number" => "required|max:20",
            "car"            => "required|max:20",
            "model"          => "required|max:20",
            "date"           => "date",

        ]);
        $validatedData += [
            'workshop_id' => auth()->user()->id,
        ];if ($request->hasFile('image')) {
            $img1     = $request->file('image');
            $imgname1 = time() . '.' . $img1->getClientOriginalExtension();
            $img1->move(public_path('workshopCustomersImage'), $imgname1);
            $company_img            = 'workshopCustomersImage/' . $imgname1;
            $validatedData['image'] = url($company_img);
        }
        $data = WorkshopCustomer::create($validatedData);

        return [
            'status'  => true,
            'message' => "Customer Added successfully!",
            'data'    => $data,
        ];
    }

    public function delCustomer(Request $request)
    {
        WorkshopCustomer::findOrFail($request->customer_id)->delete();

        return [
            'status'  => true,
            'message' => "Customer is removed successfully!",
            'data'    => null,
        ];
    }

    public function getAllInvoices(Request $request)
    {
        $data = Invoice::with(['customer', 'invoiceItems'])->where('workshop_id', auth()->user()->id)->latest('id')
            ->paginate(15);

        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => [
                "invoices"   => $data->items(),
                "pagination" => [
                    'current_page' => $data->currentPage(),
                    'per_page'     => $data->perPage(),
                    'total'        => $data->total(),
                    'last_page'    => $data->lastPage(),
                ],
            ],
        ];
    }

    public function createInvoice(Request $request)
    {
        $validatedData = $request->validate([
            "invoice_no"   => "required",
            "invoice_date" => "required",
            "customer_id"  => "required",
            "price"        => "required",
            "service_name" => "required",
            "quantity"     => "required",
            "vehicl_no"    => "required",

        ]);
        $validatedData += [
            'workshop_id' => auth()->user()->id,
        ];
        $invoice       = Invoice::create($validatedData);
        $invoice_items = json_decode($request->invoice_items);
        foreach ($invoice_items as $item) {
            InvoiceItem::create([
                "name"       => $item->name,
                "unit_price" => $item->unit_price,
                "quantity"   => $item->quantity,
                "invoice_id" => $invoice->id,
                "status"     => $item->status,
            ]);
        }

        return [
            'status'  => true,
            'message' => "Invoice Created successfully!",
            'data'    => $invoice,
        ];
    }

    //-------------------- Manage workshop service-----------------------
    public function addworkshopservice(Request $request)
    {
        $validatedData = $request->validate([
            "car_model"        => "required",
            "year"             => "required",
            "service_category" => "required",
            "note"             => "required",
            "location"         => "required",
        ]);
        $validatedData += [
            'workshop_id' => auth()->user()->id,
        ];
        $service = WorkshopServices::create($validatedData);
        return [
            'status'  => true,
            'message' => "Service Created successfully!",
            'data'    => $service,
        ];
    }

    public function getAllServices(Request $request)
    {
        $data = WorkshopServices::where('workshop_id', auth()->user()->id)->latest('id')->paginate(15);

        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => [
                "workshop_services" => $data->items(),
                "pagination"        => [
                    'current_page' => $data->currentPage(),
                    'per_page'     => $data->perPage(),
                    'total'        => $data->total(),
                    'last_page'    => $data->lastPage(),
                ],
            ],
        ];
    }

    public function delService(Request $request)
    {
        WorkshopServices::findOrFail($request->service_id)->delete();

        return [
            'status'  => true,
            'message' => "Service is removed successfully!",
            'data'    => null,
        ];
    }

    //-------------------- Manage workshop customers car-----------------------
    public function addCar(Request $request)
    {
        $validatedData = $request->validate([
            "name"        => "required",
            "customer_id" => "required",
            "image"       => "required|image|mimes:png,jpeg,gif,jpg",
            "date"        => "required",
            "model"       => "required",
            "year"        => "required",
            "vin_number"  => "required",
            "car_number"  => "required",
        ]);

        $validatedData += [
            'workshop_id' => auth()->user()->id,
        ];

        if ($request->hasFile('image')) {
            $img1     = $request->file('image');
            $imgname1 = time() . '.' . $img1->getClientOriginalExtension();
            $img1->move(public_path('customers_cars'), $imgname1);
            $company_img            = url('customers_cars/' . $imgname1);
            $validatedData['image'] = $company_img;
        }

        $service = CustomersCars::create($validatedData);

        return [
            'status'  => true,
            'message' => "Car Added successfully!",
            'data'    => $service,
        ];
    }

    public function getAllCars(Request $request)
    {
        $data = CustomersCars::where('workshop_id', auth()->user()->id)->latest('id')->paginate(15);

        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => [
                "allCars"    => $data->items(),
                "pagination" => [
                    'current_page' => $data->currentPage(),
                    'per_page'     => $data->perPage(),
                    'total'        => $data->total(),
                    'last_page'    => $data->lastPage(),
                ],
            ],
        ];
    }
    public function delCars(Request $request)
    {
        CustomersCars::findOrFail($request->id)->delete();

        return [
            'status'  => true,
            'message' => "Car is removed successfully!",
            'data'    => null,
        ];
    }

    //-------------------- Manage workshop customers service-----------------------
    public function addCustomerService(Request $request)
    {
        $validatedData = $request->validate([
            "customer_name" => "required",
            "customer_id"   => "required",
            "car_name"      => "required",
            "isCompleted"   => "required",

        ]);
        $validatedData += [
            'workshop_id' => auth()->user()->id,
        ];
        $service = CustomerService::create($validatedData);
        return [
            'status'  => true,
            'message' => "Service Added To Given Customer successfully!",
            'data'    => $service,
        ];
    }

    public function getAllCustomerServices(Request $request)
    {
        $data = CustomerService::where('workshop_id', auth()->user()->id)->latest('id')->paginate(15);

        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => [
                "services"   => $data->items(),
                "pagination" => [
                    'current_page' => $data->currentPage(),
                    'per_page'     => $data->perPage(),
                    'total'        => $data->total(),
                    'last_page'    => $data->lastPage(),
                ],
            ],
        ];
    }
    public function deleteCustomerService(Request $request)
    {
        CustomerService::findOrFail($request->id)->delete();

        return [
            'status'  => true,
            'message' => "Car is removed successfully!",
            'data'    => null,
        ];
    }

    //-------------------- Manage workshop cexpenses-----------------------

    public function addWorkshopExpense(Request $request)
    {
        $validatedData = $request->validate([
            "name"             => "required",
            "customer"         => "required",
            "service_category" => "required",
            "amount"           => "required",
            "date"             => "required",
        ]);
        $validatedData += [
            'workshop_id' => auth()->user()->id,
        ];
        $service = WorkshopExpenses::create($validatedData);
        return [
            'status'  => true,
            'message' => "Workshop expense added successfully!",
            'data'    => $service,
        ];
    }
    public function getWorkshopExpense(Request $request)
    {
        $data = WorkshopExpenses::where('workshop_id', auth()->user()->id)->latest('id')->paginate(15);

        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => [
                "expenses"   => $data->items(),
                "pagination" => [
                    'current_page' => $data->currentPage(),
                    'per_page'     => $data->perPage(),
                    'total'        => $data->total(),
                    'last_page'    => $data->lastPage(),
                ],
            ],
        ];
    }

    public function deleteWorkshopExpense(Request $request)
    {
        WorkshopExpenses::findOrFail($request->id)->delete();

        return [
            'status'  => true,
            'message' => "Workshop expense removed successfully!",
            'data'    => null,
        ];
    }

    //-------------------- Manage workshop Appointments-----------------------

    public function addAppointment(Request $request)
    {
        $validatedData = $request->validate([
            "name"           => "required",
            "vehicle_number" => "required",
            "repair_summary" => "required",
            "image"          => "required",
            "location"       => "required",
            "phone"          => "required",
            "date"           => "required",
            "time"           => "required",
            "customer_id"    => "required",
        ]);
        $validatedData += [
            'workshop_id' => auth()->user()->id,
        ];
        if ($request->hasFile('image')) {
            $img1     = $request->file('image');
            $imgname1 = time() . '.' . $img1->getClientOriginalExtension();
            $img1->move(public_path('workshop_appointments'), $imgname1);
            $company_img            = url('workshop_appointments/' . $imgname1);
            $validatedData['image'] = $company_img;
        }

        $service = WorkshopAppointments::create($validatedData);
        return [
            'status'  => true,
            'message' => "Workshop appointment added successfully!",
            'data'    => $service,
        ];
    }
    public function getAllAppointments(Request $request)
    {
        $data = WorkshopAppointments::where('workshop_id', auth()->user()->id)->latest('id')->paginate(15);

        return [
            'status'  => true,
            'message' => "Data get successfully!",
            'data'    => [
                "appointments" => $data->items(),
                "pagination"   => [
                    'current_page' => $data->currentPage(),
                    'per_page'     => $data->perPage(),
                    'total'        => $data->total(),
                    'last_page'    => $data->lastPage(),
                ],
            ],
        ];
    }

    public function deleteAppointment(Request $request)
    {
        WorkshopAppointments::findOrFail($request->id)->delete();

        return [
            'status'  => true,
            'message' => "Workshop appointment removed successfully!",
            'data'    => null,
        ];
    }

    public function getWorkshopServices()
    {
        return $services = WorkshopService::all();
    }
}
