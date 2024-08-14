<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">

    <title>Chart JS Graph Examples | Gentelella Alela! by Colorlib</title>
    <!-- Bootstrap -->
    <link href="{{ asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- SweetAlert -->
    <script src="{{ asset('js/sweetalert2/sweetalert2.min.js') }}"></script>

    <script src="{{ url('ckeditor/ckeditor.js') }}"></script>
    <script>
        function configureCKFinder(uploadButtonId) {
            var button = document.getElementById(uploadButtonId);

            if (button) {
                button.addEventListener('click', function() {
                    CKFinder.modal({
                        chooseFiles: true,
                        width: 1000,
                        height: 800,
                        onInit: function(finder) {
                            finder.on('files:choose', function(evt) {
                                var file = evt.data.files.first();
                                var outputFileName = document.getElementById('file-name');
                                var outputFileUrl = document.getElementById('file-url');
                                path = getPath(file.getUrl());
                                var urlImage =
                                    `{{ asset('${path}') }}`;
                                outputFileName.value = path;
                                outputFileUrl.src = urlImage;
                                const image = document.getElementById("file-url");
                                if (image) {
                                    if (!image.getAttribute("src")) {
                                        image.style.display = "none";
                                    } else {
                                        image.style.display = "block";
                                    }
                                }
                            });
                            finder.on('file:choose:resizedImage', function(evt) {
                                var outputFileName = document.getElementById('file-name');
                                var outputFileUrl = document.getElementById('file-url');
                                path = getPath(evt.data.file.getUrl());
                                var urlImage =
                                    `{{ asset('${path}') }}`;
                                outputFileName.value = path;
                                outputFileUrl.src = urlImage;
                            });
                        }
                    });
                });
            } else {
                console.error("Element with id '" + uploadButtonId + "' not found.");
            }
        }
    </script>

    @yield('css')
    <!-- Custom Theme Style -->
    <link href="{{ asset('build/css/custom.css') }}" rel="stylesheet">
    @include('admin/layouts/assets/js')
    <script>
        var token = "{{ auth()->user()->api_token }}";
        var headers = {
            'Authorization': 'Bearer ' + token
        };
    </script>
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <!-- sidebar -->
            @include ('admin.layouts.elements.sidebar')
            <!-- end sidebar -->
            <!-- top navigation -->
            @include ('admin.layouts.elements.topbar')
            <!-- top navigation -->
            <!-- page content -->
            <div class="right_col" role="main">
                <br>
                <br>
                <br>
                <!-- main  -->
                @yield('content')
                <!-- end main -->
            </div>
            <!-- page content -->
        </div>
    </div>
    <!-- jQuery -->
    <script src="{{ asset('vendors/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ asset('vendors/nprogress/nprogress.js') }}"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{ asset('build/js/custom.min.js') }}"></script>
    @yield('js')

    <script>
        function getPath(url) {
            var parser = new URL(url);
            var path = parser.pathname;
            if (path.startsWith('/')) {
                path = path.substring(1);
            }
            return path;
        }

        function translate(from, to, text, contentType, html = false) {
            NProgress.start();
            $.ajax({
                method: 'GET',
                url: "{{ route('admin.api.translate') }}",
                headers: headers,
                data: {
                    from: from,
                    to: to,
                    text: text,
                    html: html
                },
                success: function(data) {
                    if (html === true) {
                        var $translatedContent = $('<div>').html(data.translatedText);
                        processTranslatedContent($translatedContent, function(processedHtml) {
                            if (editorInstances[contentType] && editorInstances[contentType][to]) {
                                editorInstances[contentType][to].setData(processedHtml);
                            }
                            NProgress.done();
                        });
                    } else {
                        $('#lang_' + to + ' #' + contentType).val(data.translatedText);
                        if (contentType === 'name') {
                            $('#lang_' + to + ' #meta_title').val(data.translatedText);
                        }
                        NProgress.done();
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: "Có lỗi xảy ra",
                        showConfirmButton: false,
                        timer: 1000
                    });
                }
            });

            function processTranslatedContent($content, callback) {
                $content.find('*').each(function() {
                    $(this).html($(this).html().replace(/&lt;|&gt;/g, ''));
                });
                var processedHtml = $content.html();
                callback(processedHtml);
            }
        }

        function updateSlug(id = null, name = null, slug = null, table) {
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.api.generateSlug') }}",
                headers: headers,
                data: {
                    id: id,
                    name: name,
                    slug: slug,
                    table: table
                },
                success: function(data) {
                    $('#meta_title').val(name);
                    $('#slug').val(data.slug);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        var form = document.querySelector('.validasi');

        if (form) {
            var buttons = form.querySelectorAll('button');

            buttons.forEach(function(button) {
                button.addEventListener('keypress', function(event) {
                    if (event.keyCode === 13) {
                        event.preventDefault();
                        return false;
                    }
                });
            });

            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        }

        // clear cache 

        function clearCache() {
            $.ajax({
                url: "{{ route('admin.api.clearCache') }}",
                type: 'DELETE',
                headers: headers,
                success: function(data) {
                    Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Xóa cache thành công",
                        showConfirmButton: false,
                        timer: 1000
                    });
                },
                error: function(data) {
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: "Xóa cache thất bại",
                        showConfirmButton: false,
                        timer: 1000
                    });
                }
            });
        }

        function updateStatus(id, field, table) {
            NProgress.start();
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.api.updateStatus') }}",
                headers: headers,
                data: {
                    id: id,
                    field: field,
                    table: table,
                },
                success: function(response) {
                    NProgress.done();
                    if (response.status == true) {
                        if (response.field_status == 1) {
                            $('#' + field + '_' + id).prop('checked', true);
                        } else {
                            $('#' + field + '_' + id).prop('checked', false);
                        }
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Cập nhập thành công",
                            showConfirmButton: false,
                            timer: 1000
                        });
                    } else {
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: "Cập nhập thất bại",
                            showConfirmButton: false,
                            timer: 1000
                        });
                    }
                },
                error: function(response) {
                    NProgress.done();
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: "Cập nhập thất bại",
                        showConfirmButton: false,
                        timer: 1000
                    });
                }
            });
        }

        function reloadTable() {
            var table = $('#datatable1').DataTable();
            var currentPage = table.page.info().page;
            table.ajax.reload(null, false, true, currentPage);
        }

        function deleteItem(id, table) {
            $.ajax({
                method: 'POST',
                url: "{{ route('admin.api.deleteItem') }}",
                headers: headers,
                data: {
                    id: id,
                    table: table,
                },
                success: function(response) {
                    if (response.status == true) {
                        reloadTable();
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Cập nhập thành công",
                            showConfirmButton: false,
                            timer: 1000
                        });
                    } else {
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: "Cập nhập thất bại",
                            showConfirmButton: false,
                            timer: 1000
                        });
                    }

                },
                error: function(response) {
                    Swal.fire({
                        position: "top-end",
                        icon: "error",
                        title: "Cập nhập thất bại",
                        showConfirmButton: false,
                        timer: 1000
                    });
                }
            });
        }

        $('#language-select').on('change', function() {
            reloadTable();
        });

        // Object to store CKEditor instances
        const editorInstances = {};

        // Function to initialize CKEditor with custom configurations
        function initializeCKEditor(editorType, langKey) {
            let editorInstance = CKEDITOR.replace(`${editorType}[${langKey}]`, {
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
                                    if (element.children.length === 1 && element.children[0]
                                        .name === 'img') {
                                        return element.children[0];
                                    }
                                }
                            }
                        });
                    }
                }
            });
            // Store the instance in the editorInstances object
            if (!editorInstances[editorType]) {
                editorInstances[editorType] = {};
            }
            editorInstances[editorType][langKey] = editorInstance;

            return editorInstance;
        }

        // Function to set up save button behavior for CKEditor instances
        function setupSaveButton(editorInstance, langKey, contentType) {
            editorInstance.on('instanceReady', function(evt) {
                const editor = evt.editor;
                const saveButton = editor.ui.get('Save');
                if (saveButton) {
                    const saveButtonElement = editor.container.$.querySelector('.cke_button__save');
                    if (saveButtonElement) {
                        saveButtonElement.onclick = function(evt) {
                            evt.preventDefault();
                            evt.stopPropagation();

                            editor.execCommand('saveCommand');
                            const currentContent = editor.getData();
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
                                    for (const targetLang of langs) {
                                        if (langKey !== targetLang) {
                                            translate(langKey, targetLang, currentContent, contentType,
                                                true);
                                        }
                                    }
                                }
                            });
                        };
                    }
                }
            });
        }

        // Initialize CKEditor and save button behavior for each language
        function transCkeditor(contentTypes) {
            langs = [];
            $('[id^="lang_"]').each(function() {
                const lang = $(this).data('lang');
                langs.push($(this).data('lang'));
                for (const contentType of contentTypes) {
                    const editorInstance = initializeCKEditor(contentType, lang);
                    setupSaveButton(editorInstance, lang, contentType);
                }
            });
        }

        function transInput() {
            var langs = [];
            $('[id^="lang_"]').each(function() {
                langs.push($(this).data('lang'));
            });

            $('[id^="lang_"]').each(function() {
                var lang = $(this).attr('id').replace('lang_', '');
                var langInput = $(this);
                var childsLangInput = langInput.find('input');
                childsLangInput.each(function() {
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
                                        var val = translate(lang, to, $(this)
                                            .val(),
                                            elementId);
                                    }
                                }
                            }
                        });
                    });
                });
            });
        }

        function checkCode(id = null, code = null) {
            $.ajax({
                method: 'GET',
                url: "{{ route('admin.api.checkProductCode') }}",
                headers: headers,
                data: {
                    code: code,
                    id: id
                },
                success: function(data) {
                    if (data.status == true) {
                        Swal.fire({
                            position: "top-end",
                            icon: "error",
                            title: "Mã sản phẩm đã tồn tại",
                            showConfirmButton: false,
                            timer: 1000
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

        function handleImage($img) {
            let src = $img.attr('src');
            if (!src || src.trim() === '') {
                $img.attr('src', '{{asset("userfiles/noimage.jpg")}}');
            }
            $img.on('error', function() {
                $img.attr('src', '{{asset("userfiles/noimage.jpg")}}');
            });
        }

        function processImages(selector) {
            const $related = $(selector);
            if ($related.length) {
                const $images = $related.find('a img');
                $images.each(function() {
                    handleImage($(this));
                });
            }
        }

        $(document).ready(function() {
            processImages('body');

            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                        $(mutation.addedNodes).find('img').each(function() {
                            handleImage($(this));
                        });
                    }
                });
            });

            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        });
    </script>

</body>

</html>
