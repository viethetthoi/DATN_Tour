<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/check-out-css.css') }}">
    <link rel="shortcut icon" href="{{ asset('/public/clients/assets/images/logos/lolo1.png') }}" type="image/x-icon">
    <!-- Google Fonts -->
     <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
     
     <!-- Flaticon -->
     <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/flaticon.min.css') }}">
     <!-- Font Awesome -->
     <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/fontawesome-5.14.0.min.css') }}">
     <!-- Bootstrap -->
     <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/bootstrap.min.css') }}">
     <!-- Magnific Popup -->
     <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/magnific-popup.min.css') }}">
     <!-- Nice Select -->
     <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/nice-select.min.css') }}">
     <!-- Animate -->
     <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/aos.css') }}">
     <!-- Slick -->
     <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/slick.min.css') }}">
     <!-- Main Style -->
     <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/style.css') }}">
     <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/custom-css.css') }}">
     <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>      
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            @if (session('error'))
                toastr.error("{{ session('error') }}");
            @endif
          
            @if (session('success'))
                toastr.success("{{ session('success') }}");
            @endif
        });
    </script>
</head>

<body>
    @include('clients.blocks.headerpage')
    <section class="container" >
        <h1 class="text-center booking-header">Đặt tour</h1>

        <form action="{{ route('create-booking') }}" method="POST" class="booking-container">
            @csrf
            <div class="booking-info">
                <h2 class="booking-header">Thông Tin Liên Lạc</h2>
                <div class="booking__infor">
                    <div class="form-group">
                        <label for="username">Họ và tên*</label>
                        <input type="text" id="username" placeholder="Nhập Họ và tên" name="fullName" value="{{ isset($inforUser->fullName) ? $inforUser->fullName : '' }}" required>
                        <span class="error-message" id="usernameError"></span>
                    </div>

                    <div class="form-group">
                        <label for="email">Email*</label>
                        <input type="email" id="email" placeholder="sample@gmail.com" name="email" value="{{ isset($inforUser->email) ? $inforUser->email : '' }}" required>
                        <span class="error-message" id="emailError"></span>
                    </div>

                    <div class="form-group">
                        <label for="tel">Số điện thoại*</label>
                        <input type="text" id="tel" placeholder="Nhập số điện thoại liên hệ" name="tel" value="{{ isset($inforUser->phoneNumber) ? $inforUser->phoneNumber : '' }}" required>
                        <span class="error-message" id="telError"></span>
                    </div>

                    <div class="form-group">
                        <label for="address">Địa chỉ*</label>
                        <input type="text" id="address" placeholder="Nhập địa chỉ liên hệ" name="address" value="{{ isset($inforUser->address) ? $inforUser->address : '' }}" required>
                        <span class="error-message" id="addressError"></span>
                    </div>

                </div>


                <h2 class="booking-header">Hành Khách</h2>
                 @php
                    $now = \Carbon\Carbon::now()->startOfDay();
                    $startDate = \Carbon\Carbon::parse($detailDate->promotion->startDate)->startOfDay();
                    $endDate = \Carbon\Carbon::parse($detailDate->promotion->endDate)->endOfDay();
                
                    $isInPromotionPeriod = ($now->between($startDate, $endDate));
                
                    $discount = 0;
                    $priceAdult = $detailDate->priceAdult;
                    $priceChildren = $detailDate->priceChildren;
                
                    if ($isInPromotionPeriod && isset($detailDate->promotion)) {
                        $discount = $detailDate->promotion->discount ?? 0;
                        $priceAdult = ($detailDate->priceAdult * (100 - $discount)) / 100;
                        $priceChildren = ($detailDate->priceChildren * (100 - $discount)) / 100;
                    }
                @endphp
                
                <div class="booking__quantity">
                    <div class="form-group quantity-selector">
                        <label>Người lớn</label>
                        <div class="input__quanlity">
                            <button type="button" class="quantity-btn">-</button>
                            <input type="number" class="quantity-input" value="1" min="1" id="numAdults"
                                name="numAdults" data-price-adults="{{ $priceAdult }}" style="width: 60px;" readonly>
                            <button type="button" class="quantity-btn">+</button>
                        </div>
                    </div>
                
                    <div class="form-group quantity-selector">
                        <label>Trẻ em</label>
                        <div class="input__quanlity">
                            <button type="button" class="quantity-btn">-</button>
                            <input type="number" class="quantity-input" value="0" min="0" id="numChildren"
                                name="numChildren" data-price-children="{{ $priceChildren }}" style="width: 60px;" readonly>
                            <button type="button" class="quantity-btn">+</button>
                        </div>
                    </div>
                </div>
       
                <!-- Privacy Agreement Section -->
                <div class="privacy-section">
                    <p>Bằng cách nhấp chuột vào nút "ĐỒNG Ý" dưới đây, Khách hàng đồng ý rằng các điều kiện điều khoản
                        này sẽ được áp dụng. Vui lòng đọc kỹ điều kiện điều khoản trước khi lựa chọn sử dụng dịch vụ của
                        Lửa Việt Tours.</p>
                    <div class="privacy-checkbox">
                        <input type="checkbox" id="agree" name="agree" required>
                        <label for="agree">Tôi đã đọc và đồng ý với <a href="#" target="_blank">Điều khoản thanh
                                toán</a></label>
                    </div>
                </div>
                <!-- Payment Method -->
                <h2 class="booking-header">Phương Thức Thanh Toán</h2>

                <label class="payment-option">
                    <input type="radio" name="payment" value="office-payment" id="payment" required>
                    <img src="{{ asset('/public/clients/assets/images/contact/icon.png') }}" alt="Office Payment">
                    Thanh toán tại văn phòng
                </label>
                <label class="payment-option">
                    <input type="radio" name="payment" value="momo-payment" required>
                    <img src="{{ asset('/public/clients/assets/images/booking/thanh-toan-momo.jpg') }}" alt="MoMo">
                    Thanh toán bằng Momo
                    @if (!is_null($transIdMomo))
                        <input type="hidden" name="transactionIdMomo" value="{{ $transIdMomo }}">
                    @endif
                </label>
    
                <input type="hidden" name="payment_hidden" id="payment_hidden">
            </div>

            <!-- Order Summary -->
            <div class="booking-summary">
                <div class="summary-section">
                    <div>
                        <p>Mã tour: {{ $detailTour->tourId }} </p>
                        <input type="hidden" name="tourId" id="tourId" value="{{ $detailTour->tourId }}">
                        <input type="hidden" name="dateId" id="dateId" value="{{ $detailDate->dateId }}">
                        <h5 class="widget-title">{{ $detailTour->title }}</h5>
                        <p>Ngày khởi hành: {{ \Carbon\Carbon::parse($detailDate->startDate)->format('d/m/Y') }}</p>
                        <p>Ngày kết thúc: {{ \Carbon\Carbon::parse($detailDate->endDate)->format('d/m/Y') }}</p>

                        {{-- <p class="quantityAvailable">Số chỗ còn nhận: {{ $detailTour->quantity }} </p> --}}
                        <span id="remainingSlots" data-slots="{{ $detailDate->quantity }}">Số chỗ còn nhận: {{ $detailDate->quantity }}</span>

                    </div>

                    <input type="hidden" name="codeCoupon" id="codeCoupon" value="{{ $coupon->codeCoupon ?? null }}">
                    <input type="hidden" name="discount" id="discount" value="{{ $coupon->discount ?? null }}">

    
                    <div class="order-summary">
                        <div class="summary-item">
                            <span>Người lớn:</span>
                            <div>
                                <span class="quantity__adults">1</span>
                                <span>X</span>
                                <span class="total-price">0 VNĐ</span>
                            </div>
                        </div>
                        <div class="summary-item">
                            <span>Trẻ em:</span>
                            <div>
                                <span class="quantity__children">0</span>
                                <span>X</span>
                                <span class="total-price">0 VNĐ</span>
                            </div>
                        </div>
                        <div class="summary-item">
                            <span>Giảm giá:</span>
                            <div>
                                <span class="total-price">0 VNĐ</span>
                            </div>
                        </div>
                        <div class="summary-item total-price">
                            <span>Tổng cộng:</span>
                            <span class="final-total-display">0 VNĐ</span> <!-- Thêm class rõ ràng -->
                            <input type="hidden" class="totalPrice" name="totalPrice" id="totalPrice" value="">
                        </div>
                    </div>
                    <div class="order-coupon">
                        <input type="text" placeholder="Mã giảm giá" style="width: 65%;">
                        <button style="width: 30%" class="booking-btn btn-coupon">Áp dụng</button>
                    </div>
    
                    <div id="paypal-button-container"></div>

                <button type="submit" class="booking-btn btn-submit-booking">Xác Nhận</button>

                <button id="btn-momo-payment" class="booking-btn" style="display: none;" 
                    data-urlmomo = "{{ route('createMomoPayment') }}">Thanh toán với Momo <img src="{{ asset('/public/clients/assets//images/booking/icon-thanh-toan-momo.png') }}" alt="" style="width: 10%"></button>
                </div>
            </div>
            <script src="{{ asset('/public/clients/assets/js/check-out-js.js') }}"></script>
            </form>
    </section>
</body>

 <script src="{{ asset('/public/clients/assets/js/bootstrap.min.js') }}"></script>
 <!-- Appear Js -->
 <script src="{{ asset('/public/clients/assets/js/appear.min.js') }}"></script>
 <!-- Slick -->
 <script src="{{ asset('/public/clients/assets/js/slick.min.js') }}"></script>
 <!-- Magnific Popup -->
 <script src="{{ asset('/public/clients/assets/js/jquery.magnific-popup.min.js') }}"></script>
 <!-- Nice Select -->
 <script src="{{ asset('/public/clients/assets/js/jquery.nice-select.min.js') }}"></script>
 <!-- Image Loader -->
 <script src="{{ asset('/public/clients/assets/js/imagesloaded.pkgd.min.js') }}"></script>
 <!-- Skillbar -->
 <script src="{{ asset('/public/clients/assets/js/skill.bars.jquery.min.js') }}"></script>
 <!-- Isotope -->
 <script src="{{ asset('/public/clients/assets/js/isotope.pkgd.min.js') }}"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
 <!--  AOS Animation -->
 <script src="{{ asset('/public/clients/assets/js/aos.js') }}"></script>
 <!-- Custom script -->
 <script src="{{ asset('/public/clients/assets/js/script.js') }}"></script>
 <script src="{{ asset('/public/clients/assets/js/custom-js.js') }}"></script>

 <script src="{{ asset('/public/clients/assets/js/header-js.js') }}"></script>

</html>