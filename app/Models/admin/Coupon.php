<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'tbl_coupon';

    public function insertCoupon($coupon){
        DB::table($this->table)->insert($coupon);
        return true;
    }

    public function getCouponActive(){
        return DB::table($this->table)
                    ->where('status', 'y')
                    ->first();
    }

    public function getAllCoupon(){
        return DB::table($this->table)->get();            
    }

    public function updateStatus($couponID) {
        $status = DB::table($this->table)
                    ->where('couponId', $couponID)
                    ->value('status');

        if ($status == 'n') {
            DB::table($this->table)
            ->where('couponId', $couponID)
            ->update(['status' => 'y']);
            return 'y';
        } else {
            DB::table($this->table)
            ->where('couponId', $couponID)
            ->update(['status' => 'n']);
            return 'n';
        }
    }

    public function getDetailCoupon($couponID){
        return DB::table($this->table)
                    ->where('couponId', $couponID)
                    ->first();
    }

    public function updateCoupon($coupon, $couponId){
        DB::table($this->table)
            ->where('couponId', $couponId)
            ->update($coupon);
        return true;
    }

    public function checkAcStatus(){
        return DB::table($this->table)
                    ->where('status', 'y')
                    ->exists();
    }

}
