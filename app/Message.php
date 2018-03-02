<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

    public function incident()
    {
        return $this->belongsTo('App\Incident');
    }

    public function getMessageCompleteAttribute()
    {
        return $this->message.' '.$this->created_at;
    }
}
