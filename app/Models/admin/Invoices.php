<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Invoices extends Model
{
    use HasFactory;
    protected $table = 'tbl_invoice';

    public function insertInvoice($invoice){
        return DB::table($this->table)->insertGetId($invoice);
    }
}
