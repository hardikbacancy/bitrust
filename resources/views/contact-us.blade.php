@extends('homeLayout.main')

@section('content')
    @if(session()->has('message'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{ session()->get('message') }}
        </div>
    @endif
    <!-- Contact Us Section -->
    <section class="management contain-wrapp">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-heading">
                        <h2>Contact Us</h2>
                    </div>
                    <p>At Bitrust, We Have Made it Easy for Customer to Reach Us and Get Their Solutions Weaved.Drop your inquiry in the form given below of this page,and within 24 hours, one of our business development executive will reach you for further communication.</p>
                </div>
            </div>
        </div>

        <section class="contact-details my-4">
            <div class="container">
                <div class="row flex-wrap justify-content-center">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <h3 class="text-uppercase">Leave a Message</h3>
                        <form class="footer-content mt-6" action="/send_message" method="post" id="send-message">
                            <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">

                            <div class="flex-wrap row mt-8">
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>Name <span style="color:red;">*</span></label>
                                    <input type="text" name="name" placeholder="Please Enter Your Name" value="" class="form-control" id="name">
                                </div>

                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>Email <span style="color:red;">*</span></label>
                                    <input type="email" name="email" value="" placeholder="Please Enter Your Email" class="form-control" id="email">
                                </div>

                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>Subject <span style="color:red;">*</span></label>
                                    <input type="text" name="subject" value="" placeholder="Please Enter Subject" class="form-control" id="subject">
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <label>Message <span style="color:red;">*</span></label>
                                    <textarea class="form-control" placeholder="Please Enter Message Here..." name="message" id="message"></textarea>
                                </div>
                                <div class="col-sm-12 text-right">
                                    <button type="submit" class="btn red-bg text-white" id="send-message">Send</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <h3 class="text-uppercase">Reach out to us Directly</h3>
                        <div class="row">
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <ul class="address-link">

                                    <p><span><i class="fa fa-map-marker mr-1"></i></span>Shree Brahmani Investor INC</p>
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;20 Popham drive<br>
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;Guelph,ON<br>
                                    <p>&nbsp;&nbsp;&nbsp;&nbsp;N1E0B8</p>

                                </ul>
                            </div>
                            <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                <ul class="address-link">
                                    <li><i class="fa fa-phone"></i><a href="tel:123.567.8978"> +1 519 835 4546</a></li>
                                    <li><i class="fa fa-envelope-o"></i><a href="emailto:info@bitrust.ca">info@bitrust.ca</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-lg-12">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2890.928663251969!2d-80.23233768422914!3d43.57151687912417!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x882b9bad1046ac5f%3A0xb5e242a7997bb502!2s20+Popham+Dr%2C+Guelph%2C+ON+N1E+0B8%2C+Canada!5e0!3m2!1sen!2sin!4v1551274121099" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

@endsection
       