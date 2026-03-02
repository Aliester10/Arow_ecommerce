<?php

namespace App\Http\Controllers;

use App\Models\PrivacyPolicy;
use Illuminate\Http\Request;

class AdminPrivacyPolicyController extends Controller
{
    public function index()
    {
        $privacyPolicies = PrivacyPolicy::orderBy('created_at', 'desc')->get();
        return view('admin.privacy-policy.index', compact('privacyPolicies'));
    }

    public function create()
    {
        return view('admin.privacy-policy.create');
    }

    public function store(Request $request)
    {
        // Debug: Log incoming request data
        \Log::info('PrivacyPolicy store method called');
        \Log::info('Request data: ', $request->all());
        
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'introduction' => 'required|string',
            'last_updated' => 'required|date',
            'sections' => 'required|array',
            'sections.*.title' => 'required|string|max:255',
            'sections.*.items' => 'required|array',
            'sections.*.items.*' => 'required|string',
            'sections.*.description' => 'nullable|string',
        ]);

        // Debug: Log after validation
        \Log::info('Validation passed');

        // Deactivate all other policies when creating a new one
        PrivacyPolicy::where('is_active', true)->update(['is_active' => false]);

        $privacyPolicy = PrivacyPolicy::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'introduction' => $request->introduction,
            'last_updated' => $request->last_updated,
            'sections' => $request->sections,
            'is_active' => $request->has('is_active'),
        ]);

        // Debug: Log after creation
        \Log::info('PrivacyPolicy created with ID: ' . $privacyPolicy->id);

        return redirect()
            ->route('admin.privacy-policy.index')
            ->with('success', 'Kebijakan Privasi berhasil dibuat!');
    }

    public function edit(PrivacyPolicy $privacyPolicy)
    {
        return view('admin.privacy-policy.edit', compact('privacyPolicy'));
    }

    public function update(Request $request, PrivacyPolicy $privacyPolicy)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'introduction' => 'required|string',
            'last_updated' => 'required|date',
            'sections' => 'required|array',
            'sections.*.title' => 'required|string|max:255',
            'sections.*.items' => 'required|array',
            'sections.*.items.*' => 'required|string',
            'sections.*.description' => 'nullable|string',
        ]);

        // If this policy is being set as active, deactivate all others
        if ($request->has('is_active') && $request->is_active) {
            PrivacyPolicy::where('id', '!=', $privacyPolicy->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $privacyPolicy->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'introduction' => $request->introduction,
            'last_updated' => $request->last_updated,
            'sections' => $request->sections,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()
            ->route('admin.privacy-policy.index')
            ->with('success', 'Kebijakan Privasi berhasil diperbarui!');
    }

    public function destroy(PrivacyPolicy $privacyPolicy)
    {
        $privacyPolicy->delete();
        return redirect()
            ->route('admin.privacy-policy.index')
            ->with('success', 'Kebijakan Privasi berhasil dihapus!');
    }

    public function toggleStatus(PrivacyPolicy $privacyPolicy)
    {
        // Deactivate all other policies
        PrivacyPolicy::where('id', '!=', $privacyPolicy->id)
            ->where('is_active', true)
            ->update(['is_active' => false]);

        // Toggle current policy status
        $privacyPolicy->is_active = !$privacyPolicy->is_active;
        $privacyPolicy->save();

        $status = $privacyPolicy->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()
            ->route('admin.privacy-policy.index')
            ->with('success', "Kebijakan Privasi berhasil {$status}!");
    }
}
