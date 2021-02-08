<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AutNotificacion {

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
        if(Session::has("idPersona")){
            if ($request->ajax())
            {
                return $next($request);
            }
            else
            {
                return redirect('/');
            }
        }else{
            return response('Unauthorized.', 401);
        }


	}

}
