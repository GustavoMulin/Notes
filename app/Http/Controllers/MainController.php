<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        $id = session('user.id');
        $user = User::find($id)->toArray();
        $notes = User::find($id)->notes()->get()->toArray();

        echo '<pre>';
        print_r($user);
        print_r($notes);

        die();

        return view('home');
    }

    public function newNote()
    {
        echo 'Notes';
    }
}
