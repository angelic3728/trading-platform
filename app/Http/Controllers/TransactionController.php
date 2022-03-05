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
            ->where('is_fund', '=', 0)
            ->with('stock')
            ->join('stocks', 'transactions.stock_id', '=', 'stocks.id')
            ->select('transactions.*', 'stocks.symbol', 'stocks.company_name')
            ->get();

        $transactions2 = Transaction::where('user_id', auth()->id())
            ->where('is_fund', '=', 1)
            ->with('mutualFund')
            ->join('mutual_funds', 'transactions.mutual_fund_id', '=', 'mutual_funds.id')
            ->select('transactions.*', 'mutual_funds.symbol', 'mutual_funds.company_name')
            ->get();


        $merged = $transactions1->merge($transactions2);
        $transactions = $merged->all();
        /**
         * Return view
         */
        return view('dashboard.transactions.all', [
            'transactions' => $transactions,
            'account_manager' => $account_manager,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
