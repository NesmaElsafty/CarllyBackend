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
        // dd($this->user);
        $baseUrl = env('CLOUDFLARE_R2_URL');
        
        if($this->workshop_logo == null){
            $logo = $baseUrl.'/workshopNotFound.png';
        }else{
            // $logo = $this->workshop_logo;
            $logo = $baseUrl . $this->workshop_logo;
        }
        
        return [
            'id'            => $this->id,
            'logo'          => $logo,
            'owner'         => $this->owner,
            'location'         => $this->user->location,
            'city'         => $this->user->city,
            'lat'         => $this->user->lat,
            'lng'         => $this->user->lng,
            'phone'         => $this->user->phone,
            'whatsapp_number'         => $this->whatsapp_number,
            'workshop_name' => $this->workshop_name,
            'employee'      => $this->employee,
            'tax_number'    => $this->tax_number,
            'legal_number'  => $this->legal_number,
            'created_at'    => $this->created_at,
            'updated_at'    => $this->updated_at,
            'max'           => $this->max,
            'current'       => $this->current,
            // 'user'          => new UserResource($this->user),
            'images'        => ImageResource::collection($this->images),
            'categories'    => WorkshopCategoryResource::collection($this->categories) ?? '',
            'brands'        => BrandResource::collection($this->brands) ?? '',
            'days'          => WorkshopDayResource::collection($this->days) ?? ''            

        ];
    }
}
