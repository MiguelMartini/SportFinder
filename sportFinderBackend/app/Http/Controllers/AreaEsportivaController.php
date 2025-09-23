<?php

namespace App\Http\Controllers;

use App\Models\AreaEsportiva;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AreaEsportivaController extends Controller
{
    public function index()
    {
        $areasEsportivas = AreaEsportiva::all();

        return response()->json($areasEsportivas, 200);
    }

    public function show(string $id)
    {
        try {
            $areasEsportivas = AreaEsportiva::findOrFail($id);
            return response()->json($areasEsportivas);
        } catch (\Exception $ex) {
            return response()->json([
                'message' => 'Erro ao buscar área esportiva'
            ], 404);
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'id_administrador' => 'required|exists:usuarios,id',
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'endereco' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'cep' => 'required|string|max:20',
            'nota' => 'nullable|numeric|min:0|max:5',
        ]);

        $area = AreaEsportiva::create($request->all());

        return response()->json($area, 201);
    }

    public function update(Request $request, $id){
        try{
            $areasEsportivas = AreaEsportiva::findOrFail($id);
        }catch(ModelNotFoundException $e){
            return response()->json(['message' => 'Área esportiva não encontrada'], 404);
        }

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'endereco' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'cep' => 'required|string|max:20',
            'nota' => 'nullable|numeric|min:0|max:5',
        ]);

        $areasEsportivas->update($request->only(
            ['titulo', 'descricao','endereco','cidade','cep', 'nota']
        ));

        return response()->json($areasEsportivas, 200);
    }
}
