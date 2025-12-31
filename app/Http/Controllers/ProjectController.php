<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function show(Project $project)
    {
        $this->authorize('view', $project);

        return inertia('Projects/Show', [
            'project' => $project->load('tasks'),
        ]);
    }
}
