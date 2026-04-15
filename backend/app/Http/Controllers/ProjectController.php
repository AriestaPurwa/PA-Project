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
        $projects = Project::all();
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
        Project::create($request->all());

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project berhasil dihapus');
    }
}
