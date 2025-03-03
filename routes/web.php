<?php

use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panel\SMSController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Panel\HomeController;
use App\Http\Controllers\Panel\RoleController;
use App\Http\Controllers\Panel\UserController;
use App\Http\Controllers\Panel\CheckCodeController;
use App\Http\Controllers\Panel\OrderCodeController;
use App\Http\Controllers\Panel\DataLoggerController;
use App\Http\Controllers\Panel\PermissionController;
use App\Http\Controllers\Panel\ModemSettingController;
use App\Http\Controllers\Panel\IndustrialCityController;
use App\Http\Controllers\Panel\DataLoggerOrderCodeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::namespace('Auth')->middleware('guest')->group(function () {

    Route::get('/', [LoginController::class, 'loginForm'])->name('auth.login');
    Route::post('/post-login', [LoginController::class, 'postLogin'])->name('auth.login.post');
    
});

Route::prefix('panel')->middleware('auth')->namespace('Panel')->group(function () {

    Route::get('/logout', [LoginController::class, 'logout'])->name('auth.logout');
    Route::get('/', [HomeController::class, 'index'])->name('app.index');

    Route::get('/read-message', [HomeController::class, 'readMessage'])->name('app.read-message');

    //dataLogger
    Route::prefix('dataLogger')->group(function () {

        Route::get('/', [DataLoggerController::class, 'index'])->name('app.data-logger.index');
        Route::get('/create', [DataLoggerController::class, 'create'])->name('app.data-logger.create');
        Route::post('/store', [DataLoggerController::class, 'store'])->name('app.data-logger.store');
        Route::get('/edit/{device}', [DataLoggerController::class, 'edit'])->name('app.data-logger.edit');
        Route::put('/update/{device}', [DataLoggerController::class, 'update'])->name('app.data-logger.update');
        Route::delete('/destroy/{device}', [DataLoggerController::class, 'destroy'])->name('app.data-logger.destroy');
        Route::get('/status/{device}', [DataLoggerController::class, 'status'])->name('app.data-logger.status');
        // Route::get('/check-Code/{device}', [DataLoggerController::class, 'checkCode'])->name('app.data-logger.check-code');
        // Route::post('/check-Code/store/{device}', [DataLoggerController::class, 'checkCodeStore'])->name('app.data-logger.check-code.store');

        Route::prefix('order-code')->group(function () {
            Route::get('/{device}', [DataLoggerOrderCodeController::class, 'index'])->name('app.data-logger.order-code');
            Route::get('/{device}/create/', [DataLoggerOrderCodeController::class, 'create'])->name('app.data-logger.order-code.create');
            Route::post('/{device}/store', [DataLoggerOrderCodeController::class, 'store'])->name('app.data-logger.order-code.store');
            Route::get('/{device}/edit/{orderCode}', [DataLoggerOrderCodeController::class, 'edit'])->name('app.data-logger.order-code.edit');
            Route::get('/status/{device}', [DataLoggerOrderCodeController::class, 'status'])->name('app.data-logger.order-code.status');
            
            Route::put('/{device}/update/{orderCode}', [DataLoggerOrderCodeController::class, 'update'])->name('app.data-logger.order-code.update');
            Route::delete('/{device}/delete/{orderCode}', [DataLoggerOrderCodeController::class, 'delete'])->name('app.data-logger.order-code.destroy');
        });
    });

    Route::prefix('messages')->group(function () {

        Route::get('/send-box', [SMSController::class, 'sendBox'])->name('app.Message.send-box');
        Route::get('/recieve-box', [SMSController::class, 'recieveBox'])->name('app.Message.recieve-box');
        Route::get('/create-message', [SMSController::class, 'createMessage'])->name('admin.Message.create-message');
        Route::post('/post-message', [SMSController::class, 'postMessage'])->name('admin.Message.post-message');
        Route::get('/delete-message', [SMSController::class, 'deleteMessage'])->name('admin.Message.delete-message');
        Route::post('/fetch-industrial', [SMSController::class, 'fetchIndustrial'])->name('app.Message.fetch-industrial');
    });

    Route::prefix('modem-setting')->group(function () {

        Route::get('/', [ModemSettingController::class, 'index'])->name('app.setting.index');
        Route::get('/create', [ModemSettingController::class, 'create'])->name('app.setting.create');
        Route::post('/store', [ModemSettingController::class, 'store'])->name('app.setting.store');
        Route::get('/edit/{setting}', [ModemSettingController::class, 'edit'])->name('app.setting.edit');
        Route::put('/update/{setting}', [ModemSettingController::class, 'update'])->name('app.setting.update');
        Route::get('/status/{setting}', [ModemSettingController::class, 'status'])->name('app.setting.status');

    });

    //checkCode
    Route::prefix('check-code')->group(function () {

        Route::get('/', [CheckCodeController::class, 'index'])->name('app.check-code.index');
        Route::get('/create', [CheckCodeController::class, 'create'])->name('app.check-code.create');
        Route::post('/store', [CheckCodeController::class, 'store'])->name('app.check-code.store');
        Route::get('/edit/{checkCode}', [CheckCodeController::class, 'edit'])->name('app.check-code.edit');
        Route::put('/update/{checkCode}', [CheckCodeController::class, 'update'])->name('app.check-code.update');
        Route::delete('/destroy/{checkCode}', [CheckCodeController::class, 'destroy'])->name('app.check-code.destroy');
    });

    //OrderCode
    Route::prefix('order-code')->group(function () {

        Route::get('/', [OrderCodeController::class, 'index'])->name('app.order-code.index');
        Route::get('/create', [OrderCodeController::class, 'create'])->name('app.order-code.create');
        Route::post('/store', [OrderCodeController::class, 'store'])->name('app.order-code.store');
        Route::get('/edit/{orderCode}', [OrderCodeController::class, 'edit'])->name('app.order-code.edit');
        Route::put('/update/{orderCode}', [OrderCodeController::class, 'update'])->name('app.order-code.update');
        Route::get('/status/{orderCode}', [OrderCodeController::class, 'status'])->name('app.order-code.status');
        Route::delete('/destroy/{orderCode}', [OrderCodeController::class, 'destroy'])->name('app.order-code.destroy');
    });

    Route::prefix('user')->group(function () {

        Route::get('/', [UserController::class, 'index'])->name('app.user.index');
        Route::get('/create', [UserController::class, 'create'])->name('app.user.create');
        Route::post('/store', [UserController::class, 'store'])->name('app.user.store');
        Route::get('/edit/{user}', [UserController::class, 'edit'])->name('app.user.edit');
        Route::put('/update/{user}', [UserController::class, 'update'])->name('app.user.update');
        Route::delete('/destroy/{user}', [UserController::class, 'destroy'])->name('app.user.destroy');
        Route::get('/status/{user}', [UserController::class, 'status'])->name('app.user.status');
        Route::get('/activation/{user}', [UserController::class, 'activation'])->name('app.user.activation');
        Route::get('/reset-password/{user}', [UserController::class, 'resetPassword'])->name('app.user.reset-password');
        Route::put('/reset-password/{user}/post', [UserController::class, 'postResetPassword'])->name('app.user.reset-password.post');
        Route::get('/roles/{user}', [UserController::class, 'roles'])->name('app.user.role');
        Route::post('/roles/{user}/store', [UserController::class, 'rolesStore'])->name('app.user.role.store');
        Route::get('/industrial/{user}', [UserController::class, 'industrial'])->name('app.user.industrial-form');
        Route::post('/industrial/{user}/store', [UserController::class, 'industrialStore'])->name('app.user.industrial-store');

    });

    Route::prefix('industrial')->group(function () {

        Route::get('/', [IndustrialCityController::class, 'index'])->name('app.industrial.index');
        Route::get('/create', [IndustrialCityController::class, 'create'])->name('app.industrial.create');
        Route::post('/store', [IndustrialCityController::class, 'store'])->name('app.industrial.store');
        Route::get('/edit/{industrial}', [IndustrialCityController::class, 'edit'])->name('app.industrial.edit');
        Route::put('/update/{industrial}', [IndustrialCityController::class, 'update'])->name('app.industrial.update');
        Route::delete('/destroy/{industrial}', [IndustrialCityController::class, 'destroy'])->name('app.industrial.destroy');
        Route::get('/status/{industrial}', [IndustrialCityController::class, 'status'])->name('app.industrial.status');
        Route::post('/fetch-city', [IndustrialCityController::class, 'fetchCity'])->name('app.industrial.fetch-city');
    });

    //role
    Route::prefix('role')->group(function () {

        Route::get('/', [RoleController::class, 'index'])->name('app.role.index');
        Route::get('/create', [RoleController::class, 'create'])->name('app.role.create');
        Route::post('/store', [RoleController::class, 'store'])->name('app.role.store');
        Route::get('/edit/{role}', [RoleController::class, 'edit'])->name('app.role.edit');
        Route::put('/update/{role}', [RoleController::class, 'update'])->name('app.role.update');
        Route::delete('/destroy/{role}', [RoleController::class, 'destroy'])->name('app.role.destroy');
        // Route::get('/permission-form/{role}', [RoleController::class, 'permissionForm'])->name('app.role.permission-form');
        // Route::post('/permission-update/{role}', [RoleController::class, 'permissionUpdate'])->name('app.role.permission-update');
    });

    //permission
    // Route::prefix('permission')->group(function () {

    //     Route::get('/', [PermissionController::class, 'index'])->name('admin.user.permission.index');
    //     Route::get('/create', [PermissionController::class, 'create'])->name('admin.user.permission.create');
    //     Route::post('/store', [PermissionController::class, 'store'])->name('admin.user.permission.store');
    //     Route::get('/edit/{permission}', [PermissionController::class, 'edit'])->name('admin.user.permission.edit');
    //     Route::put('/update/{permission}', [PermissionController::class, 'update'])->name('admin.user.permission.update');
    //     Route::delete('/destroy/{permission}', [PermissionController::class, 'destroy'])->name('admin.user.permission.destroy');
    // });



});

// Route::get('/', function () {
//     return view('welcome');
// });
