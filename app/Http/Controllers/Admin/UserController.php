<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;


class UserController extends BackEndController
{

    /**
     * @Description : view profile user
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */

    public function change_profile()
    {
        $user = Auth::user();
        Session::put('user', $user);
        return $this->render(
            'admin.user.change_profile',
            compact(
                'user'
            ),
        );
    }

    /**
     * @Description : Thay đổi mật khẩu người dùng
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */


    public function action_change_password(Request $request)
    {
        $user = User::find(Auth::id());


        $user->name = $request->input('name');

        if (Hash::check($request->input('password'), $user->password)) {
            if ($request->input('newPass') != $request->input('confirmNewPass')) {
                return back()->withErrors([
                    'error' => 'mật khẩu nhập lại không chính xác.',
                ])->onlyInput('error');
            } else {
                $user->password = bcrypt($request->input('newPass'));
                $user->save();
                return back()->withErrors([
                    'success' => 'Đổi mật khẩu thành công',
                ])->onlyInput('success');
            }
        } else {
            return back()->withErrors([
                'error' => 'Sai mật khẩu.',
            ])->onlyInput('error');
        }
    }

    
}
