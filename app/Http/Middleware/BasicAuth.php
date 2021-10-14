//BasicAuth.php file is created:
<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuth {
	/**
	* Handle an incoming request.
	*
	* @param  \Illuminate\Http\Request  $request
	* @param  \Closure  $next
	* @return mixed
	*/
	public function handle($request, Closure $next) {
		return $next($request);
	}

    //Replace handle function:
public function handle($request, Closure $next) {
	//The following line(s) will be specific to your project, and depend on whatever you need as an authentication.
  	$isAuthenticatedAdmin = (Auth::check() && Auth::user()->admin == 1);
  
  	//This will be excecuted if the new authentication fails.
	if (! $isAuthenticatedAdmin)
		return redirect('/login')->with('message', 'Authentication Error.');
	return $next($request);
}

//In app/Http/Kernel.php, add this line:
protected $routeMiddleware = [
	/*
	* All the laravel-defined authentication methods
	*/
  'adminAuth' => \App\Http\Middleware\AdminAuth::class //Registering New Middleware
];

}

//In routes/web.php, add this at the end of the desired routes:
Route::get('/adminsite', function () {
	return view('adminsite');
})->middleware('adminAuth'); //This line makes the route use your new authentication middleware.