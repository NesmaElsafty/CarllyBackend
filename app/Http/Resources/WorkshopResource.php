<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkshopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $baseUrl = env('APP_URL');
        
        if($this->workshop_logo == null){
            $logo = $baseUrl.'/icon/notfound.png';
        }else{
            // $logo = $this->workshop_logo;
            $logo = $baseUrl .'/'. $this->workshop_logo;
        }

        $images = $this->images()
        ->whereNotNull('image')
        ->pluck('image')
        ->map(fn($image) => $baseUrl . '/' . $image)
        ->toArray();
        
        return [
            'id'            => $this->id,
            'logo'          => $logo,
            'owner'         => $this->owner,
            'workshop_name' => $this->workshop_name,
            'employee'      => $this->employee,
            'tax_number'    => $this->tax_number,
            'legal_number'  => $this->legal_number,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'images'          => $images,
            'categories'    => WorkshopCategoryResource::collection($this->categories) ?? '',
            'brands'        => BrandResource::collection($this->brands) ?? '',
            'days'          => WorkshopDayResource::collection($this->days) ?? '',

        ];
    }
}
