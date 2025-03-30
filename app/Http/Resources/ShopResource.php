<?php

namespace App\Http\Resources;

use App\Models\allUsersModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopResource extends JsonResource
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
            'user_id' => $this->user_id,
            'is_top_dealer' =>$this->is_top_dealer,
            'company_name' => $this->company_name,
            'company_img' => $this->company_img,
            'company_address' => $this->company_address,
            'reviews' => $this->reviews,
            'created_at' => $this->created_at,       
        ];
    }
}
