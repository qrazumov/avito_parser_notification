<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Result extends JsonResource
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
            'title' => $this->title,
            'desc' => $this->desc,
            'link' => $this->link,
            'phone' => $this->phone,
            'price' => $this->price,
            'src' => $this->src,
            'status' => $this->status,
        ];
        //return parent::toArray($request);
    }
}
