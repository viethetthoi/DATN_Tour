function toggleFavourite(event, userId, tourId) {
    event.preventDefault();

    $.ajax({
        url: 'http://localhost/DATN_TOUR/favourite-tour/' + userId + '/' + tourId + '/toggle-favourite',
        method: 'GET',
        success: function(response) {
            if (response.status === 'success') {
                var heart = $('a[data-tour-id="' + tourId + '"]'); // Tìm theo đúng tourId
                if (response.favourite == -1) {
                    window.location.href = './login';
                    return;
                }
                if (response.favourite == 1) {
                    heart.addClass('heart_favou');
                    heart.html('❤');
                    toastr.success('Đã thêm vào danh sách yêu thích!');
                } else {
                    heart.removeClass('heart_favou');
                    heart.html('♡');
                    toastr.success('Đã bỏ khỏi danh sách yêu thích!');
                }
            } else {
                toastr.error('Có lỗi xảy ra!');
            }
        },
        error: function(xhr) {
            toastr.error('Không thể kết nối tới server!');
        }
    });
}