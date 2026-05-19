<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function index()
    {
        return response()->json(Admin::all());
    }

    public function login(Request $request): JsonResponse
    {
        $data = $request->only([
            'user_admin',
            'pass_admin',
        ]);

        $data['user_admin'] = $data['user_admin'] ?? null;
        $data['pass_admin'] = $data['pass_admin'] ?? null;

        if (!$data['user_admin']) return response()->json('User es obligatorio', 422);

        if (!$data['pass_admin']) return response()->json('Password es obligatorio', 422);

        $admin = Admin::where('user_admin', (string) $data['user_admin'])->first();

        if (!$admin || !Hash::check((string) $data['pass_admin'], $admin->pass_admin)) {
            return response()->json('Credenciales incorrectas', 401);
        }

        $request->session()->regenerate();
        $request->session()->put([
            'admin_id' => $admin->id,
            'admin_user' => $admin->user_admin,
        ]);

        return response()->json([
            'message' => 'Inicio de sesion correcto',
            'data' => $admin,
            'session_id' => $request->session()->getId(),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json('Sesion cerrada correctamente');
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->only([
            'user_admin',
            'pass_admin',
            'tel_admin',
            'ci_admin',
        ]);

        $data['user_admin'] = $data['user_admin'] ?? null;
        $data['pass_admin'] = $data['pass_admin'] ?? null;
        $data['tel_admin'] = $data['tel_admin'] ?? null;
        $data['ci_admin'] = $data['ci_admin'] ?? null;

        if (!$data['user_admin']) return response()->json('User es obligatorio', 422);

        if (!$data['pass_admin']) return response()->json('Password es obligatorio', 422);

        if (strlen($data['pass_admin']) < 8) return response()->json('Password debe tener al menos 8 caracteres', 422);

        if (!$data['tel_admin']) return response()->json('Telefono es obligatorio', 422);

        if (!$data['ci_admin']) return response()->json('CI es obligatorio', 422);

        // if (Admin::where('ci_admin', (string) $data['ci_admin'])->exists()) return response()->json('CI ya registrado', 422);

        $data['user_admin'] = (string) $data['user_admin'];
        $data['pass_admin'] = Hash::make((string) $data['pass_admin']);
        $data['tel_admin'] = (string) $data['tel_admin'];
        $data['ci_admin'] = (string) $data['ci_admin'];



        Log::warning('Admin creado', [
            'ci_admin' => $data['ci_admin'],
        ]);

        $admin = Admin::create($data);

        return response()->json([
            'message' => 'Admin creado correctamente',
            'data' => $admin,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        return response()->json($admin);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $data = $request->validate([
            'user_admin' => 'sometimes|required|string|max:255',
            'pass_admin' => 'sometimes|required|string|min:8',
            'tel_admin' => 'sometimes|required|string|max:20',
            'ci_admin' => 'sometimes|required|string|max:50|unique:admins,ci_admin,' . $admin->id,
        ]);

        if (isset($data['pass_admin'])) {
            $data['pass_admin'] = Hash::make($data['pass_admin']);
        }

        $admin->update($data);

        return response()->json($admin);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);

        $admin->delete();

        return response()->json([
            'message' => 'Eliminado correctamente'
        ]);
    }
}
