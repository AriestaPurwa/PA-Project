<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RiskController;
use App\Http\Controllers\RiskCategoryController;
use App\Http\Controllers\AuthController;



Route::middleware('auth')->group(function () {

    Route::get('/projects', [ProjectController::class, 'index'])
        ->name('projects.index');

});

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
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::get('/guest-mode', function () {
    return redirect('/projects/create?guest=1');
});


//testing only
Route::get('/try-test', function () {
    dd('TRY TEST WORKS'); 
});



/*
|--------------------------------------------------------------------------
| login-register
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin']);
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
Route::get('/projects/{project}/edit',
    [ProjectController::class, 'edit'])
    ->name('projects.edit');

Route::put('/projects/{project}',
    [ProjectController::class, 'update'])
    ->name('projects.update');

 //edit risk
Route::get('/projects/{project}/risks/{risk}/edit',
    [RiskController::class, 'edit'])
    ->name('projects.risks.edit');

Route::put('/projects/{project}/risks/{risk}',
    [RiskController::class, 'update'])
    ->name('projects.risks.update');

// Route::get(
//     '/projects/{project}/categories/{category}/risks/create',
//     [RiskController::class, 'create']
// )->name('risks.create.from.category');