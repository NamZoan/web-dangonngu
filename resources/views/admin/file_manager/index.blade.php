@section('content')
    @include('ckfinder::setup')
    <div class="row">
        <iframe src="{{route ('ckfinder_browser')}}" class="col-md-12 col-sm-12" frameborder="0" style="height: 90vh"></iframe>
    </div>

@endsection
