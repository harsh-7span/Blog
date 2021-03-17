<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    protected $fillable = [
        'url','imageable_type','imageable_id'
    ];

    public function imageable()
    {
        return $this->morphTo();
    }
}
