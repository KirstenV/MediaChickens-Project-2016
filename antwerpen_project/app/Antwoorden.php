<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Antwoorden extends Model
{

    public function show_users()
    {
        return $this->belongsToMany('App\User');
    }

    public function show_vragen()
    {
        return $this->belongsToMany('App\Vragen');
    }
    protected $table = 'antwoorden';
}
