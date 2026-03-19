<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        return Inertia::render('Auth/ForgotPassword', [
            'title' => 'Сброс пароля'
        ]);
    }

    protected function sendResetLinkResponse(Request $request, $response): JsonResponse|RedirectResponse
    {
        if($request->wantsJson()) {
            return new JsonResponse(['message' => trans($response)], 200);
        }
        else {
            session()->flash('status', trans($response));
            return back()->with('status', trans($response));
        }

    }
}
