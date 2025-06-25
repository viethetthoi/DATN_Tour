<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách phiếu giảm giá</title>
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
</head>

<body>
    <div class="container body">
        <div class="left_col">
            @include('admin.blocks.sidebar')
        </div>
        <div class="main_container">
            <div class="right_col" role="main">
                <div class="page-title">
                    <div class="title_left" style="text-align: center">
                        <h3>Danh sách phiếu giảm giá</h3>
                    </div>
                    <div style="text-align: right; margin-right: 40px; margin-bottom: 10px">
                        <a href="{{ route('admin-add-coupon') }}" class="btn btn-primary btn-sm edit-tour">
                            <i class="fas fa-plus"></i>
                        </a>
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
                                        <th>Tên khuyến mãi</th>
                                        <th>Tên mã</th>
                                        <th>Ưu đãi</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Cập nhật</th>
                                        <th>Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($coupons as $coupon)
                                        <tr>
                                            <td>{{ $coupon->couponId }}</td>
                                            <td>{{ $coupon->title }}</td>
                                            <td>{{ $coupon->codeCoupon }}</td>
                                            <td>{{ $coupon->discount }}</td>
                                            <td>{{ \Carbon\Carbon::parse($coupon->startDate)->format('d/m/y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($coupon->endDate)->format('d/m/y') }}</td>
                                            <td>
                                                <a href="{{ route('admin-edit-coupon', ['couponId' => $coupon->couponId]) }}"
                                                    class="btn btn-primary btn-sm edit-tour">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                            <td>
                                                @if ($coupon->status == 'n')
                                                    <a href="{{ route('admin-edit-status-coupon', ['status' => 'n', 'couponId' => $coupon->couponId]) }}"
                                                        class="btn btn-secondary btn-sm">
                                                        <i class="fas fa-ban"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ route('admin-edit-status-coupon', ['status' => 'y', 'couponId' => $coupon->couponId]) }}"
                                                        class="btn btn-success btn-sm">
                                                        <i class="fas fa-check-circle"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
