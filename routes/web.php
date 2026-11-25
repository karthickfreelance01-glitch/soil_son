<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public website
|--------------------------------------------------------------------------
*/

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/services', [PageController::class, 'services'])->name('services');
Route::get('/services/{slug}', [PageController::class, 'serviceShow'])->name('services.show');
Route::get('/de-addiction', [PageController::class, 'deAddiction'])->name('de-addiction');
Route::get('/rehabilitation', [PageController::class, 'rehabilitation'])->name('rehabilitation');
Route::get('/individual-counselling', [PageController::class, 'individualCounselling'])->name('individual-counselling');
Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');
Route::get('/sitemap.xml', [PageController::class, 'sitemap'])->name('sitemap');

Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('contact.store');

/* Slide-out "Quick Enquiry" panel on every page */
Route::post('/enquiry', [EnquiryController::class, 'store'])
    ->middleware('throttle:10,1')
    ->name('enquiry.store');

/* Legacy WordPress URLs -> clean Laravel URLs */
Route::redirect('/home', '/', 301);
Route::redirect('/index.php', '/', 301);
foreach (['about', 'de-addiction', 'rehabilitation', 'individual-counselling', 'gallery', 'contact'] as $slug) {
    Route::redirect("/index.php/{$slug}", "/{$slug}", 301);
}

/*
|--------------------------------------------------------------------------
| Admin / Staff backend  (/admin)
|--------------------------------------------------------------------------
| admin : everything
| staff : dashboard, enquiries (view / update / export), gallery
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.dashboard'));
    Route::get('login', [Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [Admin\AuthController::class, 'login'])->middleware('throttle:10,1')->name('login.submit');

    Route::middleware(['auth', 'role:admin,staff'])->group(function () {
        Route::post('logout', [Admin\AuthController::class, 'logout'])->name('logout');
        Route::post('change-password', [Admin\AuthController::class, 'changePassword'])->name('change-password');

        Route::get('dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard');

        // Enquiries
        Route::get('enquiries', [Admin\EnquiryController::class, 'index'])->name('enquiries.index');
        Route::get('enquiries/export', [Admin\EnquiryController::class, 'export'])->name('enquiries.export');
        Route::get('enquiries/{enquiry}', [Admin\EnquiryController::class, 'show'])->name('enquiries.show');
        Route::put('enquiries/{enquiry}', [Admin\EnquiryController::class, 'update'])->name('enquiries.update');

        // Gallery
        Route::get('gallery', [Admin\GalleryController::class, 'index'])->name('gallery.index');
        Route::post('gallery', [Admin\GalleryController::class, 'store'])->name('gallery.store');
        Route::put('gallery/{item}', [Admin\GalleryController::class, 'update'])->name('gallery.update');
        Route::post('gallery/{item}/toggle', [Admin\GalleryController::class, 'toggle'])->name('gallery.toggle');
        Route::delete('gallery/{item}', [Admin\GalleryController::class, 'destroy'])->name('gallery.destroy');

        // Admin only
        Route::middleware('role:admin')->group(function () {
            Route::delete('enquiries/{enquiry}', [Admin\EnquiryController::class, 'destroy'])->name('enquiries.destroy');

            Route::get('services', [Admin\ServiceController::class, 'index'])->name('services.index');
            Route::get('services/create', [Admin\ServiceController::class, 'create'])->name('services.create');
            Route::post('services', [Admin\ServiceController::class, 'store'])->name('services.store');
            Route::get('services/{service}/edit', [Admin\ServiceController::class, 'edit'])->name('services.edit');
            Route::put('services/{service}', [Admin\ServiceController::class, 'update'])->name('services.update');
            Route::post('services/{service}/toggle', [Admin\ServiceController::class, 'toggle'])->name('services.toggle');
            Route::delete('services/{service}', [Admin\ServiceController::class, 'destroy'])->name('services.destroy');

            Route::get('seo', [Admin\SeoController::class, 'index'])->name('seo.index');
            Route::put('seo/{page}', [Admin\SeoController::class, 'update'])->name('seo.update');

            Route::get('users', [Admin\UserController::class, 'index'])->name('users.index');
            Route::post('users', [Admin\UserController::class, 'store'])->name('users.store');
            Route::put('users/{user}', [Admin\UserController::class, 'update'])->name('users.update');
            Route::delete('users/{user}', [Admin\UserController::class, 'destroy'])->name('users.destroy');
        });
    });
});

/* Hospital Management System (same as gh.hms-society.com) */
require __DIR__.'/hms.php';

/* Laravel's auth middleware redirects guests to the route named "login". */
Route::get('login', fn () => redirect()->route('admin.login'))->name('login');
