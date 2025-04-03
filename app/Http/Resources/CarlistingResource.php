<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarListingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $baseUrl = env('APP_URL');

        $images = $this->images()
        ->whereNotNull('image')
        ->where('image', '!=', '')
        ->pluck('image')
        ->map(fn($image) => $baseUrl . '/' . $image)
        ->toArray();

        $company_name = $this->user->dealer->company_name;
        return [
            "id"                    => $this->id,
            "car_type"              => $this->car_type,
            "listing_title"         => $this->listing_title,
            "listing_type"          => $this->listing_type,
            "listing_model"         => $this->listing_model,
            "listing_year"          => $this->listing_year,
            "listing_price"         => $this->listing_price,
            "images"                => $images,
            'wa_number'             => $this->wa_number,
            'contact_number'        => $this->contact_number,
            "listing_desc"          => $this->listing_desc,
            'company_name'          => $company_name,
            "user_id"               => $this->user_id,
            "features_gear"         => $this->features_gear,
            "features_speed"        => $this->features_speed,
            "features_seats"        => $this->features_seats,
            "features_door"         => $this->features_door,
            "features_fuel_type"    => $this->features_fuel_type,
            "features_climate_zone" => $this->features_climate_zone,
            "features_cylinders"    => $this->features_cylinders,
            "features_bluetooth"    => $this->features_bluetooth,
            "features_others"       => $this->features_others,
            "car_color"             => $this->car_color,
            "body_type"             => $this->body_type,
            "regional_specs"        => $this->regional_specs,
            "vin_number"            => $this->vin_number,
            "pickup_date"           => $this->pickup_date,
            "pickup_time"           => $this->pickup_time,
            "updated_at"            => $this->updated_at,
            "created_at"            => $this->created_at,
            "img1"                  => $this->img1,
            "img2"                  => $this->img2,
            "img3"                  => $this->img3,
            "img4"                  => $this->img4,
            "img5"                  => $this->img5,
        ];
    }
}
