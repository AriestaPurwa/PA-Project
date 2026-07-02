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

    public function editProject()
    {
        $project = session('guest_project');

        if (!$project) {
            return redirect('/guest-mode')
                ->with('error', 'Guest project tidak ditemukan.');
        }

        return view('guest.project-edit', compact('project'));
    }

    public function updateProject(Request $request)
    {
        $project = session('guest_project');

        if (!$project) {
            return redirect('/guest-mode')
                ->with('error', 'Guest project tidak ditemukan.');
        }

        $validated = $request->validate([
            'nama_project' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $project['nama_project'] = $validated['nama_project'];
        $project['deskripsi'] = $validated['deskripsi'] ?? null;

        session(['guest_project' => $project]);

        return redirect()
            ->route('guest.editor')
            ->with('success', 'Guest project berhasil diperbarui.');
    }

    public function deleteCategory($id)
    {
        $id = (int) $id;

        $project = session('guest_project');

        if (!$project) {
            return redirect('/guest-mode')
                ->with('error', 'Guest project tidak ditemukan.');
        }

        $categories = $project['categories'] ?? [];
        $risks = $project['risks'] ?? [];

        $categoryIdsToDelete = $this->collectGuestCategoryChildren($categories, $id);
        $categoryIdsToDelete[] = $id;

        $categories = array_values(array_filter($categories, function ($category) use ($categoryIdsToDelete) {
            return !in_array((int) $category['id'], $categoryIdsToDelete);
        }));

        $risks = array_values(array_filter($risks, function ($risk) use ($categoryIdsToDelete) {
            return !in_array((int) $risk['category_id'], $categoryIdsToDelete);
        }));

        $project['categories'] = $categories;
        $project['risks'] = $risks;

        session(['guest_project' => $project]);

        return redirect()
            ->route('guest.editor')
            ->with('success', 'Category berhasil dihapus.');
    }

    public function deleteRisk($id)
    {
        $project = session('guest_project');

        if (!$project) {
            return redirect()
                ->route('guest.create')
                ->with('error', 'Guest project tidak ditemukan.');
        }

        $risks = $project['risks'] ?? [];

        $risks = array_values(array_filter($risks, function ($risk) use ($id) {
            return (int) $risk['id'] !== (int) $id;
        }));

        $project['risks'] = $risks;

        session(['guest_project' => $project]);

        return redirect()
            ->route('guest.editor')
            ->with('success', 'Risk berhasil dihapus.');
    }

    public function editCategory($id)
    {
        $id = (int) $id;

        $project = session('guest_project');

        if (!$project) {
            return redirect()
                ->route('guest.create')
                ->with('error', 'Guest project tidak ditemukan.');
        }

        $category = $this->findGuestCategoryRecursive(
            $project['categories'] ?? [],
            $id
        );

        if (!$category) {
            return redirect()
                ->route('guest.editor')
                ->with('error', 'Category tidak ditemukan.');
        }

        return view('guest.category-edit', compact(
            'project',
            'category'
        ));
    }

    public function updateCategory(Request $request, $id)
    {
        $id = (int) $id;

        $project = session('guest_project');

        if (!$project) {
            return redirect()
                ->route('guest.create')
                ->with('error', 'Guest project tidak ditemukan.');
        }

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $category = $this->findGuestCategoryRecursive(
            $project['categories'] ?? [],
            $id
        );

        if (!$category) {
            return redirect()
                ->route('guest.editor')
                ->with('error', 'Category tidak ditemukan.');
        }

        $project['categories'] = $this->updateGuestCategoryRecursive(
            $project['categories'] ?? [],
            $id,
            $validated['nama_kategori']
        );

        session(['guest_project' => $project]);

        return redirect()
            ->route('guest.editor')
            ->with('success', 'Category berhasil diperbarui.');
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

    private function collectGuestCategoryChildren(array $categories, int $parentId): array
    {
        $children = [];

        foreach ($categories as $category) {
            if ((int) ($category['parent_id'] ?? 0) === $parentId) {
                $childId = (int) $category['id'];

                $children[] = $childId;

                $children = array_merge(
                    $children,
                    $this->collectGuestCategoryChildren($categories, $childId)
                );
            }
        }

        return $children;
    }

    private function findGuestCategoryRecursive(array $categories, int $id): ?array
    {
        foreach ($categories as $category) {
            if ((int) $category['id'] === $id) {
                return $category;
            }

            if (!empty($category['children'])) {
                $found = $this->findGuestCategoryRecursive($category['children'], $id);

                if ($found) {
                    return $found;
                }
            }
        }

        return null;
    }

    private function updateGuestCategoryRecursive(array $categories, int $id, string $namaKategori): array
    {
        foreach ($categories as &$category) {
            if ((int) $category['id'] === $id) {
                $category['nama_kategori'] = $namaKategori;
            }

            if (!empty($category['children'])) {
                $category['children'] = $this->updateGuestCategoryRecursive(
                    $category['children'],
                    $id,
                    $namaKategori
                );
            }
        }

        unset($category);

        return $categories;
    }
}
