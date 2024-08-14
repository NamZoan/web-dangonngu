@section('content')
    <!-- breadcrumbs  -->

    <div class="grid-x grid-container">
        <div aria-label="You are here:" role="navigation">
            <ul class="breadcrumbs">
                <li><a href="{{ route('web_home') }}">{{ GetTranslation(trans('breadcrumb.home')) }}</a></li>
                <li class="disabled">{{ $information->name }}</li>
            </ul>
        </div>
    </div>
    <div class="grid-container grid-x grid-margin-x align-center">
        <div class="title-4 title-col">
            <h1>{{ GetTranslation($information->name) }}</h1>
        </div>
        <div class="grid-y grid-margin-y" style="margin: 0 1rem;">
            {!! $information->description !!}
        </div>
    </div>
    <!-- Thank You Message -->
@endsection
