<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ViewController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/',                 [ViewController::class, 'home'])->name('home');
Route::get('/policy',           [ViewController::class, 'policy'])->name('policy');
Route::get('/impressum',        [ViewController::class, 'impressum'])->name('impressum');
Route::get('/agb',              [ViewController::class, 'agb'])->name('agb');

Route::get('/products/{id?}',   [ProductController::class, 'viewproduct'])->name('products');

Route::get('/contact',          [ViewController::class, 'contact'])->name('contact');
Route::post('/contact',         [MessageController::class, 'storeMessage'])->name('storemessage');

Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => ['role:1', 'auth']], function () {
    Route::get('',        	[MessageController::class, 'showMessages'])->name('admin.showmessages');
    Route::get('home',       [HomeController::class, 'index'])->name('admin.home');
    Route::get('{id?}',      [MessageController::class, 'showMessage'])->name('admin.showmessage');
    
    Route::post('search',    [MessageController::class, 'findMessage'])->name('admin.findmessage');
    Route::post('{id?}',     [CommentController::class, 'storeComment'])->name('admin.storecomment');   
});

Route::get('/home',             [ViewController::class, 'home'])->name('home');


Route::group(['middleware' => ['guest']], function () {
    Route::get('/register',         [ViewController::class, 'register'])->name('register');
    Route::get('/login',            [ViewController::class, 'login'])->name('login');
});

Route::group(['middleware' => ['isuser', 'auth']], function () {
    Route::get('/about',            [ViewController::class, 'about'])->name('about');
    Route::get('/service',          [ViewController::class, 'service'])->name('service');
});

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::get('/register',         [ViewController::class, 'register'])->name('register');
//Route::get('/login',            [ViewController::class, 'login'])->name('login');

/*

// Authentication Routes...
$this->get('login', 'Auth\LoginController@showLoginForm')->name('login');
$this->post('login', 'Auth\LoginController@login');
$this->post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
$this->get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
$this->post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
$this->get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
$this->post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
$this->get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
$this->post('password/reset', 'Auth\ResetPasswordController@reset');

*/

Route::get('/vue',            [ViewController::class, 'vue'])->name('vue');