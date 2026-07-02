<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RiskController;
use App\Http\Controllers\RiskCategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RiskOverviewController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ProjectTimelineController;



// Route::middleware('auth')->group(function () {

//     Route::get('/projects', [ProjectController::class, 'index'])
//         ->name('projects.index');

// });

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

// Route::get('/', function () {
//     return redirect('/projects');
// });

Route::get('/', function () {
    return view('landing');
});

/*
|--------------------------------------------------------------------------
| Guest Mode Routes
|--------------------------------------------------------------------------
*/

Route::get('/guest-mode', [GuestController::class, 'create'])
    ->name('guest.create');

Route::post('/guest-mode', [GuestController::class, 'store'])
    ->name('guest.store');

Route::get('/guest/editor', [GuestController::class, 'editor'])
    ->name('guest.editor');


// ===== Guest Project =====

Route::get('/guest/project/edit', [GuestController::class, 'editProject'])
    ->name('guest.project.edit');

Route::put('/guest/project/update', [GuestController::class, 'updateProject'])
    ->name('guest.project.update');


// ===== Guest Category =====

Route::get('/guest/category/create/{parentId?}', [GuestController::class, 'createCategory'])
    ->name('guest.category.create');

Route::post('/guest/category/store', [GuestController::class, 'storeCategory'])
    ->name('guest.category.store');

Route::get('/guest/category/{id}/edit', [GuestController::class, 'editCategory'])
    ->name('guest.category.edit');

Route::put('/guest/category/{id}/update', [GuestController::class, 'updateCategory'])
    ->name('guest.category.update');

Route::delete('/guest/category/{id}/delete', [GuestController::class, 'deleteCategory'])
    ->name('guest.category.delete');


// ===== Guest Risk =====

Route::get('/guest/risk/create/{categoryId}', [GuestController::class, 'createRisk'])
    ->name('guest.risk.create');

Route::post('/guest/risk/store', [GuestController::class, 'storeRisk'])
    ->name('guest.risk.store');

Route::get('/guest/risk/{id}', [GuestController::class, 'showRisk'])
    ->name('guest.risk.show');

Route::get('/guest/risk/{id}/edit', [GuestController::class, 'editRisk'])
    ->name('guest.risk.edit');

Route::put('/guest/risk/{id}/update', [GuestController::class, 'updateRisk'])
    ->name('guest.risk.update');

Route::delete('/guest/risk/{id}/delete', [GuestController::class, 'deleteRisk'])
    ->name('guest.risk.delete');

//testing only
Route::get('/try-test', function () {
    dd('TRY TEST WORKS'); 
});



/*
|--------------------------------------------------------------------------
| login-register
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');
    
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout']);

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

// Route::resource(
//     'projects.risks',
//     RiskController::class
// );

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
| Guest Editor
|--------------------------------------------------------------------------
*/ 
Route::get('/try', function () {
    return redirect('/projects/create');
});


/*
|--------------------------------------------------------------------------
| route edit
|--------------------------------------------------------------------------
*/
//edit project
// Route::get('/projects/{project}/edit',
//     [ProjectController::class, 'edit'])
//     ->name('projects.edit');

// Route::put('/projects/{project}',
//     [ProjectController::class, 'update'])
//     ->name('projects.update');

 //edit risk
// Route::get('/projects/{project}/risks/{risk}/edit',
//     [RiskController::class, 'edit'])
//     ->name('projects.risks.edit');

// Route::put('/projects/{project}/risks/{risk}',
//     [RiskController::class, 'update'])
//     ->name('projects.risks.update');

// Route::get(
//     '/projects/{project}/categories/{category}/risks/create',
//     [RiskController::class, 'create']
// )->name('risks.create.from.category');

Route::get(
    '/projects/{project}/history',
    [ActivityLogController::class, 'index']
)->name('projects.history');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/risk-overview', [RiskOverviewController::class, 'index'])
    ->middleware('auth')
    ->name('risk-overview');

Route::get('/activity-log', [ActivityLogController::class, 'globalIndex'])
    ->middleware('auth')
    ->name('activity-log');

Route::get('/reports', [ReportController::class, 'index'])
    ->middleware('auth')
    ->name('reports.index');

Route::get('/reports/{project}', [ReportController::class, 'show'])
    ->middleware('auth')
    ->name('reports.show');

Route::view('/user-guide', 'pages.user-guide')
    ->middleware('auth')
    ->name('user-guide');


Route::get('/settings', [SettingsController::class, 'index'])
    ->middleware('auth')
    ->name('settings');

Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])
    ->middleware('auth')
    ->name('settings.profile.update');

Route::view('/about-system', 'pages.about-system')
    ->middleware('auth')
    ->name('about-system');

Route::middleware('auth')->group(function () {

    Route::get('/projects/{project}/timeline', [ProjectTimelineController::class, 'index'])
        ->name('projects.timeline.index');

    Route::post('/projects/{project}/timeline/tasks', [ProjectTimelineController::class, 'storeTask'])
        ->name('projects.timeline.tasks.store');

    Route::delete('/projects/{project}/timeline/tasks/{task}', [ProjectTimelineController::class, 'destroyTask'])
        ->name('projects.timeline.tasks.destroy');

    Route::post('/projects/{project}/timeline/tasks/{task}/subtasks', [ProjectTimelineController::class, 'storeSubtask'])
        ->name('projects.timeline.subtasks.store');

    Route::put('/projects/{project}/timeline/tasks/{task}/subtasks/{subtask}', [ProjectTimelineController::class, 'updateSubtask'])
        ->name('projects.timeline.subtasks.update');

    Route::delete('/projects/{project}/timeline/tasks/{task}/subtasks/{subtask}', [ProjectTimelineController::class, 'destroySubtask'])
        ->name('projects.timeline.subtasks.destroy');

    Route::post('/projects/{project}/timeline/tasks/{task}/risks', [ProjectTimelineController::class, 'attachRisk'])
        ->name('projects.timeline.risks.attach');

    Route::put('/projects/{project}/timeline/tasks/{task}/risks/{risk}', [ProjectTimelineController::class, 'updateRiskStatus'])
        ->name('projects.timeline.risks.update');

    Route::delete('/projects/{project}/timeline/tasks/{task}/risks/{risk}', [ProjectTimelineController::class, 'detachRisk'])
        ->name('projects.timeline.risks.detach');

});

// Route::put('/projects/{project}/timeline/tasks/{task}/subtasks/{subtask}', [ProjectTimelineController::class, 'updateSubtask'])
//     ->name('projects.timeline.subtasks.update');

Route::get('/projects/{project}/timeline/tasks/{task}/edit', [ProjectTimelineController::class, 'editTask'])
    ->name('projects.timeline.tasks.edit');

Route::put('/projects/{project}/timeline/tasks/{task}', [ProjectTimelineController::class, 'updateTask'])
    ->name('projects.timeline.tasks.update');

Route::get('/projects/{project}/timeline/tasks/{task}/subtasks/{subtask}/edit', [ProjectTimelineController::class, 'editSubtask'])
    ->name('projects.timeline.subtasks.edit');