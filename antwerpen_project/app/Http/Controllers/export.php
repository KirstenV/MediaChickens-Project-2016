<?php namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Excel;
use App\Projecten;
class export extends Controller
{
    public function get_export (){
       $export= Excel::create('Laravel Excel', function($excel) {
            $excel->sheet('Excel sheet', function ($sheet) {
                $sheet->setOrientation(Projecten::all());
            });
        })->export('csv');

        return print_r($export);
    }
}
