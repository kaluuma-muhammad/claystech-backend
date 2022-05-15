<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Client;
use App\Models\Country;

class ClientsController extends Controller
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
        $countries = Country::get();
        $projects = Project::get();
        $clients = Client::with('user')->with('project')
        ->where('status', 1)->orderBy('id', 'DESC')->get();

        $respose = [
            'countries' => $countries,
            'projects' => $projects,
            'clients' => $clients
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
            'client_names' => 'required|string',
            'client_email' => 'required|string|unique:clients,client_email',
            'phone_code' => 'required|integer',
            'client_contact' => 'required|integer',
            'product' => 'required|integer'
        ]);

        $client = Client::create([
            'client_names' => $request['client_names'],
            'client_email' => $request['client_email'],
            'phone_code' => $request['phone_code'],
            'client_contact' => $request['client_contact'],
            'product' => $request['product'],
            'added_by' => Auth::user()->id,
        ]);

        return $client;
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
            'client_names' => 'required|string',
            'client_email' => 'required|string|unique:clients,client_email,'.$id,
            'phone_code' => 'required|integer',
            'client_contact' => 'required|integer',
            'product' => 'required|integer'
        ]);

        $client = Client::where('id', $id)->update([
            'client_names' => $request['client_names'],
            'client_email' => $request['client_email'],
            'phone_code' => $request['phone_code'],
            'client_contact' => $request['client_contact'],
            'product' => $request['product'],
            'added_by' => Auth::user()->id,
        ]);

        return $client;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::where('id', $id)->update([
            'status' => 0
        ]);

        return $client;
    }
}
