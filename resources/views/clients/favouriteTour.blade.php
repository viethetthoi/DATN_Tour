<!DOCTYPE html>
<html lang="zxx">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Danh sách yêu thích</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon Icon -->
    <link rel="shortcut icon" href="{{ asset('/public/clients/assets/images/logos/lolo1.png') }}" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet">

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
    <!-- jQuery UI -->
    <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/jquery-ui.min.css') }}">
    <!-- Animate -->
    <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/aos.css') }}">
    <!-- Slick -->
    <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/slick.min.css') }}">
    <!-- Main Style -->
    <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/style.css') }}">

    <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/custom-css.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>


    <style>
        #select-options li {
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
        }

        #select-options li:hover {
            background-color: #f0f0f0;
            color: #007bff;
        }

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
            text-align: center;
            font-size: 16px;
            border: 1px solid #271e1e;
            /* Red border */
            padding: 5px 10px;
            border-radius: 5px;
            width: auto;
            flex-shrink: 0;
        }

        .swiper-button-prev,
        .swiper-button-next {
            color: #000;
            background: #fff;
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
    </style>

</head>

<body>
    @include('clients.blocks.headerpage')
    <div class="page-wrapper">


        <section class="page-banner-area pt-50 pb-35 rel z-1 bgs-cover"
            style="background-image: url({{ asset('/public/clients/assets/images/banner/result_tour.jpg);') }}">
            <div class="container">
                <div class="banner-inner text-white mb-50">
                    <h2 class="page-title mb-10" data-aos="fade-left" data-aos-duration="1500" data-aos-offset="50">Danh
                        sách yêu thích</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-20" data-aos="fade-right" data-aos-delay="200"
                            data-aos-duration="1500" data-aos-offset="50">
                            <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                            <li class="breadcrumb-item active">Yêu thích</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </section>

        <section class="tour-list-page py-100 rel z-1">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-10 rmb-75">
                        <div class="shop-sidebar mb-30">
                            @if (!$toursPopular->isEmpty())
                                <div class="widget widget-tour" data-aos="fade-up" data-aos-duration="1500"
                                    data-aos-offset="50">
                                    <h6 class="widget-title">Phổ biến Tours</h6>
                                    @foreach ($toursPopular as $tour)
                                        <div class="destination-item tour-grid style-three bgc-lighter">
                                            <div class="image">
                                                <img src="{{ asset('/public/image/' . $tour->image[0]) }}"
                                                    alt="Tour">
                                            </div>
                                            <div class="content">
                                                <div class="destination-header">
                                                    <span class="location"><i class="fal fa-map-marker-alt"></i>
                                                        {{ $tour->destination }}</span>
                                                    @if (!is_null($tour->rating))
                                                        <div class="ratting">
                                                            <i class="fas fa-star"></i>
                                                            <span>{{ $tour->rating }}</span>
                                                        </div>
                                                    @endif

                                                </div>
                                                <h6><a
                                                        href="{{ route('detailtourpage', ['id' => $tour->tourId]) }}">{{ $tour->title }}</a>
                                                </h6>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-9">
                        @php
                            use Carbon\Carbon;
                        @endphp
                        <div id="tourList">
                            @foreach ($tours as $tour)
                                @php
                                    $firstDate = $tour->date;
                                    $statusFavourite = $tour->statusFavourite;
                                @endphp
                                <div class="pani">
                                    <div class="destination-item style-three bgc-lighter" data-aos="fade-up"
                                        data-aos-duration="1500" data-aos-offset="50" style="margin-top: 70px">
                                        <div class="image"
                                            style="position: relative; overflow: hidden; border-radius: 10px;">
                                            <link rel="stylesheet"
                                                href="{{ asset('/public/clients/assets/css/favourite-css.css') }}">
                                            <a href="#"
                                                class="heart {{ $statusFavourite == 1 ? 'heart_favou' : '' }}"
                                                data-tour-id="{{ $tour->tourId }}"
                                                onclick="toggleFavourite(event, '{{ $userId }}', {{ $tour->tourId }})">
                                                {{ $statusFavourite == 1 ? '❤' : '♡' }}
                                            </a>
                                            <img src="{{ asset('/public/image/' . $tour->image[0]) }}" alt="Tour List">

                                            <script src="{{ asset('/public/clients/assets/js/favourite-js.js') }}"></script>
                                        </div>

                                        <div class="content">
                                            <div class="destination-header">
                                                <span class="location"><i
                                                        class="fal fa-map-marker-alt"></i>{{ trim(explode(',', $tour->tour->destination)[0]) }}</span>
                                                <div class="ratting">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $tour->rating)
                                                            <i class="fas fa-star"></i> {{-- sao đầy --}}
                                                        @else
                                                            <i class="far fa-star"></i> {{-- sao rỗng --}}
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                            <h5><a
                                                    href="{{ route('detailtourpage', ['id' => $tour->tourId]) }}">{{ $tour->tour->title }}</a>
                                            </h5>
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

                                                    <div class="swiper-button-prev">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </div>
                                                    <div class="swiper-button-next">
                                                        <i class="fas fa-chevron-right"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <script>
                                                var swiper = new Swiper('.swiper-container', {
                                                    slidesPerView: 3,
                                                    spaceBetween: 10,
                                                    navigation: {
                                                        nextEl: '.swiper-button-next',
                                                        prevEl: '.swiper-button-prev',
                                                    },
                                                });
                                            </script>
                                            <div class="destination-footer">
                                                <span class="price">
                                                    <span>{{ number_format($firstDate->pluck('priceAdult')->min(), 0, ',', '.') }}₫</span>
                                                </span> <a
                                                    href="{{ route('detailtourpage', ['id' => $tour->tourId]) }}"
                                                    class="theme-btn style-two style-three">
                                                    <span data-hover="Book Now">Đặt Ngay</span>
                                                    <i class="fal fa-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div id="pagination" class="mt-4 d-flex justify-content-center"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('clients.blocks.footer')

    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const itemsPerPage = 4;
            const tourItems = document.querySelectorAll(".pani");
            const totalItems = tourItems.length;
            const totalPages = Math.ceil(totalItems / itemsPerPage);
            const paginationContainer = document.getElementById("pagination");

            function showPage(page) {
                // Ẩn tất cả tour
                tourItems.forEach((item, index) => {
                    item.style.display = "none";
                });

                // Hiển thị tour thuộc trang hiện tại
                const start = (page - 1) * itemsPerPage;
                const end = start + itemsPerPage;
                for (let i = start; i < end && i < totalItems; i++) {
                    tourItems[i].style.display = "block";
                }

                // Highlight nút trang hiện tại
                const buttons = document.querySelectorAll(".page-btn");
                buttons.forEach(btn => btn.classList.remove("active"));
                const currentBtn = document.querySelector(`.page-btn[data-page='${page}']`);
                if (currentBtn) currentBtn.classList.add("active");
            }

            function createPagination() {
                for (let i = 1; i <= totalPages; i++) {
                    const btn = document.createElement("button");
                    btn.innerText = i;
                    btn.classList.add(
                        "page-btn",
                        "btn",
                        "btn-outline-success",
                        "btn-sm",
                        "px-3",
                        "py-2",
                        "rounded-pill",
                        "shadow",
                        "transition"
                    );

                    btn.setAttribute("data-page", i);
                    btn.addEventListener("click", () => showPage(i));
                    paginationContainer.appendChild(btn);
                }
            }

            if (totalItems > itemsPerPage) {
                createPagination();
                showPage(1); // Hiển thị trang đầu tiên
            } else {
                // Hiển thị tất cả nếu ít hơn itemsPerPage
                tourItems.forEach(item => item.style.display = "block");
            }
        });
    </script>
    <!-- Jquery -->
    <script src="{{ asset('/public/clients/assets/js/jquery-3.6.0.min.js') }}"></script>
    <!-- Bootstrap -->
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
    <!-- Jquery UI -->
    <script src="{{ asset('/public/clients/assets/js/jquery-ui.min.js') }}"></script>
    <!-- Isotope -->
    <script src="{{ asset('/public/clients/assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!--  AOS Animation -->
    <script src="{{ asset('/public/clients/assets/js/aos.js') }}"></script>
    <!-- Custom script -->
    <script src="{{ asset('/public/clients/assets/js/script.js') }}"></script>
    <script src="{{ asset('/public/clients/assets/js/custom-js.js') }}"></script>
    <script src="{{ asset('/public/clients/assets/js/header-js.js') }}"></script>


</body>

</html>
