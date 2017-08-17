<?php

namespace App\Http\Controllers;

use App\Task;

class TasksController extends Controller
{
    public function index(){
        return view('tasks.index', ["tasks" => Task::today()->get() ]);
    }

    public function destroy(Task $task){
        $task->delete();
        return back();
    }

    public function update(Task $task){
        $task->update([
           "completed" => request('completed')
        ]);
        return back();
    }
}
