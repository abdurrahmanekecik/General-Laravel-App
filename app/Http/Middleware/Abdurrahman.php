<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Symfony\Component\HttpFoundation\Response;

class Abdurrahman
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $parts = explode('/', $request->path());
        if ($parts[0] == 'customers') {
            Alert::success('Success Title', 'Başarıyla sayfayı gördünüz.');
            return $next($request);
        }
        else{
            return $next($request);

        }


    }
}
