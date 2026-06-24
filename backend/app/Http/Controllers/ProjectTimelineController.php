<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Project;
use App\Models\ProjectTask;
use App\Models\ProjectSubtask;
use App\Models\Risk;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectTimelineController extends Controller
{
    public function index(Project $project)
    {
        $this->authorizeProject($project);

        $tasks = $project->projectTasks()
            ->with(['subtasks', 'risks'])
            ->orderBy('start_date')
            ->get();

        $risks = Risk::where('project_id', $project->id)
            ->orderByDesc('risk_score')
            ->get();

        $totalTasks = $tasks->count();

        $totalSubtasks = $tasks->sum(function ($task) {
            return $task->subtasks->count();
        });

        $doneSubtasks = $tasks->sum(function ($task) {
            return $task->subtasks->where('status', 'Done')->count();
        });

        $assignedRisks = $tasks->sum(function ($task) {
            return $task->risks->count();
        });

        return view('project_timelines.index', compact(
            'project',
            'tasks',
            'risks',
            'totalTasks',
            'totalSubtasks',
            'doneSubtasks',
            'assignedRisks'
        ));
    }

    public function storeTask(Request $request, Project $project)
    {
        $this->authorizeProject($project);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'duration_days' => ['required', 'integer', 'min:1', 'max:365'],
        ]);

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = $startDate->copy()->addDays($validated['duration_days'] - 1);

        $task = $project->projectTasks()->create([
            'name' => $validated['name'],
            'start_date' => $startDate,
            'end_date' => $endDate,
            'duration_days' => $validated['duration_days'],
            'status' => 'To Do',
            'progress' => 0,
        ]);

        $this->refreshProjectProgress($project);

        $this->logActivity(
            $project,
            'create_task',
            'project_task',
            'Created project task: ' . $task->name
        );

        return back()->with('success', 'Task berhasil ditambahkan.');
    }

    public function destroyTask(Project $project, ProjectTask $task)
    {
        $this->authorizeProject($project);
        $this->ensureTaskBelongsToProject($project, $task);

        $taskName = $task->name;

        $task->delete();

        $this->refreshProjectProgress($project);

        $this->logActivity(
            $project,
            'delete_task',
            'project_task',
            'Deleted project task: ' . $taskName
        );

        return back()->with('success', 'Task berhasil dihapus.');
    }

    public function storeSubtask(Request $request, Project $project, ProjectTask $task)
    {
        $this->authorizeProject($project);
        $this->ensureTaskBelongsToProject($project, $task);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $subtask = $task->subtasks()->create([
            'name' => $validated['name'],
            'status' => 'To Do',
        ]);

        $this->refreshTaskProgress($task);
        $this->refreshProjectProgress($project);

        $this->logActivity(
            $project,
            'create_subtask',
            'project_subtask',
            'Created subtask "' . $subtask->name . '" in task "' . $task->name . '".'
        );

        return back()->with('success', 'Subtask berhasil ditambahkan.');
    }

    public function updateSubtask(Request $request, Project $project, ProjectTask $task, ProjectSubtask $subtask)
    {
        $this->authorizeProject($project);
        $this->ensureTaskBelongsToProject($project, $task);
        $this->ensureSubtaskBelongsToTask($task, $subtask);

        $validated = $request->validate([
            'status' => ['required', 'in:To Do,In Progress,Done'],
        ]);

        $subtask->update([
            'status' => $validated['status'],
        ]);

        $this->refreshTaskProgress($task);
        $this->refreshProjectProgress($project);

        $this->logActivity(
            $project,
            'update_subtask_status',
            'project_subtask',
            'Updated subtask "' . $subtask->name . '" status to ' . $validated['status'] . '.'
        );

        return back()->with('success', 'Status subtask berhasil diperbarui.');
    }

    public function destroySubtask(Project $project, ProjectTask $task, ProjectSubtask $subtask)
    {
        $this->authorizeProject($project);
        $this->ensureTaskBelongsToProject($project, $task);
        $this->ensureSubtaskBelongsToTask($task, $subtask);

        $subtaskName = $subtask->name;

        $subtask->delete();

        $this->refreshTaskProgress($task);
        $this->refreshProjectProgress($project);

        $this->logActivity(
            $project,
            'delete_subtask',
            'project_subtask',
            'Deleted subtask: ' . $subtaskName
        );

        return back()->with('success', 'Subtask berhasil dihapus.');
    }

    public function attachRisk(Request $request, Project $project, ProjectTask $task)
    {
        $this->authorizeProject($project);
        $this->ensureTaskBelongsToProject($project, $task);

        $validated = $request->validate([
            'risk_id' => ['required', 'exists:risks,id'],
            'monitoring_status' => ['required', 'in:Open,In Progress,Handled'],
        ]);

        $risk = Risk::findOrFail($validated['risk_id']);

        if ($risk->project_id !== $project->id) {
            abort(403);
        }

        $task->risks()->syncWithoutDetaching([
            $risk->id => [
                'monitoring_status' => $validated['monitoring_status'],
            ],
        ]);

        $this->logActivity(
            $project,
            'assign_risk_to_task',
            'task_risk',
            'Assigned risk "' . $risk->nama_risiko . '" to task "' . $task->name . '".'
        );

        return back()->with('success', 'Risk berhasil ditambahkan ke task.');
    }

    public function updateRiskStatus(Request $request, Project $project, ProjectTask $task, Risk $risk)
    {
        $this->authorizeProject($project);
        $this->ensureTaskBelongsToProject($project, $task);

        if ($risk->project_id !== $project->id) {
            abort(403);
        }

        $validated = $request->validate([
            'monitoring_status' => ['required', 'in:Open,In Progress,Handled'],
        ]);

        $task->risks()->updateExistingPivot($risk->id, [
            'monitoring_status' => $validated['monitoring_status'],
        ]);

        $this->logActivity(
            $project,
            'update_task_risk',
            'task_risk',
            'Updated risk "' . $risk->nama_risiko . '" monitoring status in task "' . $task->name . '".'
        );

        return back()->with('success', 'Status risk berhasil diperbarui.');
    }

    public function detachRisk(Project $project, ProjectTask $task, Risk $risk)
    {
        $this->authorizeProject($project);
        $this->ensureTaskBelongsToProject($project, $task);

        if ($risk->project_id !== $project->id) {
            abort(403);
        }

        $task->risks()->detach($risk->id);

        $this->logActivity(
            $project,
            'remove_risk_from_task',
            'task_risk',
            'Removed risk "' . $risk->nama_risiko . '" from task "' . $task->name . '".'
        );

        return back()->with('success', 'Risk berhasil dihapus dari task.');
    }

    private function refreshTaskProgress(ProjectTask $task): void
    {
        $task->load('subtasks');

        $totalSubtasks = $task->subtasks->count();

        if ($totalSubtasks === 0) {
            $task->update([
                'progress' => 0,
                'status' => 'To Do',
            ]);

            return;
        }

        $doneSubtasks = $task->subtasks->where('status', 'Done')->count();

        $progress = round(($doneSubtasks / $totalSubtasks) * 100);

        $status = match (true) {
            $progress >= 100 => 'Done',
            $progress > 0 => 'In Progress',
            default => 'To Do',
        };

        $task->update([
            'progress' => $progress,
            'status' => $status,
        ]);
    }

    private function refreshProjectProgress(Project $project): void
    {
        $project->load('projectTasks.subtasks');

        foreach ($project->projectTasks as $task) {
            $this->refreshTaskProgress($task);
        }

        $project->load('projectTasks');

        $tasks = $project->projectTasks;

        if ($tasks->count() === 0) {
            $project->update([
                'progress' => 0,
                'status' => 'Planning',
            ]);

            return;
        }

        $progress = round($tasks->avg('progress'));

        $status = match (true) {
            $progress >= 100 => 'Completed',
            $progress > 0 => 'Ongoing',
            default => 'Planning',
        };

        $project->update([
            'progress' => $progress,
            'status' => $status,
        ]);
    }

    private function authorizeProject(Project $project): void
    {
        if (
            !auth()->check() ||
            $project->user_id !== auth()->id()
        ) {
            abort(403);
        }
    }

    private function ensureTaskBelongsToProject(Project $project, ProjectTask $task): void
    {
        if ($task->project_id !== $project->id) {
            abort(404);
        }
    }

    private function ensureSubtaskBelongsToTask(ProjectTask $task, ProjectSubtask $subtask): void
    {
        if ($subtask->task_id !== $task->id) {
            abort(404);
        }
    }

    private function logActivity(Project $project, string $action, string $targetType, string $description): void
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'project_id' => $project->id,
            'action' => $action,
            'target_type' => $targetType,
            'target_id' => $project->id,
            'description' => $description,
        ]);
    }
}