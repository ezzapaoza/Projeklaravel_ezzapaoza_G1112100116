<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get(
    'resto/home',
    [App\Http\Controllers\resto\HomeController::class, 'index']
)
    ->middleware('can:isResto');
Route::get(
    'kurir/home',
    [App\Http\Controllers\kurir\HomeController::class, 'index']
)
    ->middleware('can:isKurir');
Route::get(
    'konsumen/home',
    [App\Http\Controllers\konsumen\HomeController::class, 'index']
)
    ->middleware('can:isKonsumen');
Route::get(
    'resto/user',
    [App\Http\Controllers\resto\UserController::class, 'index']
)
    ->middleware('can:isResto');
Route::get(
    'resto/user/create',
    [App\Http\Controllers\resto\UserController::class, 'create']
)
    ->middleware('can:isResto');
Route::post(
    'resto/user/store',
    [App\Http\Controllers\resto\UserController::class, 'store']
)
    ->middleware('can:isResto');
Route::get(
    'resto/user/edit/{id}',
    [App\Http\Controllers\resto\UserController::class, 'edit']
)
    ->middleware('can:isResto');
Route::post(
    'resto/user/update/{id}',
    [App\Http\Controllers\resto\UserController::class, 'update']
)
    ->middleware('can:isResto');
Route::post(
    'resto/user/destroy/{id}',
    [App\Http\Controllers\resto\UserController::class, 'destroy']
)
    ->middleware('can:isResto');
Route::get('resto/pizza', [
    App\Http\Controllers\resto\PizzaController::class,
    'index'
])->middleware('can:isResto');
Route::get('resto/pizza/create', [
    App\Http\Controllers\resto\PizzaController::class,
    'create'
])->middleware('can:isResto');
Route::post('resto/pizza/store', [
    App\Http\Controllers\resto\PizzaController::class,
    'store'
])->middleware('can:isResto');
Route::get(
    'resto/pizza/edit/{id}',
    [
        App\Http\Controllers\resto\PizzaController::class,
        'edit'
    ]
)->middleware('can:isResto');
Route::post(
    'resto/pizza/update/{id}',
    [
        App\Http\Controllers\resto\PizzaController::class,
        'update'
    ]
)->middleware('can:isResto');
Route::post(
    'resto/pizza/destroy/{id}',
    [
        App\Http\Controllers\resto\PizzaController::class,
        'destroy'
    ]
)->middleware('can:isResto');
Route::get(
    'konsumen/alamatkirim',
    [App\Http\Controllers\konsumen\AlamatKirimController::class, 'index']
)
    ->middleware('can:isKonsumen');
Route::get(
    'konsumen/alamatkirim/create',
    [App\Http\Controllers\konsumen\AlamatKirimController::class, 'create']
)
    ->middleware('can:isKonsumen');
Route::post(
    'konsumen/alamatkirim/store',
    [App\Http\Controllers\konsumen\AlamatKirimController::class, 'store']
)
    ->middleware('can:isKonsumen');
Route::get(
    'konsumen/alamatkirim/edit/{id}',
    [App\Http\Controllers\konsumen\AlamatKirimController::class, 'edit']
)
    ->middleware('can:isKonsumen');
Route::post(
    'konsumen/alamatkirim/update/{id}',
    [App\Http\Controllers\konsumen\AlamatKirimController::class, 'update']
)
    ->middleware('can:isKonsumen');
Route::post(
    'konsumen/alamatkirim/destroy/{id}',
    [App\Http\Controllers\konsumen\AlamatKirimController::class, 'destroy']
)
    ->middleware('can:isKonsumen');
Route::post(
    'konsumen/alamatkirim/default/{id}',
    [App\Http\Controllers\konsumen\AlamatKirimController::class, 'default']
)
    ->middleware('can:isKonsumen');
Route::get(
    'konsumen/order',
    [App\Http\Controllers\konsumen\JualController::class, 'order']
)
    ->middleware('can:isKonsumen');
Route::post(
    'konsumen/addtocart/{id}',
    [App\Http\Controllers\konsumen\JualController::class, 'addtocart']
)
    ->middleware('can:isKonsumen');
Route::get(
    'konsumen/cart',
    [App\Http\Controllers\konsumen\JualController::class, 'getcart']
)
    ->middleware('can:isKonsumen');
Route::post(
    'konsumen/cart',
    [App\Http\Controllers\konsumen\JualController::class, 'postcart']
)
    ->middleware('can:isKonsumen');
Route::get(
    'konsumen/checkout',
    [App\Http\Controllers\konsumen\JualController::class, 'getcheckout']
)
    ->middleware('can:isKonsumen');
Route::post(
    'konsumen/checkout',
    [App\Http\Controllers\konsumen\JualController::class, 'postcheckout']
)
    ->middleware('can:isKonsumen');
Route::post(
    'konsumen/cancel/{id}',
    [App\Http\Controllers\konsumen\JualController::class, 'postcancel']
)
    ->middleware('can:isKonsumen');
Route::get(
    'konsumen/track/{id}',
    [App\Http\Controllers\konsumen\JualController::class, 'gettrack']
)
    ->middleware('can:isKonsumen');
Route::post('resto/proses/{id}', [
    App\Http\Controllers\resto\JualController::class,
    'postproses'
])->middleware('can:isResto');
Route::post('resto/siap/{id}', [
    App\Http\Controllers\resto\JualController::class,
    'postsiap'
])->middleware('can:isResto');
Route::post('resto/cancel/{id}', [
    App\Http\Controllers\resto\JualController::class,
    'postcancel'
])->middleware('can:isResto');
Route::get('resto/track/{id}', [
    App\Http\Controllers\resto\JualController::class,
    'gettrack'
])->middleware('can:isResto');
