$(document).ready(function() {
    let triggerButton = null;
    toastr.options = {
        "closeButton": true, // Hiển thị nút đóng
        "progressBar": true, // Hiển thị thanh tiến độ
        "showMethod": "fadeIn", // Phương thức hiển thị (fadeIn cho hiệu ứng mượt mà)
        "hideMethod": "fadeOut", // Phương thức ẩn (fadeOut để biến mất từ từ)
        "timeOut": 1000, // Thời gian hiển thị toastr (1000ms = 1 giây)
        "extendedTimeOut": 1000, // Thời gian khi người dùng hover lên toastr (để đảm bảo toastr biến mất nhanh)
        "hideEasing": "linear", // Hiệu ứng ẩn (linear để hiệu ứng ẩn nhanh)
        "showEasing": "linear"  // Hiệu ứng hiển thị (linear để hiệu ứng hiện nhanh)
    };

    // Khi mở modal
    $('#cancelTourModal').on('show.bs.modal', function(event) {
        triggerButton = $(event.relatedTarget); // Lưu lại nút kích hoạt modal
        var bookingId = triggerButton.data('booking-id');
        var destination = triggerButton.data('destination');

        console.log('Tour ID (show modal):', bookingId);
        console.log('Destination (show modal):', destination);

        var modal = $(this);
        modal.find('#tourId').val(bookingId); // Cập nhật giá trị vào input ẩn
        modal.find('#tourDestination').text(destination); // Cập nhật tên điểm đến vào modal
    });

    // Khi modal đóng
    $('#cancelTourModal').on('hidden.bs.modal', function() {
        triggerButton = null; // Reset lại khi modal đóng
        $('#cancelTourForm')[0].reset(); // Reset form khi modal đóng
    });

    // Submit form hủy tour qua AJAX
    $('#cancelTourForm').submit(function(e) {
        e.preventDefault(); // Ngăn form submit mặc định

        if (!triggerButton) {
            toastr.error('Không xác định được tour cần hủy.');
            return;
        }

        var bookingId = triggerButton.data('booking-id');

        console.log('Tour ID (submit):', bookingId);

        $.ajax({
            url: window.cancelTourUrl, // Dùng route từ biến JavaScript
            type: 'POST',
            data: {
                bookingId: bookingId,
                _token: $('meta[name="csrf-token"]').attr('content') // Sử dụng token CSRF nếu có trong meta
            },
            success: function(response) {
                toastr.success(response.message || 'Hủy tour thành công.');
                $('#cancelTourModal').modal('hide');
                location.reload(); // Làm mới trang
            },
            error: function(xhr) {
                var errorMsg = 'Đã xảy ra lỗi.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                toastr.error(errorMsg); // Hiển thị lỗi nếu có
            }
        });
    });
});
