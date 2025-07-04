<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Users extends Model
{
    use HasFactory;
    protected $table = 'tbl_users';

    public function register($data)
    {
        return DB::table($this->table)->insert($data);
    }

    public function registerAccount($data)
    {
        return DB::table($this->table)
                    ->where('email', '=', $data->email)
                    ->first();
    }

    public function checkMail($email){
        return DB::table($this->table)
                    ->where('email', $email)
                    ->exists();
    }

    public function checkUserExist($userName, $email){
        return DB::table($this->table)
                    ->where('userName', '=', $userName)
                    ->orWhere('email', '=', $email)
                    ->exists();
    }

    public function getUserByToken($token){
        return DB::table($this->table)->where('activation_token', $token)->first();
    }

    // Cập nhật thông tin kích hoạt tài khoản
    public function activateUserAccount($token)
    {
        return DB::table($this->table)
            ->where('activation_token', $token)
            ->update(['activation_token' => null, 'isActive' => 'y']);
    }

    public function login($account){
        return DB::table($this->table)
                    ->where('userName', '=', $account['userName'])
                    ->where('passWord', '=', $account['passWord'])
                    ->where('isActive', 'y')
                    ->exists();
    }

   

    public function checkUserExistGoogle($google_id){
        $check = DB::table($this->table)
        ->where('google_id', $google_id)->first();
        return $check;
    }


    public function getUser($userName){
        return DB::table($this->table)
                    ->where('userName', $userName)
                    ->first();
    }

    public function updateUser($user){
        return DB::table($this->table)
                 ->where('userName', $user['userName'])
                 ->update([
                     'fullName' => $user['fullName'],
                     'phoneNumber' => $user['phoneNumber'],
                     'address' => $user['address'],
                     'birthDay' => $user['birthDay'],
                     'updateDate' => now(),
                 ]);
    }

    public function updatePass($user){
        return DB::table($this->table)
                 ->where('userName', $user['userName'])
                 ->update([
                     'passWord' => $user['passWord'],
                 ]);
    }

    public function updateAvatar($user){
        return DB::table($this->table)
                 ->where('userName', $user['userName'])
                 ->update([
                     'avatar' => $user['avatar'],
                 ]);
    }

    public function getUserGoogleId($google_id){
        return DB::table($this->table)
                    ->where('google_id', $google_id)
                    ->first();
    }

    public function checkUserExist1($userName, $email){
        return DB::table($this->table)
                    ->where('userName', '=', $userName)
                    ->Where('email', '=', $email)
                    ->exists();
    }
    public function resetPass($userName, $email){
        $pass = md5('ACFdb123');
        return DB::table($this->table)
                    ->where('userName', '=', $userName)
                    ->Where('email', '=', $email)
                    ->update(['passWord' => $pass]);
    }
}
