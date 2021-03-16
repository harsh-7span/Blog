<?php

namespace App\Http\Resources\Book;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User\Resource as UserResource;
use Illuminate\Support\Facades\Storage;

class Resource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    
     public function toArray($request)
    {
        $data['id'] = $this->id;
        $data['code'] = $this->code;
        $data['desc'] = $this->desc;
        $data['name'] = $this->name;
        $data['images'] = $this->getMedia('gallery');
        $data['author'] = new UserResource($this->user);
        return ['book' => $data];
    }
}
