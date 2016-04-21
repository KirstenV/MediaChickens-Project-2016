<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Projecten;
use App\User;
use App\Fase;
Use App\Project_foto;
use App\Vragen;


use App\Http\Requests;

class projectController extends Controller
{
    public function project_toevoegen(){
		$vragen=Projecten::all();
		return view('project_toevoegen');
	}
	
	public function show_project($id){
		$project_data = Projecten::find($id);
		
		return view('show_project')->with('project_data',$project_data);
	}
	
	public function edit_project($id){
		
		return view('edit_project')->with('id',$id);
		//return $project_data;
	}
	
	public function json_project($id){
		$project_data = Projecten::find($id);
		//return view('edit_project')->with('project_data',$project_data);
		return $project_data;
	}
	
	
	public function update_record($table,$id, Request $request){
		$status = "succes";
		DB::table($table)->where('id', $id)->update(array($request->input('row_name') => $request->input('row_content')));
		
		
		return $status;
	}
	
	public function json_fotos($id){
		$fotos = Projecten::find($id)->show_fotos;
		//return view('edit_project')->with('project_data',$project_data);
		return $fotos;
	}
	
	public function json_vragen($id){
		$project_vragen = Projecten::find($id)->show_vragen;
		//return view('edit_project')->with('project_data',$project_data);
		return $project_vragen;
	}
	
	public function add_project(Request $request){
		/*
		$project = new Projecten;
		$project->titel = "proef";
		$project->beschrijving ="proef proef";
		$project->project_picture ="proef_proef.jpg";
		$project->project_picture = 1;
		$project->save();
		*/
		
		return $request->all();
	}
	
}
