<?php

namespace App\Http\Controllers;

use App\Contracts\UserContract as UserRepository;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UserRepository $userRepo)
    {
        $users = $userRepo->all();

        return view('users.index', compact('users'));
    }
}
