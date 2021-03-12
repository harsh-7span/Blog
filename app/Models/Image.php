<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Models\Book;

class Image extends Model
{
    protected $fillable = [
        'book_id','image',
    ];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
