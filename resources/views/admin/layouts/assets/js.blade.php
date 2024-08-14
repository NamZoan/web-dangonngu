@isset($js)
    <script src="{{ asset('admin/assets/js/jquery-3.7.1.min.js') }}"></script>
    @foreach ($js as $key => $value)
        <script src="{{ asset($value) }}"></script>
    @endforeach
@endisset
