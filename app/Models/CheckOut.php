<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


class CheckOut extends Model
{
    use HasFactory;
    protected $table = "tbl_checkout";

    public function createCheckOut($data){
        return DB::table($this->table)->insertGetId($data);
    }
}
