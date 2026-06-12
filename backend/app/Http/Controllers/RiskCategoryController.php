<?php

namespace App\Http\Controllers;

use App\Models\RiskCategory;
use App\Models\Risk;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Services\ActivityLogService;

class RiskCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index($projectId)
    // {
    //     $project = Project::findOrFail($projectId);

    //     $categories = RiskCategory::where('project_id', $projectId)
    //         ->whereNull('parent_id')
    //         ->with('children')
    //         ->get();

    //     return view('risk_categories.index', compact('project', 'categories'));
    // }

    public function index(Project $project)
    {
        $categories = RiskCategory::where('project_id', $project->id)
            ->whereNull('parent_id')
            ->with('children')
            ->get();

        return view('risk_categories.index', compact('project', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Project $project, Request $request)
    {
        $this->authorizeProject($project);

        $categories = $project->categories;

        $parentId = $request->parent;

        return view('risk_categories.create', compact(
            'project',
            'categories',
            'parentId'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        $this->authorizeProject($project);
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:risk_categories,id'
        ]);

        // hitung level
        if ($request->parent_id) {
            $parent = RiskCategory::find($request->parent_id);
            $level = $parent->level + 1;
        } else {
            $level = 0; // root category
        }

        $category = RiskCategory::create([
            'project_id' => $project->id, // ✅ dari URL
            'parent_id' => $request->parent_id,
            'nama_kategori' => $request->nama_kategori,
            'level' => $level
        ]);

        return redirect()
            ->route('projects.show', $project->id)
            ->with('success', 'Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    // public function edit(Project $project, RiskCategory $category)
    // {
    //     $this->authorizeProject($project);
    //     return view('risk_categories.edit', compact('project','category'));
    // }

    public function edit(Project $project, RiskCategory $category)
    {
        $this->authorizeProject($project);

        return view(
            'risk_categories.edit',
            compact('project', 'category')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Project $project, RiskCategory $category)
    // {
    //     $this->authorizeProject($project);
    //     $request->validate([
    //         'nama_kategori' => 'required|string|max:255'
    //     ]);

    //     // $category = RiskCategory::findOrFail($id);

    //     $category->update([
    //         'nama_kategori' => $request->nama_kategori
    //     ]);

    //     return redirect()
    //         ->back()
    //         ->with('success', 'Kategori berhasil diperbarui');
    // }

    public function update(
        Request $request,
        Project $project,
        RiskCategory $category
    ) {
        $this->authorizeProject($project);

        $request->validate([
            'nama_kategori' => 'required|max:255',
        ]);

        $category->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()
            ->route('projects.show', $project->id)
            ->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, RiskCategory $category)
    {
        $this->authorizeProject($project);

        $this->deleteCategoryRecursive($category);

        return back()->with(
            'success',
            'Kategori dan seluruh isi berhasil dihapus'
        );
    }

    private function deleteCategoryRecursive($category)
    {
        // Hapus semua child category
        foreach ($category->children as $child) {

            $this->deleteCategoryRecursive($child);
        }

        // Hapus semua risk dalam category
        $category->risks()->delete();

        // Hapus category
        $category->delete();
    }

    private function authorizeProject(Project $project)
    {
        // Guest project boleh publik
        if ($project->is_guest) {
            return;
        }

        // Permanent project harus owner
        if (!auth()->check() || $project->user_id !== auth()->id()) {
            abort(403);
        }
    }
}
