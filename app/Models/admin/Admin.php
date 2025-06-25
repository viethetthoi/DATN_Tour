<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Admin extends Model
{
    use HasFactory;
    protected $table = 'tbl_admin';

    public function login($admin){
        return DB::table($this->table)
                    ->where('userName', $admin['userName'])
                    ->where('passWord', $admin['passWord'])
                    ->exists();
    }
}
