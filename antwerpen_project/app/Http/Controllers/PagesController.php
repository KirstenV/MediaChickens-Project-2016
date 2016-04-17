<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Projecten;
use App\User;
use App\Fase;
use App\Http\Requests;

class PagesController extends Controller
{
   public function home(){
	   //$projecten = \DB::table('projecten')->get();
	   //$users = User::all();
	  
	   //user -> on to many werkt! 
	   $user_id = 1;
	   $projecten = User::find($user_id)->show_projecten;
	   
	   
	   //projecten -> on to many fases
	   $projecten_id = 1;
	   $fases = Projecten::find($projecten_id)->show_fases;
	   
	   
	   //projecten -> on to many fotos
	   $fotos = Projecten::find($projecten_id)->show_fotos;
	   
	   
	   //projecten ->many to many relationship locatie
	   $locaties = Projecten::find($projecten_id)->show_locaties;
	   
	   return view('home')->with('projecten', $projecten);;

   }
	
	
	public function about(){
		return view('pages.about');
	}
	
	
	

}
  