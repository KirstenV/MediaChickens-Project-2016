<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Projecten;
use App\Locatie;
use App\Locatie_projecten;
use App\Http\Requests;

class kaartController extends Controller
{
    
	public function json_projects($id){
	
	   //projecten ->many to many relationship locatie
	   $locaties = Locatie::find($id)->show_projects_of_location;
	   
	   return $locaties;

   }
   
   
   	public function json_locations(){
	
	   //projecten ->many to many relationship locatie
	   $locaties = Locatie::all();
	   
	   return $locaties;

   }
}
