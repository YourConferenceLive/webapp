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
	<link href="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/css/app.css?v=2" rel="stylesheet">

	<?php echo global_js() ?>

	<!-- Socket IO -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.4.0/socket.io.js" integrity="sha512-Y8KodDCDqst1e8z0EGKiqEQq3T8NszmgW2HvsC6+tlNw7kxYxHTLl5Iw/gqZj/6qhZdBt+jYyOsybgSAiB9OOA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script>
		let socketServer = "https://socket.yourconference.live:443";
		let socket = io(socketServer);
		let user_id = "<?=($this->session->userdata('project_sessions')["project_{$this->project->id}"]['user_id'])?>";
	</script>
	<script src="<?=ycl_root?>/ycl_assets/js/active-status.js"></script>
</head>
