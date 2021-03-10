<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
use App\Models\User;

class Book extends Model
{
    protected $fillable = [
        'id','code', 'name','desc','user_id'
    ];

    public function images()
    {
        return $this->hasMany(Image::class);

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
