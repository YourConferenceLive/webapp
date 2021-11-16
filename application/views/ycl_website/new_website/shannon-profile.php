<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <!-- Site Title-->
    <title>Shannon Morton - Your Conference Live - One World Presentation Management</title>
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
  </head>
  <body>
    <!-- Page -->
    <div class="page">
      <div id="page-loader">
        <div class="cssload-container">
          <div class="cssload-speeding-wheel"></div>
        </div>
      </div>
      <!-- Page header-->
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
										</li>
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
      <section class="breadcrumbs-custom novi-background bg-cover">
        <div class="container">
          <div class="breadcrumbs-custom__inner">
            <p class="breadcrumbs-custom__title">Profile</p>
            <ul class="breadcrumbs-custom__path">
				<li><a href="<?=base_url()?>">Home</a></li>
            </ul>
          </div>
        </div>
      </section>
      <!-- Team member profile-->
      <section class="section-xl bg-white novi-background bg-cover">
        <div class="container">
          <!-- Profile Corporate-->
          <article class="profile-corporate"><img class="profile-corporate__image" src="<?=base_url()?>ycl_assets/images/homepage_images/shannon-morton-480x362.jpg" alt="" width="886" height="666"/>
            <div class="profile-corporate__caption">
              <p class="profile-corporate__title">Shannon Morton</p>
              <p class="profile-corporate__subtitle">Senior Consultant</p>
              <p>With a successful background in international business, Shannon specializes as a communications consultant, with a focus on international conferences. Fluent in English and Japanese, and conversational in several other languages, Shannon's communication skills are the perfect requisite for designing and organizing online forms and database management systems that intuitively meet the challenges of users from around the world.</p>
              <ul class="list-inline-sm profile-corporate__list">
                <li><a class="icon-sm fa-facebook icon novi-icon" href="#"></a></li>
                <li><a class="icon-sm fa-twitter icon novi-icon" href="#"></a></li>
     
              </ul>
            </div>
          </article>
        </div>
      </section>

      <section class="section-xl bg-white text-center novi-background bg-cover">
        <div class="container">
          <div class="row justify-content-lg-center">
            <div class="col-lg-10 col-xl-8">
              <!-- RD Mailform-->
				<form class="rd-mailform_style-1" data-form-output="form-output-global" data-form-type="contact" method="post" action="<?=base_url()?>testSmtp">
					<input type="text" name="mailto" id="mailto" value="rexterdayuta2@gmail.com" style="display: none">
					<div class="form-wrap form-wrap_icon"><span class="icon novi-icon linear-icon-man"></span>
						<input class="form-input" id="contact-name" type="text" name="name" placeholder="Your name" required>
						<span id="contact-name-error" style="color:red"></span>
					</div>
					<div class="form-wrap form-wrap_icon"><span class="icon novi-icon linear-icon-envelope"></span>
						<input class="form-input" id="contact-email" type="email" name="email" placeholder="Your email" required>
						<span id="contact-email-error" style="color:red"></span>
					</div>
					<div class="form-wrap form-wrap_icon"><span class="icon novi-icon linear-icon-telephone"></span>
						<input class="form-input" id="contact-phone" type="text" name="phone" placeholder="Your phone" required>
						<span id="contact-phone-error" style="color:red"></span>
					</div>
					<div class="form-wrap form-wrap_icon"><span class="icon novi-icon linear-icon-feather"></span>
						<textarea class="form-input" id="contact-message" name="message" placeholder="Tell us about your event" required></textarea>
						<span id="contact-message-error" style="color:red"></span>
					</div>
					<div class="form-wrap form-wrap_icon">
						<div class="g-recaptcha text-center" style="text-align: -webkit-center; display: inline-block" data-sitekey="6LfbHKQZAAAAAA9nhI-4GNOmLakkRGGaBTJgHFbF"></div>
						<div class="gaps-2x"></div>
						<span id="errorcaptcha" style="color:red"></span>
					</div>
					<button class="button button-primary" type="submit" id="reg_login" >send</button>
				</form>
            </div>
          </div>
        </div>
      </section>

      <!-- Page Footer-->
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
            <p class="rights"><span>YCL</span><span>&nbsp;</span><span class="copyright-year"></span>. Design&nbsp;by&nbsp;<a class="link-primary-inverse" href="https:www.owpm.com">OWPM</a></p>
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

	<script>
		var base_url = '<?=base_url()?>';
	</script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="<?=ycl_root?>/ycl_assets/js/homepage_js/contact.js"></script>


  </body>
</html>
