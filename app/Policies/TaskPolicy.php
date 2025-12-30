<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use App\Enums\TaskStatus;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    public function updateStatus(User $user, Task $task): bool
    {
        if ($task->status === TaskStatus::COMPLETED) {
            return false;
        }

        return $task->project->owner_id === $user->id;
    }
}
