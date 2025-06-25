<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Booking;
use App\Models\admin\Tour;
use App\Models\admin\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    private $tour;
    private $booking;
    private $user;

    public function __construct()
    {
        $this->tour = new Tour();
        $this->booking = new Booking();
        $this->user = new User();
    }
    public function show(){
        $total_data = [
                'countTour' => $this->tour->getAllTour()->count(),
                'countBooking' => $this->booking->getAllBooking()->count(),
                'countUser' => $this->user->getAllUser()->count(),
                'totalPrice' => $this->booking->totalAllBooking()
            ];
        $users = $this->user->getAllUser();
        $bookings = $this->booking->getAllBooking();
        $topBooked = $this->booking->topBookedTour();
        $quantityDomain = $this->tour->quantityDomain();
        $annualRevenue = $this->booking->annualRevenue(Carbon::now()->year);
        // dd($annualRevenue);
        // dd($quantityDomain);
        // dd($topBooked);
        // dd($data);
        return view('admin.dashboard', compact('total_data', 'users', 'bookings', 'topBooked', 'quantityDomain', 'annualRevenue'));
    }

    public function annualRevenue(Request $request){
        $year = $request->get('year', now()->year);

        // Lấy dữ liệu doanh thu từ model (giả sử model Booking đã inject sẵn trong controller qua $this->booking)
        $annualRevenue = $this->booking->annualRevenue($year);

        return response()->json($annualRevenue);
    }
}
