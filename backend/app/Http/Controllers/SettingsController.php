<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Risk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $projectIds = Project::where('user_id', auth()->id())
            ->pluck('id');

        $totalProjects = $projectIds->count();

        $totalRisks = Risk::whereIn('project_id', $projectIds)
            ->count();

        $highRisks = Risk::whereIn('project_id', $projectIds)
            ->where('risk_level', 'High')
            ->count();

        $mediumRisks = Risk::whereIn('project_id', $projectIds)
            ->where('risk_level', 'Medium')
            ->count();

        $lowRisks = Risk::whereIn('project_id', $projectIds)
            ->where('risk_level', 'Low')
            ->count();

        return view('pages.settings', compact(
            'user',
            'totalProjects',
            'totalRisks',
            'highRisks',
            'mediumRisks',
            'lowRisks'
        ));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'profile_photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        $user->name = $validated['name'];

        if ($request->hasFile('profile_photo')) {

            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $path = $request->file('profile_photo')
                ->store('profile-photos', 'public');

            $user->profile_photo = $path;
        }

        $user->save();

        return redirect()
            ->route('settings')
            ->with('success', 'Profile berhasil diperbarui.');
    }
}