<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Carrera::all());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:150',
            'facultad' => 'required|string|max:150',
            'duracion_semestres' => 'required|integer|min:1',
        ], $this->validationMessages());

        $carrera = Carrera::create($data);

        return response()->json([
            'message' => 'Carrera creada correctamente',
            'data' => $carrera,
        ], 201);
    }

    public function show(Carrera $carrera): JsonResponse
    {
        return response()->json($carrera);
    }

    public function update(Request $request, Carrera $carrera): JsonResponse
    {
        $data = $request->validate([
            'nombre' => 'sometimes|required|string|max:150',
            'facultad' => 'sometimes|required|string|max:150',
            'duracion_semestres' => 'sometimes|required|integer|min:1',
        ], $this->validationMessages());

        $carrera->update($data);

        return response()->json($carrera);
    }

    public function destroy(Carrera $carrera): JsonResponse
    {
        try {
            $carrera->delete();
        } catch (QueryException) {
            return response()->json([
                'message' => 'No se puede eliminar la carrera porque esta relacionada con una tesis',
            ], 409);
        }

        return response()->json([
            'message' => 'Carrera eliminada correctamente',
        ]);
    }
}
