<?php

namespace App\Console\Commands\LSE;

use Illuminate\Console\Command;

use Excel;

class ImportStocks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lse:import-stocks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports Stocks from LSE Csv';

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
      Excel::import(new \App\Imports\LSEStocksImport, base_path('lse-stocks.csv'));

    }
}
