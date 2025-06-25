$(document).ready(function () {

    var sqlInjectionPattern = /[<>'"%;()&+]/;

    /****************************************
     *              PAGE LOGIN              *
     * ***************************************/
    //Handle click switch tab
    $("#sign-up").click(function () {
        $(".sign-in").hide();
        $(".signup").show();
    });
    $('#message').hide();
    $('#error').hide();
    $('#error_login').hide();

    $("#sign-in").click(function () {
        $(".signup").hide();
        $(".sign-in").show();
    });

    // Handle form submission for signin
    $("#login-form").on("submit", function (e) {
        e.preventDefault();
        var userName = $("#username_login").val().trim();
        var password = $("#password_login").val().trim();

        // Đặt lại nội dung thông báo lỗi và ẩn chúng
        $("#validate_username").hide().text("");
        $("#validate_password").hide().text("");

        var isValid = true;

        // Kiểm tra độ dài mật khẩu
        if (password.length < 6) {
            isValid = false;
            $("#validate_password")
                .show()
                .text("Mật khẩu phải có ít nhất 6 ký tự.");
        }

        // Kiểm tra tên đăng nhập và mật khẩu không chứa ký tự đặc biệt (SQL injection)
        
        if (sqlInjectionPattern.test(userName)) {
            isValid = false;
            $("#validate_username")
                .show()
                .text("Tên đăng nhập không được chứa ký tự đặc biệt.");
        }

        if (sqlInjectionPattern.test(password)) {
            isValid = false;
            $("#validate_password")
                .show()
                .text("Mật khẩu không được chứa ký tự đặc biệt.");
        }

        if (isValid) {
            var formData = {
                username: userName,
                password: password,
                _token: $('input[name="_token"]').val(),
            };
            console.log(formData, $(this).attr("action"));

            $.ajax({
                type: "POST",
                url: $(this).attr("action"),
                data: formData,
                success: function (response) {
                    if (response.success) {
                        window.location.href = response.redirecUrl;
                    } else {
                        $('#error_login').text(response.message).show();
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    toastr.error("Có lỗi xảy ra. Vui lòng thử lại sau.");
                },
            });
        }
    });

    // Handle form submission for signup
    $("#register-form").on("submit", function (e) {
        e.preventDefault();
        
        // Hiển thị loader và ẩn form
        $(".loader").show();
        $("#register-form").addClass("hidden-content");
    
        // Lấy giá trị của các trường nhập liệu
        var userName = $("#username_register").val().trim();
        var email = $("#email_register").val().trim();
        var password = $("#password_register").val().trim();
        var rePass = $("#re_pass").val().trim();
    
        // Đặt lại nội dung thông báo lỗi và ẩn chúng
        $("#validate_username_regis").hide().text("");
        $("#validate_email_regis").hide().text("");
        $("#validate_password_regis").hide().text("");
        $("#validate_repass").hide().text("");
        $("#message").hide().text(""); // Đảm bảo thông báo thành công được reset
        $("#error").hide().text("");   // Đảm bảo thông báo lỗi được reset
    
        // Kiểm tra lỗi
        var isValid = true;
    
        // Kiểm tra SQL Injection (Định nghĩa regex để kiểm tra ký tự đặc biệt nguy hiểm)
        var sqlInjectionPattern = /[;'"\\-]/; // Ký tự nguy hiểm: ; ' " \ -
        if (sqlInjectionPattern.test(userName)) {
            isValid = false;
            $("#validate_username_regis")
                .show()
                .text("Tên tài khoản không được chứa ký tự đặc biệt.");
        }
    
        // Kiểm tra định dạng email
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            isValid = false;
            $("#validate_email_regis").show().text("Email không hợp lệ.");
        }
    
        // Kiểm tra mật khẩu
        if (password.length < 6) {
            isValid = false;
            $("#validate_password_regis")
                .show()
                .text("Mật khẩu phải có ít nhất 6 ký tự.");
        }
    
        if (sqlInjectionPattern.test(password)) {
            isValid = false;
            $("#validate_password_regis")
                .show()
                .text("Mật khẩu không được chứa ký tự đặc biệt nguy hiểm.");
        }
    
        // Kiểm tra nhập lại mật khẩu
        if (password !== rePass) {
            isValid = false;
            $("#validate_repass").show().text("Mật khẩu nhập lại không khớp.");
        }
    
        // Nếu dữ liệu hợp lệ, gửi AJAX
        if (isValid) {
            var formData = {
                username_regis: userName,
                email: email,
                password_regis: password,
                _token: $('input[name="_token"]').val(),
            };
            console.log(formData, $(this).attr("action"));
    
            $.ajax({
                type: "POST",
                url: $(this).attr("action"),
                data: formData,
                timeout: 10000, // Timeout sau 10 giây
                success: function (response) {
                    if (response.success) {
                        // Hiển thị thông báo thành công
                        $('#message').text(response.message).show();
                        $('#error').hide();
                        
                        // Reset form
                        $("#register-form")[0].reset();
                        
                        // Hiển thị lại form đã reset
                        $("#register-form").removeClass("hidden-content");
                    } else {
                        // Hiển thị thông báo lỗi
                        $('#error').text(response.message).show();
                        $('#message').hide();
                        $("#register-form").removeClass("hidden-content");
                    }
                },
                error: function (xhr, textStatus, errorThrown) {
                    console.log(xhr, textStatus, errorThrown); // Ghi log lỗi để debug
                    toastr.error("Có lỗi xảy ra. Vui lòng thử lại sau.");
                    $("#register-form").removeClass("hidden-content");
                },
                complete: function () {
                    $(".loader").hide(); // Luôn ẩn loader sau khi yêu cầu hoàn tất
                }
            });
        } else {
            // Nếu dữ liệu không hợp lệ, ẩn loader và hiển thị lại form
            $(".loader").hide();
            $("#register-form").removeClass("hidden-content");
        }
    });

    /****************************************
     *              HOME PAGE             *
     * ***************************************/
    $("#start_date, #end_date").datetimepicker({
        format: "d/m/Y",
        timepicker: false,
    });
    /****************************************
     *              HEADER                  *
     * ***************************************/
    $('#userDropdown').click(function(){
        $('#dropdownMenu').toggle(); // Khi click vào button, toggle hiển thị menu
    });

   


});
