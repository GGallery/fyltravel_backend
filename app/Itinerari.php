<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Itinerari extends Model
{
    protected $table="itinerari";

    public function travels() {
        return $this->belongsToMany('App\Travel', 'itinerari_travel_map', 'id_itinerario', 'id_travel');
    }

}
