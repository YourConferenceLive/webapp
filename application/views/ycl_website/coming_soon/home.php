<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Your Conference Live</title>
	<link rel="shortcut icon" href="<?=ycl_root?>/ycl_assets/ycl_Icon.png" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Your Conference Live" />
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	<!-- CSS -->
	<link href="<?=ycl_root?>/vendor_frontend/fontawesome/css/all.css" rel="stylesheet"><!-- Font-awesome-CSS -->
	<!-- //CSS -->
	<!-- Fonts -->
	<link href="//fonts.googleapis.com/css?family=Josefin+Sans:100,100i,300,300i,400,400i,600,600i,700,700i&amp;subset=latin-ext" rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Oswald:200,300,400,500,600,700&amp;subset=cyrillic,latin-ext,vietnamese" rel="stylesheet">
	<!-- Fonts -->

	<style>
		html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,dl,dt,dd,ol,nav ul,nav li,fieldset,form,label,legend,table,caption,tbody,tfoot,thead,tr,th,td,article,aside,canvas,details,embed,figure,figcaption,footer,header,hgroup,menu,nav,output,ruby,section,summary,time,mark,audio,video{margin:0;padding:0;border:0;font-size:100%;font:inherit;vertical-align:baseline;}
		article, aside, details, figcaption, figure,footer, header, hgroup, menu, nav, section {display: block;}
		ol,ul{list-style:none;margin:0px;padding:0px;}
		blockquote,q{quotes:none;}
		blockquote:before,blockquote:after,q:before,q:after{content:'';content:none;}
		table{border-collapse:collapse;border-spacing:0;}
		/* start editing from here */
		a{text-decoration:none;}
		.txt-rt{text-align:right;}/* text align right */
		.txt-lt{text-align:left;}/* text align left */
		.txt-center{text-align:center;}/* text align center */
		.float-rt{float:right;}/* float right */
		.float-lt{float:left;}/* float left */
		.clear{clear:both;}/* clear float */
		.pos-relative{position:relative;}/* Position Relative */
		.pos-absolute{position:absolute;}/* Position Absolute */
		.vertical-base{	vertical-align:baseline;}/* vertical align baseline */
		.vertical-top{	vertical-align:top;}/* vertical align top */
		nav.vertical ul li{	display:block;}/* vertical menu */
		nav.horizontal ul li{	display: inline-block;}/* horizontal menu */
		img{max-width:100%;}
		/*end reset*/
		body {
			background: url(<?=base_url()?>ycl_assets/coming_soon/background.jpg)no-repeat center top;
			background-size: cover;
			-webkit-background-size: cover;
			-moz-background-size: cover;
			-o-background-size: cover;
			-ms-background-size: cover;
			background-attachment: fixed;
			background-position: center;
			text-align: center;
			font-family: 'Oswald', sans-serif;
			position: relative;

		}
		.main-w3layouts {
			position: absolute;
			top: 0;
			left: 21%;
			width: 55%;
			margin-top: 100px;
		}

		/* ---- particles.js container ---- */

		#particles-js{
			width: 100%;
			background-image: url('');
			background-size: cover;
			background-position: 50% 50%;
			background-repeat: no-repeat;
		}
		canvas.particles-js-canvas-el {
			height: 789px!important;
		}
		/*--//parallax-js--*/
		.main-agile h2 {
			font-size: 5em;
			text-align: center;
			text-transform: uppercase;
			letter-spacing: 4px;
			color: #fff;
			font-weight: 600;
			text-shadow: 1px 1px 2px #000;
		}
		.w3layouts-newsletter h2 {
			font-size: 3em;
			letter-spacing: 2px;
			color: cornflowerblue;
		}
		.w3layouts-newsletter p {
			font-size: 1.3em;
			letter-spacing: 1px;
			font-family: 'Josefin Sans', sans-serif;
			width: 70%;
			margin: 1.5em auto;
			line-height: 1.6;
			color: #fff;
		}
		.main-agile {
			margin: 5em 0 7em;
		}
		.main-agile p {
			color: #fff;
			width: 59%;
			text-align: center;
			margin: 2em auto 1.5em;
			line-height: 30px;
			font-size: 1.1em;
			font-weight: 200;
			letter-spacing: 2px;
		}
		.content-wthree {
			padding: 50px 50px;
			text-align: center;
			position: relative;
		}
		.main-w3layouts h1 {
			color: #fff;
			font-size: 4em;
			letter-spacing: 3px;
			margin: .55em 0;
			font-family: 'Josefin Sans', sans-serif;
		}
		.w3layouts-newsletter form {
			width: 75%;
			margin: 2em auto 0;
		}
		.w3layouts-newsletter input[type="email"] {
			padding: .8em 1em;
			width: 65%;
			letter-spacing: 1px;
			font-size: 1em;
			color: #fff;
			outline: none;
			border: 4px double #ff0c9e;
			background: none;
			float: left;
		}
		.w3layouts-newsletter input[type="submit"] {
			color: #fff;
			font-size: .9em;
			border: none;
			background:#f5d12b;
			padding: 1.25em 3.5em;
			outline: none;
			cursor: pointer;
			transition: 0.5s all;
			-webkit-transition: 0.5s all;
			-moz-transition: 0.5s all;
			-ms-transition: 0.5s all;
			-o-transition: 0.5s all;
			float: left;
			letter-spacing: 1px;
			transition:0.5s all;
			-webkit-transition:0.5s all;
			-moz-transition:0.5s all;
			-ms-transition:0.5s all;
			-o-transition:0.5s all;
		}
		.w3layouts-newsletter input[type="submit"]:hover {
			background: #ff0c9e;
			transition:0.5s all;
			-webkit-transition:0.5s all;
			-moz-transition:0.5s all;
			-ms-transition:0.5s all;
			-o-transition:0.5s all;
		}
		.w3layouts-newsletter img {
			width: 25%;
		}
		.w3layouts-newsletter {
			padding: 3em 1em 4em;
		}
		/*--//footer--*/
		.footer-w3l p {
			font-size: 1em;
			letter-spacing: 3px;
			padding: 2em 0;
			color:#fff;
		}
		.footer-w3l p a{
			color:#fff;
		}
		.footer-w3l p a:hover{
			text-decoration:underline;
		}
		/*--//footer--*/

		/*--responsive--*/
		@media(max-width: 1680px){

		}
		@media(max-width: 1600px){

		}
		@media(max-width: 1440px){
			.w3layouts-newsletter form {
				width: 82%;
			}
			.w3layouts-newsletter p {
				width: 80%;
			}
		}
		@media(max-width: 1366px){
			.w3layouts-newsletter form {
				width: 90%;
			}
		}
		@media(max-width: 1280px){
			.w3layouts-newsletter p {
				width: 90%;
			}
			.main-w3layouts h1 {
				font-size: 3.5em;
				margin: .5em 0;
			}
			.w3layouts-newsletter h2 {
				font-size: 2.8em;
			}
			.w3layouts-newsletter {
				padding: 2em 1em 3em;
			}
			canvas.particles-js-canvas-el {
				height: 704px!important
			}
			.main-w3layouts {
				left: 20%;
				width: 60%;
			}
		}
		@media(max-width: 1080px){
			.main-w3layouts {
				left: 15%;
				width: 70%;
			}
		}
		@media(max-width: 1050px){
			.main-w3layouts {
				left: 14%;
			}
		}
		@media(max-width: 1024px){
			.main-w3layouts {
				left: 13%;
				width: 72%;
			}
		}
		@media(max-width: 991px){
			.main-w3layouts h1 {
				font-size: 3.3em;
			}
			.w3layouts-newsletter h2 {
				font-size: 2.6em;
			}
			.w3layouts-newsletter input[type="email"] {
				width: 64%;
			}
			.w3layouts-newsletter {
				padding: 1.5em 1em 2em;
			}
			canvas.particles-js-canvas-el {
				height: 664px!important;
			}
		}
		@media(max-width: 900px){
			.main-w3layouts {
				left: 10%;
				width: 79%;
			}
		}
		@media(max-width: 800px){
			.main-w3layouts h1 {
				font-size: 3.2em;
			}
			.w3layouts-newsletter h2 {
				font-size: 2.3em;
			}
			.w3layouts-newsletter input[type="submit"] {
				padding: 1.25em 3em;
			}
			.w3layouts-newsletter input[type="email"] {
				width: 62%;
			}
			.footer-w3l p {
				letter-spacing: 2px;
				padding: 1.5em 0;
			}
			canvas.particles-js-canvas-el {
				height: 632px!important;
			}
		}
		@media(max-width: 768px){
			.main-w3layouts {
				left: 9%;
				width: 81%;
			}
			.main-w3layouts h1 {
				margin: 1em 0;
			}
			.footer-w3l p {
				padding: 5em 0;
			}
			canvas.particles-js-canvas-el {
				height: 909px!important;
			}
			.w3layouts-newsletter input[type="email"] {
				width: 61%;
			}
		}
		@media(max-width: 736px){
			.main-w3layouts h1 {
				margin: .4em 0;
				font-size: 3em;
			}
			.w3layouts-newsletter h2 {
				font-size: 2.2em;
			}
			.w3layouts-newsletter p {
				font-size: 1.2em;
			}
			.w3layouts-newsletter img {
				width: 28%;
			}
			.w3layouts-newsletter input[type="submit"] {
				padding: 1.25em 2.7em;
			}
			.footer-w3l p {
				padding: 2.5em 0;
			}
			canvas.particles-js-canvas-el {
				height: 600px!important;
			}
		}
		@media(max-width: 667px){
			.main-w3layouts h1 {
				font-size: 2.8em;
			}
			.w3layouts-newsletter h2 {
				font-size: 2em;
			}
			.w3layouts-newsletter p {
				width: 100%;
			}
			.main-w3layouts {
				left: 7%;
				width: 89%;
			}
			canvas.particles-js-canvas-el {
				height: 581px!important;
			}
			.footer-w3l p {
				padding: 1.5em 0;
			}
		}
		@media(max-width: 640px){
			.main-w3layouts {
				left: 4%;
				width: 93%;
			}
		}
		@media(max-width: 600px){
			.w3layouts-newsletter input[type="email"] {
				width: 58%;
			}
			.footer-w3l p {
				line-height: 2;
			}
			.w3layouts-newsletter {
				padding: 1em 1em 2em;
			}
		}
		@media(max-width: 568px){
			.w3layouts-newsletter input[type="submit"] {
				padding: 1.25em 2.3em;
			}
		}
		@media(max-width: 480px){
			.main-w3layouts h1 {
				font-size: 2.5em;
				letter-spacing: 2px;
			}
			.w3layouts-newsletter h2 {
				letter-spacing: 1px;
			}
			.w3layouts-newsletter {
				padding: .8em 1em 1.5em;
			}
			.w3layouts-newsletter h2 {
				font-size: 1.75em;
			}
			.w3layouts-newsletter p {
				font-size: 1.1em;
			}
			.w3layouts-newsletter img {
				width: 38%;
			}
			.w3layouts-newsletter input[type="email"] {
				font-size: .9em;
			}
			.w3layouts-newsletter input[type="submit"] {
				padding: 1.1em 1.4em;
			}
		}
		@media(max-width: 440px){
			.main-w3layouts h1 {
				font-size: 2.3em;
				letter-spacing: 1px;
			}
			.w3layouts-newsletter h2 {
				font-size: 1.65em;
			}
			.w3layouts-newsletter input[type="email"] {
				width: 53%;
			}
		}
		@media(max-width: 414px){
			.w3layouts-newsletter input[type="submit"] {
				font-size: .85em;
				padding: 1.2em 1.4em;
			}
			.main-w3layouts {
				left: 2%;
				width: 95%;
			}
			.main-w3layouts h1 {
				margin: 1.4em 0 .8em;
			}
			.w3layouts-newsletter input[type="email"] {
				width: 52%;
			}
		}
		@media(max-width: 384px){
			.main-w3layouts h1 {
				margin: 1em 0 .4em;
				font-size: 2em;
			}
			.w3layouts-newsletter h2 {
				font-size: 1.4em;
			}
			.w3layouts-newsletter input[type="submit"] {
				padding: 1.2em 1em;
			}
			.footer-w3l p {
				font-size: .9em;
			}
		}
		@media(max-width: 375px){
			.w3layouts-newsletter {
				padding: .8em 0em 1.5em;
			}
			.main-w3layouts h1 {
				margin: 1.2em 0 .4em;
			}
		}
		@media(max-width: 320px){
			.main-w3layouts h1 {
				margin: .7em 0 .3em;
				font-size: 1.8em;
			}
			.w3layouts-newsletter h2 {
				font-size: 1.25em;
			}
			.w3layouts-newsletter p {
				font-size: 1em;
			}
			.w3layouts-newsletter input[type="email"] {
				padding: .7em 1em;
				font-size: .8em;
			}
			.w3layouts-newsletter input[type="submit"] {
				padding: 1.04em 1em;
				font-size: .8em;
			}
			.footer-w3l p {
				font-size: .8em;
				padding: 1em 0;
			}
			canvas.particles-js-canvas-el {
				height: 487px!important;
			}
		}
	</style>


</head>
<body>
<div id="particles-js"></div>
<div class="main-w3layouts">
	<img src="<?=ycl_root?>/ycl_assets/ycl_logo.png" width="250px">
	<h1>Your Conference Live</h1>
	<div class="w3layouts-newsletter">
		<h2>Coming Soon</h2>
		<p>Our website is under construction, we are working very hard to give you the best experience.</p>
	</div>
	<div class="footer-w3l">
		<p class="agileinfo"> &copy; Your Conference Live</p>
	</div>
</div>

<!-- Js-Files -->
<script src="<?=ycl_root?>/vendor_frontend/particlesjs/particles.js"></script>
<script>
    particlesJS('particles-js',

        {
            "particles": {
                "number": {
                    "value": 80,
                    "density": {
                        "enable": true,
                        "value_area": 800
                    }
                },
                "color": {
                    "value": "#ffffff"
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    },
                    "image": {
                        "src": "img/github.svg",
                        "width": 100,
                        "height": 100
                    }
                },
                "opacity": {
                    "value": 0.5,
                    "random": false,
                    "anim": {
                        "enable": false,
                        "speed": 1,
                        "opacity_min": 0.1,
                        "sync": false
                    }
                },
                "size": {
                    "value": 5,
                    "random": true,
                    "anim": {
                        "enable": false,
                        "speed": 40,
                        "size_min": 0.1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#ffffff",
                    "opacity": 0.4,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 6,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "attract": {
                        "enable": false,
                        "rotateX": 600,
                        "rotateY": 1200
                    }
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "repulse"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 400,
                        "line_linked": {
                            "opacity": 1
                        }
                    },
                    "bubble": {
                        "distance": 400,
                        "size": 40,
                        "duration": 2,
                        "opacity": 8,
                        "speed": 3
                    },
                    "repulse": {
                        "distance": 200
                    },
                    "push": {
                        "particles_nb": 4
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect": true,
            "config_demo": {
                "hide_card": false,
                "background_color": "#b61924",
                "background_image": "",
                "background_position": "50% 50%",
                "background_repeat": "no-repeat",
                "background_size": "cover"
            }
        }

    );
</script>
<!--<script src="js/app.js"></script>-->
<!-- //Js-Files -->

</body>
</html>
