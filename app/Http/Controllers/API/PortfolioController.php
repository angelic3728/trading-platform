<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use IEX;
use ASX;
use CustomStockData;
use CustomFundData;
use CustomBondData;
use CustomCryptoData;
use Cache;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class PortfolioController extends Controller
{

    public function performance(string $range = "7d")
    {
        $stock_data = array();
        $fund_data = array();
        $bond_data = array();
        $crypto_data = array();

        $start_date = '';
        $inverval = '1 day';
        switch ($range) {

            case '7d':
                $start_date = Carbon::now()->subDays(6)->endOfDay();
                break;

            case '1m':
                $start_date = Carbon::now()->subMonths(1)->endOfDay();
                break;

            case '6m':
                $start_date = Carbon::now()->subMonths(6)->endOfDay();
                $inverval = '3 days';

            case 'ytd':
                $start_date = Carbon::now()->startOfYear()->endOfDay();
                break;
                $inverval = '3 days';

            case '1y':
                $start_date = Carbon::now()->subYears(1)->endOfDay();
                $inverval = '5 days';
                break;

            case '5y':
                $start_date = Carbon::now()->subYears(5)->endOfDay();
                $inverval = '20 days';
                break;

            default:
                return Carbon::now();
                break;
        }

        $period = CarbonPeriod::create($start_date, $inverval, Carbon::now());

        foreach ($period as $date) {
            array_push($stock_data, [$date->timestamp * 1000, 0]);
            array_push($fund_data, [$date->timestamp * 1000, 0]);
            array_push($bond_data, [$date->timestamp * 1000, 0]);
            array_push($crypto_data, [$date->timestamp * 1000, 0]);
        }

        $last_date = end($stock_data)[0] / 1000;
        $last_date_str = Carbon::createFromTimestamp($last_date)->format('Y-m-d');
        if ($last_date_str != Carbon::now()->format('Y-m-d')) {
            array_push($stock_data, [Carbon::now()->endOfDay()->timestamp * 1000, 0]);
            array_push($fund_data, [Carbon::now()->endOfDay()->timestamp * 1000, 0]);
            array_push($bond_data, [Carbon::now()->endOfDay()->timestamp * 1000, 0]);
            array_push($crypto_data, [Carbon::now()->endOfDay()->timestamp * 1000, 0]);
        }

        $stock_data = array_reverse($stock_data);
        $fund_data = array_reverse($fund_data);
        $bond_data = array_reverse($bond_data);
        $crypto_data = array_reverse($crypto_data);

        $transactions = auth()->user()->transactions()->get();
        $used_currencies = array();

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
                } else if ($transaction->wherefrom == 2) {
                    if (!in_array("USDAUD", $used_currencies))
                        array_push($used_currencies, "USDAUD");
                }
            }

            if (count($used_currencies) != 0) {
                $currency_str = implode(",", $used_currencies);
                $all_rates = IEX::getHistoricRates($currency_str, $range);
            }

            foreach ($transactions as $transaction) {
                if ($transaction->wherefrom == 0) {
                    if ($transaction->stock) {
                        // add detailed info

                        $transaction->gcurrency = $transaction->stock->gcurrency;
                        switch ($transaction->stock->data_source) {
                            case 'iex':
                                $chart = [];
                                try {
                                    $chart = IEX::getChart($transaction->stock->symbol, $range);
                                    $chart = $chart->toArray();
                                    $chart = array_reverse($chart);
                                } catch (\Exception $e) {
                                }

                                for ($i = 0; $i < count($stock_data); $i++) {
                                    if ($stock_data[$i][0] > Carbon::createFromFormat('Y-m-d',  $transaction->created_at)->timestamp*1000) {
                                        if ($transaction->gcurrency != "USD") {
                                            for ($j = 0; $j < count($chart); $j++) {
                                                if ($chart[$j]['date'] == Carbon::createFromTimestamp($stock_data[$i][0])) {
                                                    $rate = $this->getExactRate($stock_data[$i][0], $all_rates['USD' . $transaction->gcurrency]);
                                                    if ($transaction->type == 'buy')
                                                        $stock_data[$i][1] = $stock_data[$i][1] + $chart[$j]['fClose'] * $transaction->shares;
                                                    else
                                                        $stock_data[$i][1] = $stock_data[$i][1] - $chart[$j]['fClose'] * $transaction->shares;
                                                    break;
                                                } else if ($stock_data[$i][0] > Carbon::createFromFormat('Y-m-d',  $chart[$j]['date'])->timestamp * 1000) {
                                                    $rate = $this->getExactRate($stock_data[$i][0], $all_rates['USD' . $transaction->gcurrency]);
                                                    if ($transaction->type == 'buy')
                                                        $stock_data[$i][1] = $stock_data[$i][1] + ($chart[$j]['fClose'] * $transaction->shares) / ($rate);
                                                    else
                                                        $stock_data[$i][1] = $stock_data[$i][1] - ($chart[$j]['fClose'] * $transaction->shares) / ($rate);
                                                    break;
                                                }
                                            }
                                        } else {
                                            for ($j = 0; $j < count($chart); $j++) {
                                                if ($chart[$j]['date'] == Carbon::createFromTimestamp($stock_data[$i][0])) {
                                                    if ($transaction->type == 'buy')
                                                        $stock_data[$i][1] = $stock_data[$i][1] + $chart[$j]['fClose'] * $transaction->shares;
                                                    else
                                                        $stock_data[$i][1] = $stock_data[$i][1] - $chart[$j]['fClose'] * $transaction->shares;
                                                    break;
                                                } else if ($stock_data[$i][0] > Carbon::createFromFormat('Y-m-d',  $chart[$j]['date'])->timestamp * 1000) {
                                                    if ($transaction->type == 'buy')
                                                        $stock_data[$i][1] = $stock_data[$i][1] + $chart[$j]['fClose'] * $transaction->shares;
                                                    else
                                                        $stock_data[$i][1] = $stock_data[$i][1] - $chart[$j]['fClose'] * $transaction->shares;
                                                    break;
                                                }
                                            }
                                        }
                                    } else {
                                        break;
                                    }
                                }

                                break;
                            case 'asx':
                                $chart = [];
                                try {
                                    $chart = ASX::getChart($transaction->stock->symbol, $range);
                                    $chart = $chart->toArray();
                                    $chart = array_reverse($chart);
                                } catch (\Exception $e) {
                                }

                                for ($i = 0; $i < count($stock_data); $i++) {
                                    if ($stock_data[$i][0] > Carbon::createFromFormat('Y-m-d',  $transaction->created_at)->timestamp*1000) {
                                        if ($transaction->gcurrency != "USD") {
                                            for ($j = 0; $j < count($chart); $j++) {
                                                if ($chart[$j]['date'] == Carbon::createFromTimestamp($stock_data[$i][0])) {
                                                    $rate = $this->getExactRate($stock_data[$i][0], $all_rates['USD' . $transaction->gcurrency]);
                                                    if ($transaction->type == 'buy')
                                                        $stock_data[$i][1] = $stock_data[$i][1] + $chart[$j]['fClose'] * $transaction->shares;
                                                    else
                                                        $stock_data[$i][1] = $stock_data[$i][1] - $chart[$j]['fClose'] * $transaction->shares;
                                                    break;
                                                } else if ($stock_data[$i][0] > Carbon::createFromFormat('Y-m-d',  $chart[$j]['date'])->timestamp * 1000) {
                                                    $rate = $this->getExactRate($stock_data[$i][0], $all_rates['USD' . $transaction->gcurrency]);
                                                    if ($transaction->type == 'buy')
                                                        $stock_data[$i][1] = $stock_data[$i][1] + ($chart[$j]['fClose'] * $transaction->shares) / ($rate);
                                                    else
                                                        $stock_data[$i][1] = $stock_data[$i][1] - ($chart[$j]['fClose'] * $transaction->shares) / ($rate);
                                                    break;
                                                }
                                            }
                                        } else {
                                            for ($j = 0; $j < count($chart); $j++) {
                                                if ($chart[$j]['date'] == Carbon::createFromTimestamp($stock_data[$i][0])) {
                                                    if ($transaction->type == 'buy')
                                                        $stock_data[$i][1] = $stock_data[$i][1] + $chart[$j]['fClose'] * $transaction->shares;
                                                    else
                                                        $stock_data[$i][1] = $stock_data[$i][1] - $chart[$j]['fClose'] * $transaction->shares;
                                                    break;
                                                } else if ($stock_data[$i][0] > Carbon::createFromFormat('Y-m-d',  $chart[$j]['date'])->timestamp * 1000) {
                                                    if ($transaction->type == 'buy')
                                                        $stock_data[$i][1] = $stock_data[$i][1] + $chart[$j]['fClose'] * $transaction->shares;
                                                    else
                                                        $stock_data[$i][1] = $stock_data[$i][1] - $chart[$j]['fClose'] * $transaction->shares;
                                                    break;
                                                }
                                            }
                                        }
                                    } else {
                                        break;
                                    }
                                }
                                break;
                            case 'custom':
                                $chart = CustomStockData::chart($transaction->stock->symbol, $range);
                                $chart = $chart->toArray();
                                $chart = array_reverse($chart);
                                for ($i = 0; $i < count($stock_data); $i++) {
                                    if ($stock_data[$i][0] > Carbon::createFromFormat('Y-m-d',  $transaction->created_at)->timestamp*1000) {
                                        if ($transaction->gcurrency != "USD") {
                                            for ($j = 0; $j < count($chart); $j++) {
                                                if ($chart[$j]['date'] == Carbon::createFromTimestamp($stock_data[$i][0])) {
                                                    $rate = $this->getExactRate($stock_data[$i][0], $all_rates['USD' . $transaction->gcurrency]);
                                                    if ($transaction->type == 'buy')
                                                        $stock_data[$i][1] = $stock_data[$i][1] + $chart[$j]['fClose'] * $transaction->shares;
                                                    else
                                                        $stock_data[$i][1] = $stock_data[$i][1] - $chart[$j]['fClose'] * $transaction->shares;
                                                    break;
                                                } else if ($stock_data[$i][0] > Carbon::createFromFormat('Y-m-d',  $chart[$j]['date'])->timestamp * 1000) {
                                                    $rate = $this->getExactRate($stock_data[$i][0], $all_rates['USD' . $transaction->gcurrency]);
                                                    if ($transaction->type == 'buy')
                                                        $stock_data[$i][1] = $stock_data[$i][1] + ($chart[$j]['fClose'] * $transaction->shares) / ($rate);
                                                    else
                                                        $stock_data[$i][1] = $stock_data[$i][1] - ($chart[$j]['fClose'] * $transaction->shares) / ($rate);
                                                    break;
                                                }
                                            }
                                        } else {
                                            for ($j = 0; $j < count($chart); $j++) {
                                                if ($chart[$j]['date'] == Carbon::createFromTimestamp($stock_data[$i][0])) {
                                                    if ($transaction->type == 'buy')
                                                        $stock_data[$i][1] = $stock_data[$i][1] + $chart[$j]['fClose'] * $transaction->shares;
                                                    else
                                                        $stock_data[$i][1] = $stock_data[$i][1] - $chart[$j]['fClose'] * $transaction->shares;
                                                    break;
                                                } else if ($stock_data[$i][0] > Carbon::createFromFormat('Y-m-d',  $chart[$j]['date'])->timestamp * 1000) {
                                                    if ($transaction->type == 'buy')
                                                        $stock_data[$i][1] = $stock_data[$i][1] + $chart[$j]['fClose'] * $transaction->shares;
                                                    else
                                                        $stock_data[$i][1] = $stock_data[$i][1] - $chart[$j]['fClose'] * $transaction->shares;
                                                    break;
                                                }
                                            }
                                        }
                                    } else {
                                        break;
                                    }
                                }
                                break;
                        }
                    }
                } else if ($transaction->wherefrom == 1) {
                    if ($transaction->fund) {
                        // add detailed info
                        $transaction->gcurrency = $transaction->fund->gcurrency;
                        switch ($transaction->fund->data_source) {
                            case 'iex':
                                $chart = [];
                                try {
                                    if ($transaction->fund->exchange != "NAS") {
                                        $chart = IEX::getChart($transaction->fund->symbol, $range);
                                        $chart = $chart->toArray();
                                    }
                                    else
                                        $chart = ASX::getChart($transaction->fund->symbol, $range);
                                    $chart = array_reverse($chart);
                                } catch (\Exception $e) {
                                }
                                for ($i = 0; $i < count($fund_data); $i++) {
                                    if ($fund_data[$i][0] > Carbon::createFromFormat('Y-m-d',  $transaction->created_at)->timestamp*1000) {
                                        if ($transaction->gcurrency != "USD") {
                                            for ($j = 0; $j < count($chart); $j++) {
                                                if ($chart[$j]['date'] == Carbon::createFromTimestamp($fund_data[$i][0])) {
                                                    $rate = $this->getExactRate($fund_data[$i][0], $all_rates['USD' . $transaction->gcurrency]);
                                                    if ($transaction->type == 'buy')
                                                        $fund_data[$i][1] = $fund_data[$i][1] + ($transaction->fund->exchange == "NAS") ? $chart[$j]['adjClose'] * $transaction->shares  / ($rate) : $chart[$j]['fClose'] * $transaction->shares  / ($rate);
                                                    else
                                                        $fund_data[$i][1] = $fund_data[$i][1] - ($transaction->fund->exchange == "NAS") ? $chart[$j]['adjClose'] * $transaction->shares  / ($rate) : $chart[$j]['fClose'] * $transaction->shares  / ($rate);
                                                    break;
                                                } else if ($fund_data[$i][0] > Carbon::createFromFormat('Y-m-d',  $chart[$j]['date'])->timestamp * 1000) {
                                                    $rate = $this->getExactRate($fund_data[$i][0], $all_rates['USD' . $transaction->gcurrency]);
                                                    if ($transaction->type == 'buy')
                                                        $fund_data[$i][1] = $fund_data[$i][1] + ($transaction->fund->exchange == "NAS") ? $chart[$j]['adjClose'] * $transaction->shares  / ($rate) : $chart[$j]['fClose'] * $transaction->shares / ($rate);
                                                    else
                                                        $fund_data[$i][1] = $fund_data[$i][1] - ($transaction->fund->exchange == "NAS") ? $chart[$j]['adjClose'] * $transaction->shares  / ($rate) : $chart[$j]['fClose'] * $transaction->shares / ($rate);
                                                    break;
                                                }
                                            }
                                        } else {
                                            for ($j = 0; $j < count($chart); $j++) {
                                                if ($chart[$j]['date'] == Carbon::createFromTimestamp($fund_data[$i][0])) {
                                                    if ($transaction->type == 'buy')
                                                        $fund_data[$i][1] = $fund_data[$i][1] + ($transaction->fund->exchange == "NAS") ? $chart[$j]['adjClose'] * $transaction->shares : $chart[$j]['fClose'] * $transaction->shares;
                                                    else
                                                        $fund_data[$i][1] = $fund_data[$i][1] - ($transaction->fund->exchange == "NAS") ? $chart[$j]['adjClose'] * $transaction->shares : $chart[$j]['fClose'] * $transaction->shares;
                                                    break;
                                                } else if ($fund_data[$i][0] > Carbon::createFromFormat('Y-m-d',  $chart[$j]['date'])->timestamp * 1000) {
                                                    if ($transaction->type == 'buy')
                                                        $fund_data[$i][1] = $fund_data[$i][1] + ($transaction->fund->exchange == "NAS") ? $chart[$j]['adjClose'] * $transaction->shares : $chart[$j]['fClose'] * $transaction->shares;
                                                    else
                                                        $fund_data[$i][1] = $fund_data[$i][1] - ($transaction->fund->exchange == "NAS") ? $chart[$j]['adjClose'] * $transaction->shares : $chart[$j]['fClose'] * $transaction->shares;
                                                    break;
                                                }
                                            }
                                        }
                                    } else {
                                        break;
                                    }
                                }
                                break;
                            case 'asx':
                                $chart = ASX::getChart($transaction->fund->symbol, $range);
                                $chart = $chart->toArray();
                                $chart = array_reverse($chart);
                                for ($i = 0; $i < count($fund_data); $i++) {
                                    if ($fund_data[$i][0] > Carbon::createFromFormat('Y-m-d',  $transaction->created_at)->timestamp*1000) {
                                        if ($transaction->gcurrency != "USD") {
                                            for ($j = 0; $j < count($chart); $j++) {
                                                if ($chart[$j]['date'] == Carbon::createFromTimestamp($fund_data[$i][0])) {
                                                    $rate = $this->getExactRate($fund_data[$i][0], $all_rates['USD' . $transaction->gcurrency]);
                                                    if ($transaction->type == 'buy')
                                                        $fund_data[$i][1] = $fund_data[$i][1] + $chart[$j]['adjClose'] * $transaction->shares  / ($rate);
                                                    else
                                                        $fund_data[$i][1] = $fund_data[$i][1] - $chart[$j]['adjClose'] * $transaction->shares  / ($rate);
                                                    break;
                                                } else if ($fund_data[$i][0] > Carbon::createFromFormat('Y-m-d',  $chart[$j]['date'])->timestamp * 1000) {
                                                    $rate = $this->getExactRate($fund_data[$i][0], $all_rates['USD' . $transaction->gcurrency]);
                                                    if ($transaction->type == 'buy')
                                                        $fund_data[$i][1] = $fund_data[$i][1] + $chart[$j]['adjClose'] * $transaction->shares  / ($rate);
                                                    else
                                                        $fund_data[$i][1] = $fund_data[$i][1] - $chart[$j]['adjClose'] * $transaction->shares  / ($rate);
                                                    break;
                                                }
                                            }
                                        } else {
                                            for ($j = 0; $j < count($chart); $j++) {
                                                if ($chart[$j]['date'] == Carbon::createFromTimestamp($fund_data[$i][0])) {
                                                    if ($transaction->type == 'buy')
                                                        $fund_data[$i][1] = $fund_data[$i][1] + $chart[$j]['adjClose'] * $transaction->shares;
                                                    else
                                                        $fund_data[$i][1] = $fund_data[$i][1] - $chart[$j]['adjClose'] * $transaction->shares;
                                                    break;
                                                } else if ($fund_data[$i][0] > Carbon::createFromFormat('Y-m-d',  $chart[$j]['date'])->timestamp * 1000) {
                                                    if ($transaction->type == 'buy')
                                                        $fund_data[$i][1] = $fund_data[$i][1] + $chart[$j]['adjClose'] * $transaction->shares;
                                                    else
                                                        $fund_data[$i][1] = $fund_data[$i][1] - $chart[$j]['adjClose'] * $transaction->shares;
                                                    break;
                                                }
                                            }
                                        }
                                    } else {
                                        break;
                                    }
                                }
                                break;
                            case 'custom':
                                $chart = CustomFundData::chart($transaction->fund->symbol, $range);
                                $chart = $chart->toArray();
                                $chart = array_reverse($chart);
                                for ($i = 0; $i < count($fund_data); $i++) {
                                    if ($fund_data[$i][0] > Carbon::createFromFormat('Y-m-d',  $transaction->created_at)->timestamp*1000) {
                                        if ($transaction->gcurrency != "USD") {
                                            for ($j = 0; $j < count($chart); $j++) {
                                                if ($chart[$j]['date'] == Carbon::createFromTimestamp($fund_data[$i][0])) {
                                                    $rate = $this->getExactRate($fund_data[$i][0], $all_rates['USD' . $transaction->gcurrency]);
                                                    if ($transaction->type == 'buy')
                                                        $fund_data[$i][1] = $fund_data[$i][1] + $chart[$j]['fClose'] * $transaction->shares  / ($rate);
                                                    else
                                                        $fund_data[$i][1] = $fund_data[$i][1] - $chart[$j]['fClose'] * $transaction->shares  / ($rate);
                                                    break;
                                                } else if ($fund_data[$i][0] > Carbon::createFromFormat('Y-m-d',  $chart[$j]['date'])->timestamp * 1000) {
                                                    $rate = $this->getExactRate($fund_data[$i][0], $all_rates['USD' . $transaction->gcurrency]);
                                                    if ($transaction->type == 'buy')
                                                        $fund_data[$i][1] = $fund_data[$i][1] + $chart[$j]['fClose'] * $transaction->shares  / ($rate);
                                                    else
                                                        $fund_data[$i][1] = $fund_data[$i][1] - $chart[$j]['fClose'] * $transaction->shares  / ($rate);
                                                    break;
                                                }
                                            }
                                        } else {
                                            for ($j = 0; $j < count($chart); $j++) {
                                                if ($chart[$j]['date'] == Carbon::createFromTimestamp($fund_data[$i][0])) {
                                                    if ($transaction->type == 'buy')
                                                        $fund_data[$i][1] = $fund_data[$i][1] + $chart[$j]['fClose'] * $transaction->shares;
                                                    else
                                                        $fund_data[$i][1] = $fund_data[$i][1] - $chart[$j]['fClose'] * $transaction->shares;
                                                    break;
                                                } else if ($fund_data[$i][0] > Carbon::createFromFormat('Y-m-d',  $chart[$j]['date'])->timestamp * 1000) {
                                                    if ($transaction->type == 'buy')
                                                        $fund_data[$i][1] = $fund_data[$i][1] + $chart[$j]['fClose'] * $transaction->shares;
                                                    else
                                                        $fund_data[$i][1] = $fund_data[$i][1] - $chart[$j]['fClose'] * $transaction->shares;
                                                    break;
                                                }
                                            }
                                        }
                                    } else {
                                        break;
                                    }
                                }
                                break;
                        }
                    }
                } else if ($transaction->wherefrom == 2) {
                    if ($transaction->bond) {
                        $transaction->gcurrency = $transaction->bond->gcurrency;
                        switch ($transaction->bond->data_source) {
                            case 'asx':
                                $chart = ASX::getBChart($transaction->bond->id, $range);
                                for ($i = 0; $i < count($bond_data); $i++) {
                                    if ($bond_data[$i][0] > Carbon::createFromFormat('Y-m-d',  $transaction->created_at)->timestamp*1000) {
                                        for ($j = 0; $j < count($chart); $j++) {
                                            if ($chart[$j]['date'] == Carbon::createFromTimestamp($bond_data[$i][0])) {
                                                $rate = $this->getExactRate($bond_data[$i][0], $all_rates['USDAUD']);
                                                if ($transaction->type == 'buy')
                                                    $bond_data[$i][1] = $bond_data[$i][1] + $chart[$j]['fClose'] * $transaction->shares  / ($rate);
                                                else
                                                    $bond_data[$i][1] = $bond_data[$i][1] - $chart[$j]['fClose'] * $transaction->shares  / ($rate);
                                                break;
                                            } else if ($bond_data[$i][0] > Carbon::createFromFormat('Y-m-d',  $chart[$j]['date'])->timestamp * 1000) {
                                                $rate = $this->getExactRate($bond_data[$i][0], $all_rates['USDAUD']);
                                                if ($transaction->type == 'buy')
                                                    $bond_data[$i][1] = $bond_data[$i][1] + $chart[$j]['fClose'] * $transaction->shares  / ($rate);
                                                else
                                                    $bond_data[$i][1] = $bond_data[$i][1] - $chart[$j]['fClose'] * $transaction->shares  / ($rate);
                                                break;
                                            }
                                        }
                                    } else {
                                        break;
                                    }
                                }
                                break;
                            case 'custom':
                                $chart = CustomBondData::chart($transaction->bond->id, $range);
                                $chart = $chart->toArray();
                                $chart = array_reverse($chart);
                                for ($i = 0; $i < count($bond_data); $i++) {
                                    if ($bond_data[$i][0] > Carbon::createFromFormat('Y-m-d',  $transaction->created_at)->timestamp*1000) {
                                        if ($transaction->gcurrency != "USD") {
                                            for ($j = 0; $j < count($chart); $j++) {
                                                if ($chart[$j]['date'] == Carbon::createFromTimestamp($bond_data[$i][0])) {
                                                    $rate = $this->getExactRate($bond_data[$i][0], $all_rates['USD' . $transaction->gcurrency]);
                                                    if ($transaction->type == 'buy')
                                                        $bond_data[$i][1] = $bond_data[$i][1] + $chart[$j]['fClose'] * $transaction->shares  / ($rate);
                                                    else
                                                        $bond_data[$i][1] = $bond_data[$i][1] - $chart[$j]['fClose'] * $transaction->shares  / ($rate);
                                                    break;
                                                } else if ($bond_data[$i][0] > Carbon::createFromFormat('Y-m-d',  $chart[$j]['date'])->timestamp * 1000) {
                                                    $rate = $this->getExactRate($bond_data[$i][0], $all_rates['USD' . $transaction->gcurrency]);
                                                    if ($transaction->type == 'buy')
                                                        $bond_data[$i][1] = $bond_data[$i][1] + $chart[$j]['fClose'] * $transaction->shares  / ($rate);
                                                    else
                                                        $bond_data[$i][1] = $bond_data[$i][1] - $chart[$j]['fClose'] * $transaction->shares  / ($rate);
                                                    break;
                                                }
                                            }
                                        } else {
                                            for ($j = 0; $j < count($chart); $j++) {
                                                if ($chart[$j]['date'] == Carbon::createFromTimestamp($bond_data[$i][0])) {
                                                    if ($transaction->type == 'buy')
                                                        $bond_data[$i][1] = $bond_data[$i][1] + $chart[$j]['fClose'] * $transaction->shares;
                                                    else
                                                        $bond_data[$i][1] = $bond_data[$i][1] - $chart[$j]['fClose'] * $transaction->shares;
                                                    break;
                                                } else if ($bond_data[$i][0] > Carbon::createFromFormat('Y-m-d',  $chart[$j]['date'])->timestamp * 1000) {
                                                    if ($transaction->type == 'buy')
                                                        $bond_data[$i][1] = $bond_data[$i][1] + $chart[$j]['fClose'] * $transaction->shares;
                                                    else
                                                        $bond_data[$i][1] = $bond_data[$i][1] - $chart[$j]['fClose'] * $transaction->shares;
                                                    break;
                                                }
                                            }
                                        }
                                    } else {
                                        break;
                                    }
                                }
                        }
                    }
                } else if ($transaction->wherefrom == 3) {
                    if ($transaction->crypto) {
                        $transaction->gcurrency = $transaction->crypto->gcurrency;
                        switch ($transaction->crypto->data_source) {
                            case 'gecko':
                                $chart = Cache::remember('crypto:detail-gecko-chart-' . $transaction->crypto->coin_id . $range, 11, function () use ($transaction, $range) {
                                    return ASX::getCChart($transaction->crypto->coin_id, $range);
                                });
                                $chart = array_reverse($chart);
                                for ($i = 0; $i < count($crypto_data); $i++) {
                                    if ($crypto_data[$i][0] > Carbon::createFromFormat('Y-m-d',  $transaction->created_at)->timestamp*1000) {
                                        for ($j = 0; $j < count($chart); $j++) {
                                            if (Carbon::createFromTimestamp($chart[$j][0]/1000)->format('Y-m-d') == Carbon::createFromTimestamp($crypto_data[$i][0])->format('Y-m-d')) {
                                                if ($transaction->type == 'buy')
                                                    $crypto_data[$i][1] = $crypto_data[$i][1] + $chart[$j][1] * $transaction->shares;
                                                else
                                                    $crypto_data[$i][1] = $crypto_data[$i][1] - $chart[$j][1] * $transaction->shares;
                                                break;
                                            } else if ($crypto_data[$i][0] > $chart[$j][0]) {
                                                if ($transaction->type == 'buy')
                                                    $crypto_data[$i][1] = $crypto_data[$i][1] + $chart[$j][1] * $transaction->shares;
                                                else
                                                    $crypto_data[$i][1] = $crypto_data[$i][1] - $chart[$j][1] * $transaction->shares;
                                                break;
                                            }
                                        }
                                    } else {
                                        break;
                                    }
                                }
                                break;
                            case 'custom':
                                $chart = CustomCryptoData::chart($transaction->crypto->symbol, $range);
                                $chart = $chart->toArray();
                                $chart = array_reverse($chart);
                                for ($i = 0; $i < count($crypto_data); $i++) {
                                    if ($crypto_data[$i][0] > Carbon::createFromFormat('Y-m-d',  $transaction->created_at)->timestamp*1000) {
                                        for ($j = 0; $j < count($chart); $j++) {
                                            if (Carbon::createFromTimestamp($chart[$j][0]/1000)->format('Y-m-d') == Carbon::createFromTimestamp($crypto_data[$i][0])->format('Y-m-d')) {
                                                if ($transaction->type == 'buy')
                                                    $crypto_data[$i][1] = $crypto_data[$i][1] + $chart[$j][1] * $transaction->shares;
                                                else
                                                    $crypto_data[$i][1] = $crypto_data[$i][1] - $chart[$j][1] * $transaction->shares;
                                                break;
                                            } else if ($crypto_data[$i][0] > $chart[$j][0]) {
                                                if ($transaction->type == 'buy')
                                                    $crypto_data[$i][1] = $crypto_data[$i][1] + $chart[$j][1] * $transaction->shares;
                                                else
                                                    $crypto_data[$i][1] = $crypto_data[$i][1] - $chart[$j][1] * $transaction->shares;
                                                break;
                                            }
                                        }
                                    } else {
                                        break;
                                    }
                                }
                        }
                    }
                }
            }

            $stock_data = array_reverse($stock_data);
            $fund_data = array_reverse($fund_data);
            $bond_data = array_reverse($bond_data);
            $crypto_data = array_reverse($crypto_data);

            /**
             * Return Json
             */
            return response()->json([
                'success' => true,
                'stock_data' => $stock_data,
                'fund_data' => $fund_data,
                'bond_data' => $bond_data,
                'crypto_data' => $crypto_data,
            ]);
        } else {
            /**
             * Return Json
             */
            return response()->json([
                'success' => false,
                'data' => [],
            ]);
        }
    }

    public function getExactRate($data_timestamp, $rate_arr)
    {
        for ($i = 0; $i < count($rate_arr); $i++) {
            if ($rate_arr[$i][0] < $data_timestamp)
                return $rate_arr[$i][1];
        }

        return $rate_arr[count($rate_arr) - 1][1];
    }
}
