<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MainController extends Controller
{
    public function index()
    {
        $id = session('user.id');
        $notes = User::find($id)->notes()->get()->toArray();

        return view('home', ['notes' => $notes]);
    }

    public function newNote()
    {
        echo 'Notes';
    }

    public function editNote($id)
    {
        $id = $this->decryptId($id);
        echo "Edite o Id = $id";
    }

    public function deleteNote($id)
    {
        $id = $this->decryptId($id);
        echo "Delete o Id = $id";
    }

    private function decryptId($id)
    {
         try {  
            $id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->route('home');
        }

        return $id;
    }
}
