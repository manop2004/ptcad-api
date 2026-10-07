<?php
Route::get('/account/forgotpassword/sent', [App\Http\Controllers\AccountController::class, 'forgotpasswordSent'])->name('fronend.account.forgotpassword.sent');
Route::get('/account/verify-email/{token}', [App\Http\Controllers\AccountController::class, 'verifyEmailChange'])->name('fronend.account.verifyEmail');
    Route::get('/register/pending', [App\Http\Controllers\Auth\RegisterController::class, 'showPending'])->name('fronend.register.pending');
    Route::post('/register/resend', [App\Http\Controllers\Auth\RegisterController::class, 'resendVerification'])->name('fronend.register.resend');

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\TbPagesRedirect;
use App\Models\TbPromotionOnepage;
Route::get('/test123456', function () { return 'HELLO WORLD TEST OK'; });
//api
Route::get('api/jsonDetail', [App\Http\Controllers\API\ProductController::class, 'jsonDetail'])->name('fronend.product.jsonDetail');
Route::get('api/province', [App\Http\Controllers\API\ProvinceController::class, 'province'])->name('api.province');
Route::get('api/amphure', [App\Http\Controllers\API\ProvinceController::class, 'amphure'])->name('api.amphure');
Route::get('api/district', [App\Http\Controllers\API\ProvinceController::class, 'district'])->name('api.district');
Route::get('api/zipcode', [App\Http\Controllers\API\ProvinceController::class, 'zipcode'])->name('api.zipcode');
Route::get('api/getIndustry', [App\Http\Controllers\API\CrmapplicadthaiController::class, 'getIndustry']);
Route::get('api/getProvince', [App\Http\Controllers\API\CrmapplicadthaiController::class, 'getProvince']);
Route::get('api/ticket', [App\Http\Controllers\API\TicketController::class, 'TicketForUser']);
Route::get('api/getSubcategory', [App\Http\Controllers\API\ProductController::class, 'getSubcategory']);
//chatbot api (public, ไม่ต้อง login)
Route::get('api/chatbot/qna', [App\Http\Controllers\ChatbotController::class, 'getQna']);
Route::post('api/chatbot/log', [App\Http\Controllers\ChatbotController::class, 'logClick']);

//google merchant
Route::get('api/google/merchant/insert', [App\Http\Controllers\API\GooglemerchantController::class, 'insert']);
Route::get('api/google/merchant/list', [App\Http\Controllers\API\GooglemerchantController::class, 'list']);
Route::delete('api/google/merchant/delete', [App\Http\Controllers\API\GooglemerchantController::class, 'delete']);
Route::get('api/google/merchant/view', [App\Http\Controllers\API\GooglemerchantController::class, 'view']);

//webhook omise
Route::post('api/omise/webhook', [App\Http\Controllers\API\OmiseController::class, 'omise_webhook']);

// Stripe Checkout
Route::get('/cart/payment/{id}/stripe', [App\Http\Controllers\Shopping\PaymentController::class, 'stripeCheckout'])->name('fronend.cart.payment.stripe');
Route::get('/cart/payment/stripe/success/{id}', [App\Http\Controllers\Shopping\PaymentController::class, 'stripeSuccess'])->name('fronend.cart.payment.stripe.success');
Route::get('/cart/payment/stripe/cancel/{id}', [App\Http\Controllers\Shopping\PaymentController::class, 'stripeCancel'])->name('fronend.cart.payment.stripe.cancel');

// webhook stripe
Route::post('api/stripe/webhook', [App\Http\Controllers\API\StripeController::class, 'webhook']);

// Botnoi API Helper & Documentation
Route::get('/api-docs', [App\Http\Controllers\API\BotnoiLicenseController::class, 'docs'])->name('api.docs');
Route::get('/botnoi-api', [App\Http\Controllers\API\BotnoiLicenseController::class, 'docs'])->name('botnoi.api.docs');

//conjob
Route::get('api/testnofityCornjop', [App\Http\Controllers\API\ConjobController::class, 'test_notify_cronjop']);
Route::get('api/sendmailSoftwareExp', [App\Http\Controllers\API\ConjobController::class, 'check_software_exp']);
Route::get('api/consent/history', [App\Http\Controllers\API\ConjobController::class, 'check_pdpa_Crate_To_History']);

//conjob getmember
Route::get('api/sendmailGetmemberNew', [App\Http\Controllers\API\GetmemberController::class, 'check_Newmember_By_Getmember']);
Route::get('api/sendmailGetmemberStaff', [App\Http\Controllers\API\GetmemberController::class, 'check_UserGetmember_ToStaff']);

//conjob promotion
Route::get('api/linenotify/promotion', [App\Http\Controllers\API\PromotionController::class, 'check_linenotify_promotion']);

//conjob order
Route::get('api/clear/orderexpire', [App\Http\Controllers\API\OrderController::class, 'check_orderExpire']);
Route::get('api/linenotify/orderpayment', [App\Http\Controllers\API\OrderController::class, 'check_order_warning']);
Route::get('api/linenotify/ordertransfer', [App\Http\Controllers\API\OrderController::class, 'check_order_warning_transfer']);
Route::get('api/orderreport', [App\Http\Controllers\API\OrderController::class, 'report_order']);

Route::get('api/orderthankyou', [App\Http\Controllers\API\ThankUController::class, 'SendMailThankyou']);

// one page gstarcad
Route::get('gstarcad', [App\Http\Controllers\Onepage\GstarcadController::class, 'index'])->name('onepage.gstarcad.index');
Route::post('gstarcad/quotation/do', [App\Http\Controllers\API\CrmapplicadthaiController::class, 'crateQuotation'])->name('onepage.gstarcad.crateQuotation');
Route::get('gstarcad/demo', [App\Http\Controllers\Onepage\GstarcadController::class, 'dowload'])->name('onepage.gstarcad.dowload');
Route::post('gstarcad/register/do', [App\Http\Controllers\API\CrmapplicadthaiController::class, 'crate'])->name('onepage.gstarcad.crate');
Route::get('gstarcad/promotion', [App\Http\Controllers\Onepage\GstarcadController::class, 'promotion'])->name('onepage.gstarcad.promotion');
Route::get('gstarcad/meetgstar', [App\Http\Controllers\Onepage\GstarcadController::class, 'meetgstar'])->name('onepage.gstarcad.meetgstar');
Route::post('gstarcad/meetgstar/do', [App\Http\Controllers\Onepage\GstarcadController::class, 'crateMeet'])->name('onepage.gstarcad.crateMeet');
// one page adobe
Route::get('adobe', [App\Http\Controllers\Onepage\AdobeController::class, 'index'])->name('onepage.adobe.index');
Route::get('adobe/register/do', [App\Http\Controllers\API\CrmapplicadthaiController::class, 'crate'])->name('onepage.adobe.crate');

// หมดโปร
//Route::get('adobe/offer', [App\Http\Controllers\Onepage\AdobeController::class, 'offer'])->name('onepage.adobe.offer');
//Route::get('adobe/offer/thankyou', [App\Http\Controllers\Onepage\AdobeController::class, 'crate_offer'])->name('onepage.adobe.crate_offer');


// one page ExtrAXION 2D
Route::get('extraxion-2d-and-rebars', [App\Http\Controllers\Onepage\ExtraxionController::class, 'index'])->name('onepage.extraxion.index');
Route::get('extraxion-2d-and-rebars/thankyou', [App\Http\Controllers\API\CrmapplicadthaiController::class, 'crate'])->name('onepage.extraxion.crate');

// one page Lumion
Route::get('lumion', [App\Http\Controllers\Onepage\LumionController::class, 'index'])->name('onepage.lumion.index');
Route::get('lumion/thankyou', [App\Http\Controllers\Onepage\LumionController::class, 'crate'])->name('onepage.lumion.crate');

//login
Route::get('administrator', [App\Http\Controllers\Auth\AdministratorController::class, 'index'])->name('administrator');
Route::post('administrator', [App\Http\Controllers\Auth\AdministratorController::class, 'login'])->name('administrator');
//logout
Route::get('user/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('user.logout');

//login google
Route::get('auth/google', [App\Http\Controllers\Auth\GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\GoogleController::class, 'handleGoogleCallback'])->name('google.callback');
Route::get('unconnect/google', [App\Http\Controllers\Auth\GoogleController::class, 'unconnect'])->name('google.unconnect');

//login social facebook
Route::get('auth/facebook', [App\Http\Controllers\Auth\FacebookController::class, 'redirectTofacebook'])->name('facebook.login');
Route::get('auth/facebook/callback', [App\Http\Controllers\Auth\FacebookController::class, 'handleFacebookCallback'])->name('facebook.callback');
Route::get('unconnect/facebook', [App\Http\Controllers\Auth\FacebookController::class, 'unconnect'])->name('facebook.unconnect');

//register
Route::get('confirmation', [App\Http\Controllers\FontendController::class, 'confirmation'])->name('confirmation');

//index
Route::get('/', [App\Http\Controllers\FontendController::class, 'index'])->name('fronend.home');
Route::get('/thai-gstarcad', [App\Http\Controllers\FontendController::class, 'thai-gstarcad'])->name('fronend.thai-gstarcad');

Route::get('/search', [App\Http\Controllers\FontendController::class, 'search'])->name('fronend.search');
Route::get('/favorite', [App\Http\Controllers\FontendController::class, 'favorite'])->name('fronend.favorite');
Route::get('/brand/{permalink}', [App\Http\Controllers\FontendController::class, 'brand'])->name('fronend.brand');
Route::get('/promotion/event', [App\Http\Controllers\FontendController::class, 'promotionEvent'])->name('fronend.promotion.event');

//category
Route::get('/category', [App\Http\Controllers\FontendController::class, 'categoryAll'])->name('fronend.category.all');
Route::get('/category/{permalink}', [App\Http\Controllers\FontendController::class, 'category'])->name('fronend.category');

//material
Route::get('/material', [App\Http\Controllers\FontendController::class, 'materialAll'])->name('fronend.material.all');
Route::get('/malist', [App\Http\Controllers\FontendController::class, 'malist'])->name('fronend.material.list');
Route::get('/maproduct', [App\Http\Controllers\FontendController::class, 'maproduct'])->name('fronend.material.product');

//product
Route::get('/product/{permalink}', [App\Http\Controllers\FontendController::class, 'product'])->name('fronend.product.content');
Route::get('/api/frontend/product/{permalink}', [App\Http\Controllers\FontendController::class, 'productJson']);

//sales
Route::get('/sale', [App\Http\Controllers\FontendController::class, 'sale'])->name('fronend.sale.all');
Route::get('/sale/{start_date}', [App\Http\Controllers\FontendController::class, 'sale_promotion'])->name('fronend.sale');

//article
Route::get('/article', [App\Http\Controllers\FontendController::class, 'articleIndex'])->name('fronend.article.main');
Route::get('/article/search', [App\Http\Controllers\FontendController::class, 'articleSearch'])->name('fronend.article.search');
Route::get('/article/searchtag/{search}', [App\Http\Controllers\FontendController::class, 'articleSearchtag'])->name('fronend.article.searchtag');
 
// [ใหม่] ตัวกรอง "หมวดหมู่" คงที่ (art_cat) — คนละเส้นทางกับ searchtag (keyword) ด้านบน
Route::get('/article/category/{cat}', [App\Http\Controllers\FontendController::class, 'articleCategory'])->name('fronend.article.category');
Route::get('/article/{permalink}', [App\Http\Controllers\FontendController::class, 'articleContent'])->name('fronend.article.content');


//tutorial
Route::get('/tutorial', [App\Http\Controllers\FontendController::class, 'tutorialIndex'])->name('fronend.tutorial.main')->middleware('auth');
Route::get('/tutorial/tag/{search}', [App\Http\Controllers\FontendController::class, 'tutorialSearchtag'])->name('fronend.tutorial.searchtag')->middleware('auth');
Route::get('/tutorial/{permalink}', [App\Http\Controllers\FontendController::class, 'tutorialContent'])->name('fronend.tutorial.content')->middleware('auth');
Route::post('/tutorial/progress/save', [App\Http\Controllers\FontendController::class, 'tutorialProgressSave'])->name('fronend.tutorial.progress.save')->middleware('auth');

//page
Route::get('/page/{permalink}', [App\Http\Controllers\FontendController::class, 'pageContent'])->name('fronend.page.content');

//quotation
Route::get('/quotation', [App\Http\Controllers\FontendController::class, 'quotation'])->name('fronend.quotation');
Route::post('/quotation/crate', [App\Http\Controllers\FontendController::class, 'quotationCrate'])->name('fronend.quotation.crate');
Route::get('/quotation/confirm', [App\Http\Controllers\FontendController::class, 'quotationStatus'])->name('fronend.quotation.status');
Route::get('/quotation/{id}/record/{crm}/detail', [App\Http\Controllers\FontendController::class, 'quotationCrmPreview'])->name('frontend.crm.quotation.preview');

//Shopping Cart
Route::get('/cart', [App\Http\Controllers\Shopping\CartController::class, 'cart'])->name('fronend.cart');
Route::get('/cart2', [App\Http\Controllers\Shopping\CartController::class, 'cart2'])->name('fronend.cart2');
Route::post('/cart/add/one', [App\Http\Controllers\Shopping\CartController::class, 'addTocart_One']);
Route::post('/cart/add/two', [App\Http\Controllers\Shopping\CartController::class, 'addTocart_Two']);
Route::get('/cart/update', [App\Http\Controllers\Shopping\CartController::class, 'cartUpdate'])->name('cart.update');
Route::get('/cart/delete/{id}', [App\Http\Controllers\Shopping\CartController::class, 'cartDelete'])->name('cart.delete');
Route::get('/cart/clear', [App\Http\Controllers\Shopping\CartController::class, 'cartClear']);
//Shopping Coupon
Route::get('/cart/coupon', [App\Http\Controllers\Shopping\CouponController::class, 'cartCoupon'])->name('fronend.cart.coupon');
Route::get('/cart/coupon/{id}/codition/{page}', [App\Http\Controllers\Shopping\CouponController::class, 'CouponCodition'])->name('fronend.cart.coupon.codition');
Route::get('/cart/add/{code}/condition', [App\Http\Controllers\Shopping\CouponController::class, 'couponAddCondition'])->name('fronend.cart.add.condition');
Route::post('/cart/validate-coupon', [App\Http\Controllers\Shopping\CartController::class, 'ajaxValidateCoupon'])
    ->name('cart.validateCoupon');
	
//favorite
Route::get('/favorite', [App\Http\Controllers\FavoriteController::class, 'index'])->name('fronend.favorite');

//forgot
Route::get('/forgot/user', [App\Http\Controllers\FontendController::class, 'forgotPasswordUser'])->name('fronend.forgotpassword');
Route::post('/forgot/user/sendmail', [App\Http\Controllers\FontendController::class, 'forgotPasswordSendMail'])->name('fronend.forgotpassword.sendmail');
Route::get('/forgot/user', [App\Http\Controllers\FontendController::class, 'forgotPasswordUser'])->name('fronend.forgotpassword');
Route::post('/forgot/user/sendmail', [App\Http\Controllers\FontendController::class, 'forgotPasswordSendMail'])->name('fronend.forgotpassword.sendmail');
Route::get('/forgot/user/sent', [App\Http\Controllers\FontendController::class, 'forgotPasswordSent'])->name('fronend.forgotpassword.sent');
Route::get('/forgot/{id}/{code}/mail', [App\Http\Controllers\FontendController::class, 'forgotPassword'])->name('fronend.forgot.password');
Route::put('/forgot/reset/{id}/pass', [App\Http\Controllers\FontendController::class, 'forgotPasswordUpdate'])->name('fronend.forgot.password.update');


//email template
Route::get('/emailtemplate/{link}', [App\Http\Controllers\FontendController::class, 'emailtemplate'])->name('fronend.emailtemplate');
Route::get('/pv/promotion/{id}', [App\Http\Controllers\FontendController::class, 'previewPromotion'])->name('fronend.preview.promotion');

//help
Route::get('/help', [App\Http\Controllers\FontendController::class, 'indexHelp'])->name('fronend.help.index');

Route::post('/help/ticket', [App\Http\Controllers\FontendController::class, 'crateHelp'])->name('fronend.help.crate');
Route::get('/help/status/{code}', [App\Http\Controllers\FontendController::class, 'status'])->name('fronend.help.status');
Route::get('/help/review/{code}/{score}', [App\Http\Controllers\FontendController::class, 'reviewHelp'])->name('fronend.help.review');

Route::get('/order/review/{order_number}', [App\Http\Controllers\Shopping\OrderReviewController::class, 'reviewOrder'])->name('fronend.order.review');
Route::post('/order/review/store', [App\Http\Controllers\Shopping\OrderReviewController::class, 'store'])->name('reviews.store');

Auth::routes();
Route::group(['middleware' => ['auth']], function () {

    //Shopping Shopping
    Route::get('/cart/confirm', [App\Http\Controllers\Shopping\CartController::class, 'cartConfirm'])->name('fronend.cart.confirm');
    Route::get('/cart/confirm2', [App\Http\Controllers\Shopping\CartController::class, 'cartConfirm2'])->name('fronend.cart.confirm2');
    //Shopping Payment
    Route::post('/cart/confirm/crate', [App\Http\Controllers\Shopping\PaymentController::class, 'orderConfirmCrate'])->name('fronend.cart.confirm.crate');
    Route::post('/cart/confirm/crate2', [App\Http\Controllers\Shopping\PaymentController2::class, 'orderConfirmCrate2'])->name('fronend.cart.confirm.crate2');
    Route::post('/cart/payment/confirm', [App\Http\Controllers\Shopping\PaymentController::class, 'orderPaymentConfirm'])->name('fronend.cart.payment.confirm');
    Route::get('/cart/payment/{id}/notify', [App\Http\Controllers\Shopping\PaymentController::class, 'orderPaymentNotify'])->name('fronend.cart.payment.notify');
    Route::get('/cart/{id}/payment', [App\Http\Controllers\Shopping\PaymentController::class, 'orderPayment'])->name('fronend.cart.payment');
    Route::get('/cart/{id}/repeat', [App\Http\Controllers\Shopping\PaymentController::class, 'orderRepeat'])->name('fronend.cart.repeat');
    Route::put('/cart/confirm/{id}/update', [App\Http\Controllers\Shopping\PaymentController::class, 'orderConfirmUpdate'])->name('fronend.cart.confirm.update');
    Route::get('/cart/payment/{id}/update', [App\Http\Controllers\Shopping\PaymentController::class, 'orderPaymentUpdate'])->name('fronend.cart.payment.update');
    Route::get('/cart/payment/{id}/update2', [App\Http\Controllers\Shopping\PaymentController2::class, 'orderPaymentUpdate2'])->name('fronend.cart.payment.update2');

    //user --------------------------------------------------------------------------------
    Route::get('/account/main', [App\Http\Controllers\AccountController::class, 'accountMenu'])->name('fronend.account.menu');
    Route::get('/account', [App\Http\Controllers\AccountController::class, 'account'])->name('fronend.account');
    Route::put('/account/update/{id}', [App\Http\Controllers\AccountController::class, 'accountUpdate'])->name('fronend.account.update');
    Route::get('/account/order', [App\Http\Controllers\AccountController::class, 'order'])->name('fronend.account.order');
    Route::get('/account/order/{id}/detail', [App\Http\Controllers\AccountController::class, 'orderDetail'])->name('fronend.account.order.detail');
    Route::get('/account/order/invoice/{id}', [App\Http\Controllers\AccountController::class, 'invoiceDownload'])->name('fronend.account.order.invoice');
    Route::put('/account/order/{id}/cancel', [App\Http\Controllers\AccountController::class, 'orderCancel'])->name('fronend.order.cancel');
    Route::get('/account/software', [App\Http\Controllers\AccountController::class, 'software'])->name('fronend.account.software');
    Route::get('/account/software/{id}/renew', [App\Http\Controllers\AccountController::class, 'renewCheckout'])->name('fronend.account.software.renew');
    Route::get('/account/documents', [App\Http\Controllers\DocumentController::class, 'frontendIndex'])->name('fronend.account.documents');
    Route::get('/account/quotation', [App\Http\Controllers\AccountController::class, 'quotation'])->name('fronend.account.quotation');
    Route::get('/account/quotation/{id}/detail', [App\Http\Controllers\AccountController::class, 'quotationDetail'])->name('fronend.account.quotation.detail');
    Route::get('/account/address', [App\Http\Controllers\AccountController::class, 'address'])->name('fronend.account.address');
    Route::get('/account/address2', [App\Http\Controllers\AccountController::class, 'address2'])->name('fronend.account.address2');
	Route::post('/account/address/crate', [App\Http\Controllers\AccountController::class, 'addressCrate'])->name('fronend.account.address.crate');
    Route::put('/account/address/update/{id}', [App\Http\Controllers\AccountController::class, 'addressUpdate'])->name('fronend.account.address.update');
    Route::post('/account/receipt/crate', [App\Http\Controllers\AccountController::class, 'receiptCrate'])->name('fronend.account.receipt.crate');
    Route::put('/account/receipt/update/{id}', [App\Http\Controllers\AccountController::class, 'receiptUpdate'])->name('fronend.account.receipt.update');
    Route::get('/account/changepassword', [App\Http\Controllers\AccountController::class, 'changepassword'])->name('fronend.account.changepassword');
    Route::put('/account/changepassword/update/{id}', [App\Http\Controllers\AccountController::class, 'changepasswordUpdate'])->name('fronend.account.changepassword.update');
    Route::get('/account/forgotpassword', [App\Http\Controllers\AccountController::class, 'forgotpassword'])->name('fronend.account.forgotpassword');
    Route::put('/account/forgotpassword/update/{id}', [App\Http\Controllers\AccountController::class, 'forgotpasswordUpdate'])->name('fronend.account.forgotpassword.update');
    Route::get('/account/consent', [App\Http\Controllers\AccountController::class, 'pdpa'])->name('fronend.account.pdpa');
    Route::put('/account/consent/update/{id}', [App\Http\Controllers\AccountController::class, 'pdpaUpdate'])->name('fronend.account.consent.update');
    Route::put('/account/consent/removeUser/{id}', [App\Http\Controllers\AccountController::class, 'removeUser'])->name('fronend.account.consent.removeUser');
    Route::post('/account/contact/store', [App\Http\Controllers\AccountController::class, 'contactStore'])->name('fronend.account.contact.store');
    Route::delete('/account/contact/{id}/delete', [App\Http\Controllers\AccountController::class, 'contactDestroy'])->name('fronend.account.contact.delete');
    
    // เพิ่มบรรทัดนี้ในกลุ่ม route ที่ต้อง login (auth) เหมือนกับ fronend.account.software
// (ถ้าไม่แน่ใจว่ากลุ่มไหน ให้หาโดยค้นคำว่า "fronend.account.software" ใน web.php แล้ววางไว้ใกล้ๆ กัน)
Route::get('/account/faq', [App\Http\Controllers\FaqController::class, 'frontendIndex'])->name('fronend.account.faq')->withoutMiddleware('auth');
    // Shopping Coupon
    Route::get('/account/coupon', [App\Http\Controllers\Shopping\CouponController::class, 'couponAccount'])->name('fronend.account.coupon');
    Route::post('/account/coupon/crate/{userId}', [App\Http\Controllers\Shopping\CouponController::class, 'couponCrate'])->name('fronend.account.coupon.crate');

    //admin --------------------------------------------------------------------------------
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/home2', [App\Http\Controllers\HomeController::class, 'index2'])->name('home2');
    Route::get('/home/quotation/json', [App\Http\Controllers\HomeController::class, 'jsonQuotation'])->name('home.quotation.json');
    Route::post('/LogoutAdmin', [App\Http\Controllers\HomeController::class, 'LogoutAdmin'])->name('LogoutAdmin');
    
    

    //setting
    Route::get('/setting/index', [App\Http\Controllers\SettingController::class, 'index'])->name('setting.index');
    Route::put('/setting/updateSeting/{id}', [App\Http\Controllers\SettingController::class, 'updateSeting'])->name('setting.updateSeting');
    Route::put('/setting/deleteLogo', [App\Http\Controllers\SettingController::class, 'deleteLogo'])->name('setting.deleteLogo');
    Route::get('setting/herobanner', [App\Http\Controllers\SettingController::class, 'heroBanner'])->name('setting.herobanner');
Route::put('setting/herobanner/update/{id}', [App\Http\Controllers\SettingController::class, 'updateHeroBanner'])->name('setting.herobanner.update');
Route::post('/setting/herobanner/delete-image', [App\Http\Controllers\SettingController::class, 'deleteHeroImage'])->name('setting.herobanner.deleteImage');
Route::post('/setting/herobanner/delete-bg-image', [App\Http\Controllers\SettingController::class, 'deleteHeroBgImage'])->name('setting.herobanner.deleteBgImage');
Route::delete('setting/herobanner/delete-image', [App\Http\Controllers\SettingController::class, 'deleteHeroImage'])->name('setting.herobanner.deleteImage');
Route::post('/setting/herobanner/delete-full-image', [App\Http\Controllers\SettingController::class, 'deleteHeroFullImage'])->name('setting.herobanner.deleteFullImage');
Route::post('/setting/herobanner/update-mode/{id}', [App\Http\Controllers\SettingController::class, 'updateHeroMode'])->name('setting.herobanner.updateMode');
Route::get('/productcategory', [App\Http\Controllers\ProductCategoryController::class, 'index'])->name('productcategory.index');
Route::get('/productcategory/jsondata', [App\Http\Controllers\ProductCategoryController::class, 'jsondata'])->name('productcategory.jsondata');
Route::get('/productcategory/add', [App\Http\Controllers\ProductCategoryController::class, 'add'])->name('productcategory.add');
Route::post('/productcategory', [App\Http\Controllers\ProductCategoryController::class, 'store'])->name('productcategory.store');
Route::get('/productcategory/edit/{id}', [App\Http\Controllers\ProductCategoryController::class, 'edit'])->name('productcategory.edit');
Route::put('/productcategory/{id}', [App\Http\Controllers\ProductCategoryController::class, 'update'])->name('productcategory.update');
Route::delete('/productcategory/{id}', [App\Http\Controllers\ProductCategoryController::class, 'destroy'])->name('productcategory.destroy');
Route::post('/productcategory/toggle-status/{id}', [App\Http\Controllers\ProductCategoryController::class, 'toggleStatus'])->name('productcategory.toggleStatus');
Route::delete('setting/herobanner/delete-bg-image', [App\Http\Controllers\SettingController::class, 'deleteHeroBgImage'])->name('setting.herobanner.deleteBgImage');
    Route::put('/setting/deleteLogoMobile', [App\Http\Controllers\SettingController::class, 'deleteLogoMobile'])->name('setting.deleteLogoMobile');
    Route::put('/setting/deleteIcon', [App\Http\Controllers\SettingController::class, 'deleteIcon'])->name('setting.deleteIcon');
    Route::put('/setting/deleteCover', [App\Http\Controllers\SettingController::class, 'deleteCover'])->name('setting.deleteCover');
    Route::get('/setting/contact', [App\Http\Controllers\SettingController::class, 'contact'])->name('setting.contact');
    Route::put('/setting/updateContact/{id}', [App\Http\Controllers\SettingController::class, 'updateContact'])->name('setting.updateContact');
    Route::get('/setting/extensions', [App\Http\Controllers\SettingController::class, 'extensions'])->name('setting.extensions');
    Route::post('/setting/crateExtensions', [App\Http\Controllers\SettingController::class, 'crateExtensions'])->name('setting.crateExtensions');
    Route::put('/setting/updateExtensions/{id}', [App\Http\Controllers\SettingController::class, 'updateExtensions'])->name('setting.updateExtensions');
    Route::get('/setting/logtag', [App\Http\Controllers\SettingController::class, 'logtag'])->name('setting.logtag');
    Route::put('/setting/logtagUpdate', [App\Http\Controllers\SettingController::class, 'logtagUpdate'])->name('setting.logtagUpdate');
    Route::get('/setting/payment', [App\Http\Controllers\SettingController::class, 'payment'])->name('setting.payment');
    Route::post('/setting/cratePayment', [App\Http\Controllers\SettingController::class, 'cratePayment'])->name('setting.cratePayment');
    Route::put('/setting/updatePayment/{id}', [App\Http\Controllers\SettingController::class, 'updatePayment'])->name('setting.updatePayment');

    //history file import product
    Route::get('/history/fileuploads/product', [App\Http\Controllers\HistoryfileuploadController::class, 'product'])->name('history.fileupload.product.index');
    Route::get('/history/fileuploads/product/json', [App\Http\Controllers\HistoryfileuploadController::class, 'productJson'])->name('history.fileupload.product.json');

    //logtag
    Route::get('setting/logtag/json', [App\Http\Controllers\LogtagController::class, 'json'])->name('logtag.json');

    //order
    Route::get('/order', [App\Http\Controllers\OrderController::class, 'index'])->name('order.index');
    Route::get('/order/view/{id}', [App\Http\Controllers\OrderController::class, 'view'])->name('order.view');
    Route::get('/order/pdf/{id}', [App\Http\Controllers\OrderController::class, 'generatorPDF'])->name('order.pdf');
    Route::put('/order/update/staff/{id}', [App\Http\Controllers\OrderController::class, 'updateStaff'])->name('order.update.staff');
    Route::put('/order/update/staff/remark/{id}', [App\Http\Controllers\OrderController::class, 'updateRemark'])->name('order.update.staff.remark');
    Route::put('/order/update/status/{id}', [App\Http\Controllers\OrderController::class, 'updateStatus'])->name('order.update.status');
    // [PTCAD] Reset Hardware Proxy — ผูก middleware auth เพื่อให้เช็ค Auth::id() ในคอนโทรลเลอร์ได้จริง
Route::middleware(['auth'])->group(function () {
    Route::get('/api/ptcad/reset-proxy', [App\Http\Controllers\PtcadResetProxyController::class, 'status'])->name('ptcad.reset.status');
    Route::post('/api/ptcad/reset-proxy', [App\Http\Controllers\PtcadResetProxyController::class, 'request'])->name('ptcad.reset.request');
});
    Route::put('/order/update/transport/{id}', [App\Http\Controllers\OrderController::class, 'updateTransport'])->name('order.update.transport');
    Route::get('/order/status/{id}', [App\Http\Controllers\OrderController::class, 'status'])->name('order.status');
    Route::get('/order/jsondata', [App\Http\Controllers\OrderController::class, 'jsondata'])->name('order.jsondata');
    Route::get('/order/report', [App\Http\Controllers\OrderController::class, 'report'])->name('order.report');
    Route::get('/order/report/orderpayment', [App\Http\Controllers\OrderController::class, 'orderPayment'])->name('order.report.orderpayment');
    Route::get('/order/report/orderMaxOrder', [App\Http\Controllers\OrderController::class, 'orderMaxOrder'])->name('order.report.json.maxOrder');
    Route::get('/order/report/statusOrder', [App\Http\Controllers\OrderController::class, 'statusOrder'])->name('order.report.json.statusOrder');
    Route::get('/order/report/summary', [App\Http\Controllers\OrderController::class, 'orderSummary'])->name('order.report.summary');

    Route::get('/order/sendmail/{id}', [App\Http\Controllers\OrderController::class, 'sendmail'])->name('order.sendmail');

    //banner
    Route::get('/banner/index', [App\Http\Controllers\BannerController::class, 'index'])->name('banner.index');
    Route::get('/banner/add', [App\Http\Controllers\BannerController::class, 'add'])->name('banner.add');
    Route::post('/banner/crate', [App\Http\Controllers\BannerController::class, 'crate'])->name('banner.crate');
    Route::get('/banner/edit/{id}', [App\Http\Controllers\BannerController::class, 'edit'])->name('banner.edit');
    Route::put('/banner/update/{id}', [App\Http\Controllers\BannerController::class, 'update'])->name('banner.update');
    Route::get('/banner/status/{id}', [App\Http\Controllers\BannerController::class, 'status'])->name('banner.status');
    Route::get('/banner/jsondata', [App\Http\Controllers\BannerController::class, 'jsondata'])->name('banner.jsondata');
    Route::delete('banner/delete', [App\Http\Controllers\BannerController::class, 'delete'])->name('banner.delete');
    Route::put('/banner/deleteDesktop', [App\Http\Controllers\BannerController::class, 'deleteDesktop'])->name('banner.deleteDesktop');
    Route::put('/banner/deleteMobile', [App\Http\Controllers\BannerController::class, 'deleteMobile'])->name('banner.deleteMobile');

    //brand
    Route::get('setting/brand/index', [App\Http\Controllers\BrandController::class, 'index'])->name('brand.index');
    Route::get('setting/brand/add', [App\Http\Controllers\BrandController::class, 'add'])->name('brand.add');
    Route::post('setting/brand/crate', [App\Http\Controllers\BrandController::class, 'crate'])->name('brand.crate');
    Route::get('setting/brand/edit/{id}', [App\Http\Controllers\BrandController::class, 'edit'])->name('brand.edit');
    Route::put('setting/brand/update/{id}', [App\Http\Controllers\BrandController::class, 'update'])->name('brand.update');
    Route::get('setting/brand/status/{id}', [App\Http\Controllers\BrandController::class, 'status'])->name('brand.status');
    Route::get('setting/brand/jsondata', [App\Http\Controllers\BrandController::class, 'jsondata'])->name('brand.jsondata');
    Route::delete('setting/brand/delete', [App\Http\Controllers\BrandController::class, 'delete'])->name('brand.delete');
    Route::put('setting/brand/deleteImg', [App\Http\Controllers\BrandController::class, 'deleteImg'])->name('brand.deleteImg');

    //product
    Route::get('setting/product/index', [App\Http\Controllers\ProductController::class, 'index'])->name('product.index');
    Route::get('setting/product/add', [App\Http\Controllers\ProductController::class, 'add'])->name('product.add');
    Route::post('setting/product/crate', [App\Http\Controllers\ProductController::class, 'crate'])->name('product.crate');
    Route::get('setting/product/{tab}/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('product.edit');
    Route::put('setting/product/update/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('product.update');
    Route::put('setting/product/update/content/{id}', [App\Http\Controllers\ProductController::class, 'updateContent'])->name('product.update.content');
    Route::get('setting/product/jsondata', [App\Http\Controllers\ProductController::class, 'jsondata'])->name('product.jsondata');
    Route::get('setting/product/jsonCatsub', [App\Http\Controllers\ProductController::class, 'jsonCatsub'])->name('product.jsonCatsub');
    Route::get('setting/product/jsonGetpro', [App\Http\Controllers\ProductController::class, 'jsonGetpro'])->name('product.jsonGetpro');
    Route::delete('settingproduct/delete', [App\Http\Controllers\ProductController::class, 'delete'])->name('product.delete');
    Route::put('setting/product/deleteFile', [App\Http\Controllers\ProductController::class, 'deleteFile'])->name('product.delete.file');
    Route::post('setting/product/import/excel', [App\Http\Controllers\ProductController::class, 'import'])->name('product.import.excel');
	Route::post('setting/product/export/excel', [App\Http\Controllers\ProductController::class, 'export'])->name('product.export.excel');
	Route::get('setting/product/report', [App\Http\Controllers\ProductController::class, 'report'])->name('product.report');
    Route::get('setting/product/json/beatseller', [App\Http\Controllers\ProductController::class, 'jsonBestseller'])->name('product.json.beatseller');
    Route::get('setting/product/json/type', [App\Http\Controllers\ProductController::class, 'jsonType'])->name('product.json.type');

    //product image
    Route::post('setting/product/crateProductimg', [App\Http\Controllers\ProductController::class, 'crateProductimg'])->name('product.crateProductimg');
    Route::delete('setting/product/deleteImg', [App\Http\Controllers\ProductController::class, 'deleteImg'])->name('product.deleteImg');

    //product status
    Route::get('setting/product/status/json', [App\Http\Controllers\ProductController::class, 'jsonStatus'])->name('product.status.json');
    Route::get('setting/product/status/{id}', [App\Http\Controllers\ProductController::class, 'status'])->name('product.status');

    //product spec
    Route::post('setting/product/spec/crate', [App\Http\Controllers\ProductController::class, 'crateSpec'])->name('product.spec.crate');
    Route::get('setting/product/spec/json/{id}', [App\Http\Controllers\ProductController::class, 'jsonSpec'])->name('product.spec.json');
    Route::delete('setting/product/spec/delete', [App\Http\Controllers\ProductController::class, 'deleteSpec'])->name('product.spec.delete');
    Route::delete('setting/product/spec/deleteall', [App\Http\Controllers\ProductController::class, 'deleteSpecAll'])->name('product.spec.deleteAll');

    //product detail
    Route::get('setting/product/detail/{tab}/add/{id}', [App\Http\Controllers\ProductdetailController::class, 'add'])->name('product.detail.add');
    Route::post('setting/product/detail/crate', [App\Http\Controllers\ProductdetailController::class, 'crate'])->name('product.detail.crate');
    Route::get('setting/product/{tab}/detail/{proId}/edit/{id}', [App\Http\Controllers\ProductdetailController::class, 'edit'])->name('product.detail.edit');
    Route::put('setting/product/detail/update/{id}', [App\Http\Controllers\ProductdetailController::class, 'update'])->name('product.detail.update');
    Route::put('setting/product/detail/updateModel/{id}', [App\Http\Controllers\ProductdetailController::class, 'updateModel'])->name('product.detail.updateModel');
    Route::get('setting/product/detail/status/{id}', [App\Http\Controllers\ProductdetailController::class, 'status'])->name('product.detail.status');
    Route::get('setting/product/detail/jsondata/{id}', [App\Http\Controllers\ProductdetailController::class, 'jsondata'])->name('product.detail.jsondata');
    Route::delete('setting/product/detail/delete', [App\Http\Controllers\ProductdetailController::class, 'delete'])->name('product.detail.delete');
    Route::delete('setting/product/detail/deleteImg', [App\Http\Controllers\ProductdetailController::class, 'deleteImg'])->name('product.detail.deleteImg');

    //product condition
    Route::get('setting/condition/index', [App\Http\Controllers\ConditionController::class, 'index'])->name('condition.index');
    Route::get('setting/condition/add', [App\Http\Controllers\ConditionController::class, 'add'])->name('condition.add');
    Route::post('setting/condition/crate', [App\Http\Controllers\ConditionController::class, 'crate'])->name('condition.crate');
    Route::get('setting/condition/edit/{id}', [App\Http\Controllers\ConditionController::class, 'edit'])->name('condition.edit');
    Route::put('setting/condition/update/{id}', [App\Http\Controllers\ConditionController::class, 'update'])->name('condition.update');
    Route::get('setting/condition/status/{id}', [App\Http\Controllers\ConditionController::class, 'status'])->name('condition.status');
    Route::get('setting/condition/jsondata', [App\Http\Controllers\ConditionController::class, 'jsondata'])->name('condition.jsondata');
    Route::delete('setting/condition/delete', [App\Http\Controllers\ConditionController::class, 'delete'])->name('condition.delete');
    Route::put('setting/condition/deleteImg', [App\Http\Controllers\ConditionController::class, 'deleteImg'])->name('condition.deleteImg');

    //category
    Route::get('/category/index', [App\Http\Controllers\CategoryController::class, 'index'])->name('category.index');
    Route::get('/category/add', [App\Http\Controllers\CategoryController::class, 'add'])->name('category.add');
    Route::post('/category/crate', [App\Http\Controllers\CategoryController::class, 'crate'])->name('category.crate');
    Route::get('/category/edit/{id}', [App\Http\Controllers\CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/category/update/{id}', [App\Http\Controllers\CategoryController::class, 'update'])->name('category.update');
    Route::get('/category/status/{id}', [App\Http\Controllers\CategoryController::class, 'status'])->name('category.status');
    Route::get('/category/jsondata', [App\Http\Controllers\CategoryController::class, 'jsondata'])->name('category.jsondata');
    Route::delete('category/delete', [App\Http\Controllers\CategoryController::class, 'delete'])->name('category.delete');

    //sub category
    Route::get('/categorysub/{categoryId}/index', [App\Http\Controllers\CategorysubController::class, 'index'])->name('categorysub.index');
    Route::get('/categorysub/{categoryId}/add', [App\Http\Controllers\CategorysubController::class, 'add'])->name('categorysub.add');
    Route::post('/categorysub/crate', [App\Http\Controllers\CategorysubController::class, 'crate'])->name('categorysub.crate');
    Route::get('/categorysub/{categoryId}/edit/{subId}', [App\Http\Controllers\CategorysubController::class, 'edit'])->name('categorysub.edit');
    Route::put('/categorysub/{categoryId}/update/{subId}', [App\Http\Controllers\CategorysubController::class, 'update'])->name('categorysub.update');
    Route::get('/category/{categoryId}/status/{subId}', [App\Http\Controllers\CategorysubController::class, 'status'])->name('categorysub.status');
    Route::get('/categorysub/jsondata', [App\Http\Controllers\CategorysubController::class, 'jsondata'])->name('categorysub.jsondata');
    Route::delete('categorysub/delete', [App\Http\Controllers\CategorysubController::class, 'delete'])->name('categorysub.delete');

    //type
    Route::get('/type/setting', [App\Http\Controllers\TypeController::class, 'setting'])->name('type.setting');
    Route::post('/type/setting/crate', [App\Http\Controllers\TypeController::class, 'settingCrate'])->name('type.setting.crate');
    Route::put('/type/setting/update/{id}', [App\Http\Controllers\TypeController::class, 'settingUpdate'])->name('type.setting.update');
    Route::get('/type/index', [App\Http\Controllers\TypeController::class, 'index'])->name('type.index');
    Route::get('/type/add', [App\Http\Controllers\TypeController::class, 'add'])->name('type.add');
    Route::post('/type/crate', [App\Http\Controllers\TypeController::class, 'crate'])->name('type.crate');
    Route::get('/type/edit/{id}', [App\Http\Controllers\TypeController::class, 'edit'])->name('type.edit');
    Route::put('/type/update/{id}', [App\Http\Controllers\TypeController::class, 'update'])->name('type.update');
    Route::get('/type/status/{id}', [App\Http\Controllers\TypeController::class, 'status'])->name('type.status');
    Route::get('/type/jsondata', [App\Http\Controllers\TypeController::class, 'jsondata'])->name('type.jsondata');
    Route::delete('type/delete', [App\Http\Controllers\TypeController::class, 'delete'])->name('type.delete');

    //popup
    Route::get('/popup/index', [App\Http\Controllers\PopupController::class, 'index'])->name('popup.index');
    Route::post('/popup/crate', [App\Http\Controllers\PopupController::class, 'crate'])->name('popup.crate');
    Route::put('/popup/update/{id}', [App\Http\Controllers\PopupController::class, 'update'])->name('popup.update');
    Route::delete('popup/delete', [App\Http\Controllers\PopupController::class, 'delete'])->name('popup.delete');
    Route::put('/popup/deleteImg', [App\Http\Controllers\PopupController::class, 'deleteImg'])->name('popup.deleteImg');

    //promotion
    Route::get('/promotion/index', [App\Http\Controllers\PromotionController::class, 'index'])->name('promotion.index');
    Route::get('/promotion/add', [App\Http\Controllers\PromotionController::class, 'add'])->name('promotion.add');
    Route::post('/promotion/crate', [App\Http\Controllers\PromotionController::class, 'crate'])->name('promotion.crate');
    Route::get('/promotion/edit/{id}', [App\Http\Controllers\PromotionController::class, 'edit'])->name('promotion.edit');
    Route::put('/promotion/update/{id}', [App\Http\Controllers\PromotionController::class, 'update'])->name('promotion.update');
    Route::get('/promotion/status/{id}', [App\Http\Controllers\PromotionController::class, 'status'])->name('promotion.status');
    Route::get('/promotion/jsondata', [App\Http\Controllers\PromotionController::class, 'jsondata'])->name('promotion.jsondata');
    Route::delete('promotion/delete', [App\Http\Controllers\PromotionController::class, 'delete'])->name('promotion.delete');
    Route::put('/promotion/deleteImg', [App\Http\Controllers\PromotionController::class, 'deleteImg'])->name('promotion.deleteImg');
    Route::get('/promotion/calendar', [App\Http\Controllers\PromotionController::class, 'calendar'])->name('promotion.calendar');
    Route::get('/promotion/calendar/json', [App\Http\Controllers\PromotionController::class, 'calendarJson'])->name('promotion.calendar.json');
    Route::get('/promotion/pdpa', [App\Http\Controllers\PromotionController::class, 'pdpa'])->name('promotion.pdpa');
    Route::get('/promotion/pdpa/jsondata', [App\Http\Controllers\PromotionController::class, 'pdpaJsond'])->name('promotion.pdpa.jsondata');
    Route::get('/promotion/pdpa/jsonTable', [App\Http\Controllers\PromotionController::class, 'jsonTable'])->name('promotion.pdpa.jsonTable');
    Route::get('/promotion/pdpa/export', [App\Http\Controllers\PromotionController::class, 'pdpaExport'])->name('promotion.pdpa.export');

    //promotion report notify
    Route::get('/promotion/report/notify', [App\Http\Controllers\PromotionController::class, 'reportNotify'])->name('promotion.report.notify');
    Route::get('/promotion/report/notify/jsondata', [App\Http\Controllers\PromotionController::class, 'reportNotifyJson'])->name('promotion.report.notify.jsondata');

    //promotion setting line notify
    Route::get('/promotion/setting/index', [App\Http\Controllers\PromotionlinenotifyController::class, 'index'])->name('promotion.setting.linetify.index');
    Route::get('/promotion/setting/add', [App\Http\Controllers\PromotionlinenotifyController::class, 'add'])->name('promotion.setting.linetify.add');
    Route::post('/promotion/setting/crate', [App\Http\Controllers\PromotionlinenotifyController::class, 'crate'])->name('promotion.setting.linetify.crate');
    Route::get('/promotion/setting/edit/{id}', [App\Http\Controllers\PromotionlinenotifyController::class, 'edit'])->name('promotion.setting.linetify.edit');
    Route::put('/promotion/setting/update/{id}', [App\Http\Controllers\PromotionlinenotifyController::class, 'update'])->name('promotion.setting.linetify.update');
    Route::get('/promotion/setting/status/{id}', [App\Http\Controllers\PromotionlinenotifyController::class, 'status'])->name('promotion.setting.linetify.status');
    Route::get('/promotion/setting/jsondata', [App\Http\Controllers\PromotionlinenotifyController::class, 'jsondata'])->name('promotion.setting.linetify.jsondata');
    Route::delete('promotion/setting/delete', [App\Http\Controllers\PromotionlinenotifyController::class, 'delete'])->name('promotion.setting.linetify.delete');

    //software
    Route::get('/setting/software/index', [App\Http\Controllers\SoftwareController::class, 'index'])->name('software.index');
    Route::get('/setting/software/add', [App\Http\Controllers\SoftwareController::class, 'add'])->name('software.add');
    Route::post('/setting/software/crate', [App\Http\Controllers\SoftwareController::class, 'crate'])->name('software.crate');
    Route::get('/setting/software/edit/{id}', [App\Http\Controllers\SoftwareController::class, 'edit'])->name('software.edit');
    Route::put('/setting/software/update/{id}', [App\Http\Controllers\SoftwareController::class, 'update'])->name('software.update');
    Route::get('/setting/software/status/{id}', [App\Http\Controllers\SoftwareController::class, 'status'])->name('software.status');
    Route::get('/setting/software/jsondata', [App\Http\Controllers\SoftwareController::class, 'jsondata'])->name('software.jsondata');
    Route::delete('/setting/software/delete', [App\Http\Controllers\SoftwareController::class, 'delete'])->name('software.delete');

    Route::get('admin/civilpromax/import', [App\Http\Controllers\SoftwareController::class, 'civilProMaxImportForm'])
    ->name('admin.civilpromax.import')->middleware(['auth']);
Route::post('admin/civilpromax/import', [App\Http\Controllers\SoftwareController::class, 'civilProMaxImportStore'])
    ->name('admin.civilpromax.import.store')->middleware(['auth']);
    Route::get('admin/civilpromax/stock', [App\Http\Controllers\SoftwareController::class, 'civilProMaxStockList'])
    ->name('admin.civilpromax.stock')->middleware(['auth']);

    //program
    Route::get('/setting/program/index', [App\Http\Controllers\ProgramController::class, 'index'])->name('program.index');
    Route::get('/setting/program/add', [App\Http\Controllers\ProgramController::class, 'add'])->name('program.add');
    Route::post('/setting/program/crate', [App\Http\Controllers\ProgramController::class, 'crate'])->name('program.crate');
    Route::get('/setting/program/edit/{tab}/{id}', [App\Http\Controllers\ProgramController::class, 'edit'])->name('program.edit');
    Route::put('/setting/program/update/{tab}/{id}', [App\Http\Controllers\ProgramController::class, 'update'])->name('program.update');
    Route::get('/setting/program/status/{id}', [App\Http\Controllers\ProgramController::class, 'status'])->name('program.status');
    Route::get('/setting/program/jsondata', [App\Http\Controllers\ProgramController::class, 'jsondata'])->name('program.jsondata');
    Route::delete('/setting/program/delete', [App\Http\Controllers\ProgramController::class, 'delete'])->name('program.delete');

    //program install
    Route::get('/setting/program/install/{p}add', [App\Http\Controllers\PrograminstallController::class, 'add'])->name('program.install.add');
    Route::post('/setting/program/install/{p}/crate', [App\Http\Controllers\PrograminstallController::class, 'crate'])->name('program.install.crate');
    Route::get('/setting/program/install/{p}/edit/{id}', [App\Http\Controllers\PrograminstallController::class, 'edit'])->name('program.install.edit');
    Route::put('/setting/program/install/{p}/update/{id}', [App\Http\Controllers\PrograminstallController::class, 'update'])->name('program.install.update');
    Route::get('/setting/program/install/status/{id}', [App\Http\Controllers\PrograminstallController::class, 'status'])->name('program.install.status');
    Route::get('/setting/program/install/{p}/jsondata', [App\Http\Controllers\PrograminstallController::class, 'jsondata'])->name('program.install.jsondata');
    Route::delete('/setting/program/install/delete', [App\Http\Controllers\PrograminstallController::class, 'delete'])->name('program.install.delete');
    Route::put('/setting/program/install/delete/file', [App\Http\Controllers\PrograminstallController::class, 'deleteFile'])->name('program.install.delete.file');

    //emailtemplate
    Route::get('/promotion/emailtemplate/index', [App\Http\Controllers\EmailtemplateController::class, 'index'])->name('promotion.emailtemplate.index');
    Route::get('/promotion/emailtemplate/add', [App\Http\Controllers\EmailtemplateController::class, 'add'])->name('promotion.emailtemplate.add');
    Route::post('/promotion/emailtemplate/crate', [App\Http\Controllers\EmailtemplateController::class, 'crate'])->name('promotion.emailtemplate.crate');
    Route::get('/promotion/emailtemplate/edit/{id}', [App\Http\Controllers\EmailtemplateController::class, 'edit'])->name('promotion.emailtemplate.edit');
    Route::put('/promotion/emailtemplate/update/{id}', [App\Http\Controllers\EmailtemplateController::class, 'update'])->name('promotion.emailtemplate.update');
    Route::get('/promotion/emailtemplate/status/{id}', [App\Http\Controllers\EmailtemplateController::class, 'status'])->name('promotion.emailtemplate.status');
    Route::get('/promotion/emailtemplate/jsondata', [App\Http\Controllers\EmailtemplateController::class, 'jsondata'])->name('promotion.emailtemplate.jsondata');
    Route::delete('promotion/emailtemplate/delete', [App\Http\Controllers\EmailtemplateController::class, 'delete'])->name('promotion.emailtemplate.delete');

    //promotion coupon
    Route::get('/promotion/coupon/index', [App\Http\Controllers\CouponController::class, 'index'])->name('promotion.coupon.index');
    Route::get('/promotion/coupon/add', [App\Http\Controllers\CouponController::class, 'add'])->name('promotion.coupon.add');
    Route::post('/promotion/coupon/crate', [App\Http\Controllers\CouponController::class, 'crate'])->name('promotion.coupon.crate');
    Route::get('/promotion/coupon/edit/{id}', [App\Http\Controllers\CouponController::class, 'edit'])->name('promotion.coupon.edit');
    Route::put('/promotion/coupon/update/{id}', [App\Http\Controllers\CouponController::class, 'update'])->name('promotion.coupon.update');
    Route::get('/promotion/coupon/status/{id}', [App\Http\Controllers\CouponController::class, 'status'])->name('promotion.coupon.status');
    Route::get('/promotion/coupon/jsondata', [App\Http\Controllers\CouponController::class, 'jsondata'])->name('promotion.coupon.jsondata');
    Route::get('/promotion/coupon/jsoncategorie', [App\Http\Controllers\CouponController::class, 'jsoncategorie'])->name('promotion.coupon.product.jsoncategorie');
    Route::delete('promotion/coupon/delete', [App\Http\Controllers\CouponController::class, 'delete'])->name('promotion.coupon.delete');
    Route::get('/promotion/coupon/{id}/report', [App\Http\Controllers\CouponController::class, 'report'])->name('promotion.coupon.report');
    Route::get('/promotion/coupon/report/jsondata', [App\Http\Controllers\CouponController::class, 'reportJson'])->name('promotion.coupon.report.json');

    //promotion recommend
    Route::get('/recommend/promotion/index', [App\Http\Controllers\RecommendpromotionController::class, 'index'])->name('recommend.promotion.index');
    Route::get('/recommend/promotion/add', [App\Http\Controllers\RecommendpromotionController::class, 'add'])->name('recommend.promotion.add');
    Route::post('/recommend/promotion/crate', [App\Http\Controllers\RecommendpromotionController::class, 'crate'])->name('recommend.promotion.crate');
    Route::get('/recommend/promotion/edit/{id}', [App\Http\Controllers\RecommendpromotionController::class, 'edit'])->name('recommend.promotion.edit');
    Route::put('/recommend/promotion/update/{id}', [App\Http\Controllers\RecommendpromotionController::class, 'update'])->name('recommend.promotion.update');
    Route::get('/recommend/promotion/status/{id}', [App\Http\Controllers\RecommendpromotionController::class, 'status'])->name('recommend.promotion.status');
    Route::get('/recommend/promotion/jsondata', [App\Http\Controllers\RecommendpromotionController::class, 'jsondata'])->name('recommend.promotion.jsondata');
    Route::delete('recommend/promotion/delete', [App\Http\Controllers\RecommendpromotionController::class, 'delete'])->name('recommend.promotion.delete');
    Route::put('/recommend/promotion/deleteImg', [App\Http\Controllers\RecommendpromotionController::class, 'deleteImg'])->name('recommend.promotion.deleteImg');

    Route::get('/recommend/category/index', [App\Http\Controllers\RecommendcategoryController::class, 'index'])->name('recommend.category.index');
    Route::get('/recommend/category/add', [App\Http\Controllers\RecommendcategoryController::class, 'add'])->name('recommend.category.add');
    Route::post('/recommend/category/crate', [App\Http\Controllers\RecommendcategoryController::class, 'crate'])->name('recommend.category.crate');
    Route::get('/recommend/category/edit/{id}', [App\Http\Controllers\RecommendcategoryController::class, 'edit'])->name('recommend.category.edit');
    Route::put('/recommend/category/update/{id}', [App\Http\Controllers\RecommendcategoryController::class, 'update'])->name('recommend.category.update');
    Route::get('/recommend/category/status/{id}', [App\Http\Controllers\RecommendcategoryController::class, 'status'])->name('recommend.category.status');
    Route::get('/recommend/category/jsondata', [App\Http\Controllers\RecommendcategoryController::class, 'jsondata'])->name('recommend.category.jsondata');
    Route::delete('recommend/category/delete', [App\Http\Controllers\RecommendcategoryController::class, 'delete'])->name('recommend.category.delete');
    Route::put('/recommend/category/deleteImg', [App\Http\Controllers\RecommendcategoryController::class, 'deleteImg'])->name('recommend.category.deleteImg');

    Route::get('/recommend/product/index', [App\Http\Controllers\RecommendproductController::class, 'index'])->name('recommend.product.index');
    Route::get('/recommend/product/add', [App\Http\Controllers\RecommendproductController::class, 'add'])->name('recommend.product.add');
    Route::post('/recommend/product/crate', [App\Http\Controllers\RecommendproductController::class, 'crate'])->name('recommend.product.crate');
    Route::get('/recommend/product/edit/{id}', [App\Http\Controllers\RecommendproductController::class, 'edit'])->name('recommend.product.edit');
    Route::put('/recommend/product/update/{id}', [App\Http\Controllers\RecommendproductController::class, 'update'])->name('recommend.product.update');
    Route::get('/recommend/product/status/{id}', [App\Http\Controllers\RecommendproductController::class, 'status'])->name('recommend.product.status');
    Route::get('/recommend/product/jsondata', [App\Http\Controllers\RecommendproductController::class, 'jsondata'])->name('recommend.product.jsondata');
    Route::get('/recommend/product/jsonGet', [App\Http\Controllers\RecommendproductController::class, 'jsonGet'])->name('recommend.product.jsonGet');
    Route::delete('recommend/product/delete', [App\Http\Controllers\RecommendproductController::class, 'delete'])->name('recommend.product.delete');
    Route::put('/recommend/product/deleteImg', [App\Http\Controllers\RecommendproductController::class, 'deleteImg'])->name('recommend.product.deleteImg');

    Route::get('/recommend/category/product/index', [App\Http\Controllers\RecommendcategoryproductController::class, 'index'])->name('recommend.category.product.index');
    Route::get('/recommend/category/product/add', [App\Http\Controllers\RecommendcategoryproductController::class, 'add'])->name('recommend.category.product.add');
    Route::post('/recommend/category/product/crate', [App\Http\Controllers\RecommendcategoryproductController::class, 'crate'])->name('recommend.category.product.crate');
    Route::get('/recommend/category/product/edit/{id}', [App\Http\Controllers\RecommendcategoryproductController::class, 'edit'])->name('recommend.category.product.edit');
    Route::put('/recommend/category/product/update/{id}', [App\Http\Controllers\RecommendcategoryproductController::class, 'update'])->name('recommend.category.product.update');
    Route::get('/recommend/category/product/status/{id}', [App\Http\Controllers\RecommendcategoryproductController::class, 'status'])->name('recommend.category.product.status');
    Route::get('/recommend/category/product/jsondata', [App\Http\Controllers\RecommendcategoryproductController::class, 'jsondata'])->name('recommend.category.product.jsondata');
    Route::get('/recommend/category/product/jsonGet', [App\Http\Controllers\RecommendcategoryproductController::class, 'jsonGet'])->name('recommend.category.product.jsonGet');
    Route::get('/recommend/category/product/jsonproductGet', [App\Http\Controllers\RecommendcategoryproductController::class, 'jsonproductGet'])->name('recommend.category.product.jsonproductGet');
    Route::delete('recommend/category/product/delete', [App\Http\Controllers\RecommendcategoryproductController::class, 'delete'])->name('recommend.category.product.delete');
    Route::put('/recommend/category/product/deleteImg', [App\Http\Controllers\RecommendcategoryproductController::class, 'deleteImg'])->name('recommend.category.product.deleteImg');

    //onepage
    Route::get('/onepage/index', [App\Http\Controllers\Onepages\OnepageController::class, 'index'])->name('onepage.index');
    Route::get('/onepage/add', [App\Http\Controllers\Onepages\OnepageController::class, 'add'])->name('onepage.add');
    Route::post('/onepage/crate', [App\Http\Controllers\Onepages\OnepageController::class, 'crate'])->name('onepage.crate');
    Route::get('/onepage/edit/{id}', [App\Http\Controllers\Onepages\OnepageController::class, 'edit'])->name('onepage.edit');
    Route::put('/onepage/update/{id}', [App\Http\Controllers\Onepages\OnepageController::class, 'update'])->name('onepage.update');
    Route::get('/onepage/status/{id}', [App\Http\Controllers\Onepages\OnepageController::class, 'status'])->name('onepage.status');
    Route::get('/onepage/jsondata', [App\Http\Controllers\Onepages\OnepageController::class, 'jsondata'])->name('onepage.jsondata');
    Route::delete('onepage/delete', [App\Http\Controllers\Onepages\OnepageController::class, 'delete'])->name('onepage.delete');
    Route::put('/onepage/deleteImg', [App\Http\Controllers\Onepages\OnepageController::class, 'deleteImg'])->name('onepage.deleteImg');

    //onepage setting
    Route::get('/onepage/{page}/setting', [App\Http\Controllers\Onepages\SettingController::class, 'index'])->name('onepage.setting');
    Route::post('/onepage/{page}/setting/crate', [App\Http\Controllers\Onepages\SettingController::class, 'crate'])->name('onepage.setting.crate');
    Route::put('/onepage/{page}/setting/deleteImg', [App\Http\Controllers\Onepages\SettingController::class, 'deleteImg'])->name('onepage.setting.deleteImg');
    Route::get('/onepage/{page}/setting/status/{id}', [App\Http\Controllers\Onepages\SettingController::class, 'status'])->name('onepage.setting.status');

    //onepage setting form
    Route::get('/onepage/{page}/setting/form', [App\Http\Controllers\Onepages\FormController::class, 'index'])->name('onepage.setting.form');
    Route::post('/onepage/{page}/setting/form/crate', [App\Http\Controllers\Onepages\FormController::class, 'crate'])->name('onepage.setting.form.crate');
    Route::delete('/onepage/setting/form/delete', [App\Http\Controllers\Onepages\FormController::class, 'delete'])->name('onepage.setting.form.delete');

    //onepage setting page
    Route::get('/onepage/{page}/setting/page', [App\Http\Controllers\Onepages\SettingController::class, 'page'])->name('onepage.setting.page');

    //onepage banner
    Route::get('/onepage/banner/{page}', [App\Http\Controllers\Onepages\BannerController::class, 'index'])->name('onepage.setting.banner');
    Route::post('/onepage/banner/{page}/crate', [App\Http\Controllers\Onepages\BannerController::class, 'crate'])->name('onepage.setting.banner.crate');
    Route::put('/onepage/banner/{page}/update/{id}', [App\Http\Controllers\Onepages\BannerController::class, 'update'])->name('onepage.setting.banner.update');
    Route::put('/onepage/banner/deleteImg', [App\Http\Controllers\Onepages\BannerController::class, 'deleteImg'])->name('onepage.setting.banner.deleteImg');

    //onepage footer
    Route::get('/onepage/footer/{page}', [App\Http\Controllers\Onepages\FooterController::class, 'index'])->name('onepage.setting.footer');
    Route::post('/onepage/footer/{page}/crate', [App\Http\Controllers\Onepages\FooterController::class, 'crate'])->name('onepage.setting.footer.crate');
    Route::put('/onepage/footer/{page}/update/{id}', [App\Http\Controllers\Onepages\FooterController::class, 'update'])->name('onepage.setting.footer.update');

    //onepage section
    Route::get('/onepage/section/{page}', [App\Http\Controllers\Onepages\SectionController::class, 'index'])->name('onepage.setting.section');
    Route::get('/onepage/section/add/{page}', [App\Http\Controllers\Onepages\SectionController::class, 'add'])->name('onepage.setting.section.add');
    Route::post('/onepage/section/crate', [App\Http\Controllers\Onepages\SectionController::class, 'crate'])->name('onepage.setting.section.crate');
    Route::get('/onepage/section/edit/{page}/{id}', [App\Http\Controllers\Onepages\SectionController::class, 'edit'])->name('onepage.setting.section.edit');
    Route::put('/onepage/section/update/{id}', [App\Http\Controllers\Onepages\SectionController::class, 'update'])->name('onepage.setting.section.update');
    Route::get('/onepage/section/jsondata/{page}/{section}', [App\Http\Controllers\Onepages\SectionController::class, 'jsondata'])->name('onepage.setting.section.jsondata');
    Route::get('/onepage/section/status/{id}', [App\Http\Controllers\Onepages\SectionController::class, 'status'])->name('onepage.setting.section.status');
    Route::delete('/onepage/section/delete', [App\Http\Controllers\Onepages\SectionController::class, 'delete'])->name('onepage.setting.section.delete');

    //onepage tab
    // Route::get('/onepage/{page}/tab/{section}', [App\Http\Controllers\OnepageController::class, 'settingTab'])->name('onepage.setting.tab');
    // Route::get('/onepage/{page}/tab/add/{section}', [App\Http\Controllers\OnepageController::class, 'settingTabadd'])->name('onepage.setting.tab.add');
    // Route::post('/onepage/{page}/tab/crate', [App\Http\Controllers\OnepageController::class, 'settingTabcrate'])->name('onepage.setting.tab.crate');
    // Route::get('/onepage/{page}/tab/edit/{id}', [App\Http\Controllers\OnepageController::class, 'settingTabedit'])->name('onepage.setting.tab.edit');
    // Route::put('/onepage/{page}/tab/update/{id}', [App\Http\Controllers\OnepageController::class, 'settingTabupdate'])->name('onepage.setting.tab.update');
    // Route::get('/onepage/{page}/tab/{section}/jsondata', [App\Http\Controllers\OnepageController::class, 'settingTabJsondata'])->name('onepage.setting.tab.jsondata');


    //custom code
    Route::get('/custom/{code}/index', [App\Http\Controllers\CustomcodeController::class, 'index'])->name('custom.index');
    Route::get('/custom/{code}/add', [App\Http\Controllers\CustomcodeController::class, 'add'])->name('custom.add');
    Route::post('/custom/crate', [App\Http\Controllers\CustomcodeController::class, 'crate'])->name('custom.crate');
    Route::get('/custom/{code}/edit/{id}', [App\Http\Controllers\CustomcodeController::class, 'edit'])->name('custom.edit');
    Route::put('/custom/update/{id}', [App\Http\Controllers\CustomcodeController::class, 'update'])->name('custom.update');
    Route::get('/custom/status/{id}', [App\Http\Controllers\CustomcodeController::class, 'status'])->name('custom.status');
    Route::get('/custom/jsondata/{code}', [App\Http\Controllers\CustomcodeController::class, 'jsondata'])->name('custom.jsondata');
    Route::delete('custom/delete', [App\Http\Controllers\CustomcodeController::class, 'delete'])->name('custom.delete');

    //category
    Route::get('/setting/category/index', [App\Http\Controllers\CategoryController::class, 'index'])->name('category.index');
    Route::get('/setting/category/add', [App\Http\Controllers\CategoryController::class, 'add'])->name('category.add');
    Route::post('/setting/category/crate', [App\Http\Controllers\CategoryController::class, 'crate'])->name('category.crate');
    Route::get('/setting/category/edit/{id}', [App\Http\Controllers\CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/setting/category/update/{id}', [App\Http\Controllers\CategoryController::class, 'update'])->name('category.update');
    Route::get('/setting/category/status/{id}', [App\Http\Controllers\CategoryController::class, 'status'])->name('category.status');
    Route::get('/setting/category/jsondata', [App\Http\Controllers\CategoryController::class, 'jsondata'])->name('category.jsondata');
    Route::delete('setting/category/delete', [App\Http\Controllers\CategoryController::class, 'delete'])->name('category.delete');

    //redirect page
    Route::get('/setting/redirect/index', [App\Http\Controllers\RedirectController::class, 'index'])->name('redirect.index');
    Route::get('/setting/redirect/add', [App\Http\Controllers\RedirectController::class, 'add'])->name('redirect.add');
    Route::post('/setting/redirect/crate', [App\Http\Controllers\RedirectController::class, 'crate'])->name('redirect.crate');
    Route::get('/setting/redirect/edit/{id}', [App\Http\Controllers\RedirectController::class, 'edit'])->name('redirect.edit');
    Route::put('/setting/redirect/update/{id}', [App\Http\Controllers\RedirectController::class, 'update'])->name('redirect.update');
    Route::get('/setting/redirect/status/{id}', [App\Http\Controllers\RedirectController::class, 'status'])->name('redirect.status');
    Route::get('/setting/redirect/jsondata', [App\Http\Controllers\RedirectController::class, 'jsondata'])->name('redirect.jsondata');
    Route::delete('setting/redirect/delete', [App\Http\Controllers\RedirectController::class, 'delete'])->name('redirect.delete');

    //hot search
    Route::get('/setting/hotsearch/index', [App\Http\Controllers\HotsearchController::class, 'index'])->name('hotsearch.index');
    Route::get('/setting/hotsearch/add', [App\Http\Controllers\HotsearchController::class, 'add'])->name('hotsearch.add');
    Route::post('/setting/hotsearch/crate', [App\Http\Controllers\HotsearchController::class, 'crate'])->name('hotsearch.crate');
    Route::get('/setting/hotsearch/edit/{id}', [App\Http\Controllers\HotsearchController::class, 'edit'])->name('hotsearch.edit');
    Route::put('/setting/hotsearch/update/{id}', [App\Http\Controllers\HotsearchController::class, 'update'])->name('hotsearch.update');
    Route::get('/setting/hotsearch/status/{id}', [App\Http\Controllers\HotsearchController::class, 'status'])->name('hotsearch.status');
    Route::get('/setting/hotsearch/jsondata', [App\Http\Controllers\HotsearchController::class, 'jsondata'])->name('hotsearch.jsondata');
    Route::delete('setting/hotsearch/delete', [App\Http\Controllers\HotsearchController::class, 'delete'])->name('hotsearch.delete');

    //transport
    Route::get('/setting/transport/index', [App\Http\Controllers\TransportController::class, 'index'])->name('transport.index');
    Route::put('/setting/transport/status/{id}', [App\Http\Controllers\TransportController::class, 'status'])->name('transport.status');
    Route::get('/setting/transport/jsondata', [App\Http\Controllers\TransportController::class, 'jsondata'])->name('transport.jsondata');

    //bank
    Route::get('/setting/bank/index', [App\Http\Controllers\BankController::class, 'index'])->name('bank.index');
    Route::get('/setting/bank/add', [App\Http\Controllers\BankController::class, 'add'])->name('bank.add');
    Route::post('/setting/bank/crate', [App\Http\Controllers\BankController::class, 'crate'])->name('bank.crate');
    Route::get('/setting/bank/edit/{id}', [App\Http\Controllers\BankController::class, 'edit'])->name('bank.edit');
    Route::put('/setting/bank/update/{id}', [App\Http\Controllers\BankController::class, 'update'])->name('bank.update');
    Route::get('/setting/bank/status/{id}', [App\Http\Controllers\BankController::class, 'status'])->name('bank.status');
    Route::get('/setting/bank/jsondata', [App\Http\Controllers\BankController::class, 'jsondata'])->name('bank.jsondata');
    Route::delete('setting/bank/delete', [App\Http\Controllers\BankController::class, 'delete'])->name('bank.delete');

    //installment
    Route::get('/setting/installment/index', [App\Http\Controllers\InstallmentController::class, 'index'])->name('installment.index');
    Route::get('/setting/installment/add', [App\Http\Controllers\InstallmentController::class, 'add'])->name('installment.add');
    Route::post('/setting/installment/crate', [App\Http\Controllers\InstallmentController::class, 'crate'])->name('installment.crate');
    Route::get('/setting/installment/edit/{id}', [App\Http\Controllers\InstallmentController::class, 'edit'])->name('installment.edit');
    Route::put('/setting/installment/update/{id}', [App\Http\Controllers\InstallmentController::class, 'update'])->name('installment.update');
    Route::get('/setting/installment/status/{id}', [App\Http\Controllers\InstallmentController::class, 'status'])->name('installment.status');
    Route::get('/setting/installment/jsondata', [App\Http\Controllers\InstallmentController::class, 'jsondata'])->name('installment.jsondata');
    Route::delete('setting/installment/delete', [App\Http\Controllers\InstallmentController::class, 'delete'])->name('installment.delete');
    Route::put('/setting/installment/deleteImg', [App\Http\Controllers\InstallmentController::class, 'deleteImg'])->name('installment.deleteImg');

    //artlicle
    Route::get('/setting/artlicle/index', [App\Http\Controllers\ArtlicleController::class, 'index'])->name('artlicle.index');
    Route::get('/setting/artlicle/add', [App\Http\Controllers\ArtlicleController::class, 'add'])->name('artlicle.add');
    Route::post('/setting/artlicle/crate', [App\Http\Controllers\ArtlicleController::class, 'crate'])->name('artlicle.crate');
    Route::get('/setting/artlicle/edit/{id}', [App\Http\Controllers\ArtlicleController::class, 'edit'])->name('artlicle.edit');
    Route::put('/setting/artlicle/update/{id}', [App\Http\Controllers\ArtlicleController::class, 'update'])->name('artlicle.update');
    Route::get('/setting/artlicle/status/{id}', [App\Http\Controllers\ArtlicleController::class, 'status'])->name('artlicle.status');
    Route::get('/setting/artlicle/jsondata', [App\Http\Controllers\ArtlicleController::class, 'jsondata'])->name('artlicle.jsondata');
    Route::get('/setting/artlicle/getCat', [App\Http\Controllers\ArtlicleController::class, 'getCat'])->name('artlicle.getCat');
    Route::delete('setting/artlicle/delete', [App\Http\Controllers\ArtlicleController::class, 'delete'])->name('artlicle.delete');
    Route::put('/setting/artlicle/deleteImg', [App\Http\Controllers\ArtlicleController::class, 'deleteImg'])->name('artlicle.deleteImg');
    Route::get('/setting/artlicle/random', [App\Http\Controllers\ArtlicleController::class, 'random'])->name('artlicle.random');
    Route::get('/setting/artlicle/search', [App\Http\Controllers\ArtlicleController::class, 'search'])->name('artlicle.search');


    //faq
Route::get('/setting/faq/index', [App\Http\Controllers\FaqController::class, 'index'])->name('faq.index');
Route::get('/setting/faq/add', [App\Http\Controllers\FaqController::class, 'add'])->name('faq.add');
Route::post('/setting/faq/crate', [App\Http\Controllers\FaqController::class, 'crate'])->name('faq.crate');
Route::get('/setting/faq/edit/{id}', [App\Http\Controllers\FaqController::class, 'edit'])->name('faq.edit');
Route::put('/setting/faq/update/{id}', [App\Http\Controllers\FaqController::class, 'update'])->name('faq.update');
Route::get('/setting/faq/status/{id}', [App\Http\Controllers\FaqController::class, 'status'])->name('faq.status');
Route::get('/setting/faq/jsondata', [App\Http\Controllers\FaqController::class, 'jsondata'])->name('faq.jsondata');
Route::delete('setting/faq/delete', [App\Http\Controllers\FaqController::class, 'delete'])->name('faq.delete');
// เพิ่มบรรทัดนี้ต่อท้ายกลุ่ม route faq เดิม (อยู่ "นอก" กลุ่มที่ต้อง login เพราะลูกค้าต้องเปิดได้โดยไม่ต้อง login)
Route::get('/faq/{parmalink}', [App\Http\Controllers\FaqController::class, 'view'])->name('faq.view')->withoutMiddleware('auth');


Route::get('document', [App\Http\Controllers\DocumentController::class, 'index'])->name('document.index');
Route::get('document/jsondata', [App\Http\Controllers\DocumentController::class, 'jsondata'])->name('document.jsondata');
Route::get('document/add', [App\Http\Controllers\DocumentController::class, 'add'])->name('document.add');
Route::get('document/edit/{id}', [App\Http\Controllers\DocumentController::class, 'edit'])->name('document.edit');
Route::post('document/crate', [App\Http\Controllers\DocumentController::class, 'crate'])->name('document.crate');
Route::put('document/update/{id}', [App\Http\Controllers\DocumentController::class, 'update'])->name('document.update');
Route::get('document/status/{id}', [App\Http\Controllers\DocumentController::class, 'status'])->name('document.status');
Route::delete('document/delete', [App\Http\Controllers\DocumentController::class, 'delete'])->name('document.delete');

    //tutorial
    Route::get('/setting/tutorial/index', [App\Http\Controllers\TutorialController::class, 'index'])->name('tutorial.index');
    Route::get('/setting/tutorial/add', [App\Http\Controllers\TutorialController::class, 'add'])->name('tutorial.add');
    Route::post('/setting/tutorial/crate', [App\Http\Controllers\TutorialController::class, 'crate'])->name('tutorial.crate');
    Route::get('/setting/tutorial/edit/{id}', [App\Http\Controllers\TutorialController::class, 'edit'])->name('tutorial.edit');
    Route::put('/setting/tutorial/update/{id}', [App\Http\Controllers\TutorialController::class, 'update'])->name('tutorial.update');
    Route::get('/setting/tutorial/status/{id}', [App\Http\Controllers\TutorialController::class, 'status'])->name('tutorial.status');
    Route::get('/setting/tutorial/jsondata', [App\Http\Controllers\TutorialController::class, 'jsondata'])->name('tutorial.jsondata');
    Route::delete('setting/tutorial/delete', [App\Http\Controllers\TutorialController::class, 'delete'])->name('tutorial.delete');
    Route::put('/setting/tutorial/deleteImg', [App\Http\Controllers\TutorialController::class, 'deleteImg'])->name('tutorial.deleteImg');
    Route::get('/setting/tutorial/random', [App\Http\Controllers\TutorialController::class, 'random'])->name('tutorial.random');
    Route::get('/setting/tutorial/search', [App\Http\Controllers\TutorialController::class, 'search'])->name('tutorial.search');
    Route::post('/setting/tutorial/fetch-video-info', [App\Http\Controllers\TutorialController::class, 'fetchVideoInfo'])->name('tutorial.fetchVideoInfo');

    //page
    Route::get('/setting/page/setting', [App\Http\Controllers\PageControlle::class, 'setting'])->name('page.setting');
    Route::post('/setting/page/setting/crate', [App\Http\Controllers\PageControlle::class, 'settingCrate'])->name('page.setting.crate');
    Route::put('/setting/page/setting/update/{id}', [App\Http\Controllers\PageControlle::class, 'settingUpdate'])->name('page.setting.update');
    Route::get('/setting/page/index', [App\Http\Controllers\PageControlle::class, 'index'])->name('page.index');
    Route::get('/setting/page/preview/{parmalink}', [App\Http\Controllers\PageControlle::class, 'preview'])->name('page.preview');
    Route::get('/setting/page/add', [App\Http\Controllers\PageControlle::class, 'add'])->name('page.add');
    Route::post('/setting/page/crate', [App\Http\Controllers\PageControlle::class, 'crate'])->name('page.crate');
    Route::get('/setting/page/edit/{id}', [App\Http\Controllers\PageControlle::class, 'edit'])->name('page.edit');
    Route::put('/setting/page/update/{id}', [App\Http\Controllers\PageControlle::class, 'update'])->name('page.update');
    Route::get('/setting/page/status/{id}', [App\Http\Controllers\PageControlle::class, 'status'])->name('page.status');
    Route::get('/setting/page/jsondata', [App\Http\Controllers\PageControlle::class, 'jsondata'])->name('page.jsondata');
    Route::delete('setting/page/delete', [App\Http\Controllers\PageControlle::class, 'delete'])->name('page.delete');

    //quotation
    Route::get('/setting/quotation/setting', [App\Http\Controllers\QuotationControlle::class, 'setting'])->name('quotation.setting');
    Route::post('/setting/quotation/setting/crate', [App\Http\Controllers\QuotationControlle::class, 'settingCrate'])->name('quotation.setting.crate');
    Route::put('/setting/quotation/setting/update/{id}', [App\Http\Controllers\QuotationControlle::class, 'settingUpdate'])->name('quotation.setting.update');
    Route::get('/setting/quotation/index', [App\Http\Controllers\QuotationControlle::class, 'index'])->name('quotation.index');
    Route::get('/setting/quotation/preview/{id}', [App\Http\Controllers\QuotationControlle::class, 'preview'])->name('quotation.preview');
    Route::put('/setting/quotation/update/staff/{id}', [App\Http\Controllers\QuotationControlle::class, 'updateStaff'])->name('quotation.update.staff');
    Route::get('/setting/quotation/status/{id}', [App\Http\Controllers\QuotationControlle::class, 'status'])->name('quotation.status');
    Route::get('/setting/quotation/jsondata', [App\Http\Controllers\QuotationControlle::class, 'jsondata'])->name('quotation.jsondata');
    Route::get('/setting/quotation/report', [App\Http\Controllers\QuotationControlle::class, 'report'])->name('quotation.report');
    Route::get('/setting/quotation/jsonaverage', [App\Http\Controllers\QuotationControlle::class, 'jsonaverage'])->name('quotation.jsonaverage');
    Route::get('/setting/quotation/report/product', [App\Http\Controllers\QuotationControlle::class, 'reportProduct'])->name('quotation.report.product');
    Route::get('/setting/quotation/maxquotation', [App\Http\Controllers\QuotationControlle::class, 'quotationMaxQuotation'])->name('quotation.json.maxquotation');

    //get member
    Route::get('getmember/setting', [App\Http\Controllers\GetmemberController::class, 'setting'])->name('getmember.setting');
    Route::put('getmember/setting/update/{id}', [App\Http\Controllers\GetmemberController::class, 'updateSetting'])->name('getmember.setting.update');
    Route::post('getmember/crate', [App\Http\Controllers\GetmemberController::class, 'crate'])->name('getmember.crate');
    Route::put('getmember/deleteImg', [App\Http\Controllers\GetmemberController::class, 'deleteImg'])->name('getmember.deleteImg');
    Route::get('getmember/index', [App\Http\Controllers\GetmemberController::class, 'index'])->name('getmember.index');
    Route::get('getmember/edit/{id}', [App\Http\Controllers\GetmemberController::class, 'edit'])->name('getmember.edit');
    Route::put('getmember/update/status/{id}', [App\Http\Controllers\GetmemberController::class, 'updateStatus'])->name('getmember.update.status');
    Route::get('getmember/jsondata', [App\Http\Controllers\GetmemberController::class, 'jsondata'])->name('getmember.jsondata');
    Route::get('getmember/export', [App\Http\Controllers\GetmemberController::class, 'Export'])->name('getmember.export.excel');

    //user
    Route::get('/setting/user/index', [App\Http\Controllers\UserController::class, 'index'])->name('user.index');
    Route::get('/setting/user/add', [App\Http\Controllers\UserController::class, 'add'])->name('user.add');
    Route::post('/setting/user/crate', [App\Http\Controllers\UserController::class, 'crate'])->name('user.crate');
    Route::get('/setting/user/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('user.edit');
    Route::put('/setting/user/update/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('user.update');
    Route::put('/setting/user/update/staff/{id}', [App\Http\Controllers\UserController::class, 'updateStaff'])->name('user.staff.update');
    Route::get('/setting/user/status/{id}', [App\Http\Controllers\UserController::class, 'status'])->name('user.status');
    Route::get('/setting/user/jsondata', [App\Http\Controllers\UserController::class, 'jsondata'])->name('user.jsondata');
    Route::get('/setting/user/jsonpenname/{id}', [App\Http\Controllers\UserController::class, 'jsonpenname'])->name('user.json.penname');
    Route::delete('setting/user/delete', [App\Http\Controllers\UserController::class, 'delete'])->name('user.delete');
    Route::get('setting/user/profile/{id}', [App\Http\Controllers\UserController::class, 'profile'])->name('user.profile');
    Route::get('setting/user/level/{id}', [App\Http\Controllers\UserController::class, 'level'])->name('user.level');
    Route::put('/setting/user/levelupdate/{id}', [App\Http\Controllers\UserController::class, 'levelupdate'])->name('user.levelupdate');
    Route::get('setting/role-permission', [App\Http\Controllers\LevelMenuController::class, 'index'])->name('levelmenu.index');
    Route::get('setting/role-permission/{level}/edit', [App\Http\Controllers\LevelMenuController::class, 'edit'])->name('levelmenu.edit');
    Route::put('setting/role-permission/{level}/update', [App\Http\Controllers\LevelMenuController::class, 'update'])->name('levelmenu.update');
    Route::get('setting/user/changpassword/{id}', [App\Http\Controllers\UserController::class, 'changpassword'])->name('user.changpassword');
    Route::put('/setting/user/changpasswordUpdate/{id}', [App\Http\Controllers\UserController::class, 'changpasswordUpdate'])->name('user.changpasswordUpdate');
    Route::get('/setting/user/setting', [App\Http\Controllers\UserController::class, 'setting'])->name('user.setting');
    Route::post('/setting/user/setting/crate', [App\Http\Controllers\UserController::class, 'settingCrate'])->name('user.setting.crate');
    Route::put('/setting/user/setting/update/{id}', [App\Http\Controllers\UserController::class, 'settingUpdate'])->name('user.setting.update');

    //user business
    Route::get('/setting/business/index', [App\Http\Controllers\BusinessControlle::class, 'index'])->name('business.index');
    Route::get('/setting/business/add', [App\Http\Controllers\BusinessControlle::class, 'add'])->name('business.add');
    Route::post('/setting/business/crate', [App\Http\Controllers\BusinessControlle::class, 'crate'])->name('business.crate');
    Route::get('/setting/business/edit/{id}', [App\Http\Controllers\BusinessControlle::class, 'edit'])->name('business.edit');
    Route::put('/setting/business/update/{id}', [App\Http\Controllers\BusinessControlle::class, 'update'])->name('business.update');
    Route::get('/setting/business/status/{id}', [App\Http\Controllers\BusinessControlle::class, 'status'])->name('business.status');
    Route::get('/setting/business/jsondata', [App\Http\Controllers\BusinessControlle::class, 'jsondata'])->name('business.jsondata');
    Route::delete('setting/business/delete', [App\Http\Controllers\BusinessControlle::class, 'delete'])->name('business.delete');

    //user position
    Route::get('/setting/position/index', [App\Http\Controllers\PositionControlle::class, 'index'])->name('position.index');
    Route::get('/setting/position/add', [App\Http\Controllers\PositionControlle::class, 'add'])->name('position.add');
    Route::post('/setting/position/crate', [App\Http\Controllers\PositionControlle::class, 'crate'])->name('position.crate');
    Route::get('/setting/position/edit/{id}', [App\Http\Controllers\PositionControlle::class, 'edit'])->name('position.edit');
    Route::put('/setting/position/update/{id}', [App\Http\Controllers\PositionControlle::class, 'update'])->name('position.update');
    Route::get('/setting/position/status/{id}', [App\Http\Controllers\PositionControlle::class, 'status'])->name('position.status');
    Route::get('/setting/position/jsondata', [App\Http\Controllers\PositionControlle::class, 'jsondata'])->name('position.jsondata');
    Route::delete('setting/position/delete', [App\Http\Controllers\PositionControlle::class, 'delete'])->name('position.delete');

    //user dashboard
    Route::get('/setting/user/dashboard', [App\Http\Controllers\ReportuserController::class, 'index'])->name('user.dashboard');
    Route::get('/setting/user/average', [App\Http\Controllers\ReportuserController::class, 'average'])->name('user.average');
    Route::get('/setting/user/averageYear', [App\Http\Controllers\ReportuserController::class, 'averageYear'])->name('user.averageYear');
    Route::get('/setting/user/jsonaverage', [App\Http\Controllers\ReportuserController::class, 'jsonaverage'])->name('user.jsonaverage');
    Route::get('/setting/user/jsonprovince', [App\Http\Controllers\ReportuserController::class, 'jsonprovince'])->name('user.jsonprovince');
    Route::get('/setting/user/jsonbusiness', [App\Http\Controllers\ReportuserController::class, 'jsonbusiness'])->name('user.jsonbusiness');
    Route::get('/setting/user/jsonposition', [App\Http\Controllers\ReportuserController::class, 'jsonposition'])->name('user.jsonposition');

    //user address
    Route::get('/setting/user/address/{id}', [App\Http\Controllers\UseraddressController::class, 'address'])->name('user.address');
    Route::post('/setting/user/address/crate', [App\Http\Controllers\UseraddressController::class, 'addressCrate'])->name('user.address.crate');
    Route::put('/setting/user/address/update/{id}', [App\Http\Controllers\UseraddressController::class, 'addressUpdate'])->name('user.address.update');
    Route::get('/setting/user/receipt/{id}', [App\Http\Controllers\UseraddressController::class, 'receipt'])->name('user.receipt');
    Route::post('/setting/user/receipt/crate', [App\Http\Controllers\UseraddressController::class, 'receiptCrate'])->name('user.receipt.crate');
    Route::put('/setting/user/receipt/update/{id}', [App\Http\Controllers\UseraddressController::class, 'receiptUpdate'])->name('user.receipt.update');
    Route::get('/setting/user/api/json/province', [App\Http\Controllers\UseraddressController::class, 'json_province'])->name('user.api.json.province');
    Route::get('/setting/user/api/json/amphure', [App\Http\Controllers\UseraddressController::class, 'json_amphure'])->name('user.api.json.amphure');
    Route::get('/setting/user/api/json/district', [App\Http\Controllers\UseraddressController::class, 'json_district'])->name('user.api.json.district');
    Route::get('/setting/user/api/json/zipcode', [App\Http\Controllers\UseraddressController::class, 'json_zipcode'])->name('user.api.json.zipcode');


    //support
    Route::get('/ticket/index', [App\Http\Controllers\HelpController::class, 'index'])->name('ticket.index');
    Route::get('/ticket/add', [App\Http\Controllers\HelpController::class, 'add'])->name('ticket.add');
    Route::post('/ticket/crate', [App\Http\Controllers\HelpController::class, 'crate'])->name('ticket.crate');
    Route::get('/ticket/edit/{id}', [App\Http\Controllers\HelpController::class, 'edit'])->name('ticket.edit');
    Route::put('/ticket/update/{id}', [App\Http\Controllers\HelpController::class, 'update'])->name('ticket.update');
    Route::get('/ticket/status/{id}', [App\Http\Controllers\HelpController::class, 'status'])->name('ticket.status');
    Route::get('/ticket/jsondata', [App\Http\Controllers\HelpController::class, 'jsondata'])->name('ticket.jsondata');
    Route::delete('ticket/delete', [App\Http\Controllers\HelpController::class, 'delete'])->name('ticket.delete');
    Route::get('ticket/seandmail/{id}', [App\Http\Controllers\HelpController::class, 'seandmail'])->name('ticket.seandmail');
    Route::get('ticket/getnotify', [App\Http\Controllers\HelpController::class, 'getNotify'])->name('ticket.getnotify');
	Route::get('/ticket/getAllData', [App\Http\Controllers\HelpController::class, 'getAllData'])->name('ticket.getAllData');

    //support program
    Route::get('/ticket/program/index', [App\Http\Controllers\HelpprogramController::class, 'index'])->name('ticket.program.index');
    Route::get('/ticket/program/add', [App\Http\Controllers\HelpprogramController::class, 'add'])->name('ticket.program.add');
    Route::post('/ticket/program/crate', [App\Http\Controllers\HelpprogramController::class, 'crate'])->name('ticket.program.crate');
    Route::get('/ticket/program/edit/{id}', [App\Http\Controllers\HelpprogramController::class, 'edit'])->name('ticket.program.edit');
    Route::put('/ticket/program/update/{id}', [App\Http\Controllers\HelpprogramController::class, 'update'])->name('ticket.program.update');
    Route::get('/ticket/program/status/{id}', [App\Http\Controllers\HelpprogramController::class, 'status'])->name('ticket.program.status');
    Route::get('/ticket/program/jsondata', [App\Http\Controllers\HelpprogramController::class, 'jsondata'])->name('ticket.program.jsondata');
    Route::delete('ticket/program/delete', [App\Http\Controllers\HelpprogramController::class, 'delete'])->name('ticket.program.delete');

    //support dashboard
    Route::get('/ticket/dashboard', [App\Http\Controllers\HelpController::class, 'indexStaff'])->name('ticket.dashboard');
	Route::get('/ticket/json/datatable', [App\Http\Controllers\HelpController::class, 'jsonDatatableStaff'])->name('ticket.json.datatable');

	// หน้าแสดง elFinder (browser interface)
    Route::get('/elfinder', [App\Http\Controllers\ElfinderController::class, 'index']);

    // Connector ที่ elFinder เรียกใช้งาน (ทั้ง GET/POST)
	Route::any('/elfinder/connector', [App\Http\Controllers\ElfinderController::class, 'connector'])->name('elfinder.connector');

    // หน้าแสดงสำหรับ CKEditor integration
    Route::get('/elfinder/ckeditor', [App\Http\Controllers\ElfinderController::class, 'ckeditor']);

	// Review
    Route::get('/setting/review/index', [App\Http\Controllers\Shopping\OrderReviewController::class, 'index'])->name('order.review.index');
	Route::get('/setting/review/add', [App\Http\Controllers\Shopping\OrderReviewController::class, 'add'])->name('order.review.add');
    Route::post('/setting/review/crate', [App\Http\Controllers\Shopping\OrderReviewController::class, 'crate'])->name('order.review.crate');
    Route::get('/setting/review/edit/{id}', [App\Http\Controllers\Shopping\OrderReviewController::class, 'edit'])->name('order.review.edit');
    Route::put('/setting/review/update/{id}', [App\Http\Controllers\Shopping\OrderReviewController::class, 'update'])->name('order.review.update');
    Route::get('/setting/review/status/{id}', [App\Http\Controllers\Shopping\OrderReviewController::class, 'status'])->name('order.review.status');
    Route::get('/setting/review/jsondata', [App\Http\Controllers\Shopping\OrderReviewController::class, 'jsondata'])->name('order.review.jsondata');
    Route::delete('setting/review/delete', [App\Http\Controllers\Shopping\OrderReviewController::class, 'delete'])->name('order.review.delete');
	
	Route::post('/setting/review/update-status', [App\Http\Controllers\Shopping\OrderReviewController::class, 'updateStatus'])->name('order.review.updateStatus');	
	//chatbot
Route::get('/setting/chatbot/index', [App\Http\Controllers\ChatbotAdminController::class, 'index'])->name('chatbot.index');
Route::post('/setting/chatbot/crate', [App\Http\Controllers\ChatbotAdminController::class, 'crate'])->name('chatbot.crate');
Route::put('/setting/chatbot/update/{id}', [App\Http\Controllers\ChatbotAdminController::class, 'update'])->name('chatbot.update');
Route::get('/setting/chatbot/status/{id}', [App\Http\Controllers\ChatbotAdminController::class, 'status'])->name('chatbot.status');
Route::delete('setting/chatbot/delete', [App\Http\Controllers\ChatbotAdminController::class, 'delete'])->name('chatbot.delete');    
Route::post('/setting/chatbot/toggle-widget', [App\Http\Controllers\ChatbotAdminController::class, 'toggleWidget'])->name('chatbot.toggleWidget');
});

//trial request
Route::get('/trial', [App\Http\Controllers\TrialRequestController::class, 'index'])->name('fronend.trial.index');
Route::post('/trial/store', [App\Http\Controllers\TrialRequestController::class, 'store'])->name('fronend.trial.store');

// PromotionOnepage
Route::get('{pageItem}', [App\Http\Controllers\FontendController::class, 'listOnepage'])->name('onepages');

//Redirect
try {
    if (\Illuminate\Support\Facades\Schema::hasTable('tb_pages_redirect')) {
        $redirects = TbPagesRedirect::select('redirect_old', 'redirect_show')->where('redirect_show', 1)->get();
        foreach ($redirects as $redirect) {
            $data = strtolower(str_replace('https://' . ($_SERVER['SERVER_NAME'] ?? ''), "", $redirect->redirect_old));
            Route::get($data, [App\Http\Controllers\FontendController::class, 'pageRedirect']);
        }
    }
} catch (\Throwable $e) {
    // Skip if database is not reachable or tables are not created yet
}
Route::get('/promotion/bundle', function () {
    $breadcrumb = [
        ['route' => route('fronend.home'), 'name' => 'หน้าหลัก'],
        ['route' => '', 'name' => 'โปรโมชั่น Bundle'],
    ];
    return view('fontend.bundle.promo', compact('breadcrumb'));
})->name('fronend.bundle.promo');
 
Route::post('/cart/add-bundle', [App\Http\Controllers\Shopping\CartController::class, 'addBundleToCart'])
    ->name('fronend.cart.addBundle');
