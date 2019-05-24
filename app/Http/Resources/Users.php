<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Users extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id"=>$this->id,
            "user_name"=>$this->user_name,
            "email"=>$this->email,
            "first_name"=>$this->first_name,
            "last_name"=>$this->last_name,
            "address"=>$this->address,
            "city"=>$this->city,
            "house_number"=>$this->house_number,
            "postal_code"=>$this->postal_code,
            "telephone_number"=>$this->telephone_number,
            "status"=>$this->status,
            "deleted_at"=>$this->deleted_at,
            "created_at"=>$this->created_at,
            "updated_at"=>$this->updated_at,
        ];
    }
}
