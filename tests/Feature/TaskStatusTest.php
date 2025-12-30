<?php

use App\Models\Task;
use App\Enums\TaskStatus;
use App\Actions\Tasks\UpdateTaskStatus;

it('prevents invalid task status transitions', function () {
    $task = Task::factory()->create([
        'status' => TaskStatus::DRAFT,
    ]);

    expect(
        fn() =>
        app(UpdateTaskStatus::class)
            ->execute($task, TaskStatus::COMPLETED)
    )->toThrow(Exception::class);
});

it('allows moving a task from in_progress to completed', function () {
    $task = Task::factory()->create([
        'status' => TaskStatus::IN_PROGRESS,
    ]);

    app(UpdateTaskStatus::class)->execute($task, TaskStatus::COMPLETED);

    expect($task->fresh()->status)->toBe(TaskStatus::COMPLETED);
});
