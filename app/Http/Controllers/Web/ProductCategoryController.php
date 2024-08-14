<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\ProductCategory;
use Http\Discovery\Exception\NotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Codezero\LocalizedRoutes\Localized;

class ProductCategoryController extends FontEndController
{
    public function index(Request $request, ProductCategory $category, $slug)
    {
        $locale = app()->getLocale();
        $category = Cache::remember('product_category_' . $slug . '_' . $locale, $this->cacheTime, function () use ($slug) {
            return ProductCategory::where(["slug" => $slug, "status" => 1])->first();
        });

        if (!$category) return abort(404);

        $page = LengthAwarePaginator::resolveCurrentPage();

        // tạo cache
        $products = Cache::remember('products_for_category_' . $slug . '_page_' . $page . '_' . $locale, $this->cacheTime, function () use ($category) {

            // lấy danh sách sản phẩm
            $productsForCategory = $category->products()->where('status', 1)->get();

            // phân trang
            $paginatedData =  new LengthAwarePaginator(
                $productsForCategory->forPage(LengthAwarePaginator::resolveCurrentPage(), 5),
                $productsForCategory->count(),
                5,
                LengthAwarePaginator::resolveCurrentPage(),
                ['path' => route('web_list_product', $category->slug)]
            );
            $paginatedData->setPath(route('web_list_product', $category->slug));

            return $paginatedData;
        });

        $categories =  Cache::remember('product_categories_' . $locale, $this->cacheTime, function () use ($category) {
            return ProductCategory::where('status', 1)->get();
        });

        $this->header = [
            'canonical' => Route('web_list_product', $category->slug),
            'robots' => $category->robots ?? 'index,follow',
            'title' => $category->name,
            'description' => $category->meta_description ?? "Interesting and latest news about showbiz and celebrity movies " . $category->name,
            'keywords' => $category->meta_keywords ?? "Interesting, latest news,movies,showbiz," . $category->name,
            'og_image' => $category->image,
            'og_url' => Route('web_list_product', $category->slug),
        ];

        return $this->render(
            'web.product_category.index',
            compact(
                'category',
                'categories',
                'products',
                // 'featuredArticle'
            )
        );
    }


    /**
     * @Description : 
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */

    public function getProducts(Request $request)
    {
        $data = $request->all();
        $locale = $data['locale'];
        app()->setLocale($locale);

        $minPrice = $data['filter']['minPrice'];
        $maxPrice = $data['filter']['maxPrice'];

        $category = ProductCategory::where('slug', $data['slug'])->first();

        if (!$category) {
            return response()->json(['status' => 'error', 'message' => 'Category not found'], 404);
        }

        $products = $category->products()
            ->where('status', 1)
            ->where(function ($query) use ($locale, $minPrice, $maxPrice) {
                $query->where('price->' . $locale, '>=', (int) $minPrice)
                    ->where('price->' . $locale, '<=', (int) $maxPrice);
            })
            ->get();
        $response = [];
        foreach ($products as $product) {
            $response[] = [
                'id' => $product->id,
                'name' => $product->getTranslation('name', $locale),
                'image' => asset($product->image),
                'url' => route('web_product_detail', $product->slug, true, $locale),
                'price' => $product->price,
                'meta_description' => $product->meta_description,
            ];
        }

        return response()->json($response);
    }
}
