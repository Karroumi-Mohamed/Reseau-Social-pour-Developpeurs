<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'nullable|url|max:255',
        ]);

        auth()->user()->projects()->create($validated);

        return back()->with('success', 'Project added successfully.');
    }

    public function remove(Project $project)
    {
        if ($project->user_id !== auth()->id()) {
            abort(403);
        }
        
        $project->delete();

        return back()->with('success', 'Project removed successfully.');
    }
}