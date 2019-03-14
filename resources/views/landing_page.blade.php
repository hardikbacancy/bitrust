@extends('homeLayout.main')

@section('content')

<div id="" class="banner">
    <!--  <img src="images/banner.jpg"> -->
    <div class="banncontent">
        <h1>We Provide the Best Financial Solution</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud </p>
        <a href="#">Know More</a>
    </div>
</div>
<!-- END OF SLIDER WRAPPER -->

<!-- START - Contain Wrapp -->
<section class="weare contain-wrapp ">
    <div class="container">
        <div class="row trust-bg">
            <div class="col-md-12">
                <div class="section-heading">
                    <h2>We Are <strong> BI Trust </strong></h2>
                    <p> Modern Business Journeys  Begin Online </p>
                </div>
            </div>

            <div class="col-sm-4">
                <div class="col-icon-2 box">
                    <div class="images-box">
                        <img src="{{asset('home/images/marketing.png')}}">
                    </div>
                    <h3>Marketting</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore. </p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="col-icon-2 box">
                    <div class="images-box">
                        <img src="{{asset('home/images/banking.png')}}">
                    </div>
                    <h3>Banking</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore. </p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="col-icon-2 box">
                    <div class="images-box">
                        <img src="{{asset('home/images/evaluation.png')}}">
                    </div>
                    <h3>Evaluation</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore. </p>
                </div>
            </div>
        </div>
        <hr>
        <div class="row trustwrk">
            <div class="col-md-12 mb-30">
                <div class="section-heading">
                    <h2>How a BI Trust works</h2>
                    <p> Accessing small business funding shouldn't be complicated or time-consuming... </p>
                </div>
            </div>

            <div class="col-sm-4 ">
                <div class="col-icon-2 box">
                    <div class="images-box-trustwrk">
                        <img src="{{asset('home/images/minute.png')}}">
                    </div>
                    <h3>Apply anywhere in minutes</h3>
                    <p>Enter basic business information and link your revenue data online or through our mobile app. </p>
                </div>
            </div>
            <div class="col-sm-4 mt-10p trustwrk-c-img">
                <div class="col-icon-2 box">
                    <div class="images-box-trustwrk">
                        <img src="{{asset('home/images/banking.png')}}">
                    </div>
                    <h3>Get a decision quickly</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore. </p>
                </div>
            </div>
            <div class="col-sm-4 mt-20p">
                <div class="col-icon-2 box">
                    <div class="images-box-trustwrk">
                        <img src="{{'home/images/evaluation.png'}}">
                    </div>
                    <h3>Start using your funds today</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore. </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END - Contain Wrapp -->
<section class=" loan-sec contain-wrapp ">
    <div class="container">
        <div class="row">
            <div class="col-md-6  pull-right">
                <img src="{{asset('home/images/msmeloan.png')}}"   class="img-responsive" >
            </div>
            <div class="col-md-6 mt-50">
                <span> For Self Employed </span>
                <h5>MSME Loan</h5>
                <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex. </p>
                <ul>
                    <li> Lorem ipsum dolor sit amet </li>
                    <li> Lorem ipsum dolor sit amet, consectetur adipisicing  </li>
                    <li> Lorem ipsum dolor sit amet, consectetur adipisicing </li>
                </ul>
            </div>
        </div>
        <div class="row mt-100">
            <div class="col-md-6 ">
                <img src="{{asset('home/images/msmeloan.png')}}"  class="img-responsive" >
            </div>

            <div class="col-md-6 mt-50">
                <span> For Self Employed </span>
                <h5>Business Loan</h5>
                <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex. </p>
                <ul>
                    <li> Lorem ipsum dolor sit amet </li>
                    <li> Lorem ipsum dolor sit amet, consectetur adipisicing  </li>
                    <li> Lorem ipsum dolor sit amet, consectetur adipisicing </li>
                </ul>
            </div>

        </div>
    </div>
</section>

<section class="parallax parallaxsec parallax-two bg4">
    <div class="cta-wrapper ">
        <div class="container">
            <div class="row parallaxsectop">
                <h4>We Bring the Right People Together to Challenge Established Thinking and Drive Transformation.</h4>
                <p>On the other hand we denounce with righteous indignation and dislike men who are so beguiled and demoralized
                    by the charms of pleasure of the moment so blinded by desire that they cannot.</p>
            </div>
            <div class="row">
                <div class="col-md-4 cta-box">
                    <div class="col-icon centered">
                        <img src="{{asset('home/images/stockexchange.png')}}">
                        <h5>Stock Exchange and Banks</h5>
                        <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit.  </p>
                    </div>
                </div>
                <div class="col-md-4 cta-box">
                    <div class="col-icon centered">
                        <img src="{{asset('home/images/stockexchange.png')}}">
                        <h5>Stock Exchange and Banks</h5>
                        <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit.  </p>
                    </div>
                </div>
                <div class="col-md-4 cta-box">
                    <div class="col-icon centered">
                        <img src="{{asset('home/images/stockexchange.png')}}">
                        <h5>Stock Exchange and Banks</h5>
                        <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit.  </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="newsinsight contain-wrapp gray-container ">
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="section-heading ">
                    <h2>News and Insights</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Numquam voluptas ducimus sequi animi.</p>

                </div>
            </div>
        </div>
        <div class="row mt-50">
            <div class="col-md-4">
                <article class="post-wrapper">
                    <a href="#"><img src="{{asset('home/images/articleone.png')}}" class="img-responsive" alt=""></a>
                    <div class="post-content">

                        <h6><a href="#">If the White Whale be raised, it must be in a month</a></h6>
                        <span class="post-date"><i class="fa fa-clock-o"></i> 17 August 2017</span>
                    </div>
                </article>
            </div>
            <div class="col-md-4">
                <article class="post-wrapper">
                    <a href="#"><img src="{{asset('home/images/articleone.png')}}" class="img-responsive" alt=""></a>
                    <div class="post-content">

                        <h6><a href="#">If the White Whale be raised, it must be in a month</a></h6>
                        <span class="post-date"><i class="fa fa-clock-o"></i> 17 August 2017</span>
                    </div>
                </article>
            </div>
            <div class="col-md-4">
                <article class="post-wrapper">
                    <a href="#"><img src="{{asset('home/images/articleone.png')}}" class="img-responsive" alt=""></a>
                    <div class="post-content">

                        <h6><a href="#">If the White Whale be raised, it must be in a month</a></h6>
                        <span class="post-date"><i class="fa fa-clock-o"></i> 17 August 2017</span>
                    </div>
                </article>
            </div>
        </div>
    </div>
</section>
@endsection
       