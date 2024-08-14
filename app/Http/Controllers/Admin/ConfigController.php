<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Language;
use App\Models\LanguageLine;
use Illuminate\Http\Request;

class ConfigController extends BackEndController
{
    public function home()
    {
        $this->config = [
            'js' => [
                'admin/library/finder.js',
                'ckeditor/ckeditor.js'
            ]
        ];
        $languages = Language::where('active', 1)->orderBy('default', 'DESC')->get();

        $query = new Config();
        $data = [];
        $fields = [
            'slides',
            'images',
        ];
        foreach ($fields as $field) {
            $data[$field] = $query->where('name', $field)->first();
        }


        $fieldLines = [
            'meta_title',
            'meta_keyword',
            'meta_description',
            'description_slide',
        ];

        foreach ($fieldLines as $field) {
            $data[$field] = LanguageLine::where('group', 'home')->where('key', $field)->first();
        }

        return $this->render(
            'admin.config.home',
            compact(
                'languages',
                'data',
            ),
        );
    }

    public function home_update(Request $request)
    {
        $data = $request->all();

        $update = [
            'meta_title' => $data['meta_title'],
            'meta_keyword' => $data['meta_keyword'],
            'meta_description' => $data['meta_description'],
            'description_slide' => $data['description'],
        ];


        foreach ($update as $key => $value) {
            $query = LanguageLine::where('group', 'home')->where('key', $key)->first();
            foreach ($value as $lang => $text) {
                $query->setTranslation('text', $lang, $text);
            }
            $query->save();
        }

        $update1 = [
            'slides' => $data['slides'],
            'images' => $data['images'],
        ];

        foreach ($update1 as $key => $value) {
            $query = Config::where('name', $key)->first();
            $query->value = $value;
            $query->save();
        }

        if (isset($data['save'])) {
            return redirect()->route('admin_config_home');
        }
    }

    /**
     * @Description : Thanh toán
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */


    public function payment()
    {
        $this->config = [
            'js' => [
                'admin/library/finder.js',
                'ckeditor/ckeditor.js'
            ]
        ];
        $languages = Language::where('active', 1)->orderBy('default', 'DESC')->get();

        $query = new Config();
        $data = [];
        $fields = [
            'email_payment',
            'content_email_admin',
            'status_payment'
        ];
        foreach ($fields as $field) {
            $data[$field] = $query->where('name', $field)->first();
        }


        $fieldLines = [
            'content_email_user',
            'content_email_user_nonpayment',
            'content_thanks_you',
            'content_thanks_you_nonpayment',
        ];

        foreach ($fieldLines as $field) {
            $data[$field] = LanguageLine::where('group', 'payment')->where('key', $field)->first();
        }
        return $this->render(
            'admin.config.payment',
            compact(
                'languages',
                'data',
            ),
        );
    }


    public function payment_update(Request $request)
    {
        $data = $request->all();

        $update = [
            'content_email_user' => $data['content_email_user'],
            'content_thanks_you' => $data['content_thanks_you'],
            'content_email_user_nonpayment' => $data['content_email_user_nonpayment'],
            'content_thanks_you_nonpayment' => $data['content_thanks_you_nonpayment'],
        ];

        $update1 = [
            'status_payment' => isset($data['status_payment']) ? 1 : 0,
            'email_payment' => $data['email_payment'],
            'content_email_admin' => $data['content_email_admin'],
        ];

        // cập nhật
        foreach ($update as $key => $value) {
            $query = LanguageLine::where('group', 'payment')->where('key', $key)->first();
            foreach ($value as $lang => $text) {
                $query->setTranslation('text', $lang, $text);
            }
            $query->save();
        }
        foreach ($update1 as $key => $value) {
            $query = Config::where('name', $key)->first();
            $query->value = $value;
            $query->save();
        }

        if (isset($data['save'])) {
            return redirect()->route('admin_config_payment');
        }
    }

    public function headerAndFooter()
    {
        $this->config = [
            'js' => [
                'admin/library/finder.js',
                'ckeditor/ckeditor.js'
            ]
        ];
        $languages = Language::where('active', 1)->orderBy('default', 'DESC')->get();

        $query = new Config();
        $data = [];
        $fields = [
            'email_payment',
            'content_email_admin',
            'status_payment'
        ];
        foreach ($fields as $field) {
            $data[$field] = $query->where('name', $field)->first();
        }


        $fieldLines = [
            'content_email_user',
            'content_email_user_nonpayment',
            'content_thanks_you',
            'content_thanks_you_nonpayment',
        ];

        foreach ($fieldLines as $field) {
            $data[$field] = LanguageLine::where('group', 'payment')->where('key', $field)->first();
        }
        return $this->render(
            'admin.config.headerAndFooter',
            compact(
                'languages',
                'data',
            ),
        );
    }


    public function headerAndFooter_update(Request $request)
    {
        // $data = $request->all();

        // $update = [
        //     'content_email_user' => $data['content_email_user'],
        //     'content_thanks_you' => $data['content_thanks_you'],
        //     'content_email_user_nonpayment' => $data['content_email_user_nonpayment'],
        //     'content_thanks_you_nonpayment' => $data['content_thanks_you_nonpayment'],
        // ];

        // $update1 = [
        //     'status_payment' => isset($data['status_payment']) ? 1 : 0,
        //     'email_payment' => $data['email_payment'],
        //     'content_email_admin' => $data['content_email_admin'],
        // ];

        // // cập nhật
        // foreach ($update as $key => $value) {
        //     $query = LanguageLine::where('group', 'payment')->where('key', $key)->first();
        //     foreach ($value as $lang => $text) {
        //         $query->setTranslation('text', $lang, $text);
        //     }
        //     $query->save();
        // }
        // foreach ($update1 as $key => $value) {
        //     $query = Config::where('name', $key)->first();
        //     $query->value = $value;
        //     $query->save();
        // }

        // if (isset($data['save'])) {
        //     return redirect()->route('admin_config_payment');
        // }
    }
}
