<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Projecten;
use App\User;
use App\Fase;
Use App\Project_foto;
use App\Vragen;
use App\Antwoorden;

class unityController extends Controller
{
    public function get_projects(){
        return response()->json( Projecten::all());
    }

    public function get_vragen_by_id($id,$user){
        if($user){
            
        }
        return $fases = Projecten::find($id)->show_vragen;
    }

    public function login_unity(Request $request){
        $errors = array('project' => Projecten::find($id));
        if(!isset($request->name)){

        }
    }
    
    
}
