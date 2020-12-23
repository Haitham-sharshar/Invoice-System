<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Local
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if(config('locale.status')){
            $config = config('locale.languages');
            if (Session::has('locale') && array_key_exists(Session::get('locale'),$config)){
                App::setLocale(Session::get('local'));
            }else{
                $userlanguage = preg_split('/[,;]/', $request->server('HTTP_ACCEPT_LANGUAGES'));
                foreach ($userlanguage as $language){
                    if (array_key_exists($language , config('locale.languages'))){
                        App::setLocale($language);
                        setlocale(LC_TIME,config('locale.languges')[$language][2]);
                        Carbon::setLocale(config('locale.languages')[$language][0]);
                        if(config('locale.languages')[$language][2]){
                            \Session(['lang-rtl'=>true]);
                        }else{
                            Session::forget('lang-rtl');
                        }
                        break;
                    }
                }
            }

        }
        return $next($request);
    }
}
