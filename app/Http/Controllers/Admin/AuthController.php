<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * @Description : view Login
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */
    public function login()
    {
        return view('admin.auth.login');
    }


    /**
     * @Description :  xử lý đăng nhập
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */

    public function action_login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (auth()->attempt($credentials)) {
            // Tạo token mới cho người dùng
            $token = Str::random(60);

            auth()->user()->setAttribute('api_token', $token);
            auth()->user()->save();
        
            $request->session()->regenerate();
        
            return redirect()->intended('admin/post_category')->with('api_token', $token);
        }

        return back()->withErrors([
            'error' => 'Sai tài khoản hoặc mật khẩu.',
        ])->onlyInput('error');
    }

    /**
     * @Description : Đăng xuất
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin_login');
    }



    /**
     * @Description : 
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */

    public function forget()
    {
        return view('admin.auth.forget');
    }

    /**
     * @Description : tìm lại mật khẩu
     *
     * @throws 	: NotFoundException
     * @param 	: int data
     * @return 	: array
     * @Author 	: DRaja
     */
    public function action_forget(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'error' => 'Không tồn tại email',
            ])->onlyInput('error');
        }

        $randomPassword = Str::random(8);

        $email = $credentials['email'];
        $subject = 'Lấy lại mật khẩu';
        $content = '<!DOCTYPE html>
        <html>
        
        <head>
            <title>Reset Password</title>
        </head>
        
        <body>
            <p>Mật khẩu mới của bạn là: ' . $randomPassword . '</p>
            <p>Vui lòng đăng nhập vào hệ thống bằng mật khẩu mới này.</p>
        </body>
        
        </html>';

        $sendPass = $this->sendEmail($email, $subject, $content);
        if ($sendPass->getStatusCode() == 200) {
            $hashedPassword = bcrypt($randomPassword);
            $user->password = $hashedPassword;
            $user->save();

            return redirect()->back()->with('success', 'Một mật khẩu mới đã được gửi đến email của bạn.');
        } else {
            return redirect()->back()->withErrors([
                'error' => 'Đã xảy ra lỗi khi gửi email. Vui lòng thử lại sau.',
            ]);
        }
    }
}
