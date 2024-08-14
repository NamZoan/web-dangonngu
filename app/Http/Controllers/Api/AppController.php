<?php

namespace App\Http\Controllers\Api;

use Cart;
use DOMDocument;
use App\Models\Post;
use App\Models\Order;
use App\Models\Product;
use App\Models\Information;
use Illuminate\Support\Str;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\PostCategoryRelation;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Stichoza\GoogleTranslate\GoogleTranslate;

class AppController extends Controller
{

    /**
     * @Description : cập nhật trạng thái
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array Json
     * @Author 	: DRaja
     */

    protected $translator;

    public function __construct(GoogleTranslate $translator)
    {
        $this->translator = $translator;
    }

    public function updateStatus(Request $request)
    {
        $data = $request->all();
        $select = DB::table($data['table'])
            ->where('id', $data['id'])
            ->value($data['field']);
        if ($select == 1) {
            $check = DB::table($data['table'])
                ->where('id', $data['id'])
                ->update([$data['field'] => 0]);
            if ($check) {
                $responseData = [
                    'id' => $data['id'],
                    'field' => $data['field'],
                    'field_status' => 0,
                    'status' => true,
                    'message' => 'Cập nhật thành công'
                ];
            } else {
                return new JsonResponse([
                    'status' => false,
                    'message' => 'Cập nhật thất bại'
                ]);
            }
        } else {
            $check = DB::table($data['table'])
                ->where('id', $data['id'])
                ->update([$data['field'] => 1]);

            if ($check) {
                $responseData = [
                    'id' => $data['id'],
                    'field' => $data['field'],
                    'field_status' => 1,
                    'status' => true,
                    'message' => 'Cập nhật thành công'
                ];
            } else {
                return new JsonResponse([
                    'status' => false,
                    'message' => 'Cập nhật thất bại'
                ]);
            }
        }

        return new JsonResponse($responseData);
    }

    /** Delete theo model
     * @Description : 
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */


    public function deleteItem(Request $request)
    {
        $data = $request->all();
        $check = DB::table($data['table'])
            ->where('id', $data['id'])
            ->delete();

        if ($check) {

            // xử lý với phần posts
            if ($data['table'] == 'posts') {
                PostCategoryRelation::where('post_id', $data['id'])->delete();
            }

            // xử lý với phần posts_category
            if ($data['table'] == 'post_categories') {
                PostCategoryRelation::where('category_id', $data['id'])->delete();
            }


            return new JsonResponse([
                'status' => true,
                'message' => 'Xóa thành công'
            ]);
        } else {
            return new JsonResponse([
                'status' => false,
                'message' => 'Xóa thất bại'
            ]);
        }
    }

    /**
     * @Description : Hàm lấy slug
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */
    public function generateSlug(Request $request)
    {
        // Lấy chuỗi từ request
        $data = $request->all();
        $slug = $this->generateUniqueSlug($data);
        return response()->json(['slug' => $slug]);
    }

    private function generateUniqueSlug($data)
    {
        $slug = ($data['slug'] == null) ? Str::slug($data['name']) : $data['slug'];

        if ($data['id'] == null) {
            $count = DB::table($data['table'])
                ->where('slug', 'like', $slug . '%')
                ->count();

            return $count > 0 ? "{$slug}-" . ($count + 1) : $slug;
        } else {
            $count = DB::table($data['table'])
                ->where('slug', 'like', $slug . '%')
                ->where('id', '!=', $data['id'])
                ->count();

            return $count > 0 ? "{$slug}-" . ($count + 1) : $slug;
        }
    }

    /** lấy Thông tin
     * @Description : 
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */


    public function getInformation(Request $request)
    {
        $search = $request->input('search');
        $start = $request->input('start', 0);
        $length = $request->input('length', 5);
        $order = $request->input('order');
        $search = $request->input('search');
        $lang = $request->input('lang');

        $query = Information::query();

        // Bộ lọc
        if (!empty($search['value'])) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search['value'] . '%');
                // Add more conditions for other fields here if needed
            });
        }

        // Sắp xếp
        if (!empty($order)) {
            $columnIndex = $order[0]['column'];
            $columnName = $request->input('columns.' . $columnIndex . '.data');
            $direction = $order[0]['dir'];

            // Validate column name to avoid SQL injection
            $allowedColumns = ['name', 'created_at']; // Add more if needed
            if (in_array($columnName, $allowedColumns)) {
                $query->orderBy($columnName, $direction);
            }
        }

        // Phân trang
        $filteredCategories = $query->offset($start)->limit($length)->get();
        $count = $query->count();

        $data = $filteredCategories->map(function ($category) use ($lang) {
            return [
                'id' => $category->id,
                'url' => route("web.information", ['slug' => $category->slug], true, $lang),
                'name' => $category->getTranslation('name', $lang),
                'status' => $category->status,
                'view_header' => $category->view_header,
                'view_footer' => $category->view_footer,
                'created_at' => $category->created_at,
            ];
        });

        return response()->json([
            'data' => $data,
            'recordsTotal' => $count,
        ]);
    }

    /** lấy danh mục bài viết
     * @Description : 
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */


    public function getCategories(Request $request)
    {
        $search = $request->input('search');
        $start = $request->input('start', 0);
        $length = $request->input('length', 5);
        $order = $request->input('order');
        $search = $request->input('search');
        $lang = $request->input('lang');

        $query = PostCategory::query();

        // Bộ lọc
        if (!empty($search['value'])) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search['value'] . '%');
                // Add more conditions for other fields here if needed
            });
        }

        // Sắp xếp
        if (!empty($order)) {
            $columnIndex = $order[0]['column'];
            $columnName = $request->input('columns.' . $columnIndex . '.data');
            $direction = $order[0]['dir'];

            // Validate column name to avoid SQL injection
            $allowedColumns = ['name', 'created_at']; // Add more if needed
            if (in_array($columnName, $allowedColumns)) {
                $query->orderBy($columnName, $direction);
            }
        }

        // Phân trang
        $filteredCategories = $query->offset($start)->limit($length)->get();
        $count = $query->count();

        $data = $filteredCategories->map(function ($category) use ($lang) {
            return [
                'id' => $category->id,
                'url' => route("web_list_post", ['slug' => $category->slug], true, $lang),
                'image' => asset($category->image),
                'name' => $category->getTranslation('name', $lang),
                'status' => $category->status,
                'view_home' => $category->view_home,
                'created_at' => $category->created_at,
            ];
        });

        return response()->json([
            'data' => $data,
            'recordsTotal' => $count,
        ]);
    }


    /**
     * @Description : lấy tất cả các bài viết
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: json(array)
     * @Author 	: DRaja
     */


    public function getPosts(Request $request)
    {
        $search = $request->input('search');
        $start = $request->input('start', 0);
        $length = $request->input('length', 5);
        $order = $request->input('order');
        $lang = $request->input('lang');


        // Khởi tạo query để lấy dữ liệu từ cơ sở dữ liệu
        $query = Post::with('user', 'categories');
        // Áp dụng bộ lọc nếu có
        if (!empty($search['value'])) {
            $like = '%' . $search['value'] . '%';

            $query->where(
                'name',
                'LIKE',
                $like
            );
        }
        // Xử lý sắp xếp
        if (!empty($order)) {
            $columnIndex = $order[0]['column'];
            $columnName = $request->input('columns.' . $columnIndex . '.data');
            $direction = $order[0]['dir'];
            $query->orderBy($columnName, $direction);
        }
        $filteredPosts = $query->skip($start)->take($length)->get();

        $data = $filteredPosts->map(function ($item) use ($lang) {
            return [
                'id' => $item->id,
                'categories' => $item->categories->map(function ($category) use ($lang) {
                    return $category->getTranslation('name', $lang);
                }),
                'user_name' => $item->user->name,
                'view' => $item->view,
                'url' => route("web_post_detail", ['slug' => $item->slug], true, $lang),
                'image' => asset($item->image),
                'name' => $item->getTranslation('name', $lang),
                'status' => $item->status,
                'created_at' => $item->created_at,
            ];
        });
        $count = Post::count();
        return response()->json([
            'data' => $data,
            'recordsTotal' => $count,
        ]);
    }

    /**
     * @Description : lấy danh mục sản phẩm
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */

    public function getProductCategories(Request $request)
    {
        $search = $request->input('search');
        $start = $request->input('start', 0);
        $length = $request->input('length', 5);
        $order = $request->input('order');
        $lang = $request->input('lang');

        $query = ProductCategory::query();

        // Bộ lọc
        if (!empty($search['value'])) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search['value'] . '%');
                // Add more conditions for other fields here if needed
            });
        }

        // Sắp xếp
        if (!empty($order)) {
            $columnIndex = $order[0]['column'];
            $columnName = $request->input('columns.' . $columnIndex . '.data');
            $direction = $order[0]['dir'];

            // Validate column name to avoid SQL injection
            $allowedColumns = ['name', 'created_at']; // Add more if needed
            if (in_array($columnName, $allowedColumns)) {
                $query->orderBy($columnName, $direction);
            }
        }

        // Phân trang
        $filteredCategories = $query->offset($start)->limit($length)->get();
        // dd($query->toSql());
        $count = $query->count();

        $data = $filteredCategories->map(function ($category) use ($lang) {
            return [
                'id' => $category->id,
                'url' => route("web_list_product", ['slug' => $category->slug], true, $lang),
                'image' => asset($category->image),
                'name' => $category->getTranslation('name', $lang),
                'status' => $category->status,
                'created_at' => $category->created_at,
            ];
        });


        return response()->json([
            'data' => $data,
            'recordsTotal' => $count,
        ]);
    }

    /**
     * @Description : 
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */

    public function getProducts(Request $request)
    {
        $search = $request->input('search');
        $start = $request->input('start', 0);
        $length = $request->input('length', 5);
        $order = $request->input('order');
        $lang = $request->input('lang');

        $query = Product::with('category');

        // Áp dụng bộ lọc nếu có
        if (!empty($search['value'])) {
            $like = '%' . $search['value'] . '%';
            $query->where('name', 'LIKE', $like);
        }

        // Xử lý sắp xếp
        if (!empty($order)) {
            $columnIndex = $order[0]['column'];
            $columnName = $request->input('columns.' . $columnIndex . '.data');
            $direction = $order[0]['dir'];
            $query->orderBy($columnName, $direction);
        }

        $filteredProducts = $query->skip($start)->take($length)->get();

        $count = Product::count();

        $data = $filteredProducts->map(function ($product) use ($lang) {
            return [
                'id' => $product->id,
                'url' => route("web_product_detail", ['slug' => $product->slug], true, $lang),
                'category' => $product->category ? $product->category->getTranslation('name', $lang) : null,
                'code' => $product->code,
                'image' => asset($product->image),
                'name' => $product->getTranslation('name', $lang),
                'price' => $product->getTranslation('price', $lang),
                'unit' => $product->getTranslation('unit', $lang),
                'status' => $product->status,
                'created_at' => $product->created_at,
            ];
        });

        return response()->json([
            'data' => $data,
            'recordsTotal' => $count,
        ]);
    }


    /**
     * @Description : Xóa cache
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */

    public function clearCache()
    {
        // Xóa cache
        Artisan::call('cache:clear');

        return response()->json(['message' => 'Cache cleared successfully'], 200);
    }

    /**
     * @Description : Dịch ngôn ngữ
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */

    public function translate(Request $request)
    {
        set_time_limit(120);
        $data = $request->only(['from', 'to', 'text', 'html']);
        $from = $data['from'];
        $to = $data['to'];
        $text = $data['text'];
        $html = filter_var($data['html'], FILTER_VALIDATE_BOOLEAN);

        $this->translator->setSource($from)->setTarget($to);

        if ($html) {
            $translatedText = $this->translateHtml($text);
        } else {
            $translatedText = $this->translator->translate($text);
        }

        return response()->json(['translatedText' => $translatedText]);
    }

    private function translateHtml($htmlContent)
    {
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTML(mb_convert_encoding($htmlContent, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();

        $body = $dom->getElementsByTagName('body')->item(0);
        if ($body) {
            $this->translateNode($body);
        }

        return $dom->saveHTML($body);
    }

    private function translateNode($node)
    {
        if ($node->nodeType === XML_TEXT_NODE) {
            $node->nodeValue = $this->translator->translate($node->nodeValue);
        } else {
            foreach ($node->childNodes as $childNode) {
                $this->translateNode($childNode);
            }
        }
    }


    public function checkProductCode(Request $request)
    {

        $id = $request->input('id');
        if (!$id) {
            $code = $request->input('code');
            $check = Product::where('code', $code)
                ->count();
        } else {
            $code = $request->input('code');
            $check = Product::where('code', $code)
                ->where('id', $id)
                ->count();
        }

        return response()->json(['status' => $check > 0]);
    }

    public function getOrders(Request $request)
    {
        $search = $request->input('search');
        $start = $request->input('start', 0);
        $length = $request->input('length', 5);
        $order = $request->input('order');

        $query = Order::query();

        // Áp dụng bộ lọc nếu có
        if (!empty($search['value'])) {
            $like = '%' . $search['value'] . '%';
            $query->where('name', 'LIKE', $like)
                ->orWhere('transaction_code', 'LIKE', $like)
                ->orWhere('email', 'LIKE', $like)
                ->orWhere('created_at', 'LIKE', $like)
                ->orWhere('phone', 'LIKE', $like);
        }

        // Xử lý sắp xếp
        if (!empty($order)) {
            $columnIndex = $order[0]['column'];
            $columnName = $request->input('columns.' . $columnIndex . '.data');
            $direction = $order[0]['dir'];
            $query->orderBy($columnName, $direction);
        }

        $count = $query->count();
        $filteredOrders = $query->skip($start)->take($length)->get();

        $data = $filteredOrders->map(function ($order) {
            return [
                'id' => $order->id,
                'transaction_code' => $order->transaction_code,
                'name' => $order->name,
                'email' => $order->email,
                'phone' => $order->phone,
                'total' => $order->total,
                'unit_payment' => $order->unit_payment,
                'order_status' => $order->order_status,
                'created_at' => $order->created_at,
            ];
        });

        return response()->json([
            'data' => $data,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
        ]);
    }
}
