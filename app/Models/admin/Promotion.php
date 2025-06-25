<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Promotion extends Model
{
    use HasFactory;
    protected $table = 'tbl_promotion';

    public function getAllPromotion(){
        return DB::table($this->table)->get();
    }

    public function insertPromotion($promotion){
        return DB::table($this->table)->insertGetId($promotion);
    }

    public function getDetailPromotion($promotionId){
        return DB::table($this->table)
                    ->where('promotionId', $promotionId)
                    ->first();
    }

    public function updatePromotion($promotion){
        return DB::table($this->table)
                    ->where('promotionId', $promotion['promotionId'])
                    ->update($promotion);
    }

    public function updateStatus($promotionId)
    {
        $promotion = DB::table('tbl_promotion')
                        ->where('promotionId', $promotionId)
                        ->first();
    
        if ($promotion) {
            $newStatus = ($promotion->status === 'n') ? 'y' : 'n';
    
            DB::table('tbl_promotion')
                ->where('promotionId', $promotionId)
                ->update(['status' => $newStatus]);
    
            return $newStatus;
        }
        return null;
    }

    public function checkAcStatus(){
        return DB::table($this->table)
                    ->where('status', 'y')
                    ->exists();
    }
    

}
