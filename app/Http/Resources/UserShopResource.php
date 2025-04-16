<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserShopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $appUrl = env('APP_URL');
        $r2 = env('CLOUDFLARE_R2_URL');

        $image ='/icon/notfound.png';
        if($this->image){
            $image = str_replace($appUrl, $r2, $this->image);
        }
        
        return [
            'id' => $this->id,
            'fname' => $this->fname,
            'lname' => $this->lname,
            'image' => $image,
            'email' => $this->email,
            'phone' => $this->phone,
            'city' => $this->city,
            'location' => $this->location ?? $this->dealer->company_address,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'usertype' => $this->usertype,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'dealer' => new ShopResource($this->dealer),
        ];
    }
}
