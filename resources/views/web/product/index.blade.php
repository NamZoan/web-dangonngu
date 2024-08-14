@section('css')
    <style>
        .quantity-product .quantity {
            display: flex;
            border: 2px solid #3498db;
            border-radius: 4px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
            outline: none;
            margin-bottom: 0;
        }

        /* Hide the number input spin buttons */
        .quantity-product .input-box::-webkit-inner-spin-button,
        .quantity-product .input-box::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .quantity-product .input-box[type="number"] {
            -moz-appearance: textfield;
        }

        /* button add to card  */

        .add-to-cart-button {
            background: #3498db;
            border: none;
            border-radius: 4px;
            -webkit-box-shadow: 0 3px 13px -2px rgba(0, 0, 0, 0.15);
            box-shadow: 0 3px 13px -2px rgba(0, 0, 0, 0.15);
            color: #fff;
            display: flex;
            font-family: "Ubuntu", sans-serif;
            justify-content: space-around;
            overflow: hidden;
            outline: none;
            padding: 0.7rem;
            position: relative;
            text-transform: uppercase;
            transition: 0.4s ease;
            width: auto;
        }

        .add-to-cart-button:active {
            -webkit-box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.45);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.45);
            -webkit-transform: translateY(4px);
            transform: translateY(4px);
        }

        .add-to-cart-button:hover {
            cursor: pointer;
        }

        .add-to-cart-button:hover,
        .add-to-cart-button:focus {
            -webkit-box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.45);
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.45);
            -webkit-transform: translateY(-1px);
            transform: translateY(-1px);
        }

        .add-to-cart-button.added {
            background: #2fbf30;
            -webkit-box-shadow: 0 0 0 0.2rem rgba(11, 252, 3, 0.45);
            box-shadow: 0 0 0 0.2rem rgba(11, 252, 3, 0.45);
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

        /* Page style */
        .container {
            align-items: center;
            display: flex;
            justify-content: center;
            width: 100%;
        }

        .quantity-product label,
        .price-product label {
            width: 100%;
            color: #0c3b61;
            font-size: 16px;
            font-weight: bold;
            text-align: left;
            line-height: 1.2;
            -webkit-text-stroke-width: 0px;
            margin: 10px auto;
        }

        .quantity-product span {
            font-size: 18px;
            font-weight: bold;
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
            font-weight: bold;
            margin: auto 1rem;
        }

        .products h2 a {
            font-size: 20px;
        }

        .product-filters {
            padding: 0.5rem 1.5rem;
            background-color: #fefefe;
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
            /* color: var(--link_a_color); */
            font-size: 0.9rem;
            font-weight: 800;
        }

        /* .product-filters .menu > li > a:hover{
                                                                                                                          padding-left: 0;
                                                                                                                          color: #27476E;
                                                                                                                          font-size: 0.99rem;
                                                                                                                        } */

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
        }

        .summary {
            position: relative;
        }

        .des-summary {
            color: #595959;
            display: -webkit-box;
            -webkit-line-clamp: 10;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            position: relative;
        }

        .des-summary::after {
            content: '.....................';
            position: absolute;
            right: 0;
            bottom: 0;
            background: white;
            padding-left: 5px;
        }


        .product-card-desc {
            color: #8a8a8a;
            display: block;
            font-size: 0.85rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .product-card-price {
            color: #3e3e3e;
            display: inline-block;
            font-size: 0.85rem;
            font-weight: 600;
            margin-top: 0.8rem;
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

        .product_image .image {
            border: 4px solid #fefefe;
            border-radius: 0;
            -webkit-box-shadow: 0 0 0 1px rgba(10, 10, 10, 0.2);
            box-shadow: 0 0 0 1px rgba(10, 10, 10, 0.2);
        }

        a.read-more {
            position: absolute;
            bottom: 0;
            right: 0;
            margin-bottom: 2px;
            padding: 0;
            color: #14679e;
            background: #ffffff;
            font-size: 16px;
        }
    </style>
@endsection
@section('content')
    <div class="cell grid-container">
        <div class="grid-x grid-container">
            <div aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs">
                    <li><a href="{{ route('web_home') }}">{{ GetTranslation(trans('breadcrumb.home')) }}</a></li>
                    <li><a href="{{ route('web_list_product', $category->slug) }}">{{ GetTranslation($category->name) }}</a></li>
                    <li class="disabled">{{ GetTranslation($product->name) }}</li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    <div class="cell grid-container">
        <div class="grid-x grid-container">
            <h3>{{ GetTranslation($product->name) }}</h3>
        </div>
    </div>
    <hr>

    <div class="grid-x grid-margin-x">

        <div class="medium-6 cell">
            <div class="product_image grid-x grid-padding-x small-up-4">
                <div>
                    <div class="f-carousel" id="myCarousel">
                        <div class="f-carousel__slide cell grid-y grid-margin-y align-center"
                            data-thumb-src="{{ asset($product->image) }}">
                            <a class="cell grid-y grid-margin-y align-center" href="{{ asset($product->image) }}"
                                data-fancybox="{{ $product->name }}"><img width="640" height="480" alt=""
                                    data-lazy-src="{{ asset($product->image) }}" /></a>
                        </div>
                        @foreach (json_decode($product->multiple_image) as $key => $image)
                            <div class="f-carousel__slide cell grid-y grid-margin-y align-center"
                                data-thumb-src="{{ asset($image) }}">
                                <a class="cell grid-y grid-margin-y align-center" href="{{ asset($image) }}"
                                    data-fancybox="{{ $product->name }}"><img width="640" height="480" alt=""
                                        data-lazy-src="{{ asset($image) }}" /></a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>


        </div>
        <div class="medium-6 large-5 cell large-offset-1">
            <br>
            <h4>{{ GetTranslation(trans('product.information')) }}</h4>
            <br>
            <div class="summary">
                <div class="des-summary">
                    {!! $product->summary !!}
                </div>
                <a class="button read-more" data-open="exampleModal1">{{ GetTranslation(trans('product.see')) }}</a>

            </div>
            <div class="tiny reveal large" id="exampleModal1" data-reveal>
                <br>
                <h4>{{ GetTranslation(trans('product.information')) }}</h4>
                <br>
                <button class="close-button" data-close aria-label="Close modal" type="button">
                    <span aria-hidden="true">&times;</span>
                </button>
                {!! $product->summary !!}
            </div>
            <hr>
            <div class="cell grid-x secondary expanded button-group" style="justify-content: space-around;">

                <div class="quantity-product grid-y align-center">
                    <label for="">{{ GetTranslation(trans('product.quantity')) }}</label>

                    <div class="quantity">
                        <button class="minus" aria-label="Decrease">&minus;</button>
                        <input type="number" class="input-box" id="quantity" value="1" min="1" max="10">
                        <button class="plus" aria-label="Increase">&plus;</button>
                    </div>
                </div>
                <div class="price-product">
                    <label for="">{{ GetTranslation(trans('product.price')) }}</label>
                    <div class="cell box-price">
                        <span class="price">{{ $product->price }} {{ $product->unit }}</span>
                    </div>
                </div>
            </div>
            <br>
            <div class="cell grid-x secondary expanded button-group small-up-1">
                <button class="cell add-to-cart-button"
                    onclick="add_to_cart({{ $product->id }},document.getElementById('quantity').value)">
                    <svg class="add-to-cart-box box-1" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <rect width="24" height="24" rx="2" fill="#ffffff" />
                    </svg>
                    <svg class="add-to-cart-box box-2" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <rect width="24" height="24" rx="2" fill="#ffffff" />
                    </svg>
                    <svg class="cart-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <circle cx="9" cy="21" r="1"></circle>
                        <circle cx="20" cy="21" r="1"></circle>
                        <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                    </svg>
                    <svg class="tick" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24">
                        <path fill="none" d="M0 0h24v24H0V0z" />
                        <path fill="#ffffff"
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM9.29 16.29L5.7 12.7c-.39-.39-.39-1.02 0-1.41.39-.39 1.02-.39 1.41 0L10 14.17l6.88-6.88c.39-.39 1.02-.39 1.41 0 .39.39.39 1.02 0 1.41l-7.59 7.59c-.38.39-1.02.39-1.41 0z" />
                    </svg>
                    <span class="add-to-cart">{{ GetTranslation(trans('product.add_to_cart')) }}</span>
                    <span class="added-to-cart">{{ GetTranslation(trans('product.cart_added_successfully')) }}</span>
                </button>
            </div>
            @if ($product->link_affiliate)
                <div class="cell grid-x secondary expanded button-group">
                    <a href="{{ $product->link_affiliate }}" class="button cell">{{ GetTranslation(trans('product.affiliate')) }}</a>
                </div>
            @endif

        </div>

        <div class="cell pro_desc_img" id="pro_desc_img">
            <br>
            <h4>{{ GetTranslation(trans('product.product_description')) }}</h4>
            <br>
            {!! $product->description !!}
        </div>

        <div class="list-products cell ">
            <hr>
            <div class="column text-center">
                <h2>{{ GetTranslation(trans('product.related_products')) }}</h2>
            </div>
            <div class="products grid-x grid-margin-x small-up-2 medium-up-2 large-up-4">
                @foreach ($relatedProducts as $item)
                    <div class="product-card cell">
                        <div class="product-card-thumbnail">
                            <a class="cell grid-x align-center"
                                href="{{ route('web_product_detail', $item->slug) }}"><img
                                    src="{{ asset($item->image) }}"></a>
                        </div>
                        <h2 class="product-card-title text-center"><a
                                href="{{ route('web_product_detail', $item->slug) }}">{{ GetTranslation($item->name) }}</a></h2>
                        <span class="product-card-desc text-center">{{ GetTranslation($item->meta_description) }}</span>
                        <span class="product-card-price">{{ $item->price }} {{ $item->unit }}</span>
                    </div>
                @endforeach

            </div>

        </div>
    </div>
@endsection
@section('js')
    <link rel="stylesheet" href="{{ asset('js/fancybox/fancybox.min.css') }}" />
    <script src="{{ asset('js/fancybox/fancybox.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/carousel/carousel.umd.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/carousel/carousel.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/carousel/carousel.thumbs.css" />
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/carousel/carousel.thumbs.umd.js"></script>
    <script>
        const container = document.getElementById("myCarousel");
        const options = {
            Thumbs: {
                type: "modern",
            },
        };

        new Carousel(container, options, {
            Thumbs
        });

        Fancybox.bind("[data-fancybox]", {
            // Your custom options
        });
    </script>
    <script>
        (function() {
            const quantityContainer = document.querySelector(".quantity");
            const minusBtn = quantityContainer.querySelector(".minus");
            const plusBtn = quantityContainer.querySelector(".plus");
            const inputBox = quantityContainer.querySelector(".input-box");

            updateButtonStates();

            quantityContainer.addEventListener("click", handleButtonClick);
            inputBox.addEventListener("input", handleQuantityChange);

            function updateButtonStates() {
                const value = parseInt(inputBox.value);
                minusBtn.disabled = value <= 1;
                plusBtn.disabled = value >= parseInt(inputBox.max);
            }

            function handleButtonClick(event) {
                if (event.target.classList.contains("minus")) {
                    decreaseValue();
                } else if (event.target.classList.contains("plus")) {
                    increaseValue();
                }
            }

            function decreaseValue() {
                let value = parseInt(inputBox.value);
                value = isNaN(value) ? 1 : Math.max(value - 1, 1);
                inputBox.value = value;
                updateButtonStates();
                handleQuantityChange();
            }

            function increaseValue() {
                let value = parseInt(inputBox.value);
                value = isNaN(value) ? 1 : Math.min(value + 1, parseInt(inputBox.max));
                inputBox.value = value;
                updateButtonStates();
                handleQuantityChange();
            }

            function handleQuantityChange() {
                let value = parseInt(inputBox.value);
                value = isNaN(value) ? 1 : value;

                // Execute your code here based on the updated quantity value
                console.log("Quantity changed:", value);
            }
        })();


        //   add to cart 

        addToCartButton = document.querySelectorAll(".add-to-cart-button");

        document.querySelectorAll('.add-to-cart-button').forEach(function(addToCartButton) {
            addToCartButton.addEventListener('click', function() {
                addToCartButton.classList.add('added');
                setTimeout(function() {
                    addToCartButton.classList.remove('added');
                }, 2000);
            });
        });
    </script>
@endsection
