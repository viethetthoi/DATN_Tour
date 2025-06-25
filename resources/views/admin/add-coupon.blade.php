<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm phiếu giảm giá</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SmartWizard CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.smartwizard/4.2.0/css/smart_wizard_all.min.css"
        rel="stylesheet" type="text/css" />
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->

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
                            <h3>Thêm phiếu giảm giá</h3>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="x_panel">
                                <div class="x_title">

                                    <div class="clearfix"></div>
                                </div>
                                <div class="x_content add-tours">
                                    <!-- Smart Wizard -->
                                    <p>Thêm thông tin chi tiết để tạo một phiếu khuyến mãi mới!!</p>
                                    <div id="wizard" class="form_wizard wizard_horizontal">

                                        <div id="step-1">
                                            <form class="form-info-tour" action="{{ route('admin-add-submit-coupon') }}"
                                                method="POST" id="form-step1">
                                                @csrf
                                                <div class="field item form-group bad">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Mô tả
                                                        <span>*</span></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <textarea name="description" id="description" rows="6" style="width: 100%;" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="field item form-group">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Mã code
                                                        <span>*</span></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input type="text" class="form-control" name="code"
                                                            id="code" placeholder="Nhập mã code"
                                                            value="{{ $randomCode }}" readonly>
                                                    </div>
                                                </div>
                                                <div class="field item form-group">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Ưu đãi
                                                        <span>*</span></label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input type="text" class="form-control" name="discount"
                                                            id="discount" placeholder="Nhập Ưu đãi"
                                                            pattern="^\d+(\.\d{1,2})?$"
                                                            title="Giá phải là số dương (có thể có tối đa 2 chữ số sau dấu chấm)"
                                                            required>
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
