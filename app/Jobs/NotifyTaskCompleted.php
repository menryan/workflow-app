<?php

namespace App\Jobs;

use Throwable;
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

    public int $tries = 3;

    public function backoff(): array
    {
        return [10, 30, 60];
    }

    public function __construct(
        public int $taskId
    ) {}

    public function handle(): void
    {
        $task = Task::find($this->taskId);

        if (! $task || $task->completed_notified_at) {
            return;
        }

        Log::info("Task {$task->id} completed");

        $task->update([
            'completed_notified_at' => now(),
        ]);
    }

    public function failed(Throwable $exception): void
    {
        Log::error(
            "Failed to notify completion for task {$this->taskId}",
            ['exception' => $exception]
        );
    }
}
