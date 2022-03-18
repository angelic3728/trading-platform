<?php

namespace App\Console\Commands\IEX;

use Illuminate\Console\Command;

use IEX;

use App\Stock;
use App\MutualFund;
use App\CryptoCurrency;

class ImportStocks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'iex:import-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import IEX Stocks, Funds and Cryptos';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        /**
         * Get stocks
         */
        // $stocks = IEX::getAvailableSymbols();
        // /**
        //  * Loop through US stock symbols and insert them
        //  */
        // foreach ($stocks as $item) {
        //     $stock = new Stock;
        //     $stock->symbol = $item['symbol'];
        //     $stock->company_name = $item['company_name'];
        //     $stock->link = 'https://finance.yahoo.com/quote/' . $item['symbol'] . '?p=' . $item['symbol'];
        //     $stock->data_source = 'iex';
        //     $stock->gcurrency = $item['currency'];
        //     $stock->exchange = $item['exchange'];
        //     $stock->save();
        // }

        // $lstocks = IEX::getAvailableLSESymbols();
        // /**
        //  * Loop through symbols and insert them
        //  */
        // foreach ($lstocks as $item) {
        //     $modified_symbol = str_replace("-LN", "", $item['symbol']);
        //     $stock = new Stock();
        //     $stock->symbol = $item['symbol'];
        //     $stock->company_name = $item['company_name'];
        //     $stock->link = 'https://www.londonstockexchange.com/stock/' . $modified_symbol . '/sample/company-page';
        //     $stock->data_source = 'iex';
        //     $stock->gcurrency = $item['currency'];
        //     $stock->exchange = $item['exchange'];
        //     $stock->save();
        // }

        // $mfds = IEX::getAvailableMFDSymbols();

        // /**
        //  * Loop through etf symbols and insert them
        //  */
        // foreach ($mfds as $item) {

        //     $fund = new MutualFund();
        //     $fund->symbol = $item['symbol'];
        //     $fund->company_name = $item['company_name'];
        //     $fund->link = 'https://finance.yahoo.com/quote/' . $item['symbol'] . '?p=' . $item['symbol'];
        //     $fund->data_source = 'iex';
        //     $fund->gcurrency = $item['currency'];
        //     $fund->exchange = $item['exchange'];
        //     $fund->save();
        // }

        // $etfs = IEX::getAvailableETFSymbols();

        // /**
        //  * Loop through etf symbols and insert them
        //  */
        // foreach ($etfs as $item) {

        //     $fund = new MutualFund();
        //     $fund->symbol = $item['symbol'];
        //     $fund->company_name = $item['company_name'];
        //     $fund->link = 'https://finance.yahoo.com/quote/' . $item['symbol'] . '?p=' . $item['symbol'];
        //     $fund->data_source = 'iex';
        //     $fund->gcurrency = $item['currency'];
        //     $fund->exchange = $item['exchange'];
        //     $fund->save();
        // }

        $cryptos = IEX::getAvailableCryptoSymbols();

        foreach ($cryptos as $item) {
            $crypto = new CryptoCurrency();
            $crypto->symbol = $item['symbol'];
            $crypto->name = $item['name'];
            $crypto->coin_id = $item['coin_id'];
            $crypto->link = 'https://finance.yahoo.com/quote/' . $item['msymbol'] . '?p=' . $item['msymbol'];
            $crypto->data_source = 'gecko';
            $crypto->gcurrency = $item['currency'];
            $crypto->save();
        }
    }
}
