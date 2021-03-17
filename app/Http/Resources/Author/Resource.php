<?php

namespace App\Http\Resources\Author;

use Illuminate\Http\Resources\Json\JsonResource;
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
        $data['name'] = $this->name;
        $data['bio'] = $this->bio;
        $data['dateOfbirth'] = $this->dateOfbirth;
        $data['dateOfdeth'] = $this->dateOfdeth;
        foreach($this->tags as $tags)
        {
            $data['tags'][] = $tags->name;
        }
        foreach($this->images as $images)
        {
            $data['images'][] =  Storage::url($images['url']);    
        }
        return $data;
    }
}
