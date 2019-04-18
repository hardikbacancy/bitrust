@extends('homeLayout.main')

@section('content')

<div id="" class="banner">
    <!--  <img src="images/banner.jpg"> -->
    <div class="banncontent">
        <h1>We Provide the Best Financial Solution</h1>
        <p>Bitrust team believe in to help each and every financial needy person to provide fund,so they can fullfil their dream</p>
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
                    <p>With its focus on the customer, marketing is one of the premier components of our business.</p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="col-icon-2 box">
                    <div class="images-box">
                        <img src="{{asset('home/images/banking.png')}}">
                    </div>
                    <h3>Banking</h3>
                    <p>We are the financial institution that take less membership fees from the public and provide them loan in less Emi's for certain period</p>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="col-icon-2 box">
                    <div class="images-box">
                        <img src="{{asset('home/images/evaluation.png')}}">
                    </div>
                    <h3>Evaluation</h3>
                    <p>As a financial institution we evaluate the significance,and actual need for customers so right person can take our benefits.</p>
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
                    <p>Enter basic information along with beneficiary's data online.</p>
                </div>
            </div>
            <div class="col-sm-4 mt-10p trustwrk-c-img">
                <div class="col-icon-2 box">
                    <div class="images-box-trustwrk">
                        <img src="{{asset('home/images/banking.png')}}">
                    </div>
                    <h3>Get a decision quickly</h3>
                    <p>Pay basic membership fees and be eligible to get funds</p>
                </div>
            </div>
            <div class="col-sm-4 mt-20p">
                <div class="col-icon-2 box">
                    <div class="images-box-trustwrk">
                        <img src="{{'home/images/evaluation.png'}}">
                    </div>
                    <h3>Start using your funds today</h3>
                    <p>Apply for any loan amount with certain period at lowest emi's</p>
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
                <p>Loans for The Micro, Small and Medium Enterprises categorise under MSME Loan,and we make provide and support it </p>
                <ul>
                    <li> To Promote MSME growth</li>
                    <li> We encourage and inspire young Enterpreneur</li>
                    <li> We removed every process that slows down a loan approval</li>
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
                <p>With small business loans , funding for your small business is now just 24 hours away.
                    Use the funds to invest in infrastructure, expand operations, upgrade to the latest plant and machinery,
                    maintain inventory, or to increase working capital</p>
                <ul>
                    <li> Large capital made affordable</li>
                    <li> To help Scale up operations and take on bigger projects and much more </li>
                    <li> To Increase your business cash flow </li>
                </ul>
            </div>

        </div>
    </div>
</section>

<section class="parallax parallaxsec parallax-two bg4">
    <div class="cta-wrapper ">
        <div class="container">
            <div class="row parallaxsectop">
                <h4>Shree Brahmani Investor INC bring support people to grow individually</h4>
                <p>We helps the servicing and management of loan facility on a single platform.
                    The solutions provide a comprehensive set of
                    customer and account centric business operations
                    which enable customers to be more business centic and offers
                    customer support capability
                </p>
            </div>
            <div class="row">
                <div class="col-md-4 cta-box">
                    <div class="col-icon centered">
                        <img src="{{asset('home/images/stockexchange.png')}}">
                        <h5>End-to-end loan management functionality</h5>
                        {{--<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit.  </p>--}}
                    </div>
                </div>
                <div class="col-md-4 cta-box">
                    <div class="col-icon centered">
                        <img src="{{asset('home/images/stockexchange.png')}}">
                        <h5>User specific Dashboards, full trace and control</h5>
                        {{--<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit.  </p>--}}
                    </div>
                </div>
                <div class="col-md-4 cta-box">
                    <div class="col-icon centered">
                        <img src="{{asset('home/images/stockexchange.png')}}">
                        <h5>Customer oriented settlement of loan</h5>
                        {{--<p> Lorem ipsum dolor sit amet, consectetur adipisicing elit.  </p>--}}
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{--<section class="newsinsight contain-wrapp gray-container ">--}}
    {{--<div class="container">--}}
        {{--<div class="row">--}}
            {{--<div class="col-md-8 col-md-offset-2">--}}
                {{--<div class="section-heading ">--}}
                    {{--<h2>News and Insights</h2>--}}
                    {{--<p>Get the latest news from our team</p>--}}

                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        {{--<div class="row mt-50">--}}
            {{--<div class="col-md-4">--}}
                {{--<article class="post-wrapper">--}}
                    {{--<img src="{{asset('home/images/articleone.png')}}" class="img-responsive" alt="">--}}
                    {{--<div class="post-content">--}}

                        {{--<h6>If the White Whale be raised, it must be in a month</h6>--}}
                        {{--<span class="post-date"><i class="fa fa-clock-o"></i> 17 August 2017</span>--}}
                    {{--</div>--}}
                {{--</article>--}}
            {{--</div>--}}
            {{--<div class="col-md-4">--}}
                {{--<article class="post-wrapper">--}}
                    {{--<img src="{{asset('home/images/articleone.png')}}" class="img-responsive" alt="">--}}
                    {{--<div class="post-content">--}}

                        {{--<h6>If the White Whale be raised, it must be in a month</h6>--}}
                        {{--<span class="post-date"><i class="fa fa-clock-o"></i> 17 August 2017</span>--}}
                    {{--</div>--}}
                {{--</article>--}}
            {{--</div>--}}
            {{--<div class="col-md-4">--}}
                {{--<article class="post-wrapper">--}}
                    {{--<img src="{{asset('home/images/articleone.png')}}" class="img-responsive" alt="">--}}
                    {{--<div class="post-content">--}}

                        {{--<h6>If the White Whale be raised, it must be in a month</h6>--}}
                        {{--<span class="post-date"><i class="fa fa-clock-o"></i> 17 August 2017</span>--}}
                    {{--</div>--}}
                {{--</article>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</section>--}}
@endsection
       