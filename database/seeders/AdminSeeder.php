<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\admin;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $password = 'admin123';
        
        $encryptedPass = $this->encryptWithRsa($password);

        admin::updateOrCreate(
            ['ci_admin' => '1234567'],
            [
                'user_admin' => 'admin',
                'pass_admin' => $encryptedPass,
                'tel_admin'  => '0981123456',
            ]
        );
    }

    private function encryptWithRsa(string $value): string
    {
        $path = storage_path('app/private/rsa_public.pem');
        
        if (! file_exists($path)) {
            throw new \Exception("No se encontro la llave publica en: $path");
        }

        $publicKey = file_get_contents($path);
        $encrypted = '';

        if (! openssl_public_encrypt($value, $encrypted, $publicKey, OPENSSL_PKCS1_OAEP_PADDING)) {
            throw new \Exception('No se pudo cifrar con RSA');
        }
        
        return base64_encode($encrypted);
    }
}
