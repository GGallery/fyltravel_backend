<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tappe extends Model
{

	protected $table="tappe";

    //
    public function travel() {

        return $this->belongsTo('App\Travel', 'id');
    }



}
