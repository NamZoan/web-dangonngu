<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\PostCategory;
use App\Models\Post;
use Spatie\Sitemap\SitemapIndex;
use Illuminate\Support\Facades\Route;


class CreateSitemap extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-sitemap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // tạo sitemap tổng
        $index = SitemapIndex::create();
        // Tạo sitemap cho trang chủ và danh mục
        $sitemap = Sitemap::create()
            ->add(Url::create(route('web_home') . '/')); // Thêm trang chủ

        // Thêm các danh mục từ bảng post_categories
        PostCategory::all()->each(function ($category) use ($sitemap) {
            $sitemap->add(Url::create(route('web_list_post', ['slug' => $category->slug]) . '/'));
        });

        // Lưu sitemap vào thư mục public
        $sitemap->writeToFile(public_path('sitemaps/sitemap.xml'));

        $index->add('/sitemaps/sitemap.xml');
        // Tạo sitemap cho các bài viết theo tháng và năm
        foreach (range(1, 12) as $month) {
            $posts = Post::whereMonth('created_at', $month)->get();

            // Nếu không có bài viết trong tháng này, bỏ qua
            if ($posts->isEmpty()) {
                continue;
            }

            $sitemap = Sitemap::create();

            // Thêm tất cả bài viết trong tháng cụ thể
            $posts->each(function ($post) use ($sitemap) {
                $sitemap->add(url(route('web_post_detail', ['slug' => $post->slug], false)).'/');
            });

            // Lưu sitemap cho tháng này
            $year = date('Y');
            $sitemap->writeToFile(public_path('sitemaps/sitemap-' . $month . '-' . $year . '.xml'));
            // thêm sitemap tổng
            $index->add('/sitemaps/sitemap-' . $month . '-' . $year . '.xml');
        }

        $index->writeToFile(public_path('sitemap_index.xml'));
    }
}
