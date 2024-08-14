<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\ProductCategory;
use Http\Discovery\Exception\NotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;

class PostCategoryController extends FontEndController
{
    public function index(PostCategory $category, $slug)
    {

        $category = Cache::remember('post_category_' . $slug, $this->cacheTime, function () use ($slug) {
            return PostCategory::where(["slug" => $slug, "status" => 1])->first();
        });

        if (!$category) return abort(404);


        $page = LengthAwarePaginator::resolveCurrentPage();

        // lấy bài viết nổi bật
        $featuredArticle = Cache::remember('featured_article_' . $slug, $this->cacheTime, function () use ($category) {
            return Post::where('status', 1)
                ->take(5)
                ->orderBy('view', 'DESC')
                ->get();
        });

        // tạo cache
        $posts = Cache::remember('posts_for_category_' . $slug . '_page_' . $page, $this->cacheTime, function () use ($category) {

            // lấy danh sách bài viết
            $postsForCategory = $category->posts()->where('status', 1)->get();

            // phân trang
            $paginatedData =  new LengthAwarePaginator(
                $postsForCategory->forPage(LengthAwarePaginator::resolveCurrentPage(), 5),
                $postsForCategory->count(),
                5,
                LengthAwarePaginator::resolveCurrentPage(),
                ['path' => Route('web_list_post', $category->slug)]
            );
            $paginatedData->setPath(Route('web_list_post', $category->slug));

            return $paginatedData;
        });


        // lấy tất cả các danh mục bài viết

        $categories =  Cache::remember('categories', $this->cacheTime, function () use ($category) {
            return PostCategory::where('status', 1)->get();
        });

        // $this->header = [
        //     'canonical' => Route('web_list_post', $category->slug) . '/',
        //     'robots' => $category->robots ?? 'index,follow',
        //     'title' => $category->name,
        //     'description' => $category->meta_description ?? "Interesting and latest news about showbiz and celebrity movies " . $category->name,
        //     'keywords' => $category->meta_keywords ?? "Interesting, latest news,movies,showbiz," . $category->name,
        //     'og_image' => $category->image,
        //     'og_url' => Route('web_list_post', $category->slug),
        // ];

        return $this->render('web.post_category.index', compact(
            'category',
            'posts',
            'featuredArticle',
            'categories'
        ));
    }
}
