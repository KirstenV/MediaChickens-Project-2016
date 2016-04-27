<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
/*
Route::get('/', function () {
	$peopel =['anton','artem','Lesha'];
    return view('welcome',compact('peopel'));
	 //return view('welcome')->with('peopel', $person);
});
*/

Route::get('about', 'PagesController@about');

Route::get('/', 'PagesController@home');

Route::post('projecten/add', 'projectController@project_toevoegen');

Route::get('project/{id}/view', 'projectController@show_project');

Route::get('project/{id}/edit', 'projectController@edit_project');

Route::get('project/{id}/edit/api', 'projectController@json_project');

Route::put('{tabel}/{id}', 'projectController@update_record');

Route::get('fotos/{id}/edit/api', 'projectController@json_fotos');

Route::get('vragen/{id}/edit/api', 'projectController@json_vragen');

Route::put('{tabel}/api/add', 'projectController@add_project');


Route::get('kaart/{id}/api/get_locations', 'kaartController@json_projects');

Route::get('kaart/api/get_locations', 'kaartController@json_locations');


Route::put('{tabel}/api/add_dependency', 'projectController@add_project_dependency');


Route::get('javascript_main',function(){
	return view('javascript');
});

Route::get('al_projects/api/get', 'projectController@json_al_projects');
Route::post('upload_form','projectController@upload_form');

