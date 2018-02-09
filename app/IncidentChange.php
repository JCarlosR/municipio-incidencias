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
            return 'La incidencia se registró';
        if ($this->type == 'edit')
            return 'La incidencia se editó';
        if ($this->type == 'attention')
            return 'La incidencia fue atendida por '.$this->user->name;
        if ($this->type == 'derive')
            return 'La incidencia se derivó';
        if ($this->type == 'resolved')
            return 'La incidencia se resolvió';
        if ($this->type == 'open')
            return 'La incidencia se abrió';
    }

}
