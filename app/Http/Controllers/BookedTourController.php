<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use App\Models\Tours;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class BookedTourController extends Controller
{
    private $tour;
    private $user;
    private $review;
    private $booking;
    public function __construct()
    {
        $this->tour = new Tours();
        $this->user = new Users();
        $this->review = new Review();
        $this->booking = new Booking();
    }
    public function showListMyTour(){
        $userName = session()->get('userName');
        $inforUser = $this->user->getUser($userName);
        $userId = $inforUser->userId;
        $tours = $this->tour->getMyTours($userId, 4);
        if ($userId) {
            // Gọi API Python để lấy danh sách tour được gợi ý cho từng người dùng 
           try {
                $apiUrl = 'http://127.0.0.1:5555/api/user-recommendations';
                $response = Http::get($apiUrl, [
                    'user_id' => $userId
                ]);

                if ($response->successful()) {
                    $tourIds = $response->json('recommended_tours');

                    // ✅ Kiểm tra trước khi dùng array_slice
                    if (is_array($tourIds)) {
                        $tourIds = array_slice($tourIds, 0, 4);
                    } else {
                        $tourIds = null;
                    }
                } else {
                    $tourIds = null;
                }
            } catch (\Exception $e) {
                $tourIds = null;
            }

            if ($tourIds !== null) {
                $toursPopular = $this->tour->toursRecommendation($tourIds, $userId);
                // dd($toursPopular);
            } else {
                $toursPopular = $this->tour->toursRating();
                // dd($toursPopular);
            }
        }
        return view('clients.listMyTour', compact('tours', 'toursPopular'));
    }

    public function reviewTour(Request $request){
        $rating = $request->input('rating');
        $message = $request->input('comment');
        $tourId = $request->input('tourId');
        $userName = session()->get('userName');

        // ✅ KIỂM TRA SỚM nếu chưa đăng nhập
        if (empty($userName)) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn cần đăng nhập để đánh giá.',
                'redirect' => route('loginpage')
            ]);
        }

        // ✅ LÚC NÀY mới lấy thông tin user
        $inforUser = $this->user->getUser($userName);
        $userId = $inforUser->userId ?? null;

        if (!$userId) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy thông tin người dùng, vui lòng đăng nhập lại.',
                'redirect' => route('loginpage')
            ]);
        }

        $data_review = [
            'userId' => $userId,
            'tourId' => $tourId,
            'rating' => $rating,
            'comment' => $message,
            'timestamp' => now()
        ];
        $review = $this->review->insertReview($data_review);
        $reviews = $this->review->getAllReview($tourId);
        $tbRating = $this->review->getTBRating($tourId);
        $quantity = $this->review->quantityRating($tourId);
        // dd($quantity);
        if ($review > 0) { // Kiểm tra nếu $review thành công
            return response()->json([
                'success' => true,
                'message' => 'Cảm ơn bạn đã đánh giá!',
                'reviews' => $reviews,
                'average_rating' => $tbRating->average_rating,
                'total_reviews' => $tbRating->total_reviews,
                'quantityRating' => $quantity
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra, vui lòng thử lại!',
            ]);
        }

    
    }
    public function cancelTour(Request $request){
        $bookingId = $request->input('bookingId');
        // dd($bookingId);
        $check_cancel = $this->booking->updateBookingStatus($bookingId);
        if($check_cancel == true){
        return response()->json(['message' => 'Tour đã được hủy thành công.']);
        }

    }


}
