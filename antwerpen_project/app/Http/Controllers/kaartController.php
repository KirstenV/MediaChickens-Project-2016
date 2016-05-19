<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Projecten;
use App\Locatie;
use App\Locatie_projecten;
use App\Http\Requests;
use App\Project_foto;

class kaartController extends Controller
{

    public function json_projects($id)
    {

        //projecten ->many to many relationship locatie
        $locaties = Locatie::find($id)->show_projects_of_location;

        return $locaties;

    }


    public function json_locations($id)
    {

        if (Projecten::find($id)) {
            $project_information = array('project' => Projecten::find($id));
            if (Projecten::find($id)->show_locaties) {
                $project_information = array_add($project_information, 'locaties', Projecten::find($id)->show_locaties);
                if (Projecten::find($id)->show_fotos) {
                    $project_information = array_add($project_information, 'image', Projecten::find($id)->show_fotos);
                }

                return $project_information;

            }


        }
        return array('error' => "locatie zijn niet terug gevonden");


        //projecten ->many to many relationship locatie


    }
}
