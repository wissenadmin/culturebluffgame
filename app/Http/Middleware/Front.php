<?php namespace App\Http\Middleware;

use Closure;
use Auth;
use Redirect;
use Session;

class Front {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$user = Auth::user();
		if(empty($user)){
			return redirect('login');	
		}else if($user->role_id != 2)
		{
			Auth::logout();
        	Session::flush();
        	return redirect('login');	
		}
		return $next($request);
	}

}
