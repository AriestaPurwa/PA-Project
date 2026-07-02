<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Risk;
use App\Models\RiskCategory;
use Illuminate\Support\Facades\Auth;

class RiskOverviewController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $projects = Project::where('user_id', $userId)
            ->latest()
            ->get();

        $projectIds = $projects->pluck('id');

        $totalProjects = $projects->count();

        $totalRisks = Risk::whereIn('project_id', $projectIds)->count();

        $totalHighRisks = Risk::whereIn('project_id', $projectIds)
            ->where('risk_level', 'High')
            ->count();

        $totalMediumRisks = Risk::whereIn('project_id', $projectIds)
            ->where('risk_level', 'Medium')
            ->count();

        $totalLowRisks = Risk::whereIn('project_id', $projectIds)
            ->where('risk_level', 'Low')
            ->count();

        $riskOverview = $projects->map(function ($project) {
            $risks = Risk::where('project_id', $project->id)->get();

            $totalRisk = $risks->count();
            $highRisk = $risks->where('risk_level', 'High')->count();
            $mediumRisk = $risks->where('risk_level', 'Medium')->count();
            $lowRisk = $risks->where('risk_level', 'Low')->count();

            $highestRisk = $risks->sortByDesc('risk_score')->first();

            $project->total_categories = RiskCategory::where('project_id', $project->id)->count();
            $project->total_risks = $totalRisk;
            $project->high_risks = $highRisk;
            $project->medium_risks = $mediumRisk;
            $project->low_risks = $lowRisk;
            $project->highest_risk_level = $highestRisk ? $highestRisk->risk_level : '-';
            $project->highest_risk_score = $highestRisk ? $highestRisk->risk_score : 0;

            return $project;
        });

        return view('pages.risk-overview', compact(
            'totalProjects',
            'totalRisks',
            'totalHighRisks',
            'totalMediumRisks',
            'totalLowRisks',
            'riskOverview'
        ));
    }
}