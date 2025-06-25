<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    use HasFactory;
    protected $table = 'tbl_users';

    public function getAllUser(){
        return DB::table($this->table)->paginate(8);
    }

    public function updateActive($userId){
        return DB::table($this->table)
                    ->where('userId', $userId)
                    ->update(['isActive' => 'y', 'activation_token' => null]);       
    }

    public function updateStatus($userId, $status){
        if($status == 'b'){
            return DB::table($this->table)
                        ->where('userId', $userId)
                        ->update(['status' => 'o']);        
        }
        return DB::table($this->table)
                        ->where('userId', $userId)
                        ->update(['status' => 'b']); 
    }

    public function getStatus($userId){
        return DB::table($this->table)
                    ->where('userId', $userId)
                    ->first(['status']);  
    }
}
