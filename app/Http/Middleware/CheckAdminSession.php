<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminSession
{
    public function handle(Request $request, Closure $next): Response
    {
        $adminId = $request->session()->get('admin_id');

        if (!$adminId || !Admin::where('id', $adminId)->exists()) {
            return response()->json('Sesion no iniciada', 401);
        }

        return $next($request);
    }
}
