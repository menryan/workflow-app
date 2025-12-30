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
