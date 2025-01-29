<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $all_users = User::all();
        $user_count = User::count();

        return view('users.index')->with([
            'users' => $all_users,
            'user_count' => $user_count
        ]);
    }
}
