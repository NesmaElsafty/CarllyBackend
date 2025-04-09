<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $baseurl = env('CLOUDFLARE_R2_URL');
        return [
            "id"=> $this->id,
            "image" => $baseurl . $this->image
        ];
    }
}
