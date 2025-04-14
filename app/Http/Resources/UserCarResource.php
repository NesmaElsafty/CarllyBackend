<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserCarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            "id"                    => $this->id,
            "user_id"               => $this->user_id,
            "car_type"              => $this->car_type,
            "car_color"             => $this->car_color,
            "location"              => $this->location ?? $this->user->location,
            "total_views"           => "1",
            "listing_type"          => $this->listing_type,
            "listing_model"         => $this->listing_model,
            "listing_year"          => $this->listing_year,
            "listing_title"         => $this->listing_title,
            "listing_desc"          => $this->listing_desc,
            "images"                => ImageResource::collection($this->images),
            "listing_price"         => $this->listing_price,
            "features_gear"         => $this->features_gear,
            "features_speed"        => $this->features_speed,
            "features_seats"        => $this->features_seats,
            "features_door"         => $this->features_door,
            "features_fuel_type"    => $this->features_fuel_type,
            "features_climate_zone" => $this->features_climate_zone,
            "features_cylinders"    => $this->features_cylinders,
            "features_bluetooth"    => $this->features_bluetooth,
            "features_others"       => $this->features_others,
            "regional_specs"        => $this->regional_specs,
            "body_type"             => $this->body_type,
            "pickup_date"           => $this->pickup_date,
            "pickup_time"           => $this->pickup_time,
            "city"                  => $this->city ??$this->user->city,
            "lat"                   => $this->lat ?? $this->user->lat,
            "lng"                   => $this->lng ?? $this->user->lng,
            'contact_number'        => $this->contact_number,
            'wa_number'             => $this->wa_number,
            "vin_number"            => $this->vin_number,
            'max'                   => $this->max,
            'current'               => $this->current,
            "user"                  => new UserResource($this->user),
            "updated_at"            => $this->updated_at,
            "created_at"            => $this->created_at,
        ];
    }
}
