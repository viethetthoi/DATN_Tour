<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Review extends Model
{
    use HasFactory;
    protected $table = 'tbl_reviews';

    public function insertReview($review){
        return DB::table($this->table)->insert($review);
    }

    public function getAllReview($tourId){
        $reviews = DB::table($this->table)
                        ->where('tourId', $tourId)
                        ->get();
        foreach($reviews as $review){
            $review->user = DB::table('tbl_users')
                ->where('userId', $review->userId)
                ->get();
            $review->tour = DB::table('tbl_tour')
                ->where('tourId', $tourId)
                ->get();
        }
        return $reviews;
    }

    public function getTBRating($tourId)
    {
        $ratingData = DB::table($this->table)
                        ->where('tourId', $tourId)
                        ->select(
                            DB::raw('avg(rating) as average_rating'),  
                            DB::raw('count(*) as total_reviews')    
                        )
                        ->first();  
    
        if ($ratingData) {
            $ratingData->average_rating = round($ratingData->average_rating);
        }
    
        return $ratingData;
    }

    public function quantityRating($tourId){
        $ratings = DB::table($this->table)
            ->select('rating', DB::raw('COUNT(*) as count'))
            ->where('tourId', $tourId)
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        // Đảm bảo luôn có đủ 5 mức sao (1-5), kể cả khi không có đánh giá nào
        $result = [];
        for ($i = 5; $i >= 1; $i--) {
            $result[$i] = $ratings[$i] ?? 0;
        }

        return $result;
    }

    
}
