<p style="font-size: 16px; font-family: Arial, sans-serif; color: #333;">Chào ,</p>
<p style="font-size: 16px; font-family: Arial, sans-serif; color: #333;">Cảm ơn bạn đã đặt tour tại VIVU. Vui lòng xem chi tiết hóa đơn trong file đính kèm.</p>
<p style="font-size: 16px; font-family: Arial, sans-serif; color: #333;">Chúc bạn một chuyến đi vui vẻ!</p>

<div class="invoice_booking" style="border: 1px solid #ddd; padding: 20px; background-color: #f9f9f9;">
    <div class="x_title" style="margin-bottom: 20px;">
        <h2 style="font-size: 24px; color: #2c3e50; font-family: Arial, sans-serif;">Hóa đơn chi tiết</h2>
    </div>
    <div class="x_content" style="font-family: Arial, sans-serif; color: #333;">
        <section class="content invoice">
            <!-- title row -->
            <div class="row" style="margin-bottom: 20px;">
                <div class="invoice-header">
                    <h3 style="font-size: 20px; font-weight: bold;">
                        {{ $invoice->tour->title }}
                    </br>
                        <small style=" font-size: 18px;">Ngày đặt: {{ date('d-m-Y', strtotime($invoice->bookingDate)) }}</small>
                    </h3>
                </div>
            </div>

            <!-- info row -->
            <div class="row invoice-info" style="margin-bottom: 20px;">
                <div class="col-sm-4 invoice-col" style="font-size: 14px;">
                    Từ
                    <address>
                        <strong>{{ $invoice->fullName }}</strong><br>
                        {{ $invoice->address }}<br>
                        Số điện thoại: {{ $invoice->phoneNumber }}<br>
                        Email: {{ $invoice->email }}
                    </address>
                </div>
                <div class="col-sm-4 invoice-col" style="font-size: 14px;">
                    Đến
                    <address>
                        <strong>Công ty VIVU</strong><br>
                        Vinh Xuân, Phú Vang, Huế<br>
                        Phone: 0369 404 100<br>
                        Email: voducviet2003@gmail.com
                    </address>
                </div>
                <br>
                <div class="col-sm-4 invoice-col" style="font-size: 14px;">
                    <b>Mã hóa đơn #{{ $invoice->checkout->checkoutId }}</b><br>
                    <b>Mã giao dịch:</b>{{ $invoice->checkout->transactionId }} <br>
                    <b>Ngày thanh toán: </b> {{ date('d-m-Y', strtotime($invoice->checkout->paymentDate)) }}<br>
                    <b>Tài khoản: {{ $invoice->userId }}</b> 
                </div>
            </div>

            <!-- Table row -->
            <div class="row">
                <div class="table" style="width: 100%; margin-bottom: 20px;">
                    <table class="table table-striped" style="width: 100%; border-collapse: collapse;">
                        <thead style="background-color: #f2f2f2;">
                            <tr>
                                <th style="padding: 8px; text-align: left;">Loại</th>
                                <th style="padding: 8px; text-align: left;">Số lượng</th>
                                <th style="padding: 8px; text-align: left;">Đơn giá</th>
                                <th style="padding: 8px; text-align: left;">Tổng tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="border-bottom: 1px solid #ddd;">
                                <td style="padding: 8px;">Người lớn</td>
                                <td style="padding: 8px;">{{ $invoice->numAdults }}</td>
                                <td style="padding: 8px;"> {{ number_format($invoice->date->priceAdult, 0, ',', '.') }} vnđ</td>
                                <td style="padding: 8px;">{{ number_format($invoice->date->priceAdult * $invoice->numAdults, 0, ',', '.') }} vnđ</td>
                            </tr>
                            <tr style="border-bottom: 1px solid #ddd;">
                                <td style="padding: 8px;">Trẻ em</td>
                                <td style="padding: 8px;">{{ $invoice->numChildren }}</td>
                                <td style="padding: 8px;"> {{ number_format($invoice->date->priceChildren, 0, ',', '.') }} vnđ</td>
                                <td style="padding: 8px;">{{ number_format($invoice->date->priceChildren * $invoice->numChildren, 0, ',', '.') }} vnđ</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row" style="margin-bottom: 20px;">
                 <div class="col-md-6">
                    <p style="font-size: 20px; font-weight: bold;">Tổng tiền: {{ number_format($invoice->totalPrice, 0, ',', '.') }} vnđ</p>
                </div>
                <div class="col-md-6">
                    <p style="font-size: 16px; font-weight: bold;">Phương thức thanh toán:</p>
                    @if ($invoice->checkout->paymentMethod == 'momo-payment')
                    <h1 style="color: red; font-weight: bold;">Thanh toán tại Momo</h1>
                    @else
                    <h1 style="color: red; font-weight: bold;">Thanh toán tại văn phòng</h1>
                    @endif
                    <p style="font-size: 14px; color: #555; margin-top: 10px;">Vui lòng hoàn tất thanh toán theo hướng dẫn hoặc liên hệ với chúng tôi nếu cần hỗ trợ.</p>
                </div>
               
            </div>

        </section>
    </div>
</div>
