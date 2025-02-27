<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        auth()->user()->languages()->create($validated);

        return back()->with('success', 'Language added successfully.');
    }

    public function remove(Language $language)
    {
        if ($language->user_id !== auth()->id()) {
            abort(403);
        }

        $language->delete();

        return back()->with('success', 'Language removed successfully.');
    }
}