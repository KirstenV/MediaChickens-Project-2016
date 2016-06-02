<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class reaction_on_review extends Model
{
    use SoftDeletes;

    

    //
    protected $table = 'reaction_on_reviews';
    protected $dates = ['deleted_at'];
}
