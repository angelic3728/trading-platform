<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\ActivationToken;

use Auth;

class RegistrationController extends Controller
{

    public function getStarted($token)
    {

        /**
         * Get activation token
         */
        $activation_token = ActivationToken::where('token', $token)->first();

        /**
         * If there is no activation token, go to login with an message
         */
        if(!$activation_token){

            return redirect()
                      ->route('login')
                      ->withMessage('Your registration is already completed or is invalid. Please login using your account information.');

        }

        /**
         * Return get started view
         */
        return view('dashboard.get-started', [
            'activation_token' => $activation_token,
        ]);

    }

    public function setPassword(Request $request, $token)
    {

        /**
         * Validate
         */
        $request->validate([
            'password' => 'required|min:6|confirmed',
            'terms' => 'accepted',
        ]);

        /**
         * Get activation token
         */
        $activation_token = ActivationToken::where('token', $token)->first();

        /**
         * Activate User
         */
        $activation_token->user->update([
            'password' => bcrypt($request->password),
            'active' => true,
        ]);

        /**
         * Authenticate user
         */
        Auth::login($activation_token->user);

        /**
         * Delete activation token
         */
        $activation_token->delete();

        /**
         * Redirect to dashboard
         */
        return redirect()->route('overview');

    }

}
