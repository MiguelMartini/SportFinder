<?php

namespace App\Http\Middleware;

use App\Models\Usuario;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $usuario = $request->user(); // usuário autenticado via Sanctum

    if (!$usuario || $usuario->perfil != 1) {
        return response()->json(['message' => 'Acesso negado, somente administradores'], 403);
    }

    return $next($request);
    }
}
