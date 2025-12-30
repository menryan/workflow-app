<?php

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Enums\TaskStatus;
use App\Jobs\NotifyTaskCompleted;
use Illuminate\Support\Facades\Queue;

it('allows project owner to complete a task', function () {
    Queue::fake();

    $owner = User::factory()->create();
    $project = Project::factory()->create([
        'owner_id' => $owner->id,
    ]);

    $task = Task::factory()->create([
        'project_id' => $project->id,
        'status' => TaskStatus::IN_PROGRESS,
    ]);

    $this->actingAs($owner)
        ->patch("/tasks/{$task->id}/status", [
            'status' => TaskStatus::COMPLETED->value,
        ])
        ->assertRedirect();

    expect($task->fresh()->status)->toBe(TaskStatus::COMPLETED);

    Queue::assertPushed(NotifyTaskCompleted::class);
});

it('prevents non-owner from completing a task', function () {
    Queue::fake();

    $owner = User::factory()->create();
    $intruder = User::factory()->create();

    $project = Project::factory()->create([
        'owner_id' => $owner->id,
    ]);

    $task = Task::factory()->create([
        'project_id' => $project->id,
        'status' => TaskStatus::IN_PROGRESS,
    ]);

    $this->actingAs($intruder)
        ->patch("/tasks/{$task->id}/status", [
            'status' => TaskStatus::COMPLETED->value,
        ])
        ->assertForbidden();

    expect($task->fresh()->status)->toBe(TaskStatus::IN_PROGRESS);

    Queue::assertNothingPushed();
});
