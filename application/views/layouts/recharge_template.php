<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
        <meta content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" name="viewport">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>NEPZY</title>

        <!-- Bootstrap -->
        <link href="<?php echo base_url('assets/site'); ?>/css/bootstrap.min.css" rel="stylesheet">

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Custom CSS -->
        <link href="<?php echo base_url('assets/site'); ?>/css/animate.css" rel="stylesheet">
        <!-- Important Owl stylesheet -->
        <link rel="stylesheet" href="<?php echo base_url('assets/site'); ?>/css/owl.carousel.css">
        <!-- Default Theme -->
        <link rel="stylesheet" href="<?php echo base_url('assets/site'); ?>/css/owl.theme.css">
        <link href="<?php echo base_url('assets/site'); ?>/css/custom.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    </head>
    <body>
        <header>
            <nav class="navbar navbar-default navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="index.html"><img src="<?php echo base_url('assets/site'); ?>/images/nepzy-logo.png" alt=""></a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav navbar-right top-links">
                            <li><a href="#">Recharge</a></li>
                            <li><a href="#">Flight</a></li>
                            <li><a href="#">Movie</a></li>
                            <li><a href="#">Ticket</a></li>
                            <li><a href="#">Holidays</a></li>
                        </ul>

                        <ul class="nav navbar-nav navbar-right visible-mobile">
                            <li><a href="#"><i class="fa fa-user"></i>Corporate</a></li>
                            <li class="devider"></li>
                            <li><a href="#"><i class="fa fa-user-secret"></i>Agent</a></li>
                            <li class="devider"></li>
                            <li><a href="#" data-toggle="modal" data-target="#login"><i class="fa fa-sign-in"></i>Sign Up</a></li>
                            <li><a href="#" data-toggle="modal" data-target="#login"><i class="fa fa-sign-in"></i>Sign In</a></li>
                            <li class="devider"></li>
                            <li class="call"><i><img src="<?php echo base_url('assets/site'); ?>/images/24-7-icon.png" alt=""></i>8587078567</li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </nav>
        </header>
        <!-- HEADER END -->

        <section id="main-navigation">
            <div class="container">
                <div class="navig">
                    <ul>
                        <li><a href="" title="" class="active"><i class="recharge"></i>RECHARGE</a></li>
                        <li><a href="" title=""><i class="flight"></i>Flight</a></li>
                        <li><a href="" title=""><i class="movieticket"></i>Movie Ticket</a></li>
                    </ul>
                </div>
                <div class="visible-dekstop secondry-links">
                    <ul class="navbar-right">
                        <li><a href="#"><i class="fa fa-user"></i>Corporate</a></li>
                        <li class="devider"></li>
                        <li><a href="#"><i class="fa fa-user-secret"></i>Agent</a></li>
                        <li class="devider"></li>
                        <li><a href="#" data-toggle="modal" data-target="#login"><i class="fa fa-sign-in"></i>Sign Up</a></li>
                        <li><a href="#" data-toggle="modal" data-target="#login"><i class="fa fa-sign-in"></i>Sign In</a></li>
                        <li class="devider"></li>
                        <li class="call"><i><img src="<?php echo base_url('assets/site'); ?>/images/24-7-icon.png" alt=""></i>8587078567</li>
                    </ul>
                </div>
            </div>


        </section>  


        <section id="banner">
            <div class="transparent-black">

            </div>
        </section>

        <!-- BANNER END -->

        <section id="form-section">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-dv">

                            <div class="tab-cstm">

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs nav-justified" role="tablist">
                                    <li role="presentation" class="active"><a href="#mobile" aria-controls="home" role="tab" data-toggle="tab"><i class="mobile"></i><span class="text-link">Mobile</span></a></li>
                                    <li role="presentation"><a href="#landline" aria-controls="profile" role="tab" data-toggle="tab"><i class="landline"></i><span class="text-link">Landline</span></a></li>
                                    <li role="presentation"><a href="#adsl" aria-controls="messages" role="tab" data-toggle="tab"><i class="adsl"></i><span class="text-link">ADSL</span></a></li>
                                    <li role="presentation"><a href="#broad-link" aria-controls="settings" role="tab" data-toggle="tab"><i class="broadlink"></i><span class="text-link">Broad Link</span></a></li>
                                    <li role="presentation"><a href="#dish-home" aria-controls="settings" role="tab" data-toggle="tab"><i class="dishhome"></i><span class="text-link">Dish Home</span></a></li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">

                                    <div role="tabpanel" class="tab-pane fade in active" id="mobile">
                                        <div class="form-fields-dv">
                                            <?php form_open(); ?>
                                            <div class="form-group m-25px-b">
                                                <input type="text" class="form-control input-lg for-phone-mobile-pad" placeholder="Enter 10 digit number" required="required">
                                                <span class="phone-icn"><a href="#"><img src="<?php echo base_url('assets/site'); ?>/images/phone-number-icon.png" alt=""></a></span>
                                            </div>
                                            <div class="form-group m-25px-b">
                                                <label class="down-icn">
                                                    <select class="form-control input-lg">
                                                        <option selected>Operator</option>
                                                        <option>ABC</option>
                                                        <option>XYZ</option>
                                                    </select>
                                                </label>
                                            </div>
                                            <div class="form-group m-25px-b">
                                                <input type="text" class="form-control input-lg for-inline-link-pad" placeholder="Enter Amount">
                                                <span class="filed-internal-link"><a data-target="#viewplan" data-toggle="modal" href="#">View Plan</a></span>
                                            </div>
                                            <div class="form-group m-25px-b">
                                                <input type="text" class="form-control input-lg for-inline-link-pad" placeholder="Enter Promo Code">
                                                <span class="filed-internal-link"><a href="#">Apply</a></span>
                                            </div>
                                            <div class="form-group text-center m-25px-b">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" checked>Click here to pay fast
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group text-center">
                                                <input type="submit" class="btn btn-primary btn-blue" value="Pay Now">
                                            </div>
                                            <?php echo form_close(); ?>
                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane fade" id="landline">
                                        <div class="form-fields-dv">
                                            <div class="form-group m-25px-b">
                                                <input type="text" class="form-control input-lg " placeholder="Enter Landline Number">
                                            </div>
                                            <!--<div class="form-group">
                                            <select class="form-control input-lg">
                                            <option>Operator</option>
                                            </select>
                                            </div>-->



                                            <div class="form-group m-25px-b">
                                                <input type="text" class="form-control input-lg" placeholder="Enter Amount">
                                            </div>
                                            <div class="form-group m-25px-b">
                                                <input type="text" class="form-control input-lg for-inline-link-pad" placeholder="Enter Promo Code">
                                                <span class="filed-internal-link"><a href="#">Apply</a></span>
                                            </div>
                                            <div class="form-group text-center m-25px-b">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" checked>Click here to pay fast
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group text-center">
                                                <input type="submit" class="btn btn-primary btn-blue" value="Pay Now">
                                            </div>
                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane fade" id="adsl">
                                        <div class="form-fields-dv">
                                            <div class="form-group m-25px-b">
                                                <input type="text" class="form-control input-lg " placeholder="Enter Your ADSL Number">
                                            </div>
                                            <!--<div class="form-group">
                                            <select class="form-control input-lg">
                                            <option>Operator</option>
                                            </select>
                                            </div>-->

                                            <div class="form-group m-25px-b text-center">
                                                <label class="radio-inline">
                                                    <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"> Limited
                                                </label>
                                                <label class="radio-inline">
                                                    <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2" checked> Unlimited
                                                </label>
                                            </div>

                                            <div class="form-group m-25px-b">
                                                <input type="text" class="form-control input-lg" placeholder="Enter Amount">
                                            </div>
                                            <div class="form-group m-25px-b">
                                                <input type="text" class="form-control input-lg for-inline-link-pad" placeholder="Enter Promo Code">
                                                <span class="filed-internal-link"><a href="#">Apply</a></span>
                                            </div>
                                            <div class="form-group text-center m-25px-b">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" value="">Click here to pay fast
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group text-center">
                                                <input type="submit" class="btn btn-primary btn-blue" value="Pay Now">
                                            </div>
                                        </div>
                                    </div>

                                    <div role="tabpanel" class="tab-pane fade" id="broad-link">
                                        <div class="form-fields-dv">
                                            <div class="form-group m-25px-b">
                                                <input type="text" class="form-control input-lg " placeholder="Subscriber ID">
                                            </div>
                                            <!--<div class="form-group">
                                            <select class="form-control input-lg">
                                            <option>Operator</option>
                                            </select>
                                            </div>-->



                                            <div class="form-group m-25px-b">
                                                <input type="text" class="form-control input-lg" placeholder="Enter Amount">
                                            </div>
                                            <div class="form-group m-25px-b">
                                                <input type="text" class="form-control input-lg for-inline-link-pad" placeholder="Enter Promo Code">
                                                <span class="filed-internal-link"><a href="#">Apply</a></span>
                                            </div>
                                            <div class="form-group text-center m-25px-b">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" checked>Click here to pay fast
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group text-center">
                                                <input type="submit" class="btn btn-primary btn-blue" value="Pay Now">
                                            </div>
                                        </div>    
                                    </div>

                                    <div role="tabpanel" class="tab-pane fade" id="dish-home">
                                        <div class="form-fields-dv">
                                            <div class="form-group m-25px-b">
                                                <input type="text" class="form-control input-lg " placeholder="Subscriber ID">
                                            </div>
                                            <!--<div class="form-group">
                                            <select class="form-control input-lg">
                                            <option>Operator</option>
                                            </select>
                                            </div>-->



                                            <div class="form-group m-25px-b">
                                                <input type="text" class="form-control input-lg" placeholder="Enter Amount">
                                            </div>
                                            <div class="form-group m-25px-b">
                                                <input type="text" class="form-control input-lg for-inline-link-pad" placeholder="Enter Promo Code">
                                                <span class="filed-internal-link"><a href="#">Apply</a></span>
                                            </div>
                                            <div class="form-group text-center m-25px-b">
                                                <div class="checkbox">
                                                    <label>
                                                        <input type="checkbox" checked>Click here to pay fast
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group text-center">
                                                <input type="submit" class="btn btn-primary btn-blue" value="Pay Now">
                                            </div>
                                        </div>    
                                    </div>

                                </div>

                            </div>





                        </div>
                    </div>
                    <div class="col-md-4 text-banner">
                        <div class="text-banner-bottom">
                            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                                <!-- Indicators -->
                                <ol class="carousel-indicators">
                                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                    <li data-target="#myCarousel" data-slide-to="1"></li>
                                    <li data-target="#myCarousel" data-slide-to="2"></li>
                                </ol>

                                <!-- Wrapper for slides -->
                                <div class="carousel-inner" role="listbox">
                                    <div class="item active">
                                        <div class="banner-content">
                                            <h2>Weekend Sale</h2>
                                            <h3>Upto 10% Off*-on Qatar Airways</h3>
                                            <p>5th july 2015</p>
                                            <a href="#" class="btn btn-primary btn-blue btn-xs">Book Now</a>
                                        </div>
                                    </div>

                                    <div class="item">
                                        <div class="banner-content">
                                            <h2>Weekend Sale</h2>
                                            <h3>Upto 10% Off*-on Qatar Airways</h3>
                                            <p>5th july 2015</p>
                                            <a href="#" class="btn btn-primary btn-blue btn-xs">Book Now</a>
                                        </div>
                                    </div>

                                    <div class="item">
                                        <div class="banner-content">
                                            <h2>Weekend Sale</h2>
                                            <h3>Upto 10% Off*-on Qatar Airways</h3>
                                            <p>5th july 2015</p>
                                            <a href="#" class="btn btn-primary btn-blue btn-xs">Book Now</a>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- PROMOTIONAL BANNER -->

        <section id="promotional-banner" class="wow fadeInUp">

            <div class="container">


                <div class="row">
                    <div class="col-lg-12">
                        <div id="owl-demo-1">

                            <div class="item"><a href="#"><img src="<?php echo base_url('assets/site'); ?>/images/promo-banner/promo-1.jpg" alt="Owl Image"></a></div>
                            <div class="item"><a href="#"><img src="<?php echo base_url('assets/site'); ?>/images/promo-banner/promo-2.jpg" alt="Owl Image"></a></div>
                            <div class="item"><a href="#"><img src="<?php echo base_url('assets/site'); ?>/images/promo-banner/promo-3.jpg" alt="Owl Image"></a></div>
                            <div class="item"><a href="#"><img src="<?php echo base_url('assets/site'); ?>/images/promo-banner/promo-1.jpg" alt="Owl Image"></a></div>
                            <div class="item"><a href="#"><img src="<?php echo base_url('assets/site'); ?>/images/promo-banner/promo-2.jpg" alt="Owl Image"></a></div>
                            <div class="item"><a href="#"><img src="<?php echo base_url('assets/site'); ?>/images/promo-banner/promo-3.jpg" alt="Owl Image"></a></div>
                            <div class="item"><a href="#"><img src="<?php echo base_url('assets/site'); ?>/images/promo-banner/promo-1.jpg" alt="Owl Image"></a></div>
                            <div class="item"><a href="#"><img src="<?php echo base_url('assets/site'); ?>/images/promo-banner/promo-2.jpg" alt="Owl Image"></a></div>
                            <div class="item"><a href="#"><img src="<?php echo base_url('assets/site'); ?>/images/promo-banner/promo-3.jpg" alt="Owl Image"></a></div>

                        </div>
                    </div>

                </div>



            </div>
        </section>  
        <!-- HOLIDAY PACKAGE -->

        <section id="holiday-pack" class="wow fadeInUp">

            <div class="container">

                <h2>Holiday package Deals</h2>

                <div class="clearfix"></div>

                <div id="owl-demo-2">

                    <div class="item">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <figure><img src="<?php echo base_url('assets/site'); ?>/images/holiday-pack/img-1.png" class="img-responsive" alt=""></figure>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <h3>Kashmir At Its Best<br><span>(Fixed Departure)</span></h3>
                                <p>Accommodation, Airfare, Sight-seeing, Transfer and More @28,999 perperson for 5 Nights/6 Days</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="item">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <figure><img src="<?php echo base_url('assets/site'); ?>/images/holiday-pack/img-1.png" class="img-responsive" alt=""></figure>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <h3>Kashmir At Its Best<br><span>(Fixed Departure)</span></h3>
                                <p>Accommodation, Airfare, Sight-seeing, Transfer and More @28,999 perperson for 5 Nights/6 Days</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="item">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <figure><img src="<?php echo base_url('assets/site'); ?>/images/holiday-pack/img-1.png" class="img-responsive" alt=""></figure>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <h3>Kashmir At Its Best<br><span>(Fixed Departure)</span></h3>
                                <p>Accommodation, Airfare, Sight-seeing, Transfer and More @28,999 perperson for 5 Nights/6 Days</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>


                    <div class="item">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <figure><img src="<?php echo base_url('assets/site'); ?>/images/holiday-pack/img-1.png" class="img-responsive" alt=""></figure>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <h3>Kashmir At Its Best<br><span>(Fixed Departure)</span></h3>
                                <p>Accommodation, Airfare, Sight-seeing, Transfer and More @28,999 perperson for 5 Nights/6 Days</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="item">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <figure><img src="<?php echo base_url('assets/site'); ?>/images/holiday-pack/img-1.png" class="img-responsive" alt=""></figure>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <h3>Kashmir At Its Best<br><span>(Fixed Departure)</span></h3>
                                <p>Accommodation, Airfare, Sight-seeing, Transfer and More @28,999 perperson for 5 Nights/6 Days</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>


                    <div class="item">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <figure><img src="<?php echo base_url('assets/site'); ?>/images/holiday-pack/img-1.png" class="img-responsive" alt=""></figure>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <h3>Kashmir At Its Best<br><span>(Fixed Departure)</span></h3>
                                <p>Accommodation, Airfare, Sight-seeing, Transfer and More @28,999 perperson for 5 Nights/6 Days</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>


                    <div class="item">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <figure><img src="<?php echo base_url('assets/site'); ?>/images/holiday-pack/img-1.png" class="img-responsive" alt=""></figure>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <h3>Kashmir At Its Best<br><span>(Fixed Departure)</span></h3>
                                <p>Accommodation, Airfare, Sight-seeing, Transfer and More @28,999 perperson for 5 Nights/6 Days</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="item">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <figure><img src="<?php echo base_url('assets/site'); ?>/images/holiday-pack/img-1.png" class="img-responsive" alt=""></figure>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <h3>Kashmir At Its Best<br><span>(Fixed Departure)</span></h3>
                                <p>Accommodation, Airfare, Sight-seeing, Transfer and More @28,999 perperson for 5 Nights/6 Days</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>


                    <div class="item">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <figure><img src="<?php echo base_url('assets/site'); ?>/images/holiday-pack/img-1.png" class="img-responsive" alt=""></figure>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <h3>Kashmir At Its Best<br><span>(Fixed Departure)</span></h3>
                                <p>Accommodation, Airfare, Sight-seeing, Transfer and More @28,999 perperson for 5 Nights/6 Days</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>


                    <div class="item">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <figure><img src="<?php echo base_url('assets/site'); ?>/images/holiday-pack/img-1.png" class="img-responsive" alt=""></figure>
                            </div>
                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                <h3>Kashmir At Its Best<br><span>(Fixed Departure)</span></h3>
                                <p>Accommodation, Airfare, Sight-seeing, Transfer and More @28,999 perperson for 5 Nights/6 Days</p>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                </div>

            </div>

        </section>


        <!-- OUR SERVICES -->

        <section id="services-section" class="wow fadeInUp">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2>OUR SERVICES</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="content-dv">
                            <div class="row">
                                <div class="col-md-2 col-md-push-10 text-center">
                                    <img src="<?php echo base_url('assets/site'); ?>/images/red-recharge-icon.png" alt="">
                                </div>
                                <div class="col-md-10 col-md-pull-2 text-right">
                                    <h3>Fastest & Simple way for online recharge</h3>
                                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna 
                                        aliquyam erat, sed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="content-dv">
                            <div class="row">
                                <div class="col-md-2 text-center">
                                    <img src="<?php echo base_url('assets/site'); ?>/images/red-flight-icon.png" alt="">
                                </div>
                                <div class="col-md-10 text-left">
                                    <h3>Online Flight Booking</h3>
                                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna 
                                        aliquyam erat, sed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="content-dv">
                            <div class="row">

                                <div class="col-md-2 col-md-push-10 text-center">
                                    <img src="<?php echo base_url('assets/site'); ?>/images/red-ticket-icon.png" alt="">
                                </div>

                                <div class="col-md-10 col-md-pull-2 text-right">
                                    <h3>Online Movie Ticket Booking</h3>
                                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna 
                                        aliquyam erat, sed</p>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="content-dv">
                            <div class="row">
                                <div class="col-md-2 text-center">
                                    <img src="<?php echo base_url('assets/site'); ?>/images/red-payment-icon.png" alt="">
                                </div>
                                <div class="col-md-10 text-left">
                                    <h3>Online Bill Payment</h3>
                                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna 
                                        aliquyam erat, sed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>


        <!-- USE NEPZY -->

        <section id="use-nepzy-section" class="wow fadeInUp text-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2>Why Should You Use Nepzy?</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <figure><img src="<?php echo base_url('assets/site'); ?>/images/nefzy-icon.png" width="63" height="69"></figure>
                        <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.</p>
                    </div>
                </div>
            </div>
        </section>



        <!-- SECURE -->

        <section id="secure-section" class="wow fadeInUp">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2>All Your Online Payments are completely safe and secure.</h2>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="content-dv">
                            <div class="row">
                                <div class="col-md-3">
                                    <figure>
                                        <img src="<?php echo base_url('assets/site'); ?>/images/secquriety-1.png" alt="" class="img-responsive">
                                    </figure>
                                </div>
                                <div class="col-md-9">
                                    <h3>Tincidunt mauris</h3>
                                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr,sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="content-dv">
                            <div class="row">
                                <div class="col-md-3">
                                    <figure>
                                        <img src="<?php echo base_url('assets/site'); ?>/images/secquriety-2.png" alt="" class="img-responsive">
                                    </figure>
                                </div>
                                <div class="col-md-9">
                                    <h3>Tincidunt mauris</h3>
                                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr,sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="content-dv">
                            <div class="row">
                                <div class="col-md-3">
                                    <figure>
                                        <img src="<?php echo base_url('assets/site'); ?>/images/secquriety-3.png" alt="" class="img-responsive">
                                    </figure>
                                </div>
                                <div class="col-md-9">
                                    <h3>Tincidunt mauris</h3>
                                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr,sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="content-dv">
                            <div class="row">
                                <div class="col-md-3">
                                    <figure>
                                        <img src="<?php echo base_url('assets/site'); ?>/images/secquriety-4.png" alt="" class="img-responsive">
                                    </figure>
                                </div>
                                <div class="col-md-9">
                                    <h3>Tincidunt mauris</h3>
                                    <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr,sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>



        <!-- ACCREDIATIONS -->
        <section id="accrediation-section">
            <div class="container">
                <div class="row text-center">
                    <div class="col-lg-12">
                        <h2>Accredeations</h2>
                    </div>
                </div>

                <div class="row wow fadeInUp">
                    <div class="col-md-12">


                        <div id="owl-demo">

                            <div class="item"><img src="<?php echo base_url('assets/site'); ?>/images/accridiation/Untitled-1.jpg" alt="Owl Image"></div>
                            <div class="item"><img src="<?php echo base_url('assets/site'); ?>/images/accridiation/Untitled-2.jpg" alt="Owl Image"></div>
                            <div class="item"><img src="<?php echo base_url('assets/site'); ?>/images/accridiation/Untitled-3.jpg" alt="Owl Image"></div>
                            <div class="item"><img src="<?php echo base_url('assets/site'); ?>/images/accridiation/Untitled-4.jpg" alt="Owl Image"></div>
                            <div class="item"><img src="<?php echo base_url('assets/site'); ?>/images/accridiation/Untitled-5.jpg" alt="Owl Image"></div>
                            <div class="item"><img src="<?php echo base_url('assets/site'); ?>/images/accridiation/Untitled-6.jpg" alt="Owl Image"></div>
                            <div class="item"><img src="<?php echo base_url('assets/site'); ?>/images/accridiation/Untitled-1.jpg" alt="Owl Image"></div>
                            <div class="item"><img src="<?php echo base_url('assets/site'); ?>/images/accridiation/Untitled-2.jpg" alt="Owl Image"></div>
                            <div class="item"><img src="<?php echo base_url('assets/site'); ?>/images/accridiation/Untitled-3.jpg" alt="Owl Image"></div>
                            <div class="item"><img src="<?php echo base_url('assets/site'); ?>/images/accridiation/Untitled-4.jpg" alt="Owl Image"></div>
                            <div class="item"><img src="<?php echo base_url('assets/site'); ?>/images/accridiation/Untitled-5.jpg" alt="Owl Image"></div>
                            <div class="item"><img src="<?php echo base_url('assets/site'); ?>/images/accridiation/Untitled-6.jpg" alt="Owl Image"></div>
                            <div class="item"><img src="<?php echo base_url('assets/site'); ?>/images/accridiation/Untitled-1.jpg" alt="Owl Image"></div>
                            <div class="item"><img src="<?php echo base_url('assets/site'); ?>/images/accridiation/Untitled-2.jpg" alt="Owl Image"></div>
                            <div class="item"><img src="<?php echo base_url('assets/site'); ?>/images/accridiation/Untitled-3.jpg" alt="Owl Image"></div>
                            <div class="item"><img src="<?php echo base_url('assets/site'); ?>/images/accridiation/Untitled-4.jpg" alt="Owl Image"></div>
                            <div class="item"><img src="<?php echo base_url('assets/site'); ?>/images/accridiation/Untitled-5.jpg" alt="Owl Image"></div>
                            <div class="item"><img src="<?php echo base_url('assets/site'); ?>/images/accridiation/Untitled-6.jpg" alt="Owl Image"></div>

                        </div>


                    </div>
                </div>


            </div>
        </section>


        <!-- PHONE EMAIL -->
        <section id="phone-email-section">
            <div class="container">
                <div class="row" class="wow fadeInUp">
                    <div class="col-sm-6">
                        <p class="ph"><i class="fa fa-phone"></i> PHONE: 8587078567</p>
                    </div>
                    <div class="col-sm-6">
                        <p class="em"><i class="fa fa-envelope"></i> EMAIL: <a href="mailto:support@nepzy.com">support@nepzy.com</a></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- FOOTER -->
        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <h2>Recharge</h2>
                        <ul class="list-unstyled">
                            <li><a href="#">Mobile Recharge</a></li>
                            <li><a href="#">Land-line</a></li>
                            <li><a href="#">ADSL</a></li>
                            <li><a href="#">Broad Link</a></li>
                            <li><a href="#">Dish Home</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <h2>Flight & Bookings</h2>
                        <ul class="list-unstyled">
                            <li><a href="#">Round Trip</a></li>
                            <li><a href="#">One Way</a></li>
                            <li><a href="#">Cab</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <h2>Movie Tickets</h2>
                        <ul class="list-unstyled">
                            <li><a href="#">Movie Tickets</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-3">
                        <h2>About</h2>
                        <ul class="list-unstyled">
                            <li><a href="#">About Nepzy</a></li>
                            <li><a href="#">Why Nepzy</a></li>
                            <li><a href="#">Our Team</a></li>
                            <li><a href="#">Privacy Policies</a></li>
                            <li><a href="#">Terms & Conditions</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

        <!-- SOCIAL -->

        <section id="social">
            <div class="container">
                <ul class="list-inline text-center">
                    <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                    <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                </ul>
            </div>
        </section>



        <!-- VIEW PLANS POPUP -->

        <!-- Modal -->
        <div class="modal fade plans-modal" id="viewplan" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel"><img src="<?php echo base_url('assets/site'); ?>/images/ncell.jpg" alt=""> <span>Plans</span></h4>
                    </div>
                    <div class="modal-body">
                        <?php foreach ($plans_list as $key => $val): ?>

                            <div class="plans-list">
                                <div class="plans">
                                    <ul class="list-unstyled">
                                        <li>Talktime | <span><?php echo $val['plan_title']; ?></span> <div class="pull-right">Validity  |  <span><?php echo $val['validity']; ?> Days</span></div></li>
                                        <li><hr></li>
                                        <li>Description | <span><?php echo $val['description']; ?></span></li>
                                    </ul>
                                </div>
                                <div class="plan-price">
                                    <a href="#">Rs.<br><span><?php echo $val['plan_amount']; ?></span></a>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- SIGN IN // SIGN UP POPUP -->

        <!-- Modal -->
        <div class="modal fade login" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <div class="clearfix"></div>
                        <div class="row">
                            <?php echo form_open('signin',array('id'=>'signin_form')); ?>
                            <div class="col-sm-5">
                                <div class="login-dv">
                                    <h2 class="text-center">Sign In</h2>
                                    <div class="clearfix"></div>

                                    <div class="form-group">
                                        <input type="text" name="emailid" id="emailid" class="form-control input-lg m-25px-b" placeholder="Email Id or Mobile Number" required="required">
                                    </div>
                                    <div id="msgbx_err" style="display: none"><span>error: </span>User already exist with same name.</div>

                                    <div class="form-group">
                                        <input type="password" name="password" id="password" class="form-control input-lg m-25px-b" placeholder="Password" required="required">
                                    </div>

                                    <div class="form-group text-center">
                                        <input type="submit" name="submit" id="signin" class="btn btn-primary btn-blue m-25px-b" value="Sign In">
                                    </div>

                                    <div class="form-group text-center m-25px-b">
                                        <a href="#">Forgot Password?</a>
                                    </div>


                                    <div class="clearfix"></div>

                                    <div class="login-social text-center m-25px-t">
                                        <ul class="list-inline">
                                            <li class="fb"><a href="#"><i class="fa fa-facebook"></i></a></li>
                                            <li class="tw"><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <div class="col-sm-7">
                                <div class="signup-dv">
                                    <?php echo form_open('signup',array("id"=>"signup_form")); ?>
                                    <h2 class="text-center">Create New Account </h2>
                                    <div class="clearfix"></div>
                                    <div class="form-group">
                                        <input type="text" name="name" id="name" class="form-control input-lg m-25px-b signup_field" placeholder="Name" required="required">
                                    </div>

                                    <div class="form-group">
                                        <input type="email" name="emailId" id="emailId" class="form-control input-lg m-25px-b signup_field" placeholder="Email" required="required">
                                    </div>

                                    <div class="form-group">
                                        <input type="text" name="mobile_number" id="mobile_number" class="form-control input-lg m-25px-b signup_field" placeholder="Mobile Number" required="required">
                                    </div>

                                    <div class="form-group">
                                        <input type="password" name="password" id="password"  class="form-control input-lg m-25px-b signup_field" placeholder="Password" required="required">
                                    </div>

                                    <div class="form-group m-25px-b">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="user_policy" id="user_policy" checked>I have read and understood the <a href="#">terms & conditions</a> and <a href="#">fraud policy</a> and agree to it.
                                            </label>
                                        </div>
                                    </div>


                                    <div class="form-group text-center m-25px-b">
                                        <input type="submit" id="sign_up" class="btn btn-primary btn-blue" value="Sign Up">
                                    </div>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo base_url('assets/site'); ?>/js/bootstrap.min.js"></script>

        <script>
            $('.carousel-1').carousel({
                interval: 3000
            });
        </script> 
        <script src="<?php echo base_url('assets/site'); ?>/js/owl.carousel.js" type="text/javascript"></script>
        <script>
            $(document).ready(function () {

                $("#owl-demo").owlCarousel({
                    autoPlay: 3000, //Set AutoPlay to 3 seconds

                    items: 6,
                    itemsDesktop: [1199, 5],
                    itemsDesktopSmall: [979, 5]

                });

            });


            $(document).ready(function () {

                $("#owl-demo-1").owlCarousel({
                    autoPlay: 3000, //Set AutoPlay to 3 seconds

                    items: 3,
                    itemsDesktop: [1199, 3],
                    itemsDesktopSmall: [979, 3]

                });

            });

            $(document).ready(function () {

                $("#owl-demo-2").owlCarousel({
                    autoPlay: 4000, //Set AutoPlay to 3 seconds

                    items: 3,
                    itemsDesktop: [1199, 3],
                    itemsDesktopSmall: [979, 3]

                });

            });


        </script>

        <!-- Animation onload -->
        <script src="<?php echo base_url('assets/site'); ?>/js/wow.js"></script> 
        <script>
            wow = new WOW(
                    {
                        animateClass: 'animated',
                        offset: 100
                    }
            );
            wow.init();
            $('#moar').click(function () {
                var section = document.createElement('section');
                section.className = 'section--purple wow fadeInDown';
                this.parentNode.insertBefore(section, this);
            });



        </script>
        <!-- Animation onload -->

        <!-- Modal Verticle Center -->

        <script type="text/javascript">
            /* center modal */
            function centerModals() {
                $('.modal').each(function (i) {
                    var $clone = $(this).clone().css('display', 'block').appendTo('body');
                    var top = Math.round(($clone.height() - $clone.find('.modal-content').height()) / 2);
                    top = top > 0 ? top : 0;
                    $clone.remove();
                    $(this).find('.modal-content').css("margin-top", top);
                });
            }
            $('.modal').on('show.bs.modal', centerModals);
            $(window).on('resize', centerModals);
        </script>
        <!-- custom js -->
        <script src="<?php echo base_url('assets/site'); ?>/js/custom.js"></script>
    </body>
</html>