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

//location routs
Route::get('kaart/{id}/api/get_locations', 'kaartController@json_projects');
Route::post('/locatie/toevoegen/{id}/api','projectController@add_location');
Route::get('locaties/{id}/edit/api', 'projectController@json_locaties');

Route::get('kaart/api/get_locations', 'kaartController@json_locations');


Route::put('{tabel}/api/add_dependency', 'projectController@add_project_dependency');
Route::put('Project_foto/add_foto/api', 'projectController@add_foto');

Route::get('javascript_main',function(){
	return view('javascript');
});

Route::get('al_projects/api/get', 'PagesController@json_al_projects');
Route::post('upload_form','projectController@upload_form');



Route::get('login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
//Route::get('auth/logout', 'Auth\AuthController@getLogout');
Route::get('auth/logout', 'Auth\AuthController@logout');

// Registration routes...
Route::get('auth/register', 'Auth\AuthController@getRegister');
Route::post('auth/register', 'Auth\AuthController@postRegister');



//voor unity json objecten
//Route::get('unity/vragen/{id}/api', 'unityController@get_vragen_by_id');
Route::get('unity/vragen/{id}/{gebreuker}/api', 'unityController@get_vragen_by_id');
Route::get('unity/al_projecten/api', 'unityController@get_projects');







//ingeloogd test
Route::get('ingeloogd', function(){
	$user = Auth::user();
	return $user;
});


//get all cotente of project
Route::get('project/{id}/api', 'PagesController@get_al_info_from_project');



//fase

Route::get('fase/get_fase/{id}/api',"projectController@get_fase");
Route::post('fase/add_fase/api',"projectController@add_fase");
Route::post('Project_fase/update_fase_img/api',"projectController@post_fase_img");
Route::put('Project_fase/update_fase_img/api', 'projectController@update_fase_img');






//delete roots => project
Route::post('project/{id}/delete/api','projectController@delte_projeten');
//delete roots => edit page
Route::post('edit/{tabele}/{id}/delete/api','projectController@delte_edit_page');