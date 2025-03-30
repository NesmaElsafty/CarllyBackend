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
        $image =  $this->image ?? '/icon/notfound.png';
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
