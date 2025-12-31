<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProjectController extends Controller
{
    public function show(Project $project)
    {
        Gate::authorize('view', $project);

        return inertia('projects/show', [
            'project' => $project->load('tasks'),
        ]);
    }
}
