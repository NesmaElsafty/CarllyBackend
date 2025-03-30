<?php 
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdResource extends JsonResource
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
            'name' => $this->name,
            'caption' => $this->caption,
            'link' => $this->link,
            'price' => $this->price,
            'ad_type' => $this->ad_type,
            'appearance_qty' => $this->appearance_qty,
            'is_active' => (bool) $this->is_active,
            'from' => $this->from,
            'to' => $this->to,
            'views' => $this->views,
            'brand' => new BrandResource($this->brand),
            'user' => new UserResource($this->user),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
