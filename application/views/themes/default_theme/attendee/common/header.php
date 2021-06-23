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
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
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

	<!--Google Font-->
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

	<!-- Theme style and js -->
	<link href="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/css/app.css?v=2" rel="stylesheet">
<?php
	echo global_js();?>
	<!-- Socket IO -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.4.0/socket.io.js" integrity="sha512-Y8KodDCDqst1e8z0EGKiqEQq3T8NszmgW2HvsC6+tlNw7kxYxHTLl5Iw/gqZj/6qhZdBt+jYyOsybgSAiB9OOA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script>
		let socketServer = "<?=ycl_socket_server?>";
		let socket = io(socketServer);
		let user_id = "<?=($this->session->userdata('project_sessions')["project_{$this->project->id}"]['user_id'])?>";
	</script>
	<script src="<?=ycl_root?>/ycl_assets/js/active-status.js"></script>

	<?php if(isset($this->project->google_analytics_code) && $this->project->google_analytics_code != null): ?>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=<?=$this->project->google_analytics_code?>"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', '<?=$this->project->google_analytics_code?>');
		</script>
	<?php endif; ?>
</head>
<body>
