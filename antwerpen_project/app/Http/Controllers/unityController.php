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

class unityController extends Controller
{
    public function get_projects()
    {
        return response()->json(Projecten::all());
    }

    public function get_vragen_by_id($id, $user)
    {
        if ($user) {

        }
        return $fases = Projecten::find($id)->show_vragen;
    }

    public function login_unity(Request $request)
    {
        $errors = array('success' => "false");

        $userData = array(
            'email'=>$request["email"],
            'password'=>$request["password"],
        );
        $rules =array(
            'email'=>'required|email',
            'password'=>'required|min:6',
        );

        $validator = Validator::make($userData,$rules);
        if($validator->fails()) {
            return response()->json(array(
                'success' => false, 'errors' => $validator->getMessageBag()->toArray(),
            ));
        }else {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                // Authentication passed...
                return response()->json(['success' => true, 'User' =>User::where('email', $request->email) -> first()]);
            }

            return $errors = array('success' => "false",'User'=>"Gebruiker bestaat niet");
        }
    }


}


/*
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

class unityController extends Controller
{
    public function get_projects()
    {
        return response()->json(Projecten::all());
    }

    public function get_vragen_by_id($id, $user)
    {
        if ($user) {

        }
        return $fases = Projecten::find($id)->show_vragen;
    }

    public function login_unity(Request $request)
    {
        $errors = array('success' => "false");

        $input = array(
            'email' => $request->email,
            'password' => $request->password,
        );

        $rules = array(
            'email' => 'required|email',
            'password' => 'required'
        );

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            if (Request::ajax()) {
                return response()->json(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);
            } else {
                return Redirect::back()->withInput()->withErrors($validator);
            }

        } else {
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                    // Authentication passed...
                    return response()->json(['success' => true, 'User' =>User::where('email', $request->email) -> first()]);
                }

            return $errors = array('success' => "false",'User'=>"Gebruiker bestaat niet");
        }
    }


}*/
