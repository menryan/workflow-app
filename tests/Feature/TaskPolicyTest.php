<?php

use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use App\Enums\TaskStatus;
use App\Policies\TaskPolicy;
use Illuminate\Support\Facades\Gate;

it('allows project owner to update task status', function () {
    $owner = User::factory()->create();
    $project = Project::factory()->create([
        'owner_id' => $owner->id
    ]);
    $task = Task::factory()->create([
        'project_id' => $project->id
    ]);

    expect(Gate::forUser($owner)->allows('updateStatus', $task))->toBeTrue();

    // $policy = new TaskPolicy();
    // expect($policy->updateStatus($owner, $task))->toBeTrue();
});

it('prevents non-project owner to update task status', function () {
    $user = User::factory()->create();
    $owner = User::factory()->create();
    $project = Project::factory()->create([
        'owner_id' => $owner->id
    ]);
    $task = Task::factory()->create([
        'project_id' => $project->id
    ]);

    expect(Gate::forUser($user)->allows('updateStatus', $task))->toBeFalse();

    // $policy = new TaskPolicy();
    // expect($policy->updateStatus($owner, $task))->toBeTrue();
});
