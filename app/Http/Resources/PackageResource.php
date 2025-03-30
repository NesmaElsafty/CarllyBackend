<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PackageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'period' => $this->period,
            'period_type' => $this->period_type,
            'provider' => $this->provider,
            'price'=> $this->price,
            'features'=> $this->features,
            'limits'=> $this->limits,
            'created_at' => $this->created_at,
        ];
    }
}
