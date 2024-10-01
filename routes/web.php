<?php

use App\Http\Controllers\ClientProductController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;

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

Route::get('/', function () {
    return view('client.shop.index');
})->name('shop');


Route::middleware('auth')->group(function () {
    Route::group(['middleware' => 'role:admin'], function () {
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::prefix('master')->group(function () {
            Route::controller(ProductController::class)->group(function () {
                Route::get('/product', 'index');
                Route::get('/product/data', 'data');
                Route::post('/product/data', 'store');
                Route::post('/product/data/{id}', 'update');
                Route::post('/product/data/delete/{id}', 'destroy');
                Route::post('/product/data/image/{id}', 'image');
            });
        });

        Route::prefix('shop')->group(function () {
            Route::controller(TransactionController::class)->group(function () {
                Route::get('/order', 'indexadmin');
                Route::get('/order/data', 'data');
            });
        });
    });

    Route::group(['middleware' => 'role:user'], function () {
        Route::get('/dashboard-user', function () {
            return view('client.shop.dashboard');
        })->name('dashboard-user');
        Route::prefix('user')->group(function () {
            Route::controller(TransactionController::class)->group(function () {
                Route::get('/transaction', 'index')->name('transaction-list');
                Route::get('/transaction/data', 'list');
                Route::post('/transaction/success/{id}', 'success');
            });
        });
    });
});

Route::get('/login-user', function () {
    return view('client.login');
})->name('login-user');

Route::prefix('client')->group(function () {
    Route::controller(ClientProductController::class)->group(function () {
        Route::get('/shop', 'index');
        Route::get('/shop/product/{code}', 'product');
    });

    Route::controller(TransactionController::class)->group(function () {
        Route::post('/shop/pay', 'pay');
    });

    Route::prefix('master')->group(function () {
        Route::controller(ProductController::class)->group(function () {
            Route::get('/product/data/user', 'shopdata');
            Route::get('/product/data/{kodebarang}', 'show');
        });
    });
});



// useless routes
// Just to demo sidebar dropdown links active states.
Route::get('/buttons/text', function () {
    return view('buttons-showcase.text');
})->middleware(['auth'])->name('buttons.text');

Route::get('/buttons/icon', function () {
    return view('buttons-showcase.icon');
})->middleware(['auth'])->name('buttons.icon');

Route::get('/buttons/text-icon', function () {
    return view('buttons-showcase.text-icon');
})->middleware(['auth'])->name('buttons.text-icon');

require __DIR__ . '/auth.php';
