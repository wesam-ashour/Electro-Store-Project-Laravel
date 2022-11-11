<!-- FOOTER -->
<!-- NEWSLETTER -->
<div id="newsletter" class="section">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-12">
                <div class="newsletter">
                    <p>{{ __('footer.Subscribe_for_the') }} <strong>{{ __('footer.NEWSLETTER') }}</strong></p>
                    <form>
                        <input class="input" type="email" placeholder="{{ __('footer.EnterـYourـEmail') }}">
                        <button class="newsletter-btn"><i class="fa fa-envelope"></i>{{ __('footer.Subscribe') }} </button>
                    </form>
                    @foreach (\App\Models\Lookup::where('id',1)->get() as $one)
                    <ul class="newsletter-follow">
                        <li>
                            <a href="{{$one->facebook_url}}"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li>
                            <a href="{{$one->twitter_url}}"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li>
                            <a href="{{$one->instagram_url}}"><i class="fa fa-instagram"></i></a>
                        </li>
                        <li>
                            <a href="{{$one->snapchat_url}}"><i class="fa fa-snapchat"></i></a>
                        </li>
                        <li>
                            <a type="tel" value="{{$one->whatsApp_number}}" ><i class="fa fa-whatsapp"></i></a>
                        </li>
                    </ul>
                    @endforeach
                </div>
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</div>
<footer id="footer">
    <!-- bottom footer -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <div class="col-md-3 col-xs-6">
                    <div class="footer">
                        <h3 class="footer-title">{{ __('footer.About_Us') }} </h3>
                        <ul class="footer-links">
                            <li><a href="#"><i class="fa fa-map-marker"></i>{{ __('welcome.Palestine_Gaza_Strip') }}</a></li>
                            <li><a href="#"><i class="fa fa-phone"></i>059-99999999</a></li>
                            <li><a href="#"><i class="fa fa-envelope-o"></i>admin@admin.com</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-3 col-xs-6">
                    <div class="footer">
                        <h3 class="footer-title">{{ __('footer.Categories') }} </h3>
                        <ul class="footer-links">
                            <li><a href="{{route('product.view')}}">{{ __('footer.Women’s_Apparel') }}</a></li>
                            <li><a href="{{route('product.view')}}">{{ __('footer.Gifts') }}</a></li>
                            <li><a href="{{route('product.view')}}">{{ __('footer.Jewerlly_&_Accessories') }}</a></li>
                            <li><a href="{{route('product.view')}}">{{ __('footer.Shoes') }}</a></li>
                            <li><a href="{{route('product.view')}}">{{ __('footer.Handbags') }}</a></li>
                            <li><a href="{{route('product.view')}}">{{ __('footer.Sale') }}</a></li>
                        </ul>
                    </div>
                </div>

                <div class="clearfix visible-xs"></div>

                <div class="col-md-3 col-xs-6">
                    <div class="footer">
                        <h3 class="footer-title">{{ __('footer.Information') }}</h3>
                        <ul class="footer-links">
                            <li><a href="{{route('about_us')}}">{{ __('footer.About_Us') }}</a></li>
                            <li><a href="{{route('send_submisions')}}">{{ __('footer.Contact_Us') }}</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-3 col-xs-6">
                    <div class="footer">
                        <h3 class="footer-title">{{ __('footer.Service') }}</h3>
                        <ul class="footer-links">
                            <li><a href="{{route('profile_user')}}">{{ __('footer.My_Account') }}</a></li>
                            <li><a href="{{route('cart')}}">{{ __('footer.View_Cart') }}</a></li>
                            <li><a href="{{route('wishlist')}}">{{ __('footer.Wishlist') }}</a></li>
                            <li><a href="{{route('orders.index')}}">{{ __('footer.Track_My_Order') }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div></footer>
<!-- /FOOTER -->
