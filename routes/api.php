<?php

use Illuminate\Http\Request;
use App\Http\Resources\AdminResource;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\FAQs\FaqController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ZoomController;
use App\Http\Controllers\Audio\SurahController;
use App\Http\Controllers\General\HomeController;
use App\Http\Controllers\Demo\UserDemoController;
use App\Http\Controllers\PayPal\paypalController;
use App\Http\Controllers\Articles\PostsController;
use App\Http\Controllers\Sheikhs\SheikhController;
use App\Http\Controllers\Courses\CoursesController;
use App\Http\Controllers\General\ContactController;
use App\Http\Controllers\Articles\ArticleController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\Http\Controllers\General\SettingsController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Comments\CommentsController;
use App\Http\Controllers\Currency\CurrencyController;
use App\Http\Controllers\Favorite\FavoriteController;
use App\Http\Controllers\Auth\Email\EmailVerifyController;
use App\Http\Controllers\Courses\dashboard\CourseController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Subscription\SubscriptionController;
use App\Http\Controllers\Auth\Password\ResetPasswordController;
use App\Http\Controllers\Authorization\AuthorizationController;
use App\Http\Controllers\Auth\Password\ForgetPasswordController;
use App\Http\Controllers\Egazat\NovelsController;
use \App\Http\Controllers\Egazat\ReadingsController;
use App\Http\Controllers\NovelController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::group(
    [
        // 'prefix' => LaravelLocalization::setLocale() . '/','localeSessionRedirect', 'localizationRedirect', 'localeViewPath',
        'middleware' => [  'auth:sanctum', 'CheckUserStatus', 'checkEmailVerify']
    ], function(){
        Route::get('/admin', function (Request $request) {
            return AdminResource::make($request->user());
    });
        Route::prefix('dashboard/articles')->controller(PostsController::class)->group(function(){
            Route::get('/', 'index');
            Route::post('store', 'store');
            Route::put('update/{post_id}', 'update');
            Route::delete('destroy/{post_id}', 'destroy');
            Route::get('/toggleStatus/5', 'toggleStatus');
        });
        Route::resource('dashboard/course',CourseController::class);
        Route::resource('dashboard/faqs', FaqController::class);
    });

    Route::group(
        [
            // 'prefix' => LaravelLocalization::setLocale().'/',
            // 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
        ], function(){
            ///////////// Settings Controller
            Route::get('settings', [SettingsController::class, 'index']);
            Route::get('home', [HomeController::class, 'index']);
            Route::post('/favorites/{audioId}', [FavoriteController::class, 'store']);
            /////////////// Contacts Controller
            Route::post('contact-us', [ContactController::class, 'store']);
            ////////////////// Articles Controller
            Route::prefix('articles/')->controller(ArticleController::class)->group(function () {
                Route::get('/{keyword?}',  'index');
                Route::get('show/{slug}',  'showArticle');
            });
            /////////////////// Comments Endpoints
            Route::prefix('comments/')->controller(CommentsController::class)->group(function(){
                Route::get('/', 'index');
                Route::post('store', 'storeComment');
                Route::delete('destroy/{id}', 'destroy');
            });
            /////////////////// Demo User Endpoints
            Route::prefix('/demo-user')->controller(UserDemoController::class)->group(function(){
                Route::get('/', 'index');
                Route::post('/store', 'store');
                Route::delete('/destroy/{id}', 'destroy');
            });
            /////////////////// Demo User Endpoints
            Route::prefix('/teacher')->controller(SheikhController::class)->group(function(){
                Route::get('/', 'index');
                Route::post('/store', 'store');
                Route::get('/show/{name}', 'show');
                Route::delete('/destroy/{id}', 'destroy');
            });
            /////////////////// Surah Audio Endpoints
            Route::prefix('/surah')->controller(SurahController::class)->group(function(){
                Route::get('/{keyword?}', 'index');
                Route::post('/store', 'store');
                Route::get('/show/{name}', 'show');
                Route::delete('/destroy/{id}', 'destroy');
            });
            /////////////////// Surah Audio Endpoints
            Route::prefix('/courses')->controller(CoursesController::class)->group(function(){
                Route::get('/', 'index');
                // Route::post('/store', 'store');
                Route::get('/show/{title}', 'show');
                // Route::delete('/destroy/{id}', 'destroy');
            });
            /////////////////// Surah Audio Endpoints
            Route::prefix('/roles')->controller(AuthorizationController::class)->group(function(){
                Route::get('/', 'index');
                Route::post('/store', 'store');
                Route::post('/update/{id}', 'update');
                Route::get('/show/{title}', 'show');
                Route::delete('/destroy/{id}', 'destroy');
            });
            /////////////// Register Endpoint
            Route::post('auth/register', [RegistrationController::class, 'store']);
                /////// Authentication  Endpoints
            Route::prefix('auth/')->controller(AuthController::class)->group(function()
                {
                Route::post('login', 'loginForm')->name('loginForm');
                Route::delete('logout', 'logout');
                Route::delete('logoutAllDevices', 'logoutAllDevices');
            });
                //////// Auth Email Verification Endpoints
            Route::prefix('auth/')->controller(EmailVerifyController::class)->group(function(){
                Route::post('email/verify',  'verify');
                Route::get('email/verify',  'resend');
            });
                //////// Password Reset Endpoints
            Route::post('forget/password', [ForgetPasswordController::class, 'forget']);
            Route::post('reset/password', [ResetPasswordController::class, 'reset']);
        });

/////////// Social Login Oauth Endpoints
Route::group(['middleware' => ['web']], function () {
    Route::get('auth/{provider}', [SocialLoginController::class, 'redirect']);
    Route::get('auth/{provider}/callback', [SocialLoginController::class, 'callback']);
});
////// Zoom API Endpoints
Route::post('create-meeting', [\App\Http\Controllers\ZoomController::class, 'createMeeting']);
////// Currency Exchange Endpoint
Route::get('currency-exchange', [CurrencyController::class, 'index']);
Route::get('convert', [CurrencyController::class, 'convert']);
/////
Route::get('/plans', [SubscriptionController::class, 'index']);
Route::post('/subscribe', [SubscriptionController::class, 'subscribe']);
Route::post('/payment/{id}', [SubscriptionController::class, 'processPayment']);
Route::get('/plans/{id}/trial-lesson', [SubscriptionController::class, 'trialLesson']);

Route::prefix('read/')->controller(ReadingsController::class)->group(function(){
    Route::get('/reads',  'reads');
    Route::get('/',  'readNovels');
    Route::post('/',  'store');
    Route::put('/{id}',  'update');
    Route::delete('/{id}',  'destroy');
});
Route::prefix('novel/')->controller(NovelsController::class)->group(function(){
    Route::get('/',  'index');
    Route::get('/{name}',  'show');
    Route::post('/',  'store');
    Route::put('/{id}',  'update');
    Route::delete('/{id}',  'destroy');
});
