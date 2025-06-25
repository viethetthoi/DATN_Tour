<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Promotion;
use App\Models\Review;
use App\Models\StartEndDate;
use App\Models\Tours;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use Illuminate\Http\JsonResponse;


class TourController extends Controller
{
    private $tours;
    private $date;
    private $user;
    private $review;
    private $booked;
    private $promotion;
    public function __construct()
    {
        $this->tours = new Tours();
        $this->date = new StartEndDate();
        $this->user = new Users();
        $this->review = new Review();
        $this->booked = new Booking();
        $this->promotion = new Promotion();

    }
    public function viewListTour(){
        $userName = session()->get('userName');
        if(empty($userName)){
            $userId = -1;
            $tours = $this->tours->getAllTour1($userId);
            return view('clients.tour', compact('tours', 'userId'));
        }
        $inforUser = $this->user->getUser($userName);
        $userId = $inforUser->userId;
        $tours = $this->tours->getAllTour1($userId);
        // dd($tours);
        return view('clients.tour', compact('tours', 'userId'));
    }

    public function detailTour($id){
        $userName = session()->get('userName');
        try {
                $apiUrl = 'http://127.0.0.1:5555/api/tour-recommendations';
                $response = Http::get($apiUrl, [
                    'tour_id' => $id
                ]);

                if ($response->successful()) {
                    $tourIds = $response->json('recommended_tours');
                    $tourIds = array_slice($tourIds, 0, 4);
                } else {
                    $tourIds = [];
                }
        } catch (\Exception $e) {
                $tourIds = [];
        }
        // dd($tourIds);
        if(empty($userName)){
            $detailTour = $this->tours->getDetailTour($id);
            $reviews = $this->review->getAllReview($id);
            $tbRating = $this->review->getTBRating($id);
            $quantityRating = $this->review->quantityRating($id);
            $checkComment = null;  
            $userId = -1;
            $toursPopular = $this->tours->toursRecommen($tourIds, $userId);
            return view('clients.detailTour', compact('id', 'detailTour', 'reviews', 'tbRating', 'checkComment', 'quantityRating', 'toursPopular', 'userId'));
        }
        $inforUser = $this->user->getUser($userName);
        $userId = $inforUser->userId;
        $detailTour = $this->tours->getDetailTour($id);
        $reviews = $this->review->getAllReview($id);
        $tbRating = $this->review->getTBRating($id);
        $checkComment = $this->booked->checkComment($userId, $id);
        $quantityRating = $this->review->quantityRating($id);
        $toursPopular = $this->tours->toursRecommen($tourIds, $userId);

        // dd($toursPopular);
        return view('clients.detailTour', compact('id', 'detailTour', 'reviews', 'tbRating', 'checkComment', 'quantityRating', 'toursPopular', 'userId'));
    }
   


    public function regionalTours($domain){
        $userName = session()->get('userName');
        if(empty($userName)){
            $userId = -1;
            $tours = $this->tours->getAllTourDomain($domain, $userId);
            return view('clients.tour', compact('tours', 'userId', 'domain'));
        }
        $inforUser = $this->user->getUser($userName);
        $userId = $inforUser->userId;
        $tours = $this->tours->getAllTourDomain($domain, $userId);
        return view('clients.tour', compact('tours', 'userId', 'domain'));
    }

    public function searchTour(Request $request)
    {
        $domain = $request->input('addressTour');
        $budgets = $request->input('budgets');
        $departureDate = $request->input('departureDate');

        $userName = session()->get('userName');
        if(empty($userName)){
            $userId = -1;
            $tours = $this->tours->search($domain, $departureDate, $budgets, 'asc', $userId);   

            dd($tours);
            return view('clients.tour', compact('tours', 'userId', 'domain', 'budgets', 'departureDate'));
        }
        $inforUser = $this->user->getUser($userName);
        $userId = $inforUser->userId;
        $tours = $this->tours->search($domain, $departureDate, $budgets, 'asc', $userId);   
        // dd($tours);

        return view('clients.tour', compact('tours', 'userId', 'domain', 'budgets', 'departureDate'));
        

    }

    public function fillterTour(Request $request)
    {
        $userName = session()->get('userName');
        $addressTour = $request->input('addressTour');
        $budgets = $request->input('budgets');
        $departureDate = $request->input('departureDate');
        $sort = $request->input('sort');
        if(empty($userName)){
            $userId = -1;
            $tours = $this->tours->searchTour($addressTour, $departureDate, $budgets, $sort, $userId); 
            dd($tours);
            return response()->json([
                'tours' => $tours,
                'userId' => $userId
            ]);
        }
        $inforUser = $this->user->getUser($userName);
        $userId = $inforUser->userId;
        $tours = $this->tours->searchTour($addressTour, $departureDate, $budgets, $sort, $userId); 
        // dd($tou rs);
        // dd($tours);
        return response()->json([
            'tours' => $tours,
            'userId' => $userId
        ]);
    }

    public function startDate($tourId): JsonResponse
    {
        $startEndDate = $this->date->getAllDate($tourId);
        // dd($startEndDate);
        return response()->json($startEndDate);
    }
    

   
}
