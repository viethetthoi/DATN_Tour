<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Models\admin\Admin;

class UserController extends Controller
{
    private $user;


    public function __construct()
    {
        $this->user = new Users();

    }
    public function viewLoginPage(){
        return view('clients.login');
    }
    public function viewSignUpPage(){
        return view('clients.signup');
    }
     public function viewForgotPage(){
        return view('clients.forgot');
    }

    public function register(Request $request){
        $username_regis = $request->username_regis;
        $email = $request->email;
        $password_regis = $request->password_regis;
        $checkAccountExist = $this->user->checkUserExist($username_regis, $email);
        if($checkAccountExist){
            return response()->json([
                'success' => false,
                'message' => 'Tài khoản đã tồn tại'
            ]);
        }
        $activation_token = Str::random(60);
        $dataInsert = [
            'userName' => $username_regis,
            'passWord' => md5($password_regis),
            'email' => $email,
            'activation_token' => $activation_token
        ];

        $this->user->register($dataInsert);
        $this->sendActivationEmail($email, $activation_token);

        return response()->json([
            'success' => true,
            'message' => 'Đăng ký thành công!
             Vui lòng kiểm tra mail để kích hoạt tài khoản',
        ]);
    }

    public function sendActivationEmail($email, $token){
        $activation_link = route('activate.account', ['token' => $token]);
        Mail::send('clients.mail.emails_activation', ['link'=> $activation_link], function ($message) use ($email) {
            $message->to($email);
            $message->subject('Kích hoạt tài khoản của bạn!');
        });
    }

    public function activateAccount($token)
    {
        $user = $this->user->getUserByToken($token);
        if ($user) {
            $this->user->activateUserAccount($token);

            return redirect('/login')->with('message', 'Tài khoản của bạn đã được kích hoạt!');
        } else {
            return redirect('/login')->with('error', 'Mã kích hoạt không hợp lệ!');
        }
    }

    public function login(Request $request){
        $username = $request->username;
        $password = $request->password;
    
        $data_login = [
            'userName' => $username,
            'passWord' => md5($password)
        ];
        $checkUser = $this->user->login($data_login);
        if($checkUser){
            $avatar = $this->user->getUser($username);
            $request->session()->put([
                'userName' => $username,
                'avatar' => $avatar->avatar,
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Đăng nhập thành công',
                'redirecUrl' => route('homepage')
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Sai tài khoản, mật khẩu hoặc chưa kích hoạt',
            'redirecUrl' => route('loginpage')
        ]);
    }
    public function sendResetPassEmail($email){
        $activation_link = route('loginpage');
        Mail::send('clients.mail.email_resetPass', ['link'=> $activation_link], function ($message) use ($email) {
            $message->to($email);
            $message->subject('Mật khẩu mới của tài khoản của bạn!');
        });
    }

    public function forgot(Request $request){
        $userOld = $request->input('username_login_old');
        $email = $request->input('email');
        $check = $this->user->checkUserExist1($userOld, $email);
        if($check == false){
            return redirect()->back()->with('error', 'Tài khoản hoặc email sai!!');
        }
        $this->user->resetPass($userOld, $email);
        $this->sendResetPassEmail($email);
        return redirect()->back()->with('success', 'Vui lòng kiểm tra email!!');

    }

    public function logout(Request $request){
        $request->session()->forget('userName');
        $request->session()->forget('avatar');
        return redirect()->route('homepage');
    }
    
    public function profileUser(){
        $userName = session()->get('userName');
        $user = $this->user->getUser($userName);
        return view('clients.profileUser', compact('user'));
    }

    public function updateProfileUser(Request $request){
        $userName = session()->get('userName');
        $fullName = $request->input('inputFullName');
        $address = $request->input('inputAddress');
        $phoneNumber = $request->input('inputPhoneNumber');
        $birthDay = $request->input('inputBirthday');

        $data_user = [
            'userName' => $userName,
            'fullName' => $fullName,
            'phoneNumber' => $phoneNumber,
            'address' => $address,
            'birthDay' => $birthDay
        ];
        $this->user->updateUser($data_user);
        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thông tin thành công!',
            'data' => $data_user
        ]);

    }

    public function passwordProfileUser(Request $request){
        $userName = session()->get('userName');

        $user = $this->user->getUser($userName);
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Người dùng không tồn tại'
            ]);
        }
        $oldPass = md5($request->input('inputOldPass'));
        $newPass = md5($request->input('inputNewPass'));
        if ($oldPass !== $user->passWord) {
            return response()->json([
                'success' => false,
                'message' => 'Mật khẩu cũ không đúng'
            ]);
        }

        $data_pass = [
            'userName' => $userName,
            'passWord' => $newPass
        ];

        $updatePass = $this->user->updatePass($data_pass);
        if (!$updatePass) {
            return response()->json([
                'success' => false,
                'message' => 'Cập nhật mật khẩu thất bại'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Đổi mật khẩu thành công'
        ]);
    }

    public function avatarProfileUser(Request $request)
    {
        $userName = session()->get('userName');
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('clients/assets/images/profile-user'), $fileName);
    
            $data_user = [
                'userName' => $userName,
                'avatar' => $fileName
            ];
            $avatar = $this->user->updateAvatar($data_user);
            if (!$avatar) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tải ảnh không thành công!'
                ]);
            }
            return response()->json([
                'success' => true,
                'message' => 'Tải ảnh thành công!',
                'file_name' => $fileName
            ]);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'Không có file nào được chọn!'
        ]);
    }

}
