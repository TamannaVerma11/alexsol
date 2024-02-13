<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\SupportController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\TosController;
use App\Http\Controllers\API\TicketController;
use App\Http\Controllers\API\PackageController;
use App\Http\Controllers\API\LanguageController;
use App\Http\Controllers\API\IndustryTypeController;
use App\Http\Controllers\API\MethodController;
use App\Http\Controllers\API\QuestionController;
use App\Http\Controllers\API\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['as' => 'api.'], function () {

    Route::group(['prefix' => 'user', 'as' => 'user.', 'namespace' => 'User'], function () {
        Route::get('/',                 [UserController::class, 'index'])->name('list');
        Route::get('/{id}',             [UserController::class, 'show'])->name('show');
        Route::post('/register',        [UserController::class, 'userRegister'])->name('register');
        Route::post('/company',         [UserController::class, 'companyUserRegister'])->name('company.register');
        Route::post('/consultant',      [UserController::class, 'consultantUserRegister'])->name('consultant.register');
        Route::put('/{id}',             [UserController::class, 'update'])->name('update');
        Route::delete('/{id}',          [UserController::class, 'delete'])->name('delete');

        Route::post('login',            [UserController::class, 'login'])->name('login');
        Route::post('forgot-password',  [UserController::class, 'forgotPassword'])->name('forgotPassword');
        Route::post('update-password',  [UserController::class, 'updatePassword'])->name('updatePassword');

        Route::post('update-profile',   [UserController::class, 'updateProfile'])->name('updateProfile');
        Route::post('change-profile',   [UserController::class, 'changePassword'])->name('changePassword');
    });


    Route::group(['prefix' => 'company', 'as' => 'company.', 'namespace' => 'Company'], function () {
        Route::post('/invite',          [CompanyController::class, 'invite'])->name('user.invite');
        Route::post('/invited',         [CompanyController::class, 'invite_accepted'])->name('user.invite_accepted');
        Route::post('/invite',          [CompanyController::class, 'update'])->name('update');
        Route::post('/invited',         [CompanyController::class, 'updateProfile'])->name('profile.update');
    });

    Route::group(['prefix' => 'tos', 'as' => 'tos.', 'namespace' => 'Tos'], function () {
        Route::post('/update',          [TosController::class, 'update'])->name('create');
    });

    Route::group(['prefix' => 'support', 'as' => 'support.', 'namespace' => 'Support'], function () {
        Route::post('/store',           [SupportController::class, 'store'])->name('create');
        Route::post('/option',          [SupportController::class, 'optionUpdate'])->name('option.update');
    });

    Route::group(['prefix' => 'report', 'as' => 'report.', 'namespace' => 'Report'], function () {
        Route::post('/format',          [ReportController::class, 'formatStore'])->name('format');
        Route::post('/format/update',   [ReportController::class, 'formatUpdate'])->name('format.update');

        Route::post('/mlreport',         [ReportController::class, 'store'])->name('mlreport.store');
        Route::post('/mlreport/update',  [ReportController::class, 'update'])->name('mlreport.update');
    });

    Route::group(['prefix' => 'ticket', 'as' => 'ticket.', 'namespace' => 'Ticket'], function () {
        Route::post('/newAnalyseStore', [TicketController::class, 'newAnalyseStore'])->name('newAnalyseStore');
        Route::post('/store',           [TicketController::class, 'store'])->name('store');
        Route::post('/invite',          [TicketController::class, 'invite'])->name('invite');
    });

    Route::group(['prefix' => 'package', 'as' => 'package.', 'namespace' => 'Package'], function () {
        Route::post('/store',           [PackageController::class, 'store'])->name('create');
    });

    Route::group(['prefix' => 'language', 'as' => 'language.', 'namespace' => 'Language'], function () {
        Route::post('/store',           [LanguageController::class, 'store'])->name('create');
    });

    Route::group(['prefix' => 'industry', 'as' => 'industry.', 'namespace' => 'Industry'], function () {
        Route::post('/store',           [IndustryTypeController::class, 'store'])->name('create');
        Route::post('/update',          [IndustryTypeController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'method', 'as' => 'method.', 'namespace' => 'Method'], function () {
        Route::post('/store',           [MethodController::class, 'store'])->name('create');
        Route::post('/update',          [MethodController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'question', 'as' => 'question.', 'namespace' => 'Question'], function () {
        Route::post('/store',           [QuestionController::class, 'store'])->name('create');
        Route::post('/update',          [QuestionController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'category', 'as' => 'category.', 'namespace' => 'Category'], function () {
        Route::post('/store',           [CategoryController::class, 'store'])->name('create');
        Route::post('/update',          [CategoryController::class, 'update'])->name('update');
    });

    Route::middleware('auth:sanctum')->group(function () {
    });
});
