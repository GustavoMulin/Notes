<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\password;

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

       // checar se o usuário existe
       $user = User::where('username', $username)->where('deleted_at', NULL)->first();

        if(!$user) {
            return redirect()->back()->withInput()->with('loginError', 'Username ou password incorretos.');
        }

        // Checar se a password está correta
        if(!password_verify($password, $user->password)){
            return redirect()->back()->withInput()->with('loginError', 'Username ou password incorretos.');
        }

        // atualizar last_login
        $user->last_login = date('Y-m-d H:i:s');
        $user->save();

        // usuario logado
        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username
            ]
        ]);

        // redirect home
        return redirect()->to('/');
    }

    public function logout()
    {
        // logout(sair) da aplicação
        session()->forget('user');
        return redirect()->to('/login');
    }
}