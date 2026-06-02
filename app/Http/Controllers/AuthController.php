<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Faker\Provider\ar_EG\Person;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use Illuminate\Auth\Events\Login;

class AuthController extends Controller
{
    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255|unique:users',
            'password' => 'required',
        ]);
        $fields['password'] =  Hash::make($fields['password']);

        $user = User::create($fields);

        $token = $user->createToken($request->name);
        return [
            'user' => $user, 
            'token' => $token->plainTextToken];
    }

    public function login(Request $request){
        // User::factory()->create([
        //     'name' => 'Abdouaziz',
        //     'phone_number' => '7700000000',
        //     'email' => 'ciilaabokk@example.com',
        //     'password' => Hash::make('password'),
        // ]);
        return view('auth.login');

        // $request->validate([
        //     'phone_number' => 'required|string',
        //     'password' => 'required',
        // ]);

        // $user = User::where('phone_number', $request->phone_number)->first();

        // if(!$user || !Hash::check($request->password, $user->password)){
        //     return ['message' => 'The provided credentials are incorrect.'];
        // }
    
        // $token = $user->createToken($user->name);
        
        // //session(['user_id' => $user->id]); 

        // $tokenFromRequest = PersonalAccessToken::findToken($token->plainTextToken);
        // //$tokenFromRequest->user;
        // // return [
        // //     'user' => $user, 
        // //     'token' => $token->plainTextToken,
        // //     'tokenFromRequest' => $tokenFromRequest,
            
        // // ];
    }

    public function logout(Request $request){
        Auth::logout();
        return to_route('auth.login');
    }

    public function doLogin(LoginRequest $request){
        
        $field = filter_var($request->login, FILTER_VALIDATE_EMAIL)
        ? 'email'
        : 'phone_number';

        $credentials = [
            $field => $request->login,
            'password' => $request->password,
        ];
        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended(route('ouvriers.index'));
        }

        return to_route('login')->withErrors([
            'login' => 'Email ou numéro de téléphone ou mot de passe incorrect.',
        ]);
    
        // $token = $user->createToken($user->name);
        
        // session(['user_id' => $user->id]); 

        // return [
        //     'user' => $user, 
        //     'token' => $token->plainTextToken,
        // ];
    }
}
