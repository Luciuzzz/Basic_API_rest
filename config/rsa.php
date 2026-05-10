<?php

return [
    'public_key_path' => env('RSA_PUBLIC_KEY_PATH', storage_path('app/private/rsa_public.pem')),
    'private_key_path' => env('RSA_PRIVATE_KEY_PATH', storage_path('app/private/rsa_private.pem')),
];
