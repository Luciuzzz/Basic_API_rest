<?php

namespace App\Http\Controllers;

use App\Models\admin;
use Illuminate\Http\Request;
use RuntimeException;


class AdminController extends Controller
{
    public function index()
    {
        return response()->json(admin::all());
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'user_admin' => 'required|string|max:255',
            'pass_admin' => 'required|string|min:8',
            'tel_admin' => 'required|string|max:20',
            'ci_admin' => 'required|string|max:50|unique:admins,ci_admin'
        ]);

        $data['pass_admin'] = $this->encryptWithRsa($data['pass_admin']);

        $admin = admin::create($data);

        return response()->json($admin, 201);
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
