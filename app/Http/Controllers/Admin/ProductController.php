<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BackEndController;
use App\Models\Language;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ProductController extends BackEndController
{
    public function index()
    {
        $languages = Language::whereLocale('name', 'vi')->where('active', 1)->orderBy('default', 'DESC')->get();

        $this->config = [
            'js' => [
                'admin/library/changeStatus.js',
            ]
        ];

        $products = Product::all();



        return $this->render(
            'admin.product.index',
            compact(
                'products',
                'languages',
            ),
        );
    }


    /**
     * @Description : Thêm mới 1 bài viết
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */

    public function add()
    {

        $this->config = [
            'js' => [
                'admin/library/finder.js',
                'ckeditor/ckeditor.js'
            ]
        ];

        // lấy danh sách ngôn ngữ

        $languages = Language::whereLocale('name', 'vi')->where('active', 1)->orderBy('default', 'DESC')->get();


        $categories = ProductCategory::where('status', 1)->get();

        return $this->render(
            'admin.product.add',
            compact(
                'categories',
                'languages',
            ),
        );
    }

    public function store(Request $request)
    {

        $data = $request->all();
        if (isset($data['status']) == "on") $data['status'] = 1;
        else $data['status'] = 0;
        $product = new Product();

        foreach ($data['name'] as $key => $value) {
            $product->setTranslation('name', $key, $value);
        }
        foreach ($data['price'] as $key => $value) {
            $product->setTranslation('price', $key, $value);
        }
        foreach ($data['made'] as $key => $value) {
            $product->setTranslation('made', $key, $value);
        }
        foreach ($data['meta_title'] as $key => $value) {
            $product->setTranslation('meta_title', $key, $value);
        }
        foreach ($data['meta_keyword'] as $key => $value) {
            $product->setTranslation('meta_keyword', $key, $value);
        }
        foreach ($data['meta_description'] as $key => $value) {
            $product->setTranslation('meta_description', $key, $value);
        }
        foreach ($data['summary'] as $key => $value) {
            $product->setTranslation('summary', $key, $value);
        }
        foreach ($data['description'] as $key => $value) {
            $product->setTranslation('description', $key, $value);
        }

        foreach ($data['unit'] as $key => $value) {
            $product->setTranslation('unit', $key, $value);
        }

        $product->image = $data['image'];
        $product->multiple_image = $data['multiple_image'];
        $product->link_affiliate = $data['link_affiliate'];
        $product->model = $data['model'];
        $product->product_category_id = $data['product_category_id'];
        $product->code = $data['code'];
        $product->slug = $data['slug'];
        $product->status = $data['status'];
        $product->meta_robots = $data['meta_robots'];
        $product->rel = $data['rel'];
        $product->target = $data['target'];
        if ($product->save()) {
            // thêm vào danh mục 
            if (isset($data['saveAndBack'])) {
                return redirect()->route('admin_product_index');
            }
            if (isset($data['saveAndNew'])) {
                return redirect()->route('admin_product_add');
            }
            if (isset($data['save'])) {
                return redirect()->route('admin_product_edit', $product->id);
            }
        } else {
            return false;
        }
    }

    public function edit($id)
    {
        $this->config = [
            'js' => [
                'admin/library/finder.js',
                'ckeditor/ckeditor.js'
            ]
        ];

        // lấy danh sách ngôn ngữ

        $languages = Language::whereLocale('name', 'vi')->where('active', 1)->orderBy('default', 'DESC')->get();

        $categories = ProductCategory::all();


        $product = Product::find($id);
        return $this->render(
            'admin.product.edit',
            compact(
                'categories',
                'product',
                'languages',
            ),
        );
    }


    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['status'] = isset($data['status']) && $data['status'] == 1 ? 1 : 0;

        $product = Product::find($id);

        if ($product) {
            $fields = ['name', 'price', 'made', 'meta_title', 'meta_keyword', 'meta_description', 'summary', 'description', 'unit'];
            foreach ($fields as $field) {
                if (isset($data[$field])) {
                    foreach ($data[$field] as $key => $value) {
                        $product->setTranslation($field, $key, $value);
                    }
                }
            }

            $product->image = $data['image'] ?? $product->image;
            $product->multiple_image = $data['multiple_image'] ?? $product->multiple_image;
            $product->link_affiliate = $data['link_affiliate'] ?? $product->link_affiliate;
            $product->model = $data['model'] ?? $product->model;
            $product->product_category_id = $data['product_category_id'] ?? $product->product_category_id;
            $product->code = $data['code'] ?? $product->code;
            $product->slug = $data['slug'] ?? $product->slug;
            $product->status = $data['status'];
            $product->meta_robots = $data['meta_robots'] ?? $product->meta_robots;
            $product->rel = $data['rel'] ?? $product->rel;
            $product->target = $data['target'] ?? $product->target;

            $product->save();

            Cache::forget('product_' . $product->slug);

            if (isset($data['saveAndBack'])) {
                return redirect()->route('admin_product_index');
            }
            if (isset($data['saveAndNew'])) {
                return redirect()->route('admin_product_add');
            }
            if (isset($data['save'])) {
                return redirect()->route('admin_product_edit', $id);
            }
        } else {
            Log::error("Không tìm thấy bản ghi với ID: $id");
            return false;
        }
    }
}
