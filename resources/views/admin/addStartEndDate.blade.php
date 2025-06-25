<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Tours</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SmartWizard CSS -->
    <link href="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/css/smart_wizard_all.min.css" rel="stylesheet"
        type="text/css" />
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    {{-- <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f7f7;
        }
        .container.body {
            display: flex;
            min-height: 100vh;
        }
        .main_container {
            display: flex;
            width: 100%;
        }
        /* Sidebar */
        .left_col {
            background: #2A3F54;
            color: #fff;
            width: 250px;
            position: fixed;
            height: 100%;
            overflow-y: auto;
        }
        .left_col .profile {
            text-align: center;
            padding: 20px 0;
        }
        .left_col .profile_img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto;
        }
        .left_col .profile_info {
            margin-top: 10px;
        }
        .nav.side-menu li a {
            color: #fff;
            padding: 10px 20px;
            display: block;
        }
        .nav.side-menu li a:hover {
            background: #354b60;
        }
        .nav.side-menu li i {
            margin-right: 10px;
        }
        /* Main content */
        .right_col {
            margin-left: 250px;
            padding: 20px;
            flex: 1;
            background: #fff;
        }
        .x_panel {
            background: #fff;
            border: 1px solid #e6e9ed;
            border-radius: 5px;
            padding: 15px;
        }
        .x_title h2 {
            font-size: 22px;
            margin: 0;
        }
        .x_content {
            padding: 20px;
        }
        /* SmartWizard custom styles */
        .wizard_horizontal .wizard_steps {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .wizard_horizontal .wizard_steps li {
            flex: 1;
            text-align: center;
        }
        .wizard_horizontal .wizard_steps li a {
            text-decoration: none;
            color: #73879C;
        }
        .wizard_horizontal .wizard_steps li .step_no {
            display: inline-block;
            width: 30px;
            height: 30px;
            line-height: 30px;
            border-radius: 50%;
            background: #73879C;
            color: #fff;
            margin-bottom: 5px;
        }
        /* Thay đổi màu đỏ khi active */
        .wizard_horizontal .wizard_steps li.active .step_no {
            background: red;
        }
        .wizard_steps li .step_descr {
            display: block;
            font-size: 14px;
        }
        .wizard_steps li .step_descr small {
            font-size: 12px;
            color: #73879C;
        }
        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .label-align {
            text-align: right;
            padding-right: 15px;
            font-weight: bold;
        }
        .form-control {
            border: 1px solid #e6e9ed;
            border-radius: 4px;
            padding: 8px;
        }
        .bad textarea {
            border: 1px solid #e6e9ed;
            border-radius: 4px;
            padding: 8px;
        }
        .btn-primary {
            background: #1ABB9C;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
        }
        .btn-primary:hover {
            background: #16A085;
        }
        /* Scrollable form sets container */
        .form-sets-container {
            max-height: 300px;
            overflow-y: auto;
            padding-right: 10px;
            margin-bottom: 15px;
        }
        /* Custom scrollbar styling */
        .form-sets-container::-webkit-scrollbar {
            width: 8px;
        }
        .form-sets-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }
        .form-sets-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }
        .form-sets-container::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
        /* Button container inside scrollable area */
        .button-container {
            margin-top: 10px;
            text-align: right;
        }
    </style> --}}
    <link rel="stylesheet" href="{{ asset('/public/admin/css/add-date-css.css') }}">

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
                                <div id="wizard" class="form_wizard wizard_horizontal">
                                    <ul class="wizard_steps">
                                        <li>
                                            <a href="">
                                                <span class="step_no">1</span>
                                                <span class="step_descr">
                                                    Bước 1<br />
                                                    <small>Bước 1 Nhập thông tin</small>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="">
                                                <span class="step_no">2</span>
                                                <span class="step_descr">
                                                    Bước 2<br />
                                                    <small>Bước 2 Thêm hình ảnh</small>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="">
                                                <span class="step_no">3</span>
                                                <span class="step_descr">
                                                    Bước 3<br />
                                                    <small>Bước 3 Lộ trình</small>
                                                </span>
                                            </a>
                                        </li>
                                        <li class="active">
                                            <a href="">
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
                                            <form class="form-info-tour" action="{{ route('admin-add-date-tour') }}"
                                                method="POST" id="form-step1">
                                                @csrf
                                                <input type="hidden" name="tourId" id="tourId"
                                                    value="{{ $tourId }}">
                                                <div class="form-sets-container">
                                                    <div id="form-sets">
                                                        <div class="form-set" id="form-set-1">
                                                            <h2 style="text-align: center;">Lịch Trình 1</h2>
                                                            <div class="field item form-group">
                                                                <label
                                                                    class="col-form-label col-md-3 col-sm-3 label-align">Ngày
                                                                    bắt đầu
                                                                    <span>*</span></label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="date" class="form-control"
                                                                        name="start_date_1" required>
                                                                </div>
                                                            </div>
                                                            <div class="field item form-group">
                                                                <label
                                                                    class="col-form-label col-md-3 col-sm-3 label-align">Ngày
                                                                    kết thúc
                                                                    <span>*</span></label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="date" class="form-control"
                                                                        name="end_date_1" required>
                                                                </div>
                                                            </div>
                                                            <div class="field item form-group">
                                                                <label
                                                                    class="col-form-label col-md-3 col-sm-3 label-align">Tiền
                                                                    người lớn
                                                                    <span>*</span></label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control"
                                                                        name="adult_price_1"
                                                                        placeholder="Nhập giá người lớn" required
                                                                        pattern="^\d+(\.\d{1,2})?$"
                                                                        title="Giá phải là số dương (có thể có tối đa 2 chữ số sau dấu chấm)">
                                                                </div>
                                                            </div>
                                                            <div class="field item form-group">
                                                                <label
                                                                    class="col-form-label col-md-3 col-sm-3 label-align">Tiền
                                                                    trẻ em
                                                                    <span>*</span></label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="text" class="form-control"
                                                                        name="child_price_1"
                                                                        placeholder="Nhập giá trẻ em" required
                                                                        pattern="^\d+(\.\d{1,2})?$"
                                                                        title="Giá phải là số dương (có thể có tối đa 2 chữ số sau dấu chấm)">
                                                                </div>
                                                            </div>
                                                            <div class="field item form-group">
                                                                <label
                                                                    class="col-form-label col-md-3 col-sm-3 label-align">Số
                                                                    lượng
                                                                    <span>*</span></label>
                                                                <div class="col-md-6 col-sm-6">
                                                                    <input type="number" class="form-control"
                                                                        name="quantity_1" placeholder="Nhập số lượng"
                                                                        required min="1" step="1"
                                                                        title="Số lượng phải là số nguyên dương">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Button Tăng/Giảm form inside scrollable container -->
                                                    <div class="button-container">
                                                        <button type="button" class="btn btn-secondary"
                                                            id="add-form">Thêm Form</button>
                                                        <button type="button" class="btn btn-danger"
                                                            id="remove-form">Xóa Form</button>
                                                    </div>
                                                </div>
                                                <div style="text-align: right">
                                                    <button type="submit"
                                                        class="btn btn-primary btn-lg rounded-pill">Tiếp tục</button>
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
    $(document).ready(function () {
        let formCount = 1;

        // Lấy ngày hiện tại theo định dạng yyyy-mm-dd
        function getToday() {
            const today = new Date();
            const yyyy = today.getFullYear();
            const mm = String(today.getMonth() + 1).padStart(2, '0');
            const dd = String(today.getDate()).padStart(2, '0');
            return `${yyyy}-${mm}-${dd}`;
        }

        // Gắn min cho input date và ràng buộc ngày kết thúc >= ngày bắt đầu
        function attachDateLogic(formIndex) {
            const startInput = $(`input[name="start_date_${formIndex}"]`);
            const endInput = $(`input[name="end_date_${formIndex}"]`);
            const today = getToday();

            // Gán min cho ngày bắt đầu là hôm nay
            startInput.attr('min', today);

            // Gán sự kiện khi thay đổi ngày bắt đầu
            startInput.on('change', function () {
                const selectedStartDate = this.value;
                endInput.attr('min', selectedStartDate);

                if (endInput.val() && endInput.val() < selectedStartDate) {
                    endInput.val('');
                }
            });
        }

        // Gắn logic cho form đầu tiên
        attachDateLogic(formCount);

        // Thêm form mới
        $('#add-form').on('click', function () {
            formCount++;
            const today = getToday(); // để set min cho input mới

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
                                placeholder="Nhập số lượng" required min="1" step="1"
                                title="Số lượng phải là số nguyên dương">
                        </div>
                    </div>
                </div>
            `;

            $('#form-sets').append(newForm);
            attachDateLogic(formCount);
        });

        // Xoá form
        $('#remove-form').on('click', function () {
            if (formCount > 1) {
                $(`#form-set-${formCount}`).remove();
                formCount--;
            }
        });
    });
</script>



</body>

</html>
