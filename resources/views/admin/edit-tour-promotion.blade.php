<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật khuyến mãi</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SmartWizard CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery.smartwizard/4.2.0/css/smart_wizard_all.min.css"
        rel="stylesheet" type="text/css" />
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('/public/admin/css/edit-tourPro-css.css') }}">

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
                                            <li>
                                                <a
                                                    href="{{ route('admin-edit-promotion', ['promotionId' => $promotion->promotionId]) }}">
                                                    <span class="step_no">1</span>
                                                    <span class="step_descr">
                                                        Bước 1<br />
                                                        <small>Bước 1 Nhập thông tin khuyến mãi</small>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="active">
                                                <a
                                                    href="{{ route('admin-edit-tour-promotion', ['promotionId' => $promotion->promotionId]) }}">
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
                                                action="{{ route('admin-edit-submit-tour-promotion', ['promotionId' => $promotion->promotionId]) }}"
                                                method="POST" id="form-step1">
                                                @csrf
                                                <span style="font-size: 20px">{{ $promotion->description }}</span>
                                                <input type="hidden" name="proId" id="proId"
                                                    value="{{ $promotion->promotionId }}">

                                                @foreach ($arrNotInTour as $index => $itemss)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="title[]"
                                                            id="title_{{ $index + 1 }}" value="{{ $itemss->dateId }}"
                                                            checked>
                                                        <label class="form-check-label"
                                                            for="title_{{ $index + 1 }}">{{ $itemss->tour[0] }} ||
                                                            {{ \Carbon\Carbon::parse($itemss->startDate)->format('d/m/y') }}
                                                            ||{{ \Carbon\Carbon::parse($itemss->endDate)->format('d/m/y') }}</label>
                                                    </div>
                                                @endforeach

                                                @foreach ($arrMatched as $index => $item)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="title[]"
                                                            id="title_{{ $index + 1 }}" value="{{ $item->dateId }}"
                                                            checked>
                                                        <label class="form-check-label"
                                                            for="title_{{ $index + 1 }}">{{ $item->tour[0] }} ||
                                                            {{ \Carbon\Carbon::parse($item->startDate)->format('d/m/y') }}
                                                            ||{{ \Carbon\Carbon::parse($item->endDate)->format('d/m/y') }}</label>
                                                    </div>
                                                @endforeach

                                                @foreach ($arrUnmatched as $index => $items)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="title[]"
                                                            id="title_{{ $index + 1 }}"
                                                            value="{{ $items->dateId }}">
                                                        <label class="form-check-label"
                                                            for="title_{{ $index + 1 }}">{{ $items->tour[0] }} ||
                                                            {{ \Carbon\Carbon::parse($items->startDate)->format('d/m/y') }}
                                                            ||{{ \Carbon\Carbon::parse($items->endDate)->format('d/m/y') }}</label>
                                                    </div>
                                                @endforeach

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
