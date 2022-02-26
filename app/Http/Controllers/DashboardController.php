<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Transaction;
use App\Stock;

use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class DashboardController extends Controller
{

    public function overview()
    {
        /**
         * Get Account Manager
         */
        $account_manager = auth()->user()->account_manager;

        /**
         * Get Latest Documents
         */
        $documents = auth()->user()->documents()->latest()->take(5)->get();

        /**
         * Return view
         */
        return view('dashboard.overview', [
            'account_manager' => $account_manager,
            'documents' => $documents,
        ]);

    }

    public function viewAsUser(User $user=null) {
        /* Check if the user exists */
        if ($user == null) { abort(404); }
        // Grabs the current user from the request
        $reqUser = \auth()->user();
        if ($reqUser->manager) {
            Auth::loginUsingId($user->id);
            return \redirect("/");
        } else {
            abort(404);
        }
    }

}
