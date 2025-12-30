<?php

namespace App\Actions\Tasks;

use Exception;
use App\Models\Task;
use App\Models\User;
use App\Enums\TaskStatus;
use Illuminate\Support\Facades\Gate;

class UpdateTaskStatus
{
    public function execute(User $user, Task $task, TaskStatus $newStatus): void
    {
        Gate::forUser($user)->authorize('updateStatus', $task);

        if (! $task->status->canTransitionTo($newStatus)) {
            throw new Exception('Invalid status transition.');
        }

        $task->update(['status' => $newStatus]);
    }
}
