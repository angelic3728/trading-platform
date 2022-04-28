<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use IEX;

class NewsController extends Controller
{

    public function overview(Request $request)
    {
        /**
         * Get Account Manager
         */
        $account_manager = auth()->user()->account_manager;
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
        $news = IEX::getRecentNews($symbols);

        /**
         * Return news
         */
        return view('dashboard.news', [
            'news' => $news,
            'account_manager' => $account_manager,
        ]);

    }

}
