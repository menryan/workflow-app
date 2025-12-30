<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Enums\TaskStatus;
use Illuminate\Http\Request;
use App\Actions\Tasks\UpdateTaskStatus;

class TaskStatusController extends Controller
{
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'status' => ['required'],
        ]);

        app(UpdateTaskStatus::class)->execute(
            $request->user(),
            $task,
            TaskStatus::from($request->status)
        );

        return redirect()->back();
    }
}
