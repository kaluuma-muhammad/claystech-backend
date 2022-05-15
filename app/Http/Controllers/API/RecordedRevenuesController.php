<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Client;
use App\Models\Revenue;
use App\Models\RecordedRevenue;

class RecordedRevenuesController extends Controller
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
        $clients = Client::where('status', 1)->get();
        $revenues = Revenue::where('status', 1)->get();
        $r_revenues = RecordedRevenue::with('user')->with('client')->with('revenue')->
        where('status', 1)->orderBy('id', 'DESC')->get();

        $response = [
            'clients' => $clients,
            'revenues' => $revenues,
            'r_revenues' => $r_revenues
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
            'client_id' => 'required|integer',
            'revenue_id' => 'required|integer',
            'revenue_type' => 'required|string',
            'rent_from' => '',
            'rent_to' => '',
            'paid_amount' => 'required|integer'
        ]);

        $rev = $request['revenue_id'];
        $revId = Revenue::find($rev);

        $from = strtotime($request['rent_from']);
        $to = strtotime($request['rent_to']);
        
        $diff = abs($to - $from);
        $t_period  = $diff/60/60/24/30;
        $time = (int) $t_period;
        

        if ($request['revenue_type'] == 'Sell') {
            $tt_amt = $revId->sell_amount;
            $period = Null;

            $from = Null;
            $to = Null;
        } else {
            $from = $request['rent_from'];
            $to = $request['rent_to'];

            $amt = $revId->rent_amount;
            $tt_amt = $time * $amt;
            $period = $time;
        }

        $paid_amt = $request['paid_amount'];
        $balance = $tt_amt - $paid_amt;

        $revevue = RecordedRevenue::create([
            'revenue_id' => $rev,
            'client_id' => $request['client_id'],
            'revenue_type' => $request['revenue_type'],
            'period' => $period,
            'total_amount' => $tt_amt,
            'rent_from' => $from,
            'rent_to' => $to,
            'paid_amount' => $paid_amt,
            'balance' => $balance,
            'recorded_by' => Auth::user()->id,
        ]);

        return $revevue;
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
            'client_id' => 'required|integer',
            'revenue_id' => 'required|integer',
            'revenue_type' => 'required|string',
            'rent_from' => '',
            'rent_to' => '',
            'paid_amount' => 'required|integer'
        ]);

        $rev = $request['revenue_id'];
        $revId = Revenue::find($rev);

        $from = strtotime($request['rent_from']);
        $to = strtotime($request['rent_to']);
        
        $diff = abs($to - $from);
        $t_period  = $diff/60/60/24/30;
        $time = (int) $t_period;
        

        if ($request['revenue_type'] == 'Sell') {
            $tt_amt = $revId->sell_amount;
            $period = Null;

            $from = Null;
            $to = Null;
        } else {
            $from = $request['rent_from'];
            $to = $request['rent_to'];

            $amt = $revId->rent_amount;
            $tt_amt = $time * $amt;
            $period = $time;
        }

        $r_rev = RecordedRevenue::find($id);
        $rr_paid = $r_rev->paid_amount;

        $paid_amt = $request['paid_amount'] + $rr_paid;
        $balance = $tt_amt - $paid_amt;

        $revevue = RecordedRevenue::where('id', $id)->update([
            'revenue_id' => $rev,
            'client_id' => $request['client_id'],
            'revenue_type' => $request['revenue_type'],
            'period' => $period,
            'total_amount' => $tt_amt,
            'rent_from' => $from,
            'rent_to' => $to,
            'paid_amount' => $paid_amt,
            'balance' => $balance
        ]);

        return $revevue;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $revevue = RecordedRevenue::where('id', $id)->update([
            'status' => 0
        ]);

        return $revevue;
    }
}
