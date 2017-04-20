<?php namespace App\Http\Middleware;

use Closure;
use Auth;
use Redirect;
use Session;
class Admin {
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
			return redirect('admin/login');	
		}else if($user->role_id != 1)
		{
			Auth::logout();
        	Session::flush();
			return redirect('admin/login');	
		}

		return $next($request);

	}



}

