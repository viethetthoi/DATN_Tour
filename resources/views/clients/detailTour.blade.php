<!DOCTYPE html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title -->
    <title>Chi tiết tour du lịch </title>
    <!-- Favicon Icon -->
    <link rel="shortcut icon" href="{{ asset('/public/clients/assets//images/logos/lolo1.png') }}" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet">

    <!-- Flaticon -->
    <link rel="stylesheet" href="{{ asset('/public/clients/assets//css/flaticon.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/public/clients/assets//css/fontawesome-5.14.0.min.css') }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('/public/clients/assets//css/bootstrap.min.css') }}">
    <!-- Magnific Popup -->
    <link rel="stylesheet" href="{{ asset('/public/clients/assets//css/magnific-popup.min.css') }}">
    <!-- Nice Select -->
    <link rel="stylesheet" href="{{ asset('/public/clients/assets//css/nice-select.min.css') }}">
    <!-- Animate -->
    <link rel="stylesheet" href="{{ asset('/public/clients/assets//css/aos.css') }}">
    <!-- Slick -->
    <link rel="stylesheet" href="{{ asset('/public/clients/assets//css/slick.min.css') }}">
    <!-- Main Style -->
    <link rel="stylesheet" href="{{ asset('/public/clients/assets//css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/clients/assets//css/custom-css.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
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
    <style>
        .gallery-item {
            margin-bottom: 15px;
            /* Khoảng cách giữa 2 ảnh */
            width: 100%;
            height: 300px;
            /* Chiều cao cố định cho từng ảnh */
            overflow: hidden;
            border-radius: 8px;
            /* Tuỳ chọn: bo góc */
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* Giữ tỉ lệ đẹp và cắt ảnh nếu vượt khung */
            display: block;
        }
    </style>
</head>

<body>
    @include('clients.blocks.headerpage')
    <div class="page-wrapper">

        <div class="tour-gallery">
            <div class="container-fluid">
                <div class="row gap-10 justify-content-center rel">
                    @php
                        $images = json_decode($detailTour->image);
                    @endphp
                    @if ($images)
                        @for ($i = 0; $i < count($images); $i += 2)
                            <div class="col-lg-4 col-md-6">
                                <div class="gallery-item">
                                    <img src="{{ asset('/public/image/' . $images[$i]) }}" alt="Destination">
                                </div>

                                @if (isset($images[$i + 1]))
                                    <div class="gallery-item">
                                        <img src="{{ asset('/public/image/' . $images[$i + 1]) }}" alt="Destination">
                                    </div>
                                @endif
                            </div>
                        @endfor
                    @else
                        <p>Không có hình ảnh cho tour này.</p>
                    @endif
                </div>
            </div>
        </div>
        <!-- Tour Gallery End -->


        <!-- Tour Header Area start -->
        <section class="tour-header-area pt-70 rel z-1">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-12"> <!-- ✅ Đổi từ col-xl-6 col-lg-7 sang col-12 -->
                        <div class="tour-header-content mb-15" data-aos="fade-left" data-aos-duration="1500"
                            data-aos-offset="50">

                            <span class="location d-inline-block mb-10">
                                <i class="fal fa-map-marker-alt"></i>
                                {{ trim(explode(',', $detailTour->destination)[0]) }}
                            </span>

                            <div class="section-title pb-5" style="width: 100%;">
                                <h2 style="display: block; width: 100%; white-space: normal; word-break: break-word;">
                                    {{ $detailTour->title }}
                                </h2>
                            </div>

                            <div class="ratting">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>

                        </div>
                    </div>
                </div>
                <hr class="mt-50 mb-70">
            </div>
        </section>


        <section class="tour-details-page pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="tour-details-content">
                            <link rel="stylesheet"
                                href="{{ asset('/public/clients/assets/css/selectStartDate-css.css') }}">
                            <h2 class="calendar-title">LỊCH KHỞI HÀNH</h2>
                            <div class="calendar-container">
                                <input type="hidden" name="tourId" id="tourId" value="{{ $detailTour->tourId }}">

                                <div class="month-selector" id="monthSelector">
                                    <!-- tháng sẽ được render bằng JS -->
                                </div>

                                <div class="calendar-content">
                                    <div class="calendar-header"
                                        style="display: flex; justify-content: space-between; align-items: center; height: 50px; padding: 0 10px;">
                                        <button id="prevMonthBtn" class="btn-nav">« Tháng trước</button>
                                        <span class="month-label" id="monthLabel"></span>
                                        <button id="nextMonthBtn" class="btn-nav">Tháng sau »</button>
                                    </div>

                                    <div class="weekdays">
                                        <div>T2</div>
                                        <div>T3</div>
                                        <div>T4</div>
                                        <div>T5</div>
                                        <div>T6</div>
                                        <div class="red">T7</div>
                                        <div class="red">CN</div>
                                    </div>

                                    <div class="days" id="calendarDays">
                                        <!-- ngày sẽ được render bằng JS -->
                                    </div>

                                    <p class="note">Quý khách vui lòng chọn ngày phù hợp</p>
                                </div>
                            </div>

                            <script>
                                // Lưu ý: TOUR_ID_PLACEHOLDER sẽ được thay bằng tourId thực tế khi JS chạy
                                window.startDateUrl = "{{ route('startDate', ['tourId' => 'TOUR_ID_PLACEHOLDER']) }}";
                            </script>

                            <script src="{{ asset('/public/clients/assets/js/selectStartDate-js.js') }}"></script>
                        </div>



                        <div class="tour-details-content">
                            <h3>Điểm nhấn của chương trình</h3>
                            <p>{!! nl2br(e($detailTour->description)) !!}</p>
                            <div class="row pb-55">
                                <div class="col-md-6">
                                    <div class="tour-include-exclude mt-30">
                                        <h5>Bao gồm và không bao gồm</h5>
                                        <ul class="list-style-one check mt-25">
                                            <li><i class="far fa-check"></i> Dịch vụ đón và trả khách</li>
                                            <li><i class="far fa-check"></i> 1 bữa ăn mỗi ngày</li>
                                            <li><i class="far fa-check"></i> Bữa tối & Sự kiện âm nhạc trên du thuyền
                                            </li>
                                            <li><i class="far fa-check"></i> Ghé thăm các địa điểm tốt nhất trong thành
                                                phố</li>
                                            <li><i class="far fa-check"></i> Nước đóng chai trên xe buýt</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="tour-include-exclude mt-30">
                                        <h5>Không bao gồm</h5>
                                        <ul class="list-style-one mt-25">
                                            <li><i class="far fa-times"></i> Tiền hoa</li>
                                            <li><i class="far fa-times"></i> Đón và trả khách tại khách sạn</li>
                                            <li><i class="far fa-times"></i> Bữa trưa, đồ ăn & đồ uống</li>
                                            <li><i class="far fa-times"></i> Dịch vụ bổ sung</li>
                                            <li><i class="far fa-times"></i> Bảo hiểm</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h3>Thông tin thêm về chuyến đi</h3>
                        <div class="tour-activities mt-30 mb-45">
                            <div class="tour-activity-item">
                                <i class="fas fa-map-marked-alt"></i>
                                <b>Điểm tham quan: <p style="font-size: 15px">{{ $detailTour->destination }}</p></b>
                            </div>

                            <div class="tour-activity-item">
                                <i class="fas fa-utensils"></i>
                                <b>Ẩm thực</b>
                            </div>

                            <div class="tour-activity-item">
                                <i class="fas fa-clock"></i>
                                <b>Thời gian</b>
                            </div>

                            <div class="tour-activity-item">
                                <i class="fas fa-users"></i>
                                <b>Đối tượng thích hợp: <p style="font-size: 15px">Cặp đôi, Gia đình nhiều thế hệ</p>
                                </b>
                            </div>
                            <div class="tour-activity-item">
                                <i class="fas fa-car"></i>
                                <b>Phương tiện</b>
                            </div>

                            <div class="tour-activity-item">
                                <i class="fas fa-gift"></i>
                                <b>Khuyến mãi</b>
                            </div>

                        </div>

                        <h3>Lịch trình</h3>
                        <div class="accordion-two mt-25 mb-60" id="faq-accordion-two">
                            @foreach ($detailTour->timeline as $timeline)
                                <div class="accordion-item">
                                    <h5 class="accordion-header">
                                        <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                            data-bs-target="#collapse{{ $loop->index }}">
                                            Ngày {{ $loop->index + 1 }}: {{ $timeline->tl_title }}
                                            <!-- Tiêu đề và Ngày -->
                                        </button>
                                    </h5>
                                    <div id="collapse{{ $loop->index }}" class="accordion-collapse collapse"
                                        data-bs-parent="#faq-accordion-two">
                                        <div class="accordion-body">
                                            <p>{{ $timeline->tl_description }}</p> <!-- Mô tả -->
                                        </div>
                                    </div>
                                </div>
                            @endforeach



                        </div>

                        <h3>Những câu hỏi thường gặp</h3>
                        <div class="accordion-one mt-25 mb-60" id="faq-accordion">
                            <div class="accordion-item">
                                <h5 class="accordion-header">
                                    <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne">
                                        01_Tôi có thể đặt tour du lịch hoặc gói du lịch như thế nào?
                                    </button>
                                </h5>
                                <div id="collapseOne" class="accordion-collapse collapse"
                                    data-bs-parent="#faq-accordion">
                                    <div class="accordion-body">
                                        <p>Bạn có thể đặt tour du lịch hoặc gói du lịch qua các trang web du lịch trực
                                            tuyến, đại lý du lịch, hoặc liên hệ trực tiếp với các công ty tổ chức tour.
                                            Nhiều website cung cấp các gói tour theo các điểm đến, với các mức giá và
                                            lịch trình khác nhau, giúp bạn dễ dàng chọn lựa.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h5 class="accordion-header">
                                    <button class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo">
                                        02_Gói du lịch bao gồm những gì?
                                    </button>
                                </h5>
                                <div id="collapseTwo" class="accordion-collapse collapse show"
                                    data-bs-parent="#faq-accordion">
                                    <div class="accordion-body">
                                        <p>Gói du lịch thường bao gồm: vận chuyển, lưu trú, ăn uống, tham quan, hướng
                                            dẫn viên và bảo hiểm du lịch (tuỳ chọn).</p>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h5 class="accordion-header">
                                    <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree">
                                        03_Chính sách hủy và hoàn tiền của bạn là gì?
                                    </button>
                                </h5>
                                <div id="collapseThree" class="accordion-collapse collapse"
                                    data-bs-parent="#faq-accordion">
                                    <div class="accordion-body">
                                        <p>- Hủy miễn phí: Nếu hủy trước một khoảng thời gian nhất định (ví dụ 7-14
                                            ngày), bạn sẽ được hoàn tiền đầy đủ.</p>
                                        <p>- Phí hủy: Hủy trong khoảng thời gian gần ngày đi có thể bị mất một phần phí.
                                        </p>
                                        <p>- Không hoàn tiền: Nếu hủy trong vòng 24-48 giờ trước ngày đi, thường không
                                            được hoàn tiền.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item">
                                <h5 class="accordion-header">
                                    <button class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#collapseFive">
                                        04_Tôi cần những giấy tờ gì để đi du lịch?
                                    </button>
                                </h5>
                                <div id="collapseFive" class="accordion-collapse collapse"
                                    data-bs-parent="#faq-accordion">
                                    <div class="accordion-body">
                                        <p>Để đi du lịch, bạn cần có: hộ chiếu, visa (nếu cần), CMND/CCCD, vé máy bay,
                                            và xác nhận đặt tour/hotel.</p>
                                    </div>
                                </div>
                            </div>
                        </div>


                        {{-- <div id="commentrating"> --}}
                        <h3>Đánh giá sao</h3>
                        <div class="clients-reviews bgc-black mt-30 mb-60"
                            style="display: flex; justify-content: center; align-items: center; text-align: center;">
                            <div class="left">
                                <b>{{ $tbRating->average_rating }}</b>
                                <span>({{ $tbRating->total_reviews }} bình luận)</span>
                                <div class="ratting">
                                    @for ($i = 0; $i < $tbRating->average_rating; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                </div>
                            </div>
                            <div class="right" style="color: white; text-align: left">
                                <div class="ratting">
                                    <span style="font-size: 20px">Số lượng đánh giá sao</span>
                                </div>
                                <br>
                                <div class="ratting" data-rating="5">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span>({{ $quantityRating[5] }})</span>
                                </div>
                                <br>
                                <div class="ratting" data-rating="4">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span>({{ $quantityRating[4] }})</span>
                                </div>
                                <br>
                                <div class="ratting" data-rating="3">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span>({{ $quantityRating[3] }})</span>
                                </div>
                                <br>
                                <div class="ratting" data-rating="2">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <span>({{ $quantityRating[2] }})</span>
                                </div>
                                <br>
                                <div class="ratting" data-rating="1">
                                    <i class="fas fa-star"></i>
                                    <span>({{ $quantityRating[1] }})</span>
                                </div>
                                <br>
                            </div>


                        </div>

                        <h3>Các Đánh Giá Của Khách Hàng</h3>
                        <div class="comments mt-30 mb-60">
                            @foreach ($reviews as $review)
                                <div class="comment-body" data-aos="fade-up" data-aos-duration="1500"
                                    data-aos-offset="50">
                                    <div class="author-thumb">
                                        <img src="{{ asset('/public/clients/assets//images/profile-user/' . ($review->user[0]->avatar ?? 'default.jpg')) }}"
                                            alt="Author">
                                    </div>
                                    <div class="content">
                                        <h6>
                                            {{ isset($review->user[0]->fullName) && !empty($review->user[0]->fullName) ? $review->user[0]->fullName : $review->user[0]->username }}
                                        </h6>
                                        <div class="ratting">
                                            @for ($i = 0; $i < $review->rating; $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                        </div>
                                        <p>{{ $review->comment }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{-- </div> --}}

                        @if (session()->has('userName') && in_array('f', $checkComment->toArray()))
                            <h3>Thêm Đánh giá</h3>
                            <form id="comment-form" class="comment-form bgc-lighter z-1 rel mt-30" name="review-form"
                                action="" method="post" data-aos="fade-up" data-aos-duration="1500"
                                data-aos-offset="50">
                                @csrf
                                <div class="comment-review-wrap">
                                    <div class="comment-ratting-item">
                                        <span class="title">Đánh giá</span>
                                        <div class="ratting" id="rating-stars">
                                            <i class="far fa-star" data-value="1"></i>
                                            <i class="far fa-star" data-value="2"></i>
                                            <i class="far fa-star" data-value="3"></i>
                                            <i class="far fa-star" data-value="4"></i>
                                            <i class="far fa-star" data-value="5"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Đây là input hidden để chứa số sao -->
                                <input type="hidden" name="rating" id="rating-value">
                                <input type="hidden" name="tourId" id="tourId"
                                    value="{{ $detailTour->tourId }}">

                                <hr class="mt-30 mb-40">
                                <h5>Để lại phản hồi</h5>
                                <div class="row gap-20 mt-20">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="message">Nội dung</label>
                                            <textarea name="comment" id="comment" class="form-control" rows="5" required=""></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group mb-0">
                                            <button type="submit" class="theme-btn bgc-secondary style-two"
                                                id="submit-reviews" data-url-checkBooking="" data-tourId-reviews="">
                                                <span data-hover="Gửi đánh giá">Gửi đánh giá</span>
                                                <i class="fal fa-arrow-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif

                        <script>
                            document.getElementById('submit-reviews').addEventListener('click', function(e) {
                                e.preventDefault(); // Chặn form submit mặc định

                                const selectedStars = document.querySelectorAll('#rating-stars i.active').length;
                                const content = document.getElementById('comment').value.trim();
                                const tourId = document.getElementById('tourId').value.trim();
                                if (selectedStars === 0) {
                                    toastr.error('Vui lòng chọn số sao đánh giá!');
                                    return;
                                }

                                if (content === '') {
                                    toastr.error('Vui lòng nhập nội dung đánh giá!');
                                    return;
                                }

                                const formData = new FormData();
                                formData.append('rating', selectedStars);
                                formData.append('comment', content);
                                formData.append('tourId', tourId);
                                formData.append('_token', '{{ csrf_token() }}'); // nếu bạn dùng Laravel

                                const commentsContainer = document.querySelector('.comments');
                                commentsContainer.style.display = 'none';
                                fetch('{{ route('reviewtours') }}', { // Đổi lại route bạn xử lý
                                        method: 'POST',
                                        body: formData,
                                    })
                                    .then(response => response.json())
                                    .then(data => {
                                        console.log('Server trả về:', data);
                                        if (!data.success && data.redirect) {
                                            window.location.href = data.redirect;
                                            return; // Dừng thực hiện tiếp nếu đã redirect
                                        }
                                        if (data.success) {
                                            toastr.success(data.message || 'Gửi đánh giá thành công!');
                                            document.getElementById('comment').value = '';
                                            updateStars(0);

                                            // Load lại phần bình luận
                                            commentsContainer.innerHTML = '';
                                            data.reviews.forEach(review => {
                                                commentsContainer.innerHTML += `
                                            <div class="comment-body" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50">
                                                <div class="author-thumb">
                                                <img src="{{ asset('/public/clients/assets/images/profile-user/' . ($review->user[0]->avatar ?? 'default.jpg')) }}" alt="Author">
                                                </div>
                                                <div class="content">
                                                    <h6>${review.user[0].fullName || review.user[0].username}</h6>
                                                    <div class="ratting">
                                                        ${'★'.repeat(review.rating).split('').map(() => '<i class="fas fa-star"></i>').join('')}
                                                    </div>
                                                    <p>${review.comment}</p>
                                                </div>
                                            </div>
                                        `;
                                            });
                                            commentsContainer.style.display = 'block';

                                            // ✅ Update lại phần đánh giá sao
                                            const ratingContainer = document.querySelector('.clients-reviews .left');
                                            if (ratingContainer) {
                                                const starsHtml = Array.from({
                                                    length: Math.floor(data.average_rating)
                                                }, () => '<i class="fas fa-star"></i>').join('');
                                                ratingContainer.innerHTML = `
                                            <b>${data.average_rating.toFixed(1)}</b>
                                            <span>(${data.total_reviews} bình luận)</span>
                                            <div class="ratting">
                                                ${starsHtml}
                                            </div>
                                        `;
                                            }
                                            const quantityRating = data.quantityRating;
                                            document.querySelector('.right .ratting[data-rating="5"] span').textContent =
                                                `(${quantityRating[5]})`;
                                            document.querySelector('.right .ratting[data-rating="4"] span').textContent =
                                                `(${quantityRating[4]})`;
                                            document.querySelector('.right .ratting[data-rating="3"] span').textContent =
                                                `(${quantityRating[3]})`;
                                            document.querySelector('.right .ratting[data-rating="2"] span').textContent =
                                                `(${quantityRating[2]})`;
                                            document.querySelector('.right .ratting[data-rating="1"] span').textContent =
                                                `(${quantityRating[1]})`;
                                        } else {
                                            toastr.error(data.message || 'Có lỗi xảy ra, vui lòng thử lại!');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        toastr.error('Lỗi kết nối server!');
                                    });
                            });

                            // Xử lý chọn sao
                            const stars = document.querySelectorAll('#rating-stars i');
                            stars.forEach(star => {
                                star.addEventListener('click', () => {
                                    const rating = parseInt(star.getAttribute('data-value'));
                                    updateStars(rating);
                                });
                            });

                            function updateStars(rating) {
                                stars.forEach(star => {
                                    if (parseInt(star.getAttribute('data-value')) <= rating) {
                                        star.classList.add('active');
                                        star.classList.remove('far');
                                        star.classList.add('fas');
                                    } else {
                                        star.classList.remove('active');
                                        star.classList.remove('fas');
                                        star.classList.add('far');
                                    }
                                });
                            }
                        </script>



                    </div>

                    <div class="col-lg-4 col-md-8 col-sm-10 rmt-75">
                        <div class="blog-sidebar tour-sidebar">
                            <div class="widget widget-booking" data-aos="fade-up" data-aos-duration="1500"
                                data-aos-offset="50">
                                <h5 class="widget-title">Tour Booking</h5>
                                <form id="bookingForm"
                                    action="{{ route('checkoutpage', ['id' => $detailTour->tourId]) }}"
                                    method="POST">

                                    @csrf
                                    <input type="hidden" id="tourId" value="{{ $detailTour->tourId }}">
                                    <input type="hidden" id="dateId" name="dateId" value="">

                                    <div class="date mb-25">
                                        <b>Ngày bắt đầu:</b>
                                        <input type="date" id="startDateInput" readonly>
                                    </div>
                                    <hr>
                                    <div class="date mb-25">
                                        <b>Ngày kết thúc:</b>
                                        <input type="date" id="endDateInput" readonly>
                                    </div>
                                    <hr>
                                    <div class="time py-5">
                                        <b>Thời Gian:</b>
                                        <p id="durationText">--</p>
                                    </div>
                                    <hr class="mb-25">
                                    <h6>Vé:</h6>
                                    <ul class="tickets clearfix">
                                        <li>
                                            Trẻ Em <span class="price" id="priceChildren">--</span>
                                        </li>
                                        <li>
                                            Người Lớn <span class="price" id="priceAdult">--</span>
                                        </li>
                                    </ul>
                                    <hr class="mb-25">
                                    <div class="time py-5">
                                        <b>Số Lượng</b>
                                        <p id="quantityText">--</p>
                                    </div>
                                    <hr class="mb-25">
                                    <button type="submit" class="theme-btn style-two w-100 mt-15 mb-5">
                                        <span data-hover="Book Now">Đặt ngay</span>
                                        <i class="fal fa-arrow-right"></i>
                                    </button>

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="widget widget-contact" data-aos="fade-up" data-aos-duration="1500"
                        data-aos-offset="50">
                        <h5 class="widget-title">Need Help?</h5>
                        <ul class="list-style-one">
                            <li><i class="far fa-envelope"></i> <a
                                    href="emilto:helpxample@gmail.com">voducviet2003@gmail.com</a></li>
                            <li><i class="far fa-phone-volume"></i> <a href="callto:+0369404100">+0369 404 100</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <link rel="stylesheet" href="{{ asset('/public/clients/assets//css/date-css.css') }}">
    <section class="destinations-area bgc-black pt-100 pb-70 rel z-1">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="section-title text-white text-center counter-text-wrap mb-70" data-aos="fade-up"
                        data-aos-duration="1500" data-aos-offset="50">
                        <h2>Khám phá kho báu thế giới cùng Vi Vu</h2>
                        <p>Các tour tương tự với tour đã chọn</p>
                    </div>
                </div>
            </div>
            @php
                use Carbon\Carbon;
            @endphp
            <div class="row justify-content-center">
                @foreach ($toursPopular as $tour)
                    @php
                        $firstDate = $tour->date;
                        $statusFavourite = $tour->favourite;
                    @endphp
                    <div class="col-xxl-3 col-xl-4 col-md-6">
                        <div class="destination-item h-100 d-flex flex-column" data-aos="fade-up"
                            data-aos-duration="1500" data-aos-offset="50">
                            <div class="image" style="position: relative; overflow: hidden; border-radius: 10px;">
                                <link rel="stylesheet"
                                    href="{{ asset('/public/clients/assets//css/favourite-css.css') }}">
                                <a href="#" class="heart {{ $statusFavourite == 1 ? 'heart_favou' : '' }}"
                                    data-tour-id="{{ $tour->tourId }}"
                                    onclick="toggleFavourite(event, '{{ $userId }}', {{ $tour->tourId }})">
                                    {{ $statusFavourite == 1 ? '❤' : '♡' }}
                                </a>
                                <img src="{{ asset('/public/image/' . $tour->image[0]) }}" alt="Tour List">
                                <script src="{{ asset('/public/clients/assets//js/favourite-js.js') }}"></script>
                            </div>
                            <div class="content flex-grow-1 d-flex flex-column justify-content-between">
                                <div>
                                    <span class="location"><i class="fal fa-map-marker-alt"></i> Tours,
                                        {{ trim(explode(',', $tour->destination)[0]) }}</span>
                                    <h5 class="mt-2 mb-2">
                                        <a href="{{ route('detailtourpage', ['id' => $tour->tourId]) }}"
                                            class="desc-truncate">{{ $tour->title }}</a>
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
                                                \Carbon\Carbon::parse($tour->promotion->startDate),
                                                \Carbon\Carbon::parse($tour->promotion->endDate)))
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
            </div>
        </div>
    </section>
    @include('clients.blocks.footer')
    <!-- Jquery -->
    <script src="{{ asset('/public/clients/assets//js/jquery-3.6.0.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('/public/clients/assets//js/bootstrap.min.js') }}"></script>
    <!-- Appear Js -->
    <script src="{{ asset('/public/clients/assets//js/appear.min.js') }}"></script>
    <!-- Slick -->
    <script src="{{ asset('/public/clients/assets//js/slick.min.js') }}"></script>
    <!-- Magnific Popup -->
    <script src="{{ asset('/public/clients/assets//js/jquery.magnific-popup.min.js') }}"></script>
    <!-- Nice Select -->
    <script src="{{ asset('/public/clients/assets//js/jquery.nice-select.min.js') }}"></script>
    <!-- Image Loader -->
    <script src="{{ asset('/public/clients/assets//js/imagesloaded.pkgd.min.js') }}"></script>

    <!-- Jquery UI -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('/public/clients/assets//js/jquery-ui.min.js') }}"></script>
    <!-- Isotope -->
    <script src="{{ asset('/public/clients/assets//js/isotope.pkgd.min.js') }}"></script>
    <!--  AOS Animation -->
    <script src="{{ asset('/public/clients/assets//js/aos.js') }}"></script>
    <!-- Custom script -->
    <script src="{{ asset('/public/clients/assets//js/script.js') }}"></script>
    <script src="{{ asset('/public/clients/assets//js/custom-js.js') }}"></script>
    <script src="{{ asset('/public/clients/assets//js/header-js.js') }}"></script>

</body>

</html>
