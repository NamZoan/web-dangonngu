<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\BackEndController;
use App\Models\Language;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostCategoryRelation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;


class PostController extends BackEndController
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

        $posts = Post::with('user', 'categories')->get();



        return $this->render(
            'admin.post.index',
            compact(
                'posts',
                'languages'
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

        $languages = Language::where('active', 1)->orderBy('default', 'DESC')->get();

        $categories = PostCategory::where('status', '1')
            ->select('id', 'name')
            ->get();


        return $this->render(
            'admin.post.add',
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
        $post = new Post();
        $post->image = $data['image'];
        $post->status = $data['status'];
        $post->slug = $data['slug'];
        $post->meta_robots = $data['meta_robots'];
        $post->rel = $data['rel'];
        $post->target = $data['target'];
        $post->user_id = auth()->user()->id;

        foreach ($data['description'] as $key => $value) {
            $post->setTranslation('summary', $key, $this->generateTableOfContents($value));
            $post->setTranslation('description', $key, $this->adjustTableOfContents($value));
        }

        foreach ($data['name'] as $key => $value) {
            $post->setTranslation('name', $key, $value);
        }

        foreach ($data['meta_title'] as $key => $value) {
            $post->setTranslation('meta_title', $key, $value);
        }

        foreach ($data['meta_keyword'] as $key => $value) {
            $post->setTranslation('meta_keyword', $key, $value);
        }

        foreach ($data['meta_description'] as $key => $value) {
            $post->setTranslation('meta_description', $key, $value);
        }

        if ($post->save()) {

            // thêm vào danh mục 
            if (!empty($data['categories'])) {
                PostCategoryRelation::where('post_id', $post->id)->delete();

                foreach ($data['categories'] as $category) {

                    PostCategoryRelation::create([
                        'post_id' => $post->id,
                        'category_id' => $category

                    ]);
                }
            } else {
                PostCategoryRelation::where('post_id', $post->id)->delete();
            }

            if (isset($data['saveAndBack'])) {
                return redirect()->route('admin_post_index');
            }
            if (isset($data['saveAndNew'])) {
                return redirect()->route('admin_post_add');
            }
            if (isset($data['save'])) {
                return redirect()->route('admin_post_edit', $post->id);
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

        $languages = Language::where('active', 1)->orderBy('default', 'DESC')->get();

        $categories = PostCategory::where('status', '1')
            ->select('id', 'name')
            ->get();

        $post = Post::with('user', 'categories')->find($id);
        return $this->render(
            'admin.post.edit',
            compact(
                'categories',
                'post',
                'languages',
            ),
        );
    }


    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['status'] = isset($data['status']) && $data['status'] == 1 ? 1 : 0;

        // Find the post by ID
        $post = Post::find($id);

        if ($post) {
            // Update post fields
            $post->image = $data['image'];
            $post->status = $data['status'];
            $post->slug = $data['slug'];
            $post->meta_robots = $data['meta_robots'];
            $post->rel = $data['rel'];
            $post->target = $data['target'];
            $post->user_id = auth()->user()->id;

            // Update translations
            foreach ($data['description'] as $key => $value) {
                $post->setTranslation('summary', $key, $this->generateTableOfContents($value));
                $post->setTranslation('description', $key, $this->adjustTableOfContents($value));
            }
            foreach ($data['name'] as $key => $value) {
                $post->setTranslation('name', $key, $value);
            }
            foreach ($data['meta_title'] as $key => $value) {
                $post->setTranslation('meta_title', $key, $value);
            }
            foreach ($data['meta_keyword'] as $key => $value) {
                $post->setTranslation('meta_keyword', $key, $value);
            }
            foreach ($data['meta_description'] as $key => $value) {
                $post->setTranslation('meta_description', $key, $value);
            }

            // Save the post
            if ($post->save()) {
                // Update categories
                PostCategoryRelation::where('post_id', $post->id)->delete();
                if (!empty($data['categories'])) {
                    foreach ($data['categories'] as $category) {
                        PostCategoryRelation::create([
                            'post_id' => $post->id,
                            'category_id' => $category
                        ]);
                    }
                }

                // Clear cache
                Cache::forget('post_' . $data['slug']);

                // Redirect based on input
                if (isset($data['saveAndBack'])) {
                    return redirect()->route('admin_post_index');
                }
                if (isset($data['saveAndNew'])) {
                    return redirect()->route('admin_post_add');
                }
                if (isset($data['save'])) {
                    return redirect()->route('admin_post_edit', $id);
                }
            } else {
                Log::error("Failed to save the post with ID: $id");
                return false;
            }
        } else {
            Log::error("Không tìm thấy bản ghi với ID: $id");
            return false;
        }
    }
}
