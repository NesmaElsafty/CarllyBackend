<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkshopCategoryResource extends JsonResource
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
        $image = str_replace($appUrl, $r2, $this->image);
        
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $image,
        ];
    }
}
