<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AutenticacionRol {

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::has('rol actual'))
        {
            if (Session::get('rol actual') == "administrador investigativo")
            {
                if (Session::get('administrador investigativo') == "activo")
                {
                    if ($request->ajax())
                    {
                        return response('Unauthorized.', 401);
                    }
                    else
                    {
                        return redirect('/adminv');
                    }
                }
            }
            else if (Session::get('rol actual') == "investigador")
            {
                if (Session::get('investigador') == "activo")
                {
                    if ($request->ajax())
                    {
                        return response('Unauthorized.', 401);
                    }
                    else
                    {
                        return redirect('/inv');
                    }
                }
            }
            else if (Session::get('rol actual') == "evaluador")
            {
                if (Session::get('evaluador') == "activo")
                {
                    if ($request->ajax())
                    {
                        return response('Unauthorized.', 401);
                    }
                    else
                    {
                        return redirect('/eval');
                    }
                }
            }
        }
        return $next($request);
    }

}