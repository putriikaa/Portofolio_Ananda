<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendMailJob;
use Intervention\Image\Facades\Image;


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
    'password' => 'required|min:8|confirmed',
    'photo' =>'image|nullable|max:1999'
    ]);

    if ($request->hasFile('photo')) {
        $image = $request->file('photo');
        $filenameWithExt = $request->file('photo')->getClientOriginalName();
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('photo')->getClientOriginalExtension();
        $filenameToStore = $filename . '_' . time() . '.' . $extension;
        $path = $request->file('photo')->storeAs('photos/original', $filenameToStore);
        // Simpan gambar asli

        // Buat thumbnail dengan lebar dan tinggi yang diinginkan
        $thumbnailPath = public_path('storage/photos/thumbnail/' . $filenameToStore);
        Image::make($image)
            ->fit(100, 100)
            ->save($thumbnailPath);

        // Buat versi persegi dengan lebar dan tinggi yang sama
        $squarePath = public_path('storage/photos/square/' . $filenameToStore);
        Image::make($image)
            ->fit(200, 200)
            ->save($squarePath);

        $path = $filenameToStore;
    } else {
        $path = null;
    }
    User::create([
    'name' => $request->name, 
    'email' => $request->email,
    'password' => Hash::make($request->password),
    'photo'=> $path
    ]);

    $data = [
        'name' => $request->name,
        'email' => $request->email,
        'subject' => "Selamat Datang di Website Portfolioku",
        'body' => "Anda telah mengunjungi Website Portfolio Ananda Kusuma Putri."
    ];

    if($request->hasFile('picture')){
        //ada file yang diupload
    } else{
        //tidak ada file yang diupload
    }



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