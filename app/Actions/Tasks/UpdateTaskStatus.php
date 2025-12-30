<?php

namespace App\Actions\Tasks;

use Exception;
use App\Models\Task;
use App\Enums\TaskStatus;

class UpdateTaskStatus
{
    public function execute(Task $task, TaskStatus $newStatus): void
    {
        if (! $task->status->canTransitionTo($newStatus)) {
            throw new Exception('Invalid status transition.');
        }

        $task->update(['status' => $newStatus]);
    }
}
