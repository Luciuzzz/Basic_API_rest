<?php

namespace App\Http\Controllers;

use App\Models\admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use RuntimeException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;


class AdminController extends Controller
{
    public function index()
    {
        return response()->json(admin::all());
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

        // if (admin::where('ci_admin', (string) $data['ci_admin'])->exists()) return response()->json('CI ya registrado', 422);

        $data['user_admin'] = (string) $data['user_admin'];
        $data['pass_admin'] = Hash::make((string) $data['pass_admin']);
        $data['tel_admin'] = (string) $data['tel_admin'];
        $data['ci_admin'] = (string) $data['ci_admin'];



        Log::warning('Admin creado', [
            'ci_admin' => $data['ci_admin'],
        ]);

        $admin = admin::create($data);

        return response()->json([
            'message' => 'Admin creado correctamente',
            'data' => $admin,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(admin $admin)
    {
        return response()->json($admin);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, admin $admin)
    {
        $data = $request->validate([
            'user_admin' => 'sometimes|required|string|max:255',
            'pass_admin' => 'sometimes|required|string|min:8',
            'tel_admin' => 'sometimes|required|string|max:20',
            'ci_admin' => 'sometimes|required|string|max:50|unique:admins,ci_admin,' . $admin->id,
        ]);

        if (isset($data['pass_admin'])) {
            $data['pass_admin'] = $this->encryptWithRsa($data['pass_admin']);
        }

        $admin->update($data);

        return response()->json($admin);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $admin = admin::findOrFail($id);

        $admin->delete();

        return response()->json([
            'message' => 'Eliminado correctamente'
        ]);
    }

    private function encryptWithRsa(string $value): string
    {
        $publicKeyPath = storage_path('app/private/rsa_public.pem');

        if (! file_exists($publicKeyPath)) {
            throw new RuntimeException('No se encontro la llave publica');
        }

        $publicKey = file_get_contents($publicKeyPath);

        $encrypted = '';

        if (! openssl_public_encrypt($value, $encrypted, $publicKey, OPENSSL_PKCS1_OAEP_PADDING)) {
            throw new RuntimeException('No se pudo cifrar');
        }

        return base64_encode($encrypted);
    }
}
