<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Project;

class ActivityLogController extends Controller
{
    public function index(Project $project)
    {
        if (
            !auth()->check() ||
            $project->user_id !== auth()->id()
        ) {
            abort(403);
        }

        $logs = $project->activityLogs()
            ->latest()
            ->paginate(20);

        $totalActivities = $project->activityLogs()
            ->count();

        $lastActivity = $project->activityLogs()
            ->latest()
            ->first();

        return view(
            'activity_logs.index',
            compact(
                'project',
                'logs',
                'totalActivities',
                'lastActivity'
            )
        );
    }

    public function globalIndex()
    {
        $activityQuery = ActivityLog::where(function ($query) {
            $query->where('user_id', auth()->id())
                ->orWhereHas('project', function ($projectQuery) {
                    $projectQuery->where('user_id', auth()->id());
                });
        });

        $totalActivities = (clone $activityQuery)->count();

        $todayActivities = (clone $activityQuery)
            ->whereDate('created_at', today())
            ->count();

        $totalProjects = Project::where('user_id', auth()->id())
            ->count();

        $activityLogs = (clone $activityQuery)
            ->with('project')
            ->latest()
            ->paginate(15);

        return view('pages.activity-log', compact(
            'activityLogs',
            'totalActivities',
            'todayActivities',
            'totalProjects'
        ));
    }
}