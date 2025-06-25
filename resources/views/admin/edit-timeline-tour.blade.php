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
    <link rel="stylesheet" href="{{ asset('/public/admin/css/add-timeline-css.css') }}">

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
                                        <li class="active">
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
                                    <div>
                                        <div id="step-1" class="tab-pane" role="tabpanel">
                                            <form class="form-info-tour"
                                                action="{{ route('admin-edit-submit-timeline-tour', ['tourId' => $tourId]) }}"
                                                method="POST" id="form-step1">
                                                @csrf
                                                <input type="hidden" name="tourId" id="tourId"
                                                    value="{{ $tourId }}">
                                                <div class="form-sets-container">
                                                    <div id="form-sets">
                                                        @foreach ($timelines as $index => $timeline)
                                                            <div class="form-set" id="form-set-1">
                                                                <h2 style="text-align: center;">Ngày {{ $index + 1 }}
                                                                </h2>

                                                                <input type="hidden"
                                                                    name="timeLineId_{{ $index + 1 }}"
                                                                    id="timeLineId_{{ $index + 1 }}"
                                                                    value="{{ $timeline->timeLineId }}">
                                                                <div class="field item form-group">
                                                                    <label
                                                                        class="col-form-label col-md-3 col-sm-3 label-align">Địa
                                                                        Điểm

                                                                        <span>*</span></label>
                                                                    <div class="col-md-6 col-sm-6">
                                                                        <input class="form-control"
                                                                            name="name_{{ $index + 1 }}"
                                                                            placeholder="Nhập tên Tour"
                                                                            value="{{ $timeline->tl_title }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="field item form-group bad">
                                                                    <label
                                                                        class="col-form-label col-md-3 col-sm-3 label-align">Mô
                                                                        Tả
                                                                        <span>*</span></label>
                                                                    <div class="col-md-6 col-sm-6">
                                                                        <textarea name="description_{{ $index + 1 }}" rows="6" style="width: 100%;" required>{{ $timeline->tl_description }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
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


            // Initialize form count
            let formCount = {{ count($timelines) }};
            // Add new form set
            $('#add-form').on('click', function() {
                console.log('Add form clicked, current formCount:', formCount);
                formCount++;
                const newForm = `
                    <div class="form-set" id="form-set-${formCount}">
                                                    <h2 style="text-align: center;">Ngày ${formCount}</h2>
                        <div class="field item form-group">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Điểm Đến
                                <span>*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <input class="form-control" name="name_${formCount}" placeholder="Nhập tên Tour ${formCount}" required>
                            </div>
                        </div>
                        <div class="field item form-group bad">
                            <label class="col-form-label col-md-3 col-sm-3 label-align">Mô Tả
                                <span>*</span></label>
                            <div class="col-md-6 col-sm-6">
                                <textarea name="description_${formCount}" rows="6" style="width: 100%;" required></textarea>
                            </div>
                        </div>
                    </div>
                `;
                $('#form-sets').append(newForm);
                console.log('New form added, new formCount:', formCount);
            });

            // Remove last form set
            $('#remove-form').on('click', function() {
                console.log('Remove form clicked, current formCount:', formCount);
                if (formCount > 1) {
                    $('#form-sets .form-set:last').remove();
                    formCount--;
                    console.log('Form removed, new formCount:', formCount);
                } else {
                    console.log('Cannot remove: only one form remains');
                }
            });
        });
    </script>
</body>

</html>
