$(document).ready(function () {
    let discount = 0;
    let totalPrice = 0;
    const codeCoupon = (document.getElementById('codeCoupon')?.value || "").trim();
    const discountCoupon = parseInt(document.getElementById('discount')?.value) || 0;
    function updateSummary() {
        const numAdults = parseInt($("#numAdults").val()) || 0;
        const numChildren = parseInt($("#numChildren").val()) || 0;

        const adultPrice = parseInt($("#numAdults").data("price-adults")) || 0;
        const childPrice = parseInt($("#numChildren").data("price-children")) || 0;

        const adultsTotal = numAdults * adultPrice;
        const childrenTotal = numChildren * childPrice;

        // Luôn cập nhật giá trị mã giảm giá và số tiền giảm giá mỗi lần gọi


        // Lấy mã người dùng nhập
        const couponInput = ($(".order-coupon input").val() || "").trim();

        // Hiển thị số lượng
        $(".quantity__adults").text(numAdults);
        $(".quantity__children").text(numChildren);

        // Hiển thị tổng từng loại
        $(".summary-item:nth-child(1) .total-price").text(adultsTotal.toLocaleString() + " VNĐ");
        $(".summary-item:nth-child(2) .total-price").text(childrenTotal.toLocaleString() + " VNĐ");

        // Tính giảm giá nếu mã khớp
        discount = (couponInput === codeCoupon) ? discountCoupon : 0;

        // Cập nhật giảm giá
        $(".summary-item:nth-child(3) .total-price").text(discount.toLocaleString() + " VNĐ");

        // Tổng cộng
        totalPrice = adultsTotal + childrenTotal - discount;
        $(".final-total-display").text(totalPrice.toLocaleString() + " VNĐ");
        $(".totalPrice").val(totalPrice);
    }


    function toggleButtonState() {
        if ($("#agree").is(":checked")) {
            $(".btn-submit-booking").removeClass("inactive").css("pointer-events", "auto");
        } else {
            $(".btn-submit-booking").addClass("inactive").css("pointer-events", "none");
        }
    }

    function validateBookingForm() {
        let isValid = true;
        $(".error-message").hide();

        const username = $("#username").val().trim();
        if (username === "") {
            $("#usernameError").text("Họ và tên không được để trống").show();
            isValid = false;
        }

        const email = $("#email").val().trim();
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/;
        if (email === "") {
            $("#emailError").text("Email không được để trống").show();
            isValid = false;
        } else if (!emailPattern.test(email)) {
            $("#emailError").text("Email không đúng định dạng").show();
            isValid = false;
        }

        const tel = $("#tel").val().trim();
        const telPattern = /^[0-9]{10,11}$/;
        if (tel === "") {
            $("#telError").text("Số điện thoại không được để trống").show();
            isValid = false;
        } else if (!telPattern.test(tel)) {
            $("#telError").text("Số điện thoại phải có 10-11 chữ số").show();
            isValid = false;
        }

        const address = $("#address").val().trim();
        if (address === "") {
            $("#addressError").text("Địa chỉ không được để trống").show();
            isValid = false;
        }

        const paymentMethod = $("input[name='payment']:checked").val();
        if (!paymentMethod) {
            toastr.error("Vui lòng chọn phương thức thanh toán.");
            isValid = false;
        }

        if (isValid) {
            formDataBooking = {
                'tourId': tourId,
                'fullName': username,
                'email': email,
                'tel': tel,
                'address': address,
                'numAdults': numAdults,
                'numChildren': numChildren,
                'totalPrice': totalPrice,
                'paymentMethod': paymentMethod,
                '_token': $('input[name="_token"]').val()
            }
            console.log(formDataBooking);

        }

        return isValid;
    }

    // Nút tăng giảm
    $(".quantity-selector .quantity-btn").click(function () {
        const input = $(this).siblings("input");
        let value = parseInt(input.val()) || 0;
        const min = parseInt(input.attr("min")) || 0;
        const maxSlots = parseInt($("#remainingSlots").data("slots")) || 0;

        // Lấy ID để xác định là người lớn hay trẻ em
        const inputId = input.attr("id");
        const otherValue = inputId === "numAdults"
            ? parseInt($("#numChildren").val()) || 0
            : parseInt($("#numAdults").val()) || 0;

        // Nếu là nút giảm
        if ($(this).text() === "-" && value > min) {
            value--;
        }

        // Nếu là nút tăng
        else if ($(this).text() === "+") {
            // Kiểm tra tổng số người sẽ là bao nhiêu sau khi tăng
            if ((value + 1 + otherValue) > maxSlots) {
                toastr.warning("Tổng số người vượt quá số chỗ còn lại.");
                return; // Ngừng tăng nếu vượt quá số chỗ
            }
            value++; // Tăng giá trị
        }

        // Cập nhật giá trị vào input
        input.val(value);

        // Cập nhật lại thông tin tổng số và tổng tiền
        updateSummary();
    });



    // Khi người dùng nhập trực tiếp vào ô input
    $("#numAdults, #numChildren").on("change keyup", function () {
        updateSummary();
    });

    $(".btn-coupon").click(function (e) {
        e.preventDefault();
        const couponCode = $(".order-coupon input").val().trim();

        if (couponCode === codeCoupon) {
            toastr.success("Mã giảm giá hợp lệ!");
        } else {
            toastr.error("Mã giảm giá không hợp lệ.");
        }

        updateSummary();
    });

    $("#agree").on("change", function () {
        toggleButtonState();
    });

    $(".btn-submit-booking").on("click", function (e) {
        e.preventDefault();
        // if (validateBookingForm()) {
        //     $(".booking-container").submit();
        // }
        let isValid = true;
        $(".error-message").hide();

        const tourId = $("#tourId").val().trim();
        const dateId = $("#dateId").val().trim();
        const numAdults = $("#numAdults").val().trim();
        const numChildren = $("#numChildren").val().trim();
        const username = $("#username").val().trim();

        if (username === "") {
            $("#usernameError").text("Họ và tên không được để trống").show();
            isValid = false;
        }

        const email = $("#email").val().trim();
        const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/;
        if (email === "") {
            $("#emailError").text("Email không được để trống").show();
            isValid = false;
        } else if (!emailPattern.test(email)) {
            $("#emailError").text("Email không đúng định dạng").show();
            isValid = false;
        }

        const tel = $("#tel").val().trim();
        const telPattern = /^[0-9]{10,11}$/;
        if (tel === "") {
            $("#telError").text("Số điện thoại không được để trống").show();
            isValid = false;
        } else if (!telPattern.test(tel)) {
            $("#telError").text("Số điện thoại phải có 10-11 chữ số").show();
            isValid = false;
        }

        const address = $("#address").val().trim();
        if (address === "") {
            $("#addressError").text("Địa chỉ không được để trống").show();
            isValid = false;
        }

        const paymentMethod = $("input[name='payment']:checked").val();
        if (!paymentMethod) {
            toastr.error("Vui lòng chọn phương thức thanh toán.");
            isValid = false;
        }

        if (isValid) {
            formDataBooking = {
                'tourId': tourId,
                'dateId': dateId,
                'fullName': username,
                'email': email,
                'tel': tel,
                'address': address,
                'numAdults': numAdults,
                'numChildren': numChildren,
                'totalPrice': totalPrice,
                'paymentMethod': paymentMethod,
                '_token': $('input[name="_token"]').val()
            }
            // urlBooking = $('.booking-container').attr("action");

            console.log(formDataBooking);
            $(".booking-container").submit();

        }
    });

    $('input[name="payment"]').change(function () {
        const paymentMethod = $(this).val();
        $("#payment_hidden").val(paymentMethod);

        // Kiểm tra nếu là momo thì ẩn nút xác nhận
        const isPaymentSelected = paymentMethod === "momo-payment";

        $(".btn-submit-booking").toggle(!isPaymentSelected); // Ẩn hoặc hiện nút xác nhận

        // Xử lý cho MOMO
        if (paymentMethod === "momo-payment") {
            $("#btn-momo-payment").show(); // Hiện nút thanh toán momo
        } else {
            $("#btn-momo-payment").hide(); // Ẩn nếu không chọn momo
        }

        // Xóa mọi thành phần PayPal nếu có (phòng trường hợp render lại)
        $("#paypal-button-container").empty();
    });


    $("#btn-momo-payment").click(function (e) {
        e.preventDefault();
        const urlMomo = $(this).data("urlmomo");

        if (!validateBookingForm()) {
            return; // Dừng nếu form không hợp lệ
        }

        // Tạo bookingData
        const bookingData = {
            fullName: $("#username").val().trim(),
            email: $("#email").val().trim(),
            tel: $("#tel").val().trim(),
            address: $("#address").val().trim(),
            numAdults: parseInt($("#numAdults").val()) || 0,
            numChildren: parseInt($("#numChildren").val()) || 0,
            payment: $("input[name='payment']:checked").val(),
            payment_hidden: $("#payment_hidden").val(),
            totalPrice: totalPrice,
            tourId: $("#tourId").val().trim(),
            dateId: $("#dateId").val().trim(),
            _token: $('input[name="_token"]').val()
        };

        // Kiểm tra dữ liệu trước khi gửi
        if (!bookingData.fullName || !bookingData.email || !bookingData.tel || !bookingData.address) {
            toastr.error("Vui lòng điền đầy đủ thông tin.");
            return;
        }

        if (bookingData.numAdults < 1) {
            toastr.error("Số lượng người lớn phải lớn hơn 0.");
            return;
        }

        // Lưu vào localStorage với key cố định (tùy chọn, nên lưu ở server)
        localStorage.setItem("bookingData", JSON.stringify(bookingData));
        console.log('Booking data saved to localStorage:', bookingData);

        // Gửi yêu cầu AJAX đến server
        $.ajax({
            url: urlMomo,
            method: "POST",
            data: {
                amount: totalPrice,
                tourId: bookingData.tourId,
                dateId: bookingData.dateId,
                _token: bookingData._token,
                bookingData: JSON.stringify(bookingData)
            },
            success: function (response) {
                console.log('MoMo response:', response);
                if (response && response.payUrl) {
                    // Chuyển hướng đến trang thanh toán MoMo
                    window.location.href = response.payUrl;
                } else {
                    toastr.error("Không thể tạo thanh toán MoMo: " + (response.error || "Lỗi không xác định"));
                    localStorage.removeItem("bookingData"); // Xóa dữ liệu nếu thất bại
                }
            },
            error: function (xhr) {
                console.error('MoMo AJAX error:', xhr);
                toastr.error("Có lỗi xảy ra khi kết nối đến MoMo.");
                localStorage.removeItem("bookingData"); // Xóa dữ liệu nếu thất bại
            }
        });
    });

    // Khởi động
    updateSummary();
    toggleButtonState();
});