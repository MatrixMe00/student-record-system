<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public static function file_data(string $inputname, bool $remove_head = false, int $head_rows = 1) :Collection|false{
        if(request()->file($inputname)){
            $data = Excel::toCollection([], request()->file($inputname))[0];

            // if it should split head
            if($remove_head){
                $data->splice(0, $head_rows);
            }

            return $data;
        }

        return false;
    }
}
