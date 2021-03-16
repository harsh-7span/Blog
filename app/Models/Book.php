<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    protected $fillable = [
        'id','code', 'name','desc','user_id'
    ];

    public function images()
    {
        return $this->hasMany(Image::class);

    }
    public function authors()
    {
        return $this->belongsToMany(Author::class,'author_book','author_id','book_id');
    }
    public function tags()
    {
        return $this->morphToMany(tag::class,'taggables');
    }
}
