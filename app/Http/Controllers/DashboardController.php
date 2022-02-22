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
         * Get my investments symbols
         */
        $investments = Transaction::where('user_id', auth()->id())
                            ->select(DB::raw('sum(shares) as total_shares'), 'stock_id')
                            ->with('stock')
                            ->groupBy('stock_id')
                            ->get();

        /**
         * Get Account Manager
         */
        $account_manager = auth()->user()->account_manager;

        /**
         * Get Latest Documents
         */
        $documents = auth()->user()->documents()->latest()->take(5)->get();

        /**
         * Get my investments symbols
         */
        $investments = Transaction::where('user_id', auth()->id())
                            ->select('stock_id')
                            ->with('stock')
                            ->groupBy('stock_id')
                            ->get()
                            ->where('stock.exchange', 'NYSE')
                            ->pluck('stock.symbol')
                            ->toArray();

        /**
         * Get highlighted symbols
         */
        $highlighted = Stock::where('highlighted', true)
                            ->where('exchange', 'NYSE')
                            ->get()
                            ->pluck('symbol')
                            ->toArray();

        /**
         * Prepare news symbols
         */
        $news_symbols = array_merge($investments, $highlighted);

        /**
         * Return view
         */
        return view('dashboard.overview', [
            'account_manager' => $account_manager,
            'documents' => $documents,
            'news_symbols' => $news_symbols,
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
