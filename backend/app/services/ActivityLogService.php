<?php

namespace App\Services;

use App\Models\ActivityLog;

class ActivityLogService
{
    public static function log(
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