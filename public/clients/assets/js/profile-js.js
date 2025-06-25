$(document).ready(function () {
    $(".updateUser").on("submit", function (e) {
        e.preventDefault(); // chặn submit mặc định

        // Ẩn lỗi cũ
        $("#telError").text("").hide();

        const phone = $("#inputPhoneNumber").val().trim();
        const phonePattern = /^[0-9]{10,11}$/;

        let isValid = true;

        if (phone === "") {
            $("#telError").text("Số điện thoại không được để trống").show();
            isValid = false;
        } else if (!phonePattern.test(phone)) {
            $("#telError").text("Số điện thoại phải có 10-11 chữ số").show();
            isValid = false;
        }
        $("#birthError").text("").hide();

        const birthday = $("#inputBirthday").val();
        const today = new Date().toISOString().split('T')[0]; // YYYY-MM-DD

        if (birthday >= today) {
            $("#birthError").text("Ngày sinh không được lớn hơn hoặc bằng ngày hiện tại").show();
            isValid = false;
        }

        if (!isValid) {
            return; // ngừng submit nếu không hợp lệ
        }

        // Dữ liệu gửi đi
        const dataUpdate = {
            inputFullName: $("#inputFullName").val().trim(),
            inputAddress: $("#inputAddress").val().trim(),
            inputPhoneNumber: phone,
            inputBirthday: $("#inputBirthday").val().trim(),
            _token: $('input[name="_token"]').val()
        };

        $.ajax({
            type: "POST",
            url: $(this).attr("action"),
            data: dataUpdate,
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function () {
                toastr.error("Có lỗi xảy ra. Vui lòng thử lại sau.");
            }
        });
    });
});

$(document).ready(function () {
    const sqlInjectionPattern = /[<>\"\'%;()&+]/; // mẫu ký tự đặc biệt nguy hiểm

    $(".change_password").on("submit", function (e) {
        e.preventDefault();

        var oldPass = $("#inputOldPass").val().trim();
        var newPass = $("#inputNewPass").val().trim();
        var isValid = true;

        // Reset thông báo
        $("#validate_password").hide().text("");

        // Kiểm tra độ dài mật khẩu
        if (oldPass.length < 6 || newPass.length < 6) {
            isValid = false;
            $("#validate_password")
                .show()
                .text("Mật khẩu phải có ít nhất 6 ký tự.");
        }

        // Kiểm tra ký tự đặc biệt
        else if (sqlInjectionPattern.test(newPass)) {
            isValid = false;
            $("#validate_password")
                .show()
                .text("Mật khẩu không được chứa ký tự đặc biệt như < > \" ' % ; ( ) & +");
        }

        if (isValid) {
            var updatePass = {
                inputOldPass: oldPass,
                inputNewPass: newPass,
                _token: $('input[name="_token"]').val(),
            };

            $.ajax({
                type: "POST",
                url: $(this).attr("action"),
                data: updatePass,
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        $("#validate_password").hide();
                        $(".change_password")[0].reset();
                      
                    } else {
                        toastr.error(response.message);
                        $("#validate_password").show().text(response.message);
                    }
                },
                error: function (xhr) {
                    let errMsg = xhr.responseJSON?.message || "Đã xảy ra lỗi. Vui lòng thử lại.";
                    toastr.error(errMsg);
                    $("#validate_password").show().text(errMsg);
                },
            });
        }
    });
});

$(document).ready(function () {
    $("#avatar").on("change", function (event) {
        const file = event.target.files[0];
        if (!file) return;

        // Xem trước ảnh
        const reader = new FileReader();
        reader.onload = function (e) {
            $("#avatarPreview").attr("src", e.target.result);
        };
        reader.readAsDataURL(file);

        // Tạo FormData để gửi ảnh
        const formData = new FormData();
        formData.append("avatar", file);

        // Lấy token và URL
        const csrfToken = $("#csrfToken").val();
        const uploadUrl = $("#uploadAvatarUrl").val();

        // Gửi ảnh qua Ajax
        $.ajax({
            url: uploadUrl,
            type: "POST",
            headers: {
                "X-CSRF-TOKEN": csrfToken
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message);
                } else {
                    toastr.error(response.message);
                }
            },
            error: function () {
                toastr.error("Có lỗi xảy ra. Vui lòng thử lại sau.");
            }
        });
    });
});