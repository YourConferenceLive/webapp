<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">
<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="Athul AK">
	<link rel="icon" href="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/project_icon.ico">
	<title>Admin | <?=ucfirst($this->router->fetch_class())?></title>
	<!-- Google Font: Source Sans Pro -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;1,200;1,300;1,400&display=swap" rel="stylesheet">
	<!-- Font Awesome Icons -->
	<link rel="stylesheet" href="<?=ycl_root?>/vendor_frontend/adminlte/plugins/fontawesome-free/css/all.min.css">
	<!-- overlayScrollbars -->
	<link rel="stylesheet" href="<?=ycl_root?>/vendor_frontend/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?=ycl_root?>/vendor_frontend/adminlte/dist/css/adminlte.css">

	<!-- REQUIRED SCRIPTS -->
	<!-- jQuery -->
	<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/jquery/jquery.min.js"></script>
	<!-- Bootstrap -->
	<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- overlayScrollbars -->
	<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
	<!-- Toastr -->
	<link rel="stylesheet" href="<?=ycl_root?>/vendor_frontend/adminlte/plugins/toastr/toastr.min.css">
	<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/toastr/toastr.min.js"></script>
	<!-- SweetAlert -->
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<!-- AdminLTE App -->
	<script src="<?=ycl_root?>/vendor_frontend/adminlte/dist/js/adminlte.js"></script>

	<!-- Moment JS -->
	<!-- https://momentjs.com/docs/#/displaying/ -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.33/moment-timezone-with-data.min.js" integrity="sha512-rjmacQUGnwQ4OAAt3MoAmWDQIuswESNZwYcKC8nmdCIxAVkRC/Lk2ta2CWGgCZyS+FfBWPgaO01LvgwU/BX50Q==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

	<!-- SummerNotes -->
	<link rel="stylesheet" href="<?=ycl_root?>/vendor_frontend/adminlte/plugins/summernote/summernote.min.css">
	<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/summernote/summernote.min.js"></script>

	<!-- DateTime Picker -->
	<link rel="stylesheet" href="<?=ycl_root?>/vendor_frontend/adminlte/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
	<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

	<!-- Select2 -->
	<link rel="stylesheet" href="<?=ycl_root?>/vendor_frontend/adminlte/plugins/select2/css/select2.min.css">
	<link rel="stylesheet" href="<?=ycl_root?>/vendor_frontend/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
	<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/select2/js/select2.full.min.js"></script>

	<!-- Bootstrap4 Duallistbox -->
	<link rel="stylesheet" href="<?=ycl_root?>/vendor_frontend/adminlte/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css">
	<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.js"></script>

	<!--Custom Style-->
	<link rel="stylesheet" href="<?=ycl_root?>/theme_assets/cea/assets/css/customStyles.css">

	<!-- Socket IO -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.4.0/socket.io.js" integrity="sha512-Y8KodDCDqst1e8z0EGKiqEQq3T8NszmgW2HvsC6+tlNw7kxYxHTLl5Iw/gqZj/6qhZdBt+jYyOsybgSAiB9OOA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script>
		let socketServer = "<?=ycl_socket_server?>";
		let socket = io(socketServer);
	</script>


	<?php echo global_js() ?>

	<!-- Custom Translater  -->
	<script src="<?= ycl_base_url ?>/ycl_assets/js/translation_manager.js"></script>
	<script src="<?= ycl_base_url ?>/ycl_assets/js/translater.js"></script>
	
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse">
<div class="wrapper">

	<!-- Preloader -->
	<div class="preloader flex-column justify-content-center align-items-center">
		<img class="animation__wobble" src="<?=ycl_root?>/ycl_assets/ycl_icon.png" alt="YCL Logo">
		<span class="animation__wobble">Loading...</span>
	</div>

