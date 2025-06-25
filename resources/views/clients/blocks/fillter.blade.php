<form action="{{ route('search') }}" method="post">
    <section class="hero-area bgc-black pt-200 rpt-120 rel z-2">
        <div class="container-fluid position-relative" style="height: 110vh; overflow: hidden;">
    <!-- Ảnh nền -->
   <div class="main-hero-image bgs-cover position-absolute w-100 h-100" style="
    background-image: url('{{ asset('/public/clients/assets/images/hero/ss.jpg') }}');
    background-size: cover;
    background-position: center;
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    margin: 0;
    padding: 0;
    z-index: 0;
"></div>

    <!-- Logo và tiêu đề -->
    <div class="position-relative text-center py-4" style="z-index: 2;">
        <h1 class="hero-title" data-aos="flip-up" data-aos-delay="50" data-aos-duration="1500" data-aos-offset="50">
            <a href="{{ route('homepage') }}">
                <img src="{{ asset('/public/clients/assets/images/logos/lolo1.png') }}" width="180" height="180" alt="Logo" title="Logo">
            </a>
            <span style="color: white;">VI VU</span>
        </h1>
    </div>

    <!-- Tiêu đề trung tâm và coupon -->
    <div class="position-absolute top-50 start-50 translate-middle text-center" style="z-index: 2;">
        <h2 class="text-white text-center px-3 responsive-heading" style="color: #fff; text-shadow: 0px 2px 6px rgba(0,0,0,0.5); width: 1500px; margin: 0 auto;">
            Bạn chỉ sống một lần<br>
            hãy làm cho nó đáng nhớ bằng những chuyến đi không thể quên.
        </h2>

        @if (!empty($coupon) && \Carbon\Carbon::now()->lte(\Carbon\Carbon::parse($coupon->endDate)))
                <div class="coupon-card mt-4 mx-auto">
                    <div class="coupon-title">{{ $coupon->title }}</div>
                    <div class="coupon-info"><span class="coupon-label">Mã:</span> {{ $coupon->codeCoupon }}</div>
                    <div class="coupon-info">
                        <span class="coupon-label">Giá trị:</span>
                        <span class="coupon-value">{{ number_format($coupon->discount, 0, ',', '.') }}₫</span>
                    </div>
                    <div class="coupon-info">
                        <span class="coupon-label">Bắt đầu:</span> {{ \Carbon\Carbon::parse($coupon->startDate)->format('d/m/Y') }}
                    </div>
                    <div class="coupon-info">
                        <span class="coupon-label">Kết thúc:</span> {{ \Carbon\Carbon::parse($coupon->endDate)->format('d/m/Y') }}
                    </div>
                </div>
        @endif

        
    </div>

    <style>
        .coupon-card {
            border: 2px dashed #28a745;
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
            max-width: 400px;
            background-color: #f9f9f9;
            font-family: Arial, sans-serif;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }

        .coupon-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #28a745;
            margin-bottom: 10px;
        }

        .coupon-info {
            margin-bottom: 8px;
        }

        .coupon-label {
            font-weight: bold;
            color: #333;
        }

        .coupon-value {
            color: #e53935;
            font-weight: bold;
        }
        .responsive-heading {
    max-width: 90vw; /* không tràn ra khỏi màn hình */
    margin: 0 auto;
    text-shadow: 0px 2px 6px rgba(0, 0, 0, 0.5);
    font-size: 2rem; /* cỡ chữ lớn vừa */
    line-height: 1.4;
    word-wrap: break-word;
}

@media (max-width: 768px) {
    .responsive-heading {
        font-size: 1.5rem;
    }
}

@media (max-width: 480px) {
    .responsive-heading {
        font-size: 1.2rem;
    }
}

    </style>
</div>

        <div class="container container-1000">
            <div class="search-filter-inner" data-aos="zoom-out-down" data-aos-duration="1000" data-aos-offset="50">
                @csrf
                <div class="filter-item clearfix">
                    <div class="icon"><i class="fal fa-map-marker-alt"></i></div>
                    <span class="title">Bạn muốn đi đâu?</span>
                    <input type="text" name="addressTour" id="addressTour">
                </div>
                <div class="filter-item clearfix">
                    <div class="icon"><i class="fal fa-calendar-alt"></i></div>
                    <span class="title">Ngày bắt đầu</span>
                    <input type="date" name="departureDate" id="departureDate"  min="{{ \Carbon\Carbon::now()->toDateString() }}">
                </div>
                <div class="filter-item clearfix">
                    <div class="icon"><i class="fas fa-money-bill-wave"></i></div>
                    <span class="title">Ngân sách:</span>
                    <select name="budgets" id="budgets">
                        <option value="value1">Chọn Mức Giá</option>
                        <option value="value2">Dưới 5 triệu</option>
                        <option value="value3">Từ 5 - 10 triệu</option>
                        <option value="value4">Từ 10 - 20 triệu</option>
                        <option value="value5">Trên 20 triệu</option>
                    </select>
                </div>
                <div class="search-button">
                    <button class="theme-btn">
                        <span data-hover="Search">Search</span>
                        <i class="far fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </section>
</form>
