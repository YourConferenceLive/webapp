<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="Athul AK">
	<link rel="icon" href="<?=ycl_root?>/ycl_assets/ycl_icon.png">

	<title><?=$this->project->name?> | Your Conference Live</title>

	<!-- JQuery -->
	<script src="<?=ycl_root?>/vendor_frontend/jquery/jquery-3.5.1.min.js"></script>

	<!-- Bootstrap 4 -->
	<link href="<?=ycl_root?>/vendor_frontend/bootstrap-4.6.0/css/bootstrap.css" rel="stylesheet">
	<script src="<?=ycl_root?>/vendor_frontend/bootstrap-4.6.0/js/bootstrap.js"></script>

	<!-- Font Awesome -->
	<link href="<?=ycl_root?>/vendor_frontend/fontawesome/css/all.css" rel="stylesheet">

	<!-- SweetAlert2 -->
	<link href="<?=ycl_root?>/vendor_frontend/sweetalert2/sweetalert2.css" rel="stylesheet">
	<script src="<?=ycl_root?>/vendor_frontend/sweetalert2/sweetalert2.js"></script>

	<!-- Toastr -->
	<link href="<?=ycl_root?>/vendor_frontend/toastr/toastr.css" rel="stylesheet">
	<script src="<?=ycl_root?>/vendor_frontend/toastr/toastr.js"></script>
	<script src="<?=ycl_root?>/vendor_frontend/toastr/toastr.config.js"></script>


	<!-- Theme style and js -->
	<link href="<?=ycl_root?>/theme_assets/<?=$project->theme?>/css/app.css" rel="stylesheet">
</head>
