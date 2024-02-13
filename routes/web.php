<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',                   [App\Http\Controllers\Front\HomeController::class, 'setLocaleOnHomepage']);

Route::group(['prefix' => '{lang}', 'middleware' => ['Language', 'variables'], 'where' => ['[a-zA-Z]{2}']], function () {

    /**
     * Change app locale
     */
    Route::get('/changeLocale',     [App\Http\Controllers\Front\HomeController::class, 'changeLocale'])->name('changeLocale');

    /* Pricing document route */
    Route::get('pricing',           [App\Http\Controllers\Front\HomeController::class, 'pricing'])->name('pricing');

    /* Terms and conditions document route */
    Route::get('terms',             [App\Http\Controllers\Front\HomeController::class, 'terms'])->name('tos');

    /**
     * Home Routes
     */
    Route::get('/login',            [App\Http\Controllers\Front\HomeController::class, 'login'])->name('login');

    /*
    * Invitation accept routes
    */
    Route::get('/invited/{item}',   [App\Http\Controllers\Front\CompanyController::class, 'invited_users'])->name('company.users.invited');
    Route::post('/invited',         [App\Http\Controllers\Front\CompanyController::class, 'invite_accepted'])->name('company.users.invite_accepted.post');

    /* Responder pages */
    Route::get('/responder/{ticket}/{responder}', [App\Http\Controllers\Front\HomeController::class, 'responder'])->name('responder');
    Route::post('/responder/{ticket}/{responder}/update',    [App\Http\Controllers\Front\HomeController::class, 'responderUpdate'])->name('responder.update');

    Route::group(['middleware' => ['auth']], function () {

        /**
         * Home Routes
         */
        Route::get('/',           [App\Http\Controllers\Front\HomeController::class, 'index'])->name('home.index');

        /**
         * Two Factor Authentication Routes
         */
        Route::get('/tfa',        [App\Http\Controllers\Front\HomeController::class, 'tfa'])->name('tfa.index');


        /**
         * Tickets Routes
         */
        Route::group(['prefix' => 'tickets', 'as' => 'ticket.'], function () {
            Route::get('/',                     [App\Http\Controllers\Front\TicketController::class, 'index'])->name('index');
            Route::get('/new',                  [App\Http\Controllers\Front\TicketController::class, 'newAnalyse'])->name('newAnalyse');
            Route::post('/new',                 [App\Http\Controllers\Front\TicketController::class, 'newAnalyseStore'])->name('newAnalyseStore');
            Route::get('/create/{req_id}',      [App\Http\Controllers\Front\TicketController::class, 'create'])->name('create');
            Route::post('/create/{req_id}',     [App\Http\Controllers\Front\TicketController::class, 'store'])->name('store');
            Route::get('/intro/{ticket_id}',    [App\Http\Controllers\Front\TicketController::class, 'intro'])->name('intro');
            Route::get('/question/{ticket_id}', [App\Http\Controllers\Front\TicketController::class, 'question'])->name('question');
            Route::get('/pending',              [App\Http\Controllers\Front\TicketController::class, 'pending'])->name('pending');

            Route::get('/{item}',               [App\Http\Controllers\Front\TicketController::class, 'show'])->name('show');
            Route::get('/{item}/edit',          [App\Http\Controllers\Front\TicketController::class, 'edit'])->name('edit');
            Route::post('/{item}/update',       [App\Http\Controllers\Front\TicketController::class, 'update'])->name('update');
            Route::post('/{item}/submit',       [App\Http\Controllers\Front\TicketController::class, 'submit'])->name('submit');
            Route::get('/review/{ticket_id}',   [App\Http\Controllers\Front\TicketController::class, 'review'])->name('review');
            Route::get('/rating/{ticket_id}',   [App\Http\Controllers\Front\TicketController::class, 'rating'])->name('rating');
            Route::post('/{item}/revSub',       [App\Http\Controllers\Front\TicketController::class, 'revSub'])->name('reviewSubmit');
            Route::post('/{item}/ratSub',       [App\Http\Controllers\Front\TicketController::class, 'ratSub'])->name('ratingSubmit');
            Route::get('/{item}/delete',        [App\Http\Controllers\Front\TicketController::class, 'destroy'])->name('destroy');
            Route::get('/user',                 [App\Http\Controllers\Front\TicketController::class, 'user'])->name('user');
            Route::get('/summarize',            [App\Http\Controllers\Front\TicketController::class, 'summarize'])->name('summarize');

            Route::get('/comps/{item}',         [App\Http\Controllers\Front\TicketController::class, 'compTicket'])->name('compTicket');

            Route::get('/report_main_chart/{item}', [App\Http\Controllers\Front\TicketController::class, 'report_main_chart'])->name('report_main_chart');
            Route::post('/report_main_chart/{item}',[App\Http\Controllers\Front\TicketController::class, 'report_main_chart'])->name('chart.post');

            Route::post('/invite',              [App\Http\Controllers\Front\TicketController::class, 'invite'])->name('invite');

            Route::post('/deadline',            [App\Http\Controllers\Front\TicketController::class, 'deadline'])->name('update.deadline');
        });

        Route::get('/company',                  [App\Http\Controllers\Front\TicketController::class, 'company'])->name('ticket.company');


        /**
         * User Routes
         */
        Route::group(['prefix' => 'users', 'as' => 'user.'], function () {
            Route::get('/',                     [App\Http\Controllers\Front\UserController::class, 'index'])->name('index');
            Route::get('/create',               [App\Http\Controllers\Front\UserController::class, 'create'])->name('create');
            Route::post('/create',              [App\Http\Controllers\Front\UserController::class, 'store'])->name('store');
            Route::get('/{item}/edit',          [App\Http\Controllers\Front\UserController::class, 'show'])->name('show');
            Route::get('/{item}/edit',          [App\Http\Controllers\Front\UserController::class, 'edit'])->name('edit');
            Route::patch('/{item}/update',      [App\Http\Controllers\Front\UserController::class, 'update'])->name('update');
            Route::get('/{item}/delete',        [App\Http\Controllers\Front\UserController::class, 'destroy'])->name('destroy');
            Route::get('/profile',              [App\Http\Controllers\Front\UserController::class, 'profile'])->name('profile');
            Route::post('/profile',             [App\Http\Controllers\Front\UserController::class, 'updateProfile'])->name('profile.update');
            Route::get('/changePass',           [App\Http\Controllers\Front\UserController::class, 'password'])->name('changePass');
            Route::post('/password',            [App\Http\Controllers\Front\UserController::class, 'changePassword'])->name('password.update');
            Route::get('/company',              [App\Http\Controllers\Front\UserController::class, 'company'])->name('company');
            Route::get('/consultant',           [App\Http\Controllers\Front\UserController::class, 'consultant'])->name('consultant');
            Route::get('/invite',               [App\Http\Controllers\Front\UserController::class, 'invite'])->name('invite');
        });

        Route::get('/consultant/companies',     [App\Http\Controllers\Front\CompanyController::class, 'consultantCompanies'])->name('consultant.companies');

        /**
         *
         * Report Routes
         */
        Route::group(['prefix' => 'reports', 'as' => 'report.'], function () {
            Route::get('/format',               [App\Http\Controllers\Front\ReportController::class, 'format'])->name('format');
            Route::post('/format',              [App\Http\Controllers\Front\ReportController::class, 'formatStore'])->name('format.store');
            Route::get('/format/{item}',        [App\Http\Controllers\Front\ReportController::class, 'formatShow'])->name('format.show');
            Route::post('/format/{item}',       [App\Http\Controllers\Front\ReportController::class, 'formatUpdate'])->name('format.update');
            Route::get('/format/{item}/del',    [App\Http\Controllers\Front\ReportController::class, 'formatDestroy'])->name('format.destroy');
            Route::get('/composer/{item}',      [App\Http\Controllers\Front\ReportController::class, 'composer'])->name('composer');
            Route::post('/composer/{item}',     [App\Http\Controllers\Front\ReportController::class, 'composerStore'])->name('composer.post');

            Route::get('/requests',             [App\Http\Controllers\Front\ReportController::class, 'requests'])->name('request');
            Route::get('/requests/{item}',      [App\Http\Controllers\Front\ReportController::class, 'createRequest'])->name('request.edit');
            Route::post('/requests/{item}',     [App\Http\Controllers\Front\ReportController::class, 'updateRequest'])->name('request.update');

            Route::group(['middleware' => ['admin.auth']], function () {
                Route::get('/',                 [App\Http\Controllers\Front\ReportController::class, 'index'])->name('mlreport.index');
                Route::post('/create',          [App\Http\Controllers\Front\ReportController::class, 'store'])->name('mlreport.store');
                Route::get('/{item}/edit',      [App\Http\Controllers\Front\ReportController::class, 'edit'])->name('mlreport.edit');
                Route::post('/{item}/update',   [App\Http\Controllers\Front\ReportController::class, 'update'])->name('mlreport.update');
                Route::get('/{item}/delete',    [App\Http\Controllers\Front\ReportController::class, 'destroy'])->name('mlreport.destroy');
                Route::get('/report/composer/{item}',  [App\Http\Controllers\Front\ReportController::class, 'show'])->name('mlreport.composer');
                Route::post('/report/composer/{item}',  [App\Http\Controllers\Front\ReportController::class, 'composerPost'])->name('mlreport.composer.post');
            });

        });

        /**
         * Tos Routes
         */
        Route::group(['prefix' => 'tos', 'as' => 'tos.'], function () {
            Route::get('/',                     [App\Http\Controllers\Front\TosController::class, 'index'])->name('index');
            Route::get('/comp',                 [App\Http\Controllers\Front\TosController::class, 'index_with_comp'])->name('index_with_comp');
            Route::get('/create',               [App\Http\Controllers\Front\TosController::class, 'create'])->name('create');
            Route::post('/create',              [App\Http\Controllers\Front\TosController::class, 'store'])->name('store');
            Route::get('/{item}/edit',          [App\Http\Controllers\Front\TosController::class, 'show'])->name('show');
            Route::get('/{item}/edit',          [App\Http\Controllers\Front\TosController::class, 'edit'])->name('edit');
            Route::patch('/{item}/update',      [App\Http\Controllers\Front\TosController::class, 'update'])->name('update');
            Route::get('/{item}/delete',        [App\Http\Controllers\Front\TosController::class, 'destroy'])->name('destroy');
        });

        /**
         * Company Routes
         */
        Route::group(['prefix' => 'companies', 'as' => 'company.'], function () {
            Route::group(['middleware' => 'admin.auth'], function () {
                Route::get('/',                     [App\Http\Controllers\Front\CompanyController::class, 'index'])->name('index');
                Route::get('/create',               [App\Http\Controllers\Front\CompanyController::class, 'create'])->name('create');
                Route::post('/create',              [App\Http\Controllers\Front\CompanyController::class, 'store'])->name('store');
                Route::get('/{item}/edit',          [App\Http\Controllers\Front\CompanyController::class, 'show'])->name('show');
                Route::get('/{item}/edit',          [App\Http\Controllers\Front\CompanyController::class, 'edit'])->name('edit');
                Route::post('/{item}/update',       [App\Http\Controllers\Front\CompanyController::class, 'update'])->name('update');
                Route::get('/{item}/delete',        [App\Http\Controllers\Front\CompanyController::class, 'destroy'])->name('destroy');
                Route::get('/{item}/suspend',       [App\Http\Controllers\Front\CompanyController::class, 'suspend'])->name('suspend');
                Route::get('/{item}/activate',      [App\Http\Controllers\Front\CompanyController::class, 'activate'])->name('activate');
                Route::get('/{item}/renew',         [App\Http\Controllers\Front\CompanyController::class, 'renew'])->name('renew');
            });
            Route::get('/{item}/module',            [App\Http\Controllers\Front\CompanyController::class, 'module'])->name('module');
            Route::post('/package-update',          [App\Http\Controllers\Front\CompanyController::class, 'package_updater'])->name('package_updater');
            Route::post('/package-save',            [App\Http\Controllers\Front\CompanyController::class, 'package_save'])->name('package_save');

            Route::get('/users',                [App\Http\Controllers\Front\CompanyController::class, 'users'])->name('users')->middleware('company_owner');
            Route::get('/users/add',            [App\Http\Controllers\Front\CompanyController::class, 'add_user'])->name('users.add')->middleware('company_owner');
            Route::post('/users/add',           [App\Http\Controllers\Front\CompanyController::class, 'post_add_user'])->name('users.add.post');
            Route::get('/users/invite',         [App\Http\Controllers\Front\CompanyController::class, 'invite'])->name('users.invite')->middleware('company_owner');
            Route::post('/users/invite',        [App\Http\Controllers\Front\CompanyController::class, 'post_invite'])->name('users.invite.post')->middleware('company_owner');
            Route::get('/users/{item}/del',     [App\Http\Controllers\Front\CompanyController::class, 'user_destroy'])->name('users.destroy');
            Route::get('/profile',              [App\Http\Controllers\Front\CompanyController::class, 'profile'])->name('profile')->middleware('company_owner');
            Route::post('/update',              [App\Http\Controllers\Front\CompanyController::class, 'updateProfile'])->name('profile.update')->middleware('company_owner');
        });



        /**
         * Language Routes
         */
        Route::group(['prefix' => 'languages', 'as' => 'language.', 'middleware' => ['admin.auth']], function () {
            Route::get('/',                     [App\Http\Controllers\Front\LanguageController::class, 'index'])->name('index');
            Route::get('/create',               [App\Http\Controllers\Front\LanguageController::class, 'create'])->name('create');
            Route::post('/create',              [App\Http\Controllers\Front\LanguageController::class, 'store'])->name('store');
            Route::get('/{item}/edit',          [App\Http\Controllers\Front\LanguageController::class, 'show'])->name('show');
            Route::get('/{item}/edit',          [App\Http\Controllers\Front\LanguageController::class, 'edit'])->name('edit');
            Route::patch('/{item}/update',      [App\Http\Controllers\Front\LanguageController::class, 'update'])->name('update');
            Route::get('/{item}/delete',        [App\Http\Controllers\Front\LanguageController::class, 'destroy'])->name('destroy');
        });

        /**
         * Methods Routes
         */
        Route::group(['prefix' => 'methods', 'as' => 'method.', 'middleware' => ['admin.auth']], function () {
            Route::get('/',                     [App\Http\Controllers\Front\MethodController::class, 'index'])->name('index');
            Route::get('/create',               [App\Http\Controllers\Front\MethodController::class, 'create'])->name('create');
            Route::post('/create',              [App\Http\Controllers\Front\MethodController::class, 'store'])->name('store');
            Route::get('/{item}/edit',          [App\Http\Controllers\Front\MethodController::class, 'show'])->name('show');
            Route::get('/{item}/edit',          [App\Http\Controllers\Front\MethodController::class, 'edit'])->name('edit');
            Route::post('/{item}/update',       [App\Http\Controllers\Front\MethodController::class, 'update'])->name('update');
            Route::post('/{item}/companies',    [App\Http\Controllers\Front\MethodController::class, 'companies'])->name('companies');
            Route::get('/{item}/delete',        [App\Http\Controllers\Front\MethodController::class, 'destroy'])->name('destroy');
        });

        /**
         * Industries Routes
         */
        Route::group(['prefix' => 'industries', 'as' => 'industry.', 'middleware' => ['admin.auth']], function () {
            Route::get('/',                     [App\Http\Controllers\Front\IndustryTypeController::class, 'index'])->name('index');
            Route::get('/create',               [App\Http\Controllers\Front\IndustryTypeController::class, 'create'])->name('create');
            Route::post('/create',              [App\Http\Controllers\Front\IndustryTypeController::class, 'store'])->name('store');
            Route::get('/{item}/edit',          [App\Http\Controllers\Front\IndustryTypeController::class, 'edit'])->name('edit');
            Route::post('/{item}/update',       [App\Http\Controllers\Front\IndustryTypeController::class, 'update'])->name('update');
            Route::get('/{item}/delete',        [App\Http\Controllers\Front\IndustryTypeController::class, 'destroy'])->name('destroy');
        });

        /**
         * Questions Routes
         */
        Route::group(['prefix' => 'questions', 'as' => 'question.'], function () {
            Route::get('/',                     [App\Http\Controllers\Front\QuestionController::class, 'index'])->name('index');
            Route::get('/create',               [App\Http\Controllers\Front\QuestionController::class, 'create'])->name('create');
            Route::post('/create',              [App\Http\Controllers\Front\QuestionController::class, 'store'])->name('store');
            Route::get('/{item}/edit',          [App\Http\Controllers\Front\QuestionController::class, 'show'])->name('show');
            Route::get('/{item}/edit',          [App\Http\Controllers\Front\QuestionController::class, 'edit'])->name('edit');
            Route::post('/{item}/update',       [App\Http\Controllers\Front\QuestionController::class, 'update'])->name('update');
            Route::get('/{item}/delete',        [App\Http\Controllers\Front\QuestionController::class, 'destroy'])->name('destroy');
            Route::get('/responder',            [App\Http\Controllers\Front\QuestionController::class, 'responder'])->name('responder.index');
        });


        /**
         * Support Routes
         */
        Route::group(['prefix' => 'supports', 'as' => 'support.'], function () {
            Route::get('/',                     [App\Http\Controllers\Front\SupportController::class, 'index'])->name('index');
            Route::get('/create',               [App\Http\Controllers\Front\SupportController::class, 'create'])->name('create');
            Route::post('/create',              [App\Http\Controllers\Front\SupportController::class, 'store'])->name('store');
            Route::get('/{item}/edit',          [App\Http\Controllers\Front\SupportController::class, 'show'])->name('show');
            Route::patch('/{item}/update',      [App\Http\Controllers\Front\SupportController::class, 'update'])->name('update');
            Route::get('/{item}/delete',        [App\Http\Controllers\Front\SupportController::class, 'destroy'])->name('destroy');

            Route::post('/option',              [App\Http\Controllers\Front\SupportController::class, 'optionUpdate'])->name('option.update');
            Route::post('/reply',               [App\Http\Controllers\Front\SupportController::class, 'reply'])->name('reply');
        });


        /**
         * Packages Routes
         */
        Route::group(['prefix' => 'packages', 'as' => 'package.', 'middleware' => ['admin.auth']], function () {
            Route::get('/',                     [App\Http\Controllers\Front\PackageController::class, 'index'])->name('index');
            Route::get('/create',               [App\Http\Controllers\Front\PackageController::class, 'create'])->name('create');
            Route::post('/create',              [App\Http\Controllers\Front\PackageController::class, 'store'])->name('store');
            Route::get('/{item}/edit',          [App\Http\Controllers\Front\PackageController::class, 'show'])->name('show');
            Route::get('/{item}/edit',          [App\Http\Controllers\Front\PackageController::class, 'edit'])->name('edit');
            Route::patch('/{item}/update',      [App\Http\Controllers\Front\PackageController::class, 'update'])->name('update');
            Route::get('/{item}/delete',        [App\Http\Controllers\Front\PackageController::class, 'destroy'])->name('destroy');
        });

        /**
         * FAQS Routes
         */
        Route::group(['prefix' => 'faqs', 'as' => 'faq.'], function () {
            Route::get('/',                     [App\Http\Controllers\Front\FaqController::class, 'index'])->name('index');
        });

        /**
         * Categories Routes
         */
        Route::group(['prefix' => 'categories', 'as' => 'category.', 'middleware' => ['admin.auth']], function () {
            Route::get('/',                     [App\Http\Controllers\Front\CategoryController::class, 'index'])->name('index');
            Route::get('/create',               [App\Http\Controllers\Front\CategoryController::class, 'create'])->name('create');
            Route::post('/create',              [App\Http\Controllers\Front\CategoryController::class, 'store'])->name('store');
            Route::get('/{item}/edit',          [App\Http\Controllers\Front\CategoryController::class, 'show'])->name('show');
            Route::get('/{item}/edit',          [App\Http\Controllers\Front\CategoryController::class, 'edit'])->name('edit');
            Route::post('/{item}/update',       [App\Http\Controllers\Front\CategoryController::class, 'update'])->name('update');
            Route::get('/{item}/delete',        [App\Http\Controllers\Front\CategoryController::class, 'destroy'])->name('destroy');
            Route::post('/sortable',            [App\Http\Controllers\Front\CategoryController::class, 'sortable'])->name('sortable');
        });

        Route::get('feedback',                  [App\Http\Controllers\Front\SupportController::class, 'feedback'])->name('feedback');

        Route::get('logout',      [App\Http\Controllers\Front\UserController::class, 'logout'])->name('user.logout');
    });

    /*
    * Login Route
    */
    Route::post('/login',         [App\Http\Controllers\Front\UserController::class, 'login'])->name('login.post');

    /*
    * Register Routes
    */
    Route::post('/comp',          [App\Http\Controllers\Front\UserController::class, 'companyUserRegister'])->name('companyRegister.post');
    Route::post('/user',          [App\Http\Controllers\Front\UserController::class, 'userRegister'])->name('userRegister.post');
    Route::post('/cons',          [App\Http\Controllers\Front\UserController::class, 'consultantUserRegister'])->name('consultantRegister.post');

    Route::post('/forgot-pass',   [App\Http\Controllers\Front\UserController::class, 'forgotPassword'])->name('forgotPassword.post');
    Route::get('/resetPassword/{usr}',  [App\Http\Controllers\Front\UserController::class, 'showResetPass'])->name('resetPassword.get');
    Route::post('/update-pass',   [App\Http\Controllers\Front\UserController::class, 'updatePassword'])->name('updatePassword.post');



    // only authenticated admins can access this group
   /* Route::group(['as' => 'admin.', 'middleware' => ['admin.auth']], function () {

    });*/

});
