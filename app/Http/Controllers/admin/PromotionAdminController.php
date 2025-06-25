<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Promotion;
use App\Models\admin\StartEndDate;
use App\Models\admin\Tour;
use App\Models\admin\TourPromotion;

class PromotionAdminController extends Controller
{
    private $promotion;
    private $tour;
    private $date;
    private $tourPro;
    public function __construct()
    {
        $this->promotion = new Promotion();
        $this->tour = new Tour();
        $this->date = new StartEndDate();
        $this->tourPro = new TourPromotion();
    }
    public function viewListPromotion(){
        $promotions = $this->promotion->getAllPromotion();
        return view('admin.list_promotion', compact('promotions'));
    }

    public function viewAddPromotion(){
        return view('admin.add-promotion');
    }

    public function viewAddTourPromotion(){
        return view('admin.add-tour-in-promotion');
    }

    public function addPromotion(Request $request){
        $description = $request->input('description');
        $discount = $request->input('discount');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if(strtotime($startDate) >= strtotime($endDate)){
            return redirect()->back()->with('error', 'Vui lòng chọn lại ngày bắt đầu!!');
        }
        $date_promotion = [
            'description' => $description,
            'discount' => $discount,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];
        $checkPromotion = $this->promotion->insertPromotion($date_promotion);
        if($checkPromotion != null){
            $promotion = $this->promotion->getDetailPromotion($checkPromotion);
            $listDateTour = $this->date->getListDateTour($startDate, $endDate);
            return view('admin.add-tour-in-promotion', compact('promotion', 'listDateTour'));
        }
        return redirect()->back();
        // dd($date_promotion);
    }

    public function addTourPromotion(Request $request){
        $proId = $request->input('proId');
        $dateIds = $request->input('title');
        
        $check = $this->tourPro->insertTourPromotion($dateIds, $proId);

        if($check == true){
            return redirect()->route('admin-list-promotion')->with('success', 'Thêm khuyến mãi thành công');
        }
        return redirect()->back();
    }

    public function viewEditPromotion($poromotionId){
        $promotion = $this->promotion->getDetailPromotion($poromotionId);
        return view('admin.edit-promotion', compact('promotion'));
    }

    public function editPromotion(Request $request, $poromotionId){
        $description = $request->input('description');
        $discount = $request->input('discount');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if(strtotime($startDate) >= strtotime($endDate)){
            return redirect()->back()->with('error', 'Vui lòng chọn lại ngày bắt đầu!!');
        }
        $date_promotion = [
            'promotionId' => $poromotionId,
            'description' => $description,
            'discount' => $discount,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];
        $checkPromotion = $this->promotion->updatePromotion($date_promotion);
        if($checkPromotion >= 0){
            return redirect()->route('admin-edit-promotion',['promotionId' => $poromotionId])->with('success', 'Đã cập nhật khuyến mãi thành công');
        }
        return redirect()->back()->with('error', 'Thông báo lỗi!!');
    }

    public function viewEditTourPromotion($promotionId){
        $promotion = $this->promotion->getDetailPromotion($promotionId);
        $listDatePromotion = $this->tourPro->getListDatePromotion($promotionId);
        $listDateTour = $this->date->getListDateTour($promotion->startDate, $promotion->endDate);
        $arrMatched = [];
        $arrUnmatched = [];
        $arrNotInTour = [];

        $promotionDateIds = $listDatePromotion->pluck('dateId')->toArray();
        $tourDateIds = $listDateTour->pluck('dateId')->toArray();

        foreach ($listDateTour as $tourDate) {
            if (in_array($tourDate->dateId, $promotionDateIds)) {
                $arrMatched[] = $tourDate;   
            } else {
                $arrUnmatched[] = $tourDate;  
            }
        }

        foreach ($promotionDateIds as $promotionDateId) {
            if (!in_array($promotionDateId, $tourDateIds)) {
                $arrNotInTour[] = $this->date->getDetailDateTour($promotionDateId);
            }
        }

        return view('admin.edit-tour-promotion', compact('promotion', 'arrMatched', 'arrUnmatched', 'arrNotInTour'));
    }

    public function editTourPromotion(Request $request, $promotionId){
        $dateIds = $request->input('title', []);
        // dd($dateIds);
        $check = $this->tourPro->updateTourPromotion($dateIds, $promotionId);
        // dd($check);
        if($check == true){
            return redirect()->route('admin-edit-tour-promotion', ['promotionId' => $promotionId])->with('success', 'cập nhật thông tin thành công!!');
        }
        return redirect()->back()->with('error', 'Thông báo lỗi!!!');
    }

    public function updateStatusPromotion($promotionId, $status){
        if($status == 'n'){
            if($this->promotion->checkAcStatus() == false){
                $checkstatus = $this->promotion->updateStatus($promotionId);
                // if($checkstatus == 'y'){
                    return redirect()->route('admin-list-promotion')->with('success', 'Khuyến mãi bắt đầu hoạt động!!!');    
                // }
            }
            return redirect()->route('admin-list-promotion')->with('error', 'Đã có khuyến mãi khác đang hoạt động!');
        }
        $checkstatus = $this->promotion->updateStatus($promotionId);
        // if($checkstatus == 'n'){
            return redirect()->route('admin-list-promotion')->with('error', 'Khuyến mãi đã hết hạn!!!');
        // }
        // return redirect()->route('admin-list-promotion')->with('success', 'Khuyến mãi bắt đầu hoạt động!!!');    
    }
}
