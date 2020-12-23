<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Mockery\CountValidator\Exception;

class GenralController extends Controller
{
    public function changelanguages($locale){
        try{

               if(array_key_exists($locale , config('locale.languages'))){
                   Session::put('locale',$locale);
                   App::setLocale($locale);
                   return redirect()->back();
               }
        }catch (\Exception $execption){
            return redirect()->back();
        }
    }
}
