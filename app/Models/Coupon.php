<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'tbl_coupon';

    public function getCouponActive(){
        return DB::table($this->table)
                    ->where('status', 'y')
                    ->first();
    }
}
