@section('css')
    <style>
        #attachFilesNewProjectLabel {
            position: relative;
            overflow: hidden;
            padding: 0px;
            width: auto;
            min-height: 15rem;
            max-height: 20rem;
        }

        #file-url {
            position: relative;
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        .dz-message.custom-file-boxed-label {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            display: -webkit-box;
            display: -webkit-flex;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -webkit-flex-direction: column;
            flex-direction: column;
            -webkit-box-align: center;
            -webkit-align-items: center;
            align-items: center;
        }
    </style>

    <style>
        .upload__box {
            padding: 40px;
        }

        .upload__inputfile {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }

        .upload__btn {
            display: inline-block;
            font-weight: 600;
            color: #fff;
            text-align: center;
            min-width: 116px;
            padding: 5px;
            transition: all 0.3s ease;
            cursor: pointer;
            border: 2px solid;
            background-color: #4045ba;
            border-color: #4045ba;
            border-radius: 10px;
            line-height: 26px;
            font-size: 14px;
        }

        .upload__btn:hover {
            background-color: unset;
            color: #4045ba;
            transition: all 0.3s ease;
        }

        .upload__btn-box {
            margin-bottom: 10px;
        }

        .upload__img-wrap {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }

        .upload__img-box {
            width: 200px;
            padding: 0 10px;
            margin-bottom: 12px;
        }

        .upload__img-close {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background-color: rgba(0, 0, 0, 0.5);
            position: absolute;
            top: 10px;
            right: 10px;
            text-align: center;
            line-height: 24px;
            z-index: 1;
            cursor: pointer;
        }

        .upload__img-close:after {
            content: '\2716';
            font-size: 14px;
            color: white;
        }

        .img-bg {
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            position: relative;
            padding-bottom: 100%;
        }
    </style>
@endsection
@section('content')
    <main id="content" role="main" class="main">
        {!! html()->form('POST', route('admin_product_store'))->class('validasi')->attributes(['novalidate'])->open() !!}
        <!-- Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm mb-2 mb-sm-0">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-no-gutter">
                                <li class="breadcrumb-item"><a class="breadcrumb-link"
                                        href="{{ route('admin_product_index') }}">Sản phẩm</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Thêm sản phẩm</li>
                            </ol>
                        </nav>

                        <h1 class="page-header-title">Thêm sản phẩm</h1>
                    </div>
                </div>
            </div>
            <!-- End Page Header -->
            <div class="row">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="row">
                            <div class="col-lg-7">
                                <div class="card mb-3 mb-lg-5">
                                    <div class="card-header">
                                        <h4 class="card-header-title">Hình ảnh</h4>
                                        <div class="col-md-10">
                                            {!! html()->input('hidden', 'image')->class('form-control')->id('file-name')->placeholder('Đường dẫn link ảnh')->aria('label', 'Đường dẫn link ảnh') !!}
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="attachFilesNewProjectLabel"
                                            class="dropzone-custom custom-file-boxed dz-clickable">
                                            <img class="" src="" id="file-url" alt="Image Description">
                                            <div class="dz-message custom-file-boxed-label ">
                                                <img class="avatar avatar-xl avatar-4by3 mb-3"
                                                    src="{{ asset('admin/assets/svg/illustrations/browse.svg') }}"
                                                    style="z-index:2" Image Description>
                                                <h5 class="mb-1">Chọn hình ảnh từ máy chủ</h5>
                                                <span type="span" class="btn btn-sm btn-primary" id="upload-image">Click
                                                </span>
                                            </div>
                                        </div>
                                        <!-- End Dropzone -->
                                    </div>

                                    <div class="card-body">
                                        <div class="upload__box">
                                            <div class="upload__btn-box">
                                                <label class="upload__btn">
                                                    <p>Upload images</p>
                                                    <input type="text" multiple="" data-max_length="20" value=''
                                                        name="multiple_image" class="upload__inputfile">
                                                </label>
                                            </div>
                                            <div class="upload__img-wrap"></div>
                                        </div>
                                    </div>
                                    <!-- Body -->
                                    {!! html()->div()->class('card-body')->open() !!}
                                    {!! html()->div()->class('form-group')->open() !!}
                                    {!! html()->label('Link liên kết với nhà phân phối')->for('link_affiliate')->class('input-label') !!}
                                    {!! html()->div()->class('input-group')->open() !!}
                                    {!! html()->input('text', 'link_affiliate')->class('form-control')->id('link_affiliate')->placeholder('Đường dẫn')->aria('label', 'link_affiliate') !!}
                                    {!! html()->div()->class('input-group-append') !!}
                                    {!! html()->div()->close() !!}
                                    {!! html()->div()->close() !!}
                                    {!! html()->div()->close() !!}

                                    {!! html()->div()->class('card-body')->open() !!}
                                    {!! html()->div()->class('form-group col-6 col-sm-6')->open() !!}
                                    {!! html()->label('Thương hiệu')->for('model')->class('input-label') !!}
                                    {!! html()->div()->class('input-group')->open() !!}
                                    {!! html()->input('text', 'model')->class('form-control')->id('model')->placeholder('Thương hiệu')->aria('label', 'Tên thương hiệu') !!}
                                    {!! html()->div()->close() !!}
                                    {!! html()->div()->close() !!}
                                    {!! html()->div()->class('form-group col-6 col-sm-6')->open() !!}
                                    {!! html()->label('Danh sách danh mục')->for('model')->class('input-label') !!}
                                    <select class="form-control" id="product_category_id" name="product_category_id">
                                        @foreach ($categories as $item)
                                            <option value="{{ $item->id }}">
                                                {{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    {!! html()->div()->close() !!}
                                    {!! html()->div()->close() !!}


                                </div>

                            </div>
                            <div class="card col-lg-5">
                                <div class="card-body">
                                    {{-- CODE  --}}
                                    {!! html()->div()->class('form-group')->open() !!}
                                    {!! html()->label('CODE')->for('code')->class('input-label') !!}
                                    {!! html()->div()->class('input-group')->open() !!}
                                    {!! html()->input('text', 'code')->class('form-control')->id('code')->placeholder('Mã sản phẩm')->aria('label', 'code')->attributes(['required', 'onchange' => 'checkCode(null,this.value)']) !!}
                                    {!! html()->div()->class('invalid-tooltip')->open() !!}
                                    Vui lòng nhập đường dẫn
                                    {!! html()->div()->close() !!}
                                    {!! html()->div()->class('input-group-append') !!}
                                    {!! html()->div()->close() !!}
                                    {!! html()->div()->close() !!}

                                    {{-- SLUG  --}}
                                    {!! html()->div()->class('form-group')->open() !!}
                                    {!! html()->label('Slug')->for('slug')->class('input-label') !!}
                                    {!! html()->div()->class('input-group')->open() !!}
                                    {!! html()->input('text', 'slug')->class('form-control')->id('slug')->placeholder('slug')->aria('label', 'slug')->attributes(['required', 'onchange' => 'updateSlug(null,null,this.value,"products")']) !!}
                                    {!! html()->div()->class('invalid-tooltip')->open() !!}
                                    Vui lòng nhập đường dẫn
                                    {!! html()->div()->close() !!}
                                    {!! html()->div()->class('input-group-append') !!}
                                    {!! html()->div()->close() !!}
                                    {!! html()->div()->close() !!}

                                    {{-- STATUS  --}}
                                    {!! html()->div()->class('form-group')->open() !!}
                                    <label class="toggle-switch" for="status">
                                        <span class="col-8 col-sm-9 toggle-switch-content">
                                            <span class="text-dark">Kích hoạt</span>
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

                        </div>
                        <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
                            @foreach ($languages as $val)
                                <li class="nav-item">
                                    <a class="nav-link {!! app()->getLocale() == $val->abbr ? 'active' : '' !!}" id="{{ $val->abbr }}-tab"
                                        data-toggle="tab" href="#lang_{{ $val->abbr }}" role="tab"
                                        data-lang="{{ $val->abbr }}" aria-controls="{{ $val->abbr }}"
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
                                                    <h4 class="card-header-title">Thông tin sản phẩm</h4>
                                                </div>

                                                <div class="card-body">
                                                    {!! html()->div()->class('form-group')->open() !!}
                                                    {!! html()->label('Tên<span class="required">*</span> ')->for('name')->class('input-label') !!}
                                                    {!! html()->div()->class('input-group')->open() !!}
                                                    {!! html()->input('text', 'name[' . $val->abbr . ']')->class('form-control')->id('name')->placeholder('Tên sản phẩm')->aria('label', 'Tên sản phẩm')->attributes(['required', 'onchange' => 'updateSlug(null,this.value,null,"products")']) !!}
                                                    {!! html()->div()->class('invalid-tooltip')->open() !!}
                                                    Vui lòng nhập tên bài viết
                                                    {!! html()->div()->close() !!}
                                                    {!! html()->div()->close() !!}
                                                    {!! html()->div()->close() !!}
                                                </div>
                                                <div class="card-body">
                                                    {!! html()->div()->class('form-group col-md-4')->open() !!}
                                                    {!! html()->label('Giá tiền<span class="required">*</span> ')->for('price')->class('input-label') !!}
                                                    {!! html()->div()->class('input-group')->open() !!}
                                                    {!! html()->input('number', 'price[' . $val->abbr . ']')->class('form-control')->id('price')->placeholder('Giá sản phẩm')->aria('label', 'Tên danh mục')->attributes(['required']) !!}
                                                    {!! html()->div()->class('invalid-tooltip')->open() !!}
                                                    Vui lòng nhập giá tiền
                                                    {!! html()->div()->close() !!}
                                                    {!! html()->div()->close() !!}
                                                    {!! html()->div()->close() !!}

                                                    {!! html()->div()->class('form-group col-md-2')->open() !!}
                                                    {!! html()->label('Đơn vị')->for('price')->class('input-label') !!}
                                                    <select class="form-control" id="unit"
                                                        name="unit[{{ $val->abbr }}]">
                                                        @foreach ($languages as $lang)
                                                            <option value="{{ $lang->unit }}" {!! $lang->abbr == $val->abbr ? 'selected' : '' !!}>
                                                                {{ $lang->unit }}</option>
                                                        @endforeach
                                                    </select>
                                                    {!! html()->div()->close() !!}

                                                    {!! html()->div()->class('form-group col-md-6')->open() !!}
                                                    {!! html()->label('Xuất xứ')->for('made')->class('input-label') !!}
                                                    {!! html()->div()->class('input-group')->open() !!}
                                                    {!! html()->input('text', 'made[' . $val->abbr . ']')->class('form-control')->id('made')->placeholder('Xuất xứ')->aria('label', 'Xuất xứ') !!}
                                                    {!! html()->div()->close() !!}
                                                    {!! html()->div()->close() !!}
                                                </div>

                                                {{-- <div class="card-header">
                                                    <h4 class="card-header-title">Thông số sản phẩm</h4>
                                                </div>
                                                <div class="card-body" id="req_input">

                                                </div>
                                                <button type="button" class="btn btn-success" href="javascript:;"
                                                    id="addmore">Thêm</button>


                                                <script>
                                                    $(document).ready(function() {
                                                        $("#addmore").click(function() {
                                                            $("#req_input").append(
                                                                '<div class="form-group required_inp"><input class="form-control col-2 col-sm-3" name="parameter[{{ $val->abbr }}][]" placeholder="Từ khóa" type="text">' +
                                                                '<input class="form-control col-6 col-sm-7" name="specification[{{ $val->abbr }}][]" placeholder="Giá trị" type="text">' +
                                                                '<input type="button" id="inputRemove" class=" form-control col-2 col-sm-1 btn btn-danger" value="X"/></div>');
                                                        });
                                                        $('body').on('click', '#inputRemove', function() {
                                                            $(this).parent('div.required_inp').remove()
                                                        });
                                                    });
                                                </script> --}}
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
                                            <label class="input-label">Thông tin sản phẩm<span
                                                    class="input-label-secondary">(không
                                                    bắt
                                                    buộc)</span></label>
                                            {!! html()->div()->class('quill-custom')->open() !!}
                                            {!! html()->textarea('summary[' . $val->abbr . ']')->class('form-control')->id('summary[' . $val->abbr . ']')->rows(10) !!}
                                            {!! html()->div()->close() !!}
                                        </div>
                                        <div class="col-lg-12">
                                            <label class="input-label">Mô tả sản phẩm<span
                                                    class="input-label-secondary">(không
                                                    bắt
                                                    buộc)</span></label>
                                            {!! html()->div()->class('quill-custom')->open() !!}
                                            {!! html()->textarea('description[' . $val->abbr . ']')->class('form-control')->id('description[' . $val->abbr . ']')->rows(10) !!}
                                            {!! html()->div()->close() !!}
                                        </div>

                                        <style>
                                            #cke_{{ ($key + 1) * 2 }}_contents {
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
    configureCKFinder('upload-image');

    jQuery(document).ready(function() {
        // Khởi tạo việc upload ảnh cho tất cả các upload__box
        initImageUpload('.upload__box');

        // Khởi tạo giá trị ban đầu cho inputfile
        setInputValue('.upload__inputfile');

        // Hàm để khởi tạo việc upload ảnh
        function initImageUpload(selector) {
            $(selector).each(function() {
                var imgWrap = $(this).find('.upload__img-wrap');
                var inputElement = $(this).find('.upload__inputfile')[0];

                $(this).on('click', ".upload__inputfile", function(e) {
                    e.preventDefault();
                    var maxLength = $(this).data('max_length');

                    CKFinder.popup({
                        chooseFiles: true,
                        onInit: function(finder) {
                            finder.on('files:choose', function(evt) {
                                var files = evt.data.files.models;
                                var currentValue = inputElement.value;
                                var currentArray = currentValue ? JSON
                                    .parse(currentValue) : [];

                                files.forEach(function(f) {
                                    var url = f.getUrl();
                                    var path = getPath(url);
                                    if (currentArray.length >=
                                        maxLength) {
                                        return false;
                                    }

                                    currentArray.push(path);

                                    var urlImage =
                                        `{{ asset('${path}') }}`;

                                    var html =
                                        "<div class='upload__img-box'>" +
                                        "<div style='background-image: url(" +
                                        urlImage + ")' " +
                                        "data-number='" + $(
                                            ".upload__img-close")
                                        .length +
                                        "' " +
                                        "data-file='" + f.get(
                                            'name') +
                                        "' class='img-bg'>" +
                                        "<div class='upload__img-close'></div></div></div>";
                                    imgWrap.append(html);
                                    inputElement.value = JSON
                                        .stringify(currentArray);
                                });
                            });
                        }
                    });
                });

                $(this).on('click', ".upload__img-close", function(e) {
                    e.preventDefault();
                    var file = $(this).parent().data("file");
                    var currentValue = inputElement.value;
                    var currentArray = currentValue ? JSON.parse(currentValue) : [];
                    var deleted = false; // Biến để đánh dấu đã xóa một phần tử chưa

                    var updatedArray = currentArray.filter(function(item) {
                        if (!deleted && item.includes(file)) {
                            deleted = true;
                            return false; // Không bao gồm phần tử này trong mảng kết quả
                        }
                        return true; // Bao gồm các phần tử không trùng và phần tử đã xóa rồi
                    });

                    inputElement.value = JSON.stringify(updatedArray);

                    $(this).parent().parent().remove();
                });
            });
        }

        // Hàm để cập nhật giá trị cho inputfile
        function setInputValue(selector) {
            $(selector).each(function() {
                var inputValue = $(this).val();
                if (inputValue) {
                    try {
                        var imgArray = JSON.parse(inputValue);
                        var imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');

                        imgArray.forEach(function(url) {
                            var parts = url.split('/');
                            var name = parts[parts.length - 1];

                            var urlImage =
                                `{{ asset('${url}') }}`;

                            var html = "<div class='upload__img-box'>" +
                                "<div style='background-image: url(" + urlImage + ")' " +
                                "data-number='" + $(".upload__img-close").length + "' " +
                                "data-file='" + name + "' class='img-bg'>" +
                                "<div class='upload__img-close'></div></div></div>";
                            imgWrap.append(html);
                        });
                    } catch (error) {
                        console.error("Lỗi khi phân tích giá trị JSON:", error);
                    }
                }
            });
        }
    });
    $(document).ready(function() {
        const contentTypes = ['summary', 'description'];
        transCkeditor(contentTypes);
        transInput();
    });
</script>
@include('ckfinder::setup')
@endsection
