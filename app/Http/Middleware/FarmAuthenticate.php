<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Farm;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FarmAuthenticate
{
    private function checkFarmId(Request $request)
    {
        $farm_id = $request->route()->parameters['farm']->id;
        $farm = Farm::find($farm_id);
        $farm_user = $farm->user_id;

        if ($farm_user === Auth::user()->id) {
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!$this->checkFarmId($request)) {
            abort(403);
        }
        else {
            return $next($request);
        }
        
    }


}
