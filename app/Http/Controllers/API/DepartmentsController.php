<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Department;
use App\Models\User;
use App\Models\Country;

class DepartmentsController extends Controller
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
        $users = User::get();
        $departments = Department::with('user')->with('head')->with('country')
        ->where('status', 1)->orderBy('id', 'DESC')->get();

        $respose = [
            'countries' => $countries,
            'departments' => $departments,
            'users' => $users
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
            'depart_name' => 'required|string',
            'depart_email' => 'required|string|unique:departments,depart_email',
            'phone_code' => 'required|integer',
            'depart_contact' => 'required|integer',
            'head_of_dapart' => 'required|integer'
        ]);

        $department = Department::create([
            'depart_name' => $request['depart_name'],
            'depart_email' => $request['depart_email'],
            'phone_code' => $request['phone_code'],
            'depart_contact' => $request['depart_contact'],
            'head_of_dapart' => $request['head_of_dapart'],
            'added_by' => Auth::user()->id,
        ]);

        return $department;
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
            'depart_name' => 'required|string',
            'depart_email' => 'required|string|unique:departments,depart_email,'.$id,
            'phone_code' => 'required|integer',
            'depart_contact' => 'required|integer',
            'head_of_dapart' => 'required|integer'
        ]);

        $department = Department::where('id', $id)->update([
            'depart_name' => $request['depart_name'],
            'depart_email' => $request['depart_email'],
            'phone_code' => $request['phone_code'],
            'depart_contact' => $request['depart_contact'],
            'head_of_dapart' => $request['head_of_dapart'],
            'added_by' => Auth::user()->id,
        ]);

        return $department;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department = Department::where('id', $id)->update([
            'status' => 0
        ]);

        return $department;
    }
}
