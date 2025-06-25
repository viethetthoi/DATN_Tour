<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Promotion extends Model
{
    use HasFactory;
    protected $table = 'tbl_promotion';

    public function getPromotionActive(){
        $promotions =  DB::table($this->table)
                    ->where('status', 'y')
                    ->get();
        foreach($promotions as $promotion){
            $promotion->tourPro = DB::table('tbl_tour_promotion')
                                        ->where('promotionId', $promotion->promotionId)
                                        ->get();
        }

        return $promotions;
    }
}
