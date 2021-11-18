<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <!-- Site Title-->
    <title>Your Conference Live</title>
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta charset="utf-8">
    <link rel="icon" href="https://dev.yourconference.live/ycl_assets/ycl_icon.png">
    <!-- Stylesheets-->
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Libre+Franklin:200,300,500,600,300italic">
    <link rel="stylesheet" href="<?=base_url()?>ycl_assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?=base_url()?>ycl_assets/css/style.css">
		<!--[if lt IE 10]>
    <div style="background: #212121; padding: 10px 0; box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3); clear: both; text-align:center; position: relative; z-index:1;"><a href="http://windows.microsoft.com/en-US/internet-explorer/"><img src="<?=base_url()?>ycl_assets/images/homepage_images/ie8-panel/warning_bar_0000_us.jpg" border="0" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today."></a></div>
    <script src="<?=base_url()?>ycl_assets/js/html5shiv.min.js"></script>
		<![endif]-->
	  <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-47271713-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-47271713-3');
</script>

  </head>
  <body>
    <!-- Page -->
    <div class="page">
      <div id="page-loader">
        <div class="cssload-container">
          <div class="cssload-speeding-wheel"></div>
        </div>
      </div>
      <!-- Page Header-->
      <header class="page-header">
        <!-- RD Navbar-->
        <div class="rd-navbar-wrap">
          <nav class="rd-navbar novi-background bg-cover" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-sm-device-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-device-layout="rd-navbar-fixed" data-xl-device-layout="rd-navbar-static" data-xxl-device-layout="rd-navbar-static" data-lg-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static" data-stick-up-clone="false" data-sm-stick-up="true" data-md-stick-up="true" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true" data-lg-stick-up-offset="69px" data-xl-stick-up-offset="1px" data-xxl-stick-up-offset="1px">
            <div class="rd-navbar-inner">
              <!-- RD Navbar Panel -->
              <div class="rd-navbar-panel">
                <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                <!-- RD Navbar Brand-->
                <div class="rd-navbar-brand"><a class="brand-name" href="<?=ycl_base_url?>"><img src="<?=ycl_root?>/ycl_assets/images/homepage_images/ycl_logo_header.png" alt="" width="163" height="40"/></a></div>
              </div>
              <!-- RD Navbar Nav-->
              <div class="rd-navbar-nav-wrap">
                      <ul class="rd-navbar-nav">
                        <li class="active"><a href="<?=base_url()?>">Home</a>
                        </li>
						  <li><a href="<?=base_url()?>services">Services</a>
							  <ul class="rd-navbar-dropdown">
								  <li><a href="<?=base_url()?>webinars">Webinars</a></li>
								  <li><a href="<?=base_url()?>virtual">Virtual Conferences</a></li>
								  <li><a href="<?=base_url()?>hybrid">Hybrid Events</a></li>
                          </ul>
                        </li>
                        <li><a href="<?=ycl_base_url?>contacts">Contact</a>
							<li><a class="brand-name" href="<?=base_url()?>special"><img src="<?=ycl_root?>/ycl_assets/images/homepage_images/first_free.jpg" alt="" width="163" height="40"/></a>
                        </li>
                      </ul>
              </div>
            </div>
          </nav>
        </div>
      </header>
      <!-- Swiper-->
      <section>
        <div class="swiper-container swiper-slider swiper-slider_fullheight" data-simulate-touch="false" data-loop="false" data-autoplay="false">
          <div class="swiper-wrapper">
            <div class="swiper-slide bg-gray-lighter" data-slide-bg="<?=base_url()?>ycl_assets/images/homepage_images/slider-slide-1-1920x980.jpg">
              <div class="swiper-slide-caption text-center" style="margin-top: -450px">
                <div class="container">
                  <h1 data-caption-animate="fadeInUpSmall text-white"> <span>The Future is Now</span></h1>
                  <h3 data-caption-animate="fadeInUpSmall text-white" data-caption-delay="200">Webinars - Virtual Conferences - Hybrid Meetings</h3>
                  <div class="group-lg group-middle"><a class="button button-primary" data-caption-animate="fadeInUpSmall" data-caption-delay="350" href="#section-see-features" data-custom-scroll-to="section-see-features">See Features</a><a class="button button-black" data-caption-animate="fadeInUpSmall" data-caption-delay="350" href="<?=ycl_base_url?>contacts">Contact Us</a></div>
                </div>
              </div>
            </div>
            <div class="swiper-slide swiper-slide_top bg-accent" data-slide-bg="<?=base_url()?>ycl_assets/images/homepage_images/slider-slide-2-1920x980.jpg">
              <div class="swiper-slide-caption">
                <div class="container">
                  <h2 data-caption-animate="fadeInLeftSmall">The Power of Virtual  <br class="d-none d-lg-block"> Discover it with Your Conference Live</h2><a class="button button-gray-light-outline" data-caption-animate="fadeInLeftSmall" data-caption-delay="200" href="#">Contact Us</a>
                </div>
              </div>
            </div>
            <div class="swiper-slide swiper-slide_video context-dark video-bg-overlay">
                    <!-- RD Video-->
                    <div class="vide_bg novi-vide" data-vide-bg="<?=ycl_root?>/ycl_assets/video/ycl_header_video" data-vide-options="posterType: jpg">
                      <div class="swiper-slide-caption text-center">
                        <div class="container">
                          <h2 data-caption-animate="fadeInUpSmall">Built for the future &amp; ready today!</h2>
                          <h5 class="text-width-2 block-centered" data-caption-animate="fadeInUpSmall" data-caption-delay="200">Your Conference Live brings people together for scientific sharing for all kinds of events. We've got a pack of tools for that.</h5>
                          <div class="group-lg group-middle"><a class="button button-black" data-caption-animate="fadeInUpSmall" data-caption-delay="350" href="#section-see-features" data-custom-scroll-to="section-see-features">See Features</a><a class="button button-primary" data-caption-animate="fadeInUpSmall" data-caption-delay="350" href="<?=ycl_base_url?>contacts">Contact Us</a></div>
                        </div>
                      </div>
                    </div>
            </div>
          </div>
          <!-- Swiper Pagination-->
          <div class="swiper-pagination"></div>
          <!-- Swiper Navigation-->
          <div class="swiper-button-prev linear-icon-chevron-left"></div>
          <div class="swiper-button-next linear-icon-chevron-right"></div>
        </div>
      </section>

      <!-- Presentation -->
      <section class="section-xl bg-white text-center novi-background bg-cover" id="section-see-features">
        <div class="container">
          <div class="row row-fix justify-content-lg-center">
            <div class="col-lg-10 col-xl-8">
              <h3>Solutions for Every Event</h3>
              <p>If "pivot" was the word for 2020, then "flexibility" is where we are looking forward from here. Your Conference Live has the most modern and flexible solutions, with the experience and track record you need to take your event to where it needs to go. </p>
            </div>
          </div>
        </div>
      </section>

      <!-- The Power of YCL's Toolkit-->
      <section class="bg-gray-lighter object-wrap novi-background bg-cover">
        <div class="section-xxl section-xxl_bigger">
          <div class="container">
            <div class="row row-fix">
              <div class="col-lg-5">
                <h3>Engagement is the key</h3>
                <p>Our platform was created by top industry leaders in presentation management to improve audience engagement and loyalty with simple, friendly tools. Your Conference Live knows the take-aways we all benefit from. Whether its the learning and CME credits for the attendees or the insight gleaned from polling and metadata for you, the YCL platform is the perfect place for gathering and collaboration.</p>
              </div>
            </div>
          </div>
        </div>
        <div class="object-wrap__body object-wrap__body-sizing-1 object-wrap__body-md-right bg-image novi-background custom-bg-image" style="background-image: url(<?=base_url()?>ycl_assets/images/homepage_images/2.jpg)"></div>
      </section>

      <!-- Content Driven Platform-->
      <section class="section-xl bg-white novi-background bg-cover novi-background bg-cover">
        <div class="container">
          <div class="row justify-content-md-center flex-lg-row-reverse align-items-lg-center justify-content-lg-between row-50">
            <div class="col-md-9 col-lg-5">
              <h3>Content Driven Platform</h3>
              <p>Unlike many other webinar platforms, Your Conference Live is built around user content, not vice versa. We don't let the 'medium' interfere with the message to your audience or learner group.</p>
            </div>
            <div class="col-md-9 col-lg-6"><img src="<?=base_url()?>ycl_assets/images/homepage_images/3.png" alt="" width="652" height="491"/>
            </div>
          </div>
        </div>
      </section>

      <!-- Blurbs-->
      <section class="section-xl bg-gray-lighter novi-background bg-cover">
        <div class="container">
          <div class="row row-50">
            <div class="col-md-6 col-lg-4">
              <!-- Blurb minimal-->
              <article class="blurb blurb-minimal">
                <div class="unit flex-row unit-spacing-md">
                  <div class="unit-left">
                    <div class="blurb-minimal__icon"><span class="novi-icon icon linear-icon-magic-wand"></span></div>
                  </div>
                  <div class="unit-body">
                    <p class="blurb__title">Scalable Technology</p>
                    <p>YCL is perfect for meetings of any size, whether it be for 10 or 10,000 attendees.&nbsp; No matter the size of your event, our unique program with its powerful awareness and analytics tools provide the confidence you need to have a successful meeting. </p>
                  </div>
                </div>
              </article>
            </div>
            <div class="col-md-6 col-lg-4">
              <!-- Blurb minimal-->
              <article class="blurb blurb-minimal">
                <div class="unit flex-row unit-spacing-md">
                  <div class="unit-left">
                    <div class="blurb-minimal__icon"><span class="novi-icon icon linear-icon-menu3"></span></div>
                  </div>
                  <div class="unit-body">
                    <p class="blurb__title">Real-Time Interaction</p>
                    <p>Our broadcast is the fastest in the industry. With YCL there's none of that long lag at the end of a poll while the audience waits for the results to show. </p>
                  </div>
                </div>
              </article>
            </div>
            <div class="col-md-6 col-lg-4">
              <!-- Blurb minimal-->
              <article class="blurb blurb-minimal">
                <div class="unit flex-row unit-spacing-md">
                  <div class="unit-left">
                    <div class="blurb-minimal__icon"><span class="novi-icon icon linear-icon-users2"></span></div>
                  </div>
                  <div class="unit-body">
                    <p class="blurb__title">Made for Humans</p>
                    <p>YCL technology doesn't come between people. In fact, our virtual platform gives people more opportunity for collaboration than anyone else. User-friendly controls make getting started the easiest thing you could imagine. With YCL your meetings are all about people.</p>
                  </div>
                </div>
              </article>
            </div>
          </div>
        </div>
      </section>

      <!-- GPL3 License advantages-->
      <section class="section-xl bg-white novi-background bg-cover">
        <div class="container">
          <div class="row row-fix row-50 align-items-lg-center justify-content-lg-between">
            <div class="col-lg-5">
              <h3>Control Your Future</h3>
              <p>YCL gives you the ultimate set of tools to communicate efficiently and effectively with your membership, either online or onsite, or both. All on one integrated platform. No need to consolidate data, that is all done automatically.</p>
            </div>
            <div class="col-lg-6">
              <div class="row gallery-wrap">
                <div class="col-6"><img src="<?=base_url()?>ycl_assets/images/homepage_images/4.png" alt="" width="301" height="227"/>
                </div>
                <div class="col-6"><img src="<?=base_url()?>ycl_assets/images/homepage_images/5.png" alt="" width="301" height="227"/>
                </div>
                <div class="col-6"><img src="<?=base_url()?>ycl_assets/images/homepage_images/6.png" alt="" width="301" height="227"/>
                </div>
                <div class="col-6"><img src="<?=base_url()?>ycl_assets/images/homepage_images/7.png" alt="" width="301" height="227"/>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section class="bg-gray-dark text-center">
              <!-- RD Parallax-->
              <div class="parallax-container bg-image rd-parallax-light" data-parallax-img="<?=base_url()?>ycl_assets/images/homepage_images/8.png">
                <div class="parallax-content">
                  <div class="container section-xxl">
                    <h2>Picture Your Next Event</h2>
                    <p>Do you want to see a polished, professional experience for every participant?</p><a class="button button-primary" href="<?=ycl_base_url?>contacts">Call Us</a>
                  </div>
                </div>
              </div>
      </section>

      <section class="section-xl bg-white text-center novi-background bg-cover">
        <div class="container">
          <div class="row row-30 justify-content-lg-center">
            <div class="col-lg-11 col-xl-9">
              <h3>Your Conference Live</h3>
              <p>YCL is made up of technicians, developers, designers, producers, and writers with a single goal: to produce the best event experience possible. Always striving for new possibilities, YCL is driven by a uniquely talented and inspired management team.</p>
            </div>
          </div>
          <div class="row row-50 offset-top-1">
            <div class="col-md-6 col-lg-4">
              <!-- Thumb corporate-->
              <div class="thumb thumb-corporate">
                <div class="thumb-corporate__main"><img src="<?=ycl_root?>/ycl_assets/images/homepage_images/mark-rosenthal-480x362.jpg" alt="" width="480" height="362"/>
                  <div class="thumb-corporate__overlay">
                    <ul class="list-inline-sm thumb-corporate__list">
                      <li><a class="icon-sm fa-facebook icon novi-icon" href="#"></a></li>
                      <li><a class="icon-sm fa-twitter icon novi-icon" href="#"></a></li>

                    </ul>
                  </div>
                </div>
                <div class="thumb-corporate__caption">
                  <p class="thumb__title"><a href="<?=base_url()?>markprofile">Mark Rosenthal</a></p>
                  <p class="thumb__subtitle">Senior Consultant</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4">
              <!-- Thumb corporate-->
              <div class="thumb thumb-corporate">
                <div class="thumb-corporate__main"><img src="<?=base_url()?>ycl_assets/images/homepage_images/shannon-morton-480x362.jpg" alt="" width="480" height="362"/>
                  <div class="thumb-corporate__overlay">
                    <ul class="list-inline-sm thumb-corporate__list">
                      <li><a class="icon-sm fa-facebook icon novi-icon" href="#"></a></li>
                      <li><a class="icon-sm fa-twitter icon novi-icon" href="#"></a></li>

                    </ul>
                  </div>
                </div>
                <div class="thumb-corporate__caption">
                  <p class="thumb__title"><a href="<?=base_url()?>shannonprofile">Shannon Morton</a></p>
                  <p class="thumb__subtitle">Senior Consultant</p>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-4">
              <!-- Thumb corporate-->
              <div class="thumb thumb-corporate">
                <div class="thumb-corporate__main"><img src="<?=base_url()?>ycl_assets/images/homepage_images/mishka-480x362.jpg" alt="" width="418" height="315"/>
                  <div class="thumb-corporate__overlay">
                    <ul class="list-inline-sm thumb-corporate__list">
                      <li><a class="icon-sm fa-facebook icon novi-icon" href="#"></a></li>
                      <li><a class="icon-sm fa-twitter icon novi-icon" href="#"></a></li>

                    </ul>
                  </div>
                </div>
                <div class="thumb-corporate__caption">
                  <p class="thumb__title"><a href="<?=base_url()?>mishkaprofile">Mishka Ishwarpesad</a></p>
                  <p class="thumb__subtitle">Production</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Gallery-->
      <section class="section-xl bg-white novi-background novi-section no" data-lightgallery="group">
        <div class="container-fluid">
          <div class="row row-10 row-horizontal-10">
            <div class="col-md-4 col-xl-3"> <a class="thumb-modern" data-lightgallery="item" href="<?=base_url()?>ycl_assets/images/homepage_images/12.png">
                <figure><img src="<?=base_url()?>ycl_assets/images/homepage_images/12.png" alt="" width="472" height="355"/>
                </figure>
                <div class="thumb-modern__overlay"></div></a></div>
            <div class="col-md-4 col-xl-3"><a class="thumb-modern" data-lightgallery="item" href="<?=base_url()?>ycl_assets/images/homepage_images/13.png">
                <figure><img src="<?=base_url()?>ycl_assets/images/homepage_images/13.png" alt="" width="472" height="355"/>
                </figure>
                <div class="thumb-modern__overlay"></div></a></div>
            <div class="col-md-4 col-xl-3"><a class="thumb-modern" data-lightgallery="item" href="<?=base_url()?>ycl_assets/images/homepage_images/14.png">
                <figure><img src="<?=base_url()?>ycl_assets/images/homepage_images/14.png" alt="" width="472" height="355"/>
                </figure>
                <div class="thumb-modern__overlay"></div></a></div>
            <div class="col-md-4 col-xl-3"><a class="thumb-modern" data-lightgallery="item" href="<?=base_url()?>ycl_assets/images/homepage_images/15.png">
                <figure><img src="<?=base_url()?>ycl_assets/images/homepage_images/15.png" alt="" width="472" height="355"/>
                </figure>
                <div class="thumb-modern__overlay"></div></a></div>
            <div class="col-md-4 col-xl-3"><a class="thumb-modern" data-lightgallery="item" href="<?=base_url()?>ycl_assets/images/homepage_images/17_L.jpg">
                <figure><img src="<?=base_url()?>ycl_assets/images/homepage_images/17.png" alt="" width="472" height="355"/>
                </figure>
                <div class="thumb-modern__overlay"></div></a></div>
            <div class="col-md-4 col-xl-3"><a class="thumb-modern" data-lightgallery="item" href="<?=base_url()?>ycl_assets/images/homepage_images/16.png">
                <figure><img src="<?=base_url()?>ycl_assets/images/homepage_images/16.png" alt="" width="472" height="355"/>
                </figure>
                <div class="thumb-modern__overlay"></div></a></div>
            <div class="col-md-4 col-xl-3"><a class="thumb-modern" data-lightgallery="item" href="<?=base_url()?>ycl_assets/images/homepage_images/18.png">
                <figure><img src="<?=base_url()?>ycl_assets/images/homepage_images/18.png" alt="" width="472" height="355"/>
                </figure>
                <div class="thumb-modern__overlay"></div></a></div>
            <div class="col-md-4 col-xl-3"><a class="thumb-modern" data-lightgallery="item" href="<?=base_url()?>ycl_assets/images/homepage_images/19.png">
                <figure><img src="<?=base_url()?>ycl_assets/images/homepage_images/19.png" alt="" width="472" height="355"/>
                </figure>
                <div class="thumb-modern__overlay"></div></a></div>
          </div>
        </div>
      </section>

      <!-- Post Your Latest News-->
      <section class="section-xl bg-white novi-background bg-cover text-center">
        <div class="container">
          <h3>Cool Solutions</h3>
          <div class="row row-50">
            <div class="col-md-6 col-xl-4">
              <!-- Post classic-->
              <article class="post-minimal"><img src="<?=base_url()?>ycl_assets/images/homepage_images/post-minimal-1-418x315.jpg" alt="" width="418" height="315"/>
                <div class="post-classic-title">
                  <h5><a href="<?=base_url()?>webinars">Webinars</a></h5>
                </div>
                <div class="post-meta">
                  <div class="post-classic-body">
					  <time datetime="2017"></time></a><span>Live and On-Demand</span></div>
                </div>
                <div class="post-classic-body">
                  <p>Specialists in Life Sciences seminars and panel discussions. CME ready learning measurement and time keeping.</p>
                </div>
                <div class="post-minimal-footer"><a class="button button-link" href="<?=base_url()?>webinars">read more</a></div>
              </article>
            </div>
            <div class="col-md-6 col-xl-4">
              <!-- Post classic-->
              <article class="post-minimal"><img src="<?=base_url()?>ycl_assets/images/homepage_images/post-minimal-5-418x315.jpg" alt="" width="418" height="315"/>
                <div class="post-classic-title">
                  <h5><a href="<?=base_url()?>virtual">Virtual Conference</a></h5>
                </div>
                <div class="post-meta">
                  <div class="post-classic-body">
                      <time datetime="2017"></time></a><span>Regional, National and Global</span></div>
                </div>
                <div class="post-classic-body">
                  <p>Made popular over the past year, virtual conferences are here to stay. Economical and inclusive, the YCL virtual platform, either 2D or3D, is the perfect meeting space for conferences of all sizes.</p>
                </div>
                <div class="post-minimal-footer"><a class="button button-link" href="<?=base_url()?>virtual">read more</a></div>
              </article>
            </div>
            <div class="col-md-6 col-xl-4">
              <!-- Post classic-->
              <article class="post-minimal"><img src="<?=base_url()?>ycl_assets/images/homepage_images/post-minimal-2-418x315.jpg" alt="" width="418" height="315"/>
                <div class="post-classic-title">
                  <h5><a href="<?=base_url()?>hybrid"">Hybrid Meetings</a></h5>
                </div>
                <div class="post-meta">
                  <div class="post-classic-body">
                      <time datetime="2017"></time></a><span>Total Integration</span></div>
                </div>
                <div class="post-classic-body">
                  <p>Ensure the highest degree of participation at your next event. Our onsite app seamlessly integrates with the online participants. Polling, Q&A, Chats are simultaneously available to all. Analytics are instant and comprehensive.</p>
                </div>
                <div class="post-minimal-footer"><a class="button button-link" href="<?=base_url()?>hybrid">read more</a></div>
              </article>
            </div>
          </div>
        </div>
      </section>


      </section>

      <section class="bg-accent novi-background bg-cover">
        <div class="container">
          <div class="row row-fix justify-content-md-center align-items-lg-end">
            <div class="col-md-8 col-lg-6 section-xl">
              <h3>What's Important to You?</h3>
              <p>Analytics? Collaboration? Ease of Use? </p>YCL has everything to get you covered. Producers, technicians, and global reach, all on the fastest platform you will find. </p><a class="button button-gray-light-outline" href="contacts">Begin Your Future Now</a>
            </div>
            <div class="col-md-8 col-lg-6">
              <div class="cat-img-group">
                <div><img src="<?=base_url()?>ycl_assets/images/homepage_images/cat-2-507x508.jpg" alt="" width="507" height="508"/>
                </div>
                <div><img src="<?=base_url()?>ycl_assets/images/homepage_images/cat-1-326x427.jpg" alt="" width="326" height="427"/>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- Subscribe form-->
      <section class="section-xl bg-white text-center novi-background bg-cover">
        <div class="container">
          <h5>Don't wait to get started! Tell us about your next meeting.<br> </h5>
   <a class="button button-gray-light-outline" data-caption-animate="fadeInLeftSmall" data-caption-delay="200" href="<?=ycl_base_url?>contacts">Contact Us</a>
        </div>
      </section>

      <!-- Page Footer -->
      <section class="pre-footer-corporate novi-background bg-cover">
        <div class="container">
          <div class="row justify-content-sm-center justify-content-lg-start row-30 row-md-60">
            <div class="col-sm-10 col-md-6 col-lg-10 col-xl-3">
              <h6>About</h6>
              <p>Your Conference DOT Live is created and owned by One World Presentation Management Ltd., the world leader in innovative presentation management solutions for life science conferences.</p>
            </div>
            <div class="col-sm-10 col-md-6 col-lg-3 col-xl-3">
              <h6>Products</h6>
              <ul class="list-xxs">
                <li><a href="<?=base_url()?>webinars">Webinars</a></li>
              <li><a href="<?=base_url()?>virtual">Virtual Conferences</a></li>
                <li><a href="<?=base_url()?>hybrid">Hybrid Events</a></li>
              </ul>
            </div>
            
            <div class="col-sm-10 col-md-6 col-lg-4 col-xl-3">
              <h6>Bricks & Mortar</h6>
              <ul class="list-xs">
                <li>
                  <dl class="list-terms-minimal">
                    <dt>Location:</dt>
                    <dd>Vancouver, BC, Canada</dd>
                  </dl>
                </li>
                <li>
                  <dl class="list-terms-minimal">
                    <dt>Toll free:</dt>
                    <dd>
                      <ul class="list-semicolon">
                        <li><a href="tel:#">(800) 952-3259</a></li>
                        
                      </ul>
                    </dd>
                  </dl>
                </li>
                <li>
                  <dl class="list-terms-minimal">
                    <dt>E-mail</dt>
                    <dd><a href="mailto:#">info@yourconference.live</a></dd>
                  </dl>
                </li>
                <li>
                  <dl class="list-terms-minimal">
                    <dt>We are open</dt>
                    <dd>Mn-Fr: 10 am-8 pm</dd>
                  </dl>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </section>

      <footer class="footer-corporate novi-background bg-cover">
        <div class="container">
          <div class="footer-corporate__inner">
            <p class="rights"><span>YCL</span><span>&nbsp;</span><span class="copyright-year"></span>. Design&nbsp;by&nbsp;<a class="link-primary-inverse" href="https://www.owpm.com">OWPM</a></p>
            <ul class="list-inline-xxs">
              <li><a class="novi-icon icon icon-xxs icon-primary fa fa-facebook" href="#"></a></li>
              <li><a class="novi-icon icon icon-xxs icon-primary fa fa-twitter" href="#"></a></li>
   
            </ul>
          </div>
        </div>
      </footer>
    </div>
    <!-- Global Mailform Output-->
    <div class="snackbars" id="form-output-global"></div>
    <!-- Javascript-->
    <script src="<?=ycl_root?>/ycl_assets/js/homepage_js/core.min.js"></script>
    <script src="<?=ycl_root?>/ycl_assets/js/homepage_js/script.js"></script>
  </body>
</html>
