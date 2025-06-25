<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Admin;
use App\Models\admin\User;
use Illuminate\Http\Request;

class UserAdminController extends Controller
{
    private $user;
    private $admin;
    public function __construct()
    {
        $this->user = new User();
        $this->admin = new Admin();
    }

    public function viewLogin(){
        return view('admin.login-admin');
    }

    public function login(Request $request){
        $admin = [
            'userName' => $request->input('username'),
            'passWord' =>md5($request->input('password'))
        ];
        $checkAmin = $this->admin->login($admin);
        if($checkAmin){
            // $avatar = $this->user->getUser($username);
            $request->session()->put([
                'userNameAdmin' =>  $request->input('username'),
                // 'avatar' => $avatar->avatar,
            ]);
            return redirect()->route('dashboardpage');
        }
        return redirect()->back();
        dd($admin);
    }

    public function logout(Request $request){
        $request->session()->forget('userNameAdmin');
        return redirect()->route('admin-login');
    }

    public function viewListUser(){
        $users = $this->user->getAllUser();
        // dd($users);
        return view('admin.list-user', compact('users'));
    }

    public function updateStatustUser($userId, $status){
        if ($status === 'n') {
            $checkStatus = $this->user->updateActive($userId);
            if ($checkStatus) {
                return redirect()->route('admin-list-user')
                    ->with('success', 'Đã kích hoạt tài khoản thành công (userId = ' . $userId . ')');
            }
            return redirect()->back()
                ->with('error', 'Kích hoạt tài khoản không thành công (userId = ' . $userId . ')');
        }
        if (in_array($status, ['b', 'o'])) {
            $checkStatus = $this->user->updateStatus($userId, $status);
            if ($checkStatus) {
                $statusInfo = $this->user->getStatus($userId);
                if ($statusInfo && $statusInfo->status === 'b') {
                    return redirect()->route('admin-list-user')
                        ->with('error', 'Tài khoản đã bị khóa (userId = ' . $userId . ')');
                }
                return redirect()->route('admin-list-user')
                    ->with('success', 'Tài khoản đang hoạt động (userId = ' . $userId . ')');
            }
            return redirect()->back()
                ->with('error', 'Cập nhật trạng thái tài khoản không thành công (userId = ' . $userId . ')');
        }
        return redirect()->back()
            ->with('error', 'Trạng thái không hợp lệ được yêu cầu (userId = ' . $userId . ')');
    }

}
