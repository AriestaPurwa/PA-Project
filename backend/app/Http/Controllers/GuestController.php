<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('guest.create-project');
    }

    public function createCategory($parentId = null)
    {
        $project = session('guest_project');

        if (!$project) {
            return redirect('/guest-mode');
        }

        return view('guest.create-category', compact(
            'parentId'
        ));
    }
    
    public function createRisk($categoryId)
    {
        $project = session('guest_project');

        if (!$project) {
            return redirect('/guest-mode');
        }

        return view('guest.create-risk', compact(
            'categoryId'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_project' => 'required|max:255',
            'deskripsi' => 'nullable'
        ]);

        session([
            'guest_project' => [

                'nama_project' => $validated['nama_project'],

                'deskripsi' => $validated['deskripsi'] ?? '',

                'categories' => [],

                'risks' => []

            ]
        ]);

        return redirect('/guest/editor');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|max:255'
        ]);

        $project = session('guest_project');

        if (!$project) {
            return redirect('/guest-mode');
        }

        $newCategory = [

            'id' => uniqid(),

            'nama_kategori' => $request->nama_kategori,

            'children' => [],

            'risks' => []

        ];

        // ROOT CATEGORY
        if (!$request->parent_id) {

            $project['categories'][] = $newCategory;

        } else {

            $project['categories'] =
                $this->insertSubcategory(
                    $project['categories'],
                    $request->parent_id,
                    $newCategory
                );
        }

        session([
            'guest_project' => $project
        ]);

        return redirect('/guest/editor');
    }

    public function storeRisk(Request $request)
    {
        $request->validate([

            'nama_risiko' => 'required|max:255',

            'probability' => 'required|integer|min:1|max:5',

            'impact' => 'required|integer|min:1|max:5',

            'category_id' => 'required'

        ]);

        $project = session('guest_project');

        if (!$project) {
            return redirect('/guest-mode');
        }

        $score =
            $request->probability
            * $request->impact;

        if ($score >= 15) {

            $level = 'High';

        } elseif ($score >= 8) {

            $level = 'Medium';

        } else {

            $level = 'Low';
        }

        $newRisk = [

            'id' => uniqid(),

            'nama_risiko' => $request->nama_risiko,

            'probability' => $request->probability,

            'impact' => $request->impact,

            'risk_score' => $score,

            'risk_level' => $level
        ];

        $project['categories'] =
            $this->insertRiskIntoCategory(
                $project['categories'],
                $request->category_id,
                $newRisk
            );

        session([
            'guest_project' => $project
        ]);

        return redirect('/guest/editor');
    }

    public function editor()
    {
        $project = session('guest_project');

        if (!$project) {
            return redirect('/guest-mode');
        }

        $categories = $project['categories'] ?? [];

        $risks = $project['risks'] ?? [];

        $matrix = $this->generateGuestRiskMatrix($categories);

        return view('guest.editor', compact(
            'project',
            'categories',
            'risks',
            'matrix'
        ));
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function insertSubcategory(
        $categories,
        $parentId,
        $newCategory
    ) {
        foreach ($categories as &$category) {

            if ($category['id'] == $parentId) {

                $category['children'][] = $newCategory;

                return $categories;
            }

            if (!empty($category['children'])) {

                $category['children'] =
                    $this->insertSubcategory(
                        $category['children'],
                        $parentId,
                        $newCategory
                    );
            }
        }

        return $categories;
    }

    private function insertRiskIntoCategory(
        $categories,
        $categoryId,
        $newRisk
    ) {

        foreach ($categories as &$category) {

            if ($category['id'] == $categoryId) {

                $category['risks'][] = $newRisk;

                return $categories;
            }

            if (!empty($category['children'])) {

                $category['children'] =
                    $this->insertRiskIntoCategory(
                        $category['children'],
                        $categoryId,
                        $newRisk
                    );
            }
        }

        return $categories;
    }

    private function generateGuestRiskMatrix(array $categories)
    {
        $matrix = [];

        for ($impact = 1; $impact <= 5; $impact++) {
            for ($probability = 1; $probability <= 5; $probability++) {
                $matrix[$impact][$probability] = 0;
            }
        }

        $collectRisks = function ($categories) use (&$collectRisks, &$matrix) {
            foreach ($categories as $category) {
                foreach ($category['risks'] ?? [] as $risk) {
                    $impact = (int) ($risk['impact'] ?? 0);
                    $probability = (int) ($risk['probability'] ?? 0);

                    if ($impact >= 1 && $impact <= 5 && $probability >= 1 && $probability <= 5) {
                        $matrix[$impact][$probability]++;
                    }
                }

                if (!empty($category['children'])) {
                    $collectRisks($category['children']);
                }
            }
        };

        $collectRisks($categories);

        return $matrix;
    }
}
