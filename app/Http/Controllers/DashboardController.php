<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

use App\Xtbs;

use IEX;
use CustomStockData;
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
        $documents = auth()->user()->documents()->orderBy('id', 'DESC')->latest()->take(5)->get();
        $xtbs = Xtbs::query()->orderBy('id', 'DESC')->latest()->take(5)->get();
        $transactions = auth()->user()->transactions()->orderBy('created_at', 'DESC')->get();
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

        foreach ($transactions as $transaction) {
            if ($transaction->is_fund == 1) {
                if ($transaction->mutualFund) {
                    // add detailed info
                    $transaction->symbol = $transaction->mutualFund->symbol;
                    $transaction->company_name = $transaction->mutualFund->company_name;
                    $transaction->gcurrency = $transaction->mutualFund->gcurrency;
                    $transaction->data_source = $transaction->mutualFund->data_source;
                    switch ($transaction->mutualFund->data_source) {
                        case 'iex':
                            $iex_data = IEX::getDetails($transaction->mutualFund->symbol);
                            $transaction->latest_price = array_has($iex_data, 'quote.latestPrice') ? round(array_get($iex_data, 'quote.latestPrice'), 3) : null;
                            $transaction->change_percentage = array_has($iex_data, 'quote.changePercent') ? round(array_get($iex_data, 'quote.changePercent'), 4) : null;
                            $transaction->institutional_price =
                                array_has($iex_data, 'quote.latestPrice') ? round($transaction->mutualFund->institutionalPrice(array_get($iex_data, 'price')), 3) : null;
                            break;
                        case 'custom':
                            $transaction->latest_price = round(CustomStockData::price($transaction->mutualFund->symbol), 3);
                            $transaction->change_percentage = round(CustomStockData::changePercentage($transaction->mutualFund->symbol), 4);
                    }
                    // add real price and total prices
                    if ($transaction->mutualFund->gcurrency != "USD") {
                        $rate = $all_rates['USD' . $transaction->mutualFund->gcurrency];
                        $transaction->realPrice = ($rate && $rate != 0) ? round($transaction->price / $rate, 2) : $transaction->price;
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
                    // add detailed info
                    $transaction->symbol = $transaction->stock->symbol;
                    $transaction->company_name = $transaction->stock->company_name;
                    $transaction->gcurrency = $transaction->stock->gcurrency;
                    $transaction->data_source = $transaction->stock->data_source;
                    switch ($transaction->stock->data_source) {
                        case 'iex':
                            $iex_data = IEX::getDetails($transaction->stock->symbol);
                            $transaction->latest_price = array_has($iex_data, 'quote.latestPrice') ? round(array_get($iex_data, 'quote.latestPrice'), 3) : null;
                            $transaction->change_percentage = array_has($iex_data, 'quote.changePercent') ? round(array_get($iex_data, 'quote.changePercent'), 4) : null;
                            $transaction->institutional_price =
                                array_has($iex_data, 'quote.latestPrice') ? round($transaction->stock->institutionalPrice(array_get($iex_data, 'price')), 3) : null;
                            break;
                        case 'custom':
                            $transaction->latest_price = round(CustomStockData::price($transaction->stock->symbol), 3);
                            $transaction->change_percentage = round(CustomStockData::changePercentage($transaction->stock->symbol), 4);
                    }
                    // add real price and total prices
                    if ($transaction->stock->gcurrency != "USD") {
                        $rate = $all_rates['USD' . $transaction->stock->gcurrency];
                        $transaction->realPrice = ($rate && $rate != 0) ? round($transaction->price / $rate, 2) : $transaction->price;
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
            'transactions' => $transactions,
            'xtbs' => $xtbs
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
