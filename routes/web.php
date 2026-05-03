<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TourController;
use App\Http\Controllers\TourImageController;
use App\Http\Controllers\PagesController;

Route::get('/', [TourController::class, 'home'])->name('home');

Route::resource('tours', TourController::class)->except(['index', 'show'])->middleware(['auth', 'admin']);
Route::resource('tours', TourController::class)->only(['index', 'show']);

Route::resource('tours.images', TourImageController::class)
    ->except(['index', 'show', 'edit', 'update'])
    ->shallow()
    ->middleware(['auth', 'admin']);

Route::post('/images/{image}/move', [TourImageController::class, 'move'])->name('images.move')->middleware(['auth', 'admin']);

Route::post('/tours/{tour}/order', [TourController::class, 'order'])->name('tours.order');

Route::get('/cabinet', [TourController::class, 'cabinet'])->name('cabinet')->middleware('auth');

Route::get('/admin/orders', [TourController::class, 'adminOrders'])->name('admin.orders')->middleware(['auth', 'admin']);
Route::post('/admin/orders/{id}/status', [TourController::class, 'updateOrderStatus'])->name('admin.orders.status')->middleware(['auth', 'admin']);
Route::get('/admin/stats', [TourController::class, 'adminStats'])->name('admin.stats')->middleware(['auth', 'admin']);

Route::get('/services', [PagesController::class, 'services'])->name('services');
Route::get('/about', [PagesController::class, 'about'])->name('about');
Route::post('/about/photo', [PagesController::class, 'uploadAboutPhoto'])->name('about.photo')->middleware(['auth', 'admin']);
Route::get('/contacts', [PagesController::class, 'contacts'])->name('contacts');
Route::post('/contacts', [PagesController::class, 'storeMessage'])->name('contacts.store');

Route::get('/admin/messages', [PagesController::class, 'adminMessages'])->name('admin.messages')->middleware(['auth', 'admin']);
Route::post('/admin/messages/{id}/read', [PagesController::class, 'markRead'])->name('admin.messages.read')->middleware(['auth', 'admin']);

Auth::routes();
