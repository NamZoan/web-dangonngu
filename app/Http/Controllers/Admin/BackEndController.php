<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DOMDocument;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BackEndController extends Controller
{

    protected $user;

    /**
     * @Description : config contructor
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $defaultLang = 'vi';
        app()->setLocale($defaultLang);

        $this->layout = 'admin.layouts.index';
    }

    /**
     * @Description : Tạo mục lục 
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */

    function generateTableOfContents($htmlContent)
    {
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML(mb_convert_encoding($htmlContent, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();

        $headings = $dom->getElementsByTagName('h2');
        $indexList = '<ul>';
        foreach ($headings as $heading) {
            $text = $heading->nodeValue;
            $slug = Str::slug($text);
            $indexList .= '<li><a href="#' . $slug . '">' . $text . '</a></li>';
            $heading->setAttribute('id', $slug);
        }
        $indexList .= '</ul>';
        return $indexList;
    }

    /**
     * @Description : Viết lại description
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */

    function adjustTableOfContents($description)
    {
        $description = preg_replace_callback(
            '/<h2[^>]*>(.*?)<\/h2>/s',
            function ($matches) {
                $textContent = strip_tags($matches[1]);
                $decodedText = html_entity_decode($textContent, ENT_QUOTES, 'UTF-8');
                $slug = Str::slug($decodedText);
                return '<h2 id="' . $slug . '">' . $matches[1] . '</h2>';
            },
            $description
        );
        return $description;
    }
}
