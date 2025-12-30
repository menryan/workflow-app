<?php

use App\Models\Task;
use App\Actions\Tasks\UpdateTaskStatus;

it('cannot move a task directly from draft to completed', function () {
    $task = Task::factory()->create([
        'status' => 'draft',
    ]);

    expect(
        fn() => app(UpdateTaskStatus::class)->execute($task, 'completed')
    )->toThrow(Exception::class);
});

it('allows moving a task from in_progress to completed', function () {
    $task = Task::factory()->create([
        'status' => 'in_progress',
    ]);

    app(UpdateTaskStatus::class)->execute($task, 'completed');

    expect($task->fresh()->status)->toBe('completed');
});
