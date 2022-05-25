<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
	<?php if(file_exists(FCPATH."cms_uploads/projects/{$this->project->id}/theme_assets/presenter/login_background.jpg")): ?>
	body{
		background-image: url("<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/presenter/login_background.jpg") ;
		-webkit-background-size: cover;
		-moz-background-size: cover;
		-o-background-size: cover;
		background-size: cover;
		background-repeat: no-repeat;
		background-origin: content-box;
		background-attachment: fixed;
	}

	<?php endif; ?>
</style>

<link href="<?=ycl_root?>/theme_assets/default_theme/css/login.css?v=3" rel="stylesheet">
<body class="text-center">

<div class="row">
	<div class="col-12">
		<img class="img-fluid banner-image" onerror="$(this).hide()" src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/other_images/presenter/main_banner.jpg"  width="100%" >
	</div>
</div>

<div class="row">
	<div class="col-12">
		<div class="card pb-2 shadow" style="max-width:650px ;margin:auto; margin-top:80px">

				<form class="">

					<div class="mb-4 mt-4">
						<img src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/logo.png" alt="<?=$this->project->name?> Logo" onerror="this.src='<?=ycl_root?>/ycl_assets/ycl_logo.png'" style="max-width: 300px; max-height: 100%;">
					</div>
						<fieldset>
						<h1 class="h4 mb-3 font-weight-normal text-left" style="color:#5b5b60">Presenter Login</h1>

						<label for="inputEmail" class="sr-only">Email address</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" style="background-color:unset; "  type="button"><i class="fas fa-user"></i></label>
								</div>
								<input type="email" id="email" class="form-control" placeholder="Email address" required autofocus>
							</div>

						<label for="inputPassword" class="sr-only">Password</label>
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<label class="input-group-text" style="background-color:unset; "  type="button"><small class="fas fa-lock"></small></label>
								</div>
								<input type="password" id="password" class="form-control" placeholder="Password" required>
							</div>
						<div class="float-left">
						<button id="login-btn" class="btn mt-2 text-white px-5" style="background-color:#f78e1e;" type="button">Login</button>
						<span><a href="#">Forgot password</a></span>
						</div>
						</fieldset>
				</form>
			</div>
<!--		<small>The login to this portal will be: Username: your email address Password: COS2021 (Passwords can be changed after your first login) </small>-->
	</div>
	</div>
</div>

</body>

<script>

	$(function () {

		$('#login-btn').on('click', function () {

			Swal.fire({
				title: 'Please Wait',
				text: 'We are validating your credentials',
				imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
				imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
				imageAlt: 'Loading...',
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
					access_level: 'presenter'
				})
				.done(function( data ) {

					data = JSON.parse(data);
					if (data.status == 'success')
					{
						Swal.fire({
							title: 'Done!',
							text: 'We are redirecting you',
							icon: 'success',
							showCancelButton: false,
							showConfirmButton: false,
							allowOutsideClick: false
						});

						setTimeout(() => {
							window.location = '<?=$this->project_url.'/presenter/sessions'?>'
						}, 1000);

					}else{
						Swal.fire(
							'Unable To Login',
							data.msg,
							'error'
						);
					}

				})
				.fail(function () {
					Swal.fire(
						'Unable To Register',
						'Network error',
						'error'
					);
				});
		});

	});

</script>
