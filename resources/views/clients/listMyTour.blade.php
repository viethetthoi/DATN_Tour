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
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <div class="page-wrapper">
        <section class="page-banner-area pt-50 pb-35 rel z-1 bgs-cover"
            style="background-image: url({{ asset('/public/clients/assets/images/banner/result_tour.jpg);') }}">
            <div class="container">
                <div class="banner-inner text-white mb-50">
                    <h2 class="page-title mb-10" data-aos="fade-left" data-aos-duration="1500" data-aos-offset="50">Danh
                        sách đã đặt</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-20" data-aos="fade-right" data-aos-delay="200"
                            data-aos-duration="1500" data-aos-offset="50">
                            <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                            <li class="breadcrumb-item active">Danh sách đặt</li>
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
                        @foreach ($tours as $tour)
                            <div class="pani">
                                                            <div class="destination-item style-three bgc-lighter" data-aos="fade-up"
                                data-aos-duration="1500" data-aos-offset="50">
                                <div class="image">
                                    @if ($tour->bookingStatus == 'b')
                                        <span class="badge">Đợi xác nhận</span>
                                    @elseif ($tour->bookingStatus == 'y')
                                        <span class="badge bgc-pink">Sắp khởi hành</span>
                                    @elseif ($tour->bookingStatus == 'd')
                                        <span class="badge bgc-pink">Đang khởi hành</span>
                                    @elseif ($tour->bookingStatus == 'f')
                                        <span class="badge bgc-primary">Hoàn thành</span>
                                    @elseif ($tour->bookingStatus == 'c')
                                        <span class="badge" style="background-color: red">Đã hủy</span>
                                    @endif
                                    <img src="{{ asset('/public/image/' . $tour->image[0]) }}" alt="Tour List">
                                </div>
                                <div class="content">
                                    <div class="destination-header">
                                        <span class="location"><i
                                                class="fal fa-map-marker-alt"></i>{{ $tour->destination }}</span>
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
                                    <h5>
                                        <a
                                            href="{{ route('detailtourpage', ['id' => $tour->tourId]) }}">{{ $tour->title }}</a>
                                    </h5>
                                    <ul class="blog-meta">
                                        <li><i
                                                class="far fa-clock"></i>{{ \Carbon\Carbon::parse($tour->date[0]->startDate)->format('d/m/y') }}
                                        </li>
                                        <li><i class="far fa-user"></i> {{ $tour->numAdults + $tour->numChildren }}
                                            người</li>
                                    </ul>
                                    <div class="destination-footer">
                                        <span
                                            class="price"><span>{{ number_format($tour->totalPrice, 0) }}</span>/vnđ</span>
                                        @if (Carbon\Carbon::today()->lt(Carbon\Carbon::parse($tour->date[0]->startDate)->subDay()))
                                            @if ($tour->bookingStatus != 'f' && $tour->bookingStatus != 'c' && $tour->bookingStatus != 'd')
                                                <a href="#"
                                                    class="theme-btn style-two style-three btn btn-danger"
                                                    data-bs-toggle="modal" data-bs-target="#cancelTourModal"
                                                    data-booking-id="{{ $tour->bookingId }}"
                                                    data-destination="{{ $tour->title }}">
                                                    <span data-hover="Đánh giá">Hủy tour</span>
                                                    <i class="fal fa-arrow-right"></i>
                                                </a>
                                            @endif
                                        @endif

                                        @if ($tour->bookingStatus == 'f')
                                            <a href="{{ route('detailtourpage', ['id' => $tour->tourId]) }}"
                                                class="theme-btn style-two style-three">
                                                @if ($tour->rating)
                                                    <span data-hover="Đã đánh giá">Đã đánh giá</span>
                                                @else
                                                    <span data-hover="Đánh giá">Đánh giá</span>
                                                @endif
                                                <i class="fal fa-arrow-right"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            </div>

                        @endforeach
                        <div id="pagination" class="mt-4 d-flex justify-content-center"></div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('clients.blocks.footer')
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
    <!-- Di chuyển Modal ra ngoài, đặt trước </body> -->
    <div class="modal fade" id="cancelTourModal" tabindex="-1" aria-labelledby="cancelTourModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelTourModalLabel">
                        Hủy Tour: <span id="tourDestination"></span>
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="cancelTourForm">
                        <input type="hidden" id="bookingId" name="bookingId">
                        <div class="mb-3" style="text-align: center;">
                            <label for="reason" class="form-label">Bạn có chắc chắn muốn hủy tour không?</label>
                            <br>
                            <button type="submit" class="btn btn-danger" id="suu" name="suu"
                                style="display: block; margin: 10px auto;">Xác nhận hủy</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.cancelTourUrl = "{{ route('tour.cancel') }}";
    </script>

    <script src="{{ asset('/public/clients/assets/js/cancel-tour-js.js') }}"></script>

    <script src="{{ asset('/public/clients/assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('/public/clients/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/public/clients/assets/js/appear.min.js') }}"></script>
    <script src="{{ asset('/public/clients/assets/js/slick.min.js') }}"></script>
    <script src="{{ asset('/public/clients/assets/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('/public/clients/assets/js/jquery.nice-select.min.js') }}"></script>
    <script src="{{ asset('/public/clients/assets/js/imagesloaded.pkgd.min.js') }}"></script>
    <script src="{{ asset('/public/clients/assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('/public/clients/assets/js/isotope.pkgd.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('/public/clients/assets/js/aos.js') }}"></script>
    <script src="{{ asset('/public/clients/assets/js/script.js') }}"></script>
    <script src="{{ asset('/public/clients/assets/js/custom-js.js') }}"></script>
    <script src="{{ asset('/public/clients/assets/js/header-js.js') }}"></script>
</body>

</html>
