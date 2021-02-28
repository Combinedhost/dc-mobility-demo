<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserWiseRatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data =  [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'created_at' => Carbon::parse($this->created_at)->format('d-m-Y'),
            'ratings' => RatingResource::collection($this->rating_history),
        ];
        $data['average_rating'] = null;

        if($this->average_rating->first()){
            $data['average_rating'] = $this->average_rating->first()->value;
        }

        return $data;
    }
}
