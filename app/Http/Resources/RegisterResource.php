<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id'  => $request->id,
            'name'=> $request->name,
            'email'  => $request->email,
            'phone'  => $request->phone,
            'accessToken' => $request->token,
        ];

        return $data;
    }
}
