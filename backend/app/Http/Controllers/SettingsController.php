<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Risk;

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
}