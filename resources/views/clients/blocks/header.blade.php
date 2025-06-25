<header class="main-header header-one white-menu menu-absolute">
    <!--Header-Upper-->
    <div class="header-upper py-30 rpy-0">
        <div class="container-fluid clearfix">

            <div class="header-inner rel d-flex align-items-center">
                <div class="logo-outer">
                    <div class="logo">
                        <a href="{{ route('homepage') }}">
                            <img src="{{ asset('/public/clients/assets/images/logos/lolo1.png') }}" width="80" height="80" style="margin-left: 40px" alt="Logo" title="Logo">
                            <span style="font-size: 24px; font-weight: bold; color: white">VI VU</span>
                        </a>
                    </div>
                </div>

                <div class="nav-outer mx-lg-auto ps-xxl-5 clearfix">
                    <!-- Main Menu -->
                    <nav class="main-menu navbar-expand-lg">
                        <div class="navbar-header">
                           <div class="mobile-logo">
                               <a href="{{ route('homepage') }}">
                                    <img src="{{ asset('/public/clients/assets/images/logos/lolo1.png') }}"  width="80" height="80" alt="Logo" title="Logo">
                               </a>
                           </div>
                           
                            <!-- Toggle Button -->
                            <button type="button" class="navbar-toggle" data-bs-toggle="collapse" data-bs-target=".navbar-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>

                        <div class="navbar-collapse collapse clearfix">
                            <ul class="navigation clearfix">
                                <li><a href="{{ route('homepage') }}">Trang Chủ</a>
                                </li>
                                <li><a href="{{ route('aboutpage') }}">Giới Thiệu</a></li>
                                <li ><a href="{{ route('tourpage') }}">Điểm Đến</a>

                            </ul>
                        </div>

                    </nav>
                    <!-- Main Menu End-->
                </div>
               
                <div class="menu-sidebar">
                    <div class="user-dropdown" id="userDropdown">
                        <!-- Chỉ gắn sự kiện click vào icon -->
                        
                        @if (session()->has('userName'))
                        <img class="bx bxs-user bx-tada" id="userIcon"
                        style="width: 55px; height: 55px; object-fit: cover; border-radius: 50%;"
                        src="{{ asset('/public/clients/assets/images/profile-user/' . ( session()->get('avatar') ?? 'default.jpg')) }}"
                        alt>                   
                   
                            <ul class="dropdown-menu" id="dropdownMenu">
                                <li>{{ session()->get('userName') }}</li>
                                <li><a href="{{ route('profile.user') }}">Thông tin cá nhân</a></li>
                                <li><a href="{{ route('my.tours') }}">Đơn đã đặt</a></li>
                                <li><a href="{{ route('show.favourite') }}">Yêu thích đã lưu</a></li>
                                <li><a href="{{ route('logout')}}">Đăng xuất</a></li>
                            </ul>
                            @else
                            <i class="bx bxs-user bx-tada" id="userIcon" style="font-size: 36px; color: rgb(255, 255, 255); cursor: pointer;"></i>

                            <ul class="dropdown-menu" id="dropdownMenu">
                                <li><a href="{{ route('loginpage')}}">Đăng nhập</a></li>
                            </ul>
                            @endif
                    </div>
                </div>    
            </div>
        </div>
    </div>
    
    <!--End Header Upper-->
</header>