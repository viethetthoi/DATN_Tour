<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách tài khoản</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('/public/admin/css/list-css.css') }}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

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
        .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            border-radius: 0.375rem;
        }

        .pagination li {
            margin: 0 4px;
        }

        .pagination li a,
        .pagination li span {
            padding: 8px 12px;
            color: #007bff;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.2s ease-in-out;
        }

        .pagination li.active span {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .pagination li a:hover {
            background-color: #e9ecef;
        }
    </style>
</head>

<body>
    <div class="container body">
        <!-- Sidebar (Đã ẩn) -->
        <div class="left_col">
            <!-- Sidebar content -->
            @include('admin.blocks.sidebar') <!-- Giả sử bạn có sidebar riêng -->
        </div>

        <!-- Main content -->
        <div class="main_container">
            <div class="right_col" role="main">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Danh sách khách hàng</h3>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="x_panel">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ảnh đại diện</th>
                                        <th>Tên tài khoản</th>
                                        <th>Email</th>
                                        <th>Kích hoạt / Chưa</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->userId }}</td>
                                            <td>
                                                <img class="img-account-profile rounded-circle mb-2" id="avatarPreview"
                                                    style="width: 50px"
                                                    src="{{ asset('/public/clients/assets/images/profile-user/' . ($user->avatar ?? 'default.jpg')) }}"
                                                    alt>
                                            </td>
                                            <td>{{ $user->userName }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if ($user->isActive == 'y')
                                                    <a href="" class="btn btn-success btn-sm">
                                                        <i class="fas fa-check-circle"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('admin-list-user-status', ['userId' => $user->userId, 'status' => 'n']) }}"
                                                        class="btn btn-secondary btn-sm">
                                                        <i class="fas fa-times-circle"></i>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($user->status == 'b')
                                                    <a href="{{ route('admin-list-user-status', ['userId' => $user->userId, 'status' => 'b']) }}"
                                                        class="btn btn-secondary btn-sm">
                                                        <i class="fas fa-ban"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('admin-list-user-status', ['userId' => $user->userId, 'status' => 'o']) }}"
                                                        class="btn btn-success btn-sm">
                                                        <i class="fas fa-check-circle"></i>
                                                    </a>
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach


                                    <!-- Các dòng khác -->
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
