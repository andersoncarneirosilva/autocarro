<?php

return [
    'required' => 'O campo :attribute é obrigatório.',
    'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
    'min' => [
        'string' => 'O campo :attribute deve ter no mínimo :min caracteres.',
    ],
    'max' => [
        'string' => 'O campo :attribute não pode ter mais de :max caracteres.',
    ],
    'confirmed' => 'A confirmação de :attribute não confere.',
    'password' => [
        'min' => 'A senha deve ter pelo menos :min caracteres.',
        'confirmed' => 'A confirmação da senha não confere.',
    ],
];
