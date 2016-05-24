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
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class unityController extends Controller
{

    //install https://github.com/briannesbitt/Carbon
    public function get_projects()
    {
        $current_projects_with_custions = array();

        $projecten = DB::table('projecten')
            ->where('begin_datum', '<=', Carbon::now())
            ->where('eind_datum', '>=', Carbon::now())
            ->get();



        for ($i = 0; $i < count($projecten); $i++) {
            if (Projecten::find($projecten[$i]->id)) {
                $project = Projecten::find($projecten[$i]->id);
                if (count($project->show_vragen)) {
                    $current_projects_with_custions = array_add($current_projects_with_custions, $i, $projecten[$i]);
                }
            }
        }
        if(!$current_projects_with_custions){
            return array("error"=>"No projects are available");
        }
        return $current_projects_with_custions;


        //return response()->json(Projecten::all());
    }

    public function get_relevant_projects()
    {
        return response()->json(Projecten::all());
    }


    public function get_vragen_by_id($id)
    {
        return $fases = Projecten::find($id)->show_vragen;
    }


    public function answers_unity(Request $request)
    {


        // return array('antwoorden' => $request["antwoorden"],'vragen_id'=>$request["vragen_id"],'user_id'=>$request["user_id"]);
        if ($request["antwoorden"] && $request["vragen_id"] && $request["user_id"]) {
            $antwoord = new Antwoorden;
            if ($antwoord) {
                $antwoord->antwoorden = $request["antwoorden"];
                $antwoord->vragen_id = $request["vragen_id"];
                $antwoord->projecten_id = $request["user_id"];

                if ($antwoord->save()) {
                    return array('succes' => true, "antwoord" => $antwoord);
                } else {
                    return array('error' => true, "debug" => "server error save dosen´t workt");
                }
            }
        }
        return array('error' => true, "debug" => "wrong variabel names");
    }

    public function login_unity(Request $request)
    {
        $errors = array('success' => "false");

        $userData = array(
            'email' => $request["email"],
            'password' => $request["password"],
        );
        $rules = array(
            'email' => 'required|email',
            'password' => 'required|min:6',
        );

        $validator = Validator::make($userData, $rules);
        if ($validator->fails()) {
            return response()->json(array(
                'success' => false, 'errors' => $validator->getMessageBag()->toArray(),
            ));
        } else {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                // Authentication passed...
                return response()->json(['success' => true, 'User' => User::where('email', $request->email)->first()]);
            }

            return $errors = array('success' => "false", 'User' => "Gebruiker bestaat niet");
        }
    }


}
