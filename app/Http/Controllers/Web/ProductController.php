<?php

namespace App\Http\Controllers\Web;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends FontEndController
{
    public function index($slug, $any = null)
    {
        $product = Cache::remember('product_' . $slug, $this->cacheTime, function () use ($slug) {
            return Product::where(['slug' => $slug, 'status' => 1])->first();
        });

        if (empty($product)) return abort(404);

        $category = $product->category()->select(['id', 'name', 'slug'])->first();
        $relatedProducts = Product::whereHas('category', function ($query) use ($category) {
            $query->whereIn('id', $category->pluck('id'));
        })
        ->where('products.id', '!=', $product->id)
        ->get();

        // $this->header = [
        //     'canonical' => Route('web_product_detail', $product->slug).'/',
        //     'robots' => $product->robots ?? 'index,follow',
        //     'title' => $product->meta_title,
        //     'description' => $product->meta_description ?? "Interesting and latest news about showbit and celebrity movy" . $product->name,
        //     'keywords' => $product->meta_keywords ?? "Interesting, latest news,movy,showbiz," . $product->name,
        //     'og_image' => $product->image,
        //     'og_url' => Route('web_product_detail', $product->slug),
        // ];

        return $this->render('web.product.index', compact(
            'product',
            'relatedProducts',
            'category'
        ));
    }
}
