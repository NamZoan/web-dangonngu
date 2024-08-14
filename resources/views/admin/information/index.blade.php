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
                        <h2>Danh sách danh mục bài viết</h2>
                        <ul class="nav navbar-right panel_toolbox" style="min-width: 0px">
                            <li>
                                <select class="form-control" id="language-select">
                                    @foreach ($languages as $lang)
                                        <option value="{{ $lang->abbr }}"
                                            {{ $lang->abbr == $language ? 'selected' : '' }}>{{ $lang->name }}</option>
                                    @endforeach
                                </select>
                            </li>
                            <li style="display:flex;justify-content:center;align-items: center;margin-left: 10px;"><a
                                    class="" href="{{ route('admin_information_add') }}"><i class="fa fa-plus"
                                        data-toggle="tooltip" data-placement="bottom" title="Thêm"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box table-responsive">
                                    <table id="datatable1" class="table table-striped table-bordered bulk_action"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th><input type="checkbox" id="check-all"></th>
                                                <th>Tên</th>
                                                <th>Trạng thái</th>
                                                <th>Header</th>
                                                <th>Footer</th>
                                                <th>Ngày tạo</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
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
        $(document).ready(function() {
            $('#datatable1').DataTable({
                paging: true,
                searching: true,
                serverSide: true,

                fnServerData: function(sSource, aoData, fnCallback, oSettings) {
                    NProgress.start();
                    oSettings.jqXHR = $.ajax({
                        url: '{{ route('admin.api.getInformation') }}',
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
                            lang: $('#language-select').val()
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
                columns: [{
                        data: null,
                        render: function(data, type, row) {
                            return '<input type="checkbox" id="check-all">';
                        }
                    },
                    {
                        data: 'name',
                        render: function(data, type, row) {
                            url = row.url;
                            return '<a href="' + url +
                                '" target="_blank" rel="noopener noreferrer" data-toggle="tooltip" data-placement="bottom" title="Xem danh mục">' +
                                data + '</a>';
                        }
                    },
                    {
                        data: 'status',
                        render: function(data, type, row) {
                            var checked = (data == 1) ? 'checked' : '';
                            return '<label class="toggle-switch toggle-switch-sm" for="status_' +
                                row.id + '">' +
                                '<input type="checkbox" class="toggle-switch-input" id="status_' +
                                row.id + '" onclick="updateStatus(' + row.id +
                                ', \'status\',\'information\')" ' + checked + '>' +
                                '<span class="toggle-switch-label"><span class="toggle-switch-indicator"></span></span>' +
                                '</label>';
                        }
                    },
                    {
                        data: 'view_header',
                        render: function(data, type, row) {
                            console.log(data);
                            var checked = (data == 1) ? 'checked' : '';
                            return '<label class="toggle-switch toggle-switch-sm" for="view_header_' +
                                row.id + '">' +
                                '<input type="checkbox" class="toggle-switch-input" id="view_header_' +
                                row.id + '" onclick="updateStatus(' + row.id +
                                ', \'view_header\',\'information\')" ' + checked + '>' +
                                '<span class="toggle-switch-label"><span class="toggle-switch-indicator"></span></span>' +
                                '</label>';
                        }
                    },
                    {
                        data: 'view_footer',
                        render: function(data, type, row) {
                            console.log(data);
                            var checked = (data == 1) ? 'checked' : '';
                            return '<label class="toggle-switch toggle-switch-sm" for="view_footer_' +
                                row.id + '">' +
                                '<input type="checkbox" class="toggle-switch-input" id="view_footer_' +
                                row.id + '" onclick="updateStatus(' + row.id +
                                ', \'view_footer\',\'information\')" ' + checked + '>' +
                                '<span class="toggle-switch-label"><span class="toggle-switch-indicator"></span></span>' +
                                '</label>';
                        }
                    },
                    {
                        data: 'created_at',
                        render: function(data, type, row) {
                            if (data) {
                                return moment(data).format('DD/MM/YYYY HH:mm:ss');
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        data: null,
                        render: function(data, type, row) {
                            var editLink = "{{ route('admin_information_edit', ':id') }}"
                                .replace(':id', row.id);
                            return '<a class="table-action" href="' + editLink +
                                '"><i class="fa fa-edit"></i></a>' +
                                '<a class="table-action" href="javascript:;" onclick="deleteItem(' +
                                row.id +
                                ',\'information\')"><i class="fa fa-close"></i></a>';
                        }
                    }
                ],
                // responsive: true,

                order: [
                    [2, "asc"]
                ],
                lengthMenu: [
                    [5, 10, 15, 20, 30],
                    [5, 10, 15, 20, 30],
                ],
                pageLength: 5,
                columnDefs: [{
                        targets: 0,
                        width: '1%',
                        orderable: false,
                    },
                    {
                        targets: 1,
                        width: '10%',
                    },
                    {
                        targets: 2,
                        width: '10%'
                    },
                    {
                        targets: 3,
                        width: '10%'
                    },
                    {
                        targets: 4,
                        width: '15%',
                        checkboxes: {
                            selectRow: true
                        }
                    },
                    {
                        targets: 5,
                        width: '15%'
                    },
                    {
                        targets: 6,
                        width: '10%',
                        orderable: false,

                    },
                ],
                // fixedHeader: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/vi.json'
                }
            });
        });
    </script>
@endsection
