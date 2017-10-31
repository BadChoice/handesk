<?php

namespace App\Http\Controllers;

use App\Task;

class TasksController extends Controller
{
    public function index()
    {
        $tasks = auth()->user()->uncompletedTasks->groupBy(function ($task) {
            return ($task->datetime) ? $task->datetime->toDateString() : 1;
        });

        return view('tasks.index', ['tasks' => $tasks]);
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return back();
    }

    public function update(Task $task)
    {
        $task->update([
           'completed' => request('completed'),
        ]);

        return back();
    }
}
