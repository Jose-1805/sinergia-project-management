<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AutenticacionAdminv {

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct() {
        
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (Session::has('administrador investigativo')) {
            if (Session::get('administrador investigativo') == 'activo') {
                return $next($request);
            }
        }

        if ($request->ajax()) {
            return response('Unauthorized.', 401);
        } else {
            return redirect('/');
        }
    }

    public static function check(){
        if (Session::has('administrador investigativo')) {
            if (Session::get('administrador investigativo') == 'activo') {
                return true;
            }
        }
        return false;
    }
}
