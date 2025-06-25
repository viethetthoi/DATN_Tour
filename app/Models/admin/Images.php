<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Images extends Model
{
    use HasFactory;
    protected $table = 'tbl_images';

    public function insertImage($images, $tourId){
        foreach($images as $image){
            DB::table($this->table)->insert([
                'tourId' => $tourId,  // Liên kết với tour
                'imageURL' => $image,  // Tên file đã được lưu trữ
                'uploadDate' => now(),  // Thời gian cập nhật
            ]);
        }
        return true;
    }
}
