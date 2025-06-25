<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm khuyến mãi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SmartWizard CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.smartwizard/4.2.0/css/smart_wizard_all.min.css"
        rel="stylesheet" type="text/css" />
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
    </style> --}}
    <link rel="stylesheet" href="{{ asset('/public/admin/css/add-css.css') }}">
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
                <div class="">
                    <div class="page-title">
                        <div class="title_left">
                            <h3>Thêm khuyến mãi</h3>
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
                                    <!-- Smart Wizard -->
                                    <p>Thêm thông tin chi tiết để tạo một khuyến mãi mới!!</p>
                                    <div id="wizard" class="form_wizard wizard_horizontal">
                                        <ul class="wizard_steps">
                                            <li class="active">
                                                <a href="">
                                                    <span class="step_no">1</span>
                                                    <span class="step_descr">
                                                        Bước 1<br />
                                                        <small>Bước 1 Nhập thông tin khuyến mãi</small>
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('admin-add-tour-promotion') }}">
                                                    <span class="step_no">2</span>
                                                    <span class="step_descr">
                                                        Bước 2<br />
                                                        <small>Bước 2 Thêm các tour vào khuyến mãi</small>
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                        <div id="step-1">
                                            <form class="form-info-tour"
                                                action="{{ route('admin-add-submit-promotion') }}" method="POST"
                                                id="form-step1">
                                                @csrf
                                                <div class="field item form-group bad">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Mô tả
                                                        <span>*</span></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <textarea name="description" id="description" rows="6" style="width: 100%;" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="field item form-group">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Ưu đãi
                                                        <span>*</span></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input type="number" class="form-control" name="discount"
                                                            id="discount" placeholder="Nhập Ưu đãi" min="0"
                                                            step="1" required>
                                                    </div>
                                                </div>
                                                <div class="field item form-group">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Ngày bắt
                                                        đầu <span>*</span></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input type="date" class="form-control" name="start_date"
                                                            id="start_date" required min="{{ date('Y-m-d') }}">
                                                    </div>
                                                </div>

                                                <div class="field item form-group">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Ngày kết
                                                        thúc <span>*</span></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input type="date" class="form-control" name="end_date"
                                                            id="end_date" required>
                                                    </div>
                                                </div>

                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        const startDate = document.getElementById('start_date');
                                                        const endDate = document.getElementById('end_date');

                                                        startDate.addEventListener('change', function() {
                                                            if (startDate.value) {
                                                                endDate.min = startDate.value;
                                                                if (endDate.value && endDate.value < startDate.value) {
                                                                    endDate.value = startDate.value;
                                                                }
                                                            } else {
                                                                endDate.min = '';
                                                            }
                                                        });

                                                        if (startDate.value) {
                                                            endDate.min = startDate.value;
                                                        }
                                                    });
                                                </script>

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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
