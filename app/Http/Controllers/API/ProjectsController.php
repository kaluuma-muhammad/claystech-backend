<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\User;

class ProjectsController extends Controller
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
        $users = User::get();
        $projects = Project::with('user')->with('head')->where('status', 1)->orderBy('id', 'DESC')->get();

        $respose = [
            'projects' => $projects,
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
            'project_name' => 'required|string',
            'head_of_project' => 'required|integer',
            'project_details' => 'required|string',
            'project_type' => 'required|string',
            'stage' => 'required|string',
            'progress' => 'required|integer',
            'due_date' => 'required|date',
        ]);

        $projects = Project::create([
            'project_name' => $request['project_name'],
            'head_of_project' => $request['head_of_project'],
            'project_details' => $request['project_details'],
            'project_type' => $request['project_type'],
            'stage' => $request['stage'],
            'progress' => $request['progress'],
            'due_date' => $request['due_date'],
            'added_by' => Auth::user()->id
        ]);

        return $projects;
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
            'project_name' => 'required|string',
            'head_of_project' => 'required|integer',
            'project_details' => 'required|string',
            'project_type' => 'required|string',
            'stage' => 'required|string',
            'progress' => 'required|integer',
            'due_date' => 'required|date',
        ]);

        $project = Project::where('id', $id)->update([
            'project_name' => $request['project_name'],
            'head_of_project' => $request['head_of_project'],
            'project_details' => $request['project_details'],
            'project_type' => $request['project_type'],
            'stage' => $request['stage'],
            'progress' => $request['progress'],
            'due_date' => $request['due_date']
        ]);

        return $project;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $project = Project::where('id', $id)->update([
            'status' => 0,
        ]);

        return $project;
    }
}
