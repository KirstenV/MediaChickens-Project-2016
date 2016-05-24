<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Projecten;
use App\User;
use App\Fase;
use App\Http\Requests;
use App\Reactie;

class PagesController extends Controller
{
    public function home()
    {

        //$projecten = \DB::table('projecten')->get();
        //$users = User::all();

        //user -> on to many werkt!
        // $user_id = 1;
        //$projecten = User::find($user_id)->show_projecten;


        //projecten -> on to many fases
        $projecten_id = 1;
        //$fases = Projecten::find($projecten_id)->show_fases;


        //projecten -> on to many fotos
        //$fotos = Projecten::find($projecten_id)->show_fotos;


        //projecten ->many to many relationship locatie
        //$locaties = Projecten::find($projecten_id)->show_locaties;


        return view('home');

    }

    public function json_al_projects()
    {
        return response()->json(Projecten::all());
    }


    public function get_al_info_from_project($id)
    {
        $project = Projecten::find($id);
        $project_information = array('project' => $project);
        $project_information = array_add($project_information, 'locaties', $project->show_locaties);
        $project_information = array_add($project_information, 'fotos', $project->show_fotos);
        $project_information = array_add($project_information, 'fases', $project->show_fases);
        $project_information = array_add($project_information, 'vragen', $project->show_vragen);

        if ($project_information) {
            return $project_information;
        }
        return  array('error' => true);

	}


    public function get_al_reactions($number, $id)
    {
        $project = Projecten::find($id);

        $reaction_information = array();
        if ($project) {
            $rections = $project->show_reactie;
            if ($rections) {
                for ($i = 0; $i < count($rections); $i++) {
                    $user = User::find($rections[$i]->user_id);
                    if ($user) {
                        $reaction_information = array_add($reaction_information, $i, array('user' => $user, 'reaction' => $rections[$i]));
                    }else{
                        $reaction_information = array_add($reaction_information, $i, array('user' => "Bezoeker", 'reaction' => $rections[$i]));
                    }
                }
                return $reaction_information;
            }
        }


        return  array('error' => true);
    }

    public function add_review(Request $request){
        $review = new Reactie;
        $review->reactie_masseg = $request->message;
        $review->user_id = $request->user_id;
        $review->projecten_id = $request->project_id;


        if($review){
            $review->save();
            $user= User::find($request->user_id);
            if($user){


                return array('user' => $user, 'reaction' => $review);
            }

        }
        return  array('error' => true);
    }


    public function about()
    {
        return view('pages.about');
    }


}
  