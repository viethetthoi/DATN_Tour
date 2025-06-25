<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StartEndDate extends Model
{
    use HasFactory;
    protected $table = 'tbl_start_end_date';

    public function insertDate($dates, $tourId){
        foreach($dates as $date){
            DB::table($this->table)->insert([
                'tourId' => $tourId,             // Liên kết với tour
                'startDate' => $date['start_date'],
                'endDate' => $date['end_date'],
                'priceAdult' => $date['adult_price'],
                'priceChildren' => $date['child_price'],
                'quantity' => $date['quantity'],
                'availability' => 0
            ]);
        }
        return true;
    }

    public function getAllDate($tourId) {
    return DB::table($this->table)
        ->where('tourId', $tourId)
        ->whereDate('startDate', '>', now()->toDateString()) // chỉ lấy ngày bắt đầu từ hôm nay trở đi
        ->orderBy('startDate', 'asc')
        ->get();
}


   public function updateDate($dates, $tourId){
    $existingDateIds = DB::table($this->table)
                         ->where('tourId', $tourId)
                         ->whereDate('startDate', '>', now()->toDateString())
                         ->pluck('dateId')   // Lấy danh sách dateId hiện có
                         ->toArray();

    $newDateIds = [];
    foreach ($dates as $date) {
        if (!empty($date['dateId'])) {
            $newDateIds[] = $date['dateId'];
        }
    }

    $dateIdsToDelete = array_diff($existingDateIds, $newDateIds);
    if (!empty($dateIdsToDelete)) {
        DB::table($this->table)
            ->whereIn('dateId', $dateIdsToDelete)
            ->delete();
    }

    foreach ($dates as $date) {
        if (empty($date['dateId'])) {
            // Thêm mới
            DB::table($this->table)->insert([
                'tourId' => $tourId,
                'startDate' => $date['start_date'],
                'endDate' => $date['end_date'],
                'priceAdult' => $date['adult_price'],
                'priceChildren' => $date['child_price'],
                'quantity' => $date['quantity'],
                'availability' => 0,
            ]);
        } else {
            // Cập nhật
            DB::table($this->table)
                ->where('dateId', $date['dateId'])
                ->update([
                    'tourId' => $tourId,
                    'startDate' => $date['start_date'],
                    'endDate' => $date['end_date'],
                    'priceAdult' => $date['adult_price'],
                    'priceChildren' => $date['child_price'],
                    'quantity' => $date['quantity'],
                    'availability' => 0,
                ]);
        }
    }

    return true;
}


    public function getListDateTour($startDate, $endDate){
        $dates = DB::table($this->table)
                    ->whereBetween('startDate', [$startDate, $endDate])
                    ->get();
        foreach($dates as $date){
            $date->tour = DB::table('tbl_tour')
                            ->where('tourId', $date->tourId)
                            ->pluck('title');
        }

        return $dates;
    
    }

    public function getDetailDateTour($dateId){
        $date = DB::table($this->table)
                    ->where('dateId',$dateId)
                    ->first();
        $date->tour = DB::table('tbl_tour')
                        ->where('tourId', $date->tourId)
                        ->pluck('title');
        return $date;
    
    }
}
