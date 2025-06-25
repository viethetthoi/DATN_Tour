<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật tour</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SmartWizard CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.smartwizard/4.2.0/css/smart_wizard_all.min.css"
        rel="stylesheet" type="text/css" />
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('/public/admin/css/add-image-css.css') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <script>
        $(document).ready(function() {
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
                                    <!-- Smart Wizard -->
                                    <p>Thêm thông tin chi tiết để tạo một tour mới và bắt đầu thu hút khách hàng!</p>
                                    <div id="wizard" class="form_wizard wizard_horizontal">
                                        <ul class="wizard_steps">
                                            <li>
                                                <a href="{{ route('admin-edit-tour', ['tourId' => $tourId]) }}">
                                                    <span class="step_no">1</span>
                                                    <span class="step_descr">
                                                        Bước 1<br />
                                                        <small>Bước 1 Nhập thông tin</small>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="active">
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
                                            <li>
                                                <a href="{{ route('admin-edit-date-tour', ['tourId' => $tourId]) }}">
                                                    <span class="step_no">4</span>
                                                    <span class="step_descr">
                                                        Bước 4<br />
                                                        <small>Bước 4 Thêm lịch trình</small>
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>

                                        <!-- Bước 2 -->
                                        <div id="step-2">
                                            <form class="form-add-images"
                                                action="{{ route('admin-edit-submit-image-tour', ['tourId' => $tourId]) }}"
                                                method="POST" enctype="multipart/form-data" id="form-step2">
                                                @csrf
                                                <input type="hidden" name="tourId" id="tourId"
                                                    value="{{ $tourId }}">
                                                <div class="field item form-group">
                                                    <label class="col-form-label col-md-3 col-sm-3 label-align">Thêm
                                                        hình ảnh
                                                        <span>*</span>
                                                    </label>
                                                    <div class="col-md-6 col-sm-6">
                                                        <input type="file" name="images[]" class="form-control"
                                                            id="image-upload" multiple accept="image/*" required>
                                                        <small class="form-text text-muted">Bạn có thể tải lên ít nhất 4
                                                            ảnh.</small>
                                                        <div id="preview-images" class="mt-3 d-flex flex-wrap gap-2">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div style="text-align: right">
                                                    <button type="submit"
                                                        class="btn btn-primary btn-lg rounded-pill">Tiếp tục</button>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Các bước khác bạn thêm sau -->
                                    </div>
                                    <!-- End SmartWizard Content -->
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
    <!-- SmartWizard JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.smartwizard/4.2.0/js/jquery.smartwizard.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script>
        $(document).ready(function() {
            // Kiểm tra nếu thư viện SmartWizard đã được tải
            if ($.fn.smartWizard) {
                $('#wizard').smartWizard({
                    selected: 0, // Bắt đầu từ bước 1
                    theme: 'default',
                    transitionEffect: 'fade',
                    showStepURLhash: true,
                    toolbarSettings: {
                        toolbarPosition: 'none'
                    }
                });
            } else {
                console.log('SmartWizard không được tải.');
            }

            // Kiểm tra số lượng ảnh & preview ảnh
            $('#image-upload').on('change', function() {
                const files = this.files;
                const preview = $('#preview-images');
                preview.html(''); // Clear preview images
                Array.from(files).forEach(file => {
                    if (!file.type.startsWith('image/')) return;

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = $('<img>').attr('src', e.target.result);
                        preview.append(img);
                    };
                    reader.readAsDataURL(file);
                });
            });
        });
    </script>
</body>
<!-- Jquery UI -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</html>
