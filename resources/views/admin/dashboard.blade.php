<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome bằng CDN CSS để tránh lỗi CORS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous">
    <style>
        .tile_stats_count {
            background: #f7f7f7;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .tile_stats_count i {
            margin-right: 8px;
        }

        .panel_toolbox a {
            color: #333;
            margin-left: 10px;
        }

        .x_panel {
            background: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .x_title {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="container my-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2">
                @include('admin.blocks.sidebar')
            </div>

            <!-- Main content -->
            <div class="col-md-10">
                <!-- Top Tiles -->
                <div class="row">
                    <div class="col-md-3">
                        <div class="tile_stats_count">
                            <span><i class="fa-solid fa-route"></i> Tổng số tours</span>
                            <div class="count">{{ $total_data['countTour'] }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="tile_stats_count">
                            <span><i class="fa-solid fa-calendar-check"></i> Tổng booking</span>
                            <div class="count">{{ $total_data['countBooking'] }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="tile_stats_count">
                            <span><i class="fa-solid fa-users"></i> Người dùng</span>
                            <div class="count">{{ $total_data['countUser'] }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="tile_stats_count">
                            <span><i class="fa-solid fa-dollar-sign"></i> Doanh thu</span>
                            <div class="count">{{ number_format($total_data['totalPrice'], 0, ',', '.') }} VND</div>
                        </div>
                    </div>
                </div>

                <!-- Destination & Booking Section -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="x_panel">
                            <div class="x_title d-flex justify-content-between align-items-center">
                                <h5>Điểm đến</h5>
                                <div class="panel_toolbox">
                                    <a href="#"><i class="fa fa-chevron-up"></i></a>
                                    <a href="#"><i class="fa fa-wrench"></i></a>
                                    <a href="#"><i class="fa fa-close"></i></a>
                                </div>
                            </div>
                            <div style="height: 350px; display: flex; justify-content: center; align-items: center;">
                                <canvas id="destinationChart"></canvas>
                            </div>
                        </div>
                    </div>
                    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
                    <script>
                        document.addEventListener("DOMContentLoaded", function() {
                            var ctx = document.getElementById('destinationChart').getContext('2d');
                            var destinationChart = new Chart(ctx, {
                                type: 'pie',
                                data: {
                                    labels: ['Bắc', 'Trung', 'Nam', 'Tây Nguyên'],
                                    datasets: [{
                                        data: [
                                            {{ $quantityDomain[0]->total ?? 0 }},
                                            {{ $quantityDomain[1]->total ?? 0 }},
                                            {{ $quantityDomain[2]->total ?? 0 }},
                                            {{ $quantityDomain[3]->total ?? 0 }}
                                        ],
                                        backgroundColor: [
                                            '#36A2EB',
                                            '#FFCE56',
                                            '#FF6384',
                                            '#4BC0C0'
                                        ]
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            position: 'bottom',
                                        },
                                        title: {
                                            display: true,
                                            text: 'Số lượng tour theo miền'
                                        }
                                    }
                                }
                            });
                        });
                    </script>
                    <div class="col-md-6">
                        <div class="x_panel">
                            <div class="x_title d-flex justify-content-between align-items-center">
                                <h5>Khách hàng</h5>
                                <div class="panel_toolbox">
                                    <a href="#"><i class="fa fa-chevron-up"></i></a>
                                    <a href="#"><i class="fa fa-close"></i></a>
                                </div>
                            </div>
                            <div style="max-height: 350px; overflow-y: auto;">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Email</th>
                                            <th>Kích hoạt / Chưa</th>
                                            <th>Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->userId }}</td>

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
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Most Booked Tours & New Bookings -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="x_panel">
                            <div class="x_title d-flex justify-content-between align-items-center">
                                <h5>Tours được đặt nhiều nhất</h5>
                                <div class="panel_toolbox">
                                    <a href="#"><i class="fa fa-chevron-up"></i></a>
                                    <a href="#"><i class="fa fa-close"></i></a>
                                </div>
                            </div>
                            <div style="max-height: 300px; overflow-y: auto;">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tên</th>
                                            <th>Đã đặt</th>
                                            <th>Còn trống</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($topBooked as $item)
                                            <tr>
                                                <td>{{ $item->tourId }}</td>
                                                <td>{{ $item->tour[0] }}</td>
                                                <td>{{ $item->total_date }}</td>
                                                <td>{{ $item->date[0] }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="x_panel">
                            <div class="x_title d-flex justify-content-between align-items-center">
                                <h5>Đơn đặt mới</h5>
                                <div class="panel_toolbox">
                                    <a href="#"><i class="fa fa-chevron-up"></i></a>
                                    <a href="#"><i class="fa fa-close"></i></a>
                                </div>
                            </div>
                            <div style="max-height: 300px; overflow-y: auto;">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Họ tên</th>
                                            <th>Tên tour</th>
                                            <th>Tổng tiền</th>
                                            <th>Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bookings as $booking)
                                            <tr>
                                                <td>{{ $booking->bookingId }}</td>
                                                <td>{{ $booking->fullName }}</td>
                                                <td style="width: 350px;">{{ $booking->tour[0] }}</td>
                                                <td>{{ number_format($booking->totalPrice, 0, ',', '.') }} VND</td>

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

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Revenue Section -->
                <div class="x_panel">
                    <div class="x_title d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center justify-content-between">
                            <h5>Doanh thu theo tháng của năm</h5>
                            <div>
                                <select id="yearSelect" class="form-select">
                                    @for ($y = now()->year; $y >= now()->year - 5; $y--)
                                        <option value="{{ $y }}"
                                            {{ $y == now()->year ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="panel_toolbox">
                            <a href="#"><i class="fa fa-chevron-up"></i></a>
                            <a href="#"><i class="fa fa-wrench"></i></a>
                            <a href="#"><i class="fa fa-close"></i></a>
                        </div>
                    </div>
                    <div>
                        <canvas id="revenueChart" height="300"></canvas>
                    </div>
                </div>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                <script>
                    var ctx = document.getElementById('revenueChart').getContext('2d');
                    var revenueChart;

                    function renderChart(data) {
                        var revenues = data.map(function(item) {
                            return item.total_revenue;
                        });

                        if (revenueChart) {
                            revenueChart.data.datasets[0].data = revenues;
                            revenueChart.update();
                        } else {
                            revenueChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: [
                                        'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
                                        'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'
                                    ],
                                    datasets: [{
                                        label: 'Doanh thu (VNĐ)',
                                        data: revenues,
                                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    plugins: {
                                        legend: {
                                            display: false
                                        },
                                        title: {
                                            display: true,
                                            text: 'Doanh thu theo tháng'
                                        }
                                    },
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                callback: function(value) {
                                                    return value.toLocaleString('vi-VN') + ' ₫';
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        }
                    }

                    $(document).ready(function() {
                        var initialData = @json($annualRevenue);
                        renderChart(initialData);

                        $('#yearSelect').change(function() {
                            var year = $(this).val();

                            $.ajax({
                                url: '{{ route('admin.dashboard.annualRevenue') }}', // Đặt route này trong routes/web.php
                                type: 'GET',
                                data: {
                                    year: year
                                },
                                success: function(response) {
                                    renderChart(response);
                                },
                                error: function() {
                                    alert('Lỗi khi tải dữ liệu doanh thu!');
                                }
                            });
                        });
                    });
                </script>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>

</html>
