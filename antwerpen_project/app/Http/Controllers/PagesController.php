<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Projecten;
use App\User;
use App\Fase;
use App\Http\Requests;
use App\Reactie;
use App\Antwoorden;

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


    public  function save_answers(Request $request){
        $project_information = array('antwoord' => "error");



        foreach ($request->message as $key=>$data){
            foreach ($data as $index=>$content){
                foreach ($content as $i=>$value){
                    if($value=="true"){
                        $project_information = array('antwoord' =>$i , "vrag_id"=>$key);
                        $answer = new Antwoorden;
                        $answer->antwoorden =$i;
                        $answer->vragen_id =$key;
                        $answer->user_id =1;
                    }
                    if($i=="0"){
                        $project_information = array('antwoord' =>$value , "vrag_id"=>$key);
                        $answer = new Antwoorden;
                        $answer->antwoorden =$value;
                        $answer->vragen_id =$key;
                        $answer->user_id =1;

                    }
                    if($answer){
                        if(!$answer->save()){
                            return $project_information = array('error' =>true);
                            break;
                        }
                    }
                }

            }
        }
        return array('succes' =>true);
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
            $rections = $rections->take($number);
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
    
    
    public function delete_review(Request $request){
        
    }

    public function add_review(Request $request){
        $review = new Reactie;
        $review->reactie_masseg = $request->message;
        if($request->user_id == "null"){
            $review->user_id = 0;
        }else{
            $review->user_id = $request->user_id;
        }

        $review->projecten_id = $request->project_id;
        $review->rating = $request->rating;



        if($review){
            $review->save();
            $user= User::find($request->user_id);
            if($user){
                return array('user' => $user, 'reaction' => $review);
            }else{
                return array( 'reaction' => $review);
            }

        }
        return  array('error' => true);
    }


    public function about()
    {
        return view('pages.about');
    }


}
  