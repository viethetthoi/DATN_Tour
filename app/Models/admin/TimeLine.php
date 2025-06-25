<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TimeLine extends Model
{
    use HasFactory;
    protected $table = 'tbl_timeline';

    public function insertTimeLine($timeLines, $tourId){
        foreach($timeLines as $timeLine){
            DB::table($this->table)->insert([
                'tourId' => $tourId,             // Liên kết với tour
                'tl_title' => $timeLine['name'], // Tên thời gian line
                'tl_description' => $timeLine['description'], // Mô tả (nếu có)
            ]);
        }
        return true;
    }

    public function getAllTimeLine($tourId){
        return DB::table($this->table)
                    ->where('tourId', $tourId)
                    ->get();
    }

    public function updateTimeLine($timeLines, $tourId)
{
    $existingTimeLineIds = DB::table($this->table)
        ->where('tourId', $tourId)
        ->pluck('timeLineId')
        ->toArray();

    $incomingIds = [];
    foreach ($timeLines as $timeLine) {
        if (!empty($timeLine['timeLineId'])) {
            $incomingIds[] = $timeLine['timeLineId'];
        }
    }

    $idsToDelete = array_diff($existingTimeLineIds, $incomingIds);
    if (!empty($idsToDelete)) {
        DB::table($this->table)
            ->whereIn('timeLineId', $idsToDelete)
            ->delete();
    }

    foreach ($timeLines as $timeLine) {
        if (empty($timeLine['timeLineId'])) {
            // Insert mới
            DB::table($this->table)->insert([
                'tourId' => $tourId,
                'tl_title' => $timeLine['name'],
                'tl_description' => $timeLine['description'],
            ]);
        } else {
            // Cập nhật
            DB::table($this->table)
                ->where('timeLineId', $timeLine['timeLineId'])
                ->update([
                    'tourId' => $tourId,
                    'tl_title' => $timeLine['name'],
                    'tl_description' => $timeLine['description'],
                ]);
        }
    }

    return true;
}

}
