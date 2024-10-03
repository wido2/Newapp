<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class nomorPO extends Controller
{
    public static function generate($input,  $pad_len = null, $pad_string = null, $prefix = null, $year = null)
    {
        $prefix = empty($prefix) ? config('nomorPO.prefix') : $prefix;
        $prefix = Str::upper($prefix);
        $pad_len =  empty($pad_len) ? config('nomorPO.pad_len') : $pad_len;
        $pad_len = intval(2);
        // check is year true from config
        if(config('nomorPO.year') == true){
            $year = empty($year) ? config('nomorPO.year_val') : $year;
            $year = intval($year);
        }else{
            $year = '';
        }

        $input = intval($input);
        $pad_direction =config('nomorPO.pad_direction');
        $pad_string = empty($pad_string) ? config('nomorPO.pad_string') : $pad_string;

        if ($pad_len <= strlen($input)) {
            trigger_error('<strong>$pad_len</strong> cannot be less than or equal to the length of <strong>$input</strong> to generate Unique number', E_USER_ERROR);
        }

        if (is_string($prefix)) {
            return sprintf("%s%s%s%s%s", $prefix,'/',$year, '/', str_pad($input, $pad_len, $pad_string,  $pad_direction));
        }

        return sprintf("%s%s%s%s", $year, '/', str_pad($input, $pad_len, $pad_string,  $pad_direction));
    }

}
