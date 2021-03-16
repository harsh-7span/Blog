<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Plank\Mediable\Mediable;

class Author extends Model
{
    use Mediable;

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
    public function images()
    {
        return $this->hasMany(Image::class);

    }
}
