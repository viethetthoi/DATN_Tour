<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Coupon;
use Illuminate\Http\Request;

class CouponAdminController extends Controller
{
    private $coupon;

    public function __construct()
    {
        $this->coupon = new Coupon();
    }

    public function viewListCoupon(){
        $coupons = $this->coupon->getAllCoupon();
        return view('admin.list-coupon', compact('coupons'));
    }

    public function editStatusCoupon($status,$couponID){
        if ($status == 'n') {
            if ($this->coupon->checkAcStatus() == false) {
                $this->coupon->updateStatus($couponID);
                return redirect()->route('admin-list-coupon')->with('success', 'Đã kích hoạt phiếu giảm giá');
            } else {
                return redirect()->route('admin-list-coupon')->with('error', 'Đã có phiếu khuyến mãi khác đang hoạt động!');
            }
        }
        $this->coupon->updateStatus($couponID);
        return redirect()->route('admin-list-coupon')->with('error', 'Phiếu giảm giá đã hết hoạt động');
    }

    public function viewAddCoupon()
    {
        $randomCode = $this->generateRandomCode(10); // gọi hàm tạo mã
        return view('admin.add-coupon', compact('randomCode'));
    }

    private function generateRandomCode($length = 10){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle(str_repeat($characters, ceil($length / strlen($characters)))), 0, $length);
    }

    public function addCoupon(Request $request){
        $codeCoupon = $request->input('code');
        $description = $request->input('description');
        $discount = $request->input('discount');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if(strtotime($startDate) >= strtotime($endDate)){
            return redirect()->back()->with('error', 'Vui lòng chọn lại ngày bắt đầu!!');
        }
        $data_coupon = [
            'title' => $description,
            'codeCoupon' => $codeCoupon,
            'discount' => $discount,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];
        // dd($data_coupon);
        $check = $this->coupon->insertCoupon($data_coupon);
        
        if($check == true){
            return redirect()->route('admin-list-coupon')->with('success', 'Đã thêm thành công');
        }
        return redirect()->back()->with('error', 'Thông báo lỗi!!');
        // dd($date_promotion);
    }

    public function viewEditCoupon($couponID){
        $coupon = $this->coupon->getDetailCoupon($couponID);
        return view('admin.edit-coupon', compact('coupon'));
    }

    public function editCoupon(Request $request, $couponId){
        $codeCoupon = $request->input('code');
        $description = $request->input('description');
        $discount = $request->input('discount');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if(strtotime($startDate) >= strtotime($endDate)){
            return redirect()->back()->with('error', 'Vui lòng chọn lại ngày bắt đầu!!');
        }
        $data_coupon = [
            'title' => $description,
            'codeCoupon' => $codeCoupon,
            'discount' => $discount,
            'startDate' => $startDate,
            'endDate' => $endDate
        ];
        // dd($data_coupon);
        $check = $this->coupon->updateCoupon($data_coupon, $couponId);
        
        if($check == true){
            return redirect()->route('admin-edit-coupon', ['couponId' => $couponId])->with('success', 'Đã cập nhật thành công');
        }
        return redirect()->back()->with('error', 'Thông báo lỗi!!');
        // dd($date_promotion);
    }

}
