<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    /*
    |---------------------------------
    | AUTH ROUTES (NO middleware)
    |---------------------------------
    */

    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotForm'])
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])
    ->name('password.email');

Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])
    ->name('password.reset');

Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])
    ->name('password.update');


    /*
    |---------------------------------
    | PROTECTED ERP AREA
    |---------------------------------
    | auth = login required
    | permission middleware = role-based control
    */

    Route::middleware(['auth'])->group(function () {

        /*
        |-------------------------
        | DASHBOARD (ALL LOGGED USERS)
        |-------------------------
        */
        Route::get('/dashboard', [DashboardController::class, 'index']);


        /*
        |-------------------------
        | USERS MODULE
        |-------------------------
        */
        Route::middleware('permission:view-users')->group(function () {

            Route::get('/users', [UserController::class, 'index']);
        });

        Route::middleware('permission:create-user')->group(function () {
            Route::get('/users/create', [UserController::class, 'create']);
            Route::post('/users/store', [UserController::class, 'store']);
        });

        Route::middleware('permission:edit-user')->group(function () {
            Route::get('/users/{id}/role', [UserController::class, 'editRole']);
            Route::post('/users/{id}/role', [UserController::class, 'updateRole']);
        });


        /*
        |-------------------------
        | ROLES MODULE
        |-------------------------
        */
        Route::middleware('permission:view-roles')->group(function () {
            Route::get('/roles', [RoleController::class, 'index']);
        });

        Route::middleware('permission:manage-roles')->group(function () {
            Route::post('/roles/store', [RoleController::class, 'store']);

            Route::get('/roles/{role}/permissions', [RoleController::class, 'permissions']);
            Route::post('/roles/{role}/permissions', [RoleController::class, 'assignPermissions']);
        });


        /*
        |-------------------------
        | PERMISSIONS MODULE
        |-------------------------
        */
        Route::middleware('permission:view-permissions')->group(function () {
            Route::get('/permissions', [PermissionController::class, 'index']);
        });

        Route::middleware('permission:manage-permissions')->group(function () {
            Route::post('/permissions/store', [PermissionController::class, 'store']);
        });


        /*
        |-------------------------
        | OTHER MODULES
        |-------------------------
        */
        Route::middleware('permission:view-products')->group(function () {
            Route::get('/products', function () {
                return "Products page";
            });
        });

        Route::middleware('permission:view-orders')->group(function () {
            Route::get('/orders', function () {
                return "Orders page";
            });
        });

    });

});


/*
|--------------------------------------------------------------------------
| FRONT ROUTE
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});