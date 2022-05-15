<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Country;
use App\Models\Department;
use App\Models\Employee;

class EmployeesController extends Controller
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
        $posts = Post::get();
        $countries = Country::get();
        $departments = Department::get();
        $employees = Employee::with('user')->with('nation')->with('post')->with('department')
        ->where('status', 1)->orderBy('id', 'DESC')->get();

        $response = [
            'posts' => $posts,
            'countries' => $countries,
            'departments' => $departments,
            'employees' => $employees
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
            'names' => 'required|string',
            'department_id' => 'required|integer',
            'email' => 'required|string|unique:employees,email',
            'role_post' => 'required|integer',
            'phone_code' => 'required|integer',
            'contact' => 'required|integer',
            'country' => 'required|integer',
            'address' => 'required|string',
            'salary' => 'required|integer',
            'contract_start' => 'required|date',
            'contract_end' => 'required|date',
            'n_i_d' => 'required|string',
            'gender' => 'required|string'
        ]);

        if ($request->hasFile('image')) {
            $file = $request->image;
            $imageName = "CT-" . time() . "." . $file->getClientOriginalExtension();
            $request->file('image')->storeAs('employees', $imageName);
        } else {
            $imageName = null;
        }

        $employee = Employee::create([
            'names' => $request['names'],
            'department_id' => $request['department_id'],
            'email' => $request['email'],
            'role_post' => $request['role_post'],
            'phone_code' => $request['phone_code'],
            'contact' => $request['contact'],
            'country' => $request['country'],
            'image' => $imageName,
            'address' => $request['address'],
            'salary' => $request['salary'],
            'contract_start' => $request['contract_start'],
            'contract_end' => $request['contract_end'],
            'n_i_d' => $request['n_i_d'],
            'gender' => $request['gender'],
            'added_by' => Auth::user()->id,
        ]);

        return $employee;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $posts = Post::get();
        $countries = Country::get();
        $departments = Department::get();
        $employee = Employee::with('phone')->with('nation')->with('post')->with('department')->find($id);

        $response = [
            'posts' => $posts,
            'countries' => $countries,
            'departments' => $departments,
            'employee' => $employee
        ];

        return $response;
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
            'names' => 'required|string',
            'department_id' => 'required|integer',
            'email' => 'required|string|unique:employees,email,'.$id,
            'role_post' => 'required|integer',
            'phone_code' => 'required|integer',
            'contact' => 'required|integer',
            'country' => 'required|integer',
            'address' => 'required|string',
            'salary' => 'required|integer',
            'contract_start' => 'required|date',
            'contract_end' => 'required|date',
            'n_i_d' => 'required|string',
            'gender' => 'required|string'
        ]);

        $empImg = Employee::find($id);
        $img = $empImg->image;

        if ($request->hasFile('image')) {
            $file = $request->image;
            $imageName = "CT-" . time() . "." . $file->getClientOriginalExtension();
            $request->file('image')->storeAs('employees', $imageName);
        }

        $employee = Employee::where('id', $id)->update([
            'names' => $request['names'],
            'department_id' => $request['department_id'],
            'email' => $request['email'],
            'role_post' => $request['role_post'],
            'phone_code' => $request['phone_code'],
            'contact' => $request['contact'],
            'country' => $request['country'],
            'address' => $request['address'],
            'salary' => $request['salary'],
            'contract_start' => $request['contract_start'],
            'contract_end' => $request['contract_end'],
            'n_i_d' => $request['n_i_d'],
            'gender' => $request['gender']
        ]);

        return $employee;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::where('id', $id)->update([
            'status' => 0,
        ]);

        return $employee;
    }
}
