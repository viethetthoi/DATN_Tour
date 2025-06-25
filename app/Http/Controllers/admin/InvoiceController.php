<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\Booking;
use App\Models\admin\Invoices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{
    private $booking;
    private $invoice;
    public function __construct()
    {
        $this->booking = new Booking();
        $this->invoice = new Invoices();
    }

    public function receiveEmail($bookingId){
        $invoice = $this->booking->getDetailBooking($bookingId);
        try {
            Mail::send('admin.email.invoice', compact('invoice'), function ($message) use ($invoice) {
                $message->to($invoice->email)
                    ->subject('Hóa đơn đặt tour của khách hàng ' . $invoice->fullName);
            });
            $data_invoice = [
                'bookingID' => $invoice->bookingId,
                'amount' => $invoice->totalPrice,
                'dateIssued' =>now()
            ];
            $checkinvoice = $this->invoice->insertInvoice($data_invoice);
            $status = $this->booking->updateStatusEmail($bookingId);
            return redirect()->back()
            ->with('success', 'Hóa đơn đã được gửi qua email thành công.');
        } catch (\Exception $e) {
            return redirect()->back()
            ->with('error', 'Hóa đơn đã được gửi qua email thất bại.');
        }
    }
}
