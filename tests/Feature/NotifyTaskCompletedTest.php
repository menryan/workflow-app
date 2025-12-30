<?php

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Enums\TaskStatus;
use App\Jobs\NotifyTaskCompleted;
use Illuminate\Support\Facades\Queue;
use App\Actions\Tasks\UpdateTaskStatus;

it('dispatches a notification job when task is completed', function () {
    Queue::fake();

    $user = User::factory()->create();
    $task = Task::factory()->create([
        'status' => TaskStatus::IN_PROGRESS,
        'project_id' => Project::factory()->create([
            'owner_id' => $user->id,
        ])->id,
    ]);

    app(UpdateTaskStatus::class)->execute(
        $user,
        $task,
        TaskStatus::COMPLETED
    );

    Queue::assertPushed(NotifyTaskCompleted::class);
});

it('does not dispatches a notification job when task status is other than completed', function () {
    Queue::fake();

    $user = User::factory()->create();
    $task = Task::factory()->create([
        'status' => TaskStatus::DRAFT,
        'project_id' => Project::factory()->create([
            'owner_id' => $user->id,
        ])->id,
    ]);

    app(UpdateTaskStatus::class)->execute(
        $user,
        $task,
        TaskStatus::IN_PROGRESS
    );

    Queue::assertNotPushed(NotifyTaskCompleted::class);
});

it('does not notify twice for the same task', function () {
    $task = Task::factory()->create([
        'completed_notified_at' => now(),
    ]);

    $job = new NotifyTaskCompleted($task->id);

    $job->handle();

    expect($task->fresh()->completed_notified_at)->not->toBeNull();
});
