<?php

namespace App\Http\Controllers;

use App\Models\FavouriteTour;
use App\Models\Tours;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FavouriteTourController extends Controller
{
    private $favourite;
    private $user;
    private $tour;

    public function __construct()
    {
        $this->favourite = new FavouriteTour();
        $this->tour = new Tours();
        $this->user = new Users();
    }

    public function showAllTour(){
        $userName = session()->get('userName');
        $inforUser = $this->user->getUser($userName);
        $userId = $inforUser->userId;
        $tours = $this->favourite->getAllFavourite($userId);
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
        return view('clients.favouriteTour', compact('tours', 'userId', 'toursPopular'));
    }

    public function addFavourite($userId, $tourId){
        if($userId == -1){
            return response()->json(['status' => 'success', 'favourite' => -1]);
        }
        $favourite = $this->favourite->getFavourite($userId, $tourId);
        if ($favourite) {
            $favourite->statusFavourite = ($favourite->statusFavourite == 0) ? 1 : 0;

            $data_favourite = [
                'userId' => $userId,
                'tourId' => $tourId,
                'statusFavourite' => $favourite->statusFavourite
            ];
            $this->favourite->updateFavuorite($data_favourite);
            return response()->json(['status' => 'success', 'favourite' => $favourite->statusFavourite]);
        } else {
            $data_favourite = [
                'userId' => $userId,
                'tourId' => $tourId,
                'statusFavourite' => '1'
            ];
            $this->favourite->insertFavourite($data_favourite);

            return response()->json(['status' => 'success', 'favourite' => 1]);
        }
    }
}
