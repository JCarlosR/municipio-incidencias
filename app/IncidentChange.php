<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IncidentChange extends Model
{
    public function incident()
    {
        return $this->belongsTo('App\Incident', 'incident_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function getDescriptionAttribute()
    {
        if ($this->type == 'registry')
            return 'La incidencia fue registrada por '.$this->user->name;
        if ($this->type == 'edit')
            return 'La incidencia fue editada por '.$this->user->name;
        if ($this->type == 'attention')
            return 'La incidencia fue atendida por '.$this->user->name;
        if ($this->type == 'derive')
            return 'La incidencia fue derivada por '.$this->user->name;
        if ($this->type == 'resolved')
            return 'La incidencia fue resuelta por '.$this->user->name;
        if ($this->type == 'open')
            return 'La incidencia fue reabierta por '.$this->user->name;
    }

}
