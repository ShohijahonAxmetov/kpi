<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | National Developers Community</title>
    <link rel="icon" type="image/x-icon" href="/img/logo/brand.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    <nav class="navbar" id="navbar">
        <div class="navbar__container container">
            <div class="navbar__brand">
                <a href="{{ route('index') }}">
                    <img src="{{ asset('img/logo/brand.png') }}" class="navbar__pic" alt="">
                </a>
            </div>
            <div class="navbar__right">
                <div class="navbar__lang">
                    @foreach($langs as $language)
                    <a href="{{ route('setlocale', ['lang' => $language->lang]) }}" class="navbar__lang-link">
                        {{ $language->lang }}
                    </a>
                    @endforeach
                </div>
                <div class="navbar__toggler" id="toggle">
                    <div class="toggle">
                        
                    </div>
                </div>
            </div>
            <div class="navbar__collapse" id="collapse">
                <div class="navbar__content">
                    <a href="{{ route('services') }}" class="navbar__link">
                        Services
                    </a>
                    <a href="{{ route('works') }}" class="navbar__link">
                        Portfolio                        
                    </a>
                    <a href="{{ route('about') }}" class="navbar__link">
                        About
                    </a>
                    <a href="{{ route('contacts') }}" class="navbar__link">
                        Contacts                     
                    </a>
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="footer">
        <div class="footer__container container row">
            <div class="footer__col-rigth
             col-md-6 col-xs-12 p-0">
                <a href="#" class="footer__txt">
                    +998 97 666 66 66
                </a>
                <p class="footer__txt">
                    info@ndc.uz
                </p>
                <p class="footer__txt">
                    Uzbekistan, Tashkent
                    <br>
                    Sergeli-6
                </p>
            </div>
            <div class="col-md-6 col-xs-12 p-0 foot__col-left">
                <ul class="footer__links">
                    <li class="footer__link">
                        <a href="#" class="footer__a">
                            UX/UI design
                        </a>
                    </li>
                    <li class="footer__link">
                        <a href="#" class="footer__a">
                            Branding
                        </a>
                    </li>
                    <li class="footer__link">
                        <a href="#" class="footer__a">
                            Crm cystem
                        </a>
                    </li>
                    <li class="footer__link">
                        <a href="#" class="footer__a">
                            Social Media Marketing
                        </a>
                    </li>
                    <li class="footer__link">
                        <a href="#" class="footer__a">
                            Naming
                        </a>
                    </li>
                    <li class="footer__link">
                        <a href="#" class="footer__a">
                            UX Strategy
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer__bottom container">
            <div>
                <p class="footer__info">
                    ©2022 Все права защищены.
                </p>
            </div>
            <div>
                <a href="" class="footer__socs">Facebook</a>
                <a href="" class="footer__socs">Instagram</a>
                <a href="" class="footer__socs">Telegram</a>
            </div>
        </div>
    </footer>

    <div class="cursor" id="cursor">
        <div class="btns">
            <div class="left-arrow swiper-button-prev">
                <img src="{{ asset('img/logo/left-slider.svg') }}" alt="">
            </div>
            <div class="right-arrow swiper-button-next">
                <img src="{{ asset('img/logo/right-slider.svg') }}" alt="">
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/imask"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>

{{-- @yield('links') for links --}}


{{-- @yield('content') for content --}}


{{-- @yield('scripts') for scripts --}}