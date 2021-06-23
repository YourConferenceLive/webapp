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

<link href="<?=ycl_root?>/theme_assets/default_theme/css/login.css" rel="stylesheet">
<body class="text-center">
<form class="form-signin">

	<div class="mb-4">
		<img src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/logo.png" alt="<?=$this->project->name?> Logo" onerror="this.src='<?=ycl_root?>/ycl_assets/ycl_logo.png'" style="max-width: 100%;max-height: 100%;">
	</div>

	<?php if (ycl_env == 'production'): ?>
		<h1 class="h3 mb-3 font-weight-normal">Opening Soon!</h1>
	<?php else: ?>
		<h1 class="h3 mb-3 font-weight-normal">Please Login</h1>

		<label for="inputEmail" class="sr-only">Email address</label>
		<input type="email" id="email" class="form-control" placeholder="Email address" required autofocus>

		<label for="inputPassword" class="sr-only">Password</label>
		<input type="password" id="password" class="form-control" placeholder="Password" required>

		<button id="login-btn" class="btn btn-lg btn-primary btn-block" type="button">Login</button>
	<?php endif; ?>

</form>
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
					access_level: 'attendee'
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
                            window.location = '<?=$this->project_url.'/lobby'?>'
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
