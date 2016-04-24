<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locatie extends Model
{
	public function show_projects_of_location()
    {
        return $this->belongsToMany('App\Projecten');
    }
    protected $table = 'locatie';
}
