<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MsUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login()
    {
        return view('user.login');
    }

    public function processLogin(Request $request)
    {
        // Handle error when account is registered
        $user = MsUser::where('username', $request->username)->first();

        if (!$user) {
            return redirect()->route('user.login.form')->with('ErrorMessage', 'Username atau password salah!');
        }

        $verified = Hash::check($request->password, $user->password);

        if (!$verified) {
            return redirect()->route('user.login.form')->with('ErrorMessage', 'Username atau password salah!');
        }

        // Attempt to log in the user using the custom guard
        Auth::guard('ms_users')->login($user);

        // Redirect to user dashboard
        return redirect()->route('booking.history.form');
    }

    public function processCreate()
    {
        // Validate if the username is already used
        $usernameExists = MsUser::where('username', $request->username)->exists();
        if ($usernameExists) {
            return redirect()->route('user.create')->with('ErrorMessage', 'Username sudah digunakan!');
        }

        // Validate if the NIM is already used
        $nimExists = MsUser::where('nim', $request->nim)->exists();
        if ($nimExists) {
            return redirect()->route('user.create.form')->with('ErrorMessage', 'NIM sudah digunakan!');
        }

        // Generate id user
        $id_user = 'USR' . (MsUser::count() + 1);

        // Hash password
        $hashedPassword = Hash::make($request->password);

        // Create a new user
        $user = new MsUser([
            'id_user' => $id_user,
            'full_name' => $request->full_name,
            'nim' => $request->nim,
            'username' => $request->username,
            'password' => $hashedPassword,
            'position' => $request->position,
        ]);

        // Save the user to the database

        // Redirect to user index
        return redirect()->route('user.booking.form')->with('SuccessMessage', 'Data berhasil disimpan!');
    }

    public function processLogout() {
        // Log the user out of the 'ms_users' guard
        Auth::guard('ms_users')->logout();

        // Redirect to the login page or any other page as needed
        return redirect()->route('user.login.form');
    }
}
