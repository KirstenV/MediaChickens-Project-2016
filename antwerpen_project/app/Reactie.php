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

    protected $dates = ['deleted_at'];
    //
}
