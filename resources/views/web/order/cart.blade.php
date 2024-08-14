@section('css')
    <style>
        .quantity-product .quantity {
            display: flex;
            border: 2px solid #3498db;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 100px;
        }

        .quantity-product .quantity button {
            background-color: #3498db;
            color: #fff;
            border: none;
            cursor: pointer;
            font-size: 20px;
            width: 30px;
            height: auto;
            text-align: center;
            transition: background-color 0.2s;
        }

        .quantity-product .quantity button:hover {
            background-color: #2980b9;
        }

        .quantity-product .input-box {
            width: 40px;
            text-align: center;
            border: none;
            padding: 8px 10px;
            font-size: 16px;
            outline: 0;
            margin-bottom: 0;
        }

        .quantity-product .input-box::-webkit-inner-spin-button,
        .quantity-product .input-box::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .quantity-product .input-box[type="number"] {
            -moz-appearance: textfield;
        }

        .box-1,
        .box-2 {
            transition: 0.4s ease;
            top: -8px;
        }

        .box-1 {
            left: 23px;
            transform: rotate(45deg);
        }

        .box-2 {
            left: 32px;
            transform: rotate(63deg);
        }

        @-webkit-keyframes grow {
            0% {
                -webkit-transform: scale(0);
            }

            50% {
                -webkit-transform: scale(1.2);
            }

            100% {
                -webkit-transform: scale(1);
            }
        }

        @keyframes grow {
            0% {
                transform: scale(0);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        @-webkit-keyframes drop {
            0% {
                -webkit-transform: translateY(0);
            }

            100% {
                -webkit-transform: translateY(1px);
            }
        }

        @keyframes drop {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(1px);
            }
        }

        .container {
            align-items: center;
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .price-product label,
        .quantity-product label {
            width: 100%;
            color: #0c3b61;
            font-size: 16px;
            font-weight: 700;
            text-align: left;
            line-height: 1.2;
            -webkit-text-stroke-width: 0;
            margin: 10px auto;
        }

        .quantity-product span {
            font-size: 18px;
            font-weight: 700;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .box-price {
            min-width: 150px;
            height: 39px;
            border: 1px solid #ebebeb;
            background-color: #ebebeb;
            border-radius: 4px;
            display: flex;
            justify-content: center;
        }

        span.price {
            color: #0c3b61;
            font-size: 18px;
            font-weight: 700;
            margin: auto;
        }

        .product-filters {
            padding: 0.5rem 1.5rem;
            background-color: #fefefe;
        }

        .product-filters label {
            color: var(----color);
        }

        .product-filters .menu>li>a {
            padding-left: 0;
            font-size: 0.9rem;
            font-weight: 800;
        }

        .product-filters-header {
            font-size: 1.25rem;
            padding-top: 0.5rem;
        }

        .order-table-content tr td,
        th {
            padding: 10px;
            text-align: center;
            border: 1px solid #ebebeb;
        }

        .order-table-content tr svg {
            cursor: pointer;
        }

        .order-product-price,
        .order-product-total {
            color: #0c3b61;
            font-size: 18px;
            font-weight: bold;
            margin: auto;
        }

        .checkout p {
            margin: auto;
        }

        .price-label {
            font-size: 20px;
            font-weight: bold;
            text-align: left;
        }

        .price {
            color: #0c3b61;
            font-size: 18px;
            font-weight: bold;
            margin: auto;
        }

        .js-cd-cart {
            display: none;
        }

        .content {
            min-height: 60vh;
        }
    </style>
@endsection
@section('content')
    <div class="cell grid-container">
        <div class="grid-x grid-container">
            <div aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs">
                    <li><a href="{{ route('web_home') }}">{{ GetTranslation(trans('breadcrumb.home')) }}</a></li>
                    <li class="disabled">{{GetTranslation(trans('cart.name')) }}</li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="content grid-y grid-margin-y align-center">

    </div>

@endsection

@section('js')
    <script>
        $(document).ready(function() {
            show_cart_list();
        });

        $(document).on('ready', function() {
            $(document).on('click', '#delete-item', function() {
                var rowId = $(this).closest('tr').data('id');
                console.log(rowId);
                updateCart(rowId, 'delete');
            });

            $(document).on('click', '.plus', function() {
                var rowId = $(this).closest('tr').data('id');
                var qty = $(this).siblings('.input-box').val();
                qty++;
                updateCart(rowId, 'update', qty);
            });

            $(document).on('click', '.minus', function() {
                var rowId = $(this).closest('tr').data('id');
                var qty = $(this).siblings('.input-box').val();
                if (qty > 1) {
                    qty--;
                    updateCart(rowId, 'update', qty);
                }
            });

            $(document).on('change', '.input-box', function() {
                var rowId = $(this).closest('tr').data('id');
                var qty = $(this).val();
                updateCart(rowId, 'update', qty);
            });
        });

        async function show_cart_list() {
            try {
                var response = await getCartItems();
                var items = Object.values(response.cartData);
                if (items.length == 0) {
                    // empty cart message
                    $('.cart').empty();
                    $('.checkout').empty();
                    var content = `
                    <div class="cart-empty">
            <div class="container">
                <div class="grid-y align-center">
                    <div class="cell grid-x grid-margin-x large-6 align-center">
                        <svg fill="#000000" height="10rem" width="10rem" version="1.1" id="Capa_1"
                            xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                            viewBox="0 0 231.523 231.523" xml:space="preserve">
                            <g>
                                <path
                                    d="M107.415,145.798c0.399,3.858,3.656,6.73,7.451,6.73c0.258,0,0.518-0.013,0.78-0.04c4.12-0.426,7.115-4.111,6.689-8.231
                      l-3.459-33.468c-0.426-4.12-4.113-7.111-8.231-6.689c-4.12,0.426-7.115,4.111-6.689,8.231L107.415,145.798z" />
                                <path d="M154.351,152.488c0.262,0.027,0.522,0.04,0.78,0.04c3.796,0,7.052-2.872,7.451-6.73l3.458-33.468
                      c0.426-4.121-2.569-7.806-6.689-8.231c-4.123-0.421-7.806,2.57-8.232,6.689l-3.458,33.468
                      C147.235,148.377,150.23,152.062,154.351,152.488z" />
                                <path d="M96.278,185.088c-12.801,0-23.215,10.414-23.215,23.215c0,12.804,10.414,23.221,23.215,23.221
                      c12.801,0,23.216-10.417,23.216-23.221C119.494,195.502,109.079,185.088,96.278,185.088z M96.278,216.523
                      c-4.53,0-8.215-3.688-8.215-8.221c0-4.53,3.685-8.215,8.215-8.215c4.53,0,8.216,3.685,8.216,8.215
                      C104.494,212.835,100.808,216.523,96.278,216.523z" />
                                <path d="M173.719,185.088c-12.801,0-23.216,10.414-23.216,23.215c0,12.804,10.414,23.221,23.216,23.221
                      c12.802,0,23.218-10.417,23.218-23.221C196.937,195.502,186.521,185.088,173.719,185.088z M173.719,216.523
                      c-4.53,0-8.216-3.688-8.216-8.221c0-4.53,3.686-8.215,8.216-8.215c4.531,0,8.218,3.685,8.218,8.215
                      C181.937,212.835,178.251,216.523,173.719,216.523z" />
                                <path d="M218.58,79.08c-1.42-1.837-3.611-2.913-5.933-2.913H63.152l-6.278-24.141c-0.86-3.305-3.844-5.612-7.259-5.612H18.876
                      c-4.142,0-7.5,3.358-7.5,7.5s3.358,7.5,7.5,7.5h24.94l6.227,23.946c0.031,0.134,0.066,0.267,0.104,0.398l23.157,89.046
                      c0.86,3.305,3.844,5.612,7.259,5.612h108.874c3.415,0,6.399-2.307,7.259-5.612l23.21-89.25C220.49,83.309,220,80.918,218.58,79.08z
                      M183.638,165.418H86.362l-19.309-74.25h135.895L183.638,165.418z" />
                                <path
                                    d="M105.556,52.851c1.464,1.463,3.383,2.195,5.302,2.195c1.92,0,3.84-0.733,5.305-2.198c2.928-2.93,2.927-7.679-0.003-10.607
                      L92.573,18.665c-2.93-2.928-7.678-2.927-10.607,0.002c-2.928,2.93-2.927,7.679,0.002,10.607L105.556,52.851z" />
                                <path d="M159.174,55.045c1.92,0,3.841-0.733,5.306-2.199l23.552-23.573c2.928-2.93,2.925-7.679-0.005-10.606
                      c-2.93-2.928-7.679-2.925-10.606,0.005l-23.552,23.573c-2.928,2.93-2.925,7.679,0.005,10.607
                      C155.338,54.314,157.256,55.045,159.174,55.045z" />
                                <path
                                    d="M135.006,48.311c0.001,0,0.001,0,0.002,0c4.141,0,7.499-3.357,7.5-7.498l0.008-33.311c0.001-4.142-3.356-7.501-7.498-7.502
                      c-0.001,0-0.001,0-0.001,0c-4.142,0-7.5,3.357-7.501,7.498l-0.008,33.311C127.507,44.951,130.864,48.31,135.006,48.311z" />
                            </g>
                        </svg>
                    </div>
                    <p class="text-center margin-10">{{ GetTranslation(trans('cart.empty')) }}</p>
                    <a href="{{ route('web_home') }}" class="submit success button">{{ GetTranslation(trans('breadcrumb.home')) }}</a>
                </div>
            </div>
        </div>
                    `;
                    $('.content').html(content);

                } else {
                    var content = `
                    <div class="cart cell">
        <hr class="show-for-small-only order-table-divider">
        <table class="order-table-content stack">
            <thead>
                <tr>
                    <th width="120" class="text-center">{{ GetTranslation(trans('cart.product')) }}</th>
                    <th width="350" class="text-center">{{ GetTranslation(trans('cart.information')) }}</th>
                    <th width="80" class="text-center">{{ GetTranslation(trans('cart.quantity')) }}</th>
                    <th width="100" class="text-center">{{ GetTranslation(trans('cart.price')) }}</th>
                    <th width="5" class="text-center"></th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div class="checkout cell grid-x">
        <hr class="cell">
        <div class="cell large-6"></div>
        <div class="cell grid-x large-6">
            <div class="cell price grid-x align-center large-3">
                <p class="price-label">{{ GetTranslation(trans('cart.total_price')) }}: </p>
            </div>
            <div class="cell price grid-x align-center large-3">
                <p class="price">0</p>
            </div>
            <div class="cell grid-x button-group align-center large-6" style="margin: auto;">
                <a href="{{ route('payment.web.checkout') }}" class="button cell">{{ GetTranslation(trans('cart.checkout')) }}</a>
            </div>
        </div>
    </div>
                    `;
                    $(".content").html(content);
                    var products = '';
                    if (items.length > 0) {
                        items.forEach(item => {
                            var productAdded =
                                '<tr class="order-item" data-id="' + item.rowId + '">' +
                                '<td><img class="order-product-image" src="' + item.image + '" /></td>' +
                                '<td><a href="' + item.url + '"><span class="order-product-title">' + item
                                .name +
                                '</span></a>' +
                                '<ul class="order-product-info"><li> ' + '{{ GetTranslation(trans('cart.code')) }}' + ':' +
                                item
                                .code +
                                '</li></ul></td>' +
                                '<td><div class="quantity-product grid-x align-center"><div class="quantity">' +
                                '<button class="minus" aria-label="Decrease">&minus;</button><input type="number" class="input-box" value="' +
                                item.qty + '" min="1" max="100">' +
                                '<button class="plus" aria-label="Increase">&plus;</button></div></div></td>' +
                                '<td><span class="order-product-price">' + formatter.format(item.price) +
                                '</span><br class="hide-for-small-only"></td>' +
                                '<td><a href="javascript:;" id="delete-item"><svg width="20px" height="20px" viewBox="0 0 24 24" fill="none"' +
                                'xmlns="http://www.w3.org/2000/svg" stroke="#fa3200"><g id="SVGRepo_bgCarrier" stroke-width="0" />' +
                                '<g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" /><g id="SVGRepo_iconCarrier">' +
                                '<g clip-path="url(#clip0_429_11083)"><path d="M7 7.00006L17 17.0001M7 17.0001L17 7.00006" stroke="#fa3200" stroke-width="2.5"' +
                                'stroke-linecap="round" stroke-linejoin="round" /></g><defs><clipPath id="clip0_429_11083"><rect width="24" height="24" fill="white" />' +
                                '</clipPath></defs></g></svg></a></td></tr>'
                            products += productAdded;
                        });
                        $('.order-table-content tbody').html(products);
                        $('.checkout p.price').html(formatter.format(response.totalPrice));
                    }
                }
            } catch (error) {
                console.error('Error fetching cart items:', error);

            }
        }

        function updateCart(rowId, status, qty = null) {
            $.ajax({
                url: "{{ route('update_cart') }}",
                type: 'POST',
                data: {
                    rowId: rowId,
                    status: status,
                    qty: qty
                },
                success: function(data) {
                    if (data.status == 200) {
                        show_cart_list();
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 419) {
                        console.log('Phiên làm việc của bạn đã hết hạn, vui lòng tải lại trang và thử lại.');
                    } else {
                        console.log('Đã xảy ra lỗi, vui lòng thử lại.');
                    }
                }

            })
        }
    </script>
@endsection
