<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{

    public function user() {

        return $this->belongsTo('App\User', 'author');
    }

     public function tappe() {

        return $this->HasMany('App\tappe', 'id_travel');
    }
}
