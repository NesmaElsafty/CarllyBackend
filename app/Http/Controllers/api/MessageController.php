<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\allUsersModel;
use App\Models\carListingModel;
use App\Models\SparePartImage;
use App\Models\SparePart;
use App\Models\admin\adminAuthModel;
use App\Models\Message;
use Carbon\Carbon;

class MessageController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            "message"=>'required',
            'reciever_id'=>'required',
        ]);

        $message = Message::create([
            'message'=> $request['message'],
            'reciever_id'=> $request['reciever_id'],
            'sender_id'=> auth()->user()->id,
        ]);

        if ($message) {
            return [ 
                'status' =>true,
                'message' => 'Message Send Successfully!',
                'data' => $message
            ];
        }
      
    
    }

   
    public function getChatMessages(Request $request)
    {
        $messages = Message::with('sender','reciever')->where(function ($query) use ($request) {
            $query->where("sender_id", auth()->user()->id)
                ->where("reciever_id", $request->reciever_id );
        })
        ->orWhere(function ($query) use ($request) {
            $query->where("sender_id", $request->reciever_id)
                ->where("reciever_id", auth()->user()->id);
        })
    ->get();
       
        return [
            'status' =>true,
            'message' => "Data get successfully!",
            'data' =>  $messages,
        ];
    }
    public function getRecentChats(Request $request)
    {
        $user_ids1 = Message::where([
            "sender_id" => auth()->user()->id,

        ])->distinct('reciever_id')->pluck('reciever_id')->toArray();

        $user_ids2 = Message::where([
            "reciever_id" => auth()->user()->id,
            
        ])->distinct('sender_id')->pluck('sender_id')->toArray();

        $user_ids= array_merge($user_ids1,$user_ids2);
        $user_ids = array_unique($user_ids);
        $chats=[];
        foreach ($user_ids as $key => $id) {

            $message= Message::where(function ($query) use ($id) {
                $query->where("sender_id", auth()->user()->id)
                    ->where("reciever_id", $id );
            })
            ->orWhere(function ($query) use ($id) {
                $query->where("sender_id", $id)
                    ->where("reciever_id", auth()->user()->id);
            })->latest('id')->first();


            $message->user= allUsersModel::findOrFail($id);
            $chats[]=$message;
        }

       
        return [
            'status' =>true,
            'message' => "Data get successfully!",
            'data' =>  $chats,
        ];
    }

 

    public function addProduct(Request $request)
    {
        $validatedData=  $request->validate([
            "title" => "required",
            "images"=> "required| array",
            "brand"=> "required",
            "model"=> "required",
            "year"=> "required",
            "price"=> "required|gt:0",
        ]);
        $validatedData['desc']=$request->desc;
        $validatedData+=[
            'user_id'    => auth()->user()->id,
        ];
        unset($validatedData['images']);
       $data= SparePart::create($validatedData);

         ////////// handle images start
        foreach ($request->images as $image) {

            if ($image) {
                $img1 = $image;
                $imgname1 = time() . '.' . $img1->getClientOriginalExtension();
                $img1->move(public_path('spareparts'), $imgname1);
                $final_img = 'spareparts/'.$imgname1;
                 SparePartImage::create([
                    "spare_part_id" => $data->id,
                    "image" => $final_img,
                 ]);

                
            }
        }
        
        return [
            'status' =>true,
            'message' => "Spare Part listed successfully!",
            'data' => $data
        ];
    }

    public function delProduct(Request $request)
    {
        SparePart::findOrFail($request->product_id)->delete();

            return [
                'status' =>true,
                'message' => "Spare Parts is removed successfully!",
                'data' => null
            ];
    }



    public function updateProfile(Request $request)
    {
       
       $data=[];
        if($request->name){
            $data['name']=$request->name;
        }
        if($request->email){
            $data['email']=$request->email;
        }
        $image = $request->file('picture');
        if($image){
            $imageName = date('YmdHis') . "_user." . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/'), $imageName);
            $data['picture']=$imageName;
        }
        if($request->address){
            $data['location']=$request->address;
        }
        if($request->lat){
            $data['lat']=$request->lat;
        }
        if($request->lng){
            $data['lng']=$request->lng;
        }
        // else{  $imageName ="null";}

        $user=adminAuthModel::whereId($request->user()->id)->update($data);
        if($user){
            return [
                'status' =>true,
                'message' => "Profile updated successfully!",
                'data' => [],
            ];
        }
    }



}
