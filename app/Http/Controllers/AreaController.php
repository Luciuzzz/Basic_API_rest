<?php

namespace App\Http\Controllers;

use App\Models\Area;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Area::all());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'required|string|max:255',
        ]);

        $area = Area::create($data);

        return response()->json([
            'message' => 'Area creada correctamente',
            'data' => $area,
        ], 201);
    }

    public function show(Area $area): JsonResponse
    {
        return response()->json($area);
    }

    public function update(Request $request, Area $area): JsonResponse
    {
        $data = $request->validate([
            'nombre' => 'sometimes|required|string|max:100',
            'descripcion' => 'sometimes|required|string|max:255',
        ]);

        $area->update($data);

        return response()->json($area);
    }

    public function destroy(Area $area): JsonResponse
    {
        try {
            $area->delete();
        } catch (QueryException) {
            return response()->json([
                'message' => 'No se puede eliminar el area porque esta relacionada con una tesis',
            ], 409);
        }

        return response()->json([
            'message' => 'Area eliminada correctamente',
        ]);
    }
}
