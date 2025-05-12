<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }
    
    public function loginSubmit(Request $request)
    {
        // validação de formulário
        $request->validate(
            // Regras
            [
                'text_username' => 'required|email',
                'text_password' => 'required|min:6|max:26'
            ],
            // Mensagens de Erros
            [
                'text_username.required' => 'O username é obrigatório',
                'text_username.email' => 'O username deve ser um email válido',
                'text_password.required' => 'A password é obrigatório',
                'text_password.min' => 'A password deve ter pelo menos :min caracteres',
                'text_password.max' => 'A password deve ter no máximo :max caracteres'
            ]
        );

        // obter entrada do usuário
        $username = $request->input('text_username');
        $password = $request->input('text_password');

        echo 'OK!';
    }

    public function logout()
    {
        echo 'logout';
    }
}