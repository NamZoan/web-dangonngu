<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = app('sitemap');

        // Add URLs to your sitemap, for example:
        $sitemap->add(URL::to('/'), now(), '1.0', 'daily');
        $sitemap->add(URL::to('/about'), now(), '0.9', 'weekly');
        $sitemap->add(URL::to('/contact'), now(), '0.8', 'monthly');

        // You can add more URLs here...

        return $sitemap->render('xml');
    }
}
