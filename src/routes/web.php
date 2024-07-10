<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\WebhookController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Notifications\Channels\MailChannel;

//認証機能
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);
//stripe機能
Route::post('/create-payment-intent', [PurchaseController::class, 'createPaymentIntent']);
Route::post('stripe/webhook', [WebhookController::class, 'handleWebhook']);
Route::get('purchase/success', [PurchaseController::class, 'paymentSuccess'])->name('purchase.success');

Route::get('/', [ItemController::class, 'index'])->name('index');
Route::get('/item/{item}', [ItemController::class, 'detail'])->name('detail');
Route::get('search', [ItemController::class, 'search'])->name('search');
Route::get('/item/comment/{item}', [CommentController::class, 'show'])->name('comment');

Route::middleware('auth', 'verified')->group(function () {
    Route::get('/mypage', [UserController::class, 'mypage'])->name('mypage');
    Route::get('/mypage/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::post('/mypage/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/mypage/sell/{user}', [SellController::class, 'show'])->name('sell.show');
    // 出品機能
    Route::get('/sell', [SellController::class, 'edit'])->name('sell');
    Route::post('/sell/listing', [SellController::class, 'store'])->name('sell.listing');
    // カテゴリー階層取得ルート
    Route::get('/categories/{parentId}/subcategories', [CategoryController::class, 'getSubCategories']);

    // 購入機能
    Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchase.index');
    //支払い方法の変更
    Route::middleware('sell')->group(function () {
        Route::get('/purchase/{item}', [PurchaseController::class, 'create'])->name('purchase');
        Route::get('/purchase/{item}/select', [PurchaseController::class, 'selectPurchase'])->name('purchase.select');
        Route::post('purchase/{item}/payment-method', [PurchaseController::class, 'updatePaymentMethod'])->name('purchase.update.payment');
        Route::post('/purchase/{item}/payment-form', [PurchaseController::class, 'updatePaymentForm'])->name('purchase.payment.form');
    });

    // 住所機能
    Route::get('/address/{item}/index', [AddressController::class, 'index'])->name('address.index');
    Route::post('/address/{item}/select', [AddressController::class, 'selectAddress'])->name('address.select');
    Route::get('/address/{item}/edit/list', [AddressController::class, 'editList'])->name('address.edit.index');
    Route::delete('address/{item}/{address}/delete', [AddressController::class, 'destroy'])->name('address.destroy');
    Route::get('/address/{item}/{address}/edit', [AddressController::class, 'edit'])->name('address.edit');
    Route::post('/address/{item}/{address}/update', [AddressController::class, 'update'])->name('address.update');
    Route::get('/address/{item}/create', [AddressController::class, 'create'])->name('address.create');
    Route::post('/address/{item}/store', [AddressController::class, 'store'])->name('address.store');
    // お気に入り機能
    Route::get('/favorite', [FavoriteController::class, 'index'])->name('favorite.index');
    Route::post('/favorite/add/{item}', [FavoriteController::class, 'store'])->name('favorite.add');
    Route::delete('/favorite/destroy/{item}', [FavoriteController::class, 'destroy'])->name('favorite.destroy');
    // コメント機能
    Route::post('/item/comment/{item}', [CommentController::class, 'store'])->name('comment.store');
    Route::delete('item/comment/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');
    Route::post('/default-comments', [CommentController::class, 'addDefaultComment'])->name('defaultComment.add');
    Route::post('/default-comments/{defaultComment}', [CommentController::class, 'updateDefaultComment'])->name('defaultComment.update');
});
// 管理者画面
Route::middleware('admin')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::delete('/admin/delete/users', [AdminController::class, 'destroyMultiple'])->name('admin.destroy.users');
    Route::get('/admin/{user}', [AdminController::class, 'show'])->name('admin.show');
    Route::patch('/role/update/{user}', [AdminController::class, 'update'])->name('role.update');
    Route::get('/mail/create/{user}', [MailController::class, 'create'])->name('mail.create');
    Route::post('/mail/send/{user}', [MailController::class, 'send'])->name('mail.send');
    Route::get('/mail/sendToAll', [MailController::class, 'sendToAllForm'])->name('mail.sendToAllForm');
    Route::post('/mail/sendToAll', [MailController::class, 'sendToAll'])->name('mail.sendToAll');
});

//メール認証
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');
//メール確認のリンクをクリックした後の処理
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');
//メール確認の再送信
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('resent', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');
