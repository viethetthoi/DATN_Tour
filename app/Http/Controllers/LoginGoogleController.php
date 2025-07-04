<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;

class LoginGoogleController extends Controller
{
    private $user;

    public function __construct(){
        $this->user = new Users();
    }
   
    //
    public function redirectToGoogle()

    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */

     public function handleGoogleCallback()
     {
         try {
             $user = Socialite::driver('google')->user();
            //  dd($user);
            $finduser = $this->user->checkUserExistGoogle($user->id); 
            if($finduser){
                $avatar = $this->user->getUserGoogleId($user->id);
                if($avatar->status == 'o'){
                    session()->put([
                            'userName'=> $avatar->userName,
                            'avatar' => $avatar->avatar
                            ]);
                // session()->put('userName', $finduser->userName);
                    return redirect()->intended('/');
                }
                else{
                    return redirect()->intended('/login')->with('error', 'Tài khoản đã bị khóa!!!');
                }
                
            } 
            else{
                    $data_google = [
                        'google_id' => $user->id,
                        'fullName' => $user->name,
                        'userName' => 'user-google-' . $user->id,
                        'passWord' => md5('12345678'),
                        'email' => $user->email,
                        'isActive' => 'y'
                    ];
                if($this->user->checkMail($user->email)){
                    return redirect()->intended('/login')->with('error', 'Email đã được sử dụng!!!');
                }
                $this->user->register($data_google);
                $avatar = $this->user->getUser($data_google);
                session()->put([
                            'userName'=> $data_google['userName'],
                            // 'avatar' => $avatar->avatar
                ]);
                return redirect()->intended('/');
            }
             
         } catch (Exception $e) {
             dd($e->getMessage());
         }
     }
}
