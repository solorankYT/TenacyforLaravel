<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Institution;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Show all users
    public function index()
    {
        $users = User::with('institution')->get(); 
        return response()->json($users);
    }

    // Create a new user
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'edupid' => 'required|string',
            'roles' => 'array',
            'institution_id' => 'required|exists:institutions,id'
        ]);

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'edupid' => $request->edupid,
            'roles' => json_encode($request->roles),
            'institution_id' => $request->institution_id, 
        ]);

        return response()->json($user, 201);
    }

}
