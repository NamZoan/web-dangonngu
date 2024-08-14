<?php

namespace App\Http\Controllers\Admin;

use App\Models\Information;
use App\Models\Language;
use Illuminate\Http\Request;

class InformationController extends BackEndController
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
        $languages = Language::where('active', 1)->orderBy('default', 'DESC')->get();

        $information = Information::all();

        return $this->render(
            'admin.information.index',
            compact(
                'information',
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

        // lấy danh sách ngôn ngữ

        $languages = Language::where('active', 1)->orderBy('default', 'DESC')->get();
        return $this->render(
            'admin.information.add',
            compact('languages'),
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

        if (isset($data['view_header']) == "on") $data['view_header'] = 1;
        else $data['view_header'] = 0;

        if (isset($data['view_footer']) == "on") $data['view_footer'] = 1;
        else $data['view_footer'] = 0;

        $information = new Information();
        $information->slug = $data['slug'];
        $information->status = $data['status'];
        $information->view_header = $data['view_header'];
        $information->view_footer = $data['view_footer'];
        $information->meta_robots = $data['meta_robots'];
        $information->rel = $data['rel'];
        $information->target = $data['target'];
        foreach ($data['name'] as $key => $value) {
            $information->setTranslation('name', $key, $value);
        }
        foreach ($data['meta_title'] as $key => $value) {
            $information->setTranslation('meta_title', $key, $value);
        }
        foreach ($data['meta_keyword'] as $key => $value) {
            $information->setTranslation('meta_keyword', $key, $value);
        }
        foreach ($data['meta_description'] as $key => $value) {
            $information->setTranslation('meta_description', $key, $value);
        }
        foreach ($data['description'] as $key => $value) {
            $information->setTranslation('description', $key, $value);
        }

        if ($information->save()) {
            if (isset($data['saveAndBack'])) {
                return redirect()->route('admin_information_index');
            }
            if (isset($data['saveAndNew'])) {
                return redirect()->route('admin_information_add');
            }
            if (isset($data['save'])) {
                return redirect()->route('admin_information_edit', $information->id);
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
        $information = information::find($id);

        $languages = Language::where('active', 1)->orderBy('default', 'DESC')->get();

        return $this->render(
            'admin.information.edit',
            compact(
                'information',
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
        $data['view_header'] = isset($data['view_header']) && $data['view_header'] == 1 ? 1 : 0;
        $data['view_footer'] = isset($data['view_footer']) && $data['view_footer'] == 1 ? 1 : 0;

        $information = information::find($id);

        if ($information) {
            $information->slug = $data['slug'];
            $information->status = $data['status'];
            $information->view_header = $data['view_header'];
            $information->view_footer = $data['view_footer'];
            $information->meta_robots = $data['meta_robots'];
            $information->rel = $data['rel'];
            $information->target = $data['target'];
            foreach ($data['name'] as $key => $value) {
                $information->setTranslation('name', $key, $value);
            }
            foreach ($data['meta_title'] as $key => $value) {
                $information->setTranslation('meta_title', $key, $value);
            }
            foreach ($data['meta_keyword'] as $key => $value) {
                $information->setTranslation('meta_keyword', $key, $value);
            }
            foreach ($data['meta_description'] as $key => $value) {
                $information->setTranslation('meta_description', $key, $value);
            }
            foreach ($data['description'] as $key => $value) {
                $information->setTranslation('description', $key, $value);
            }

            if ($information->save()) {
                if (isset($data['saveAndBack'])) {
                    return redirect()->route('admin_information_index');
                }
                if (isset($data['saveAndNew'])) {
                    return redirect()->route('admin_information_add');
                }
                if (isset($data['save'])) {
                    return redirect()->route('admin_information_edit', $id);
                }
            }
        } else {
            return false; // Handle the case when the post category is not found
        }
    }
}
