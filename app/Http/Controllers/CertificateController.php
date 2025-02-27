<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issuing_organization' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'url' => 'nullable|url|max:255',
        ]);

        auth()->user()->certificates()->create($validated);

        return back()->with('success', 'Certificate added successfully.');
    }

    public function remove(Certificate $certificate)
    {
        if ($certificate->user_id !== auth()->id()) {
            abort(403);
        }

        $certificate->delete();

        return back()->with('success', 'Certificate removed successfully.');
    }
}