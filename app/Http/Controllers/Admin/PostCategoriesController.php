<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use App\Models\PostCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;

class PostCategoriesController extends BackEndController
{
    /** Danh mục bài viết
     * @Description : 
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */

    public function index()
    {

        $this->config = [
            'js' => [
                'admin/library/changeStatus.js',
            ]
        ];

        $languages = Language::whereLocale('name', 'vi')->where('active', 1)->orderBy('default', 'DESC')->get();

        $categories = PostCategory::all();

        return $this->render(
            'admin.post_category.index',
            compact(
                'categories',
                'languages'
            ),
        );
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
        // danh mục
        $categories = DB::table('post_categories')
            ->select('id', 'name')
            ->get();

        // lấy danh sách ngôn ngữ

        $languages = Language::whereLocale('name', 'vi')->where('active', 1)->orderBy('default', 'DESC')->get();
        return $this->render(
            'admin.post_category.add',
            compact('categories', 'languages'),
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

        if (isset($data['view_home']) == "on") $data['view_home'] = 1;
        else $data['view_home'] = 0;

        $postCategory = new PostCategory();
        $postCategory->image = $data['image'];
        $postCategory->slug = $data['slug'];
        $postCategory->status = $data['status'];
        $postCategory->view_home = $data['view_home'];
        $postCategory->meta_robots = $data['meta_robots'];
        $postCategory->rel = $data['rel'];
        $postCategory->target = $data['target'];
        foreach ($data['name'] as $key => $value) {
            $postCategory->setTranslation('name', $key, $value);
        }
        foreach ($data['meta_title'] as $key => $value) {
            $postCategory->setTranslation('meta_title', $key, $value);
        }
        foreach ($data['meta_keyword'] as $key => $value) {
            $postCategory->setTranslation('meta_keyword', $key, $value);
        }
        foreach ($data['meta_description'] as $key => $value) {
            $postCategory->setTranslation('meta_description', $key, $value);
        }
        foreach ($data['description'] as $key => $value) {
            $postCategory->setTranslation('description', $key, $value);
        }

        if ($postCategory->save()) {
            if (isset($data['saveAndBack'])) {
                return redirect()->route('admin_post_category_index');
            }
            if (isset($data['saveAndNew'])) {
                return redirect()->route('admin_post_category_add');
            }
            if (isset($data['save'])) {
                return redirect()->route('admin_post_category_edit', $postCategory->id);
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
        $category = PostCategory::find($id);

        $languages = Language::whereLocale('name', 'vi')->where('active', 1)->orderBy('default', 'DESC')->get();


        return $this->render(
            'admin.post_category.edit',
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

        $data['status'] = isset($data['status']) && $data['status'] == 1 ? 1 : 0;
        $data['view_home'] = isset($data['view_home']) && $data['view_home'] == 1 ? 1 : 0;

        $postCategory = PostCategory::find($id);

        if ($postCategory) {
            $postCategory->image = $data['image'];
            $postCategory->slug = $data['slug'];
            $postCategory->status = $data['status'];
            $postCategory->view_home = $data['view_home'];
            $postCategory->meta_robots = $data['meta_robots'];
            $postCategory->rel = $data['rel'];
            $postCategory->target = $data['target'];
            foreach ($data['name'] as $key => $value) {
                $postCategory->setTranslation('name', $key, $value);
            }
            foreach ($data['meta_title'] as $key => $value) {
                $postCategory->setTranslation('meta_title', $key, $value);
            }
            foreach ($data['meta_keyword'] as $key => $value) {
                $postCategory->setTranslation('meta_keyword', $key, $value);
            }
            foreach ($data['meta_description'] as $key => $value) {
                $postCategory->setTranslation('meta_description', $key, $value);
            }
            foreach ($data['description'] as $key => $value) {
                $postCategory->setTranslation('description', $key, $value);
            }

            if ($postCategory->save()) {
                if (isset($data['saveAndBack'])) {
                    return redirect()->route('admin_post_category_index');
                }
                if (isset($data['saveAndNew'])) {
                    return redirect()->route('admin_post_category_add');
                }
                if (isset($data['save'])) {
                    return redirect()->route('admin_post_category_edit', $id);
                }
            }
        } else {
            return false; // Handle the case when the post category is not found
        }
    }
}
