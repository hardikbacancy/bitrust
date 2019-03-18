<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="" content="">
    <link rel="icon" href="home/images/favicon.png">
    <title>BTrust</title>
    <!-- BOOTSTRAP -->
    <link href="home/js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- CUSTOM STYLES -->
    <link href="home/css/style.css" rel="stylesheet">
    <link href="home/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .error{
            color: red;
        }
    </style>
</head>

<body>
<!-- Top area -->
<div class="top-container">
    <div class="container">
        <div class="top-column-left">
            <a href="/">
                <img src="home/images/logo.png" alt="Logo" />
            </a>
        </div>
        <div class="top-column-right mt-1">
            <ul class="contact-line">
                <li><i class="fa fa-phone"></i><a href="tel:++15198354546"> +1 519 835 4546 </a></li>
                <li><i class="fa fa-envelope"></i><a href="mailto: info@bitrust.ca"> info@bitrust.ca </a></li>
            </ul>
            <!-- <div class="top-social-network">
                <a href="#"><i class="fa fa-facebook"></i></a>
                <a href="#"><i class="fa fa-linkedin"></i></a>
                <a href="#"><i class="fa fa-twitter"></i></a>
            </div> -->
        </div>
    </div>
</div>
<!-- Top area /-->
<div class="clearfix"></div>
<!-- Top Navbar -->
<nav class="navbar navbar-default navbar-dark megamenu mb-0">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-menu">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand logo" href="index.html">
                <img src="home/images/logo.png" alt="Logo" />
            </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse mx-0 px-3 px-sm-0" id="navbar-menu">
            <ul class="nav navbar-nav navbar-left">
                <li class="{{ request()->is('/') ? 'active' : '' }}"><a href="{{ url('/') }}">Home</a></li>
                <li class="{{ request()->is('about-us') ? 'active' : '' }}"><a href="{{ url('/about-us') }}">About Us</a></li>
                <li class="{{ request()->is('who-we-are') ? 'active' : '' }}"><a href="{{ url('/who-we-are') }}">Who we are</a></li>
                <li class="{{ request()->is('contact-us') ? 'active' : '' }}"><a href="{{ url('/contact-us') }}">Contact Us</a></li>
                <li><a href="{{ url('/login') }}">Sign In/up</a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- Top Navbar /-->

@yield('content')

<footer>
    <div class="container">
        <div class="row">
            <div class="footer-content">
                <a href="/"><img class="footer-logo" src="home/images/footerlogo.png" alt="Footer logo"></a>
                <p class="my-8">Shree Brahmani Investor INC<br>
                    20 Popham drive<br>
                    Guelph,ON<br>
                    N1E0B8</p>
                <ul class="menu">
                    <li><a class="active" href="/">HOME</a></li>
                    <li><a href="/about-us">About us</a></li>
                    <li><a href="/who-we-are">Who We are</a></li>
                    <li><a href="/contant-us">Contact US</a></li>
                    <li><a href="javascript:;">SIGN IN / UP</a></li>
                </ul>
                <hr>
                <ul class="contact">
                    <li><i class="fa fa-phone"></i><a href="tel:123.567.8978">123.567.8978</a></li>
                    <li><i class="fa fa-envelope-o"></i><a href="emailto:info@bitrust.ca">info@bitrust.ca</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Bottom Footer Line -->
    <div class="sub-footer mt-8">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <p class="">© 2019 BI Trust. All Rights Reserved</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Bottom Footer Line /-->
</footer>

<!-- jQuery -->
<script src="{{asset('home/js/jquery.min.js')}}"></script>
<!-- BOOTSTRAP -->
<script src="{{asset('home/js/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/jquery.validate.min.js') }} "></script>

<!-- Contact Us Section /-->
<script>
    $(document).ready(function () {
        $('#send-message').validate({ // initialize the plugin
            rules: {
                name: {
                    required: true
                },
                email: {
                    required: true
                },

                subject: {
                    required: true,

                },
                message: {
                    required: true,
                },
            }
        });

    });

</script>

</body>
</html>