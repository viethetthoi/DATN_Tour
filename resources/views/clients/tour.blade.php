<!DOCTYPE html>
<html lang="zxx">


<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Danh sách tour</title>
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
    {{-- <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" /> --}}

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
                    <h2 class="page-title mb-10" data-aos="fade-left" data-aos-duration="1500" data-aos-offset="50">Tour
                        List View</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-20" data-aos="fade-right" data-aos-delay="200"
                            data-aos-duration="1500" data-aos-offset="50">
                            <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                            <li class="breadcrumb-item active">Tour List</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </section>

        <section class="tour-list-page py-100 rel z-1">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-10 rmb-75">
                        <form id="searchTourForm" method="POST" action="{{ route('search.tour') }}">
                            @csrf
                            <div id="custom-select"
                                style="display: flex; align-items: center; gap: 10px; position: relative; width: 400px; margin-bottom: 20px; margin-left: 900px;">
                                <h6 style="margin: 0; white-space: nowrap;">Sắp xếp theo:</h6>
                                <div style="flex: 1; position: relative;">
                                    <div id="selected-option"
                                        style="border: 3px solid black; padding: 10px; cursor: pointer; position: relative;">
                                        Tất Cả
                                        <i class="fas fa-chevron-down"
                                            style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%);"></i>
                                    </div>
                                    <ul id="select-options"
                                        style="list-style: none; padding: 0; margin: 0; display: none; position: absolute; top: 100%; left: 0; width: 100%; background: white; border: 1px solid #ccc; z-index: 10;">
                                        <li data-value="default">Tất Cả</li>
                                        <li data-value="desc">Giá từ cao đến thấp</li>
                                        <li data-value="asc">Giá từ thấp đến cao</li>
                                        <li data-value="date">Ngày khởi hành gần nhất</li>
                                    </ul>
                                    <input type="hidden" name="sort" id="sortInput" value="default">
                                </div>
                            </div>
                            <div class="shop-sidebar mb-30">
                                <div class="widget widget-activity">
                                    <h6 class="widget-title">Ngân Sách:</h6>
                                    <div class="form-group">
                                        <select name="budgets" id="budgets"
                                            class="form-select border border-2 border-success">
                                            <option value="value1"
                                                {{ request('budgets') == 'value1' ? 'selected' : '' }}>Chọn Mức Giá
                                            </option>
                                            <option value="value2"
                                                {{ request('budgets') == 'value2' ? 'selected' : '' }}>Dưới 5 triệu
                                            </option>
                                            <option value="value3"
                                                {{ request('budgets') == 'value3' ? 'selected' : '' }}>Từ 5 - 10 triệu
                                            </option>
                                            <option value="value4"
                                                {{ request('budgets') == 'value4' ? 'selected' : '' }}>Từ 10 - 20 triệu
                                            </option>
                                            <option value="value5"
                                                {{ request('budgets') == 'value5' ? 'selected' : '' }}>Trên 20 triệu
                                            </option>
                                        </select>

                                    </div>
                                </div>

                                <div class="widget widget-activity" data-aos="fade-up" data-aos-duration="1500"
                                    data-aos-offset="50">
                                    <h6 class="widget-title">Địa Điểm Đến:</h6>
                                    <div class="form-group">
                                        <input type="text" value="{{ !empty($domain) ? $domain : '' }}"
                                            name="addressTour" id="addressTour"
                                            class="form-control border border-2 border-success"
                                            placeholder="Nhập địa điểm">
                                    </div>
                                </div>

                                <div class="widget widget-reviews" data-aos="fade-up" data-aos-duration="1500"
                                    data-aos-offset="50">
                                    <h6 class="widget-title">Ngày Khởi Hành:</h6>
                                    <div class="form-group">
                                        <input type="date" name="departureDate" id="departureDate"
                                            class="form-control border border-2 border-success"
                                            value="{{ request('departureDate') }}"
                                            min="{{ \Carbon\Carbon::now()->toDateString() }}">

                                    </div>
                                    <div class="form-group form-button d-flex justify-content-center"
                                        style="margin-top: 10px">
                                        <input type="submit" name="signin" id="signin"
                                            class="btn btn-success btn-sm" value="Áp Dụng" />
                                    </div>
                                </div>
                            </div>
                        </form>




                    </div>
                    <div class="col-lg-9">

                        <div class="shop-shorter rel z-3 mb-20">
                            <div class="sort-text mb-15 me-4 me-xl-auto">
                            </div>
                        </div>

                        @php
                            use Carbon\Carbon;
                        @endphp
                        <div id="tourList">
                            @if (empty($tours) || $tours->isEmpty())
                                <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                                    <div class="text-center text-muted">
                                        <i class="bi bi-info-circle" style="font-size: 48px;"></i>
                                        <!-- icon Bootstrap Icons -->
                                        <h4 class="mt-3">Hiện tại chưa có tour nào phù hợp</h4>
                                        <p>Vui lòng thử lại với các điều kiện khác.</p>
                                    </div>
                                </div>
                            @else
                                @foreach ($tours as $tour)
                                    <div class="tour-item">
                                        @php
                                            $firstDate = $tour->date;
                                            $statusFavourite = $tour->favourite->first();
                                        @endphp
                                        <div class="destination-item style-three bgc-lighter " data-aos="fade-up"
                                            data-aos-duration="1500" data-aos-offset="50" style="margin-top: 70px">
                                            <div class="image"
                                                style="position: relative; overflow: hidden; border-radius: 10px;">
                                                <link rel="stylesheet"
                                                    href="{{ asset('/public/clients/assets/css/favourite-css.css') }}">
                                                <a href="#"
                                                    class="heart {{ optional($statusFavourite)->statusFavourite == 1 ? 'heart_favou' : '' }}"
                                                    data-tour-id="{{ $tour->tourId }}"
                                                    onclick="toggleFavourite(event, '{{ $userId }}', {{ $tour->tourId }})">
                                                    {{ optional($statusFavourite)->statusFavourite == 1 ? '❤' : '♡' }}
                                                </a>
                                                <img src="{{ asset('/public/image/' . $tour->image[0]) }}"
                                                    alt="Tour List">
                                                <script src="{{ asset('/public/clients/assets/js/favourite-js.js') }}"></script>
                                            </div>
                                            <div class="content">
                                                <div class="destination-header">
                                                    <span class="location"><i
                                                            class="fal fa-map-marker-alt"></i>{{ trim(explode(',', $tour->destination)[0]) }}</span>

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
                                                        href="{{ route('detailtourpage', ['id' => $tour->tourId]) }}">{{ $tour->title }}</a>
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
                                                <div
                                                    class="destination-footer d-flex justify-content-between align-items-start">
                                                    <span class="price d-flex flex-column">
                                                        @if (isset($tour->promotion) &&
                                                                \Carbon\Carbon::now()->between(
                                                                    \Carbon\Carbon::parse($tour->promotion->startDate),
                                                                    \Carbon\Carbon::parse($tour->promotion->endDate)))
                                                            <del class="text-muted mb-1">
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
                                                    </span>

                                                    <a href="{{ route('detailtourpage', ['id' => $tour->tourId]) }}"
                                                        class="theme-btn style-two style-three ms-3">
                                                        <span data-hover="Book Now">Đặt Ngay</span>
                                                        <i class="fal fa-arrow-right"></i>
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <div id="pagination" class="mt-4 d-flex justify-content-center"></div>
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                AOS.init();

                                const form = document.getElementById('searchTourForm');
                                const tourList = document.getElementById('tourList');
                                const pagination = document.getElementById('pagination');
                                const selectedOption = document.getElementById('selected-option');
                                const optionsList = document.getElementById('select-options');
                                const sortInput = document.getElementById('sortInput');

                                let allTours = [];
                                const pageSize = 4;

                                let userId = null;

                                function initSwipers() {
                                    document.querySelectorAll('.swiper-container').forEach(container => {
                                        new Swiper(container, {
                                            slidesPerView: 3,
                                            spaceBetween: 10,
                                            navigation: {
                                                nextEl: container.querySelector('.swiper-button-next'),
                                                prevEl: container.querySelector('.swiper-button-prev'),
                                            },
                                        });
                                    });
                                }

                                function renderTours(tours) {
                                    let html = '';
                                    const today = new Date();

                                    tours.forEach(tour => {
                                        const start = new Date(tour.startDate);
                                        if (start < today) return;

                                        const isAvailable = tour.availability === 1;
                                        const isFavourite = tour.favourite && tour.favourite[0]?.statusFavourite == 1;
                                        console.log(isFavourite);
                                        let stars = '';
                                        for (let i = 1; i <= 5; i++) {
                                            stars += `<i class="${i <= tour.rating ? 'fas' : 'far'} fa-star"></i>`;
                                        }

                                        html += `
                                        <div class="destination-item style-three bgc-lighter" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50" style="margin-top: 70px">
                                            <div class="image" style="position: relative; overflow: hidden; border-radius: 10px;">
                                                <a href="#" class="heart ${isFavourite ? 'heart_favou' : ''}" data-tour-id="${tour.tourId}" onclick="toggleFavourite(event, ${userId}, ${tour.tourId})">
                                                    ${isFavourite ? '❤' : '♡'}
                                                </a>
                                                <img src="http://localhost/DATN_TOUR/public/image/${tour.image[0] || 'default.jpg'}" alt="Tour List">
                                            </div>
                                            <div class="content">
                                                <div class="destination-header">
                                                    <span class="location"><i class="fal fa-map-marker-alt"></i> ${tour.destination.split(',')[0].trim()}</span>
                                                    <div class="ratting">
                                                        ${stars}
                                                    </div>
                                                </div>
                                                <h5><a href="./detailtourpage/${tour.tourId}">${tour.title}</a></h5>
                                                <span class="time d-block mt-1"><i class="far fa-calendar-alt"></i> Ngày khởi hành:</span>
                                                <div class="date-carousel">
                                                    <div class="swiper-container">
                                                        <div class="swiper-wrapper">
                                                            ${tour.startDates.map(date => `<div class="swiper-slide">${new Date(date).toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit' })}</div>`).join('')}
                                                        </div>
                                                        <div class="swiper-button-prev"><i class="fas fa-chevron-left"></i></div>
                                                        <div class="swiper-button-next"><i class="fas fa-chevron-right"></i></div>
                                                    </div>
                                                </div>
                                                <div class=""destination-footer d-flex justify-content-between align-items-start">
                                                    <span class="price d-flex flex-column">
                                                                        ${
    tour.promotion &&
    tour.promotion.discount &&
    new Date() >= new Date(tour.promotion.startDate) &&
    new Date() <= new Date(tour.promotion.endDate)
        ? `
                                    <del class="text-muted mb-1">${new Intl.NumberFormat('vi-VN').format(tour.minPriceAdult)}₫</del>
                                    <span class="text-danger fw-bold">
                                        ${new Intl.NumberFormat('vi-VN').format(tour.minPriceAdult * (1 - tour.promotion.discount / 100))}₫
                                    </span>
                                `
        : `<span>${new Intl.NumberFormat('vi-VN').format(tour.minPriceAdult)}₫</span>`
}

                                                                    </span>                                                    <a href="./detailtour/${tour.tourId}" class="theme-btn style-two style-three ${isAvailable ? '' : 'disabled'}">
                                                        <span data-hover="Book Now">Đặt Ngay</span><i class="fal fa-arrow-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>`;

                                    });

                                    tourList.innerHTML = html;

                                    initSwipers();
                                    AOS.refresh();

                                    document.querySelectorAll('.heart').forEach(heart => {
                                        heart.addEventListener('click', function(event) {
                                            event.preventDefault();
                                            const tourId = this.getAttribute('data-tour-id');
                                            // console.log(tourId);
                                            console.log(tour.tourId);
                                            // toggleFavourite(event, userId, tourId); // xử lý yêu thích nếu có
                                        });
                                    });
                                }

                                function renderPagination(currentPage, totalPages) {
                                    let html = '<ul class="pagination">';
                                    if (currentPage > 1) {
                                        html +=
                                            `<li class="page-item"><a class="page-link" href="#" data-page="${currentPage - 1}">«</a></li>`;
                                    }

                                    for (let i = 1; i <= totalPages; i++) {
                                        html += `<li class="page-item ${i === currentPage ? 'active' : ''}">
                                            <a class="page-link" href="#" data-page="${i}">${i}</a>
                                        </li>`;
                                    }

                                    if (currentPage < totalPages) {
                                        html +=
                                            `<li class="page-item"><a class="page-link" href="#" data-page="${currentPage + 1}">»</a></li>`;
                                    }

                                    html += '</ul>';
                                    pagination.innerHTML = html;

                                    document.querySelectorAll('#pagination .page-link').forEach(link => {
                                        link.addEventListener('click', function(e) {
                                            e.preventDefault();
                                            const page = parseInt(this.getAttribute('data-page'));
                                            showPage(page);
                                        });
                                    });
                                }

                                function showPage(page) {
                                    const startIndex = (page - 1) * pageSize;
                                    const paginated = allTours.slice(startIndex, startIndex +
                                        pageSize); // Lấy các tour trong trang hiện tại
                                    renderTours(paginated); // Hiển thị các tour trên trang hiện tại
                                    renderPagination(page, Math.ceil(allTours.length / pageSize)); // Hiển thị phân trang
                                }

                                function submitFormAjax() {
                                    const formData = new FormData(form);
                                    tourList.innerHTML = '<p>Đang tải...</p>';
                                    pagination.innerHTML = '';

                                    fetch("{{ route('search.tour') }}", {
                                            method: 'POST',
                                            body: formData,
                                            headers: {
                                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                                'Accept': 'application/json'
                                            }
                                        })
                                        .then(response => response.json())
                                        .then(data => {
                                            allTours = data.tours || data.data || [];
                                            userId = data.userId;
                                            if (allTours.length > 0) {
                                                showPage(1); // Mặc định, trang 1 sẽ được hiển thị đầu tiên
                                            } else {
                                                tourList.innerHTML = `
                                                    <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                                                        <div class="text-center text-muted">
                                                            <i class="bi bi-info-circle" style="font-size: 48px;"></i>
                                                            <!-- icon Bootstrap Icons -->
                                                            <h4 class="mt-3">Hiện tại chưa có tour nào phù hợp</h4>
                                                            <p>Vui lòng thử lại với các điều kiện khác.</p>
                                                        </div>
                                                    </div>
                                                    `;
                                                pagination.innerHTML = '';
                                            }
                                        })
                                        .catch(error => {
                                            console.error('Error:', error);
                                            tourList.innerHTML = '<p>Đã xảy ra lỗi. Vui lòng thử lại.</p>';
                                        });
                                }

                                // Sự kiện form & select
                                selectedOption.addEventListener('click', () => {
                                    optionsList.style.display = optionsList.style.display === 'none' ? 'block' : 'none';
                                });

                                optionsList.querySelectorAll('li').forEach(item => {
                                    item.addEventListener('click', () => {
                                        const selectedText = item.textContent;
                                        const selectedValue = item.getAttribute('data-value');
                                        selectedOption.textContent = selectedText;
                                        sortInput.value = selectedValue;
                                        optionsList.style.display = 'none';
                                        submitFormAjax(); // Gọi hàm này để tải lại dữ liệu và phân trang
                                    });
                                });

                                document.addEventListener('click', function(e) {
                                    if (!document.getElementById('custom-select').contains(e.target)) {
                                        optionsList.style.display = 'none';
                                    }
                                });

                                form.addEventListener('submit', function(event) {
                                    event.preventDefault();
                                    submitFormAjax(); // Gọi hàm này để tải lại dữ liệu và phân trang khi form được submit
                                });
                            });
                        </script>
                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const itemsPerPage = 4;
                                const tourItems = document.querySelectorAll(".tour-item");
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
                    </div>
                </div>
            </div>
        </section>

        @include('clients.blocks.footer')

    </div>

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
    <!--  AOS Animation -->
    <script src="{{ asset('/public/clients/assets/js/aos.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Custom script -->
    <script src="{{ asset('/public/clients/assets/js/script.js') }}"></script>
    <script src="{{ asset('/public/clients/assets/js/custom-js.js') }}"></script>
    <script src="{{ asset('/public/clients/assets/js/header-js.js') }}"></script>


</body>

</html>
