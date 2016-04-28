<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Projecten;
use App\User;
use App\Fase;
Use App\Project_foto;
use App\Vragen;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use Intervention\Image\ImageManagerStatic as Image;


use App\Http\Requests;

class projectController extends Controller
{
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
        DB::table($table)->where('id', $id)->update(array($request->input('row_name') => $request->input('row_content')));
        $usser_updatet = Projecten::find($id);


        return $usser_updatet;
    }

    public  function  test(){
        DB::table(Fase)->where('id', 20)->update(array(titel => "SUCCES"));

        return "clarr";
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

    public function json_al_projects()
    {
        return response()->json(Projecten::all());
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

        /*
         *
         $return="";
        if($request->hasFile('project_photo')){
            $file = $request->file('project_photo');
            $return .= $file->getMimeType()."\t";
            $return .= $file->getExtension()."\t";
            $return .= $file->guessExtension()."\t";
            if($file->isValid()){
                $return .="isValid=true";
                //return $request->file('project_photo')->getClientOriginalName();
            }else{
                $return .="isValid=false";
            }
            //return $request->file('project_photo')->getClientOriginalName();
            return $return;
        }
        */
        /*
                $headers="";
                foreach (getallheaders() as $name => $value) {
                    $headers += "$name: $value\n";
                }
                return $headers;
                //return "<pre>".print_r($request->input(),true)."</pre>";
                //$file = Input::file('file');
                //return $file;
                //return $request;
                //return $input->all();
                //return $request->allFiles();
                //return "succes";
        */


        $image = Input::file('project_photo');

        //$validator = Validator::make([$image], ['image' => 'required|image|mimes:gif,jpg,jpeg,bmp,png']);
        $validator = Validator::make([$image], ['mimes:gif,jpg,jpeg,bmp,png', 'image.required']);
        //$validator = Validator::make([$image], ['project_photo','required']);
        //$validator->errors();
        //return var_dump($validator->errors());

        if ($validator->fails()) {
            return response()->json(['error' => 'bestan moet een extensie :gif,jpg,jpeg,bmp,png hebben '], 200);
            //return $validator->errors();
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
    /*
    public  function resize_img($from, $to,$width,$higth){
        $img = Image::make($from);
// now you are able to resize the instance
        $img->resize($width, $higth);
// finally we save the image as a new file
        $img->save($to);
        return "susses";
    }*/


    // deltenig apis

    public function delte_projeten($id)
    {
        //$project = Projecten::find($id);
        //$project->destroy();
        $project = Projecten::find($id);
        $project->delete();
        //$deleted_item = Projecten::withTrashed()->where('id', $id)->get();
        return $project;


    }


    public function add_fase(Request $request  )
    {

        $fase = new Fase;
        $fase->titel = "Voer hier titel in van de fase";
        $fase->beschrijving = "Voer hier je vraag in van de fase";
        $fase->fases = "welke fase ";
        $fase->fases_picture = "fases_picture_default.jpg";
        $fase->projecten_id = $request->project_id;
        $fase->save();

        $latste_fase = Projecten::find($request->project_id)->show_fases->last();
        return $latste_fase;

    }

    public function get_fase($project_id){
        $all_fases = Projecten::find($project_id)->show_fases;
        return $all_fases;
    }

}