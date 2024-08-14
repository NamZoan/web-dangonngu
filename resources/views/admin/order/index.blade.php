@section('css')
    <link href="{{ asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/switchery/dist/switchery.min.css') }}" rel="stylesheet">

    <style>
        a.table-action {
            font-size: 1rem;
            margin: 0 0.1rem;
        }
    </style>
@endsection
@section('content')
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 ">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Danh sách đơn hàng</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <table id="datatable1" class="table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Mã Đơn</th>
                                                <th>Tên</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Tổng tiền</th>
                                                <th>Trạng thái</th>
                                                <th>Ngày Đặt Hàng</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <!-- iCheck -->

    <script src="{{ asset('vendors/iCheck/icheck.min.js') }}"></script>
    <!-- Datatables -->
    <script src="{{ asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
    <script src="{{ asset('vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
    <script src="{{ asset('vendors/jszip/dist/jszip.min.js') }}"></script>
    <script src="{{ asset('vendors/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('vendors/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('vendors/switchery/dist/switchery.min.js') }}"></script>
    <script src="{{ asset('vendors/moment/min/moment.min.js') }}"></script>
    <script>
        var token = "{{ auth()->user()->api_token }}";
        var headers = {
            'Authorization': 'Bearer ' + token
        };
    </script>
    {{-- <script>
        $(document).ready(function() {
            $('#datatable1').DataTable({

                serverSide: true,
                ajax: {
                    url: '{{ route('admin.api.getOrders') }}',
                    type: 'GET',
                    headers: headers
                },
                columns: [{
                        data: 'transaction_code',
                    },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email',
                    },
                    {
                        data: 'phone'
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return row.total + ' ' + row.unit_payment;
                        }
                    },
                    {
                        data: 'order_status'
                    },
                    {
                        data: 'created_at',
                        render: function(data, type, row) {
                            return moment(data).format('HH:mm:ss DD-MM-YYYY');
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            return '<a href="#" >Chi tiết</a>';
                        },
                        orderable: false,
                        searchable: false
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    if (data.order_status == 'Chờ xác nhận') {
                        $(row).css('background-color', '#CCCCCC');
                    }
                },

                search: {
                    return: true
                },
                serverSide: true
            });
        });
    </script> --}}

    <script>
        $(document).ready(function() {
            $('#datatable1').DataTable({
                paging: true,
                searching: true,
                serverSide: true,
                order: [
                    [2, "asc"]
                ],
                lengthMenu: [
                    [5, 10, 15, 20, 30],
                    [5, 10, 15, 20, 30],
                ],
                pageLength: 10,
                fnServerData: function(sSource, aoData, fnCallback, oSettings) {
                    NProgress.start();
                    oSettings.jqXHR = $.ajax({
                        url: '{{ route('admin.api.getOrders') }}',
                        method: 'GET',
                        dataType: 'json',
                        dataSrc: "",
                        data: {
                            draw: aoData[0].value,
                            columns: aoData[1].value,
                            order: aoData[2].value,
                            start: aoData[3].value,
                            length: aoData[4].value,
                            search: aoData[5].value,
                        },
                        headers: headers,
                        success: function(response) {
                            NProgress.done();
                            fnCallback({
                                draw: response.draw,
                                data: response.data,
                                recordsTotal: response.recordsTotal,
                                recordsFiltered: response.recordsTotal
                            });
                        },
                        error: function(xhr, error, thrown) {
                            NProgress.done();
                            Swal.fire({
                                position: "top-end",
                                icon: "error",
                                title: "Lỗi tải dữ liệu từ máy chủ",
                                showConfirmButton: false,
                                timer: 1000
                            });

                        }
                    });
                },
                // responsive: true,
                rowId: function(data) {
                    return 'item_' + data.id;
                },
                columns: [{
                        data: 'transaction_code',
                        orderable: false
                    },
                    {
                        data: 'name',
                        orderable: false
                    },
                    {
                        data: 'email',
                        orderable: false
                    },
                    {
                        data: 'phone',
                        orderable: false
                    },
                    {
                        data: null,
                        orderable: false,
                        render: function(data, type, row) {
                            return row.total + ' ' + row.unit_payment;
                        }
                    },
                    {
                        data: 'order_status',
                        
                    },
                    {
                        data: 'created_at',
                        render: function(data, type, row) {
                            return moment(data).format('HH:mm:ss DD-MM-YYYY');
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            var editLink = "{{ route('admin_order_detail', ':id') }}"
                                .replace(':id', row.id);
                            return '<a href="' + editLink +
                                '" >Chi tiết</a>';
                        },
                        orderable: false,
                        searchable: false
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    if (data.order_status == 'Chờ xác nhận') {
                        $(row).css('background-color', '#CCCCCC');
                    }
                },


            });
        });
    </script>
@endsection
    
