<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Projecten;
use App\User;
use App\Fase;
Use App\Project_foto;
use App\Vragen;

class unityController extends Controller
{
    public function get_projects(){
        return response()->json( Projecten::all());
    }

    public function get_vragen_by_id($id){
        return $fases = Projecten::find($id)->show_vragen;
    }
}
