<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Inertia\Inertia;
use Inertia\Response;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     * @var string
     */
    protected $redirectTo = '/';

    public function showResetForm(Request $request): Response
    {
        $token = $request->route()->parameter('token');

        return Inertia::render('Auth/ResetPassword', [
            'title' => 'Изменение пароля',
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    protected function sendResetResponse(Request $request, $response): JsonResponse|Redirector|RedirectResponse
    {
        if ($request->wantsJson()) {
            return new JsonResponse(['message' => trans($response)], 200);
        }

        session()->flash('status', trans($response));

        return redirect($this->redirectPath())
            ->with('status', trans($response));
    }
}
