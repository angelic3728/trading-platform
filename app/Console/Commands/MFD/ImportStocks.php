<?php

namespace App\Console\Commands\MFD;

use Illuminate\Console\Command;

use IEX;

use App\MutualFunds;

class ImportStocks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mfd:import-stocks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Mutual Funds Stocks';

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
        $stocks = IEX::getAvailableMFDSymbols();
        /**
         * Loop through symbols and insert them
         */
        foreach($stocks as $item){

            $stock = new MutualFunds();
            $stock->symbol = $item['symbol'];
            $stock->company_name = $item['company_name'];
            $stock->link = 'https://finance.yahoo.com/quote/'.$item['symbol'].'?p='.$item['symbol'];
            $stock->data_source = 'iex';
            $stock->save();

        }

    }
}
