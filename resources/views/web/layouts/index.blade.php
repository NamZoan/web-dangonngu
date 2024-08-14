<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <style>
        html body {
            background-color: #eff1f5;
            background-image: url(https://1626-2405-4802-76f-b330-c526-f0b1-e26-8fa3.ngrok-free.app/userfiles/images/background.png);
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            height: 100vh;
            margin: 0;
        }
    </style>
    @include('web/layouts/assets/head')
    @yield('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">


    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-G0PP8HJP1E"></script>
    <style>
        @media (min-width: 80rem) {

            .cd-cart__trigger,
            .cd-cart__content {
                bottom: 40px;
            }
        }

        .cd-cart__trigger {
            z-index: 3;
            height: 72px;
            width: 72px;
            overflow: visible;
        }

        .cd-cart__trigger::after,
        .cd-cart__trigger::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translateY(-50%) translateX(-50%);
            -ms-transform: translateY(-50%) translateX(-50%);
            transform: translateY(-50%) translateX(-50%);
            height: 100%;
            width: 100%;
            background: url("{{ asset('web/cd-icons-cart-close.svg') }}") no-repeat 0 0;
            transition: opacity 0.2s, -webkit-transform 0.2s;
            transition: opacity 0.2s, transform 0.2s;
            transition: opacity 0.2s, transform 0.2s, -webkit-transform 0.2s;
        }

        .cd-cart__trigger::after {
            background-position: -72px 0;
            opacity: 0;
            -webkit-transform: translateX(-50%) translateY(-50%) rotate(90deg);
            -ms-transform: translateX(-50%) translateY(-50%) rotate(90deg);
            transform: translateX(-50%) translateY(-50%) rotate(90deg);
        }

        .cd-cart--open .cd-cart__trigger::before {
            opacity: 0;
        }

        .cd-cart--open .cd-cart__trigger::after {
            opacity: 1;
            -webkit-transform: translateX(-50%) translateY(-50%);
            -ms-transform: translateX(-50%) translateY(-50%);
            transform: translateX(-50%) translateY(-50%);
        }

        .cd-cart__trigger:hover+.cd-cart__content .cd-cart__layout {
            box-shadow: 0 6px 40px rgba(0, 0, 0, 0.3);
        }

        .cd-cart--open .cd-cart__trigger:hover+.cd-cart__content .cd-cart__layout {
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.17);
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/foundation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="{{ asset('js/fontawesome.min.js') }}" crossorigin="anonymous"></script>

</head>

<body>
    <!-- Start Top Bar -->

    @include('web.layouts.assets.header')


    <!-- End Top Bar -->


    <div class="main grid-container">
        <br>
        <!-- breadcrumbs  -->

        @yield('content')

    </div>


    @include('web.layouts.assets.footer')



    <script src="{{ asset('js/vendor/jquery.js') }}"></script>
    <script src="{{ asset('js/vendor/foundation.js') }}"></script>
    <script src="{{ asset('js/vendor/what-input.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        $(document).ready(function() {
            showCart();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.lang-selected').on('click', function(ev) {
                ev.preventDefault();
                $('.lang-selector').toggle();
            });
            $('.lang-selector li a').on('click', function(ev) {
                ev.preventDefault();
                var lang = $(this).text();
                $('.lang-selected').html(lang);
                $('.lang-selector').toggle();
            });


        });

        function getCartItems() {
            return new Promise((resolve, reject) => {
                $.ajax({
                    url: "{{ route('get_cart') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    data: {
                        locale: '{{ app()->getLocale() }}',
                    },
                    dataType: 'json',
                    success: function(response) {
                        resolve(response);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        reject(error);
                    }
                });
            });
        }


        async function showCart() {
            try {
                var response = await getCartItems();
                var items = Object.values(response.cartData);
                if (items.length == 0) {
                    $('.cd-cart__body ul').html('<li>{{GetTranslation(trans("cart.empty"))}}</li>');
                    $('.cd-cart__count').html('<li>0</li><li>0</li>');
                    return;
                } else {
                    var products = '';
                    items.forEach(item => {
                        var productAdded = '<li class="cd-cart__product">' +
                            '<div class="cd-cart__image">' +
                            '<a href="' + item.url + '"><img src="' + item.image +
                            '" alt="placeholder"></a>' +
                            '</div>' +
                            '<div class="cd-cart__details">' +
                            '<h3 class="truncate"><a href="' + item.url + '">' + GetTranslation(item.name) +
                            '</a></h3>' +
                            '<span class="cd-cart__price">' + formatter.format(item.price) +
                            '</span>' +
                            '<div class="cd-cart__actions">' +
                            '</div>' +
                            '</div>' +
                            '</li>';
                        products += productAdded;
                    });
                    $('.cd-cart__body ul').html(products);
                    var total = '<li>' + response.total + '</li><li>' + response.total + '</li>';
                    $('.cd-cart__count').html(total);
                }
            } catch (error) {
                console.error('Error fetching cart items:', error);
            }
        }


        function add_to_cart(id, qty = 1) {
            $.ajax({
                url: "{{ route('add_to_card') }}",
                type: 'POST',
                data: {
                    id: id,
                    qty: qty
                },
                success: function(data) {
                    if (data.status == 200) {
                        showCart();
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 419) {
                        location.reload();

                    } else {
                        alert('Đã xảy ra lỗi, vui lòng thử lại.');
                    }
                }
            });
        }

        (function() {
            const cartElement = document.querySelector('.js-cd-cart');
            if (cartElement) {
                cartElement.addEventListener('click', () => {
                    if (cartElement.classList.contains('cd-cart--open')) {
                        cartElement.classList.remove('cd-cart--open');
                    } else {
                        cartElement.classList.add('cd-cart--open');
                    }
                });
            }
        })();
    </script>

    @yield('js')

</body>


</html>
