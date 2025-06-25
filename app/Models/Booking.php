<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class Booking extends Model
{
    use HasFactory;
    protected $table = 'tbl_booking';

    public function insertBooking($data){
        return DB::table($this->table)->insertGetId($data);
    }

    public function checkComment($userId, $tourId){
        return DB::table($this->table)
                    ->where('userId', $userId)
                    ->where('tourId', $tourId)
                    ->pluck('bookingStatus');
    }

    public function updateBookingStatus($bookingId){
        DB::table($this->table)
                    ->where('bookingId', $bookingId)
                    ->update(['bookingStatus' => 'c']);
        DB::table('tbl_checkout')
                    ->where('bookingId', $bookingId)
                    ->update(['paymentStatus' => 'n']);
        return true;
    }
}
