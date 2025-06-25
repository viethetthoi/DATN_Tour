<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class FavouriteTour extends Model
{
    use HasFactory;
    protected $table = 'tbl_favourite';

    public function getAllFavourite($userId)
    {
        $favourites = DB::table($this->table)
            ->where('userId', $userId)
            ->where('statusFavourite', 1)
            ->get();
        $promotions = DB::table('tbl_promotion')
                        ->where('status', 'y')
                        ->get();

        // Gắn mảng dateId ứng với từng promotion
        foreach ($promotions as $promotion) {
            $promotion->promoDateIds = DB::table('tbl_tour_promotion')
                                        ->where('promotionId', $promotion->promotionId)
                                        ->pluck('dateId')
                                        ->toArray();
        }

        $result = collect(); // Bộ sưu tập kết quả hợp lệ

        foreach ($favourites as $favourite) {
            $tour = DB::table('tbl_tour')
                ->where('tourId', $favourite->tourId)
                ->where('acStatus', 'y') // Chỉ lấy tour đang hoạt động
                ->first();

            if (!$tour) {
                // Bỏ qua tour nếu không tồn tại hoặc không hoạt động
                continue;
            }

            // Nếu hợp lệ thì lấy thông tin chi tiết
            $favourite->image = DB::table('tbl_images')
                ->where('tourId', $favourite->tourId)
                ->limit(4)
                ->pluck('imageURL');

            $favourite->timeline = DB::table('tbl_timeline')
                ->where('tourId', $favourite->tourId)
                ->get(['tl_title', 'tl_description']);

            $favourite->date = DB::table('tbl_start_end_date')
                ->where('tourId', $favourite->tourId)
                ->where('startDate', '>', now())
                ->orderByRaw('MONTH(startDate), YEAR(startDate)')
                ->get();

            $favourite->tour = $tour;

            $rating = DB::table('tbl_reviews')
                ->where('tourId', $favourite->tourId)
                ->avg('rating');

            $favourite->rating = floor($rating ?? 0);
            foreach ($promotions as $promotion) {
                foreach ($favourite->date as $date) {
                    if (in_array($date->dateId, $promotion->promoDateIds)) {
                        $favourite->promotion = $promotion;
                        break 2;
                    }
                }
            }

            $result->push($favourite);
        }

        return $result;
    }


    public function getFavourite($userId, $tourId)
    {
        return DB::table($this->table)
            ->where('userId', $userId)
            ->where('tourId', $tourId)
            ->first();
    }

    public function insertFavourite($favuorite)
    {
        return DB::table($this->table)->insert($favuorite);
    }

    public function updateFavuorite($favourite)
    {
        return DB::table($this->table)
            ->where('userId', $favourite['userId'])
            ->where('tourId', $favourite['tourId'])
            ->update(['statusFavourite' => $favourite['statusFavourite']]);
    }
}
