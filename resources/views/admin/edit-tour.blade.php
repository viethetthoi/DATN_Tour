<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật tour</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                            <h3>Sửa Tour</h3>
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
                                    <div id="wizard" class="form_wizard wizard_horizontal">
                                        <ul class="wizard_steps">
                                            <!-- Đánh dấu bước 1 là active -->
                                            <li class="active">
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
                                        <form class="form-info-tour"
                                            action="{{ route('admin-edit-submit-tour', ['tourId' => $tourId]) }}"
                                            method="POST" id="form-step1">
                                            @csrf
                                            <div class="field item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align">Tên
                                                    <span>*</span></label>
                                                <div class="col-md-6 col-sm-6">
                                                    <input class="form-control" name="title" id="title"
                                                        placeholder="Nhập tên Tour" value="{{ $tour->title }}"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="field item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align">Điểm đến
                                                    <span>*</span></label>
                                                <div class="col-md-6 col-sm-6">
                                                    <input class="form-control" name="destination" id="destination"
                                                        value="{{ $tour->destination }}" placeholder="Điểm đến"
                                                        required>
                                                </div>
                                            </div>
                                            <div class="field item form-group">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align">Khu vực
                                                    <span>*</span></label>
                                                <div class="col-md-6 col-sm-6">
                                                    <select class="form-control" name="domain" id="domain" required>
                                                        <option value="">Chọn khu vực</option>
                                                        <option value="mb"
                                                            {{ $tour->domain == 'mb' ? 'selected' : '' }}>Miền Bắc
                                                        </option>
                                                        <option value="mt"
                                                            {{ $tour->domain == 'mt' ? 'selected' : '' }}>Miền Trung
                                                        </option>
                                                        <option value="mdnb"
                                                            {{ $tour->domain == 'mdnb' ? 'selected' : '' }}>Miền Đông
                                                            Nam Bộ</option>
                                                        <option value="mtnb"
                                                            {{ $tour->domain == 'mtnb' ? 'selected' : '' }}>Miền Tây
                                                            Nam Bộ</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="field item form-group bad">
                                                <label class="col-form-label col-md-3 col-sm-3 label-align">Mô tả
                                                    <span>*</span></label>
                                                <div class="col-md-6 col-sm-6">
                                                    <textarea name="description" id="description" rows="6" style="width: 100%;" required>{{ $tour->description }}</textarea>
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

        <!-- jQuery -->
        <!-- Bootstrap JS -->

</body>

</html>
