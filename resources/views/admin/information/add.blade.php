@section('css')
@endsection
@section('content')
    <main id="content" role="main" class="main">
        {!! html()->form('POST', route('admin_information_store'))->class('validasi')->attributes(['novalidate'])->open() !!}
        <!-- Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm mb-2 mb-sm-0">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-no-gutter">
                                <li class="breadcrumb-item"><a class="breadcrumb-link"
                                        href="{{ route('admin_information_index') }}">Thông tin</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Thêm thông tin</li>
                            </ol>
                        </nav>
                        <h1 class="page-header-title">Thêm thông tin</h1>
                    </div>
                </div>
            </div>
            <!-- End Page Header -->
            <div class="row">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="card card-body">
                                    {!! html()->div()->class('form-group')->open() !!}
                                    {!! html()->label('Meta robot')->for('meta_robots') !!}
                                    {!! html()->select('meta_robots', [
                                            'index,follow' => 'index,follow',
                                            'noindex,nofollow' => 'noindex,nofollow',
                                            'index,nofollow' => 'index,nofollow',
                                            'noindex,follow' => 'noindex,follow',
                                        ])->class('form-control')->id('meta_robots') !!}
                                    {!! html()->div()->close() !!}
                                    {!! html()->div()->class('form-group')->open() !!}
                                    {!! html()->label('Rel')->for('rel') !!}
                                    {!! html()->select('rel', ['dofollow' => 'dofollow', 'nofollow' => 'nofollow'])->class('form-control')->id('rel') !!}
                                    {!! html()->div()->close() !!}
                                    {!! html()->div()->class('form-group')->open() !!}
                                    {!! html()->label('Target')->for('target') !!}
                                    {!! html()->select('target', ['_self' => '_self', '_blank' => '_blank'])->class('form-control')->id('target') !!}
                                    {!! html()->div()->close() !!}
                                </div>
                            </div>
                            <div class="card col-lg-5">
                                {!! html()->div()->class('form-group')->open() !!}
                                {!! html()->label('Slug')->for('slug')->class('input-label') !!}
                                {!! html()->div()->class('input-group')->open() !!}
                                {!! html()->input('text', 'slug')->class('form-control')->id('slug')->placeholder('slug')->aria('label', 'slug')->attributes(['required', 'onchange' => 'updateSlug(null,null,this->value,"information")']) !!}
                                {!! html()->div()->class('invalid-tooltip')->open() !!}
                                Vui lòng nhập đường dẫn
                                {!! html()->div()->close() !!}
                                {!! html()->div()->class('input-group-append') !!}
                                {!! html()->div()->close() !!}
                                {!! html()->div()->close() !!}

                                {!! html()->div()->class('form-group')->open() !!}
                                <label class="toggle-switch" for="status">
                                    <span class="col-8 col-sm-9 toggle-switch-content">
                                        <span class="text-dark">Trạng thái</span>
                                    </span>
                                    <span class="col-4 col-sm-3">
                                        {!! html()->input('checkbox', 'status')->class('toggle-switch-input')->id('status')->checked() !!}
                                        <span class="toggle-switch-label ml-auto">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </span>
                                </label>
                                {!! html()->div()->close() !!}
                                {!! html()->div()->class('form-group')->open() !!}
                                <label class="toggle-switch" for="view_header">
                                    <span class="col-8 col-sm-9 toggle-switch-content">
                                        <span class="text-dark">Header</span>
                                    </span>
                                    <span class="col-4 col-sm-3">
                                        {!! html()->input('checkbox', 'view_header')->class('toggle-switch-input')->id('view_header')->checked() !!}
                                        <span class="toggle-switch-label ml-auto">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </span>
                                </label>
                                {!! html()->div()->close() !!}
                                {!! html()->div()->class('form-group')->open() !!}
                                <label class="toggle-switch" for="view_footer">
                                    <span class="col-8 col-sm-9 toggle-switch-content">
                                        <span class="text-dark">Footer</span>
                                    </span>
                                    <span class="col-4 col-sm-3">
                                        {!! html()->input('checkbox', 'view_footer')->class('toggle-switch-input')->id('view_footer')->checked() !!}
                                        <span class="toggle-switch-label ml-auto">
                                            <span class="toggle-switch-indicator"></span>
                                        </span>
                                    </span>
                                </label>
                                {!! html()->div()->close() !!}

                            </div>

                        </div>
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
                                    <div class="row">
                                        <div class="col-lg-7">
                                            <div class="card mb-3 mb-lg-5">
                                                <div class="card-header">
                                                    <h4 class="card-header-title">Thông tin</h4>
                                                </div>

                                                <div class="card-body">
                                                    <!-- Form Group -->
                                                    {!! html()->div()->class('form-group')->open() !!}
                                                    {!! html()->label('Tên<span class="required">*</span> ')->for('name')->class('input-label') !!}
                                                    {!! html()->div()->class('input-group')->open() !!}
                                                    {!! html()->input('text', 'name[' . $val->abbr . ']')->class('form-control')->id('name')->placeholder('Tên')->aria('label', 'Tên')->attributes(['required', 'onchange' => "updateSlug(null,this.value,null,'information')"]) !!}
                                                    {!! html()->div()->class('invalid-tooltip')->open() !!}
                                                    Vui lòng nhập tên
                                                    {!! html()->div()->close() !!}
                                                    {!! html()->div()->close() !!}
                                                    {!! html()->div()->close() !!}

                                                    <!-- End Card -->

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-5">
                                            <div class="card mb-3 mb-lg-5">
                                                <div class="card-header">
                                                    <h4 class="card-header-title">SEO</h4>
                                                </div>
                                                <div class="card-body">

                                                    {!! html()->div()->class('form-group')->open() !!}
                                                    {!! html()->label('Meta title')->for('meta_title')->class('input-label') !!}
                                                    {!! html()->div()->class('input-group')->open() !!}
                                                    {!! html()->input('text', 'meta_title[' . $val->abbr . ']')->class('form-control')->id('meta_title')->placeholder('meta_title')->aria('label', 'meta_title') !!}
                                                    {!! html()->div()->class('input-group-append') !!}
                                                    {!! html()->div()->close() !!}
                                                    {!! html()->div()->close() !!}

                                                    {!! html()->div()->class('form-group')->open() !!}
                                                    {!! html()->label('Meta keyword')->for('meta_keyword')->class('input-label') !!}
                                                    {!! html()->div()->class('input-group')->open() !!}
                                                    {!! html()->input('text', 'meta_keyword[' . $val->abbr . ']')->class('form-control')->id('meta_keyword')->placeholder('meta_keyword')->aria('label', 'meta_keyword') !!}
                                                    {!! html()->div()->close() !!}
                                                    {!! html()->div()->close() !!}

                                                    {!! html()->div()->class('form-group')->open() !!}
                                                    {!! html()->label('Meta description')->for('meta_description')->class('input-label') !!}
                                                    {!! html()->div()->class('input-group')->open() !!}
                                                    {!! html()->input('text', 'meta_description[' . $val->abbr . ']')->class('form-control')->id('meta_description')->placeholder('meta_description')->aria('label', 'meta_description') !!}
                                                    {!! html()->div()->close() !!}
                                                    {!! html()->div()->close() !!}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <label class="input-label">Mô tả<span class="input-label-secondary">(
                                                    bắt
                                                    buộc)</span></label>
                                            {!! html()->div()->class('quill-custom')->open() !!}
                                            {!! html()->textarea('description[' . $val->abbr . ']')->class('form-control')->id('description[' . $val->abbr . ']')->rows(10) !!}
                                            {!! html()->div()->close() !!}
                                        </div>

                                        <style>
                                            #cke_{{ $key + 1 }}_contents {
                                                min-height: 1000px !important;
                                            }
                                        </style>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="position-fixed bottom-0 content-centered-x w-100 z-index-99 mb-3" style="max-width: 40rem;">
                <div class="card card-sm bg-dark border-dark mx-2">
                    {!! html()->div()->class('card-body')->open() !!}
                    {!! html()->div()->class('row justify-content-center justify-content-sm-between')->open() !!}
                    <div class="col">
                        {!! html()->button('Lưu và thoát')->type('submit')->value('on')->name('saveAndBack')->class('btn btn-ghost-danger') !!}
                    </div>
                    <div class="col-auto">
                        {!! html()->button('Lưu và thêm mới')->type('submit')->value('on')->name('saveAndNew')->class('btn btn-ghost-light mr-2') !!}
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
            const contentTypes = ['description'];
            transCkeditor(contentTypes);
            transInput();
        });
    </script>
    @include('ckfinder::setup')
@endsection
