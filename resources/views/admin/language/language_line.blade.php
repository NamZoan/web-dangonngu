@extends('admin.layouts.index')
@section('css')
    <style type="text/css">
        body {
            margin-top: 20px;
        }
    </style>
@endsection

@section('content')
    <a href="{{ route('admin_language_line_add') }}"><button type="button" class="btn btn-secondary btn-lg">Thêm</button></a>

    <div class="row">
        <div class="col-md-12 col-sm-12 ">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Danh Sách Text</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-box table-responsive">
                                <table id="datatable" class="table table-striped table-bordered" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Group</th>
                                            <th>Key</th>
                                            <th>Tiếng Việt</th>
                                            <th>Tiếng Anh</th>
                                            <th>Tiếng Pháp</th>
                                            <th>Hoạt động</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($languageLines as $item)
                                            @php
                                                // Biến chứa JSON các thông báo

                                                // Giải mã JSON thành mảng PHP
                                                $messages = $item->text;

                                                // Ngôn ngữ mặc định, bạn có thể thay đổi theo ngôn ngữ hiện tại của ứng dụng
                                                $defaultLanguage = 'en';

                                                // Lấy thông báo theo ngôn ngữ mặc định
                                                $defaultMessage = $messages[$defaultLanguage] ?? '';

                                                // Lấy thông báo theo ngôn ngữ cụ thể
                                                $specificLanguage1 = 'vi';
                                                $specificMessage1 = $messages[$specificLanguage1] ?? '';

                                                // Lấy thông báo theo ngôn ngữ cụ thể
                                                $specificLanguage2 = 'fr';
                                                $specificMessage2 = $messages[$specificLanguage2] ?? '';
                                            @endphp
                                            <tr>
                                                <td>{{ $item->id }}</td>
                                                <td>{{ $item->group }}</td>
                                                <td>{{ $item->key }}</td>
                                                <td>{{ $specificMessage1 }}</td>
                                                <td>{{ $defaultMessage }}</td>
                                                <td>{{ $specificMessage2 }}</td>
                                                <td>
                                                    <a
                                                        href="{{ route('admin_language_line_update', ['id' => $item->id]) }}">Chỉnh
                                                        sửa</a>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
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
@endsection
