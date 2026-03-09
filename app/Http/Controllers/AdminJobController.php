<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class AdminJobController extends Controller
{
    public function index()
    {
        $jobs = Job::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('admin.jobs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'position' => 'required|string|max:255',
            'description' => 'required|string',
            'qualifications' => 'required|string',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|in:Full Time,Part Time,Contract',
            'email' => 'required|email',
            'is_active' => 'boolean'
        ]);

        Job::create($request->all());

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Lowongan pekerjaan berhasil ditambahkan.');
    }

    public function edit(Job $job)
    {
        return view('admin.jobs.edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        $request->validate([
            'position' => 'required|string|max:255',
            'description' => 'required|string',
            'qualifications' => 'required|string',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|in:Full Time,Part Time,Contract',
            'email' => 'required|email',
            'is_active' => 'boolean'
        ]);

        $job->update($request->all());

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Lowongan pekerjaan berhasil diperbarui.');
    }

    public function destroy(Job $job)
    {
        $job->delete();

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Lowongan pekerjaan berhasil dihapus.');
    }
}
