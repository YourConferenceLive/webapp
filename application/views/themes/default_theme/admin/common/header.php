<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin | <?=ucfirst($this->router->fetch_class())?></title>
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="<?=ycl_root?>/vendor_frontend/adminlte/plugins/fontawesome-free/css/all.min.css">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="<?=ycl_root?>/vendor_frontend/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?=ycl_root?>/vendor_frontend/adminlte/dist/css/adminlte.min.css">

	<!-- REQUIRED SCRIPTS -->
	<!-- jQuery -->
	<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- overlayScrollbars -->
	<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
	<!-- AdminLTE App -->
	<script src="<?=ycl_root?>/vendor_frontend/adminlte/dist/js/adminlte.js"></script>

</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

	<!-- Preloader -->
	<div class="preloader flex-column justify-content-center align-items-center">
		<img class="animation__wobble" src="<?=ycl_root?>/ycl_assets/ycl_icon.png" alt="YCL Logo">
	</div>

