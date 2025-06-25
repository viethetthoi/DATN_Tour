<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách tour đã đặt</title>
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
                        <h3>Danh sách Tours đã đặt</h3>
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
                                        <th>Tên tour</th>
                                        <th>Lịch đi</th>
                                        <th>Khách hàng</th>
                                        <th>Số lượng</th>
                                        <th>Ngày booking</th>
                                        <th>Trạng thái tour</th>
                                        <th>Giao dịch</th>
                                        <th>Gửi Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bookings as $booking)
                                        <tr>
                                            <td>{{ $booking->bookingId }}</td>
                                            <td style="width: 350px;">{{ $booking->tour[0] }}</td>
                                            <td style="width: 200px; text-align: center; vertical-align: middle;">
                                                {{ \Carbon\Carbon::parse($booking->date->startDate)->format('d/m/y') }}
                                                ||
                                                {{ \Carbon\Carbon::parse($booking->date->endDate)->format('d/m/y') }}
                                            </td>

                                            <td>
                                                <select class="form-control" name="info" id="info"
                                                    style="width: 95px;">
                                                    <option value="">Thông tin</option>
                                                    <option value="">{{ $booking->fullName }} ||
                                                        {{ $booking->email }} || {{ $booking->phoneNumber }} ||
                                                        {{ $booking->address }} </option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="form-control" name="quantity" id="quantity"
                                                    style="width: 95px;">
                                                    <option value="">Số lượng</option>
                                                    <option value="">{{ $booking->numAdults }} ||
                                                        {{ $booking->numChildren }} ||
                                                        {{ number_format($booking->totalPrice, 0, ',', '.') }} VND
                                                    </option>
                                                </select>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($booking->bookingDate)->format('d/m/y') }}
                                            </td>
                                            @php
                                                $statusColors = [
                                                    'c' => '#dc3545',
                                                    'b' => '#0d6efd',
                                                    'y' => '#ffc107',
                                                    'd' => '#6c757d',
                                                    'f' => '#198754',
                                                ];
                                                $textColors = [
                                                    'y' => '#212529',
                                                ];
                                                $bgColor = $statusColors[$booking->bookingStatus] ?? '#ffffff';
                                                $textColor = $textColors[$booking->bookingStatus] ?? '#ffffff';
                                            @endphp

                                            <style>
                                                .custom-status-select {
                                                    -webkit-appearance: none;
                                                    -moz-appearance: none;
                                                    appearance: none;
                                                    padding-left: 10px;
                                                    border: 1px solid #ccc;
                                                    border-radius: 4px;
                                                    height: calc(2.25rem + 2px);
                                                    /* giữ chiều cao bằng form-select bootstrap */
                                                }
                                            </style>

                                            <td>
                                                <form action="{{ route('admin-list-booking-status') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="bookingId"
                                                        value="{{ $booking->bookingId }}">

                                                    <select name="status"
                                                        class="form-select form-select-sm custom-status-select"
                                                        style="width: 110px; background-color: {{ $bgColor }}; color: {{ $textColor }};"
                                                        onchange="this.form.submit()">
                                                        <option value="c"
                                                            {{ $booking->bookingStatus == 'c' ? 'selected' : '' }}>Đã
                                                            hủy</option>
                                                        <option value="b"
                                                            {{ $booking->bookingStatus == 'b' ? 'selected' : '' }}>Đợi
                                                            duyệt</option>
                                                        <option value="y"
                                                            {{ $booking->bookingStatus == 'y' ? 'selected' : '' }}>Đã
                                                            duyệt</option>
                                                        <option value="d"
                                                            {{ $booking->bookingStatus == 'd' ? 'selected' : '' }}>Đang
                                                            đi</option>
                                                        <option value="f"
                                                            {{ $booking->bookingStatus == 'f' ? 'selected' : '' }}>Hoàn
                                                            thành</option>
                                                    </select>
                                                </form>
                                            </td>




                                            <td>
                                                @if ($booking->checkout[0] == 'n')
                                                    <a href="{{ route('admin-list-booking-payment', ['bookingId' => $booking->bookingId, 'status' => 'n']) }}"
                                                        class="btn btn-secondary btn-sm" title="Chưa giao dịch">
                                                        <i class="fas fa-ban"></i>
                                                    </a>
                                                @else
                                                    <a href="" class="btn btn-success btn-sm"
                                                        title="Đã giao dịch">
                                                        <i class="fas fa-check-circle"></i>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($booking->bookingStatus != 'b' && $booking->checkout == 'y')
                                                    @if ($booking->receiveEmail == 'n')
                                                        <a href="{{ route('admin-email', ['bookingId' => $booking->bookingId]) }}"
                                                            class="btn btn-secondary btn-sm"
                                                            title="Chưa gửi hóa đơn về email">
                                                            <i class="fas fa-ban"></i>
                                                        </a>
                                                    @else
                                                        <a href="" class="btn btn-success btn-sm"
                                                            title="Đã gửi hóa đơn về email">
                                                            <i class="fas fa-check-circle"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="d-flex justify-content-center">
                                {{ $bookings->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
