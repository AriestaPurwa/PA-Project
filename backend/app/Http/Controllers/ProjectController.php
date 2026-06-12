<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\RiskCategory;    
use Illuminate\Http\Request;
use App\Services\RiskCalculationService; 
use App\Services\ActivityLogService;
use App\Models\ProjectType;
use App\Models\ProjectTypeCategory;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $projects = Project::where('user_id', auth()->id())
    //         ->where('is_guest', false)
    //         ->latest()
    //         ->get();
    //     return view('projects.index', compact('projects'));
    // }

    public function index()
    {
        $projects = Project::where('user_id', auth()->id())
            ->where('is_guest', false)
            ->withCount([
                'risks',
                'risks as high_risks_count'   => fn($q) => $q->where('risk_level', 'High'),
                'risks as medium_risks_count' => fn($q) => $q->where('risk_level', 'Medium'),
                'risks as low_risks_count'    => fn($q) => $q->where('risk_level', 'Low'),
                'riskCategories',
            ])
            ->latest()
            ->get();
 
        // CHANGED: Agregat untuk summary bar — dihitung dari koleksi, bukan query tambahan
        $summaryTotalProjects  = $projects->count();
        $summaryTotalRisks     = $projects->sum('risks_count');
        $summaryHighRisks      = $projects->sum('high_risks_count');
        $summaryTotalCategories = $projects->sum('risk_categories_count');
 
        return view('projects.index', compact(
            'projects',
            'summaryTotalProjects',
            'summaryTotalRisks',
            'summaryHighRisks',
            'summaryTotalCategories'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projectTypes = ProjectType::where('is_active', true)->get();

        return view('projects.create', compact('projectTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Guest mode
        // if ($request->has('guest_mode')) {

        //     $project = Project::create([
        //         'user_id' => null,
        //         'is_guest' => true,
        //         'nama_project' => $request->nama_project,
        //         'deskripsi' => $request->deskripsi,
        //         'project_type_id' => 'required|exists:project_types,id', //edit
        //     ]);

        //     return redirect("/projects/{$project->id}")
        //         ->with('success',
        //         'Guest project created temporarily.');
        // }

         // Must login
        if (!auth()->check()) {

            return redirect('/login')
                ->with('success',
                'Login required to save project permanently.');
        }

        // Normal save
        $project =Project::create([
            'user_id'         => auth()->id(),
            'is_guest'        => false,
            'project_type_id' => $request->project_type_id,
            'nama_project'    => $request->nama_project,
            'deskripsi'       => $request->deskripsi,
        ]);

        $templateCategories = ProjectTypeCategory::where(
            'project_type_id',
            $project->project_type_id
        )->get();

        foreach ($templateCategories as $template) {
            RiskCategory::create([
                'project_id'    => $project->id,
                'parent_id'     => null,
                'nama_kategori' => $template->category_name,
                'level'         => 0,
            ]);
        }

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
}
