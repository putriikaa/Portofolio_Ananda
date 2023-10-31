<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendMailJob;


class LoginRegisterController extends Controller
{
/**
* Instantiate a new LoginRegisterController instance. */
    public function __construct()
    {
        $this->middleware('guest')->except ( [ 
            'logout', 'dashboard'
        ]);
    }
// Display a registration form.
    // @return \Illuminate\Http\Response
    public function register()
    {
        return view('auth.register');
    }
// **/
// *Store a new user.
// *
// * @param \Illuminate\Http\Request $request
// * @return \Illuminate\Http\Response */
public function store (Request $request)
{

    $request->validate([
    'name' => 'required|string|max: 250',
    'email' => 'required|email|max: 250 | unique:users',
    'password' => 'required|min:8|confirmed'
    ]);

    User::create([
    'name' => $request->name, 
    'email' => $request->email,
    'password' => Hash::make($request->password)
    ]);

    $data = [
        'name' => $request->name,
        'email' => $request->email,
        'subject' => "Selamat Datang di Website Portfolioku",
        'body' => "Anda telah mengunjungi Website Portfolio Ananda Kusuma Putri."
    ];

$credentials = $request->only ('email', 'password');
Auth::attempt($credentials);
$request->session ()->regenerate(); 

dispatch(new SendMailJob($data));

return redirect()->route('dashboard')
    ->withSuccess('You have successfully registered & logged in!');
}

public function login()
{
    return view('auth.login');
}

public function authenticate(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);
    if  (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->route('dashboard')
        ->withSuccess('You have successfully logged in');
    }

    return back()->withErrors([
        'email' => 'Your provided credentials do not match in our records.',
    ])->onlyInput('email');
    }

    public function dashboard()
    {
        if(Auth::check()){
            return view('auth.dashboard');
        }
        return redirect()->route('login')
        ->withErrors([
            'email' => 'Please login to access the dashboard',
        ]) ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')
        ->withSuccess('You have logged out successfully!');;
    }
}