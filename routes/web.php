<?php

use App\Http\Controllers\Admin\InformationController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Web\ErrorController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BackEndController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\FileManagerController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PostCategoriesController;
use App\Http\Controllers\Admin\ProductCategoriesController;
use App\Http\Controllers\Admin\ProductController;

use App\Http\Controllers\Admin\UserController;

use function Clue\StreamFilter\fun;

//////////////////////////// ADMIN ////////////////////////////
// CKFinder
Route::any('/ckfinder/connector', '\CKSource\CKFinderBridge\Controller\CKFinderController@requestAction')
    ->name('ckfinder_connector');

Route::any('/ckfinder/browser', '\CKSource\CKFinderBridge\Controller\CKFinderController@browserAction')
    ->name('ckfinder_browser');

Route::prefix('admin')->group(function () {

    // auth
    Route::controller(AuthController::class)->group(function () {
        //login
        Route::get('/login', 'login')->name('admin_login');
        Route::post('/login', 'action_login')->name('admin_action_login');
        //logout
        Route::get('/logout', 'logout')->name('admin_logout');
        //forget pass
        Route::get('/forget', 'forget')->name('admin_forget');
        Route::post('/forget', 'action_forget')->name('admin_action_forget');
    });

    // admin
    Route::group(['middleware' => 'auth'], function () {
        // create sitemap
        Route::get('/sitemap', 'SitemapController@index')->name('admin_sitemap');
        // clear cache
        Route::get('/clear-cache', function () {
            Artisan::call('cache:clear');
            return "<script>
        window.close();
      </script>";
        })->name('admin_clear_cache');

        // post controller
        Route::prefix('post_category')->group(function () {
            Route::controller(PostCategoriesController::class)->group(function () {
                Route::get('/', 'index')->name('admin_post_category_index');
                Route::get('/add', 'add')->name('admin_post_category_add');
                Route::post('/add', 'store')->name('admin_post_category_store');
                Route::get('/edit/{id}', 'edit')->name('admin_post_category_edit');
                Route::post('/edit/{id}', 'update')->name('admin_post_category_update');
            });
        });
        // post
        Route::prefix('post')->group(function () {
            Route::controller(PostController::class)->group(function () {
                Route::get('/', 'index')->name('admin_post_index');
                Route::get('/add', 'add')->name('admin_post_add');
                Route::post('/add', 'store')->name('admin_post_store');
                Route::get('/edit/{id}', 'edit')->name('admin_post_edit');
                Route::post('/edit/{id}', 'update')->name('admin_post_update');
            });
        });

        // information
        Route::prefix('information')->group(function () {
            Route::controller(InformationController::class)->group(function () {
                Route::get('/', 'index')->name('admin_information_index');
                Route::get('/add', 'add')->name('admin_information_add');
                Route::post('/add', 'store')->name('admin_information_store');
                Route::get('/edit/{id}', 'edit')->name('admin_information_edit');
                Route::post('/edit/{id}', 'update')->name('admin_information_update');
            });
        });

        //config
        Route::prefix('config')->group(function () {
            Route::controller(ConfigController::class)->group(function () {
                Route::prefix("home")->group(function () {
                    Route::get('/', 'home')->name('admin_config_home');
                    Route::post('/', 'home_update')->name('admin_config_home_update');
                });
                Route::prefix("home")->group(function () {
                    Route::get('/', 'home')->name('admin_config_home');
                    Route::post('/', 'home_update')->name('admin_config_home_update');
                });
                Route::prefix("payment")->group(function () {
                    Route::get('/', 'payment')->name('admin_config_payment');
                    Route::post('/', 'payment_update')->name('admin_config_payment_update');
                });
                Route::prefix("headerAndFooter")->group(function () {
                    Route::get('/', 'headerAndFooter')->name('admin_config_headerAndFooter');
                    Route::post('/', 'headerAndFooter_update')->name('admin_config_headerAndFooter_update');
                });
            });
        });

        Route::prefix("user")->group(function () {
            Route::controller(UserController::class)->group(function () {
                Route::get('/change_profile', 'change_profile')->name('change_profile');
                Route::post('/change_profile', 'action_change_password')->name('admin_change_password');
            });
        });

        Route::prefix("file")->group(function () {
            Route::controller(FileManagerController::class)->group(function () {
                Route::get('/', 'index')->name('admin_manage_files');
            });
        });

        Route::prefix("language-line")->group(function () {
            Route::controller(LanguageController::class)->group(function () {
                Route::get('/', 'language_line')->name('admin_language_line');
                Route::get('/add', 'language_line_add')->name('admin_language_line_add');
                Route::post('/add', 'post_language_line_add')->name('admin_language_line_add_post');
                Route::get('/update/{id}', 'language_line_update')->name('admin_language_line_update');
                Route::post('/update/{id}', 'post_language_line_update')->name('admin_language_line_update_post');
            });
        });

        Route::prefix("language")->group(function () {
            Route::controller(LanguageController::class)->group(function () {
                Route::get('/', 'language')->name('admin_language');
                Route::get('/add', 'language_add')->name('admin_language_add');
                Route::post('/add', 'post_language_add')->name('admin_language_add_post');
                Route::get('/update/{id}', 'language_update')->name('admin_language_update');
                Route::post('/update/{id}', 'post_language_update')->name('admin_language_update_post');
            });
        });

        Route::prefix('product_category')->group(function () {
            Route::controller(ProductCategoriesController::class)->group(function () {
                Route::get('/', 'index')->name('admin_product_category_index');
                Route::get('/add', 'add')->name('admin_product_category_add');
                Route::post('/add', 'store')->name('admin_product_category_store');
                Route::get('/edit/{id}', 'edit')->name('admin_product_category_edit');
                Route::post('/edit/{id}', 'update')->name('admin_product_category_update');
            });
        });

        //product
        Route::prefix('product')->group(function () {
            Route::controller(ProductController::class)->group(function () {
                Route::get('/', 'index')->name('admin_product_index');
                Route::get('/add', 'add')->name('admin_product_add');
                Route::post('/add', 'store')->name('admin_product_store');
                Route::get('/edit/{id}', 'edit')->name('admin_product_edit');
                Route::post('/edit/{id}', 'update')->name('admin_product_update');
            });
        });
        //order
        Route::prefix('order')->group(function () {
            Route::controller(OrderController::class)->group(function () {
                Route::get('/', 'index')->name('admin_order_index');
                Route::get('/detail/{id}', 'detail')->name('admin_order_detail');
                Route::post('/update_order_status/{id}', 'update_status_order')->name('admin_update_order_detail');
            });
        });
    });
});



//////////////////////////// WEB ////////////////////////////
Route::post('/webhook', 'App\Http\Controllers\Web\Payment\CassoController@handle')->name('switch_webhook');

// giỏ hàng
Route::post('/add_to_cart', 'App\Http\Controllers\Web\CartController@addToCart')->name('add_to_card');
Route::post('/get_cart', 'App\Http\Controllers\Web\CartController@getCartData')->name('get_cart');
Route::post('/update_cart', 'App\Http\Controllers\Web\CartController@updateCart')->name('update_cart');


Route::post('/getProducts', 'App\Http\Controllers\Web\ProductCategoryController@getProducts')->name('web.products');


Route::localized(function () {

    // chuyển khoản ngân hàng
    Route::get('/checkout_bank', 'App\Http\Controllers\Web\Payment\CassoController@bank')->name('payment.web.bank');

    Route::get('paypal/success', 'App\Http\Controllers\Web\Payment\PaypalController@success')->name('payment.web.success');
    Route::get('paypal/cancel', 'App\Http\Controllers\Web\Payment\PaypalController@cancel')->name('payment.web.cancel');
    //giỏ hàng
    Route::get('/cart', 'App\Http\Controllers\Web\CartController@cart')->name('web_cart');
    // thanh toán
    Route::get('/checkout', 'App\Http\Controllers\Web\OrderController@checkout')->name('payment.web.checkout');
    Route::post('/checkout', 'App\Http\Controllers\Web\OrderController@handle_checkout')->name('web_handle_checkout');
    // cảm ơn
    Route::get('/thanks', 'App\Http\Controllers\Web\OrderController@thanks')->name('payment.web.thanks');
    // cảm ơn
    Route::get('/information/{slug}', 'App\Http\Controllers\Web\InformationController@index')->name('web.information');
    // Sản phẩm
    Route::get('/', 'App\Http\Controllers\Web\PageController@index')->name('web_home');
    Route::get('/products/{slug}', 'App\Http\Controllers\Web\ProductCategoryController@index')->name('web_list_product');
    Route::get('/product/{slug}.html', 'App\Http\Controllers\Web\ProductController@index')->name('web_product_detail');

    // post_category
    Route::get('/{slug}', 'App\Http\Controllers\Web\PostCategoryController@index')
        ->where('slug', '[a-zA-Z0-9-]+')
        ->name('web_list_post');
    Route::get('/{slug}.html', 'App\Http\Controllers\Web\PostController@index')
        ->where('slug', '[a-zA-Z0-9-]+')
        ->name('web_post_detail');
});
