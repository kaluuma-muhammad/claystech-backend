<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Payment;

class PaymentsController extends Controller
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
        $employees = Employee::where('status', 1)->get();
        $payments = Payment::with('user')->with('employee')->where('status', 1)->orderBy('id', 'DESC')->get();

        $response = [
            'employees' => $employees,
            'payments' => $payments
        ];

        return $response;
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
            'employee_id' => 'required|integer',
            'paid_amount' => 'required|integer',
            'payment_method' => 'required|string',
            'account_num' => ''
        ]);

        $employee = Employee::find($request['employee_id']);
        $salary = $employee->salary;
        $paid_amt = $request['paid_amount'];

        $balance = $salary - $paid_amt;

        if ($request['payment_method'] == 'PayPal' || $request['payment_method'] == 'Cheque') {
            $account_num = $request['account_num'];
        } else {
            $account_num = Null;
        }

        $payment = Payment::create([
            'employee_id' => $request['employee_id'],
            'salary' => $salary,
            'payment_method' => $request['payment_method'],
            'account_num' => $account_num,
            'paid_amount' => $request['paid_amount'],
            'balance' => $balance,
            'recorded_by' => Auth::user()->id
        ]);

        return $payment;
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
            'employee_id' => 'required|integer',
            'paid_amount' => 'required|integer',
            'payment_method' => 'required|string',
            'account_num' => ''
        ]);

        $employee = Employee::find($request['employee_id']);
        $salary = $employee->salary;

        $p_amt = Payment::find($id);
        $paid = $p_amt->paid_amount;
        $paid_amt = $request['paid_amount'];
        $tt_paid_amt = $paid + $paid_amt;

        $balance = $salary - $tt_paid_amt;

        if ($request['payment_method'] == 'PayPal' || $request['payment_method'] == 'Cheque') {
            $account_num = $request['account_num'];
        } else {
            $account_num = Null;
        }

        $payment = Payment::where('id', $id)->update([
            'employee_id' => $request['employee_id'],
            'salary' => $salary,
            'payment_method' => $request['payment_method'],
            'account_num' => $account_num,
            'paid_amount' => $tt_paid_amt,
            'balance' => $balance
        ]);

        return $payment;
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
