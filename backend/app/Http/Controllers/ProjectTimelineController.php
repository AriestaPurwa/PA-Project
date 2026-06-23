<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Project;
use App\Models\ProjectSprint;
use App\Models\Risk;
use App\Models\SprintTask;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectTimelineController extends Controller
{
    public function index(Project $project)
    {
        $this->authorizeProject($project);

        $sprints = $project->sprints()
            ->with(['tasks', 'risks'])
            ->orderBy('sprint_number')
            ->get();

        $risks = Risk::where('project_id', $project->id)
            ->orderByDesc('risk_score')
            ->get();

        $totalSprints = $sprints->count();

        $totalTasks = $sprints->sum(function ($sprint) {
            return $sprint->tasks->count();
        });

        $doneTasks = $sprints->sum(function ($sprint) {
            return $sprint->tasks->where('status', 'Done')->count();
        });

        $assignedRisks = $sprints->sum(function ($sprint) {
            return $sprint->risks->count();
        });

        return view('project_timelines.index', compact(
            'project',
            'sprints',
            'risks',
            'totalSprints',
            'totalTasks',
            'doneTasks',
            'assignedRisks'
        ));
    }

    public function generate(Request $request, Project $project)
    {
        $this->authorizeProject($project);

        $validated = $request->validate([
            'start_date' => ['required', 'date'],
            'total_sprints' => ['required', 'integer', 'min:1', 'max:52'],
            'sprint_duration' => ['required', 'integer', 'min:1', 'max:4'],
        ]);

        if ($project->sprints()->exists()) {
            return back()->withErrors([
                'timeline' => 'Timeline sudah dibuat untuk project ini.'
            ]);
        }

        $startDate = Carbon::parse($validated['start_date']);
        $totalSprints = $validated['total_sprints'];
        $duration = $validated['sprint_duration'];

        for ($i = 1; $i <= $totalSprints; $i++) {
            $sprintStart = $startDate->copy()->addWeeks(($i - 1) * $duration);
            $sprintEnd = $sprintStart->copy()->addDays(($duration * 7) - 1);

            $project->sprints()->create([
                'sprint_number' => $i,
                'name' => 'Sprint ' . $i,
                'start_date' => $sprintStart,
                'end_date' => $sprintEnd,
                'status' => 'Planned',
            ]);
        }

        $project->update([
            'status' => 'Planning',
            'progress' => 0,
        ]);

        $this->logActivity(
            $project,
            'generate_timeline',
            'project_timeline',
            'Generated ' . $totalSprints . ' project sprints.'
        );

        return redirect()
            ->route('projects.timeline.index', $project->id)
            ->with('success', 'Project timeline berhasil dibuat.');
    }

    public function storeTask(Request $request, Project $project, ProjectSprint $sprint)
    {
        $this->authorizeProject($project);
        $this->ensureSprintBelongsToProject($project, $sprint);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'weight' => ['required', 'numeric', 'min:0.1', 'max:1000'],
            'status' => ['required', 'in:To Do,In Progress,Done'],
        ]);

        $sprint->tasks()->create($validated);

        $this->refreshProjectProgress($project);

        $this->logActivity(
            $project,
            'create_task',
            'sprint_task',
            'Created task "' . $validated['name'] . '" in ' . $sprint->name . '.'
        );

        return back()->with('success', 'Task berhasil ditambahkan.');
    }

    public function updateTask(Request $request, Project $project, ProjectSprint $sprint, SprintTask $task)
    {
        $this->authorizeProject($project);
        $this->ensureSprintBelongsToProject($project, $sprint);
        $this->ensureTaskBelongsToSprint($sprint, $task);

        $validated = $request->validate([
            'status' => ['required', 'in:To Do,In Progress,Done'],
        ]);

        $task->update([
            'status' => $validated['status'],
        ]);

        $this->refreshProjectProgress($project);

        $this->logActivity(
            $project,
            'update_task_status',
            'sprint_task',
            'Updated task "' . $task->name . '" status to ' . $validated['status'] . '.'
        );

        return back()->with('success', 'Status task berhasil diperbarui.');
    }

    public function destroyTask(Project $project, ProjectSprint $sprint, SprintTask $task)
    {
        $this->authorizeProject($project);
        $this->ensureSprintBelongsToProject($project, $sprint);
        $this->ensureTaskBelongsToSprint($sprint, $task);

        $taskName = $task->name;

        $task->delete();

        $this->refreshProjectProgress($project);

        $this->logActivity(
            $project,
            'delete_task',
            'sprint_task',
            'Deleted task "' . $taskName . '".'
        );

        return back()->with('success', 'Task berhasil dihapus.');
    }

    public function attachRisk(Request $request, Project $project, ProjectSprint $sprint)
    {
        $this->authorizeProject($project);
        $this->ensureSprintBelongsToProject($project, $sprint);

        $validated = $request->validate([
            'risk_id' => ['required', 'exists:risks,id'],
            'mitigation_status' => ['required', 'in:Open,In Progress,Handled'],
            'notes' => ['nullable', 'string'],
        ]);

        $risk = Risk::findOrFail($validated['risk_id']);

        if ($risk->project_id !== $project->id) {
            abort(403);
        }

        $sprint->risks()->syncWithoutDetaching([
            $risk->id => [
                'mitigation_status' => $validated['mitigation_status'],
                'notes' => $validated['notes'] ?? null,
            ],
        ]);

        $this->logActivity(
            $project,
            'assign_risk_to_sprint',
            'sprint_risk',
            'Assigned risk "' . $risk->nama_risiko . '" to ' . $sprint->name . '.'
        );

        return back()->with('success', 'Risk berhasil ditambahkan ke sprint.');
    }

    public function updateRiskStatus(Request $request, Project $project, ProjectSprint $sprint, Risk $risk)
    {
        $this->authorizeProject($project);
        $this->ensureSprintBelongsToProject($project, $sprint);

        if ($risk->project_id !== $project->id) {
            abort(403);
        }

        $validated = $request->validate([
            'mitigation_status' => ['required', 'in:Open,In Progress,Handled'],
        ]);

        $sprint->risks()->updateExistingPivot($risk->id, [
            'mitigation_status' => $validated['mitigation_status'],
        ]);

        $this->logActivity(
            $project,
            'update_sprint_risk',
            'sprint_risk',
            'Updated risk "' . $risk->nama_risiko . '" status in ' . $sprint->name . '.'
        );

        return back()->with('success', 'Status risk pada sprint berhasil diperbarui.');
    }

    public function detachRisk(Project $project, ProjectSprint $sprint, Risk $risk)
    {
        $this->authorizeProject($project);
        $this->ensureSprintBelongsToProject($project, $sprint);

        if ($risk->project_id !== $project->id) {
            abort(403);
        }

        $sprint->risks()->detach($risk->id);

        $this->logActivity(
            $project,
            'remove_risk_from_sprint',
            'sprint_risk',
            'Removed risk "' . $risk->nama_risiko . '" from ' . $sprint->name . '.'
        );

        return back()->with('success', 'Risk berhasil dihapus dari sprint.');
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

    private function ensureSprintBelongsToProject(Project $project, ProjectSprint $sprint): void
    {
        if ($sprint->project_id !== $project->id) {
            abort(404);
        }
    }

    private function ensureTaskBelongsToSprint(ProjectSprint $sprint, SprintTask $task): void
    {
        if ($task->sprint_id !== $sprint->id) {
            abort(404);
        }
    }

    private function refreshProjectProgress(Project $project): void
    {
        $project->load('sprints.tasks');

        foreach ($project->sprints as $sprint) {
            $tasks = $sprint->tasks;

            if ($tasks->count() === 0) {
                $sprint->update(['status' => 'Planned']);
                continue;
            }

            $doneCount = $tasks->where('status', 'Done')->count();

            if ($doneCount === $tasks->count()) {
                $sprint->update(['status' => 'Completed']);
            } elseif ($tasks->whereIn('status', ['In Progress', 'Done'])->count() > 0) {
                $sprint->update(['status' => 'Ongoing']);
            } else {
                $sprint->update(['status' => 'Planned']);
            }
        }

        $project->load('sprints.tasks');

        $tasks = $project->sprints->flatMap(function ($sprint) {
            return $sprint->tasks;
        });

        if ($tasks->count() === 0) {
            $project->update([
                'progress' => 0,
                'status' => 'Planning',
            ]);

            return;
        }

        $totalWeight = $tasks->sum(function ($task) {
            return (float) $task->weight;
        });

        if ($totalWeight <= 0) {
            $project->update([
                'progress' => 0,
                'status' => 'Planning',
            ]);

            return;
        }

        $earnedWeight = $tasks->sum(function ($task) {
            $factor = match ($task->status) {
                'Done' => 1,
                'In Progress' => 0.5,
                default => 0,
            };

            return (float) $task->weight * $factor;
        });

        $progress = round(($earnedWeight / $totalWeight) * 100);

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