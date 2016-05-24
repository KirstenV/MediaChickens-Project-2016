<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Projecten extends Model
{
    use SoftDeletes;
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
	 public function show_vragen()
    {
         return $this->hasMany('App\Vragen');
    }
    public function show_reactie()
    {
        return $this->hasMany('App\Reactie');
    }
	
    //
    protected $table = 'projecten';
    protected $dates = ['deleted_at'];

}
