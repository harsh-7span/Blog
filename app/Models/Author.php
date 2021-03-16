<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $fillable = [
        'name','bio','dateOfbirth','dateOfdeth',
    ]; 

    public function books()
    {
        return $this->belongsToMany(Book::class,'author_book');
    }
    public function tags()
    {
        return $this->morphToMany(tag::class,'taggables');
    }
}
