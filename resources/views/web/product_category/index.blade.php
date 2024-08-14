@section('css')
    <style>
        .breadcrumbs li {
            font-size: 12px !important;
        }

        .products h2 a {
            font-size: 20px;
        }

        .product-filters {
            padding: 0.5rem 1.5rem;
            background-color: #fefefe;
            border-bottom: 1px solid #e6e6e6;
        }

        .product-filters label {
            color: var(----color);
        }

        .product-filters .menu.nested {
            margin-left: 0rem;
            margin-bottom: 0.9rem;
        }

        .product-filters .menu>li>a {
            padding-left: 0;
            font-size: 0.9rem;
            font-weight: 800;
        }

        .product-filters .is-accordion-submenu-parent>a::after {
            border-color: #cacaca transparent transparent;
        }

        .product-filters .clear-all {
            font-size: 0.9rem;
            color: #cacaca;
        }

        .product-filters .more {
            color: #1779ba;
            font-size: 0.9rem;
            cursor: pointer;
        }

        .product-filters-header {
            font-size: 1.25rem;
            padding-top: 0.5rem;
        }

        .product-filters-tab {
            border-top: 1px solid #e6e6e6;
        }

        .product-filters-tab:last-child() {
            border-bottom: 1px solid #e6e6e6;
        }

        .product-card {
            background-color: #fefefe;
            border: 1px solid #e6e6e6;
            padding: 1rem;
            margin-bottom: 1.5rem;
            height: 100%;
        }

        .product-card-thumbnail {
            display: block;
            position: relative;
        }

        .product-card-title {
            font-size: 0.9rem;
            font-weight: 600;
            line-height: 1.45rem;
            margin-top: 1rem;
            margin-bottom: 0;
            flex: 1 !important;
        }

        .product-card-desc {
            color: #8a8a8a;
            display: block;
            font-size: 0.85rem;
            display: -webkit-box;
            -webkit-line-clamp: 4;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-card-price {
            color: #3e3e3e;
            display: inline-block;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .product-card-sale {
            color: #cacaca;
            display: inline-block;
            font-size: 0.85rem;
            margin-left: 0.3rem;
            text-decoration: line-through;
        }

        .product-card-colors {
            display: block;
            margin-top: 0.8rem;
        }

        .product-card-color-option {
            display: inline-block;
            height: 25px;
            width: 25px;
        }

        :root {
            --range-bar-color: hsl(0, 0%, 0%, 20%);
            --range-progress-bar-color: #1779ba;
            --range-thumb-color: var(--range-progress-bar-color);
        }

        .sliders_control {
            position: relative;
            min-height: 50px;
        }

        .numbers {
            display: flex;
            margin-bottom: 10px;
            justify-content: space-between;
        }

        .range-container {
            display: flex;
            flex-direction: column;
            position: relative;

            input[type="range"] {
                --left-per: 0%;
                --right-per: 100%;

                position: absolute;
                -webkit-appearance: none;
                appearance: none;
                width: 100%;
                margin: 0;
                padding: 0;
                background: transparent;
                outline: none;
                pointer-events: none;
            }

            input[type="range"]::-webkit-slider-runnable-track {
                opacity: 1;
                height: 0.5rem;
                border: none;
                box-shadow: none;
                border-radius: 9999px;
            }

            input[type="range"].left-range::-webkit-slider-runnable-track {
                background: linear-gradient(90deg,
                        var(--range-bar-color) var(--left-per),
                        var(--range-progress-bar-color) var(--left-per),
                        var(--range-progress-bar-color) var(--right-per),
                        var(--range-bar-color) var(--right-per));
            }

            input[type="range"]::-webkit-slider-thumb {
                -webkit-appearance: none;
                /* Override default look */
                appearance: none;
                margin-top: -8px;
                /* Centers thumb on the track */
                background-color: var(--range-thumb-color);
                height: 24px;
                width: 24px;
                pointer-events: all;
                border-radius: 1rem;
                outline: 5px solid white;
                outline-offset: -20px;
                box-shadow: 0 0 10px var(--range-thumb-color);
                cursor: pointer;
            }
        }

        #range-two {
            --range-progress-bar-color: hsl(250, 35%, 50%);
            --range-thumb-color: var(--range-progress-bar-color);
        }

        #range-three,
        #range-four,
        #range-five {
            --range-progress-bar-color: hsl(320, 35%, 50%);
            --range-thumb-color: var(--range-progress-bar-color);
        }

        .info {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            max-width: 40ch;
            margin: 0 auto;
            padding: 1rem;
            border: 3px solid hsl(0, 70%, 60%);
            border-radius: 1rem;
            outline: 2px solid hsl(0, 30%, 60%);
            outline-offset: -8px;
        }

        .info>div {
            display: grid;
            grid-template-columns: 15ch 1fr;
        }

        #info-size-range {
            display: grid;
            grid-template-rows: 3ch1fr;
        }

        #info-size-range>div {
            display: grid;
            grid-template-columns: 3ch 1fr;
        }


        .price-item svg {
            margin: auto;
        }

        .price-item {
            margin-top: 0.5rem;
        }

        .product-card-price {
            font-size: 1rem;
        }

        .product-card img {
            width: 100%;
            height: 12.5rem;
            object-fit: cover;
        }

        .add-to-cart-button {
            background: #3498DB;
            border: none;
            border-radius: 4px;
            -webkit-box-shadow: 0 3px 13px -2px rgba(0, 0, 0, .15);
            box-shadow: 0 3px 13px -2px rgba(0, 0, 0, .15);
            color: #fff;
            display: flex;
            font-family: 'Ubuntu', sans-serif;
            justify-content: space-around;
            min-width: 60px;
            height: 40px;
            overflow: hidden;
            outline: none;
            padding: 0.7rem;
            position: relative;
            text-transform: uppercase;
            transition: 0.4s ease;
            width: auto;
        }

        .add-to-cart-button:active {
            -webkit-transform: translateY(4px);
            transform: translateY(4px);
        }

        .add-to-cart-button:hover {
            cursor: pointer;
        }

        .add-to-cart-button:hover,
        .add-to-cart-button:focus {
            -webkit-transform: translateY(-1px);
            transform: translateY(-1px);
        }

        .add-to-cart-button.added {
            background: #2fbf30;
        }

        .add-to-cart-button.added .add-to-cart {
            display: none;
        }

        .add-to-cart-button.added .added-to-cart {
            display: block;
        }

        .add-to-cart-button.added .cart-icon {
            animation: drop 0.3s forwards;
            -webkit-animation: drop 0.3s forwards;
            animation-delay: 0.18s;
        }

        .add-to-cart-button.added .box-1,
        .add-to-cart-button.added .box-2 {
            top: 18px;
        }

        .add-to-cart-button.added .tick {
            animation: grow 0.6s forwards;
            -webkit-animation: grow 0.6s forwards;
            animation-delay: 0.7s;
        }

        .add-to-cart,
        .added-to-cart {
            margin-left: 36px;
        }

        .added-to-cart {
            display: none;
            position: relative;
        }

        .add-to-cart-box {
            height: 5px;
            position: absolute;
            top: 0;
            width: 5px;
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

        .cart-icon {
            left: 15px;
            position: absolute;
            top: 8px;
        }

        .tick {
            background: #146230;
            border-radius: 50%;
            position: absolute;
            left: 28px;
            transform: scale(0);
            top: 5px;
            z-index: 2;
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
                -webkit-transform: translateY(0px);
            }

            100% {
                -webkit-transform: translateY(1px);
            }
        }

        @keyframes drop {
            0% {
                transform: translateY(0px);
            }

            100% {
                transform: translateY(1px);
            }
        }
    </style>
@endsection
@section('content')
    <div class="cell grid-container">
        <div class="grid-x grid-container">
            <div aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs">
                    <li><a href="{{ route('web_home') }}">{{ GetTranslation(trans('breadcrumb.home')) }}</a></li>
                    <li class="disabled">{{ GetTranslation($category->name) }}</li>
                </ul>
            </div>
        </div>
    </div>
    <hr>

    <div class="grid-x content" id="content">
        <div class="product-filters small-12 medium-4 large-3" data-sticky-container>
            <div class="sticky" id="right-content" data-sticky data-margin-top="4" data-top-anchor="content:top"
                data-btm-anchor="end-content:bottom" data-sticky-on="large">
                <h1 class="product-filters-header ">{{ GetTranslation(trans('product_category.categories')) }}</h1>
                <ul class="vertical menu " data-accordion-menu>
                    <li class="product-filters-tab">
                        <ul class="categories-menu menu vertical nested is-active">
                            @foreach ($categories as $item)
                                <li><a href="{{ route('web_list_product', $item->slug) }}">{{ GetTranslation($item->name) }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="grid-x product-filters-tab">
                        <div id="range-one" class="cell range-container">
                            <div class="numbers">
                                <div class="start">
                                    <span>0</span>{{ GetTranslation(trans('product_category.unit_price')) }}
                                </div>
                                <div class="end">
                                    <span>{{ number_format(trans('product_category.max_price'), 0) }}</span>{{ GetTranslation(trans('product_category.unit_price')) }}
                                </div>
                            </div>
                            <div class="sliders_control">
                                <input type="range" class="duel-range left-range" min="0"
                                    max="{{ GetTranslation(trans('product_category.max_price')) }}" value="0" step="1" />
                                <input type="range" class="duel-range right-range" min="0"
                                    max="{{ GetTranslation(trans('product_category.max_price')) }}"
                                    value="{{ GetTranslation(trans('product_category.max_price')) }}" step="1" />
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <div class="list-products medium-8 large-9 ">
            <div class="products grid-x grid-margin-x small-up-1 medium-up-2 large-up-3">
                @if (isset($products) && count($products) > 0)
                    @foreach ($products as $item)
                        <div class="cell grid-y grid-margin-y">
                            <div class="product-card grid-y">
                                <div class="product-card-thumbnail cell">
                                    <a class="cell grid-x align-center"
                                        href="{{ route('web_product_detail', $item->slug) }}"><img
                                            src="{{ asset($item->image) }}" /></a>
                                </div>
                                <h2 class="product-card-title text-center cell"><a
                                        href="{{ route('web_product_detail', $item->slug) }}">{{ GetTranslation($item->name) }}</a></h2>
                                <span class="product-card-desc text-left cell">{{ GetTranslation($item->meta_description) }}</span>
                                <div class="price-item cell grid-x align-justify">
                                    <div class="align-left grid-y grid-margin-y align-center">
                                        <span
                                            class="product-card-price">{{ GetTranslation(trans('product_category.unit_price')) }}{{ number_format($item->price, 0) }}
                                        </span>
                                    </div>
                                    <div class="align-right grid-x align-center">
                                        <a class="grid-y align-center add-to-cart-button" href="javascript:;" data-tooltip
                                            class="top" data-click-open="false" tabindex="2"
                                            title="{{ GetTranslation(trans('cart.add_to_cart')) }}"
                                            onclick="add_to_cart({{ $item->id }},1)">
                                            <svg class="add-to-cart-box box-1" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect width="24" height="24" rx="2" fill="#ffffff" />
                                            </svg>
                                            <svg class="add-to-cart-box box-2" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect width="24" height="24" rx="2" fill="#ffffff" />
                                            </svg>
                                            <svg class="cart-icon" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <circle cx="9" cy="21" r="1"></circle>
                                                <circle cx="20" cy="21" r="1"></circle>
                                                <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6">
                                                </path>
                                            </svg>
                                            <svg class="tick" xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" viewBox="0 0 24 24">
                                                <path fill="none" d="M0 0h24v24H0V0z" />
                                                <path fill="#ffffff"
                                                    d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM9.29 16.29L5.7 12.7c-.39-.39-.39-1.02 0-1.41.39-.39 1.02-.39 1.41 0L10 14.17l6.88-6.88c.39-.39 1.02-.39 1.41 0 .39.39.39 1.02 0 1.41l-7.59 7.59c-.38.39-1.02.39-1.41 0z" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="cell">{{ GetTranslation(trans('product.empty')) }}</p>
                @endif
            </div>

            <!-- pagination  -->
            <div class="cell pagination">
                <br id="end-content">
                <ul class="pagination margin-bottom-2 grid-x align-right" role="navigation" aria-label="Pagination">
                    {{ $products->links('web.layouts.assets.pagination') }}

                </ul>
            </div>
            <!-- End Pagination -->
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(window).on('load resize', function() {
            var windowWidth = $(window).width();
            if (windowWidth < 768) {
                $('#right-content').foundation('_destroy');
            }
        });

        function getProducts(filter) {
            $.ajax({
                url: "{{ route('web.products') }}",
                type: 'POST',
                data: {
                    slug: "{{ $category->slug }}",
                    locale: '{{ app()->getLocale() }}',
                    filter: filter,
                    _token: "{{ csrf_token() }}" // Thêm CSRF token vào yêu cầu
                },
                success: function(response) {
                    renderProducts(response);
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

        function renderProducts(products) {
            var productsContainer = $('.products');
            productsContainer.empty();

            if (products.length > 0) {
                products.forEach(function(item) {
                    var productHTML = `
            <div class="cell grid-y grid-margin-y">
                <div class="product-card grid-y">
                    <div class="product-card-thumbnail cell">
                        <a class="cell grid-x align-center" href="${item.url}">
                            <img src="${item.image}" />
                        </a>
                    </div>
                    <h2 class="product-card-title text-center cell">
                        <a href="${item.url}">${GetTranslation(item.name)}</a>
                    </h2>
                    <span class="product-card-desc text-left cell">${item.meta_description}</span>
                    <div class="price-item cell grid-x align-justify">
                        <div class="align-left grid-y grid-margin-y align-center">
                            <span class="product-card-price">{{ GetTranslation(trans('product_category.unit_price')) }}${new Intl.NumberFormat().format(item.price)}</span>
                        </div>
                        <div class="align-right grid-x align-center">
                            <a class="grid-y align-center add-to-cart-button" href="javascript:;" title="{{ GetTranslation(trans('cart.add_to_cart')) }}" onclick="add_to_cart(${item.id},1)">
                                <svg class="add-to-cart-box box-1" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="24" height="24" rx="2" fill="#ffffff" />
                                </svg>
                                <svg class="add-to-cart-box box-2" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="24" height="24" rx="2" fill="#ffffff" />
                                </svg>
                                <svg class="cart-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="9" cy="21" r="1"></circle>
                                    <circle cx="20" cy="21" r="1"></circle>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                </svg>
                                <svg class="tick" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="none" d="M0 0h24v24H0V0z"></path>
                                    <path fill="#ffffff" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM9.29 16.29L5.7 12.7c-.39-.39-.39-1.02 0-1.41.39-.39 1.02-.39 1.41 0L10 14.17l6.88-6.88c.39-.39 1.02-.39 1.41 0 .39.39.39 1.02 0 1.41l-7.59 7.59c-.38.39-1.02.39-1.41 0z"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `;
                    productsContainer.append(productHTML);
                });

            } else {
                let empty = "<p class='cell' >Không có sản phẩm nào</p>"
                productsContainer.append(empty);
            }

        }


        let isDragging = false;

        const ranges = [...document.querySelectorAll(".duel-range")];
        const leftInput = document.querySelector(".left");
        const rightInput = document.querySelector(".right");

        const priceRange = document.querySelector("#info-price-range");

        ranges.forEach(range => {
            range.addEventListener("mousemove", e => {
                if (isDragging) {
                    updateRange(e);
                }
            });
            range.addEventListener("touchmove", e => {
                if (isDragging) {
                    updateRange(e);
                }
            });

            range.addEventListener("mousedown", () => {
                isDragging = true;
            });
            range.addEventListener("touchstart", () => {
                isDragging = true;
            });

            range.addEventListener("mouseup", () => {
                isDragging = false;
                const filter = getFilterFromRange(range);
                getProducts(filter);
            });
            range.addEventListener("touchend", () => {
                isDragging = false;
                const filter = getFilterFromRange(range);
                getProducts(filter);
            });
        });

        function updateRange(e) {
            const isLeft = e.target.classList.contains("left-range");
            const parent = e.target.parentNode;
            var leftPos;
            var rightPos;

            if (isLeft) {
                leftPos = e.target;
                rightPos = parent.querySelector(".right-range");

                if (parseFloat(leftPos.value) > parseFloat(rightPos.value)) {
                    e.target.value = parseFloat(rightPos.value)
                }
            } else {
                leftPos = parent.querySelector(".left-range");
                rightPos = e.target;

                if (parseFloat(rightPos.value) < parseFloat(leftPos.value)) {
                    e.target.value = parseFloat(leftPos.value);
                };
            }

            const leftPer = (Math.round(leftPos.value) / parseFloat(leftPos.max)) * 100;
            const rightPer = (Math.round(rightPos.value) / parseFloat(rightPos.max)) * 100;
            leftPos.style.setProperty("--left-per", `${leftPer}%`);
            leftPos.style.setProperty("--right-per", `${rightPer}%`);

            updateDualSliderValue(Math.round(leftPos.value), Math.round(rightPos.value), parent.parentNode);
        }

        function updateDualSliderValue(left, right, element) {
            console.log(left, right);

            let min = left.toLocaleString('en-US', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 2
            });
            let max = right.toLocaleString('en-US', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 2
            });
            element.querySelector(".start > span").innerText = min;
            element.querySelector(".end > span").innerText = max;
        }

        function getFilterFromRange(range) {
            const parent = range.parentNode;
            const leftPos = parent.querySelector(".left-range");
            const rightPos = parent.querySelector(".right-range");

            return {
                "minPrice": Math.round(leftPos.value),
                "maxPrice": Math.round(rightPos.value)
            };
        }


        $(document).ready(function() {
            $(document).on("click", ".add-to-cart-button", function() {
                $(this).addClass("added");
                setTimeout(function() {
                    $(this).removeClass("added");
                }.bind(this), 2000);
            });
        });
    </script>
@endsection
