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

    public function images() {

        return $this->HasMany('App\travels_image', 'id_travel');
    }

    public function scopo() {

        return $this->belongsToMany('App\travel_scopo', 'travels_scopi_map', 'id_travel', 'id_scopo');
    }

    public function keywords() {

        return $this->belongsToMany('App\travel_keywords', 'travels_keywords_map', 'id_travel', 'id_keywords');
    }

    public function consigliatoa() {

        return $this->belongsToMany('App\travel_consigliatoa', 'travels_consigliatoa_map', 'id_travel', 'id_consigliatoa');
    }
}
