<?php

use App\Http\Controllers\Api as Controllers;
use Illuminate\Support\Facades\Route;

Route::prefix('/auth')->name('auth.')->controller(Controllers\AuthController::class)->group(function () {

    Route::post('/registration', 'register')->name('register');

    Route::post('/login', 'login')->name('login');

    Route::post('/logout', 'logout')->name('logout')->middleware('auth:api');
});

Route::prefix('/users')->name('users.')->middleware('auth:api')->controller(Controllers\UserController::class)->group(function () {

    Route::get('/me', 'getCurrentUser')->name('me');

    Route::get('/{userId}', 'getUserById')->withoutMiddleware('auth:api')->name('user')->whereNumber('userId');

    Route::patch('/choose-category', 'myChooseCategory')->name('choose_category');

    Route::patch('/subscribe', 'mySubscriptionToPlan')->name('subscription_plan');

    Route::patch('/cancel-plan', 'myUnSubscriptionToPlan')->name('unsubscription_plan');

    Route::patch('/change-me', 'changeMe')->name('change_information');

    Route::patch('/{userId}/role', 'changeUserRole')->middleware('admin-route')->name('change_role')->whereNumber('userId');
});

Route::prefix('/categories')->name('categories.')->controller(Controllers\CategoryController::class)->group(function () {

    Route::get('/', 'getAllCategories')->name('all_categories');

    Route::get('/{categoryId}', 'getCategoryById')->name('category')->whereNumber('categoryId');

    Route::post('/', 'createCategory')->middleware('admin-route')->name('create_category')->middleware('auth:api');

    Route::patch('/{categoryId}', 'updateCategory')->middleware('admin-route')->name('update_category')->whereNumber('categoryId')->middleware('auth:api');

    Route::delete('/{categoryId}', 'deleteCategory')->middleware('admin-route')->name('destroy_category')->whereNumber('categoryId')->middleware('auth:api');
});

Route::prefix('/comments')->name('comments.')->controller(Controllers\CommentController::class)->group(function () {

    Route::get('/', 'getRandomComments')->name('random_comments');

    Route::post('/', 'createComment')->middleware('auth:api')->name('create_comment');

    Route::patch('/{commentId}', 'updateComment')->middleware('auth:api')->middleware('admin-route')->name('update_comment')->whereNumber('commentId');

    Route::delete('/{commentId}', 'deleteComment')->middleware('auth:api')->middleware('admin-route')->name('destroy_comment')->whereNumber('commentId');
});

Route::prefix('/marks')->name('marks.')->middleware('auth:api')->controller(Controllers\MarkController::class)->group(function () {

    Route::get('/{categoryId}', 'existMark')->name('check_mark')->whereNumber('categoryId');
    
    Route::post('/', 'createMark')->name('create_mark');

    Route::patch('/{markId}', 'updateMark')->middleware('admin-route')->name('update_mark')->whereNumber('markId');

    Route::delete('/{markId}', 'deleteMark')->middleware('admin-route')->name('destroy_mark')->whereNumber('markId');
});

Route::prefix('/plans')->name('plans.')->middleware('auth:api')->controller(Controllers\PlanController::class)->group(function () {

    Route::get('/', 'getAllPlans')->name('all_plans');

    Route::get('/{planId}', 'getPlanById')->name('plan')->whereNumber('planId');

    Route::post('/', 'createPlan')->middleware('admin-route')->name('create_plan');

    Route::patch('/{planId}', 'updatePlan')->middleware('admin-route')->name('update_plan')->whereNumber('planId');

    Route::delete('/{planId}', 'deletePlan')->middleware('admin-route')->name('destroy_plan')->whereNumber('planId');
});
