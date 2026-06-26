<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Risk;
use App\Models\RiskCategory;    
use Illuminate\Http\Request;
use App\Services\RiskCalculationService; 
use App\Services\ActivityLogService;
use App\Models\ProjectType;
use App\Models\ProjectTypeCategory;


class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('user_id', auth()->id())
            ->withCount([
                'risks',
                'risks as high_risks_count' => fn($q) => $q->where('risk_level', 'High'),
                'risks as medium_risks_count' => fn($q) => $q->where('risk_level', 'Medium'),
                'risks as low_risks_count' => fn($q) => $q->where('risk_level', 'Low'),
                'riskCategories',
                'risks as open_risks_count' => fn($q) => $q->where('status', 'Open'),
                'risks as in_progress_risks_count' => fn($q) => $q->where('status', 'In Progress'),
                'risks as closed_risks_count' => fn($q) => $q->where('status', 'Closed'),
            ])
            ->latest()
            ->get();

        $summaryTotalProjects = $projects->count();
        $summaryTotalCategories = $projects->sum('risk_categories_count');
        $summaryTotalRisks = $projects->sum('risks_count');
        $summaryHighRisks = $projects->sum('high_risks_count');

        return view('projects.index', compact(
            'projects',
            'summaryTotalProjects',
            'summaryTotalCategories',
            'summaryTotalRisks',
            'summaryHighRisks'
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

        ActivityLogService::log(
            $project->id,
            'create',
            'project',
            $project->id,
            'Created project: ' . $project->nama_project
        );

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

        $totalRisks = $project->risks()->count();
        $closedRisks = $project->risks()
            ->where('status', 'Closed')
            ->count();

        $project->mitigation_progress = $totalRisks > 0
            ? round(($closedRisks / $totalRisks) * 100)
            : 0;

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

        $ganttTasks = $project->projectTasks()
            ->orderBy('start_date')
            ->get();

        $ganttStart = $ganttTasks->min('start_date');
        $ganttEnd = $ganttTasks->max('end_date');

        $ganttTotalDays = 0;

        if ($ganttStart && $ganttEnd) {
            $ganttStart = \Carbon\Carbon::parse($ganttStart);
            $ganttEnd = \Carbon\Carbon::parse($ganttEnd);
            $ganttTotalDays = $ganttStart->diffInDays($ganttEnd) + 1;
        }

        return view('projects.show', compact(
            'project',
            'categories',
            'matrix',
            'heatmapService',
            'ganttTasks',
            'ganttStart',
            'ganttEnd',
            'ganttTotalDays'
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

            $projectTypes = ProjectType::where('is_active', true)
                ->get();

            return view('projects.edit', compact(
                'project',
                'projectTypes'
            ));
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

        $progress = $request->progress;

        if ($request->status === 'Completed') {
            $progress = 100;
        }

        $request->validate([
            'nama_project' => 'required|max:255',
            'status' => 'required|in:Planning,Ongoing,Completed',
            'progress' => 'required|integer|min:0|max:100',
            'estimated_budget' => 'nullable|numeric|min:0',
            'deskripsi' => 'nullable',
        ]);

        $project->update([
            'nama_project'      => $request->nama_project,
            'deskripsi'         => $request->deskripsi,
            'project_type_id'   => $request->project_type_id,
            'status'            => $request->status,
            'progress'          => $request->progress,
            'estimated_budget'  => $request->estimated_budget,
        ]);

        ActivityLogService::log(
            $project->id,
            'update',
            'project',
            $project->id,
            'Updated project: ' . $project->nama_project
        );

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

        $projectName = $project->nama_project;
        $projectId = $project->id;

        ActivityLogService::log(
            $projectId,
            'delete',
            'project',
            $projectId,
            'Deleted project: ' . $projectName
        );

        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project berhasil dihapus');
    }
}
