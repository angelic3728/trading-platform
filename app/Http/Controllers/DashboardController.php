<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Transaction;
use App\Stock;

use IEX;
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
        $transactions = auth()->user()->transactions()->get();
        $used_currencies = array();

        // get available currencies
        foreach ($transactions as $transaction) {
            if ($transaction->is_fund == 1) {
                if ($transaction->mutualFund && $transaction->mutualFund->gcurrency != "USD" && !in_array("USD" . $transaction->mutualFund->gcurrency, $used_currencies)) {
                    array_push($used_currencies, "USD" . $transaction->mutualFund->gcurrency);
                }
            } else {
                if ($transaction->stock && $transaction->stock->gcurrency != "USD" && !in_array("USD" . $transaction->stock->gcurrency, $used_currencies)) {
                    array_push($used_currencies, "USD" . $transaction->stock->gcurrency);
                }
            }
        }

        $currency_str = implode(",", $used_currencies);
        $all_rates = IEX::getRates($currency_str);

        $total_transaction_price = 0;

        // add calculated prices
        foreach ($transactions as $transaction) {
            if ($transaction->is_fund == 1) {
                if ($transaction->mutualFund) {
                    if ($transaction->mutualFund->gcurrency != "USD") {
                        $rate = $all_rates['USD' . $transaction->mutualFund->gcurrency];
                        $transaction->realPrice = ($rate && $rate != 0) ? $transaction->price / $rate : $transaction->price;
                        if ($transaction->type == "buy")
                            $total_transaction_price += $transaction->realPrice;
                        else
                            $total_transaction_price -= $transaction->realPrice;
                    } else {
                        $transaction->realPrice = $transaction->price;
                        if ($transaction->type == "buy")
                            $total_transaction_price += $transaction->realPrice;
                        else
                            $total_transaction_price -= $transaction->realPrice;
                    }
                }
            } else {
                if ($transaction->stock) {
                    if ($transaction->stock->gcurrency != "USD") {
                        $rate = $all_rates['USD' . $transaction->stock->gcurrency];
                        $transaction->realPrice = ($rate && $rate != 0) ? $transaction->price / $rate : $transaction->price;
                        if ($transaction->type == "buy")
                            $total_transaction_price += $transaction->realPrice;
                        else
                            $total_transaction_price -= $transaction->realPrice;
                    } else {
                        $transaction->realPrice = $transaction->price;
                        if ($transaction->type == "buy")
                            $total_transaction_price += $transaction->realPrice;
                        else
                            $total_transaction_price -= $transaction->realPrice;
                    }
                }
            }
        }

        /**
         * Return view
         */
        return view('dashboard.overview', [
            'account_manager' => $account_manager,
            'documents' => $documents,
            'total_transaction_price' => $total_transaction_price,
            'transactions' => $transactions
        ]);
    }

    public function viewAsUser(User $user = null)
    {
        /* Check if the user exists */
        if ($user == null) {
            abort(404);
        }
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
