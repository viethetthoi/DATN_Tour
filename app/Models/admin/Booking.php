<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'tbl_booking';

    public function getAllBooking()
    {
        $bookings = DB::table($this->table)
            ->orderBy('bookingDate', 'desc')
            ->paginate(9);

        foreach ($bookings as $booking) {
            $booking->tour = DB::table('tbl_tour')
                ->where('tourId', $booking->tourId)
                ->pluck('title');
            $booking->checkout = DB::table('tbl_checkout')
                ->where('bookingId', $booking->bookingId)
                ->value('paymentStatus');
            $booking->date = DB::table('tbl_start_end_date')
                ->where('dateId', $booking->dateId)
                ->first();
        }

        return $bookings;
    }

    // public function updateStatus($bookingId, $status){
    //     if($status == 'b'){
    //         return DB::table($this->table)
    //                     ->where('bookingId', $bookingId)
    //                     ->update(['bookingStatus' => 'y']);
    //     }
    //     elseif($status == 'y'){
    //         return DB::table($this->table)
    //                 ->where('bookingId', $bookingId)
    //                 ->update(['bookingStatus' => 'd']);
    //     }
    //     elseif($status == 'd'){
    //         return DB::table($this->table)
    //                 ->where('bookingId', $bookingId)
    //                 ->update(['bookingStatus' => 'f']);
    //     }
    // }
    public function updateStatus($bookingId, $status)
    {
        $updated = DB::table($this->table)
            ->where('bookingId', $bookingId)
            ->update(['bookingStatus' => $status]);

        if ($status === 'c') {
            DB::table('tbl_checkout')
                ->where('bookingId', $bookingId)
                ->update(['paymentStatus' => 'n']);
        }

        return $updated;
    }

    public function getStatus($bookingId)
    {
        return DB::table($this->table)
            ->where('bookingId', $bookingId)
            ->first(['bookingStatus']);
    }

    public function totalAllBooking()
    {
        return DB::table($this->table)
            ->where('bookingStatus', '<>', 'c')
            ->sum('totalPrice');
    }

    public function getAllBookingNear()
    {
        $bookings = DB::table($this->table)
            ->orderBy('bookingDate', 'desc')
            ->take(5)
            ->get();

        foreach ($bookings as $booking) {
            $booking->tour = DB::table('tbl_tour')
                ->where('tourId', $booking->tourId)
                ->pluck('title');
            $booking->checkout = DB::table('tbl_checkout')
                ->where('bookingId', $booking->bookingId)
                ->pluck('paymentStatus');
        }

        return $bookings;
    }

    public function topBookedTour()
    {
        $tours = DB::table($this->table)
            ->select('tourId', 'dateId', DB::raw('COUNT(dateId) as total_date'))
            ->groupBy('tourId', 'dateId')
            ->orderByDesc('total_date')
            ->take(5)
            ->get();

        foreach ($tours as $tour) {
            $tour->tour = DB::table('tbl_tour')
                ->where('tourId', $tour->tourId)
                ->pluck('title');
            $tour->date = DB::table('tbl_start_end_date')
                ->where('dateId', $tour->dateId)
                ->pluck('quantity');
        }
        return $tours;
    }

    public function annualRevenue($year)
    {
        $months = collect(range(1, 12))->map(function ($month) {
            return [
                'month' => $month,
                'total_revenue' => 0
            ];
        });

        $revenues = DB::table($this->table)
            ->select(DB::raw('MONTH(bookingDate) as month'), DB::raw('SUM(totalPrice) as total_revenue'))
            ->whereYear('bookingDate', $year)
            ->where('bookingStatus', '!=', 'c')
            ->groupBy(DB::raw('MONTH(bookingDate)'))
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $result = $months->map(function ($item) use ($revenues) {
            if (isset($revenues[$item['month']])) {
                $item['total_revenue'] = $revenues[$item['month']]->total_revenue;
            }
            return $item;
        });

        return $result;
    }

    public function getDetailBooking($bookingId)
    {
        $booking = DB::table($this->table)
            ->where('bookingId', $bookingId)
            ->first();
        $booking->tour = DB::table('tbl_tour')
            ->where('tourId', $booking->tourId)
            ->first();
        $booking->date = DB::table('tbl_start_end_date')
            ->where('dateId', $booking->dateId)
            ->first();
        $booking->checkout = DB::table('tbl_checkout')
            ->where('bookingId', $bookingId)
            ->first();
        return $booking;
    }

    public function updateStatusEmail($bookingId)
    {
        return DB::table($this->table)
            ->where('bookingId', $bookingId)
            ->update(['receiveEmail' => 'y']);
    }
}
