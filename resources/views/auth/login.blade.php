<!DOCTYPE html>
<html dir="ltr" lang="en-US">

@include('layouts.head')


<body>
    <!--Page Wrapper starts-->
    <div class="page-wrapper">
        <!--header starts-->
        <header class="transparent scroll-hide">
            <!--Main Menu starts-->
            <div class="site-navbar-wrap v2">
                <div class="container">
                    <div class="site-navbar">
                        <div class="row align-items-center">
                            <div class="col-md-4 col-6">
                                <a class="navbar-brand" href="#"><img src="images/logo-black.png" alt="logo" class="img-fluid"></a>
                            </div>
                        </div>
                    </div>
                    <!--mobile-menu starts -->
                    <div class="site-mobile-menu">
                        <div class="site-mobile-menu-header">
                            <div class="site-mobile-menu-close  js-menu-toggle">
                                <span class="ion-ios-close-empty"></span>
                            </div>
                        </div>
                        <div class="site-mobile-menu-body"></div>
                    </div>
                    <!--mobile-menu ends-->
                </div>
            </div>
            <!--Main Menu ends-->
        </header>
        <!--Header ends-->
        <!--User Login section starts-->
        <div class="user-login-section section-padding bg-fixed" style="background-image: url({{url('images/header/hero-5.jpg')}})">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 offset-md-1  text-center">
                        <div class="login-wrapper">
                            <ul class="ui-list nav nav-tabs justify-content-center mar-bot-30" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="tab" href="#" role="tab" aria-selected="true">Login</a>
                                </li>
                            </ul>
                            <div class="ui-dash tab-content">
                                <div class="tab-pane fade show active" id="login" role="tabpanel">
                                    <form id="login-form" action="{{route('action-login')}}" method="post">
                                    @csrf
                                        <div class="form-group">
                                            <input type="text" name="RecordOwnerID" id="RecordOwnerID" tabindex="1" class="form-control" placeholder="Kode Partner" value="" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="email" id="email" tabindex="2" class="form-control" placeholder="Email" value="" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" id="password" tabindex="3" class="form-control" placeholder="Password">
                                        </div>
                                        <div class="row mar-top-20">
                                            <div class="col-md-6 col-12 text-left">
                                                <div class="res-box">
                                                    <input type="checkbox" tabindex="4" class="" name="remember" id="remember">
                                                    <label for="remember">Remember Me</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12 text-right">
                                                <div class="res-box sm-left">
                                                    <a href="#" tabindex="5" class="forgot-password">Forgot Password?</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="res-box text-center mar-top-30">
                                            <button type="submit" class="btn v3"><i class="ion-log-in"></i> Log In</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--User login section ends-->
        <!--Login section ends-->
        <!-- Scroll to top starts-->
        <span class="scrolltotop"><i class="ion-arrow-up-c"></i></span>
        <!-- Scroll to top ends-->
    </div>
    <script src="{{ asset('public/js/plugin.js') }}"></script>
    <!--Main js-->
    <script src="{{ asset('public/js/main.js') }}"></script>
    <!--Scripts ends-->
    @include('sweetalert::alert')
</body>

</html>

<script type="text/javascript">
    $(function () {
        $(document).ready(function () {
            
        })
    })
</script>