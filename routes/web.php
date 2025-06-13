<?php

use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\NewsController as AdminNewsController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PageController as AdminPageController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UploadController as AdminUploadController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

//Route::get('/', function () {
//    return Inertia::render('Welcome', [
//        'canLogin' => Route::has('login'),
//        'canRegister' => Route::has('register'),
//        'laravelVersion' => Application::VERSION,
//        'phpVersion' => PHP_VERSION,
//    ]);
//});
//
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

// Главная страница
Route::get('/', [HomeController::class, 'index'])->name('home');

// Переключение языка
Route::post('/locale', [LocaleController::class, 'switchLocale'])->name('locale.switch');

// Каталог
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/catalog/category/{slug}', [CatalogController::class, 'byCategory'])->name('catalog.category');
Route::get('/catalog/brand/{slug}', [CatalogController::class, 'byBrand'])->name('catalog.brand');
Route::get('/catalog/{slug}', [CatalogController::class, 'show'])->name('catalog.show');

// Новости
Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{slug}', [NewsController::class, 'show'])->name('news.show');
Route::get('/promos', [NewsController::class, 'promos'])->name('promos.index');

// Корзина
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Оформление заказа
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');

// Контакты
Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Статические страницы
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/sitemap', [PageController::class, 'sitemap'])->name('pages.sitemap');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('pages.show');
Route::get('/pages', [PageController::class, 'index'])->name('pages.index');

// Заказы
Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
Route::get('/orders/{id}/success', [OrderController::class, 'success'])->name('orders.success');
Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');

// Товары (отдельный маршрут)
Route::get('/product/{slug}', [CatalogController::class, 'show'])->name('product.show');

// Профиль пользователя (требует аутентификации)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
    Route::get('/profile/orders/{id}', [ProfileController::class, 'order'])->name('profile.order');
});

// Админ-панель (требует прав администратора)
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Управление товарами
    Route::resource('products', AdminProductController::class);

    // Управление категориями
    Route::resource('categories', AdminCategoryController::class);

    // Управление брендами
    Route::resource('brands', AdminBrandController::class);

    // Управление новостями
    Route::resource('news', AdminNewsController::class);

    // Управление заказами
    Route::resource('orders', AdminOrderController::class)->except(['create', 'store']);

    // Управление страницами
    Route::resource('pages', AdminPageController::class);

    // Управление контактами
    Route::resource('contacts', AdminContactController::class);

    // Управление пользователями (только для администраторов)
    Route::resource('users', AdminUserController::class);

    // Загрузка файлов
    Route::post('upload', [AdminUploadController::class, 'store'])->name('upload.store');
    Route::post('upload/editor', [AdminUploadController::class, 'storeEditor'])->name('upload.editor');
    Route::delete('upload', [AdminUploadController::class, 'destroy'])->name('upload.destroy');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
})->middleware(AdminMiddleware::class);

