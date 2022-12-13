<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Driver;
use App\DriverActivity;
use App\Order;
use App\Package;
use App\OrderStatus;
use App\Contact;
use Auth;
use Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        return view('auth.register');
    }
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect('home');
    }

    public function login()
    {

        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if(Auth::user()->type == true){
                return redirect()->intended('admin/home');
            }else{
                Auth::logout();
                return redirect('login')->with('error', 'Opps! this user has no access to admin portal'); 
            }
        }

        return redirect('login')->with('error', 'Opps! You have entered invalid credentials');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('login');
    }

    public function home()
    {
        $drivers = Driver::where('status', 1)->get();
        $users = User::where('status', 1)->get();
        $orders = Order::get();
        $contacts = Contact::get();

        $totalDrivers = count($drivers);
        $totalUsers = count($users);
        $totalOrders = count($orders);
        $totalContacts = count($contacts);
        return view('dashboard', ["drivers" => $totalDrivers, "users" => $totalUsers, "orders" => $totalOrders, "contacts" => $totalContacts]);
    }
}
