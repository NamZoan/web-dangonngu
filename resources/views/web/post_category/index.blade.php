@section('css')
    <style>
        .featured-article img {
            width: 100%;
            height: 12.5rem;
            object-fit: cover;

        }

        .post_des {
            display: -webkit-box;
            -webkit-line-clamp: 5;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endsection
@section('content')
    <!-- breadcrumbs  -->
    <div class="grid-x grid-container">
        <div aria-label="You are here:" role="navigation">
            <ul class="breadcrumbs">
                <li><a href="{{ route('web_home') }}">{{ GetTranslation(trans('breadcrumb.home')) }}</a></li>
                <li class="disabled">{{ GetTranslation($category->name) }}</li>
            </ul>
        </div>
    </div>
    <hr>
    <div class="grid-x grid-margin-x" id="content">
        <div class="cell large-8 medium-8 small-12" style="border-right: 1px solid #E3E5E8;">
            @foreach ($posts as $post)
                <div class="grid-x grid-margin-x">
                    <div class="cell large-6 small-12">
                        <a href="{{ route('web_post_detail', $post->slug) }}" class="grid-x align-center">
                            <p><img src="{{ asset($post->image) }}" alt="image for article"></p>
                    </div>
                    <div class="cell large-6 item-list-post">
                        <h5><a href="{{ route('web_post_detail', $post->slug) }}"
                                class="cell grid-x text-left">{{ GetTranslation($post->name) }}</a></h5>
                        <p class="text-left item-post">
                            <span><svg width="15px" height="15px" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M3 9H21M7 3V5M17 3V5M6 12H8M11 12H13M16 12H18M6 15H8M11 15H13M16 15H18M6 18H8M11 18H13M16 18H18M6.2 21H17.8C18.9201 21 19.4802 21 19.908 20.782C20.2843 20.5903 20.5903 20.2843 20.782 19.908C21 19.4802 21 18.9201 21 17.8V8.2C21 7.07989 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V17.8C3 18.9201 3 19.4802 3.21799 19.908C3.40973 20.2843 3.71569 20.5903 4.09202 20.782C4.51984 21 5.07989 21 6.2 21Z"
                                        stroke="#000000" stroke-width="2" stroke-linecap="round" />
                                </svg> {{ $post->updated_at->format('d/m/y') }} &nbsp;&nbsp;</span>
                            <span>
                                <?xml version="1.0" encoding="utf-8"?>
                                <svg fill="#000000" width="14px" height="14px" viewBox="0 0 32 32" version="1.1"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M16.108 10.044c-3.313 0-6 2.687-6 6s2.687 6 6 6 6-2.686 6-6-2.686-6-6-6zM16.108 20.044c-2.206 0-4.046-1.838-4.046-4.044s1.794-4 4-4c2.206 0 4 1.794 4 4s-1.748 4.044-3.954 4.044zM31.99 15.768c-0.012-0.050-0.006-0.104-0.021-0.153-0.006-0.021-0.020-0.033-0.027-0.051-0.011-0.028-0.008-0.062-0.023-0.089-2.909-6.66-9.177-10.492-15.857-10.492s-13.074 3.826-15.984 10.486c-0.012 0.028-0.010 0.057-0.021 0.089-0.007 0.020-0.021 0.030-0.028 0.049-0.015 0.050-0.009 0.103-0.019 0.154-0.018 0.090-0.035 0.178-0.035 0.269s0.017 0.177 0.035 0.268c0.010 0.050 0.003 0.105 0.019 0.152 0.006 0.023 0.021 0.032 0.028 0.052 0.010 0.027 0.008 0.061 0.021 0.089 2.91 6.658 9.242 10.428 15.922 10.428s13.011-3.762 15.92-10.422c0.015-0.029 0.012-0.058 0.023-0.090 0.007-0.017 0.020-0.030 0.026-0.050 0.015-0.049 0.011-0.102 0.021-0.154 0.018-0.090 0.034-0.177 0.034-0.27 0-0.088-0.017-0.175-0.035-0.266zM16 25.019c-5.665 0-11.242-2.986-13.982-8.99 2.714-5.983 8.365-9.047 14.044-9.047 5.678 0 11.203 3.067 13.918 9.053-2.713 5.982-8.301 8.984-13.981 8.984z">
                                    </path>
                                </svg>
                                {{ $post->view }}
                            </span>
                        </p>
                        <p class="text-left post_des">{{ GetTranslation($post->meta_description) }}</p>
                    </div>
                </div>
            @endforeach
            <hr id="end-content">
            <ul class="pagination margin-bottom-2" role="navigation" aria-label="Pagination">
                {{ $posts->links('web.layouts.assets.pagination') }}
            </ul>

        </div>
        <div class="cell large-4 medium-4" data-sticky-container>
            <div class="sticky" data-sticky data-margin-top="4" data-top-anchor="content:top" id='right-content'
                data-btm-anchor="end-content:bottom">
                <h4>{{ GetTranslation(trans('post_category.list_of_articles')) }}</h4>
                <ul>
                    @foreach ($categories as $category)
                        <li><a href="{{ route('web_list_post', $category->slug) }}">{{ GetTranslation($category->name) }}</a></li>
                    @endforeach
                </ul>
                <hr>

                <div class="grid-x featured-article">
                    <p class="lead">{{ GetTranslation(trans('post_category.featured_article')) }}</p>
                    @foreach ($featuredArticle as $item)
                        <div class="media-object cell grid-y">
                            <div class="media-object-section">
                                <a href="{{ route('web_post_detail', $item->slug) }}"><img class="thumbnail"
                                        src="{{ asset($item->image) }}"></a>
                            </div>
                            <div class="media-object-section">
                                <p><a href="{{ route('web_post_detail', $item->slug) }}">{{ GetTranslation($item->name) }}</a>
                                </p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
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
    </script>
@endsection
