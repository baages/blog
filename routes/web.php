<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StaticPagesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\StatusesController;
use App\Http\Controllers\FollowersController;

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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', [StaticPagesController::class, 'home'])->name('home');
Route::get('/help', [StaticPagesController::class, 'help'])->name('help');
Route::get('/about', [StaticPagesController::class, 'about'])->name('about');
Route::get('/signup', [UserController::class, 'create'])->name('signup');

Route::resource('/users',UserController::class);

Route::get('login', [SessionsController::class, 'create'])->name('login');
Route::post('login', [SessionsController::class, 'store'])->name('login');
Route::delete('logout', [SessionsController::class, 'destroy'])->name('logout');

Route::get('/users{user}/edit', [UserController::class, 'edit'])->name('users.edit');

Route::get('signup/confirm/{token}', [UserController::class, 'confirmEmail'])->name('confirm_email');

// 显示重置密码的邮箱发送页面
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
// 邮箱发送重设链接
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// 密码更新页面
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
// 执行密码更新操作
Route::post('password/reset', [ResetPasswordController::class , 'reset'])->name('password.update');

// 处理创建微博的请求
// 处理删除微博的请求
Route::resource('statuses', StatusesController::class, ['only' => ['store', 'destroy']]);

// 显示用户的关注人列表
Route::get('/users/{user}/followings', [UserController::class, 'followings'])->name('users.followings');
// 显示用户的粉丝列表
Route::get('/users/{user}/followers', [UserController::class, 'followers'])->name('users.followers');

// 关注用户
Route::post('/users/followers/{user}', [FollowersController::class, 'store'])->name('followers.store');
// 取消关注用户
Route::delete('users/followers/{user}', [FollowersController::class, 'destroy'])->name('followers.destroy');
