<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Validators\RegisterValidator;
use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return Inertia::render('Auth/LoginRegister', [
            'title' => 'Регистрация',
            'isRegister' => true,
            'recaptchaSiteKey' => config('services.recaptcha.site_key')
        ]);
    }

    protected function redirectTo()
    {
        return route('verification.notice');
    }

    /**
     * Get a validator for an incoming registration request.
     * @param  array  $data
     * @return Validator
     */
    protected function validator(array $data): Validator
    {
        return (new RegisterValidator())->run($data);
    }

    /**
     * Create a new user instance after a valid registration.
     * @param array $data
     * @return User
     */
    protected function create(array $data): User
    {
        return User::create([
            'name' => $data['user_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * The user has been registered.
     * @param Request $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        //
    }
}
