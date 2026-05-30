<?php

namespace App\Http\Controllers;

use App\Models\Tesis;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TesisController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Tesis::with(['autor', 'area', 'carrera'])->get());
    }

    public function search(Request $request): JsonResponse
    {
        $data = $request->validate([
            'search' => 'nullable|string|max:255',
            'id_area' => 'nullable|integer|exists:areas,id_area',
            'id_carrera' => 'nullable|integer|exists:carreras,id_carrera',
        ], $this->validationMessages());

        $query = Tesis::with(['autor', 'area', 'carrera']);

        if (!empty($data['search'])) {
            $search = $data['search'];

            $query->where(function ($q) use ($search) {
                $q->where('titulo', 'like', "%{$search}%")
                    ->orWhere('descripcion', 'like', "%{$search}%")
                    ->orWhereHas('autor', function ($autorQuery) use ($search) {
                        $autorQuery->where('nombre', 'like', "%{$search}%")
                            ->orWhere('apellido', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        if (!empty($data['id_area'])) {
            $query->where('id_area', $data['id_area']);
        }

        if (!empty($data['id_carrera'])) {
            $query->where('id_carrera', $data['id_carrera']);
        }

        return response()->json($query->get());
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'url_contenido' => 'required|string|max:500',
            'id_autor' => 'required|integer|exists:autores,id_autor',
            'id_area' => 'required|integer|exists:areas,id_area',
            'id_carrera' => 'required|integer|exists:carreras,id_carrera',
        ], $this->validationMessages());

        $data['fecha_creacion'] = now()->toDateString();

        $tesis = Tesis::create($data);

        return response()->json([
            'message' => 'Tesis creada correctamente',
            'data' => $tesis->load(['autor', 'area', 'carrera']),
        ], 201);
    }

    public function show(Tesis $tesis): JsonResponse
    {
        return response()->json($tesis->load(['autor', 'area', 'carrera']));
    }

    public function update(Request $request, Tesis $tesis): JsonResponse
    {
        $data = $request->validate([
            'titulo' => 'sometimes|required|string|max:255',
            'descripcion' => 'sometimes|required|string',
            'url_contenido' => 'sometimes|required|string|max:500',
            'id_autor' => 'sometimes|required|integer|exists:autores,id_autor',
            'id_area' => 'sometimes|required|integer|exists:areas,id_area',
            'id_carrera' => 'sometimes|required|integer|exists:carreras,id_carrera',
        ], $this->validationMessages());

        $tesis->update($data);

        return response()->json($tesis->load(['autor', 'area', 'carrera']));
    }

    public function destroy(Tesis $tesis): JsonResponse
    {
        $tesis->delete();

        return response()->json([
            'message' => 'Tesis eliminada correctamente',
        ]);
    }
}
