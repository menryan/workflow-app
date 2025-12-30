<?php

namespace App\Jobs;

use App\Models\Task;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyTaskCompleted implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public int $taskId
    ) {}

    public function handle(): void
    {
        $task = Task::find($this->taskId);

        if (! $task) {
            return;
        }

        // pretend notification logic
        Log::info("Task {$task->id} completed");
    }
}
