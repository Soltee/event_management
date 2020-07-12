<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = [
        'user_id', 'name', 'slug', 'image_url', 'thumbnail'
    ];

    public function events(){
    	return $this->hasMany(Event::class);
    }

}
