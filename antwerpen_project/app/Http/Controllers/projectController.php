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
    public function project_toevoegen(Request $request){
		
		$project = new Projecten;
		$project->titel = $request->titel;
		$project->beschrijving ="klick op mij en pas mij aan voor de beschrijving";
		$project->project_picture ="proef_proef.jpg";
		$project->user_id = $request->admin;
		$project->save();
		return back();
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
	
	//uneversel controller can adite diferend tabels and id
	public function update_record($table,$id, Request $request){
		DB::table($table)->where('id', $id)->update(array($request->input('row_name') => $request->input('row_content')));
		$usser_updatet = Projecten::find($id);
		
		
		return $usser_updatet;
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
	
	public function add_project($tabel,Request $request){
		
		
		$project = new Projecten;
		$project->titel = $request->row_content;
		$project->begin_datum="niet ingevuld";
		$project->eind_datum="niet ingevuld";
		$project->beschrijving ="klick op mij en pas mij aan voor de beschrijving";
		$project->project_picture ="proef_proef.jpg";
		$project->user_id = $request->admin;
		$project->save();
		
		//Projecten::create(array('titel'=>'proef','beschrijving'=>"broef proef",'project_picture'=>'proef.jpg','project_picture'=>1));
		
		return  User::find($request->admin)->show_projecten->last();
	}
	
	public function json_al_projects(){
		return response()->json( Projecten::all());
	}
	
}
