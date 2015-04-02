<?php namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\Repositories\PermissionRepository as Permission;

class AuthorizeMiddleware {

	public function __construct(Guard $auth, Permission $permission)
	{
		$this->auth = $auth;
		$this->permission = $permission;
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
		$user = $this->auth->user();

		$permissions = $this->permission->all();

		$uri = $request->route()->uri();

		foreach($permissions as $permission)
		{
			$exploded_perms = explode('_', $permission->name); // manage_(users), manage_(roles), manage_(permissions)
			if( ! $user->can($permission->name) && $exploded_perms[1] == $uri)
			{
				abort(403);
			}
		}

		return $next($request);
	}

}
