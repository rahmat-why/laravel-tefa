<?php

namespace App\Http\Controllers;

use App\Models\MsCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mail;
use App\Mail\EmailService;
use Illuminate\Support\Facades\Auth;

class AuthenticationController extends Controller
{
    public function login()
    {
        return view('authentication.login');
    }

    public function processLogin(Request $request)
    {
        // Handle error when email is not registered
        $customer = MsCustomer::where('email', $request->email)->first();

        if (!$customer) {
            return redirect()->route('authentication.login.form')->with('ErrorMessage', 'Email belum terdaftar!');
        }

        // Generate OTP
        $otp = rand(100000, 999999);

        $mailData = [
            'body' => 'Berikut ini OTP anda: '.$otp
        ];

        // Send OTP to the provided email
        Mail::to($request->email)->send(new EmailService($mailData));

        // Save otp to session
        Session::put('email', $customer->email);
        Session::put('otp', $otp);

        // Redirect to verification page
        return redirect()->route('authentication.verification.form');
    }

    public function register()
    {
        return view('authentication.register');
    }

    public function processRegister(Request $request)
    {
        // Handle error when email is empty
        if (empty($request->email)) {
            return view('authentication.register'); // Return the view you want
        }

        // Handle error when email is registered
        $customer = MsCustomer::where('email', $request->email)->first();
        if ($customer) {
            return redirect()->route('authentication.register.form')->with('ErrorMessage', 'Email sudah terdaftar!');
        }

        // Generate OTP
        $otp = rand(100000, 999999);

        $mailData = [
            'body' => 'Berikut ini OTP anda: '.$otp
        ];
        
        // Send OTP
        Mail::to($request->email)->send(new EmailService($mailData));

        // Generate id customer
        $idCustomer = 'CST' . (MsCustomer::count() + 1);

        // Create new customer in the database
        $newCustomer = MsCustomer::create([
            'id_customer' => $idCustomer,
            'email' => $request->email,
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        // Save email & otp to session
        Session::put('email', $request->email);
        Session::put('otp', $otp);

        // Redirect to verification page
        return redirect()->route('authentication.verification.form')->with('SuccessMessage', 'Registrasi berhasil!');
    }

    public function verification() {
        // Retrieve OTP from session
        $otp = session('otp');

        // Handle if no OTP in session
        if (empty($otp)) {
            return redirect()->route('authentication.login.form');
        }

        return view('authentication.verification');
    }

    public function processVerification(Request $request) {
        // Retrieve email and OTP from session
        $email = session('email');
        $otp = session('otp');

        // Compare OTP
        if ($otp != $request->password) {
            return redirect()->route('authentication.verification.form')
                ->with('ErrorMessage', 'OTP tidak valid!')
                ->with('email', $email);
        }

        // Remove the session after successful verification
        session()->forget(['email', 'otp']);

        // Retrieve customer
        $customer = MsCustomer::where('email', $email)->first();

        // Attempt to log in the user using the custom guard
        Auth::guard('ms_customers')->login($customer);

        // Redirect to the home page
        return redirect()->route('home.form');
    }

    public function processLogout() {
        // Log the user out of the 'ms_customers' guard
        Auth::guard('ms_customers')->logout();

        // Redirect to the login page or any other page as needed
        return redirect()->route('authentication.login.form');
    }
}
