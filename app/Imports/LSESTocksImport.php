<?php

namespace App\Imports;

use App\Stock;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LSEStocksImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Stock([
           'company_name' => $row['company_name'],
           'symbol' => $row['symbol'].'.L',
           'discount_percentage' => str_replace('%', '', $row['discount_percentage']),
           'link' => $row['link'],
           'data_source' => 'iex',
           'exchange' => 'LSE',
        ]);
    }
}
