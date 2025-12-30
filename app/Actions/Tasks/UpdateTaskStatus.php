<?php

namespace App\Actions\Tasks;

use Exception;
use App\Models\Task;

class UpdateTaskStatus
{
    public function execute(Task $task, string $newStatus): void
    {
        if (
            $task->status === 'draft'
            && $newStatus === 'completed'
        ) {
            throw new Exception('Invalid status transition.');
        }

        $task->update(['status' => $newStatus]);
    }
}
