<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Quên Mật Khẩu</title>

   

    <link rel="shortcut icon" href="{{ asset('/public/clients/assets/images/logos/lolo1.png') }}" type="image/x-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&amp;display=swap" rel="stylesheet">
    
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

     <!-- Font Icon -->
     <link rel="stylesheet" href="{{ asset('/public/clients/login_signup/fonts/material-icon/css/material-design-iconic-font.min.css') }}">

     <!-- Main css -->
     <link rel="stylesheet" href="{{ asset('/public/clients/login_signup/css/style.css') }}">
     <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/custom-css.css') }}">
     <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
    overflow: hidden;
}
    </style>
</head>
<body>
    @include('clients.blocks.headerpage')
<div class="main" style="padding-top: 25px;">
        <!-- Sing in  Form -->
        <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="{{ asset('/public/clients/login_signup/images/forgot.jpg') }}" alt="sing up image"></figure>
                        <a href="{{ route('loginpage') }}" class="signup-image-link">Đăng nhập</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Quên Mật Khẩu</h2>
                        <form action="{{ route('forgot')}}" method="POST" class="login-form" id="login-form" style="margin-top: 15px">
                            @csrf
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="username_login_old" id="username_login_old" placeholder="Tên đăng nhập" required/>
                            </div>
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-email"></i></label>
                                <input type="text" name="email" id="email" placeholder="Email" required/>
                            </div>
                            @if (session('error'))
                                <span id="error_login" class="alert alert-danger" style="display: block; font-size: 12px; margin-top: 5px;">
                                    {{ session('error') }}
                                </span>
                            @endif
                           @if (session('success'))
                                <span id="error_login" class="alert alert-success" style="display: block; font-size: 12px; margin-top: 5px;">
                                    {{ session('success') }}
                                </span>
                            @endif

                            <div class="form-group form-button" style="display: flex; justify-content: center;">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Xác nhận" />
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                    const emailInput = document.getElementById('email');
                                    const usernameInput = document.getElementById('username_login_old');
                                    const errorMessage = document.getElementById('error_login');

                                    if (errorMessage) {
                                        [emailInput, usernameInput].forEach(input => {
                                            input.addEventListener('input', function () {
                                                errorMessage.style.display = 'none';
                                            });
                                        });
                                    }
                                });
                            </script>

                        </form>
                        
                    </div>
                </div>
            </div>
        </section>
    </div>
    
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
    <!-- Custom script -->
    <script src="{{ asset('/public/clients/assets/js/script.js') }}"></script>
    {{-- <script src="{{ asset('/public/clients/assets/js/custom-js.js') }}"></script> --}}
    <script src="{{ asset('/public/clients/assets/js/header-js.js') }}"></script>


</body>
</html>