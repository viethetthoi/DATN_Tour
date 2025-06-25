<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\CheckOut;
use App\Models\Coupon;
use App\Models\StartEndDate;
use App\Models\Tours;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use PHPUnit\Framework\Constraint\Count;

class PayMentController extends Controller
{
    private $tour;
    private $user;
    private $booking;
    private $checkout;
    private $date;
    private $coupon;

    public function __construct()
    {
        $this->tour = new Tours();
        $this->user = new Users();
        $this->booking = new Booking();
        $this->checkout = new CheckOut();
        $this->date = new StartEndDate();
        $this->coupon = new Coupon();
    }
    public function checkOut(Request $request, $tourId){
        $userName = session()->get('userName');
        $dateId = $request->input('dateId');
        if($dateId == null){
            return redirect()->back()->with('error', 'Vui lòng chọn ngày bắt đầu');
        }
        $transIdMomo = null;
        if (!empty($userName)) {
            $inforUser = $this->user->getUser($userName);
            $detailTour = $this->tour->getDetailTour($tourId);
            $detailDate = $this->date->getAllDetailDate($dateId);
            $coupon = $this->coupon->getCouponActive();
            // dd($detailDate);
            return view('clients.check_out', compact('detailTour', 'detailDate', 'inforUser', 'transIdMomo', 'coupon'));
        } else {
            $detailTour = $this->tour->getDetailTour($tourId);
            $detailDate = $this->date->getAllDetailDate($dateId);
            $coupon = $this->coupon->getCouponActive();
            return view('clients.check_out', compact('detailTour', 'detailDate', 'transIdMomo', 'coupon'));
        }
    }

    public function createBooking(Request $request){
        $userName = session()->get('userName');
        $inforUser = $this->user->getUser($userName);
        $userId = $inforUser->userId;
        $tourId = $request->input('tourId');
        $dateId = $request->input('dateId');
        $fullName = $request->input('fullName');
        $email = $request->input('email');
        $address = $request->input('address');
        $phoneNumber = $request->input('tel');
        $numAdults = $request->input('numAdults');
        $numChildren = $request->input('numChildren');
        $paymentMethod = $request->input('payment');
        $totalPrice = $request->input('totalPrice');
        if(empty($userName)){
            return redirect()->route('loginpage');
        }

        $data_booking = [
            'tourId' => $tourId,
            'userId' => $userId,
            'dateId' => $dateId,
            'fullName' => $fullName,
            'email' => $email,
            'phoneNumber' => $phoneNumber,
            'address' => $address,
            'bookingDate' => now(),
            'numAdults' => $numAdults,
            'numChildren' => $numChildren,
            'totalPrice' => $totalPrice
        ];

       
        $bookingId = $this->booking->insertBooking($data_booking);
        $data_checkout = [
            'bookingId' => $bookingId,
            'paymentMethod' => $paymentMethod,
            'paymentDate' => now(),
            'amount' => $totalPrice,
            'paymentStatus' => ($paymentMethod === 'paypal-payment' || $paymentMethod === 'momo-payment') ? 'y' : 'n',
        ];
        if ($paymentMethod === 'paypal-payment') {
            $data_checkout['transactionId'] = $request->transactionIdPaypal;
        } elseif ($paymentMethod === 'momo-payment') {
            $data_checkout['transactionId'] = $request->transactionIdMomo;
        }
        $checkOut = $this->checkout->createCheckOut($data_checkout);

        $date = $this->date->getAllDetailDate($dateId);
        $data_update_date = [
            'dateId'=> $dateId,
            'quantity' => $date->quantity - $numAdults - $numChildren,
        ];
        $updateDate = $this->date->updateQuantityDate($data_update_date);

        if(empty($booking) && empty($checkOut) && !$updateDate){
            return redirect()->back();
        }
        return redirect()->route('my.tours')->with('success', 'Đã đặt thành công, đang chờ xác nhận');

    }

    public function createMomoPayment(Request $request)
    {
        session()->put('tourId', $request->tourId);
        $totalPrice = $request->amount;
        $orderId = $request->input('orderId');
        $bookingData = json_decode($request->input('bookingData'), true);
        Session::put('bookingData', $bookingData); 
        try {
            $amount = 10000;
            // $totalPrice;
    
            // Các thông tin cần thiết của MoMo
            $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
            $partnerCode = "MOMOBKUN20180529"; // mã partner của bạn
            $accessKey = "klm05TvNBzhg7h7j"; // access key của bạn
            $secretKey = "at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa"; // secret key của bạn
    
            $orderInfo = "Thanh toán đơn hàng";
            $requestId = time();
            $orderId = time();
            $extraData = "";
            $redirectUrl = "http://127.0.0.1:8000/booking" ; // URL chuyển hướng
            $ipnUrl = "http://127.0.0.1:8000/booking"; // URL IPN
            $requestType = 'payWithATM'; // Kiểu yêu cầu
    
            // Tạo rawHash và chữ ký theo cách thủ công
            $rawHash = "accessKey=" . $accessKey . 
                       "&amount=" . $amount . 
                       "&extraData=" . $extraData . 
                       "&ipnUrl=" . $ipnUrl . 
                       "&orderId=" . $orderId . 
                       "&orderInfo=" . $orderInfo . 
                       "&partnerCode=" . $partnerCode . 
                       "&redirectUrl=" . $redirectUrl . 
                       "&requestId=" . $requestId . 
                       "&requestType=" . $requestType;
    
            // Tạo chữ ký
            $signature = hash_hmac("sha256", $rawHash, $secretKey);
    
            // Dữ liệu gửi đến MoMo
            $data = [
                'partnerCode' => $partnerCode,
                'partnerName' => "Test", // Tên đối tác
                'storeId' => "MomoTestStore", // ID cửa hàng
                'requestId' => $requestId,
                'amount' => $amount,
                'orderId' => $orderId,
                'orderInfo' => $orderInfo,
                'redirectUrl' => $redirectUrl,
                'ipnUrl' => $ipnUrl,
                'lang' => 'vi',
                'extraData' => $extraData,
                'requestType' => $requestType,
                'signature' => $signature
            ];
    
            // Gửi yêu cầu POST đến MoMo để tạo yêu cầu thanh toán
            $response = Http::post($endpoint, $data);
    
            if ($response->successful()) {
                $body = $response->json();
                if (isset($body['payUrl'])) {
                    return response()->json(['payUrl' => $body['payUrl']]);
                } else {
                    // Trả về thông tin lỗi trong response nếu không có 'payUrl'
                    return response()->json(['error' => 'Invalid response from MoMo', 'details' => $body], 400);
                }
            } else {
                // Trả về thông tin lỗi trong response nếu lỗi kết nối
                return response()->json(['error' => 'Lỗi kết nối với MoMo', 'details' => $response->body()], 500);
            }
        } catch (\Exception $e) {
            // Trả về chi tiết ngoại lệ trong response
            return response()->json(['error' => 'Đã xảy ra lỗi', 'message' => $e->getMessage(), 'trace' => $e->getTraceAsString()], 500);
        }
    }
    

    public function handlePaymentMomoCallback(Request $request)
    {
        try {
            // Lấy dữ liệu từ query string
            $resultCode = $request->query('resultCode');
            $orderId = $request->query('orderId');
            $transId = $request->query('transId');
            if (!$orderId) {
                // \Log::error('Missing orderId in MoMo callback');
                return response()->json(['error' => 'Lỗi: Thiếu orderId.'], 400);
            }
    
            // Lấy bookingData từ session
            $bookingData = Session::get('bookingData');
            $userName = session()->get('userName');
            $inforUser = $this->user->getUser($userName);
            $userId = $inforUser->userId;
            $tourId = $bookingData['tourId'];
            $dateId = $bookingData['dateId'];
            $fullName = $bookingData['fullName'];
            $email = $bookingData['email'];
            $address = $bookingData['address'];
            $phoneNumber = $bookingData['tel'];
            $numAdults = $bookingData['numAdults'];
            $numChildren = $bookingData['numChildren'];
            $paymentMethod = $bookingData['payment'];
            $totalPrice = $bookingData['totalPrice'];

            $data_booking = [
                'tourId' => $tourId,
                'userId' => $userId,
                'dateId' => $dateId,
                'fullName' => $fullName,
                'email' => $email,
                'phoneNumber' => $phoneNumber,
                'address' => $address,
                'bookingDate' => now(),
                'numAdults' => $numAdults,
                'numChildren' => $numChildren,
                'totalPrice' => $totalPrice
            ];

        
            $bookingId = $this->booking->insertBooking($data_booking);
            $data_checkout = [
                'bookingId' => $bookingId,
                'paymentMethod' => $paymentMethod,
                'paymentDate' => now(),
                'amount' => $totalPrice,
                'paymentStatus' => ($paymentMethod === 'paypal-payment' || $paymentMethod === 'momo-payment') ? 'y' : 'n',
                'transactionId' => $transId
            ];
           
            $checkOut = $this->checkout->createCheckOut($data_checkout);

            $date = $this->date->getAllDetailDate($dateId);
            $data_update_date = [
                'dateId'=> $dateId,
                'quantity' => $date->quantity - $numAdults - $numChildren,
            ];
            $updateDate = $this->date->updateQuantityDate($data_update_date);
            if(empty($booking) && empty($checkOut) && !$updateDate){
                return redirect()->back();
            }
            return redirect()->route('my.tours')->with('success', 'Đã đặt thành công, đang chờ xác nhận');
           
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Lỗi xử lý thanh toán', 'message' => $e->getMessage()], 500);
        }
    }
}
