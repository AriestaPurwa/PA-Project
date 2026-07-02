<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Risk;
use App\Models\Project;
use App\Models\RiskCategory;
use App\Services\ActivityLogService;
use App\Services\RecommendationService;

class RiskController extends Controller
{
    /**
     * Form tambah risk
     */
    public function create(Project $project)
    {
        $this->authorizeProject($project);
        $categories = RiskCategory::where('project_id', $project->id)->get();

        $selectedCategory = request('category_id');

        return view('risks.create', compact(
            'project',
            'categories',
            'selectedCategory'
        ));
    }

    /**
     * Simpan risk
     */
    public function store(Request $request, Project $project)
    {
        $this->authorizeProject($project);
        $validated = $request->validate([
            'nama_risiko' => 'required|string|max:255',
            'category_id' => 'required|exists:risk_categories,id',
            'probability' => 'nullable|integer|min:1|max:5',
            'impact' => 'nullable|integer|min:1|max:5',
            'deskripsi' => 'nullable|string'
        ]);

        // auto hitung risk score
        $riskScore = ($validated['probability'] ?? 0)
                   * ($validated['impact'] ?? 0);

        $score = $request->probability * $request->impact;

        // tentukan level
        if ($score >= 15) {
            $level = 'High';
        } elseif ($score >= 8) {
            $level = 'Medium';
        } else {
            $level = 'Low';
        }

        $risk = Risk::create([
            'project_id'  => $project->id,
            'category_id' => $request->category_id,
            'nama_risiko' => $request->nama_risiko,
            'probability' => $request->probability,
            'impact'      => $request->impact,
            'risk_score'  => $riskScore,
            'risk_level'  => $level,
        ]);
        
        ActivityLogService::log(
            $project->id,'create','risk',
            $risk->id,
            'Created new risk: ' . $risk->nama_risiko
        );

        return redirect()
            ->route('projects.show', $project->id)
            ->with('success', 'Risk berhasil ditambahkan');
    }

    /**
     * Detail risk
     */


    public function show(Project $project, Risk $risk)
    {
        $this->authorizeProject($project);

        $risk->load('project.projectType');

        $recommendation = RecommendationService::get(
            $risk->project->projectType->name,
            $risk->risk_level
        );

        return view(
            'risks.show',
            compact('project', 'risk', 'recommendation')
        );
    }

    public function edit(Project $project, Risk $risk)
    {
        $this->authorizeProject($project);

        $categories = $project->riskCategories()
            ->orderBy('nama_kategori')
            ->get();

        return view(
            'risks.edit',
            compact('project', 'risk', 'categories')
        );
    }

    public function update(
        Request $request,
        Project $project,
        Risk $risk
    ) {
        $this->authorizeProject($project);

        $request->validate([
            'nama_risiko' => 'required|max:255',
            'probability' => 'required|integer|min:1|max:5',
            'impact' => 'required|integer|min:1|max:5',
            'deskripsi' => 'nullable',
        ]);

        $score = $request->probability * $request->impact;

        if ($score >= 15) {
            $level = 'High';
        } elseif ($score >= 8) {
            $level = 'Medium';
        } else {
            $level = 'Low';
        }

        $risk->update([
            'nama_risiko' => $request->nama_risiko,
            'probability' => $request->probability,
            'impact' => $request->impact,
            'deskripsi' => $request->deskripsi,
        ]);

        ActivityLogService::log(

            $project->id,'update','risk',
            $risk->id,

            'Updated risk: ' . $risk->nama_risiko

        );

        return redirect()
            ->route('projects.show', $project->id)
            ->with('success', 'Risk updated successfully');
    }

    /**
     * Hapus risk
     */
    public function destroy(Project $project, Risk $risk)
    {
        $this->authorizeProject($project);
        $risk->delete();

        ActivityLogService::log(

            $project->id, 'delete','risk',
            $risk->id,

            'Deleted risk: ' . $risk->nama_risiko

        );
        return redirect()
            ->route('projects.show', $project->id)
            ->with('success', 'Risk berhasil dihapus');
    }

    private function authorizeProject(Project $project)
    {
        if ($project->is_guest) {
            return;
        }

        if (!auth()->check() || $project->user_id !== auth()->id()) {
            abort(403);
        }
    }
}