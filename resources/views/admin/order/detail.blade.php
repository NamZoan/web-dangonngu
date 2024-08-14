@section('css')
    <style>
        a.table-action {
            font-size: 1rem;
            margin: 0 0.1rem;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="x_panel">
                <div class="x_content">
                    <section class="content invoice">
                        <!-- title row -->
                        <div class="row">
                            <div class="invoice-header">
                                <h1>
                                    Chi tiết đơn hàng: {{ $order->transaction_code }}
                                </h1>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-5 invoice-col">
                                <h3>Thông tin khách hàng</h3>
                                <address>
                                    <h4>Tên: {{ $order->name }}</h4>
                                    <h4>Email: {{ $order->email }}</h4>
                                    <h4>Số điện thoại: {{ $order->phone }}</h4>
                                    <h4>Địa chỉ: {{ $order->address }}</h4>
                                    <h4>Ghi chú: {{ $order->message }}</h4>
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-3 invoice-col">
                                <h3>Phương thức thanh toán</h3>
                                <address>
                                    <h4>Thanh toán qua: {{ $order->method_payment }}</h4>
                                    <h4>Ngày đặt hàng: {{ $order->created_at }}</h4>
                                </address>
                            </div>
                            <!-- /.col -->

                            <div class="col-sm-4 invoice-col">
                                <h3>Trạng thái đơn hàng</h3>
                                <address>
                                    <form action="{{ route('admin_update_order_detail', ['id' => $order->id]) }}" method="POST">
                                        @csrf
                                        <div class="form-group row">
                                            <div class="col-md-6 col-sm-6 ">
                                                <select class="form-control" id="selectOption" name="option" required>
                                                    <option value="{{ $order->order_status }}" >{{ $order->order_status }}</option>
                                                    @if ($order->order_status != 'Giao cho đơn vị vận chuyển')
                                                        <option value="Giao cho đơn vị vận chuyển">Giao cho đơn vị vận chuyển</option>
                                                    @endif
                                                    @if ($order->order_status != 'Giao hàng thành công')
                                                        <option value="Giao hàng thành công">Giao hàng thành công</option>
                                                    @endif
                                                    <option value="other">Trường hợp khác</option>
                                                </select>
                                            </div>
                                            
                                            <div>
                                                <input type="text" class="form-control d-none" placeholder="Các trường hợp khác" name="other">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-secondary">Xác nhận</button>
                                    </form>

                                </address>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="  table">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Mã Sản Phẩm</th>
                                            <th>Tên Sản Phẩm</th>
                                            <th>Đơn Giá</th>
                                            <th>Số Lượng</th>
                                            <th>Tổng Tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total = 0; // Khởi tạo biến tổng ban đầu
                                        @endphp
                                        @foreach ($contents as $content)
                                            <tr>
                                                <td>{{ $content['code'] }}</td>
                                                <td>{{ $content['name'] }}</td>
                                                <td>{{ $content['unit_amount']['value'] }}
                                                    {{ $content['unit_amount']['currency_code'] }}</td>
                                                <td>{{ $content['quantity'] }}</td>

                                                <td>{{ floatval($content['unit_amount']['value']) * $content['quantity'] . ' ' . $content['unit_amount']['currency_code'] }}
                                                </td>
                                            </tr>
                                            @php
                                                $amount =
                                                    floatval($content['unit_amount']['value']) * $content['quantity'];
                                                $total += $amount; // Cộng dồn giá trị vào biến tổng
                                            @endphp
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4"></td>
                                            <td colspan="1">
                                                {{ $total . ' ' . $content['unit_amount']['currency_code'] }}</td>

                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->


                        <!-- /.row -->

                        <!-- this row will not appear when printing -->
                        <div class="row no-print">
                            <div class=" ">
                                <button class="btn btn-default" onclick="window.print();"><i class="fa fa-print"></i>
                                    Print</button>
                                <button class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit
                                    Payment</button>
                                <button class="btn btn-primary pull-right" style="margin-right: 5px;"><i
                                        class="fa fa-download"></i> Generate PDF</button>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            $('#selectOption').change(function() {
            if ($(this).val() === 'other') {
                $('.d-none').toggleClass('d-none');
            } else {
                $('.d-none').addClass('d-none');
            }
        });

        })
    @endsection
