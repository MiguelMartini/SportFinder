<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();

        return response()->json($usuarios, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:usuarios,email',
            'senha' => 'required|string|min:6',
            'perfil' => 'required|integer',
            'documento' => 'nullable|string|max:50',
        ]);

        $usuario = Usuario::create([
            'nome' => $request->nome,
            'email' => $request->email,
            'senha' => Hash::make($request->senha),
            'perfil' => $request->perfil,
            'documento' => $request->documento,
        ]);

        return response()->json($usuario, 201);
    }

    public function show(string $id)
    {

        try {
            $usuario = Usuario::findOrFail($id);

            return response()->json($usuario, 200);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => 'Erro ao buscar usuário'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $usuario = Usuario::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Usuário não encontrado'], 404);
        }

        $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'email' => "sometimes|required|email|max:255|unique:usuarios,email,$id",
            'senha' => 'sometimes|required|string|min:6',
            'perfil' => 'sometimes|required|integer',
            'documento' => 'nullable|string|max:50',
        ]);

        if ($request->filled('senha')) {
            $request->merge(['senha' => Hash::make($request->senha)]);
        }

        $usuario->update($request->only(['nome', 'email', 'senha', 'perfil', 'documento']));

        return response()->json($usuario, 200);
    }

    public function destroy($id)
    {
        try {
            $usuario = Usuario::findOrFail($id);
            $usuario->delete();
            return response()->json(['message' => 'Usuário removido com sucesso!'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Usuário não encontrado'], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao deletar usuário', 'detalhes' => $e->getMessage()], 500);
        }
    }

public function login(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'senha' => 'required|string',
    ]);

    $usuario = Usuario::where('email', $request->email)->first();

    if (! $usuario || ! Hash::check($request->senha, $usuario->senha)) {
        throw ValidationException::withMessages([
            'email' => ['As credenciais estão incorretas.'],
        ]);
    }

    $token = $usuario->createToken('api-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'usuario' => $usuario
    ]);
}

}
