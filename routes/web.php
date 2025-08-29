<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminCarController;
use App\Http\Controllers\Admin\AdminReservationController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\PolitiqueController;
use Illuminate\Support\Facades\Route;

 Route::get('/toni', function () {
    return view('voitures');
}); 

/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/

// Routes pour les politiques
Route::get('/politique-location', [PolitiqueController::class, 'politiqueLocation'])->name('politique.location');
Route::get('/politique-annulation', [PolitiqueController::class, 'politiqueAnnulation'])->name('politique.annulation');

// Page d'accueil - Liste des voitures disponibles
Route::get('/', [CarController::class, 'index'])->name('home');

// Pages de détail des voitures
Route::get('/cars/{car}', [CarController::class, 'show'])->name('cars.show');
Route::get('/search', [CarController::class, 'search'])->name('cars.search');


/*
|--------------------------------------------------------------------------
| Routes d'authentification Breeze (clients)
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    // Routes Breeze par défaut (login, register, etc.)
});

/*
|--------------------------------------------------------------------------
| Routes d'authentification Admin
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);
    });

    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Routes protégées - Clients
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'client'])->group(function () {
    // Dashboard client
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profil utilisateur
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Réservations
    Route::prefix('reservations')->name('reservations.')->group(function () {
        Route::get('/', [ReservationController::class, 'index'])->name('index');
        Route::get('/create/{car}', [ReservationController::class, 'create'])->name('create');
        Route::post('/', [ReservationController::class, 'store'])->name('store');
            // Routes pour les extensions
    Route::get('/{reservation}/extend/form', [ReservationController::class, 'showExtendForm'])->name('extend.form');
    Route::post('/{reservation}/extend', [ReservationController::class, 'extend'])->name('extend');

        Route::get('/{reservation}', [ReservationController::class, 'show'])->name('show');
    Route::delete('/{reservation}/cancel', [ReservationController::class, 'cancel'])->name('cancel');


        // Nouvelles routes pour les réservations
    Route::post('/check-availability', [ReservationController::class, 'checkAvailability'])
        ->name('check-availability');
    Route::get('/payment/callback', [ReservationController::class, 'paymentCallback'])
        ->name('payment.callback');
    Route::get('/payment/cancel/{reservation}', [ReservationController::class, 'paymentCancel'])
        ->name('payment.cancel');
    Route::post('/payment/webhook', [ReservationController::class, 'paymentWebhook'])
        ->name('payment.webhook');
    });
});

// Route webhook (pas besoin d'authentification)
Route::post('/reservations/payment/webhook', [ReservationController::class, 'paymentWebhook'])
    ->name('reservations.payment.webhook');

/*
|--------------------------------------------------------------------------
| Routes protégées - Administrateurs
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard admin
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Gestion des voitures
    Route::resource('cars', AdminCarController::class);
    
    // Gestion des réservations 
    Route::prefix('reservations')->name('reservations.')->group(function () {
        Route::get('/', [AdminReservationController::class, 'index'])->name('index');
        Route::get('/current', [AdminReservationController::class, 'current'])->name('current');
        Route::get('/expired', [AdminReservationController::class, 'expired'])->name('expired');
        Route::get('/stats', [AdminReservationController::class, 'stats'])->name('stats');
        Route::get('/{reservation}', [AdminReservationController::class, 'show'])->name('show');
        Route::post('/{reservation}/make-available', [AdminReservationController::class, 'makeAvailable'])->name('make-available');
        Route::post('/{reservation}/cancel', [AdminReservationController::class, 'cancel'])->name('cancel');
    });

    // Routes pour les notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/count', [App\Http\Controllers\Admin\AdminNotificationController::class, 'getUnreadCount'])->name('count');
        Route::get('/recent', [App\Http\Controllers\Admin\AdminNotificationController::class, 'getRecent'])->name('recent');
        Route::post('/mark-all', [App\Http\Controllers\Admin\AdminNotificationController::class, 'markAllAsRead'])->name('mark-all');
        Route::get('/click/{notification}', [App\Http\Controllers\Admin\AdminNotificationController::class, 'handleClick'])->name('click');
        Route::post('/{notification}/read', [App\Http\Controllers\Admin\AdminNotificationController::class, 'markAsRead'])->name('read');
    });
}); // ← CETTE FERMETURE MANQUAIT

Route::post('/reservations/verify-pricing', [ReservationController::class, 'verifyPricing'])
    ->name('reservations.verify-pricing')
    ->middleware('auth');
    
// Routes pour les contrats de réservation
Route::middleware(['auth'])->group(function () {
    Route::get('/reservations/{reservation}/contract/download', [ContractController::class, 'downloadContract'])
        ->name('reservations.contract.download');
    Route::get('/reservations/{reservation}/contract/view', [ContractController::class, 'viewContract'])
        ->name('reservations.contract.view');
    Route::get('/reservations/{reservation}/contract/preview', [ContractController::class, 'previewContract'])
        ->name('reservations.contract.preview');
});

// Routes de test SMS (à supprimer en production) - SORTIES DU GROUPE ADMIN
Route::get('/test-sms', [App\Http\Controllers\TestSmsController::class, 'showTestForm'])->name('test-sms');
Route::post('/test-sms', [App\Http\Controllers\TestSmsController::class, 'sendTestSms'])->name('test-sms.send');

// Cette ligne doit être à la fin du fichier
require __DIR__.'/auth.php';