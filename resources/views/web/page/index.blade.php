@section('css')
    <style>
        :root {
            --width: 30%;
            --gap: 0.5rem;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .carousel .container {
            position: relative;
            height: 21.875rem;
            overflow: hidden;
        }

        .carousel .slider {
            height: 100%;
        }

        .slider-track {
            position: relative;
            left: calc(-56% - var(--gap) * 2);
            height: inherit;
            display: flex;
            gap: var(--gap);
            list-style-type: none;
            transition: transform 0.8s;

            & .item {
                min-width: var(--width);
                background-position: center;
                background-size: cover;
            }
        }

        @media (width < 1000px) {
            .slider-track {
                left: calc(-99% - var(--gap) * 2);

                & .item {
                    min-width: 50%;
                }
            }
        }

        @media (width < 700px) {
            .slider-track {
                left: calc(-190% - var(--gap) * 2);

                & .item {
                    min-width: 100%;
                }
            }
        }

        .item {
            position: relative;
            overflow: hidden;
        }

        .item a {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-decoration: none;
        }

        .item h3 {
            margin: 0;
            padding: 0.625rem;
            color: #fff;
            z-index: 5;
        }

        .item h3:hover {
            text-decoration: underline;
        }

        /* dropdown end */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .carousel .container {
            position: relative;
            height: 21.875rem;
            overflow: hidden;
        }

        .carousel .slider {
            height: 100%;
        }

        .slider-track {
            position: relative;
            left: calc(-56% - var(--gap) * 2);
            height: inherit;
            display: flex;
            gap: var(--gap);
            list-style-type: none;
            transition: transform 0.8s;

            & .item {
                min-width: var(--width);
                background-position: center;
                background-size: cover;
            }
        }

        .slider .slider-track .item a::before {
            content: '';
            background-color: rgba(0, 0, 0, .3);
            position: absolute;
            left: 0;
            top: 0;
            right: 0;
            bottom: 0;
            z-index: 2;
        }

        .slider .slider-track li a {
            height: 100%;
            width: 100%;
        }

        @media (width < 1000px) {
            .slider-track {
                left: calc(-99% - var(--gap) * 2);

                & .item {
                    min-width: 50%;
                }
            }
        }

        @media (width < 700px) {
            .slider-track {
                left: calc(-190% - var(--gap) * 2);

                & .item {
                    min-width: 100%;
                }
            }
        }

        .featured-article img {
            width: 100%;
            height: 12.5rem;
            object-fit: cover;
        }

        .featured-article p.des {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .featured-article .callout {
            height: 100%;
        }

        .featured-article .thumnail {
            width: 100%;
            height: 12.5rem;
        }

        .many_images img {
            width: 100%;
            height: 17rem;
            object-fit: cover;
            padding: 1rem;
            border: none;
        }
    </style>
@endsection
@section('content')
    <div class="grid-x">
        <div class="orbit cell" role="region" aria-label="Favorite Space Pictures" data-orbit data-use-m-u-i="true">
            <ul class="orbit-container">
                <button class="orbit-previous" aria-label="previous"><span class="show-for-sr">Previous
                        Slide</span>&#9664;</button>
                <button class="orbit-next" aria-label="next"><span class="show-for-sr">Next Slide</span>&#9654;</button>
                @foreach ($getSlides as $slide)
                    <li class="orbit-slide">
                        <img class="orbit-image" src="{{ asset($slide) }}" alt="Space">
                        <!-- <figcaption class="orbit-caption">Lets Rocket!</figcaption> -->
                    </li>
                @endforeach
            </ul>
            <div class="orbit-bullets">
                @for ($i = 0; $i < count($getSlides); $i++)
                    <button class="{{ $i == 0 ? 'is-active' : '' }}" data-slide="{{ $i }}"><span
                            class="show-for-sr"></span></button>
                @endfor
            </div>
        </div>
    </div>
    <div class="cell text-center">
        <p style="text-align: center;">{!! GetTranslation(trans('home.description_slide')) !!}</p>
    </div>

    <!-- test  -->

    <div class="carousel cell">
        <hr>
        <div class='container'>
            <div class='slider'>
                <ul class='slider-track'>
                    @foreach ($getPostCategories as $category)
                        <li class='item' style='background-image:url("{{ asset($category->image) }}")'>
                            <a class="cell grid-y grid-margin-y align-center text-center"
                                href="{{ route('web_list_post', $category->slug, true, app()->getLocale()) }}">
                                <h3>{{ GetTranslation($category->name) }}</h3>
                            </a>
                        </li>
                    @endforeach
                    @foreach ($getPostCategories as $category)
                        <li class='item' style='background-image:url("{{ asset($category->image) }}")'>
                            <a class="cell grid-y grid-margin-y align-center text-center"
                                href="{{ route('web_list_post', $category->slug, true, app()->getLocale()) }}">
                                <h3>{{ GetTranslation($category->name) }}</h3>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <button class="orbit-previous prev" aria-label="previous"><span class="show-for-sr"></span>&#9664;</button>
            <button class="orbit-next next" aria-label="next"><span class="show-for-sr"></span>&#9654;</button>
        </div>
    </div>
    <!-- end test  -->

    <div class="column text-center">
        <hr>
        <h2>{{ GetTranslation(trans('home.heading_post')) }}</h2>
    </div>

    <div class="featured-article grid-x grid-margin-x small-up-1 medium-up-2 large-up-4">
        @foreach ($featuredArticle as $item)
            <div class="cell">
                <div class="grid-y grid-margin-y callout">
                    <a class="grid-y thumnail"
                        href="{{ route('web_post_detail', $item->slug, true, app()->getLocale()) }}"><img
                            src="{{ $item->image }}" alt="{{ GetTranslation($item->meta_title) }}"></a>
                    <a class="grid-x cell text-center" style="flex:1"
                        href="{{ route('web_post_detail', $item->slug, true, app()->getLocale()) }}">
                        <p class="lead name">{{ GetTranslation($item->name) }}</p>
                    </a>
                    <p class="des subheader text-justify">
                        
                        {{ GetTranslation($item->meta_description) }}</p>
                </div>
            </div>
        @endforeach


    </div>

    <hr>

    <div class="row column text-center">
        <h2>{{ GetTranslation(trans('home.heading_image')) }}</h2>
        <hr>
    </div>

    <div class="many_images grid-x small-up-2 medium-up-3 large-up-4">
        @foreach ($getImages as $key => $image)
            <a class="cell" href="{{ asset($image) }}" data-fancybox="gallery"
                data-caption="Hình ảnh {{ $key }}">
                <img class="thumbnail" src="{{ asset($image) }}" />
            </a>
        @endforeach
    </div>


    <br>

    <link rel="stylesheet" href="{{ asset('js/fancybox/fancybox.min.css') }}" />
    <script src="{{ asset('js/fancybox/fancybox.min.js') }}"></script>
    <script>
        Fancybox.bind("[data-fancybox]", {
            // Your custom options
        });
    </script>
@endsection
