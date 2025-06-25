<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">


    <title>Thông tin cá nhân</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="shortcut icon" href="{{ asset('/public/clients/assets/images/logos/lolo1.png') }}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/flaticon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/fontawesome-5.14.0.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/magnific-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/nice-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/slick.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/custom-css.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('/public/clients/assets/css/profileUser-css.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />


</head>

<body>
    @include('clients.blocks.headerpage')
    <div class="container-xl px-4 mt-4">
        <div class="row">
            <div class="col-xl-4">
                <div class="card mb-4 mb-xl-0">
                    <div class="card-header">Ảnh đại diện</div>
                    <div id="avatarView" class="card-body text-center">
                        <img class="img-account-profile rounded-circle mb-2" id="avatarPreview"
                            src="{{ asset('/public/clients/assets/images/profile-user/' . ($user->avatar ?? 'default.jpg')) }}"
                            alt>
                        <div class="small font-italic text-muted mb-4">JPG hoặc PNG không quá 5 MB</div>
                        <input type="file" name="avatar" id="avatar" style="display: none;">
                        <label for="avatar" class="btn btn-primary">Tải ảnh mới</label>
                    </div>
                    <input type="hidden" id="csrfToken" value="{{ csrf_token() }}">
                    <input type="hidden" id="uploadAvatarUrl" value="{{ route('avatar-profile') }}">
                    @if (!isset($user->google_id))
                        <form action="{{ route('password-profile') }}" method="POST" class="change_password">
                            @csrf
                            <div class="card-body text-center"
                                style="background-color: rgb(235, 229, 229); margin-top: 10px;">
                                <div class="invalid-feedback d-block" id="validate_password"
                                    style="display:none; margin-top:-15px;"></div>

                                <div class="mb-3">
                                    <label class="small mb-1" for="inputOldPass">Mật khẩu hiện tại</label>
                                    <input class="form-control" id="inputOldPass" type="password"
                                        placeholder="Nhập mật khẩu cũ" name="inputOldPass" required>
                                </div>
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputNewPass">Mật khẩu mới</label>
                                    <input class="form-control" id="inputNewPass" type="password"
                                        placeholder="Nhập mật khẩu mới" name="inputNewPass" required>
                                </div>
                                <div class="col-md-4 mx-auto">
                                    <input type="submit" class="btn btn-primary" value="Đổi mật khẩu" />
                                </div>
                            </div>
                        </form>    
                    @endif
                    
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header">Thông tin cá nhân</div>
                    <div class="card-body">
                        <form action="{{ route('update-profile-user') }}" method="POST" class="updateUser">
                            @csrf
                            <div class="mb-3">
                                <label class="small mb-1" for="inputUsername">Tên tài khoản</label>
                                <input class="form-control" id="inputUsername" type="text"
                                    placeholder="Enter your username" value="{{ $user->userName }}" readonly>
                            </div>

                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputLastName">Họ và tên</label>
                                    <input class="form-control" id="inputFullName" type="text"
                                        name="inputFullName" placeholder="Họ và tên"
                                        value="{{ isset($user->fullName) ? $user->fullName : '' }}">

                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputLocation">Địa chỉ</label>
                                    <input class="form-control" id="inputAddress" type="text" name="inputAddress"
                                        placeholder="Địa chỉ"
                                        value="{{ isset($user->address) ? $user->address : '' }}">
                                </div>
                            </div>


                            <div class="mb-3">
                                <label class="small mb-1" for="inputEmailAddress">Email</label>
                                <input class="form-control" id="inputEmailAddress" type="email"
                                    placeholder="Enter your email address" value="{{ $user->email }}" readonly>
                            </div>

                            <div class="row gx-3 mb-3">

                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputPhone">Số điện thoại</label>
                                    <input class="form-control" id="inputPhoneNumber" type="tel"
                                        name="inputPhoneNumber" placeholder="Số điện thoại"
                                        value="{{ isset($user->phoneNumber) ? $user->phoneNumber : '' }}">
                                    <span id="telError"
                                        style="color: #dc3545; font-size: 14px; margin-top: 4px; display: block; font-weight: 500; min-height: 18px;"></span>
                                </div>

                                <div class="col-md-6">
                                    <label class="small mb-1" for="inputBirthday">Ngày sinh</label>
                                    <input type="date" class="form-control" id="inputBirthday"
                                        name="inputBirthday" value="{{ $user->birthDay }}">
                                    <span id="birthError"
                                        style="color: #dc3545; font-size: 14px; margin-top: 4px; display: block; font-weight: 500; min-height: 18px;"></span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-3">
                                <input type="submit" class="btn btn-primary btn-update-user" value="Lưu"
                                    style="width: 100px;" />
                            </div>
                            <script src="{{ asset('/public/clients/assets/js/profile-js.js') }}"></script>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('clients.blocks.footer')

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
