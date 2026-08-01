<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user() instanceof Admin) {
            return response()->json([
                'message' => 'غير مصرح لك بالوصول لهذا القسم.'
            ], 403);
        }

        return $next($request);
    }
}