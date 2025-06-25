<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StartEndDate extends Model
{
    use HasFactory;
    protected $table = 'tbl_start_end_date';

    public function getAllDate($tourId)
    {
        $dates =  DB::table($this->table)
                    ->where('tourId', $tourId)
                    ->where('startDate', '>', now())
                    ->orderByRaw('MONTH(startDate), YEAR(startDate)') 
                    ->get();

        $promotions = DB::table('tbl_promotion')
                        ->where('status', 'y')
                        ->get();
        foreach ($promotions as $promotion) {
            $promotion->promoDateIds = DB::table('tbl_tour_promotion')
                ->where('promotionId', $promotion->promotionId)
                ->pluck('dateId')
                ->toArray();
        }
        foreach ($dates as $date) {
            $date->promotion = null; // Gán mặc định là null

            foreach ($promotions as $promotion) {

                if (in_array($date->dateId, $promotion->promoDateIds)) {
                    $date->promotion = $promotion;
                    break; // Tìm thấy thì gán và thoát khỏi vòng lặp promotion
                }
            }
        }

        return $dates; 
    }


    public function getAllDetailDate($dateId){
        $date = DB::table($this->table)
                    ->where('dateId', $dateId)
                    ->first();
        $promotions = DB::table('tbl_promotion')
                        ->where('status', 'y')
                        ->get();
        foreach ($promotions as $promotion) {
            $promotion->promoDateIds = DB::table('tbl_tour_promotion')
                ->where('promotionId', $promotion->promotionId)
                ->pluck('dateId')
                ->toArray();
        }
        foreach ($promotions as $promotion) {
            if (in_array($date->dateId, $promotion->promoDateIds)) {
                $date->promotion = $promotion;
                break; // Tìm thấy thì gán và thoát khỏi vòng lặp promotion
            }
        }
        return $date;
    }
    public function updateQuantityDate($date){
        return DB::table($this->table)
                 ->where('dateId', $date['dateId'])
                 ->update(['quantity' => $date['quantity']]);
    }
}
