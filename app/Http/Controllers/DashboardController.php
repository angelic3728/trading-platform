<?php

namespace App\Http\Controllers;

use App\User;
use App\Xtbs;

use IEX;
use ASX;
use CustomStockData;
use CustomFundData;
use Cache;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\API\StockController;
use App\Http\Controllers\API\FundsController;
use App\Http\Controllers\API\CryptosController;

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
        /**
         * Get Latest Xtbs
         */
        $xtbs = Xtbs::query()->orderBy('id', 'DESC')->latest()->take(5)->get();
        /**
         * Get All transaction
         */
        $transactions = auth()->user()->transactions()->orderBy('created_at', 'DESC')->get();
        $used_currencies = array();
        $total_transaction_price = 0;

        if (count($transactions) != 0) {
            // get available currencies
            foreach ($transactions as $transaction) {
                if ($transaction->wherefrom == 0) {
                    if ($transaction->stock && $transaction->stock->gcurrency != "USD" && !in_array("USD" . $transaction->stock->gcurrency, $used_currencies)) {
                        array_push($used_currencies, "USD" . $transaction->stock->gcurrency);
                    }
                } else if ($transaction->wherefrom == 1) {
                    if ($transaction->fund && $transaction->fund->gcurrency != "USD" && !in_array("USD" . $transaction->fund->gcurrency, $used_currencies)) {
                        array_push($used_currencies, "USD" . $transaction->fund->gcurrency);
                    }
                }
            }

            if (count($used_currencies) != 0) {
                $currency_str = implode(",", $used_currencies);
                $all_rates = IEX::getRates($currency_str);
            }

            foreach ($transactions as $transaction) {
                if ($transaction->wherefrom == 0) {
                    if ($transaction->stock) {
                        // add detailed info
                        $transaction->symbol = $transaction->stock->symbol;
                        $transaction->company_name = $transaction->stock->company_name;
                        $transaction->gcurrency = $transaction->stock->gcurrency;
                        $transaction->data_source = $transaction->stock->data_source;
                        switch ($transaction->stock->data_source) {
                            case 'iex':
                                $iex_data = [];
                                try {
                                    $iex_data = IEX::getDetails($transaction->stock->symbol);
                                } catch (\Exception $e) {
                                }
                                $transaction->latest_price = array_has($iex_data, 'quote.latestPrice') ? round(array_get($iex_data, 'quote.latestPrice'), 3) : null;
                                $transaction->change_percentage = array_has($iex_data, 'quote.changePercent') ? round(array_get($iex_data, 'quote.changePercent'), 4) : null;
                                $transaction->institutional_price =
                                    array_has($iex_data, 'quote.latestPrice') ? round($transaction->stock->institutionalPrice(array_get($iex_data, 'price')), 3) : null;
                                break;
                            case 'asx':
                                $asx_data = ASX::getDetails($transaction->stock->symbol);
                                $transaction->latest_price = array_has($asx_data, 'latest_price') ? round(array_get($asx_data, 'latest_price'), 3) : null;
                                $transaction->change_percentage = array_has($asx_data, 'change_percentage') ? round(array_get($asx_data, 'change_percentage'), 4) : null;
                                $transaction->institutional_price = array_has($asx_data, 'price') ? round($transaction->stock->institutionalPrice(array_get($asx_data, 'price')), 3) : null;
                                break;
                            case 'custom':
                                $transaction->latest_price = round(CustomStockData::price($transaction->stock->symbol), 3);
                                $transaction->change_percentage = round(CustomStockData::changePercentage($transaction->stock->symbol), 4);
                                $transaction->institutional_price = round(CustomStockData::price($transaction->stock->symbol), 3);
                        }
                        // add real price and total prices
                        if ($transaction->stock->gcurrency != "USD") {
                            $rate = $all_rates['USD' . $transaction->stock->gcurrency];
                            $transaction->realPrice = ($rate && $rate != 0) ? round($transaction->latest_price * $transaction->shares / $rate, 2) : $transaction->price;
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
                } else if ($transaction->wherefrom == 1) {
                    if ($transaction->fund) {
                        // add detailed info
                        $transaction->symbol = $transaction->fund->symbol;
                        $transaction->company_name = $transaction->fund->company_name;
                        $transaction->gcurrency = $transaction->fund->gcurrency;
                        $transaction->data_source = $transaction->fund->data_source;
                        switch ($transaction->fund->data_source) {
                            case 'iex':
                                $iex_data = [];
                                try {
                                    if ($transaction->fund->exchange != "NAS")
                                        $iex_data = IEX::getDetails($transaction->fund->symbol);
                                    else
                                        $iex_data = ASX::getDetails($transaction->fund->symbol);
                                } catch (\Exception $e) {
                                }
                                if ($transaction->fund->exchange != "NAS") {
                                    $transaction->latest_price = array_has($iex_data, 'quote.latestPrice') ? round(array_get($iex_data, 'quote.latestPrice'), 3) : null;
                                    $transaction->change_percentage = array_has($iex_data, 'quote.changePercent') ? round(array_get($iex_data, 'quote.changePercent'), 4) : null;
                                    $transaction->institutional_price =
                                        array_has($iex_data, 'quote.latestPrice') ? round($transaction->fund->institutionalPrice(array_get($iex_data, 'price')), 3) : null;
                                } else {
                                    $transaction->latest_price = array_has($iex_data, 'latest_price') ? round(array_get($iex_data, 'latest_price'), 3) : null;
                                    $transaction->change_percentage = array_has($iex_data, 'change_percentage') ? round(array_get($iex_data, 'change_percentage'), 4) : null;
                                    $transaction->institutional_price = array_has($iex_data, 'price') ? round($transaction->fund->institutionalPrice(array_get($iex_data, 'price')), 3) : null;
                                }
                                break;
                            case 'asx':
                                $asx_data = ASX::getDetails($transaction->stock->symbol);
                                $transaction->latest_price = array_has($asx_data, 'latest_price') ? round(array_get($asx_data, 'latest_price'), 3) : null;
                                $transaction->change_percentage = array_has($asx_data, 'change_percentage') ? round(array_get($asx_data, 'change_percentage'), 4) : null;
                                $transaction->institutional_price = array_has($asx_data, 'price') ? round($transaction->fund->institutionalPrice(array_get($asx_data, 'price')), 3) : null;
                                break;
                            case 'custom':
                                $transaction->latest_price = round(CustomFundData::price($transaction->fund->symbol), 3);
                                $transaction->change_percentage = round(CustomFundData::changePercentage($transaction->fund->symbol), 4);
                                $transaction->institutional_price = round(CustomFundData::price($transaction->fund->symbol), 3);
                        }
                        // add real price and total prices
                        if ($transaction->fund->gcurrency != "USD") {
                            $rate = $all_rates['USD' . $transaction->fund->gcurrency];
                            $transaction->realPrice = ($rate && $rate != 0) ? round($transaction->latest_price * $transaction->shares / $rate, 2) : $transaction->price;
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
                    if ($transaction->crypto) {
                        // add detailed info
                        $transaction->symbol = $transaction->crypto->symbol;
                        $transaction->company_name = $transaction->crypto->company_name;
                        $transaction->gcurrency = $transaction->crypto->gcurrency;
                        $transaction->data_source = $transaction->crypto->data_source;
                        switch ($transaction->crypto->data_source) {
                            case 'gecko':
                                $crypto_data = [];
                                try {
                                    $crypto_data = Cache::remember('cryptos:gecko-detail-' . $transaction->crypto->coin_id, 25, function () use ($transaction) {
                                        return ASX::getCDetails($transaction->crypto->coin_id);
                                    });
                                } catch (\Exception $e) {
                                }
                                $transaction->latest_price = ($crypto_data) ? array_get($crypto_data, 'market_data.current_price.usd') : 0;
                                $transaction->change_percentage = array_get($crypto_data, 'market_data.price_change_percentage_24h') ? round(array_get($crypto_data, 'market_data.price_change_percentage_24h'), 2) : null;
                                $transaction->institutional_price = array_get($crypto_data, 'market_data.current_price.usd') ? $transaction->crypto->institutionalPrice(array_get($crypto_data, 'market_data.current_price.usd')) : null;
                                break;
                            case 'custom':
                                $transaction->latest_price = CustomFundData::price($transaction->crypto->symbol);
                                $transaction->change_percentage = CustomFundData::changePercentage($transaction->crypto->symbol);
                                $transaction->institutional_price = CustomFundData::price($transaction->crypto->symbol);
                        }
                        // add real price and total prices
                        $transaction->realPrice = round($transaction->latest_price * $transaction->shares, 2);
                        if ($transaction->type == "buy")
                            $total_transaction_price += $transaction->realPrice;
                        else
                            $total_transaction_price -= $transaction->realPrice;
                    }
                }
            }
        }


        // Get all highlights
        $stock_highlights = StockController::highlights(4)->getData();
        $fund_highlights = FundsController::highlights(4)->getData();
        $crypto_highlights = CryptosController::highlights(4)->getData();

        $all_highlights = array_merge($stock_highlights->data, $fund_highlights->data);
        $all_highlights = array_merge($all_highlights, $crypto_highlights->data);

        $user_currency = '';
        if (auth()->user()->balance) {
            $user_currency = json_decode(auth()->user()->balance, 'true')['currency'];
            if ($user_currency != 'USD') {
                $user_currency_rate = IEX::getRates('USD' . $user_currency);
                $total_transaction_price = $total_transaction_price * $user_currency_rate['USD' . $user_currency];
            }
        }

        /**
         * Get Top cryptos
         */

        $top_cryptos = [];

        try {
            $top_cryptos = ASX::getMarketCryptos();
        } catch (\Exception $e) {
        }

        /**
         * Return view
         */
        return view('dashboard.overview', [
            'account_manager' => $account_manager,
            'documents' => $documents,
            'total_transaction_price' => $total_transaction_price,
            'user_currency' => $user_currency,
            'transactions' => $transactions,
            'xtbs' => $xtbs,
            'all_highlights' => $all_highlights,
            'top_cryptos' => $top_cryptos,
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
