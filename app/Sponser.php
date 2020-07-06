<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponser extends Model
{
    protected $fillable = [
       'event_id', 'name', 'link'
    ];

    public function event(){
    	return $this->belongsTo(Event::class);
    }
}
