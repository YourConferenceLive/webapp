<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
	<?php if(file_exists(FCPATH."cms_uploads/projects/{$this->project->id}/theme_assets/register_background.jpg")): ?>
	body{
		background-image: url("<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/register_background.jpg");
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
		<img src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/logo.png" alt="<?=$this->project->name?> Logo" style="max-width: 100%;max-height: 100%;">
	</div>

	<h1 class="h3 mb-3 font-weight-normal">Please Register</h1>

	<label for="name" class="sr-only">Name</label>
	<input type="text" id="name" class="form-control" placeholder="Name" required autofocus>

	<label for="surname" class="sr-only">Surname</label>
	<input type="text" id="surname" class="form-control" placeholder="Surname" required autofocus>

	<label for="email" class="sr-only">Email address</label>
	<input type="email" id="email" class="form-control" placeholder="Email address" required autofocus>

	<label for="password" class="sr-only">Password</label>
	<input type="password" id="password" class="form-control" placeholder="Password" required>

	<button id="register-btn" class="btn btn-lg btn-primary btn-block" type="button">Register</button>

	<p class="mt-5 mb-3 text-muted">Already registered? <a href="<?=base_url()?><?=$this->project->main_route?>/login">Login</a></p>
</form>
</body>

<script>

    $(function () {

        $('#register-btn').on('click', function () {

			Swal.fire({
				title: 'Please Wait',
				text: 'We are registering you',
				imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
				imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
				imageAlt: 'Loading...',
				showCancelButton: false,
				showConfirmButton: false,
				allowOutsideClick: false
			});


            let name = $('#name').val();
            let surname = $('#surname').val();
            let email = $('#email').val();
            let password = $('#password').val();

            if (name == '')
			{
				Swal.fire(
						'Empty name',
						'Please enter your name',
						'error'
				)
				return false;
			}

			if (surname == '')
			{
				Swal.fire(
						'Empty surname',
						'Please enter your surname',
						'error'
				)
				return false;
			}

			let emailRegex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
			if (!emailRegex.test(email))
			{
				Swal.fire(
						'Invalid email',
						'Please enter a valid email',
						'error'
				)
				return false;
			}

			if (password == '')
			{
				Swal.fire(
						'Empty password',
						'Please enter a password',
						'error'
				)
				return false;
			}

            $.post( "<?=$this->project_url.'/account/register'?>",
                {
                    name: name,
					surname: surname,
                    email: email,
                    password: password
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
                            window.location = '<?=$this->project_url.'/login'?>'
                        }, 1000);

                    }else{
                        Swal.fire(
                            'Unable To Register',
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

</html>

