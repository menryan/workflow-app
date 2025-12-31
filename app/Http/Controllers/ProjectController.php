<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function show(Project $project)
    {
        $this->authorize('view', $project);

        return inertia('projects/show', [
            'project' => $project->load('tasks'),
        ]);
    }
}
