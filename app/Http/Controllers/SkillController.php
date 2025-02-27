<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SkillController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        auth()->user()->skills()->create($validated);

        return back()->with('success', 'Skill added successfully.');
    }

    public function remove(Skill $skill)
    {
        if ($skill->user_id !== auth()->id()) {
            abort(403);
        }

        $skill->delete();

        return back()->with('success', 'Skill removed successfully.');
    }
}