<footer class="grid-container footer">
    <div class="container grid-x align-top">

        <div class="footer-col cell medium-4 large-4">
            <h4>{{ GetTranslation(trans('footer.help')) }}</h4>
            <ul>
                <li><a href="https://www.unicityscience.org" target="_blank">{{ GetTranslation(trans('footer.certify')) }} Unicity Science</a></li>
                @foreach ($information_global as $item)
                    @if ($item->view_footer == 1)
                        <li><a href="{{ route('web.information', [$item->slug]) }}">{{ GetTranslation($item->name) }}</a></li>
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="footer-col cell medium-4 large-4">
            <h4>{{ GetTranslation(trans('footer.products')) }}</h4>
            <ul>
                @foreach ($postCategories as $item)
                    <li><a href="{{ route('web_list_product', [$item->slug]) }}">{{ GetTranslation($item->name) }}</a></li>
                @endforeach
            </ul>
        </div>
        <div class="footer-col follow-us cell medium-4  large-4">
            <h4>{{ GetTranslation(trans('footer.follow')) }}</h4>
            <div class="social-links">
                <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="#"><i class="fa-brands fa-instagram"></i></a>
                <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                <a href="#"><i class="fa-brands fa-tiktok"></i></a>
            </div>
        </div>
    </div>
</footer>
