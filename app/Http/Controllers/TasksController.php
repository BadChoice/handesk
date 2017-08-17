<?php

namespace App\Http\Controllers;

use App\Task;

class TasksController extends Controller
{
    public function update(Task $task){
        $task->update([
           "completed" => request('completed')
        ]);
        return back();
    }
}
