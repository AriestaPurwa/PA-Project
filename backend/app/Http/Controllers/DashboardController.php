<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Risk;
use App\Models\RiskCategory;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $projects = Project::where('user_id', $userId)
            // ->where('is_guest', false)
            ->get();

        $projectIds = $projects->pluck('id');

        $totalProjects = $projects->count();

        $totalCategories = RiskCategory::whereIn('project_id', $projectIds)
            ->count();

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

        $averageProgress = round(
            Project::where('user_id', $userId)
                // ->where('is_guest', false)
                ->avg('progress') ?? 0
        );

        $recentProjects = Project::where('user_id', $userId)
            // ->where('is_guest', false)
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($project) {
                $risks = Risk::where('project_id', $project->id)->get();

                $project->total_risks = $risks->count();
                $project->high_risks = $risks->where('risk_level', 'High')->count();
                $project->medium_risks = $risks->where('risk_level', 'Medium')->count();
                $project->low_risks = $risks->where('risk_level', 'Low')->count();

                $highestRisk = $risks->sortByDesc('risk_score')->first();
                $project->highest_risk_level = $highestRisk ? $highestRisk->risk_level : '-';

                return $project;
            });

        $highRiskProjects = Project::where('user_id', $userId)
            // ->where('is_guest', false)
            ->latest()
            ->get()
            ->map(function ($project) {
                $project->high_risks_count = Risk::where('project_id', $project->id)
                    ->where('risk_level', 'High')
                    ->count();

                return $project;
            })
            ->where('high_risks_count', '>', 0)
            ->take(5);

        $recentActivities = ActivityLog::whereIn('project_id', $projectIds)
            ->latest()
            ->take(5)
            ->get();

        return view('pages.dashboard', compact(
            'totalProjects',
            'totalCategories',
            'totalRisks',
            'highRisks',
            'mediumRisks',
            'lowRisks',
            'averageProgress',
            'recentProjects',
            'highRiskProjects',
            'recentActivities'
        ));
    }
}