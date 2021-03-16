<?php

namespace App\Http\Resources\Book;

use Illuminate\Http\Resources\Json\ResourceCollection;

class Collection extends ResourceCollection
{
    public $collects = 'App\Http\Resources\Book\Resource';
    
    public function toArray($request)
    {
		return $this->collection;
    }

}
