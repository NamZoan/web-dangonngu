@section('css')
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
    <script>
        var myEditor = [];
        var description = [];
    </script>
    <link rel="stylesheet" href="{{ asset('vendors/multi-select-tag/multi-select-tag.css') }}">
@endsection
@section('content')
    <main id="content" role="main" class="main">
        {!! html()->form('POST', route('admin_config_home_update'))->class('validasi')->attributes(['novalidate'])->open() !!}
        <!-- Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row align-items-center">
                    <div class="col-sm mb-2 mb-sm-0">

                        <h1 class="page-header-title">Cấu hình trang chủ</h1>
                    </div>
                </div>
            </div>
            <!-- End Page Header -->
            <div class="row">
                <div class="x_panel">
                    <div class="x_content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card mb-3 mb-lg-5">
                                    <div class="card-header">
                                        <h4 class="card-header-title">Hình ảnh slides</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="upload__box">
                                            <div class="upload__btn-box">
                                                <label class="upload__btn">
                                                    <p>Upload images</p>
                                                    <input type="text" multiple="" data-max_length="20"
                                                        value='{{ $data['slides']->value }}' name="slides"
                                                        class="upload__inputfile">
                                                </label>
                                            </div>
                                            <div class="upload__img-wrap"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card mb-3 mb-lg-5">
                                    <div class="card-header">
                                        <h4 class="card-header-title">Hình ảnh kết quả biến đổi</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="upload__box">
                                            <div class="upload__btn-box">
                                                <label class="upload__btn">
                                                    <p>Upload images</p>
                                                    <input type="text" multiple="" data-max_length="20"
                                                        value='{{ $data['images']->value }}' name="images"
                                                        class="upload__inputfile">
                                                </label>
                                            </div>
                                            <div class="upload__img-wrap"></div>
                                        </div>
                                    </div>
                                </div>

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
                                        <div class="card col-lg-12">
                                            <div class="card-header">
                                                <h4 class="card-header-title">SEO</h4>
                                            </div>
                                            <div class="card-body">

                                                {!! html()->div()->class('form-group col-lg-4 ')->open() !!}
                                                {!! html()->label('Meta title')->for('meta_title')->class('input-label') !!}
                                                {!! html()->div()->class('input-group')->open() !!}
                                                {!! html()->input('text', 'meta_title[' . $val->abbr . ']', $data['meta_title']->getTranslation('text', $val->abbr))->class('form-control')->id('meta_title')->placeholder('meta_title')->aria('label', 'meta_title') !!}
                                                {!! html()->div()->class('input-group-append') !!}
                                                {!! html()->div()->close() !!}
                                                {!! html()->div()->close() !!}

                                                {!! html()->div()->class('form-group col-lg-4')->open() !!}
                                                {!! html()->label('Meta keyword')->for('meta_keyword')->class('input-label') !!}
                                                {!! html()->div()->class('input-group')->open() !!}
                                                {!! html()->input('text', 'meta_keyword[' . $val->abbr . ']', $data['meta_keyword']->getTranslation('text', $val->abbr))->class('form-control')->id('meta_keyword')->placeholder('meta_keyword')->aria('label', 'meta_keyword') !!}
                                                {!! html()->div()->close() !!}
                                                {!! html()->div()->close() !!}


                                                {!! html()->div()->class('form-group col-lg-4')->open() !!}
                                                {!! html()->label('Meta description')->for('meta_description')->class('input-label') !!}
                                                {!! html()->div()->class('input-group')->open() !!}
                                                {!! html()->input(
                                                        'text',
                                                        'meta_description[' . $val->abbr . ']',
                                                        $data['meta_description']->getTranslation('text', $val->abbr),
                                                    )->class('form-control')->id('meta_description')->placeholder('meta_description')->aria('label', 'meta_description') !!}
                                                {!! html()->div()->close() !!}
                                                {!! html()->div()->close() !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <label class="input-label">Mô tả</label>
                                            {!! html()->div()->class('quill-custom')->open() !!}
                                            {!! html()->textarea('description[' . $val->abbr . ']', $data['description_slide']->getTranslation('text', $val->abbr))->class('form-control')->id('description[' . $val->abbr . ']')->rows(10) !!}
                                            {!! html()->div()->close() !!}
                                        </div>
                                        <script src="{{ url('ckeditor/ckeditor.js') }}"></script>
                                        <script>
                                            description['{{ $val->abbr }}'] = CKEDITOR.replace('description[{{ $val->abbr }}]', {
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

            var langs = [];
            $('[id^="lang_"]').each(function() {
                langs.push($(this).data('lang'));
            });

            $('[id^="lang_"]').each(function() {
                var lang = $(this).attr('id').replace('lang_', '');
                var langDefault = $(this);
                var childsLangDefault = langDefault.find('input');
                childsLangDefault.each(function() {
                    var elementId = $(this).attr('id');
                    $(this).on('change', function() {
                        const swalWithBootstrapButtons = Swal.mixin({
                            customClass: {
                                confirmButton: "btn btn-success",
                                cancelButton: "btn btn-danger"
                            },
                            buttonsStyling: false
                        });
                        swalWithBootstrapButtons.fire({
                            title: "Dịch ngôn ngữ?",
                            icon: "warning",
                            showCancelButton: true,
                            cancelButtonText: "Không",
                            confirmButtonText: "Có",
                            reverseButtons: true
                        }).then((result) => {
                            if (result.isConfirmed) {
                                for (var i = 0; i < langs.length; i++) {
                                    if (lang != langs[i]) {
                                        var to = langs[i];
                                        var val = translate(lang, to, $(this).val(),
                                            elementId);
                                    }
                                }
                            }
                        });
                    });
                });
            });

            // dịch ngôn ngữ cho phần editor
            $('[id^="lang_"]').each(function() {
                let lang = $(this).data('lang');
                description[lang].on('instanceReady', function(evt) {
                    const editor = evt.editor;
                    var saveButton = editor.ui.get('Save');
                    if (saveButton) {
                        var saveButtonElement = editor.container.$.querySelector(
                            '.cke_button__save');
                        if (saveButtonElement) {
                            saveButtonElement.onclick = function(evt) {
                                evt.preventDefault();
                                evt.stopPropagation();

                                editor.execCommand('saveCommand');
                                var currentContent = editor.getData();
                                const swalWithBootstrapButtons = Swal.mixin({
                                    customClass: {
                                        confirmButton: "btn btn-success",
                                        cancelButton: "btn btn-danger"
                                    },
                                    buttonsStyling: false
                                });
                                swalWithBootstrapButtons.fire({
                                    title: "Dịch ngôn ngữ?",
                                    icon: "warning",
                                    showCancelButton: true,
                                    cancelButtonText: "Không",
                                    confirmButtonText: "Có",
                                    reverseButtons: true
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        for (var i = 0; i < langs.length; i++) {
                                            if (lang != langs[i]) {
                                                translate(lang, langs[i],
                                                    currentContent, 'description',
                                                    true);
                                            }
                                        }
                                    }
                                });
                            };
                        }
                    }
                });
            });

        });
    </script>

    <script>
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
    </script>
@endsection
