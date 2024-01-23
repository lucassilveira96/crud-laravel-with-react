<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Product\GetAllProductsController;
use App\Http\Controllers\Product\GetOneProductController;
use App\Http\Controllers\Product\NewProductController;
use App\Http\Controllers\Product\UpdateProductController;
use App\Http\Controllers\Product\DeleteProductController;
use App\Http\Controllers\ProductCategory\GetAllProductCategoriesController;
use App\Http\Controllers\ProductCategory\GetOneProductCategoryController;
use App\Http\Controllers\ProductCategory\NewProductCategoryController;
use App\Http\Controllers\ProductCategory\UpdateProductCategoryController;
use App\Http\Controllers\ProductCategory\DeleteProductCategoryController;
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
Route::post('/products', NewProductController::class)->name('newProduct');

Route::get('/products', GetAllProductsController::class)->name('getAllProducts');

Route::get('/products/{id}', GetOneProductController::class)->name('getOneProduct');

Route::patch('/products/{id}', UpdateProductController::class)->name('updateProduct');

Route::delete('/products/{id}', DeleteProductController::class)->name('deleteProduct');

Route::post('/product/categories', NewProductCategoryController::class)->name('newProductCategory');

Route::get('/product/categories', GetAllProductCategoriesController::class)->name('getAllProductCategories');

Route::get('/product/categories/{id}', GetOneProductCategoryController::class)->name('getOneProductCategory');

Route::patch('/product/categories/{id}', UpdateProductCategoryController::class)->name('updateProductCategory');

Route::delete('/product/categories/{id}', DeleteProductCategoryController::class)->name('deleteProductCategory');
