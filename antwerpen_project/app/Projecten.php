<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Projecten extends Model
{
	 public function show_fases()
    {
        return $this->hasMany('App\Fase');
    }
	
	 public function show_fotos()
    {
        return $this->hasMany('App\Project_foto');
    }
	
	  public function show_locaties()
    {
        return $this->belongsToMany('App\Locatie');
    }
	
    //
	protected $table = 'projecten';
}
