@section('css')
    <style>
        .payment h6 {
            font-weight: bold;
            font-size: 24px;
        }

        .multi-step-checkout-form-divider {
            margin: 0.9375rem;
        }
    </style>
@endsection
@section('content')
    <div class="cell grid-container">
        <div class="grid-x grid-container">
            <div aria-label="You are here:" role="navigation">
                <ul class="breadcrumbs">
                    <li><a href="{{ route('web_home') }}">{{ GetTranslation(trans('breadcrumb.home')) }}</a></li>
                </ul>
            </div>
        </div>
    </div>
    <hr>
    {!! html()->form('POST', route('web_handle_checkout'))->class('validasi')->attributes(['data-abide novalidate'])->open() !!}
    <div class="payment cell grid-x">
        @if (session('error'))
            <div data-abide-error class="alert callout">
                <p><i class="fi-alert"></i>{{ session('error') }}</p>
            </div>
        @endif

        <div class="multi-step-product-step-subheader cell">
            <h6 class="multi-step-product-step-subheader">{{ GetTranslation(trans('checkout.order')) }}</h6>

            <table class="order-table-content">
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
                    @foreach ($cartItems as $item)
                        <tr class="text-center" data-id="{{ $item->rowId }}">
                            <td><img class="order-product-image" src="{{ $item->options['image'] }}">
                            </td>
                            <td><span>{{ $item->options['name'][app()->getLocale()] }}</span>
                                <ul class="order-product-info">
                                    <li> {{ GetTranslation(trans('cart.code')) }}:{{ $item->id }}</li>
                                </ul>
                            </td>
                            <td>
                                <span>{{ $item->qty }}</span>
                            </td>
                            <td><span
                                    class="order-product-price">{{ number_format($item->options['price'][app()->getLocale()]) }}
                                    {{ $item->options['unit'][app()->getLocale()] }}</span><br class="hide-for-small-only">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <br>
        </div>
        <div class="cell small-12 medium-8 large-8">
            <div class="shipping-address multi-step-checkout-step-section">
                <h6 class="multi-step-checkout-step-subheader">{{ GetTranslation(trans('checkout.information')) }}</h6>

                <div class="cell grid-x grid-padding-x small-up-1 large-up-2 medium-up-2">
                    <div class="cell form-item">
                        <label>{{ GetTranslation(trans('checkout.first_name')) }}
                            <input type="text" placeholder="" name="firstName" required>
                            <span class="form-error">Trường này là bắt buộc.</span>
                        </label>
                    </div>
                    <div class=" cell form-item">
                        <label>{{ GetTranslation(trans('checkout.last_name')) }}
                            <input type="text" placeholder="" name="lastName" required>
                            <span class="form-error">Trường này là bắt buộc.</span>

                        </label>
                    </div>
                </div>
                <div>
                    <hr class="multi-step-checkout-form-divider">
                </div>
                <div class="cell grid-x grid-padding-x">
                    <div class="small-12 medium-4 large-4 cell form-item">
                        <label>{{ GetTranslation(trans('checkout.country')) }}
                            <select id="country" name="country" class="form-control" required>
                            </select>
                            <span class="form-error" data-form-error-on="required">Trường này là bắt buộc.</span>
                        </label>
                    </div>
                    <div class="small-12 medium-4 large-4 cell form-item">
                        <label>{{ GetTranslation(trans('checkout.state')) }}
                            <select name="state" id="state" class="form-control" required>
                            </select>
                            <span class="form-error">Trường này là bắt buộc.</span>
                        </label>
                    </div>
                    <div class="small-12 medium-4 large-4 cell form-item">
                        <label>{{ GetTranslation(trans('checkout.city')) }}
                            <select name="city" id="city" class="form-control" required>
                            </select>
                            <span class="form-error">Trường này là bắt buộc.</span>
                        </label>
                    </div>
                    <div class=" cell small-12 medium-8 large-10 form-item">
                        <label>{{ GetTranslation(trans('checkout.address')) }}
                            <input type="text" placeholder="" name="address" required>
                            <span class="form-error" data-form-error-on="required">Trường này là bắt buộc.</span>
                        </label>
                    </div>
                    <div class="small-6 medium-4 large-2 cell form-item">
                        <label>ZIP
                            <input type="number" placeholder="ZIP" name="zipCode" required pattern="number">
                            <span class="form-error" data-form-error-on="required">Trường này là bắt buộc.</span>
                            <span class="form-error" data-form-error-on="pattern">Mã ZIP phải là số.</span>
                        </label>
                    </div>
                </div>
                <div>
                    <hr class="multi-step-checkout-form-divider">
                </div>
                <div class="cell grid-x grid-padding-x small-up-1 large-up-2 medium-up-2">
                    <div class="cell grid-y grid-margin-y align-center form-item" style="margin-top: 1rem 0;">
                        <label>Email
                        </label>

                        <input type="email" placeholder="" name="email" required pattern="email"
                            style="margin: 1rem 0;">
                        <span class="form-error" data-form-error-on="required" style="margin:0">Trường này là bắt
                            buộc.</span>
                        <span class="form-error" data-form-error-on="pattern" style="margin:0">Email không hợp lệ.</span>
                    </div>
                    <br>
                    <div class=" cell grid-y grid-margin-y align-center form-item" style="margin: 1rem 0;">
                        <label>{{ GetTranslation(trans('checkout.phone')) }}
                        </label>

                        <input class="cell" type="tel" placeholder="" name="phone" id="phone">
                        <span class="form-error" id="message-phone"></span>
                    </div>

                </div>

                <div class="cell grid-x grid-padding-x" style="margin-top:2rem">
                    <div class=" cell">
                        <label>{{ GetTranslation(trans('checkout.mess')) }}
                            <textarea name="description" placeholder="{{ GetTranslation(trans('checkout.mess')) }}" cols="30" rows="10"></textarea>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="cell grid-container small-12 medium-4 large-4">
            <div class="multi-step-checkout-shipping-options multi-step-checkout-step-section">
                {{-- check payment  --}}
                @if ($status_payment->value == 1)
                    <h6 class="multi-step-checkout-step-subheader">{{ GetTranslation(trans('checkout.method_payment')) }}</h6>
                    <div class="row multi-step-checkout-shipping-option">
                        <label>
                            <div class="small-10 cell">
                                <input type="radio" id="payment" name="method_payment" value="bank"
                                    class="multi-step-checkout-shipping-option-selection" checked="checked">
                                <span
                                    class="multi-step-checkout-shipping-option-title">{{ GetTranslation(trans('checkout.bank_transfer')) }}</span>
                                <div class="multi-step-checkout-shipping-option-desc">
                                    {{ GetTranslation(trans('checkout.des_bank_transfer')) }}
                                </div>
                            </div>
                            <div class="small-2 cell multi-step-checkout-shipping-cost">
                                {{ number_format($totalVND) }} ₫
                            </div>
                        </label>
                    </div>
                    <div class="row multi-step-checkout-shipping-option">
                        <label>
                            <div class="small-10 cell">
                                <input type="radio" id="payment" name="method_payment" value="paypal"
                                    class="multi-step-checkout-shipping-option-selection"><span
                                    class="multi-step-checkout-shipping-option-title">PayPal</span>
                                <div class="multi-step-checkout-shipping-option-desc">{{ GetTranslation(trans('checkout.des_paypal')) }}
                                </div>
                            </div>
                            <div class="small-2 cell multi-step-checkout-shipping-cost">
                                {{ number_format($totalUSD) }} $
                            </div>
                        </label>
                    </div>
                    <button type="submit" class="primary button expanded">{{ GetTranslation(trans('checkout.button')) }}</button>
                @else
                    <br>
                    <div class="cell multi-step-checkout-shipping-option" style="margin:2rem 0">
                        <label>
                            <div class="small-10 cell">

                                <div class="multi-step-checkout-shipping-option-desc">
                                    {{ GetTranslation(trans('checkout.mess_nonpayment')) }}
                                </div>
                            </div>
                            <div class="small-2 cell multi-step-checkout-shipping-cost" style="margin:1rem 0">
                                {{ number_format($totalVND) }} ₫
                            </div>
                        </label>
                    </div>
                    <input type="hidden" name ="method_payment" value="none">
                    <button type="submit" class="primary button expanded">{{ GetTranslation(trans('checkout.order')) }}</button>
                @endif
                {{-- end  --}}
            </div>

        </div>
    </div>
    {!! html()->form()->close() !!}
@endsection

@section('js')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.10/build/css/intlTelInput.css">
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.10/build/js/intlTelInput.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const phoneInputField = document.querySelector("#phone");
            const countryDropdown = document.querySelector("#country");
            const stateDropdown = document.querySelector("#state");
            const cityDropdown = document.querySelector("#city");

            const iti = window.intlTelInput(phoneInputField, {
                initialCountry: "auto",
                hiddenInput: function(telInputName) {
                    return {
                        phone: "phone_full",
                        country: "country_code"
                    };
                },
                geoIpLookup: callback => {
                    fetch("https://ipinfo.io/json?token=78094255b17a7a")
                        .then(res => res.json())
                        .then(data => {
                            countryDropdown.value = data.country;
                            callback(data.country);
                        })
                        .catch(() => callback("{{ app()->getLocale() }}"));
                },
                utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@23.0.10/build/js/utils.js",
            });



            // Populate country dropdown
            const countryData = intlTelInput.getCountryData();
            for (let i = 0; i < countryData.length; i++) {
                const country = countryData[i];
                const optionNode = document.createElement("option");
                optionNode.value = country.name;
                optionNode.setAttribute('data-val', country.iso2);
                phoneInputField.addEventListener('countrychange', () => {
                    const CountryIp = iti.getSelectedCountryData().iso2;
                    if (CountryIp == country.iso2) {
                        optionNode.selected = true;
                        loadStates(countryDropdown.options[countryDropdown.selectedIndex].getAttribute(
                            'data-val'));
                    }
                });
                const textNode = document.createTextNode(country.name);
                optionNode.appendChild(textNode);
                countryDropdown.appendChild(optionNode);
            }


            // Event listener for country change
            countryDropdown.addEventListener('change', () => {
                iti.setCountry(countryDropdown.options[countryDropdown.selectedIndex].getAttribute(
                    'data-val'));
                loadStates(countryDropdown.options[countryDropdown.selectedIndex].getAttribute('data-val'));
            });

            // Event listener for state change
            stateDropdown.addEventListener('change', () => {
                loadCities(countryDropdown.options[countryDropdown.selectedIndex].getAttribute('data-val'),
                    stateDropdown.options[stateDropdown.selectedIndex].getAttribute('data-val'));
            });
            // Function to load states
            function loadStates(countryCode) {
                stateDropdown.innerHTML = '';
                cityDropdown.innerHTML = '';

                fetch(
                        `https://api.countrystatecity.in/v1/countries/${countryCode}/states`, {
                            method: 'GET',
                            headers: {
                                'X-CSCAPI-KEY': 'NUxDOVpHM3dHdnBTdWVzOGNxQTRrc0NwV2pmUWxNdnFXQlJsMkxteQ=='
                            }
                        }
                    )
                    .then(response => response.json())
                    .then(data => {
                        const states = data;
                        if (Array.isArray(states) && states.length > 0) {
                            states.forEach(state => {
                                const optionNode = document.createElement("option");
                                optionNode.value = state.name;
                                optionNode.setAttribute('data-val', state.iso2);
                                const textNode = document.createTextNode(state.name);
                                optionNode.appendChild(textNode);
                                stateDropdown.appendChild(optionNode);
                            });
                        } else {
                            const optionNode = document.createElement("option");
                            optionNode.value = 'N/A';
                            optionNode.setAttribute('data-val', 'N/A');
                            const textNode = document.createTextNode('N/A');
                            optionNode.appendChild(textNode);
                            stateDropdown.appendChild(optionNode);
                        }
                        loadCities(countryCode,
                            stateDropdown.options[stateDropdown.selectedIndex].getAttribute('data-val'));
                    })
                    .catch(error => console.error('Error fetching states:', error));



            }

            // Function to load cities
            function loadCities(countryCode, stateCode) {
                cityDropdown.innerHTML = '';

                fetch(
                        `https://api.countrystatecity.in/v1/countries/${countryCode}/states/${stateCode}/cities`, {
                            method: 'GET',
                            headers: {
                                'X-CSCAPI-KEY': 'NUxDOVpHM3dHdnBTdWVzOGNxQTRrc0NwV2pmUWxNdnFXQlJsMkxteQ=='
                            }
                        }
                    )
                    .then(response => response.json())
                    .then(data => {
                        const cities = data;
                        if (Array.isArray(cities) && cities.length > 0) {
                            cities.forEach(city => {
                                const optionNode = document.createElement("option");
                                optionNode.value = city.name;
                                const textNode = document.createTextNode(city.name);
                                optionNode.appendChild(textNode);
                                cityDropdown.appendChild(optionNode);
                            });
                        } else {
                            const optionNode = document.createElement("option");
                            optionNode.value = 'N/A';
                            const textNode = document.createTextNode('N/A');
                            optionNode.appendChild(textNode);
                            cityDropdown.appendChild(optionNode);
                        }
                    })
                    .catch(error => console.error('Error fetching cities:', error));
            }

            // function checkZipcode(countryCode, stateCode, cityName, zipcode) {
            //     fetch(`https://api.zippopotam.us/${countryCode}/${stateCode}/${zipcode}`)
            //         .then(response => {
            //             if (response.ok) {
            //                 return true;
            //             } else {
            //                 return false;
            //             }
            //         })
            //         .then(data => {
            //             if (data) {
            //                 const cityFound = data.places.some(place => place['place name'].toLowerCase() ===
            //                     cityName.toLowerCase());
            //                 if (cityFound) {
            //                     return true;
            //                 } else {
            //                     return false;
            //                 }
            //             }
            //         })
            //         .catch();
            // }

            const form = document.querySelector("form");

            form.onsubmit = () => {
                if (!iti.isValidNumber()) {
                    document.querySelector("#message-phone").innerHTML =
                        "Invalid number. Please try again.";
                    document.querySelector("#message-phone").style = "display:block;margin:0";
                    return false;
                }


                // const check = checkZipcode(countryDropdown.options[countryDropdown.selectedIndex].getAttribute(
                //         'data-val'), stateDropdown.options[stateDropdown.selectedIndex].getAttribute(
                //         'data-val'),
                //     cityDropdown.options[cityDropdown.selectedIndex].value, form.zipCode.value);

                // console.log(check);

            };

            const phoneFullInput = document.querySelector('input[name="phone_full"]');
            const country_code = document.querySelector('input[name="country_code"]');


            $('#phone').on('blur', function() {
                phoneFullInput.value = iti.getNumber();
            });

            $('#country').on('change', function() {
                country_code.value = $('#country option:selected').attr('data-val');
            });
        });
    </script>
@endsection
