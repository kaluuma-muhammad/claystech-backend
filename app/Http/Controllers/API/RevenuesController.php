<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Revenue;

class RevenuesController extends Controller
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
        $products = Project::where('status', 1)->get();
        $revenues = Revenue::with('user')->with('project')
        ->where('status', 1)->orderBy('id', 'DESC')->get();

        $respose = [
            'products' => $products,
            'revenues' => $revenues
        ];

        return $respose;
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
            'revenue_name' => 'required|string',
            'rent_amount' => 'required|integer',
            'sell_amount' => 'required|integer',
            'product' => 'required|integer'
        ]);

        $revenues = Revenue::create([
            'revenue_name' => $request['revenue_name'],
            'rent_amount' => $request['rent_amount'],
            'sell_amount' => $request['sell_amount'],
            'product' => $request['product'],
            'added_by' => Auth::user()->id,
        ]);

        return $revenues;
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
            'revenue_name' => 'required|string',
            'rent_amount' => 'required|integer',
            'sell_amount' => 'required|integer',
            'product' => 'required|integer'
        ]);

        $revenues = Revenue::where('id', $id)->update([
            'revenue_name' => $request['revenue_name'],
            'rent_amount' => $request['rent_amount'],
            'sell_amount' => $request['sell_amount'],
            'product' => $request['product']
        ]);

        return $revenues;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $revenues = Revenue::where('id', $id)->update([
            'status' => 0,
        ]);

        return $revenues;
    }
}
