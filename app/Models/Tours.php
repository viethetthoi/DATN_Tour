<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Tours extends Model
{
    use HasFactory;
    protected $table = 'tbl_tour';

    public function getAllTour(){
        $tours = DB::table($this->table)->get();

        foreach($tours as $tour){
            $tour->image = DB::table('tbl_images')
                            ->where('tourId', $tour->tourId)
                            ->pluck('imageURL');
            
            $tour->timeline = DB::table('tbl_timeline')
                            ->where('tourId', $tour->tourId)
                            ->pluck('tl_title');
            
            $tour->date = DB::table('tbl_start_end_date')
                            ->where('tourId', $tour->tourId)
                            ->orderBy('startDate', 'asc')
                            ->get();
        }

        return $tours;
    }

    public function getAllTour1($userId) {
        $tours = DB::table($this->table)
                    ->where('acStatus', 'y')
                    ->get();

        // Lấy danh sách promotion đang hoạt động
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

        foreach ($tours as $tour) {
            // Ảnh tour
            $tour->image = DB::table('tbl_images')
                            ->where('tourId', $tour->tourId)
                            ->pluck('imageURL');

            // Lịch trình
            $tour->timeline = DB::table('tbl_timeline')
                                ->where('tourId', $tour->tourId)
                                ->pluck('tl_title');

            // Ngày khởi hành tương lai
            $tour->date = DB::table('tbl_start_end_date')
                            ->where('tourId', $tour->tourId)
                            ->where('startDate', '>', now())
                            ->orderBy('startDate', 'asc')
                            ->get();

            // Tour yêu thích
            $tour->favourite = DB::table('tbl_favourite')
                                ->where('tourId', $tour->tourId)
                                ->where('userId', $userId)
                                ->get();
            $rating = DB::table('tbl_reviews')
            ->where('tourId', $tour->tourId)
            ->avg('rating');

            $tour->rating = floor($rating ?? 0);

            // Kiểm tra promotion
            foreach ($promotions as $promotion) {
                foreach ($tour->date as $date) {
                    Log::info('So sánh dateId: ' . $date->dateId . ' với promoDateIds: ', $promotion->promoDateIds);

                    if (in_array($date->dateId, $promotion->promoDateIds)) {
                        Log::info('=> MATCH: TourId ' . $tour->tourId . ' có khuyến mãi: ' . $promotion->promotionId);
                        $tour->promotion = $promotion;
                        break 2;
                    }
                }
            }

        }

        return $tours;
    }

    public function getAllTourDomain($domain, $userId){
        $tours = DB::table($this->table)
                        ->where('destination', 'like', '%' . $domain . '%')
                        ->where('acStatus', 'y')
                        ->paginate(4);
        
        // Lấy danh sách promotion đang hoạt động
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

        foreach($tours as $tour){
            $tour->image = DB::table('tbl_images')
                            ->where('tourId', $tour->tourId)
                            ->pluck('imageURL');
            
            $tour->timeline = DB::table('tbl_timeline')
                            ->where('tourId', $tour->tourId)
                            ->pluck('tl_title');
            $tour->date = DB::table('tbl_start_end_date')
                            ->where('tourId', $tour->tourId)
                            ->where('startDate', '>', now())
                            ->orderBy('startDate', 'asc')
                            ->get();
            $tour->favourite = DB::table('tbl_favourite')
                            ->where('tourId', $tour->tourId)
                            ->where('userId', $userId)
                            ->get();
            $rating = DB::table('tbl_reviews')
                        ->where('tourId', $tour->tourId)
                        ->avg('rating');

            $tour->rating = floor($rating ?? 0);
            foreach ($promotions as $promotion) {
                    foreach ($tour->date as $date) {
                        // Log::info('So sánh dateId: ' . $date->dateId . ' với promoDateIds: ', $promotion->promoDateIds);

                        if (in_array($date->dateId, $promotion->promoDateIds)) {
                            // Log::info('=> MATCH: TourId ' . $tour->tourId . ' có khuyến mãi: ' . $promotion->promotionId);
                            $tour->promotion = $promotion;
                            break 2;
                        }
                    }
            }
        }

        return $tours;
    }


    public function getDetailTour($id){
        $getDetailTour = DB::table($this->table)
                            ->where('tourId', '=', $id)                    
                            ->first();
        $getDetailTour->image = DB::table('tbl_images')
                            ->where('tourId', $getDetailTour->tourId)
                            ->limit(4)
                            ->pluck('imageURL');
            
        $getDetailTour->timeline = DB::table('tbl_timeline')
                            ->where('tourId', $getDetailTour->tourId)
                            ->get(['tl_title', 'tl_description']);

        $getDetailTour->date = DB::table('tbl_start_end_date')
                            ->where('tourId', $getDetailTour->tourId)
                            ->orderByRaw('MONTH(startDate), YEAR(startDate)')
                            ->get();



        return $getDetailTour;
    }

    public function getDetailTourFavourite($id, $userId){
        $getDetailTour = DB::table($this->table)
                            ->where('tourId', '=', $id)                    
                            ->first();
        $getDetailTour->image = DB::table('tbl_images')
                            ->where('tourId', $getDetailTour->tourId)
                            ->limit(4)
                            ->pluck('imageURL');
            
        $getDetailTour->timeline = DB::table('tbl_timeline')
                            ->where('tourId', $getDetailTour->tourId)
                            ->get(['tl_title', 'tl_description']);
                            
        $getDetailTour->date = DB::table('tbl_start_end_date')
                            ->where('tourId', $getDetailTour->tourId)
                            ->where('startDate', '>', now())
                            ->orderByRaw('MONTH(startDate), YEAR(startDate)')
                            ->get();
        $getDetailTour->favourite = DB::table('tbl_favourite')
                            ->where('tourId', $getDetailTour->tourId)
                            ->where('userId', $userId)
                            ->get();



        return $getDetailTour;
    }

 public function searchTour($addressTour = null, $departureDate = null, $budgets = null, $sort = null, $userId = null)
{
    $query = DB::table('tbl_tour')
        ->where('acStatus', 'y')
        ->select(
            'tbl_tour.tourId',
            'tbl_tour.title',
            'tbl_tour.description',
            'tbl_tour.image',
            'tbl_tour.destination',
            'tbl_tour.reviews'
        );

    if (!empty($addressTour)) {
        $query->where('tbl_tour.destination', 'LIKE', '%' . $addressTour . '%');
    }

    $tours = $query->get();

    // Lấy danh sách promotion đang hoạt động
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

    $validTours = []; // ✅ Danh sách tour hợp lệ

    foreach ($tours as $tour) {
        // Lấy các ngày khởi hành còn chỗ, tương lai
        $datesAndPrices = DB::table('tbl_start_end_date')
            ->where('tourId', $tour->tourId)
            ->where('availability', 0)
            ->where('startDate', '>=', now())
            ->when($departureDate, function ($q) use ($departureDate) {
                $q->where('startDate', '>=', $departureDate);
            })
            ->select('dateId', 'startDate', 'priceAdult')
            ->orderBy('startDate')
            ->get();

        if ($datesAndPrices->isEmpty()) {
            continue; // Bỏ tour không hợp lệ
        }

        // Gắn thông tin bổ sung
        $tour->startDates = $datesAndPrices->pluck('startDate')->toArray();
        $tour->priceAdults = $datesAndPrices->pluck('priceAdult')->toArray();
        $tour->nearestStartDate = collect($tour->startDates)->sort()->first();
        $tour->minPriceAdult = collect($tour->priceAdults)->min();

        $tour->image = DB::table('tbl_images')
            ->where('tourId', $tour->tourId)
            ->pluck('imageURL');

        $tour->timeline = DB::table('tbl_timeline')
            ->where('tourId', $tour->tourId)
            ->pluck('tl_title');

        $tour->favourite = DB::table('tbl_favourite')
            ->where('tourId', $tour->tourId)
            ->where('userId', $userId)
            ->get(); // ✅ Trả về true/false

        $rating = DB::table('tbl_reviews')
            ->where('tourId', $tour->tourId)
            ->avg('rating');

        $tour->rating = floor($rating ?? 0);

        // Gắn khuyến mãi nếu có
        $tourDateIds = $datesAndPrices->pluck('dateId')->toArray();
        foreach ($promotions as $promotion) {
            if (array_intersect($promotion->promoDateIds, $tourDateIds)) {
                $tour->promotion = $promotion;
                break;
            }
        }

        $validTours[] = $tour; // ✅ Chỉ thêm tour hợp lệ
    }

    $tours = collect($validTours); // ✅ Biến thành Collection

    // Lọc theo ngân sách
    if (!empty($budgets)) {
        $priceRange = $this->mapBudgetToPriceRange($budgets);
        if ($priceRange) {
            $tours = $tours->filter(function ($tour) use ($priceRange) {
                return $tour->minPriceAdult >= $priceRange['min'] && $tour->minPriceAdult <= $priceRange['max'];
            })->values();
        }
    }

    // Sắp xếp
    if ($sort === 'asc') {
        $tours = $tours->sortBy('minPriceAdult')->values();
    } elseif ($sort === 'desc') {
        $tours = $tours->sortByDesc('minPriceAdult')->values();
    } elseif ($sort === 'date') {
        $tours = $tours->sortBy('nearestStartDate')->values();
    }

    return $tours;
}


    
public function search($addressTour = null, $departureDate = null, $budgets = null, $sort = null, $userId = null)
{
    $query = DB::table('tbl_tour')
    ->where('acStatus', 'y')
        ->select(
            'tourId',
            'title',
            'description',
            'image',
            'destination',
            'reviews'
        );

    if (!empty($addressTour)) {
        $query->where('destination', 'LIKE', '%' . $addressTour . '%');
    }

    $tours = $query->get();

    // Lấy danh sách promotion đang hoạt động
    $promotions = DB::table('tbl_promotion')
        ->where('status', 'y')
        ->get();

    foreach ($promotions as $promotion) {
        $promotion->promoDateIds = DB::table('tbl_tour_promotion')
            ->where('promotionId', $promotion->promotionId)
            ->pluck('dateId')
            ->toArray();
    }

    $validTours = [];

    foreach ($tours as $tour) {
        // Lấy danh sách ngày khởi hành hợp lệ
        $dates = DB::table('tbl_start_end_date')
            ->where('tourId', $tour->tourId)
            ->where('availability', 0)
            ->where('startDate', '>=', now())
            ->when($departureDate, function ($q) use ($departureDate) {
                $q->where('startDate', '>=', $departureDate);
            })
            ->orderByRaw('MONTH(startDate), YEAR(startDate)')
            ->get();

        // Bỏ qua tour không có ngày khởi hành hợp lệ
        if ($dates->isEmpty()) {
            continue;
        }

        // Gán các thuộc tính cho tour
        $tour->date = $dates;
        $tour->priceAdults = $dates->pluck('priceAdult')->toArray();

        $startDates = $dates->pluck('startDate');
        $tour->nearestStartDate = $startDates->isNotEmpty() ? $startDates->sort()->first() : null;

        $tour->minPriceAdult = collect($tour->priceAdults)->min();

        // Lấy ảnh
        $tour->image = DB::table('tbl_images')
            ->where('tourId', $tour->tourId)
            ->pluck('imageURL');

        // Lấy timeline
        $tour->timeline = DB::table('tbl_timeline')
            ->where('tourId', $tour->tourId)
            ->pluck('tl_title');

        // Lấy danh sách yêu thích (trả về collection)
        $tour->favourite = DB::table('tbl_favourite')
            ->where('tourId', $tour->tourId)
            ->where('userId', $userId)
            ->get();

        // Tính đánh giá trung bình
        $rating = DB::table('tbl_reviews')
            ->where('tourId', $tour->tourId)
            ->avg('rating');
        $tour->rating = floor($rating ?? 0);

        // Gán promotion (nếu có)
        $tour->promotion = null;
        foreach ($promotions as $promotion) {
            foreach ($dates as $date) {
                if (in_array($date->dateId, $promotion->promoDateIds)) {
                    $tour->promotion = $promotion;
                    break 2;
                }
            }
        }

        $validTours[] = $tour;
    }

    $tours = collect($validTours);

    // Lọc theo ngân sách
    if (!empty($budgets)) {
        $priceRange = $this->mapBudgetToPriceRange($budgets);

        if ($priceRange) {
            $tours = $tours->filter(function ($tour) use ($priceRange) {
                return $tour->minPriceAdult >= $priceRange['min'] && $tour->minPriceAdult <= $priceRange['max'];
            })->values();
        }
    }

    // Sắp xếp
    if ($sort == 'asc') {
        $tours = $tours->sortBy('minPriceAdult')->values();
    } elseif ($sort == 'desc') {
        $tours = $tours->sortByDesc('minPriceAdult')->values();
    } elseif ($sort == 'date') {
        $tours = $tours->sortBy('nearestStartDate')->values();
    }

    return $tours;
}

    

    private function mapBudgetToPriceRange($budget){
        switch ($budget) {
            case 'value2': 
                return ['min' => 0, 'max' => 5000000];
            case 'value3': 
                return ['min' => 5000000, 'max' => 10000000];
            case 'value4':
                return ['min' => 10000000, 'max' => 20000000];
            case 'value5':
                return ['min' => 20000000, 'max' => PHP_INT_MAX];
            default:
                return null;
        }
    }

    public function updateQuantityTour($tour){
        return DB::table($this->table)
                 ->where('tourId', $tour['tourId'])
                 ->update(['quantity' => $tour['quantity']]);
    }

    public function getMyTours($id, $perPage = 10){
        $myTours = DB::table('tbl_booking')
            ->join('tbl_tour', 'tbl_booking.tourId', '=', 'tbl_tour.tourId')
            ->join('tbl_checkout', 'tbl_booking.bookingId', '=', 'tbl_checkout.bookingId')
            ->where('tbl_booking.userId', $id)
            ->orderByDesc('tbl_booking.bookingDate')
            ->get();

        foreach ($myTours as $tour) {
            $tour->image = DB::table('tbl_images')
                    ->where('tourId', $tour->tourId)
                    ->pluck('imageUrl');
            
                $tour->rating = DB::table('tbl_reviews')
                    ->where('tourId', $tour->tourId)
                    ->where('userId', $id)
                    ->value('rating');
            
                $tour->date = DB::table('tbl_start_end_date')
                    ->where('tourId', $tour->tourId)
                    ->where('dateId', $tour->dateId) // lấy từ $tour
                    ->get(); // cột đúng cần lấy!
                $rating = DB::table('tbl_reviews')
                        ->where('tourId', $tour->tourId)
                        ->avg('rating');

                $tour->rating = floor($rating ?? 0);
        }
        return $myTours;
    }

    public function toursRecommendation($tourIds){
        $tours = collect(); // dùng Collection để có thể gọi isEmpty()

        foreach ($tourIds as $tourId) {
            $getDetailTour = DB::table($this->table)
                                ->where('tourId', $tourId)
                                ->first();

            if ($getDetailTour) {
                // Lấy danh sách hình ảnh (pluck trả về Collection)
                $getDetailTour->image = DB::table('tbl_images')
                                        ->where('tourId', $tourId)
                                        ->limit(4)
                                        ->pluck('imageURL');

                // Lấy timeline (get trả về Collection)
                $getDetailTour->timeline = DB::table('tbl_timeline')
                                        ->where('tourId', $tourId)
                                        ->get(['tl_title', 'tl_description']);

                // Lấy ngày khởi hành - kết thúc
                $getDetailTour->date = DB::table('tbl_start_end_date')
                                        ->where('tourId', $tourId)
                                        ->orderByRaw('MONTH(startDate), YEAR(startDate)')
                                        ->get();
                $getDetailTour->rating = DB::table('tbl_reviews')
                                ->where('tourId', $tourId)
                                ->avg('rating');

                // Thêm vào Collection
                $tours->push($getDetailTour);
            }
        }

        return $tours;
    }

    public function toursRecommen($tourIds, $userId) {
    $tours = collect();

    // Lấy các promotion đang hoạt động
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

    foreach ($tourIds as $tourId) {
        $tour = DB::table($this->table)
                    ->where('tourId', $tourId)
                    ->first();

        if ($tour) {
            // Ảnh
            $tour->image = DB::table('tbl_images')
                            ->where('tourId', $tourId)
                            ->limit(4)
                            ->pluck('imageURL');

            // Timeline
            $tour->timeline = DB::table('tbl_timeline')
                                ->where('tourId', $tourId)
                                ->get(['tl_title', 'tl_description']);

            // Ngày khởi hành
            $tour->date = DB::table('tbl_start_end_date')
                            ->where('tourId', $tourId)
                            ->orderByRaw('MONTH(startDate), YEAR(startDate)')
                            ->get();

            // Rating trung bình (làm tròn 1 chữ số)
            $tour->rating = round(
                DB::table('tbl_reviews')
                    ->where('tourId', $tourId)
                    ->avg('rating'), 1
            );

            // Kiểm tra yêu thích
            $tour->favourite = DB::table('tbl_favourite')
                                ->where('tourId', $tourId)
                                ->where('userId', $userId)
                                ->exists();

            // Gắn promotion nếu dateId phù hợp
            foreach ($promotions as $promotion) {
                foreach ($tour->date as $date) {
                    if (in_array($date->dateId, $promotion->promoDateIds)) {
                        $tour->promotion = $promotion;
                        break 2;
                    }
                }
            }
            $tours->push($tour);
        }
    }

    return $tours;
}

public function toursRating() {
    $tours = collect();

    // Lấy 4 tour có rating trung bình cao nhất
    $topTourIds = DB::table('tbl_reviews')
                ->join('tbl_tour', 'tbl_reviews.tourId', '=', 'tbl_tour.tourId')
                ->where('tbl_tour.acStatus', '=', 'y') // Chỉ lấy tour đang hoạt động
                ->select('tbl_reviews.tourId', DB::raw('AVG(rating) as avg_rating'))
                ->groupBy('tbl_reviews.tourId')
                ->orderByDesc('avg_rating')
                ->limit(4)
                ->pluck('tbl_reviews.tourId');


    foreach ($topTourIds as $tourId) {
        $getDetailTour = DB::table($this->table)
                            ->where('tourId', $tourId)
                            ->first();

        if ($getDetailTour) {
            // Lấy hình ảnh
            $getDetailTour->image = DB::table('tbl_images')
                                    ->where('tourId', $tourId)
                                    ->limit(4)
                                    ->pluck('imageURL');

            // Lấy timeline
            $getDetailTour->timeline = DB::table('tbl_timeline')
                                    ->where('tourId', $tourId)
                                    ->get(['tl_title', 'tl_description']);

            // Lấy ngày bắt đầu - kết thúc
            $getDetailTour->date = DB::table('tbl_start_end_date')
                                    ->where('tourId', $tourId)
                                    ->orderByRaw('MONTH(startDate), YEAR(startDate)')
                                    ->get();

            // Thêm rating trung bình
            $getDetailTour->rating = round(
                DB::table('tbl_reviews')
                    ->where('tourId', $tourId)
                    ->avg('rating'),
                1
            );

            $tours->push($getDetailTour);
        }
    }

    return $tours;
}

    
}
