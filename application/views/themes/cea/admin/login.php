<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
	<?php if(file_exists(FCPATH."cms_uploads/projects/{$this->project->id}/theme_assets/login_background.jpg")): ?>
	body{
		background-image: url("<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/login_background.jpg");
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
	}
	<?php endif; ?>
</style>

<link href="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/assets/css/login.css" rel="stylesheet">
<body class="text-center">
<form class="form-signin">

	<div class="mb-4">
		<img src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/logo.png" alt="<?=$this->project->name?> Logo" onerror="this.src='<?=ycl_root?>/ycl_assets/ycl_logo.png'" style="max-width: 100%;max-height: 100%;">
	</div>

	<h1 class="h3 mb-3 font-weight-normal">Admin Login</h1>

	<label for="inputEmail" class="sr-only">Email address</label>
	<input type="email" id="email" class="form-control" placeholder="Email address" required autofocus>

	<label for="inputPassword" class="sr-only">Password</label>
	<input type="password" id="password" class="form-control" placeholder="Password" required>

	<button id="login-btn" class="btn btn-lg btn-primary btn-block" type="button">Login</button>

</form>
</body>
<script src="<?= ycl_base_url ?>/ycl_assets/js/translater.js"></script>

<script>

	$(function () {
		$('#login-btn').on('click', function () {

			let dialogTitle = 'Please Wait';
			let dialogText = 'We are validating your credentials';
			let imageAltText = 'Loading...';

			let dialogTitle2 = 'Done!';
			let dialogText2 = 'We are redirecting you';

			let unableText3 = "Unable To Login";
			
			let unableText4 = "Unable To Register";
			let unableMsg4 = "Network error";

			Swal.fire({
				title: dialogTitle,
				text: dialogText,
				imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
				imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
				imageAlt: imageAltText,
				showCancelButton: false,
				showConfirmButton: false,
				allowOutsideClick: false
			});

			let email = $('#email').val();
			let password = $('#password').val();
			$.post( "<?=$this->project_url.'/authentication/login'?>",
			{
				email: email,
				password: password,
				access_level: 'admin'
			})
			.done(function( data ) {
				data = JSON.parse(data);
				if (data.status == 'success')
				{
					Swal.fire({
						title: dialogTitle2,
						text: dialogText2,
						icon: 'success',
						showCancelButton: false,
						showConfirmButton: false,
						allowOutsideClick: false
					});

					setTimeout(() => {
						window.location = '<?=$this->project_url.'/admin/dashboard'?>'
						// alert("Success");
					}, 1000);

				}else{
					Swal.fire(
						unableText3,
						data.msg,
						'error'
					);

				}

			})
			.fail(function () {
				Swal.fire(
					unableText4,
					unableMsg4,
					'error'
				);
			});
			
		});
	});

</script>
