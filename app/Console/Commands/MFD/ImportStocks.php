<?php

namespace App\Console\Commands\MFD;

use Illuminate\Console\Command;

use IEX;

use App\MutualFund;

class ImportStocks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mfd:import-funds';

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
        $mfds = IEX::getAvailableMFDSymbols();
        /**
         * Loop through symbols and insert them
         */
        foreach($mfds as $item){

            $mfd = new MutualFund();
            $mfd->symbol = $item['symbol'];
            $mfd->company_name = $item['company_name'];
            $mfd->exchange = $item['exchange'];
            $mfd->currency = $item['currency'];
            $mfd->link = 'https://finance.yahoo.com/quote/'.$item['symbol'].'?p='.$item['symbol'];
            $mfd->data_source = 'iex';
            $mfd->save();

        }

    }
}
