<?php namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Excel;
use App\Projecten;
use App\Reactie;
use App\Vragen;
use App\Antwoorden;
class export extends Controller
{
    public function get_export (){
       $export= Excel::create('Inspraak', function($excel) {
            $excel->sheet('Projecten', function ($sheet) {
                $sheet->fromArray(Projecten::all());
            });
           
           $excel->sheet('Reacties', function ($sheet) {
                $sheet->fromArray(Reactie::all());
            });
           
           $excel->sheet('Vragen', function ($sheet) {
                $sheet->fromArray(Vragen::all());
            });
           
           $excel->sheet('Antwoorden', function ($sheet) {
                $sheet->fromArray(Antwoorden::all());
            });
        })->export('xls');

        return print_r($export);
    }
}
