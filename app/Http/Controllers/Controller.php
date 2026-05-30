<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function validationMessages(): array
    {
        $message = 'Verifique los datos cargados e intente nuevamente.';

        return [
            'required' => $message,
            'string' => $message,
            'max' => $message,
            'integer' => $message,
            'exists' => $message,
            'email' => $message,
            'unique' => $message,
            'min' => $message,
        ];
    }
}
