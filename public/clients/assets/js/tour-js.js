document.addEventListener('DOMContentLoaded', function () {
    // Khởi tạo AOS
    AOS.init();

    const form = document.getElementById('searchTourForm');
    const tourList = document.getElementById('tourList');

    function submitFormAjax() {
        const formData = new FormData(form);
        tourList.innerHTML = '<p>Đang tải...</p>';

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
                if (data.tours && data.tours.length > 0) {
                    let html = '';
                    data.tours.forEach(tour => {
                        const start = new Date(tour.startDate);
                        const end = new Date(tour.endDate);
                        const days = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
                        const nights = days - 1;

                        html += `
                        <div class="destination-item style-three bgc-lighter" data-aos="fade-up" data-aos-duration="1500" data-aos-offset="50" style="margin-top: 70px">
                            <div class="image">
                                <span class="badge bgc-pink">Featured</span>
                                <a href="#" class="heart"><i class="fas fa-heart"></i></a>
                                <img src="/DATN_TOUR/public/image/${tour.image?.[0] || 'default.jpg'}" alt="Tour List">
                            </div>
                            <div class="content">
                                <div class="destination-header">
                                    <span class="location"><i class="fal fa-map-marker-alt"></i>${tour.destination.split(',')[0].trim()}</span>
                                    <div class="ratting">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </div>
                                <h5><a href="/detailtourpage/${tour.tourId}">${tour.title}</a></h5>
                                <span class="time d-block mt-1"><i class="far fa-calendar-alt"></i> Ngày khởi hành: ${start.toLocaleDateString('vi-VN')}</span>
                                <ul class="blog-meta">
                                    <li><i class="far fa-clock"></i> ${days}N${nights}Đ</li>
                                    <li><i class="far fa-user"></i>${tour.quantity}</li>
                                </ul>
                                <div class="destination-footer">
                                    <span class="price"><span>${new Intl.NumberFormat('vi-VN').format(tour.priceAdult)}₫</span></span>
                                    <a href="/DATN_TOUR/public/detailtour/${tour.tourId}" class="theme-btn style-two style-three">
                                        <span data-hover="Book Now">Book Now</span>
                                        <i class="fal fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                    });
                    tourList.innerHTML = html;
                    AOS.refresh();
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
                }
            })
            .catch(error => {
                console.error('Error:', error);
                tourList.innerHTML = '<p>Đã xảy ra lỗi. Vui lòng thử lại.</p>';
            });
    }

    // Xử lý custom dropdown
    const selectedOption = document.getElementById('selected-option');
    const optionsList = document.getElementById('select-options');
    const sortInput = document.getElementById('sortInput');

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

            console.log('Bạn đã chọn:', selectedValue);
            submitFormAjax();
        });
    });

    // Đóng dropdown nếu click ra ngoài
    document.addEventListener('click', function (e) {
        if (!document.getElementById('custom-select').contains(e.target)) {
            optionsList.style.display = 'none';
        }
    });

    // Cũng xử lý khi form được submit thủ công (nếu có)
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        submitFormAjax();
    });
});