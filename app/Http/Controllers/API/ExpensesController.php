<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Expense;
class ExpensesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = Expense::with('user')->where('status', 1)->orderBy('id', 'DESC')->get();

        return $expenses;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'expense_name' => 'required|string',
            'expense_amount' => 'required|integer',
            'quantity' => 'required|integer'
        ]);

        $total_amt = $request['expense_amount'] * $request['quantity'];

        $expense = Expense::create([
            'expense_name' => $request['expense_name'],
            'expense_amount' => $request['expense_amount'],
            'quantity' => $request['quantity'],
            'total_amount' => $total_amt,
            'recorded_by' => Auth::user()->id,
        ]);

        return $expense;
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'expense_name' => 'required|string',
            'expense_amount' => 'required|integer',
            'quantity' => 'required|integer'
        ]);

        $total_amt = $request['expense_amount'] * $request['quantity'];

        $expense = Expense::where('id', $id)->update([
            'expense_name' => $request['expense_name'],
            'expense_amount' => $request['expense_amount'],
            'quantity' => $request['quantity'],
            'total_amount' => $total_amt
        ]);

        return $expense;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::where('id', $id)->update([
            'status' => 0,
        ]);

        return $expense;
    }
}
