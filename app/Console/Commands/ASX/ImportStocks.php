<?php

namespace App\Console\Commands\ASX;

use Illuminate\Console\Command;

use ASX;

use App\Stock;
use App\Fund;
use App\Bond;

class ImportStocks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asx:import-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Australia Stocks';

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
        $stocks = ASX::getAvailableSymbols();
        /**
         * Loop through symbols and insert them
         */
        foreach ($stocks as $item) {
            $stock = new Stock();
            $stock->symbol = $item['symbol'];
            $stock->company_name = $item['company_name'];
            $stock->link = 'https://finance.yahoo.com/quote/' . $item['symbol'] . '?p=' . $item['symbol'];
            $stock->data_source = 'asx';
            $stock->gcurrency = $item['currency'];
            $stock->exchange = $item['exchange'];
            $stock->save();
        }

        $funds = ASX::getAvailableMFDSymbols();
        /**
         * Loop through fund symbols and insert them
         */
        foreach ($funds as $item) {
            $fund = new Fund();
            $fund->symbol = $item['symbol'];
            $fund->company_name = $item['company_name'];
            $fund->link = 'https://finance.yahoo.com/quote/' . $item['symbol'] . '?p=' . $item['symbol'];
            $fund->data_source = 'asx';
            $fund->gcurrency = $item['currency'];
            $fund->exchange = $item['exchange'];
            $fund->save();
        }

        $bonds = ASX::getAvailableBondCodes();

        foreach ($bonds as $item) {
            $bond = new Bond();
            $bond->symbol = $item['code'];
            $bond->name = $item['name'];
            $bond->data_source = 'asx';
            $bond->gcurrency = 'AUD';
            $bond->exchange = $item['exchange'];
            $bond->link = ($item['exchange'] == "XTB")?'https://xtbs.com.au/xtbs-profile/'.$item['code']:'https://finance.yahoo.com/quote/'.$item['code'].'.AX';
            $bond->is_indexed = $item['is_indexed'];
            $bond->save();
        }
    }
}
