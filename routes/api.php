<?php


use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\FeedbackCategoryController;
use App\Http\Controllers\Api\FeedbackController;
use Illuminate\Support\Facades\Route;

Route::apiResource('customers', CustomerController::class);
Route::apiResource('feedback', FeedbackController::class);
Route::apiResource('feedback-categories', FeedbackCategoryController::class);
