<?php

namespace App\Http\Controllers;

use App\Models\RiskCategory;
use App\Models\Risk;
use App\Models\Project;
use Illuminate\Http\Request;

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
        $categories = $project->categories;

        $parentId = $request->parent;

        return view('risk_categories.create', compact(
            'project',
            'categories',
            'parentId'
        ));
            // $parentId = request('parent'); // ambil parent dari URL

            // return view('risk_categories.create', compact('project', 'parentId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
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
    // public function edit($id)
    // {
    //     $category = RiskCategory::findOrFail($id);

    //     return view('risk_categories.edit', compact('category'));
    // }

    public function edit(Project $project, RiskCategory $category)
    {
        return view('risk_categories.edit', compact('project','category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project, RiskCategory $category)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255'
        ]);

        // $category = RiskCategory::findOrFail($id);

        $category->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()
            ->back()
            ->with('success', 'Kategori berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project, RiskCategory $category)
    {
        // tidak boleh jika punya sub category
        if ($category->children()->exists()) {
            return back()->with('error',
                'Kategori memiliki sub kategori.');
        }

        // tidak boleh jika punya risk
        if ($category->risks()->exists()) {
            return back()->with('error',
                'Kategori masih memiliki risk.');
        }

        $category->delete();

        return back()->with('success', 'Kategori berhasil dihapus');
    }
}
