<?php

namespace App\Http\Controllers;

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

        return view(
            'activity_logs.index',
            compact('project', 'logs')
        );
    }
}