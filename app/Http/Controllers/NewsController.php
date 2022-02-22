<?php

namespace App\Http\Controllers;

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
         * If there are no symbols, go to overview
         */
        if(!$request->filled('symbols')){

            return redirect()->route('overview');

        }

        /**
         * Get Symbols
         */
        $symbols = explode(',', $request->symbols);

        /**
         * Get recent news
         */
        $news = IEX::getRecentNews($symbols, 100);

        /**
         * Return news
         */
        return view('dashboard.news', [
            'news' => $news,
        ]);

    }

}
