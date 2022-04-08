<?php

namespace App\Http\Controllers;

use IEX;
use ASX;
use CustomStockData;
use CustomFundData;
use Cache;

use App\Http\Controllers\API\StockController;
use App\Http\Controllers\API\FundsController;
use App\Http\Controllers\API\CryptosController;

class FormsController extends Controller
{

    public function index()
    {

        // Get all highlights
        $stock_highlights = StockController::highlights(4)->getData();
        $fund_highlights = FundsController::highlights(4)->getData();
        $crypto_highlights = CryptosController::highlights(4)->getData();

        $all_highlights = array_merge($stock_highlights->data, $fund_highlights->data);
        $all_highlights = array_merge($all_highlights, $crypto_highlights->data);        

        /**
         * Return view
         */
        return view('forms.main', [
            'all_highlights' => $all_highlights,
        ]);
    }

    public function equities()
    {
        return view('forms.equities');
    }
}
