<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vragen extends Model
{

	public function show_answers()
	{
		return $this->hasMany('App\Antwoorden');
	}


	protected $table = 'vragen';
    //
}
