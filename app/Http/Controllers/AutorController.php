<?php

namespace App\Http\Controllers;

use App\Models\Autor;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AutorController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Autor::all());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:autores,email',
            'telefono' => 'required|string|max:20',
        ]);

        $autor = Autor::create($data);

        return response()->json([
            'message' => 'Autor creado correctamente',
            'data' => $autor,
        ], 201);
    }

    public function show(Autor $autor): JsonResponse
    {
        return response()->json($autor);
    }

    public function update(Request $request, Autor $autor): JsonResponse
    {
        $data = $request->validate([
            'nombre' => 'sometimes|required|string|max:100',
            'apellido' => 'sometimes|required|string|max:100',
            'email' => [
                'sometimes',
                'required',
                'email',
                'max:150',
                Rule::unique('autores', 'email')->ignore($autor->id_autor, 'id_autor'),
            ],
            'telefono' => 'sometimes|required|string|max:20',
        ]);

        $autor->update($data);

        return response()->json($autor);
    }

    public function destroy(Autor $autor): JsonResponse
    {
        try {
            $autor->delete();
        } catch (QueryException) {
            return response()->json([
                'message' => 'No se puede eliminar el autor porque esta relacionado con una tesis',
            ], 409);
        }

        return response()->json([
            'message' => 'Autor eliminado correctamente',
        ]);
    }
}
