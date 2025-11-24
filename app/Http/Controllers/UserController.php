<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function index()
    {
        return view('user');
    }
    public function destroy(User $user)
{
    $user->delete();
    return back()->with('success', "User {$user->name} has been deleted.");
}
}
