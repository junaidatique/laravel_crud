<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Task;

class TasksController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index')->withTasks($tasks);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required|unique:tasks|max:255',
            'description' => 'required',
        ]);

        $input = $request->all();

        Task::create($input);
        $request->session()->flash('flash_message', 'Task was successful!');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $task = Task::findOrFail($id);

        return view('tasks.show')->withTask($task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit')->withTask($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);


        $this->validate($request, [
            'title' => 'required|max:255|unique:tasks,title,'.$id,
            'description' => 'required',
        ]);

        $input = $request->all();

        $task->fill($input)->save();

        $request->session()->flash('flash_message', 'Task successfully added!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $task = Task::findOrFail($id);

        $task->delete();
        $request = new Request();
        session()->flash('flash_message', 'Task successfully deleted!');

        return redirect()->route('tasks.index');
    }
}
