<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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

        // $image ='/icon/notfound.png';
            $image = str_replace($appUrl, $r2, $this->image);
        
        return [
            'id' => $this->id,
            'fname' => $this->fname,
            'lname' => $this->lname,
            'image' => $image,
            'email' => $this->email,
            'phone' => $this->phone,
            'city' => $this->usertype === 'workshop_provider' ? $this->workshop_provider->branch : $this->city,
            'location' => $this->location,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'usertype' => $this->usertype,
            // 'package' => new PackageResource($this->package),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
