<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $baseUrl = env('CLOUDFLARE_R2_URL');
        
        if($this->image == null){
            $image = $baseUrl.'/icon/notfound.png';
        }else{
            $image = $baseUrl . $this->image;
        }
    
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $image,
            'link' => $this->link,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
