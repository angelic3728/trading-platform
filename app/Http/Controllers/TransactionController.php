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
         * Get all transactions
         */
        $transactions = Transaction::where('user_id', auth()->id())
                            ->with('stock')
                            ->join('stocks', 'transactions.stock_id', '=', 'stocks.id')
                            ->select('transactions.*', 'stocks.symbol', 'stocks.company_name')
                            ->when($request->q, function ($query) use ($request) {
                                return $query->where(function($query) use ($request){
                                    $query->where('transactions.shares', 'LIKE', "%$request->q%")
                                          ->orWhere('transactions.price','LIKE', "%$request->q%")
                                          ->orWhere('transactions.type','LIKE', "%$request->q%")
                                          ->orWhere('stocks.symbol','LIKE', "%$request->q%")
                                          ->orWhere('stocks.company_name','LIKE', "%$request->q%");
                                });
                            })
                            ->latest()
                            ->paginate(10);

        /**
         * Return view
         */
        return view('dashboard.transactions.all', [
            'transactions' => $transactions,
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
