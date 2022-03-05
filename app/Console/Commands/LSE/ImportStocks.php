<?php

namespace App\Console\Commands\LSE;

use Illuminate\Console\Command;
use IEX;
use App\Stock;

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
  protected $description = 'Imports IEX LONDON stocks';

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
    $stocks = IEX::getAvailableLSESymbols();
    /**
     * Loop through symbols and insert them
     */
    foreach ($stocks as $item) {

      $modified_symbol = str_replace("-LN", "", $item['symbol']);

      $stock = new Stock;
      $stock->symbol = $item['symbol'];
      $stock->company_name = $item['company_name'];
      $stock->link = 'https://www.londonstockexchange.com/stock/' . $modified_symbol . '/sample/company-page';
      $stock->data_source = 'iex';
      $stock->currency = $item['currency'];
      $stock->exchange = $item['exchange'];
      $stock->save();
    }
  }
}
