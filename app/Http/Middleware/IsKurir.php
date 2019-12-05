<?php

namespace App\Http\Middleware;

use Closure;
use App\role as role;
use App\user as user;
use Illuminate\Support\Facades\Auth;
class IsKurir
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
      $autentikasi = user::join('roles','roles.kd_level','=','users.kd_level')->find(Auth::id());
      if (strtoupper($autentikasi->level) == 'KURIR') {
        return $next($request);
      }
          return abort(404); // If user is not an admin.
    }


}
