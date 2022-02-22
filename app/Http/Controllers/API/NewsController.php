<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use IEX;
use DB;

use App\Transaction;

class NewsController extends Controller
{

    public function overview(Request $request)
    {

        /**
         * Get Symbols
         */
        $symbols = explode(',', $request->symbols);

        /**
         * Get recent news
         */
        $news = IEX::getRecentNews($symbols, $request->limit);

        /**
         * Return news
         */
        return response()->json([
            'success' => true,
            'data' => $news,
        ]);

    }

}
