<?php

namespace App\Console\Commands\ASX;

use Illuminate\Console\Command;

use ASX;

use App\Stock;

class ImportStocks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'asx:import-stocks';

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

            $stock = new Stock;
            $stock->symbol = $item['symbol'];
            $stock->company_name = $item['company_name'];
            $stock->link = 'https://finance.yahoo.com/quote/' . $item['symbol'] . '?p=' . $item['symbol'];
            $stock->data_source = 'asx';
            $stock->currency = $item['currency'];
            $stock->exchange = $item['exchange'];
            $stock->save();
        }
    }
}
