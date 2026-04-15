<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RiskController;
use App\Http\Controllers\RiskCategoryController;

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/projects');
});

/*
|--------------------------------------------------------------------------
| Projects
|--------------------------------------------------------------------------
*/

Route::resource('projects', ProjectController::class);

/*
|--------------------------------------------------------------------------
| Risk Categories (Nested)
|--------------------------------------------------------------------------
*/

Route::resource(
    'projects.categories', // ganti 'projects.risk-categories' jika error
    RiskCategoryController::class
);

/*
|--------------------------------------------------------------------------
| Risks (Nested)
|--------------------------------------------------------------------------
*/

Route::resource(
    'projects.risks',
    RiskController::class
);

/*
|--------------------------------------------------------------------------
| RBS Tree
|--------------------------------------------------------------------------
*/

Route::get('/projects/{project}/rbs',
    [ProjectController::class, 'rbs']
)->name('projects.rbs');

/*
|--------------------------------------------------------------------------
| Future Features
|--------------------------------------------------------------------------
*/

Route::get('/projects/{project}/matrix',
    [ProjectController::class, 'matrix']
);

Route::get(
    '/projects/{project}/risks/{risk}/recommendation',
    [RiskController::class, 'recommendation']
)->name('risks.recommendation');

/*
|--------------------------------------------------------------------------
| Create Risk From Category
|--------------------------------------------------------------------------
*/

// Route::get(
//     '/projects/{project}/categories/{category}/risks/create',
//     [RiskController::class, 'create']
// )->name('risks.create.from.category');