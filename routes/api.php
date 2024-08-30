<?php

use App\Http\Controllers\Admin\AssignRoleController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PermissionUnderRoleController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');

    Route::post('forgot-password', 'forgotPassword');
    Route::post('reset-password', 'resetPassword');
});

Route::group(['middleware'  => 'auth:sanctum'], function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::group(['prefix'  => 'role', 'as' => 'role.', 'middleware' => 'auth:sanctum'], function () {
    Route::controller(RoleController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/edit/{role}', 'edit');
        Route::put('/update/{role}', 'update');
    });
});

Route::group(['prefix'  => 'permission', 'as' => 'permission.'], function () {
    Route::controller(PermissionController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{permission}', 'edit')->name('edit');
        Route::put('/update/{permission}', 'update')->name('update');
        Route::delete('/delete/{permission}', 'delete')->name('delete');
    });
});


Route::group(['prefix'  => 'permission_under_role', 'as' => 'permission_under_role.'], function () {
    Route::controller(PermissionUnderRoleController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::get('/create', 'create')->name('create');
        Route::get('/edit/{roleId}', 'edit')->name('edit');
        Route::put('/update/{roleId}', 'update')->name('update');
        Route::get('/destroy/{roleId}', 'destroy')->name('destroy');
    });
});


Route::group(['prefix'  => 'assign_role', 'as' => 'assign_role.'], function () {
    Route::controller(AssignRoleController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{userId}', 'edit')->name('edit');
        Route::put('/update/{userId}', 'update')->name('update');
        Route::get('/destroy/{userId}', 'destroy')->name('destroy');
    });
});
