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

    public function processLogout() {
        // Log the user out of the 'ms_users' guard
        Auth::guard('ms_users')->logout();

        // Redirect to the login page or any other page as needed
        return redirect()->route('user.logout.process');
    }

    public function index()
    {
        // Mengambil daftar pengguna dari database yang memiliki password
        $usersWithPassword = MsUser::whereNotNull('password')
            ->where('position', 'HEAD MECHANIC')
            ->get();

        return view('user.index', ['users' => $usersWithPassword]);
    }

    public function create()
    {
        return view('user.create');
    }

    public function processCreate(Request $request)
    {
       // Validasi request
        $request->validate([
            'full_name' => 'required|string',
            'nim' => 'required|string|unique:ms_users,nim',
            'username' => 'required|string|unique:ms_users,username',
            'password' => 'required|string',
            'position' => 'required|string',
        ], [
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'nim.required' => 'NIM wajib diisi.',
            'nim.unique' => 'NIM sudah digunakan.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'position.required' => 'Posisi wajib diisi.',
        ]);

        // Generate ID user
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
        $user->save();

        // Redirect to user index
        return redirect()->route('user.index')->with('SuccessMessage', 'Data berhasil disimpan!');
    }

    public function edit($id)
    {
        // Mengambil data pengguna berdasarkan id
        $msUser = MsUser::find($id);

        // Jika pengguna tidak ditemukan, kembalikan respons 'Not Found'
        if (!$msUser) {
            return abort(404);
        }

        // Menampilkan halaman untuk mengedit pengguna
        return view('user.edit', compact('msUser'));
    }

    public function update(Request $request, $id)
    {
        // Validasi request
        $request->validate([
            'full_name' => 'required|string',
            'nim' => 'required|string',
            'password' => 'nullable|string',
        ], [
            'full_name.required' => 'Nama lengkap wajib diisi.',
            'nim.required' => 'NIM wajib diisi.',
        ]);

        // Mengambil pengguna berdasarkan ID dari database
        $user = MsUser::find($id);

        // Jika pengguna tidak ditemukan, kembalikan respons 'Not Found'
        if (!$user) {
            return abort(404);
        }

        // Memperbarui seluruh atribut pengguna
        $user->full_name = $request->input('full_name');
        $user->nim = $request->input('nim');

        // Jika terdapat kata sandi baru
        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        // Memperbarui pengguna dalam database
        $user->save();

        // Menampilkan pesan sukses ke view
        return redirect()->route('user.index')->with('successMessage', 'Data berhasil diubah!');
    }

    public function delete($id)
    {
        // Mengambil pengguna berdasarkan ID dari database
        $msUser = MsUser::find($id);

        // Jika pengguna tidak ditemukan, kembalikan respons 'Not Found'
        if (!$msUser) {
            return abort(404);
        }

        // Menampilkan halaman konfirmasi penghapusan pengguna
        return view('user.delete', compact('msUser'));
    }

    // Menghapus pengguna dari database
    public function destroy($id)
    {
        // Mengambil pengguna berdasarkan ID dari database
        $msUser = MsUser::find($id);

        // Jika pengguna ditemukan
        if ($msUser) {
            // Setel kolom password menjadi null
            $msUser->password = null;

            // Simpan perubahan ke database
            $msUser->save();
        }

        // Redirect ke halaman daftar pengguna setelah penghapusan
        return redirect()->route('user.index')->with('successMessage', 'Pengguna berhasil dihapus!');
    }

    // Memeriksa keberadaan pengguna berdasarkan ID
    private function msUserExists($id)
    {
        // Menggunakan metode exists pada model MsUser
        return MsUser::where('id_user', $id)->exists();
    }

}
