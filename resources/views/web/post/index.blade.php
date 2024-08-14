@section('css')
    <style>
        .featured-article img {
            width: 100%;
            height: 12.5rem;
            object-fit: cover;

        }

        h2,
        h3,
        h4 {
            scroll-margin-top: 4rem;
        }

        html {
            scroll-behavior: smooth;
        }

        .post-card {
            margin: 10px;
        }

        .media-object {
            flex-direction: column;
        }

        .media-object .media-object-section img {
            width: 100%;
            height: auto;
        }

        #fixedButton {
            display: none;
            position: fixed;
            bottom: 50%;
            left: 0;
            cursor: pointer;
            opacity: 0.5;
        }

        #fixedButton:hover {
            opacity: 0.5;
        }

        #fixedButton:active {
            opacity: 2;
        }


        .table-of-contents-mobile {
            display: none;
        }

        .table-of-contents ul li {
            list-style-type: initial;
        }

        .table-of-contents-mobile ul li {
            list-style-type: initial;
        }

        @media only screen and (max-width: 768px) {
            #fixedButton {
                display: block;
            }

            .table-of-contents {
                display: none;
            }

            .table-of-contents-mobile.active {
                display: block;
                position: fixed;
                top: 10%;
                left: 0;
                width: 80%;
                background-color: #ebebeb;
                height: 600px;
                border-radius: 10px;
                border: 1px solid rgba(51, 51, 51, 0.95);
                z-index: 10000;
            }

            .table-of-contents-mobile.active .lead {
                display: block;
                color: #333;
                text-decoration: none;
            }

            .table-of-contents-mobile.active ul {
                margin: 10px 10px 10px 30px;
            }

            .table-of-contents-mobile .lead {
                margin-bottom: 0;
            }

            @keyframes fadeOut {
                0% {
                    opacity: 2.5;
                }

                75% {
                    opacity: 2;
                }

                50% {
                    opacity: 1.5;
                }

                25% {
                    opacity: 1;
                }

                100% {
                    opacity: 0.5;
                }
            }

            #fixedButton.clicked {
                animation: fadeOut 5s forwards;
            }

            .table-of-contents-mobile.active+.header,
            .table-of-contents-mobile.active+.main,
            .table-of-contents-mobile.active+.footer {
                opacity: 0.5;
                /* Điều chỉnh độ mờ tùy thích */
            }

            .table-of-contents-mobile .title-bar {
                background-color: #ebebeb;
                box-shadow: none;
                border-radius: 10px;
            }
        }

        .clear-fix {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            z-index: 9999;
        }

        .clear-fix.blurred {
            background-color: rgba(0, 0, 0, 0.5);
            display: block;
        }

        .post-related .post-card-desc {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .post-content {
            margin: 0;
            padding: 0.75rem;
            border-right: 1rem solid #EBEBEB;
        }

        @media only screen and (max-width: 768px) {
            .post-content {
                border: none !important;
                padding: 0rem;
            }
        }
    </style>
@endsection
@section('content')
    <div class="grid-x grid-container">
        <div aria-label="You are here:" role="navigation">
            <ul class="breadcrumbs">
                <li><a href="{{ route('web_home') }}">{{ GetTranslation(trans('breadcrumb.home')) }}</a></li>
                <li class="disabled">{{ GetTranslation($post->name) }}</li>
            </ul>
        </div>
    </div>
    <hr>

    <div class="grid-x grid-margin-x" id="content">
        <div class="cell large-9 medium-9 small-12 post-content ">
            <div class="new-article-content">
                <div class="title-4 title-col">
                    <h1>{{ GetTranslation($post->name) }}</h1>
                </div>
                {{-- description  --}}
                {!!GetTranslation($post->description) !!}
                {{-- description  --}}
                <br id="end-content">
            </div>
        </div>
        <div class="cell large-3 medium-3" data-sticky-container>
            <div class="sticky" id="right-content" data-sticky data-sticky-on="medium" data-margin-top="4"
                data-top-anchor="content:top" data-btm-anchor="end-content:bottom">
                <div class="table-of-contents active">
                    <p class="lead">{{ GetTranslation(trans('post.index')) }}</p>
                    {!! GetTranslation($post->summary) !!}
                </div>
                <hr>

                <div class="grid-x featured-article">
                    <p class="lead">{{ GetTranslation(trans('post.featured_article')) }}</p>
                    @foreach ($featuredArticle as $item)
                        <div class="media-object cell grid-y small-up-1">
                            <div class="cell media-object-section">
                                <a href="{{ route('web_post_detail', $item->slug) }}"><img class="thumbnail"
                                        src="{{ asset($item->image) }}"></a>
                            </div>
                            <div class="cell media-object-section">
                                <p><a href="{{ route('web_post_detail', $item->slug) }}">{{ GetTranslation($item->name) }}</a></p>
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>

        </div>
    </div>

    <div class="post-related">
        <div class="list-posts cell ">
            <hr>
            <div class="column text-center">
                <h2>{{ GetTranslation(trans('post.related_articles')) }}</h2>
            </div>
            <div class="posts grid-x grid-margin-x small-up-2 medium-up-3 large-up-4">
                @foreach ($relatedPosts as $item)
                    <div class="post-card cell callout">
                        <div class="post-card-thumbnail">
                            <a class="cell grid-x align-center" href="{{ route('web_post_detail', $item->slug) }}"><img
                                    src="{{ asset($item->image) }}"></a>
                        </div>
                        <h5 class="post-card-title"><a
                                href="{{ route('web_post_detail', $item->slug) }}">{{ GetTranslation($item->name) }}</a></h5>
                        <span class="post-card-desc">{{ GetTranslation($item->meta_description) }}</span>

                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div id="fixedButton"><svg width="40px" height="40px" viewBox="0 0 18 18" xmlns="http://www.w3.org/2000/svg"
            mirror-in-rtl="true">
            <path fill="#494c4e"
                d="M17 0H1a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V1a1 1 0 0 0-1-1zM3 16a1 1 0 0 1 0-2 1 1 0 0 1 0 2zm0-4a.945.945 0 0 1-1-1 .945.945 0 0 1 1-1 .945.945 0 0 1 1 1 .945.945 0 0 1-1 1zm0-4a.945.945 0 0 1-1-1 .945.945 0 0 1 1-1 .945.945 0 0 1 1 1 .945.945 0 0 1-1 1zm0-4a.945.945 0 0 1-1-1 .945.945 0 0 1 1-1 .945.945 0 0 1 1 1 .945.945 0 0 1-1 1zm12 12H7a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2zm0-4H7a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2zm0-4H7a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2zm0-4H7a1 1 0 0 1 0-2h8a1 1 0 0 1 0 2z" />
        </svg></div>
    <div class="clear-fix"></div>
    <div class="table-of-contents-mobile">
        <div class="title-bar">
            <div class="title-bar-left">
                <p class="lead"><svg fill="#000000" width="20px" height="15px" viewBox="0 0 52 52" data-name="Layer 1"
                        id="Layer_1" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M50,15.52H2a2,2,0,0,1-2-2V2A2,2,0,0,1,2,0H50a2,2,0,0,1,2,2V13.52A2,2,0,0,1,50,15.52Zm-46-4H48V4H4Z" />
                        <path
                            d="M50,33.76H2a2,2,0,0,1-2-2V20.24a2,2,0,0,1,2-2H50a2,2,0,0,1,2,2V31.76A2,2,0,0,1,50,33.76Zm-46-4H48V22.24H4Z" />
                        <path
                            d="M50,52H2a2,2,0,0,1-2-2V38.48a2,2,0,0,1,2-2H50a2,2,0,0,1,2,2V50A2,2,0,0,1,50,52ZM4,48H48V40.48H4Z" />
                    </svg>{{ GetTranslation(trans('post.related_articles')) }}</p>
            </div>
            <div class="title-bar-right">
                <svg id="close-table" width="20px" height="20px" viewBox="0 0 1024 1024"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill="#000000"
                        d="M195.2 195.2a64 64 0 0 1 90.496 0L512 421.504 738.304 195.2a64 64 0 0 1 90.496 90.496L602.496 512 828.8 738.304a64 64 0 0 1-90.496 90.496L512 602.496 285.696 828.8a64 64 0 0 1-90.496-90.496L421.504 512 195.2 285.696a64 64 0 0 1 0-90.496z" />
                </svg>
            </div>
        </div>
        {!! $post->summary !!}
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


        document.addEventListener("DOMContentLoaded", function() {
            var fixedButton = document.getElementById("fixedButton");
            var closeTable = document.getElementById("close-table");
            var tableOfContentsMobile = document.querySelector(".table-of-contents-mobile");
            var clear_fix = document.querySelector(".clear-fix");


            fixedButton.addEventListener("click", function() {
                fixedButton.classList.add("clicked");
                setTimeout(function() {
                    fixedButton.classList.remove("clicked");
                }, 5000);
            });
            fixedButton.addEventListener("click", function(event) {
                if (event.target === fixedButton || fixedButton.contains(event.target)) {
                    tableOfContentsMobile.classList.toggle("active");
                    clear_fix.classList.add("blurred");
                }
            });

            closeTable.addEventListener("click", function(event) {
                tableOfContentsMobile.classList.remove("active");
                clear_fix.classList.remove("blurred");
            });

            document.addEventListener("click", function(event) {
                if (!tableOfContentsMobile.contains(event.target) && event.target !== fixedButton && !
                    fixedButton.contains(event.target)) {
                    tableOfContentsMobile.classList.remove("active");
                    clear_fix.classList.remove("blurred");
                }
            });

            var linksInTableOfContents = tableOfContentsMobile.querySelectorAll("a");
            linksInTableOfContents.forEach(function(link) {
                link.addEventListener("click", function() {
                    tableOfContentsMobile.classList.remove("active");
                    clear_fix.classList.remove("blurred");
                });
            });
        });
    </script>
@endsection
