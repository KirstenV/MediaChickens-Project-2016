<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Projecten;
use App\User;
use App\Fase;


use App\Http\Requests;

class projectController extends Controller
{
    public function project_toevoegen(){
		$vragen=Projecten::all();
		return view('project_toevoegen');
	}
	public function add_project(Request $request){
		return $request->all();
	}
}
