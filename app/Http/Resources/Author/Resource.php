<?php

namespace App\Http\Resources\Author;

use Illuminate\Http\Resources\Json\JsonResource;

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
        $data['images'] = $this->getMedia('gallery');
        foreach($this->tags as $tags)
        {
            $data['tags'][] = $tags->name;
        }
        return $data;
    }
}
