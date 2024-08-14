<?php

namespace App\Http\Controllers\Web;

use App\Models\Config;
use App\Models\Post;
use App\Models\Language;
use App\Models\PostCategory;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Spatie\TranslationLoader\LanguageLine;
use App\Http\Controllers\Web\FontEndController;
use Illuminate\Support\Facades\Cookie;

class PageController extends FontEndController
{

    public function test()
    {
        $formatEmailSendUser = LanguageLine::where('group', 'payment')->where('key', 'content_email_user')->first();
        $formatUser = $formatEmailSendUser->text['vi'];
        dd($formatUser);
        $locale = app()->getLocale();

        $data = [
            'id' => 1,
            'name' => 'Hoang',
            'email' => 'hoangdjno1@gmail.com',
            'phone' => '0123456789',
            'address' => 'Hà Nội',
            'total' => 1000000,
            'unit' => 'VND',
            'date' => date('Y-m-d H:i:s'),
            'payment' => 'PayPal',
            'status' => 'Đã thanh toán',
            'products' => [
                [
                    'name' => 'Sản phẩm 1',
                    'quantity' => 1,
                    'price' => 1000000
                ],
                [
                    'name' => 'Sản phẩm 2',
                    'quantity' => 2,
                    'price' => 2000000
                ],
            ]
        ];


    }
    /**
     * @Description : Trang HomePage
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */

    public function index(Request $request)
    {
        $lang = app()->getLocale();
        $languages = Language::where('active', '=', 1)->get();


        $featuredArticle = Cache::remember('featured_article_home_' . $lang, $this->cacheTime, function () use ($lang) {
            return Post::where('status', 1)
                ->take(4)
                ->orderBy('view', 'DESC')
                ->get();
        });

        $getSlides = Cache::remember('slides_home_' . $lang, $this->cacheTime, function () use ($lang) {
            $query = Config::where('name', 'slides')
                ->first()->value;

            $data = [];
            foreach (json_decode($query) as $key => $slide) {
                $data[$key] = $slide;
            }
            return $data;
        });

        $getImages = Cache::remember('images_home_' . $lang, $this->cacheTime, function () use ($lang) {
            $query = Config::where('name', 'images')
                ->first()->value;

            $data = [];
            foreach (json_decode($query) as $key => $image) {
                $data[$key] = $image;
            }
            return $data;
        });


        $getPostCategories = Cache::remember('post_categories_home_' . $lang, $this->cacheTime, function () use ($lang) {
            return PostCategory::where('status', 1)
                ->get();
        });


        $this->header = [
            'canonical' => route('web_home'),
            'robots' => 'index,follow',
            'title' => 'Home',
            'description' => 'Home',
            'keywords' => 'Home',
            'og_image' => '',
            'og_url' => route('web_home'),
        ];

        return $this->render('web.page.index', compact(
            'lang',
            'languages',
            'featuredArticle',
            'getSlides',
            'getImages',
            'getPostCategories',
        ));
    }
}
