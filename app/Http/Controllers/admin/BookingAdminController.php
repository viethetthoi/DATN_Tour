<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Booking;
use App\Models\admin\Checkout;
use Illuminate\Http\Request;

class BookingAdminController extends Controller
{
    private $booking;
    private $checkout;

    public function __construct()
    {
        $this->booking = new Booking();
        $this->checkout = new Checkout();
    }

    public function viewListBooking()
    {
        $bookings = $this->booking->getAllBooking();
        // dd($bookings);
        return view('admin.list-booking', compact('bookings'));
    }

    // public function updateStatustBooking($bookingId, $status){
    // if ($status === 'n') {
    //     $check_checkout = $this->checkout->updatePaymentStatus($bookingId);
    //     if ($check_checkout) {
    //         return redirect()->route('admin-list-booking')
    //             ->with('success', 'Đã thanh toán thành công (bookingId = ' . $bookingId . ')');
    //     }
    //     return redirect()->back()
    //         ->with('error', 'Thanh toán không thành công (bookingId = ' . $bookingId . ')');
    // }

    // if (in_array($status, ['b', 'y', 'd'])) {
    //     $checkbooking = $this->booking->updateStatus($bookingId, $status);
    //     if ($checkbooking) {
    //         $statusInfo = $this->booking->getStatus($bookingId);
    //         $statusKey = is_object($statusInfo) && isset($statusInfo->bookingStatus) ? $statusInfo->bookingStatus : '';

    //         $statusMessages = [
    //             // 'b' => 'Chuyển sang trạng thái đã đặt chỗ (bookingId = ' . $bookingId . ')',
    //             'y' => 'Chuyển sang trạng thái sắp khởi hành (bookingId = ' . $bookingId . ')',
    //             'd' => 'Chuyển sang trạng thái đang khởi hành (bookingId = ' . $bookingId . ')',
    //             'f' => 'Chuyển sang trạng thái đã hoàn thành tour (bookingId = ' . $bookingId . ')',
    //         ];

    //         $message = $statusMessages[$statusKey] ?? 'Cập nhật trạng thái booking thành công (bookingId = ' . $bookingId . ')';

    //         return redirect()->route('admin-list-booking')->with('success', $message);
    //     }

    //     return redirect()->back()
    //         ->with('error', 'Cập nhật trạng thái booking không thành công (bookingId = ' . $bookingId . ')');
    // }

    // return redirect()->back()
    //     ->with('error', 'Trạng thái không hợp lệ (bookingId = ' . $bookingId . ')');
    // }
    public function updateStatustBooking(Request $request)
    {
        $bookingId = $request->input('bookingId');
        $status = $request->input('status');
        $checkStatus = $this->booking->updateStatus($bookingId, $status);

        if ($checkStatus) {
            switch ($status) {
                case 'b':
                    return redirect()->route('admin-list-booking')
                        ->with('success', 'Chuyển sang trạng thái Đợi xác nhận (bookingId = ' . $bookingId . ')');
                case 'y':
                    return redirect()->route('admin-list-booking')
                        ->with('success', 'Chuyển sang trạng thái đã duyệt (bookingId = ' . $bookingId . ')');
                case 'f':
                    return redirect()->route('admin-list-booking')
                        ->with('success', 'Chuyển sang trạng thái Hoàn thành (bookingId = ' . $bookingId . ')');
                case 'c':
                    return redirect()->route('admin-list-booking')
                        ->with('success', 'Chuyển sang trạng thái Đã hủy (bookingId = ' . $bookingId . ')');
                case 'd':
                    return redirect()->route('admin-list-booking')
                        ->with('success', 'Chuyển sang trạng thái Đang khởi hành (bookingId = ' . $bookingId . ')');
                default:
                    return redirect()->route('admin-list-booking')
                        ->with('warning', 'Trạng thái không hợp lệ (bookingId = ' . $bookingId . ')');
            }
        }

        return redirect()->route('admin-list-booking')
            ->with('error', 'Cập nhật trạng thái thất bại (bookingId = ' . $bookingId . ')');
    }
    public function updateStatustPayment($bookingId, $status){
        if ($status === 'n') {
            $check_checkout = $this->checkout->updatePaymentStatus($bookingId);
            if ($check_checkout) {
                return redirect()->route('admin-list-booking')
                    ->with('success', 'Đã thanh toán thành công (bookingId = ' . $bookingId . ')');
            }
            return redirect()->back()
                ->with('error', 'Thanh toán không thành công (bookingId = ' . $bookingId . ')');
        }
    }
}
