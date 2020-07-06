<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venue extends Model
{
     protected $fillable = [
      'event_id', 'image', 'name', 'address', 'latitude', 'longitude'
    ];

    public function event(){
    	return $this->belongsTo(Event::class);
    }
}
