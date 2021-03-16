<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Plank\Mediable\Mediable;

class Book extends Model
{
    use Mediable;
    
    protected $fillable = [
        'code', 'name','desc','user_id'
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
