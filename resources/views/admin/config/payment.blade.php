@section('css')
    <script src="{{ url('ckeditor/ckeditor.js') }}"></script>
@endsection
@section('content')
    <main id="content" role="main" class="main">
        {!! html()->form('POST', route('admin_config_payment_update'))->class('validasi')->attributes(['novalidate'])->open() !!}
        <!-- Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm mb-2 mb-sm-0">

                        <h1 class="page-header-title">Cấu hình trang thanh toán</h1>
                    </div>
                </div>
            </div>
            <!-- End Page Header -->
            <div class="row">
                <div class="x_panel">
                    <div class="row">
                        {!! html()->div()->class('row card-body')->open() !!}
                        {!! html()->div()->class('form-group col-7')->open() !!}
                        {!! html()->label('Email nhận thông tin đơn hàng mới')->for('email_payment')->class('input-label') !!}
                        {!! html()->div()->class('input-group')->open() !!}
                        {!! html()->input('text', 'email_payment', $data['email_payment']->value)->class('form-control')->id('email_payment')->placeholder('Email')->aria('label', 'email_payment') !!}
                        {!! html()->div()->class('input-group-append') !!}
                        {!! html()->div()->close() !!}
                        {!! html()->div()->close() !!}
                        {!! html()->div()->class('form-group col-5 row')->open() !!}
                        <label class="toggle-switch row" for="status_payment">
                            <span class="col-sm-10 toggle-switch-content">
                                <span class="text-dark">Trạng thái thanh toán đơn hàng</span>
                            </span>
                            <span class="col-sm-2">
                                {!! html()->input('checkbox', 'status_payment', $data['status_payment']->value)->class('toggle-switch-input')->id('status_payment') !!}
                                <span class="toggle-switch-label ml-auto">
                                    <span class="toggle-switch-indicator"></span>
                                </span>
                            </span>
                        </label>
                        {!! html()->div()->close() !!}
                        {!! html()->div()->close() !!}

                        <div class="col-lg-12">
                            <label class="input-label">Email nhận thông tin gửi về admin</label>
                            <ul>
                                <li>[id] : Mã đơn hàng</li>
                                <li>[name] : Tên người đặt</li>
                                <li>[email] : Email người đặt</li>
                                <li>[phone] : SDT người đặt</li>
                                <li>[address] : Địa chỉ người đặt</li>
                                <li>[date] : Ngày đặt</li>
                                <li>[list_product] : Danh sách sản phẩm</li>
                                <li>[total_price] : Tổng tiền</li>
                                <li>[method_payment] : Phương thức thanh toán</li>
                                <li>[status_payment] : Trạng thái thanh toán</li>
                            </ul>
                            {!! html()->div()->class('quill-custom')->open() !!}
                            {!! html()->textarea('content_email_admin', $data['content_email_admin']->value)->class('form-control')->id('content_email_admin')->rows(10) !!}
                            {!! html()->div()->close() !!}
                        </div>
                        <script>
                            CKEDITOR.replace('content_email_admin', {
                                height: '600px',
                                filebrowserBrowseUrl: "{{ route('ckfinder_browser') }}",
                                filebrowserImageBrowseUrl: "{{ route('ckfinder_browser') }}?type=Images&token=123",
                                filebrowserFlashBrowseUrl: "{{ route('ckfinder_browser') }}?type=Flash&token=123",
                                filebrowserUploadUrl: "{{ route('ckfinder_connector') }}?command=QuickUpload&type=Files",
                                filebrowserImageUploadUrl: "{{ route('ckfinder_connector') }}?command=QuickUpload&type=Images",
                                filebrowserFlashUploadUrl: "{{ route('ckfinder_connector') }}?command=QuickUpload&type=Flash",
                                extraAllowedContent: 'img[!src,alt]{width,height};',
                                allowedContent: true,
                                on: {
                                    instanceReady: function(evt) {
                                        this.dataProcessor.htmlFilter.addRules({
                                            elements: {
                                                p: function(element) {
                                                    if (element.children.length == 1 && element.children[0].name ==
                                                        'img') {
                                                        return element.children[0];
                                                    }
                                                }
                                            }
                                        });
                                    }
                                }
                            });
                        </script>
                        @include('ckfinder::setup')
                    </div>
                    <div class="x_content">
                        <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
                            @foreach ($languages as $val)
                                <li class="nav-item">
                                    <a class="nav-link {!! app()->getLocale() == $val->abbr ? 'active' : '' !!}" id="{{ $val->abbr }}-tab"
                                        data-toggle="tab" href="#lang_{{ $val->abbr }}" role="tab"
                                        aria-controls="{{ $val->abbr }}"
                                        aria-selected="true">{{ $val->name }}{!! app()->getLocale() == $val->abbr ? '*' : '' !!}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            @foreach ($languages as $key => $val)
                                <div class="tab-pane fade show {!! app()->getLocale() == $val->abbr ? 'active' : '' !!}" id="lang_{{ $val->abbr }}"
                                    role="tabpanel" aria-labelledby="{{ $val->abbr }}-tab"
                                    data-lang="{{ $val->abbr }}">
                                    <br>
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label class="input-label">Gửi thông tin đơn hàng cho khách hàng qua
                                                email</label>
                                            <ul>
                                                <li>[id] : Mã đơn hàng</li>
                                                <li>[name] : Tên người đặt</li>
                                                <li>[address] : Địa chỉ người đặt</li>
                                                <li>[date] : Ngày đặt</li>
                                                <li>[list_product] : Danh sách sản phẩm</li>
                                                <li>[total_price] : Tổng tiền</li>
                                                <li>[method_payment] : Phương thức thanh toán</li>
                                                <li>[status_payment] : Trạng thái thanh toán</li>
                                            </ul>
                                            {!! html()->div()->class('quill-custom')->open() !!}
                                            {!! html()->textarea(
                                                    'content_email_user[' . $val->abbr . ']',
                                                    $data['content_email_user']->getTranslation('text', $val->abbr),
                                                )->class('form-control')->id('content_email_user[' . $val->abbr . ']')->rows(10) !!}
                                            {!! html()->div()->close() !!}
                                        </div>
                                    </div>
                                    <br>
                                    <br>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label class="input-label">Trang Cảm ơn </label>
                                            <ul>
                                                <li>[id] : Mã đơn hàng</li>
                                                <li>[name] : Tên người đặt</li>
                                                <li>[address] : Địa chỉ người đặt</li>
                                                <li>[date] : Ngày đặt</li>
                                                <li>[list_product] : Danh sách sản phẩm</li>
                                                <li>[total_price] : Tổng tiền</li>
                                                <li>[method_payment] : Phương thức thanh toán</li>
                                            </ul>
                                            {!! html()->div()->class('quill-custom')->open() !!}
                                            {!! html()->textarea(
                                                    'content_thanks_you[' . $val->abbr . ']',
                                                    $data['content_thanks_you']->getTranslation('text', $val->abbr),
                                                )->class('form-control')->id('content_thanks_you[' . $val->abbr . ']')->rows(10) !!}
                                            {!! html()->div()->close() !!}
                                        </div>
                                    </div>

                                    <br>
                                    <br>
                                    <h2>Đối với trang không thanh toán</h2>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label class="input-label">Gửi thông tin đơn hàng cho khách hàng qua
                                                email</label>
                                            <ul>
                                                <li>[id] : Mã đơn hàng</li>
                                                <li>[name] : Tên người đặt</li>
                                                <li>[address] : Địa chỉ người đặt</li>
                                                <li>[date] : Ngày đặt</li>
                                                <li>[list_product] : Danh sách sản phẩm</li>
                                                <li>[total_price] : Tổng tiền</li>
                                                <li>[method_payment] : Phương thức thanh toán</li>
                                                <li>[status_payment] : Trạng thái thanh toán</li>
                                            </ul>
                                            {!! html()->div()->class('quill-custom')->open() !!}
                                            {!! html()->textarea(
                                                    'content_email_user_nonpayment[' . $val->abbr . ']',
                                                    $data['content_email_user_nonpayment']->getTranslation('text', $val->abbr),
                                                )->class('form-control')->id('content_email_user_nonpayment[' . $val->abbr . ']')->rows(10) !!}
                                            {!! html()->div()->close() !!}
                                        </div>
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <label class="input-label">Trang Cảm ơn</label>
                                            <ul>
                                                <li>[id] : Mã đơn hàng</li>
                                                <li>[name] : Tên người đặt</li>
                                                <li>[address] : Địa chỉ người đặt</li>
                                                <li>[date] : Ngày đặt</li>
                                                <li>[list_product] : Danh sách sản phẩm</li>
                                                <li>[total_price] : Tổng tiền</li>
                                                <li>[method_payment] : Phương thức thanh toán</li>
                                            </ul>
                                            {!! html()->div()->class('quill-custom')->open() !!}
                                            {!! html()->textarea(
                                                    'content_thanks_you_nonpayment[' . $val->abbr . ']',
                                                    $data['content_thanks_you_nonpayment']->getTranslation('text', $val->abbr),
                                                )->class('form-control')->id('content_thanks_you_nonpayment[' . $val->abbr . ']')->rows(10) !!}
                                            {!! html()->div()->close() !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="position-fixed bottom-0 content-centered-x w-100 z-index-99 mb-3" style="max-width: 7rem;">
                <div class="card card-sm bg-dark border-dark mx-2">
                    {!! html()->div()->class('card-body')->open() !!}
                    {!! html()->div()->class('row justify-content-center justify-content-sm-between')->open() !!}
                    <div class="col-auto">
                        {!! html()->button('Lưu')->type('submit')->value('on')->name('save')->class('btn btn-primary') !!}
                    </div>
                    {!! html()->div()->close() !!}
                    {!! html()->div()->close() !!}
                </div>
            </div>
            {!! html()->form()->close() !!}
            <!-- End Content -->
    </main>
@endsection
@section('js')
    <script>
        $(document).ready(function() {
            const contentTypes = ['content_email_user', 'content_thanks_you', 'content_email_user_nonpayment',
                'content_thanks_you_nonpayment'
            ];
            transCkeditor(contentTypes);
        });
    </script>
    @include('ckfinder::setup')
@endsection
