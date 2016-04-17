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
Route::get('project_toevoegen', 'projectController@project_toevoegen');
Route::get('project_toevoegen/add', 'projectController@add_project');
