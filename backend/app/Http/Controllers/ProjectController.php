<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\RiskCategory;    
use Illuminate\Http\Request;
use App\Services\RiskCalculationService; //sementara

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::where('user_id', auth()->id())
            ->where('is_guest', false)
            ->latest()
            ->get();
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Guest mode
        if ($request->has('guest_mode')) {

            $project = Project::create([
                'user_id' => null,
                'is_guest' => true,
                'nama_project' => $request->nama_project,
                'deskripsi' => $request->deskripsi,
            ]);

            return redirect("/projects/{$project->id}")
                ->with('success',
                'Guest project created temporarily.');
        }

         // Must login
        if (!auth()->check()) {

            return redirect('/login')
                ->with('success',
                'Login required to save project permanently.');
        }

        // Normal save
        Project::create([
            'user_id' => auth()->id(),
            'is_guest' => false,
            'project_type_id' => $request->project_type_id,
            'nama_project' => $request->nama_project,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {

        // Guest project boleh diakses publik
        if (!$project->is_guest) {

            // Jika project permanent
            // harus milik user login

            if (!auth()->check() || $project->user_id !== auth()->id()) {
                abort(403);
            }
        }

        $calculator = new RiskCalculationService();

        $categories = RiskCategory::where('project_id', $project->id)
            ->whereNull('parent_id')
            ->with(['children.children.risks', 'risks'])
            ->get();

        foreach ($categories as $category) {
            $calculator->attachScoresRecursively($category);
        }

        $matrix = $calculator->generateRiskMatrix($project->id);

        $heatmapService = $calculator;

        // return view('projects.show', compact('project', 'categories'));

        return view('projects.show', compact(
            'project',
            'categories',
            'matrix',
            'heatmapService'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        // project permanent harus owner
        if (!$project->is_guest) {

            if (!auth()->check() ||
                $project->user_id !== auth()->id()) {

                abort(403);
            }
        }

        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        // ownership check
        if (!$project->is_guest) {

            if (!auth()->check() ||
                $project->user_id !== auth()->id()) {

                abort(403);
            }
        }

        $request->validate([
            'nama_project' => 'required|max:255',
            'deskripsi' => 'nullable',
        ]);

        $project->update([
            'nama_project' => $request->nama_project,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('projects.show', $project->id)
            ->with('success', 'Project updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if (!$project->is_guest) {

            if (!auth()->check() ||
                $project->user_id !== auth()->id()) {

                abort(403);
            }
        }
        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project berhasil dihapus');
    }

    private function logActivity(
        $projectId,
        $action,
        $targetType,
        $targetId,
        $description
    ) {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'project_id' => $projectId,
            'action' => $action,
            'target_type' => $targetType,
            'target_id' => $targetId,
            'description' => $description,
        ]);
    }
}
