<?php

namespace App\Actions\Tasks;

use Exception;
use App\Models\Task;

class UpdateTaskStatus
{
    protected array $allowedTransitions = [
        'draft' => ['in_progress'],
        'in_progress' => ['completed'],
    ];

    public function execute(Task $task, string $newStatus): void
    {
        if (! in_array($newStatus, $this->allowedTransitions[$task->status] ?? [])) {
            throw new Exception('Invalid status transition.');
        }

        $task->update(['status' => $newStatus]);
    }
}
