<?php

namespace App\Models\admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Tour extends Model
{
    use HasFactory;
    protected $table = 'tbl_tour';

    public function inserTour($tour){
        return DB::table($this->table)->insertGetId($tour);
    }

    public function getAllTour(){
        $tours = DB::table($this->table)->paginate(8);

        foreach($tours as $tour){
            $tour->date = DB::table('tbl_start_end_date')
                            ->where('tourId', $tour->tourId)
                            ->orderBy('startDate', 'asc')
                            ->get();
        }
        return $tours;
    }

    public function getDetailTour($tourId){
        return DB::table($this->table)
                            ->where('tourId', $tourId)
                            ->first();
    }

    public function updateTour($tour){
        return DB::table($this->table)
                    ->where('tourId', $tour['tourId'])
                    ->update([
                        'title' => $tour['title'],
                        'description' => $tour['description'],
                        'destination' => $tour['destination'],
                        'domain' => $tour['domain']]);
                    
    }

    public function quantityDomain(){
        return DB::table($this->table)
            ->select('domain', DB::raw('COUNT(*) as total'))
            ->groupBy('domain')
            ->get();
    }

    public function deleteTour($tourId){
        $acStatus = DB::table($this->table)
                        ->where('tourId', $tourId)
                       ->value('acStatus');
        if($acStatus == 'y'){
            DB::table($this->table)
                ->where('tourId', $tourId)
                ->update(['acStatus'=> 'n']);
            return 'n';
        }
        else{
            DB::table($this->table)
                ->where('tourId', $tourId)
                ->update(['acStatus'=> 'y']);
            return 'y';
        }
    }


}
