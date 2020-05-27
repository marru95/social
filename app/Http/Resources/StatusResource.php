<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatusResource extends JsonResource
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
            'body' => $this->body,
            'user_name' => $this->user->name,
            'user_avatar' => 'https://image.shutterstock.com/image-vector/people-icon-vector-user-symbol-600w-1714434235.jpg',
            'ago' => $this->created_at->diffForHumans()
        ];
    }
}
