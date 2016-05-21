<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Projecten;
use App\User;
use App\Fase;
Use App\Project_foto;
use App\Vragen;
use App\Locatie;
use App\Locatie_projecten;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use Intervention\Image\ImageManagerStatic as Image;


use App\Http\Requests;

class projectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
//		if(Auth::check){
//			if(!Auth::is_adm && \Request::route()->getName() == '/'){
//				return redirect()->route('login');
//			}
//		}

    }

    public function project_toevoegen(Request $request)
    {

        $project = new Projecten;
        $project->titel = $request->titel;
        $project->beschrijving = "klick op mij en pas mij aan voor de beschrijving";
        $project->project_picture = "proef_proef.jpg";
        $project->user_id = $request->admin;
        $project->save();
        return back();
    }

    public function show_project($id)
    {
        $project_data = Projecten::find($id);

        return view('show_project')->with('project_data', $project_data);
    }

    public function edit_project($id)
    {

        return view('edit_project')->with('id', $id);
        //return $project_data;
    }

    public function json_project($id)
    {
        $project_data = Projecten::find($id);
        //return view('edit_project')->with('project_data',$project_data);
        return $project_data;
    }

    //uneversel controller can adite diferend tabels and id
    public function update_record($table, $id, Request $request)
    {
        $project_information = array('$table' => $table);
        $project_information = array('rij_naam' => $request->rij_naam);
        $project_information = array_add($project_information, 'id', $id);

        switch ($request->rij_naam) {
            case "titel":
                $validator = Validator::make($request->all(), [
                    'invul_veld' => 'required|max:250',
                ]);
                break;
            case "beschrijving":
                $validator = Validator::make($request->all(), [
                    'invul_veld' => 'required|max:5000',
                ]);
                break;

            case "begin_datum":

                $validator = Validator::make($request->all(), [
                    'invul_veld' => 'date_format:Y-m-d',
                ]);
                break;
            case "eind_datum":
                $validator = Validator::make($request->all(), [
                    'invul_veld' => 'date_format:Y-m-d',
                ]);
                break;
            case "vraag":
                $validator = Validator::make($request->all(), [
                    'invul_veld' => 'required|max:1000',
                ]);
                break;
            case "mogelijke_antwoorden_1" :
                $validator = Validator::make($request->all(), [
                    'invul_veld' => 'required|max:1000',
                ]);
                break;
            case "mogelijke_antwoorden_2" :
                $validator = Validator::make($request->all(), [
                    'invul_veld' => 'required|max:1000',
                ]);
                break;
            case "mogelijke_antwoorden_3" :
                $validator = Validator::make($request->all(), [
                    'invul_veld' => 'required|max:1000',
                ]);
                break;
            case "mogelijke_antwoorden_4" :
                $validator = Validator::make($request->all(), [
                    'invul_veld' => 'required|max:1000',
                ]);
                break;
            case "fase_titel" :
                $validator = Validator::make($request->all(), [
                    'invul_veld' => 'required|max:250',
                ]);
                break;
            case "fase_beschrijving" :
                $validator = Validator::make($request->all(), [
                    'invul_veld' => 'required|max:500',
                ]);
                break;
            case "fases_picture" :
                $validator = Validator::make($request->all(), [
                    'invul_veld' => 'required|max:250',
                ]);

                break;

            default:
                $validator = Validator::make($request->all(), [
                    'invul_veld' => 'required|max: 250',
                ]);
        }


        if ($validator->fails()) {
            $project_information = array_add($project_information, '$errors', $validator->errors());
            return $project_information;
        }

        DB::table($table)->where('id', $id)->update(array($request->input('rij_naam') => $request->input('invul_veld')));
        if($request->rij_naam=='fases_picture'){
            $project_information = array_add($project_information, 'fases_picture', Fase::find($id)->fases_picture);
        }

        $usser_updatet = Projecten::find($id);

        $project_information = array_add($project_information, '$succes', "alles s opgeslagen");

        return $project_information;
    }

    public function json_fotos($id)
    {
        $fotos = Projecten::find($id)->show_fotos;
        //return view('edit_project')->with('project_data',$project_data);
        return $fotos;
    }

    public function add_foto(Request $request)
    {
        $foto = new Project_foto;
        $foto->project_picture = $request->row_content;
        $foto->projecten_id = $request->project_id;
        $foto->save();

        $foto = Projecten::find($request->project_id)->show_fotos->last();
        return $foto;

    }

    public function json_vragen($id)
    {
        $project_vragen = Projecten::find($id)->show_vragen;
        //return view('edit_project')->with('project_data',$project_data);
        return $project_vragen;
    }

    public function add_project($tabel, Request $request)
    {


        $project = new Projecten;
        $project->titel = $request->row_content;
        $project->begin_datum = "niet ingevuld";
        $project->eind_datum = "niet ingevuld";
        $project->beschrijving = "klick op mij en pas mij aan voor de beschrijving";
        $project->project_picture = "proef_proef.jpg";
        $project->user_id = $request->admin;
        $project->save();

        //Projecten::create(array('titel'=>'proef','beschrijving'=>"broef proef",'project_picture'=>'proef.jpg','project_picture'=>1));

        return User::find($request->admin)->show_projecten->last();
    }


    public function add_project_dependency($tabel, Request $request)
    {
        if ($tabel == "Vragen") {
            $question = new Vragen;
            $question->choices = $request->question_type;
            $question->vraag = "Voer hier je vraag in";
            $question->mogelijke_antwoorden_1 = "geef hier mogelijke aantwoord";
            $question->mogelijke_antwoorden_2 = "geef hier mogelijke aantwoord";
            $question->mogelijke_antwoorden_3 = "geef hier mogelijke aantwoord";
            $question->mogelijke_antwoorden_4 = "geef hier mogelijke aantwoord";
            $question->projecten_id = $request->project_id;
            $question->save();

            $latste_vraag = Projecten::find($request->project_id)->show_vragen->last();


            return $latste_vraag;
        } else {
            return "Er is iets mis gegaan";
        }
    }

    public function upload_form(Request $request)
    {
        $image = Input::file('project_photo');

        $validator = Validator::make([$image], ['mimes:gif,jpg,jpeg,bmp,png', 'image.required']);

        if ($validator->fails()) {
            return response()->json(['error' => 'bestan moet een extensie :gif,jpg,jpeg,bmp,png hebben '], 200);
        }
        $destinationPath = 'img/original';


        if (!$image->move($destinationPath, $image->getClientOriginalName())) {

            return $validator->errors(['message' => 'Error saving the file.', 'code' => 400]);
        }

        $image_name = $image->getClientOriginalName();
        $img_url = $destinationPath . "/" . $image_name;


        $img = Image::make($img_url);
// now you are able to resize the instance
        $img->resize(1024, 768);
// finally we save the image as a new file
        $img->save('img/project/' . $image_name);


        $img = Image::make($img_url);
// now you are able to resize the instance

        $img->resize(400, 300, function ($constraint) {
            $constraint->upsize();
        });
// finally we save the image as a new file
        $img->save('img/project/small_' . $image_name);

        return response()->json(['success' => true, 'src_image' => $image->getClientOriginalName()], 200);
        //
    }


    // delete api

    public function delte_projeten($id)
    {
        //$project = Projecten::find($id);
        //$project->destroy();
        $massege = "error";
        $project = Projecten::find($id);
        $project->delete();
        //$deleted_item = Projecten::withTrashed()->where('id', $id)->get();
        $massege = "succes";
        return $massege;


    }

    public function delte_edit_page($tabele, $id)
    {
        $massege = "error";
        if ($tabele == 'foto') {
            $project = Project_foto::find($id);
            $project->delete();
            $massege = " foto is succes vol verwijderd";
        }

        if ($tabele == 'vragen') {
            $project = Vragen::find($id);
            $project->delete();
            $massege = " vraag is succes vol verwijderd";
        }

        if ($tabele == 'fases') {
            $project = Fase::find($id);
            $project->delete();
            $massege = " fase is succes vol verwijderd";
        }
        if($tabele == "locations"){
            $project = Locatie::find($id);
            $project->delete();
            $massege = " fase is succes vol verwijderd";
        }

        //$deleted_item = Projecten::withTrashed()->where('id', $id)->get();
        return $massege;
    }


    //get fase update post fase
    public function add_fase(Request $request)
    {

        $fase = new Fase;
        $fase->fase_titel = "Voer hier titel in van de fase";
        $fase->fase_beschrijving = "Voer hier je vraag in van de fase";
        $fase->fases = "open fase";
        $fase->fases_picture = "fases_picture_default.jpg";
        $fase->projecten_id = $request->project_id;
        $fase->save();

        $latste_fase = Projecten::find($request->project_id)->show_fases->last();
        return $latste_fase;

    }

    public function get_fase($project_id)
    {
        $all_fases = Projecten::find($project_id)->show_fases;
        return $all_fases;
    }

    public function update_fase_img(Request $request)
    {

    }

    public function post_fase_img(Request $request)
    {

        $image = Input::file('fase_photo');

        $validator = Validator::make([$image], ['mimes:gif,jpg,jpeg,bmp,png', 'image.required']);

        if ($validator->fails()) {
            return response()->json(['error' => 'bestan moet een extensie :gif,jpg,jpeg,bmp,png hebben '], 200);
        }
        $destinationPath = 'img/original';


        if (!$image->move($destinationPath, $image->getClientOriginalName())) {

            return $validator->errors(['message' => 'Error saving the file.', 'code' => 400]);
        }

        $image_name = $image->getClientOriginalName();
        $img_url = $destinationPath . "/" . $image_name;


        $img = Image::make($img_url);
// now you are able to resize the instance
        $img->resize(400, 300);
// finally we save the image as a new file
        $img->save('img/fase/' . $image_name);


        return response()->json(['success' => true, 'src_image' => $image->getClientOriginalName()], 200);

    }

    //add nieuw location wor project
    public function add_location($project_id, Request $request)
    {
        $project_information = array('$table' => "locaties");

        $validator = Validator::make($request->all(), [
            'address' => 'required|max: 1000',
            'lat' => 'required|max: 250',
            'lng' => 'required|max: 250',
        ]);
        if(!$project_id){
            $project_information = array_add($project_information, '$errors',"Oeps, er ging iets fout! Refresh je pagina!");
            return $project_information;
        }


        if ($validator->fails()) {
            $project_information = array_add($project_information, '$errors', $validator->errors());
            return $project_information;
        }


        $locatie = new Locatie;
        $locatie->straat_naam = $request->address;
        //$locatie->poscode = "klick op mij en pas mij aan voor de beschrijving";
        //$locatie->huisnummer = "proef_proef.jpg";
        $locatie->position_latitude = $request->lat;
        $locatie->position_longitude = $request->lng;
        $locatie->save();

        $bridge_locatie_project = new Locatie_projecten;
        $bridge_locatie_project->projecten_id = $project_id;
        $bridge_locatie_project->locatie_id = $locatie->id;
        $bridge_locatie_project->save();
        $project_information = array_add($project_information, '$succes',"alles is opgeslagen" );
        $project_information = array_add($project_information, '$location',$locatie );

        return  $project_information;
    }

    public function json_locaties($project_id){
        $locaties = Projecten::find($project_id)->show_locaties;
        return $locaties;
    }

    public  function get_user_json(){

        $users = DB::table('users')->select('name');
        $is_adm = $users->addSelect('is_adm','id','email')->get();

        if(!$is_adm){
            return  array('$error' => "Fout met her server");
        }
        return $is_adm;
    }

    public function manag_users(Request $request){
        if($request->action === "delete"){
            $project = User::find($request->id);
            $project->delete();
            $massege =  array('succes' =>true, "delete"=>true);
            return $massege;
        }else{
            $id = $request->id;
            if($request->action == "0"){
                DB::table('users')->where('id', $id)->update(array('is_adm' => "1"));
                $users = DB::table('users')->select('name')->where('id',$id);
                $is_adm = $users->addSelect('is_adm','id','email')->get();

                return array('succes' => true,"id"=>$id,"is_adm"=> '1',"update"=>true,"user"=>$is_adm);
            }
            if($request->action == "1"){
                $users = DB::table('users')->select('name')->where('id',$id);
                $is_adm = $users->addSelect('is_adm','id','email')->get();
                DB::table('users')->where('id', $id)->update(array('is_adm' => "0"));
                return array('succes' => true,"id"=>$id,"is_adm"=> '0',"update"=>true,"user"=>$is_adm);
            }

        }
        return array('$error' => "Fout met her server");
    }

}