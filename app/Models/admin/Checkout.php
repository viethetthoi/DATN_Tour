<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Checkout extends Model
{
    use HasFactory;
    protected $table = 'tbl_checkout';

    public function updatePaymentStatus($bookingId){
        return DB::table($this->table)
                    ->where('bookingId', $bookingId)
                    ->update(['paymentStatus' => 'y']);
    }
}
