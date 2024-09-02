<?php

use App\Http\Controllers\Admin\AssignRoleController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PermissionUnderRoleController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::group(['middleware'  => 'auth:sanctum'], function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::group(['prefix'  => 'user', 'as' => 'user.', 'middleware' => 'auth:sanctum'], function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/edit/{user}', 'edit');
        Route::put('/update/{user}', 'update');
        Route::delete('/delete/{user}', 'delete');
        Route::get('/profile', 'profile');
        Route::get('/all', 'userAll');
    });
});

Route::group(['prefix'  => 'role', 'as' => 'role.', 'middleware' => 'auth:sanctum'], function () {
    Route::controller(RoleController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/edit/{role}', 'edit');
        Route::put('/update/{role}', 'update');
        Route::delete('/delete/{role}', 'delete');
    });
});

Route::group(['prefix'  => 'permission', 'as' => 'permission.'], function () {
    Route::controller(PermissionController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/edit/{permission}', 'edit');
        Route::put('/update/{permission}', 'update');
        Route::delete('/delete/{permission}', 'delete');
        Route::get('/user', 'permissionUser');
    });
});


Route::group(['prefix'  => 'permission_under_role', 'as' => 'permission_under_role.'], function () {
    Route::controller(PermissionUnderRoleController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/edit/{roleId}', 'edit');
        Route::put('/update/{roleId}', 'update');
        Route::delete('/delete/{roleId}', 'delete');
    });
});

Route::group(['prefix'  => 'assign_role', 'as' => 'assign_role.'], function () {
    Route::controller(AssignRoleController::class)->group(function () {
        Route::get('/', 'index');
        Route::post('/store', 'store');
        Route::get('/edit/{userId}', 'edit');
        Route::put('/update/{userId}', 'update');
        Route::delete('/delete/{userId}', 'delete');
    });
});
