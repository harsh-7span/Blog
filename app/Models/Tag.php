<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = [
        'tag_id', 'name','taggables_type','taggables_id'
    ];

    public function books()
    {
        return $this->morphedByMany(Book::class,'taggables','taggables_type','taggables_id');
    }
    public function authors()
    {
        return $this->morphedByMany(tag::class,'taggables','taggables_type','taggables_id');
    }
    
}
