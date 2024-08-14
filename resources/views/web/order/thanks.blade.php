@section('content')
    <!-- breadcrumbs  -->

    <div class="grid-x grid-container">
        <div aria-label="You are here:" role="navigation">
            <ul class="breadcrumbs">
                <li><a href="{{ route('web_home') }}">{{ GetTranslation(trans('breadcrumb.home')) }}</a></li>
            </ul>
        </div>
    </div>
    <div class="grid-x grid-margin-x align-center">
        <div class="grid-y grid-margin-y" style="margin: 0 1rem;">
            {!! $data !!}
        </div>
    </div>
    <!-- Thank You Message -->
@endsection
