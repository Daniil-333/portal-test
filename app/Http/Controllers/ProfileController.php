<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class ProfileController extends Controller
{
    use AuthenticatesUsers, ConfirmsPasswords;

    const string TITLE = 'Профиль';

    public function index()
    {
        return Inertia::render('Profile/Index', [
            'title' => self::TITLE,
        ]);
    }

    public function update_info()
    {
        $user = auth()->user();

        if (!$user) {
            $errors['profile_update_error'][] = 'Пользователь не авторизован!';
        }

        return Inertia::render('Profile/Index', [
            'title' => self::TITLE,
            'errors' => Inertia::merge($errors ?? []),
        ]);
    }

    public function update_password(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            $errors['profile_update_error'][] = 'Пользователь не авторизован!';
        }

        if (!Hash::check($request->get('old_password'), $user->password)) {
            $errors['profile_update_error'][] = 'Текущий пароль введён неверно!';
        }

        if ($request->get('password') !== $request->get('confirm')) {
            $errors['profile_update_error'][] = 'Пароли не совпадают!';
        }

        $user->update(['password' => Hash::make($request->get('password'))]);

        return Inertia::render('Profile/Index', [
            'title' => self::TITLE,
            'errors' => Inertia::merge($errors ?? []),
        ]);
    }

    public function remove(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return Inertia::render('Profile/Index', [
                'title' => self::TITLE,
                'errors' => Inertia::merge([
                    'profile_remove_error' => 'Пользователь не авторизован!'
                ])
            ]);
        }

        $user->delete();
        $this->logout($request);
    }
}
