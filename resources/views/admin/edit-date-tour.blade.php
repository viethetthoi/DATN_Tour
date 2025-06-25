<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật tour</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SmartWizard CSS -->
    <link href="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet"
        type="text/css" />
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('/public/admin/css/add-date-css.css') }}">

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
        <div class="main_container">
            <!-- Sidebar -->
            @include('admin.blocks.sidebar')

            <!-- page content -->
            <div class="right_col" role="main">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Thêm Tours</h3>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Form</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content add-tours">
                                <p>Thêm thông tin chi tiết để tạo một tour mới và bắt đầu thu hút khách hàng!</p>
                                {{-- <div id="wizard" class="sw"> --}}
                                <div id="wizard" class="form_wizard wizard_horizontal">
                                    <ul class="wizard_steps">
                                        <!-- Đánh dấu bước 1 là active -->
                                        <li>
                                            <a href="{{ route('admin-edit-tour', ['tourId' => $tourId]) }}">
                                                <span class="step_no">1</span>
                                                <span class="step_descr">
                                                    Bước 1<br />
                                                    <small>Bước 1 Nhập thông tin</small>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin-edit-image-tour', ['tourId' => $tourId]) }}">
                                                <span class="step_no">2</span>
                                                <span class="step_descr">
                                                    Bước 2<br />
                                                    <small>Bước 2 Thêm hình ảnh</small>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin-edit-timeline-tour', ['tourId' => $tourId]) }}">
                                                <span class="step_no">3</span>
                                                <span class="step_descr">
                                                    Bước 3<br />
                                                    <small>Bước 3 Lộ trình</small>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="active">
                                            <a href="{{ route('admin-edit-date-tour', ['tourId' => $tourId]) }}">
                                                <span class="step_no">4</span>
                                                <span class="step_descr">
                                                    Bước 4<br />
                                                    <small>Bước 4 Thêm lịch trình</small>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div>
                                        <div id="step-1" class="tab-pane" role="tabpanel">
                                            <form class="form-info-tour"
                                                action="{{ route('admin-edit-submit-date-tour', ['tourId' => $tourId]) }}"
                                                method="POST" id="form-step1">
                                                @csrf
                                                <input type="hidden" name="tourId" id="tourId"
                                                    value="{{ $tourId }}">
                                                <div class="form-sets-container">
                                                    <!-- Phần form trong Blade -->
                                                    <div id="form-sets">
                                                        @foreach ($dates as $index => $date)
                                                            <div class="form-set" id="form-set-{{ $index + 1 }}">
                                                                <h2 style="text-align: center;">Lịch Trình
                                                                    {{ $index + 1 }}</h2>

                                                                <input type="hidden" name="dateId_{{ $index + 1 }}"
                                                                    id="dateId_{{ $index + 1 }}"
                                                                    value="{{ $date->dateId }}">

                                                                <div class="field item form-group">
                                                                    <label
                                                                        class="col-form-label col-md-3 col-sm-3 label-align">Ngày
                                                                        bắt đầu <span>*</span></label>
                                                                    <div class="col-md-6 col-sm-6">
                                                                        <input type="date" class="form-control"
                                                                            name="start_date_{{ $index + 1 }}"
                                                                            value="{{ $date->startDate }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="field item form-group">
                                                                    <label
                                                                        class="col-form-label col-md-3 col-sm-3 label-align">Ngày
                                                                        kết thúc <span>*</span></label>
                                                                    <div class="col-md-6 col-sm-6">
                                                                        <input type="date" class="form-control"
                                                                            name="end_date_{{ $index + 1 }}"
                                                                            value="{{ $date->endDate }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="field item form-group">
                                                                    <label
                                                                        class="col-form-label col-md-3 col-sm-3 label-align">Tiền
                                                                        người lớn <span>*</span></label>
                                                                    <div class="col-md-6 col-sm-6">
                                                                        <input type="text" class="form-control"
                                                                            name="adult_price_{{ $index + 1 }}"
                                                                            placeholder="Nhập giá người lớn" required
                                                                            pattern="^\d+(\.\d{1,2})?$"
                                                                            value="{{ $date->priceAdult }}"
                                                                            title="Giá phải là số dương (có thể có tối đa 2 chữ số sau dấu chấm)">
                                                                    </div>
                                                                </div>
                                                                <div class="field item form-group">
                                                                    <label
                                                                        class="col-form-label col-md-3 col-sm-3 label-align">Tiền
                                                                        trẻ em <span>*</span></label>
                                                                    <div class="col-md-6 col-sm-6">
                                                                        <input type="text" class="form-control"
                                                                            name="child_price_{{ $index + 1 }}"
                                                                            placeholder="Nhập giá trẻ em" required
                                                                            pattern="^\d+(\.\d{1,2})?$"
                                                                            value="{{ $date->priceChildren }}"
                                                                            title="Giá phải là số dương (có thể có tối đa 2 chữ số sau dấu chấm)">
                                                                    </div>
                                                                </div>
                                                                <div class="field item form-group">
                                                                    <label
                                                                        class="col-form-label col-md-3 col-sm-3 label-align">Số
                                                                        lượng <span>*</span></label>
                                                                    <div class="col-md-6 col-sm-6">
                                                                        <input type="number" class="form-control"
                                                                            name="quantity_{{ $index + 1 }}"
                                                                            placeholder="Nhập số lượng" required
                                                                            min="0" step="1"
                                                                            value="{{ $date->quantity }}"
                                                                            title="Số lượng phải là số nguyên dương">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <br>
                                                        @endforeach
                                                    </div>

                                                    <!-- Nút thêm/xóa form -->
                                                    <div class="button-container">
                                                        <button type="button" class="btn btn-secondary"
                                                            id="add-form">Thêm Form</button>
                                                        <button type="button" class="btn btn-danger"
                                                            id="remove-form">Xóa Form</button>
                                                    </div>

                                                </div>
                                                <div style="text-align: right">
                                                    <button type="submit"
                                                        class="btn btn-primary btn-lg rounded-pill">Lưu</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SmartWizard JS -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/js/jquery.smartWizard.min.js"></script> --}}
    <!-- Custom JS -->
    <script>
        $(document).ready(function() {
            // Khởi tạo formCount bằng số lượng form hiện có (Blade truyền vào)
            let formCount = {{ count($dates) ?? 1 }};
            if (formCount < 1) formCount = 1;

            function getToday() {
                const today = new Date();
                today.setDate(today.getDate() + 1);
                const yyyy = today.getFullYear();
                const mm = String(today.getMonth() + 1).padStart(2, '0');
                const dd = String(today.getDate()).padStart(2, '0');
                return `${yyyy}-${mm}-${dd}`;
            }

            // Gắn min ngày hôm nay và ràng buộc end_date >= start_date cho formIndex
            function attachDateLogic(formIndex) {
                const startInput = $(`input[name="start_date_${formIndex}"]`);
                const endInput = $(`input[name="end_date_${formIndex}"]`);
                const today = getToday();

                startInput.attr('min', today);

                startInput.on('change', function() {
                    const selectedStartDate = this.value;
                    endInput.attr('min', selectedStartDate);

                    if (endInput.val() && endInput.val() < selectedStartDate) {
                        endInput.val('');
                    }
                });
            }

            // Gắn sự kiện cho tất cả form hiện có lúc load
            for (let i = 1; i <= formCount; i++) {
                attachDateLogic(i);
            }

            // Thêm form mới
            $('#add-form').on('click', function() {
                formCount++;
                const today = getToday();

                const newForm = `
                <div class="form-set" id="form-set-${formCount}">
                    <h2 style="text-align: center;">Lịch Trình ${formCount}</h2>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Ngày bắt đầu <span>*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input type="date" class="form-control" name="start_date_${formCount}" required min="${today}">
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Ngày kết thúc <span>*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input type="date" class="form-control" name="end_date_${formCount}" required>
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Tiền người lớn <span>*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" class="form-control" name="adult_price_${formCount}"
                                placeholder="Nhập giá người lớn" required
                                pattern="^\\d+(\\.\\d{1,2})?$"
                                title="Giá phải là số dương (có thể có tối đa 2 chữ số sau dấu chấm)">
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Tiền trẻ em <span>*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input type="text" class="form-control" name="child_price_${formCount}"
                                placeholder="Nhập giá trẻ em" required
                                pattern="^\\d+(\\.\\d{1,2})?$"
                                title="Giá phải là số dương (có thể có tối đa 2 chữ số sau dấu chấm)">
                        </div>
                    </div>
                    <div class="field item form-group">
                        <label class="col-form-label col-md-3 col-sm-3 label-align">Số lượng <span>*</span></label>
                        <div class="col-md-6 col-sm-6">
                            <input type="number" class="form-control" name="quantity_${formCount}"
                                placeholder="Nhập số lượng" required min="0" step="1"
                                title="Số lượng phải là số nguyên dương">
                        </div>
                    </div>
                </div>
            `;

                $('#form-sets').append(newForm);
                attachDateLogic(formCount);
            });

            // Xóa form cuối cùng
            $('#remove-form').on('click', function() {
                if (formCount > 1) {
                    $(`#form-set-${formCount}`).remove();
                    formCount--;
                }
            });
        });
    </script>


</body>

</html>
