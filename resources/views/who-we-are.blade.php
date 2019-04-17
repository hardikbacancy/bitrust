@extends('homeLayout.main')
@section('content')

    <style>
        .mngt-box img{    height: 250px;
            max-width: 250px;
            width: 100%;
            margin: 0 auto;}
        .mngt-box  ul li{list-style-type: none}
    </style>
    <section class="management contain-wrapp">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Our Professionals</h2>
                    </div>
                </div>
            </div>

            <div class="row mt-6 mngt-box text-center">
                <div class="col-md-4 mt-8 col-sm-12 col-xs-12 ">
                    <img src="{{asset('home/images/jagdish_b_patel.jpg')}}" class="img-responsive text-center">
                    <div class="content-box">
                        <h3 class="mt-3">Jagdish B Patel</h3>
                        <span>Director</span>
                        <h4>Work Experience</h4>
                        <ul>
                            <li>Founder of 4 successful startnup</li>
                        </ul>

                    </div>


                </div>
                <div class="col-md-4 mt-8 col-sm-12 col-xs-12 ">
                    <img src="{{asset('home/images/sunil_patel.jpg')}}" class="img-responsive text-center">
                    <div class="content-box">
                        <h3 class="mt-3">Sunil Patel</h3>
                        <span>Director</span>
                        <h4>Work Experience</h4>
                        <ul>
                            <li>Founder of 4 successful startnup</li>
                        </ul>
                    </div>


                </div>
                <div class="col-md-4 mt-8 col-sm-12 col-xs-12 ">
                    <img src="{{asset('home/images/bhadresh_patel.jpg')}}" class="img-responsive text-center">
                    <div class="content-box">
                        <h3 class="mt-3">Bhadresh Patel</h3>
                        <span>Director</span>
                        <h4>Work Experience</h4>
                        <ul>
                            <li>Founder of 4 successful startnup</li>
                        </ul>
                    </div>


                </div>
            </div>




    </section>

@endsection
       