@section('css')
    <script src="{{ asset('js/pusher/pusher.min.js') }}"></script>
    <script>
        let orderId = '{{ $order->transaction_code }}';
        var pusher = new Pusher('e60a9559084d6fc75eeb', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('payment.' + orderId);

        channel.bind('success', function(data) {

            if (data.status == 200) {
                window.location.href = "{{ route('payment.web.thanks', null, true, app()->getLocale()) }}";
            }

            if (data.status == 201) {
                window.location.href = "{{ route('payment.web.checkout', null, true, app()->getLocale()) }}";
            }
        });
    </script>
@endsection
@section('content')
    <div class="payment cell grid-x">
        @if (session('error'))
            <div data-abide-error class="alert callout">
                <p><i class="fi-alert"></i>{{ session('error') }}</p>
            </div>
        @endif

        <div class="cell small-12 medium-7 large-8">
            <div class="" id="countdown"></div>

            <h6>{{ GetTranslation(trans('checkout.information')) }}</h6>
            <ul>
                <li>{{ GetTranslation(trans('checkout.name')) }}: {{ $order->name }}</li>
                <li>Email: {{ $order->email }}</li>
                <li>{{ GetTranslation(trans('checkout.phone')) }}: {{ $order->phone }}</li>
                <li>{{ GetTranslation(trans('checkout.address')) }}: {{ $order->address }}</li>
                <li>{{ GetTranslation(trans('checkout.mess')) }}: {{ $order->message }}</li>
            </ul>
            <div class="multi-step-product-step-subheader cell">
                <h6 class="multi-step-product-step-subheader">{{ trans('checkout.order') }}</h6>

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
                        @foreach ($products as $item)
                            <tr class="text-center">
                                <td><img class="order-product-image" src="{{ $item['image'] }}">
                                </td>
                                <td><span>{{ $item['name'][app()->getLocale()] }}</span>
                                    <ul class="order-product-info">
                                        <li> {{ GetTranslation(trans('cart.code')) }}:{{ $item['code'] }}</li>
                                    </ul>
                                </td>
                                <td>
                                    <span>{{ $item['qty'] }}</span>
                                </td>
                                <td><span class="order-product-price">{{ number_format($item['price']) }}
                                        đ</span><br class="hide-for-small-only">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
            </div>
        </div>

        <div class="cell grid-container small-12 medium-5 large-4">
            <div class="multi-step-checkout-shipping-options multi-step-checkout-step-section">
                {{-- check payment  --}}
                <div class="row multi-step-checkout-shipping-option">
                    <label>
                        <div class="small-10 cell">
                            <img src="{{ $qr }}" alt="" srcset="">
                        </div>
                    </label>
                </div>
                <button type="submit" class="primary button expanded">{{ GetTranslation(trans('checkout.button')) }}</button>

                {{-- end  --}}
            </div>

        </div>
    </div>
@endsection
