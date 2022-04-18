<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Transaction;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**
         * Get Account Manager
         */
        $account_manager = auth()->user()->account_manager;

        /**
         * Get all transactions
         */
        $transactions1 = Transaction::where('user_id', auth()->id())
            ->where('wherefrom', '=', 0)
            ->with('stock')
            ->join('stocks', 'transactions.stock_id', '=', 'stocks.id')
            ->select('transactions.*', 'stocks.symbol', 'stocks.company_name')
            ->get();

        $transactions2 = Transaction::where('user_id', auth()->id())
            ->where('wherefrom', '=', 1)
            ->with('fund')
            ->join('funds', 'transactions.fund_id', '=', 'funds.id')
            ->select('transactions.*', 'funds.symbol', 'funds.company_name')
            ->get();

        $transactions3 = Transaction::where('user_id', auth()->id())
            ->where('wherefrom', '=', 2)
            ->with('bond')
            ->join('bonds', 'transactions.bond_id', '=', 'bonds.id')
            ->select('transactions.*', 'bonds.symbol', 'bonds.name')
            ->get();

        $transactions4 = Transaction::where('user_id', auth()->id())
            ->where('wherefrom', '=', 3)
            ->with('crypto')
            ->join('crypto_currencies', 'transactions.crypto_id', '=', 'crypto_currencies.id')
            ->select('transactions.*', 'crypto_currencies.symbol', 'crypto_currencies.name')
            ->get();

        $merged = $transactions1->merge($transactions2);
        $transactions = $merged->merge($transactions3);
        $transactions = $transactions->merge($transactions4);
        $transactions = $transactions->all();
        /**
         * Return view
         */
        return view('dashboard.transactions.all', [
            'transactions' => $transactions,
            'account_manager' => $account_manager,
        ]);
    }
}
