<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reactie extends Model
{
    use SoftDeletes;
    protected $table = 'reactie';


    public function show_projects_of_location()
    {
        return $this->belongsToMany('App\Projecten');
    }
    public function show_answer()
    {
        return $this->hasMany('App\reaction_on_review');
    }

    protected $dates = ['deleted_at'];
    //
}
