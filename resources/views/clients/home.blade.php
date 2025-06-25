<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Trang chủ </title>
    <!-- Favicon Icon -->
    <link rel="shortcut icon" href="{{ asset('/public/clients/assets/images/logos/lolo1.png') }}" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet">

    <!-- Flaticon -->
    <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/custom-css.css') }}">

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <style>
        .date-carousel {
            display: flex;
            align-items: center;
            max-width: 300px;
            margin: 20px 20px 0;
            position: relative;
        }

        .swiper-container {
            width: 100%;
            overflow: hidden;
        }

        .swiper-wrapper {
            display: flex;
            flex-wrap: nowrap;
            /* Ensure horizontal layout */
        }

        .swiper-slide {
            color: #ffffff;
            text-align: center;
            font-size: 16px;
            border: 1px solid #b7acac;
            /* Red border */
            padding: 5px 10px;
            border-radius: 5px;
            width: auto;
            flex-shrink: 0;
        }

        .swiper-button-prev,
        .swiper-button-next {
            color: #ffffff;
            background: #232C26;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            /* Fix buttons in place */
            top: 50%;
            transform: translateY(-50%);
        }

        .swiper-button-prev {
            left: -40px;
            /* Position outside the left edge */
        }

        .swiper-button-next {
            right: -40px;
            /* Position outside the right edge */
        }

        .swiper-button-prev:after,
        .swiper-button-next:after {
            font-size: 14px;
        }

        .desc-truncate {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* Chỉ hiển thị 2 dòng */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            max-height: 3em;
            /* Tùy thuộc vào line-height, thường 1.5em mỗi dòng */
            line-height: 1.5em;
            white-space: normal;
        }

        .tour-image {
            width: 100%;
            /* Hoặc đặt chiều rộng cụ thể, ví dụ 300px */
            height: 200px;
            /* Chiều cao mong muốn */
            object-fit: cover;
            /* Cắt ảnh để vừa khung mà không bị méo */
            border-radius: 8px;
            /* Bo góc nếu muốn */
            display: block;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">

        <!-- Preloader -->

        <div class="preloader">
            <div class="custom-loader"></div>
        </div>
        <!-- main header -->
        @include('clients.blocks.header')

        <!-- Hero Area End -->
        @include('clients.blocks.fillter')

        <!-- Destinations Area start -->
        <section class="destinations-area bgc-black pt-100 pb-70 rel z-1">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="section-title text-white text-center counter-text-wrap mb-70" data-aos="fade-up"
                            data-aos-duration="1500" data-aos-offset="50">
                            <h2>Khám phá kho báu thế giới cùng Vi Vu</h2>
                            <p>Một trang web phổ biến nhất mà bạn sẽ nhớ</p>
                        </div>
                    </div>
                </div>
                @php
                    use Carbon\Carbon;
                @endphp
                <div class="row justify-content-center">
                    @foreach ($tours as $tour)
                        @php
                            $firstDate = $tour->date;
                            $statusFavourite = $tour->favourite->first();
                        @endphp
                        <div class="col-xxl-3 col-xl-4 col-md-6">
                            <div class="destination-item h-100 d-flex flex-column" data-aos="fade-up"
                                data-aos-duration="1500" data-aos-offset="50">
                                <div class="image" style="position: relative; overflow: hidden; border-radius: 10px;">
                                    <link rel="stylesheet"
                                        href="{{ asset('/public/clients/assets/css/favourite-css.css') }}">
                                    <a href="#"
                                        class="heart {{ optional($statusFavourite)->statusFavourite == 1 ? 'heart_favou' : '' }}"
                                        data-tour-id="{{ $tour->tourId }}"
                                        onclick="toggleFavourite(event, '{{ $userId }}', {{ $tour->tourId }})">
                                        {{ optional($statusFavourite)->statusFavourite == 1 ? '❤' : '♡' }}
                                    </a>
                                    <img src="{{ asset('/public/image/' . $tour->image[0]) }}"
                                        alt="{{ $tour->title }}" class="tour-image">
                                    <script src="{{ asset('/public/clients/assets/js/favourite-js.js') }}"></script>
                                </div>
                                <div class="content flex-grow-1 d-flex flex-column justify-content-between">
                                    <div>
                                        <span class="location"><i class="fal fa-map-marker-alt"></i> Tours,
                                            {{ trim(explode(',', $tour->destination)[0]) }}</span>
                                        <h5 class="mt-2 mb-2">
                                            <a href="{{ route('detailtourpage', ['id' => $tour->tourId]) }}"
                                                class="desc-truncate" title="{{ $tour->title }}">
                                                {{ $tour->title }}
                                            </a>
                                        </h5>

                                        <span class="time d-block mt-1">
                                            <i class="far fa-calendar-alt"></i> Số Ngày: {{ $tour->time }}
                                        </span>
                                        <span class="time d-block mt-1">
                                            <i class="far fa-calendar-alt"></i> Ngày khởi hành:
                                        </span>
                                        <div class="date-carousel">
                                            <div class="swiper-container">
                                                <div class="swiper-wrapper">
                                                    @foreach ($firstDate as $date)
                                                        <div class="swiper-slide">
                                                            {{ \Carbon\Carbon::parse($date->startDate)->format('d/m') }}
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <!-- Add Navigation Arrows -->
                                                <div class="swiper-button-prev">
                                                    <i class="fas fa-chevron-left"></i> <!-- Mũi tên trái -->
                                                </div>
                                                <div class="swiper-button-next">
                                                    <i class="fas fa-chevron-right"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Include Swiper JS -->
                                        <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
                                        <script>
                                            var swiper = new Swiper('.swiper-container', {
                                                slidesPerView: 3, // Show 5 dates at a time as in the image
                                                spaceBetween: 10,
                                                navigation: {
                                                    nextEl: '.swiper-button-next',
                                                    prevEl: '.swiper-button-prev',
                                                },
                                            });
                                        </script>

                                    </div>
                                </div>

                                <div
                                    class="destination-footer border-top pt-1.5 mt-2 d-flex justify-content-between align-items-start">
                                    <div class="price d-flex flex-column">
                                        @if (isset($tour->promotion) &&
                                                \Carbon\Carbon::now()->between(
                                                    \Carbon\Carbon::parse($tour->promotion->startDate)->startOfDay(),
                                                    \Carbon\Carbon::parse($tour->promotion->endDate)))->endOfDay()
                                            <del class="text-muted">
                                                {{ number_format($firstDate->pluck('priceAdult')->min(), 0, ',', '.') }}₫
                                            </del>
                                            <span class="text-danger fw-bold">
                                                {{ number_format($firstDate->pluck('priceAdult')->min() * (1 - $tour->promotion->discount / 100), 0, ',', '.') }}₫
                                            </span>
                                        @else
                                            <span>
                                                {{ number_format($firstDate->pluck('priceAdult')->min(), 0, ',', '.') }}₫
                                            </span>
                                        @endif
                                    </div>
                                    <a href="{{ route('detailtourpage', ['id' => $tour->tourId]) }}"
                                        class="read-more ms-3 mt-1">
                                        Đặt Ngay <i class="fal fa-angle-right"></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                    @endforeach

                    <div class="d-flex justify-content-center align-items-center mt-3">
                        <a href="{{ route('tourpage') }}" class="btn"
                            style="background-color: transparent; color: white; border: 1px solid white; transition: all 0.3s ease;"
                            onmouseover="this.style.backgroundColor='white'; this.style.color='black'; this.style.border='1px solid black';"
                            onmouseout="this.style.backgroundColor='transparent'; this.style.color='white'; this.style.border='1px solid white';">
                            Xem Tất Cả
                        </a>
                    </div>



                </div>
            </div>
        </section>
        <!-- Destinations Area end -->


        <!-- About Us Area start -->
        <section class="about-us-area py-100 rpb-90 rel z-1">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-5 col-lg-6">
                        <div class="about-us-content rmb-55" data-aos="fade-left" data-aos-duration="1500"
                            data-aos-offset="50">
                            <div class="section-title mb-25">
                                <h2>Du lịch với sự tự tin lý do hàng đầu để chọn công ty của chúng tôi</h2>
                            </div>
                            <p>Chúng tôi sẽ nỗ lực hết mình để biến giấc mơ du lịch của bạn thành hiện thực, những viên
                                ngọc ẩn và những điểm tham quan không thể bỏ qua</p>

                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-6" data-aos="fade-right" data-aos-duration="1500"
                        data-aos-offset="50">
                        <div class="about-us-image">
                            <img src="{{ asset('/public/clients/assets/images/about/about.png') }}" alt="About">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- About Us Area end -->


        <!-- Popular Destinations Area start -->
        <section class="popular-destinations-area pt-100 pb-90 rel z-1">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="section-title text-center counter-text-wrap mb-40" data-aos="fade-up"
                            data-aos-duration="1500" data-aos-offset="50">
                            <h2>ĐIỂM ĐẾN YÊU THÍCH</h2>
                            <p>Hãy chọn một điểm đến du lịch nổi tiếng dưới đây để khám phá các chuyến đi độc quyền của
                                chúng tôi với mức giá vô cùng hợp lý.</p>
                            <ul class="destinations-nav mt-30">
                                <li data-filter=".MB" class="active">Miền Bắc</li>
                                <li data-filter=".MT">Miền Trung</li>
                                <li data-filter=".MDNB">Miền Đông Nam Bộ</li>
                                <li data-filter=".MTNB">Miền Tây Nam Bộ</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row gap-10 destinations-active justify-content-center">
                        @include('clients.mienTrung')
                        @include('clients.mienBac')
                        @include('clients.MDNB')
                        @include('clients.MTNB')
                    </div>
                </div>
            </div>
            <style>
                .item {
                    display: none;
                }

                .item.MB {
                    display: block;
                }
            </style>
            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                $(document).ready(function() {
                    $('.destinations-nav li').on('click', function(e) {
                        e.preventDefault();
                        var filterClass = $(this).attr('data-filter');
                        $('.item').hide();
                        $(filterClass).show();
                        $('.destinations-nav li').removeClass('active');
                        $(this).addClass('active');
                    });
                });
            </script>
        </section>

        @include('clients.blocks.footer')

    </div>

    <script src="{{ asset('/public/clients/assets/js/jquery-3.6.0.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('/public/clients/assets/js/bootstrap.min.js') }}"></script>
    <!-- Appear Js -->
    <script src="{{ asset('/public/clients/assets/js/appear.min.js') }}"></script>
    <!-- Slick -->
    <script src="{{ asset('/public/clients/assets/js/slick.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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
    <!--  AOS Animation -->
    <script src="{{ asset('/public/clients/assets/js/aos.js') }}"></script>
    <!-- Custom script -->
    <script src="{{ asset('/public/clients/assets/js/script.js') }}"></script>
    <script src="{{ asset('/public/clients/assets/js/custom-js.js') }}"></script>
    <script src="{{ asset('/public/clients/assets/js/header-js.js') }}"></script>
</body>

</html>
