<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use App\Models\ProductCategory;

use Illuminate\Support\Facades\DB;

class ProductCategoriesController extends BackEndController
{
    public function index()
    {
        $languages = Language::whereLocale('name', 'vi')->where('active', 1)->orderBy('default', 'DESC')->get();

        $this->config = [
            'js' => [
                'admin/library/changeStatus.js',
            ]
        ];

        $categories = ProductCategory::all();

        return $this->render('admin.product_category.index', compact('categories', 'languages'));
    }


    /**
     * @Description : Thêm mới 1 danh mục
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */

    public function add()
    {

        // config
        $this->config = [
            'js' => [
                'admin/library/finder.js',
                'ckeditor/ckeditor.js'
            ]
        ];
        // lấy danh sách ngôn ngữ
        $languages = Language::whereLocale('name', 'vi')->where('active', 1)->orderBy('default', 'DESC')->get();

        $categories = ProductCategory::where('status', 1)->get();
        // dd($languages);
        return $this->render(
            'admin.product_category.add',
            compact(
                'languages',
                'categories'
            ),
        );
    }


    /**
     * @Description : Lưu danh mục
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */

    public function store(Request $request)
    {

        $data = $request->all();
        if (isset($data['status']) == "on") $data['status'] = 1;
        else $data['status'] = 0;


        $productCategory = new ProductCategory();
        foreach ($data['name'] as $key => $value) {
            $productCategory->setTranslation('name', $key, $value);
        }
        foreach ($data['meta_title'] as $key => $value) {
            $productCategory->setTranslation('meta_title', $key, $value);
        }
        foreach ($data['meta_keyword'] as $key => $value) {
            $productCategory->setTranslation('meta_keyword', $key, $value);
        }
        foreach ($data['meta_description'] as $key => $value) {
            $productCategory->setTranslation('meta_description', $key, $value);
        }
        foreach ($data['description'] as $key => $value) {
            $productCategory->setTranslation('description', $key, $value);
        }

        $productCategory->status = $data['status'];
        $productCategory->image = $data['image'];
        $productCategory->slug = $data['slug'];
        $productCategory->meta_robots = $data['meta_robots'];
        $productCategory->rel = $data['rel'];
        $productCategory->target = $data['target'];

        if ($productCategory->save()) {
            if (isset($data['saveAndBack'])) {
                return redirect()->route('admin_product_category_index');
            }
            if (isset($data['saveAndNew'])) {
                return redirect()->route('admin_product_category_add');
            }
            if (isset($data['save'])) {
                return redirect()->route('admin_product_category_edit', $productCategory->id);
            }
        } else {
            return false;
        }
    }

    /** Sửa danh mục
     * @Description : 
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */

    public function edit($id)
    {
        $this->config = [
            'js' => [
                'admin/library/finder.js',
                'ckeditor/ckeditor.js'
            ]
        ];

        $languages = Language::whereLocale('name', 'vi')->where('active', 1)->orderBy('default', 'DESC')->get();

        $category = ProductCategory::find($id);
        return $this->render(
            'admin.product_category.edit',
            compact(
                'category',
                'languages'
            ),
        );
    }


    /**
     * @Description : Cập nhật sửa danh mục
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */


    public function update(Request $request, $id)
    {
        $data = $request->all();
        if (isset($data['status']) && $data['status'] == 1) {
            $data['status'] = 1;
        } else {
            $data['status'] = 0;
        }

        $productCategory = new ProductCategory();
        foreach ($data['name'] as $key => $value) {
            $productCategory->setTranslation('name', $key, $value);
        }
        foreach ($data['meta_title'] as $key => $value) {
            $productCategory->setTranslation('meta_title', $key, $value);
        }
        foreach ($data['meta_keyword'] as $key => $value) {
            $productCategory->setTranslation('meta_keyword', $key, $value);
        }
        foreach ($data['meta_description'] as $key => $value) {
            $productCategory->setTranslation('meta_description', $key, $value);
        }
        foreach ($data['description'] as $key => $value) {
            $productCategory->setTranslation('description', $key, $value);
        }

        $productCategory->status = $data['status'];
        $productCategory->image = $data['image'];
        $productCategory->slug = $data['slug'];
        $productCategory->meta_robots = $data['meta_robots'];
        $productCategory->rel = $data['rel'];
        $productCategory->target = $data['target'];

        // Lấy bản ghi dựa trên ID
        $postCategory = ProductCategory::find($id);

        // Kiểm tra xem có tìm thấy bản ghi không
        if ($postCategory) {
            // Cập nhật thông tin từ dữ liệu đầu vào
            $postCategory->update($data);

            if (isset($data['saveAndBack'])) {
                return redirect()->route('admin_product_category_index');
            }
            if (isset($data['saveAndNew'])) {
                return redirect()->route('admin_product_category_add');
            }
            if (isset($data['save'])) {
                return redirect()->route('admin_product_category_edit', $id);
            }
        } else {
            return false; // Hoặc xử lý trường hợp không tìm thấy bản ghi
        }
    }
}
