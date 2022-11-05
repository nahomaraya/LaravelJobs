<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;



class UserController extends Controller
{
    public function create(){
        return view('user.register');
    }
    public function store(Request $request){
       
            $formFields = $request->validate([
                'name' => ['required', 'min:3'],
                'email'=> ['required', 'email', Rule::unique('users', 'email')],
                'password'=> ['required','confirmed','min:6']
                
            ]);
            //hash password
            $formFields['password']=bcrypt( $formFields['password']);
            //creaate user
            $user = User::create($formFields);
            //login user
            auth()->login($user);
            return redirect('/')->with('message', 'Registered and Logged in');
        
       
    }

    
    public function login(){
        return view('user.login');
    }
    public function authenticate(Request $request){
        $formFields = $request->validate([
            'email'=> ['required', 'email'],
            'password'=> 'required'
            
        ]);
        if(auth()->attempt($formFields)){
            $request->session()->regenerateToken();
            return redirect('/')->with('message', 'Logged in Successfully');
        }
        else{
            return back()->withErrors(['email'=> 'Invalid email or password']);
        }
    }
    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')->with('message', 'You have been logged out');

    }
}
