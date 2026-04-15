<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Risk;
use App\Models\Project;
use App\Models\RiskCategory;

class RiskController extends Controller
{
    /**
     * Form tambah risk
     */
    public function create(Project $project)
    {
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

        Risk::create([
            'project_id'  => $project->id,
            'category_id' => $request->category_id,
            'nama_risiko' => $request->nama_risiko,
            'probability' => $request->probability,
            'impact'      => $request->impact,
            'risk_score'  => $riskScore,
            'risk_level'  => $level,
        ]);

        return redirect()
            ->route('projects.show', $project->id)
            ->with('success', 'Risk berhasil ditambahkan');
    }

    /**
     * Detail risk
     */
    public function show(Risk $risk)
    {
        return view('risks.show', compact('risk'));
    }

    /**
     * Hapus risk
     */
    public function destroy(Project $project, Risk $risk)
    {
        $risk->delete();

        return redirect()
            ->route('projects.show', $project->id)
            ->with('success', 'Risk berhasil dihapus');
    }
}