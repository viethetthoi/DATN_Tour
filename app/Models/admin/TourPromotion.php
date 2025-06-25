<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TourPromotion extends Model
{
    use HasFactory;
    protected $table = 'tbl_tour_promotion';

    public function insertTourPromotion(array $dateIds, $proId)
    {
        $data = [];

        foreach ($dateIds as $dateId) {
            $data[] = [
                'dateId' => $dateId,
                'promotionId' => $proId,
            ];
        }

        if (!empty($data)) {
            DB::table($this->table)->insert($data);
        }

        return true;
    }

    public function getListDatePromotion($poromotionId){
        return DB::table('tbl_tour_promotion')
                    ->where('promotionId', $poromotionId)
                    ->get();
    }

    public function updateTourPromotion(array $dateIds, $proId)
{
    if (empty($dateIds)) {
        // Nếu không có dateId nào → xóa hết bản ghi của promotionId này
        DB::table('tbl_tour_promotion')
            ->where('promotionId', $proId)
            ->delete();
        return true;
    }

    // Lấy danh sách dateId hiện tại trong DB
    $currentDateIds = DB::table('tbl_tour_promotion')
                        ->where('promotionId', $proId)
                        ->pluck('dateId')
                        ->toArray();

    // Xác định dateId cần xóa (có trong DB nhưng không có trong $dateIds)
    $deleteDateIds = array_diff($currentDateIds, $dateIds);

    // Xác định dateId cần insert (có trong $dateIds nhưng chưa có trong DB)
    $insertDateIds = array_diff($dateIds, $currentDateIds);

    // Xóa các dateId thừa
    if (!empty($deleteDateIds)) {
        DB::table('tbl_tour_promotion')
            ->where('promotionId', $proId)
            ->whereIn('dateId', $deleteDateIds)
            ->delete();
        return true;
    }

    // Thêm các dateId mới
    if (!empty($insertDateIds)) {
        $insertData = [];
        foreach ($insertDateIds as $dateId) {
            $insertData[] = [
                'promotionId' => $proId,
                'dateId' => $dateId,
            ];
        }
        DB::table('tbl_tour_promotion')->insert($insertData);
    }

    return true;
}



}
