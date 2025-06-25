<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Promotion;
use Illuminate\Http\Request;
use App\Models\Tours;
use App\Models\Users;

class HomeController extends Controller

{
    private $homeTour;
    private $user;
    private $promotion;
    private $coupon;
    public function __construct()
    {
        $this->homeTour = new Tours();
        $this->user = new Users();
        $this->promotion = new Promotion();
        $this->coupon = new Coupon();
    }
    public function viewHomePage(){
        $userName = session()->get('userName');
        if(empty($userName)){
            $userId = -1;
            $tours = $this->homeTour->getAllTour1($userId)->take(4);
            $promotion = $this->promotion->getPromotionActive();
            $coupon = $this->coupon->getCouponActive();

            // dd($promotion);
            // $tours = $tour;
            // $countTour = $tours->count();
            return view('clients.home', compact('tours', 'userId', 'coupon'));
        }
        $inforUser = $this->user->getUser($userName);
        $userId = $inforUser->userId;
        $tour = $this->homeTour->getAllTour1($userId);
        $coupon = $this->coupon->getCouponActive();

        // $promotion = $this->promotion->getPromotionActive();

        // dd($promotion, $tour);
        $tours = $tour->take(4);
        // $countTour = $tours->count();
        return view('clients.home', compact('tours', 'userId', 'coupon'));
    }

    public function viewAboutPage(){
        return view('clients.about');
    }
}
