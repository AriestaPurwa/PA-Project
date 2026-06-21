<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Risk;
use App\Models\RiskCategory;

class ReportController extends Controller
{
    public function index()
    {
        $projects = Project::where('user_id', auth()->id())
            ->with('projectType')
            ->withCount([
                'riskCategories',
                'risks',
                'risks as high_risks_count' => fn ($query) => $query->where('risk_level', 'High'),
                'risks as medium_risks_count' => fn ($query) => $query->where('risk_level', 'Medium'),
                'risks as low_risks_count' => fn ($query) => $query->where('risk_level', 'Low'),
            ])
            ->latest()
            ->get();

        $totalProjects = $projects->count();
        $totalRisks = $projects->sum('risks_count');
        $totalHighRisks = $projects->sum('high_risks_count');
        $readyReports = $projects->where('risks_count', '>', 0)->count();

        return view('pages.reports.index', compact(
            'projects',
            'totalProjects',
            'totalRisks',
            'totalHighRisks',
            'readyReports'
        ));
    }

    public function show(Project $project)
    {
        if (
            !auth()->check() ||
            $project->user_id !== auth()->id()
        ) {
            abort(403);
        }

        $risks = Risk::where('project_id', $project->id)
            ->with('category')
            ->orderByDesc('risk_score')
            ->get();

        $categories = RiskCategory::where('project_id', $project->id)
            ->orderBy('level')
            ->orderBy('nama_kategori')
            ->get();

        $totalRisks = $risks->count();
        $highRisks = $risks->where('risk_level', 'High')->count();
        $mediumRisks = $risks->where('risk_level', 'Medium')->count();
        $lowRisks = $risks->where('risk_level', 'Low')->count();

        return view('pages.reports.show', compact(
            'project',
            'risks',
            'categories',
            'totalRisks',
            'highRisks',
            'mediumRisks',
            'lowRisks'
        ));
    }
}