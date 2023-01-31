<style>
    body{
        text-rendering: optimizelegibility;
        margin-top: 0;
        color: #222222;
        font-family: "Open Sans", sans-serif;
        font-size: 16px;
    }
    .parallax {
        /* Set a specific height */
        min-height: 500px;

        /* Create the parallax scrolling effect */
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
    .form-control{
        font-size: 18px;
    }
</style>

<?php //echo"<pre>"; print_r($sessions);exit;?>
<section class="parallax" style="background-image: url(https://yourconference.live/CCO/front_assets/images/bg_login.png); top: 0; padding-top: 0; height: 100vh" >
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12" style="margin-top: 100px; margin-left: 20px; margin-right: 20px;">
                <div class="card m-auto text-center">
                    <div class="row">
                        <div class="col-sm-12" style="margin: 30px 0px" >
							<div class="col-sm-12 " style="margin: 30px 0px" >
								<h6 style="color:#EF5D21; font-size: 18px">Welcome to the</h6>
								<h4  style="color:#EF5D21"><b><?=$this->project->name?> Learner Resource App</b></h4>
								<div style="height: 1px;background-color: #EF5D21;" class="my-3"></div>

								<?php if(isset($sess_data) && !empty($sess_data)): ?>
									<!--													--><?php //echo "<pre>"; print_r($sess_data);  exit?>
									<b><p class="mx-3" id="sessionTitle" style="font-size: 25px; line-height: 1.2"><?=$sess_data->name?></b>
									<?php if(isset ($sess_data->presenters) && !empty($sess_data->presenters)): ?>
										<?php foreach ($sess_data->presenters as $presenter):?>
											<div id="moderators" style="font-size: 18px;">
												<?=$presenter->name.' '.$presenter->surname.', '.$presenter->credentials?>
											</div>
										<?php endforeach;?>
									<?php endif ?>
								<?php endif; ?>

							</div>
                            <div style="height: 2px;background-color: #EF5D21;" class="mb-3"></div>
                            <p style="font-size: 14px" class="mx-5"> Log in to participate in <br> polling, access resources and other valuable <br>features available in this session.</p>
                            <form id="login-form" name="frm_login" method="post" action="<?= $this->project_url ?>/authentication/login">
                            <div class="mx-5" style="">
                                <div class="form-group mb-1">
                                    <input type="text" name="sess_id" id="sess_id" class="form-control shadow-none" value="<?=$session_id?>" placeholder="" style="display: none" >
                                    <input type="text" name="access_level" class="form-control shadow-none" value="mobile_attendee" placeholder="" style="display: none" >
                                    <input type="text" name="email" id="email" class="form-control shadow-none" value="" placeholder="Email" >
                                </div>
                                <div class="form-group">
                                    <input type="password" id="password" name="password" class="form-control shadow-none" value="" placeholder="Password">
                                </div>
                            </div>

                            <div class="text-left mx-5">
                                <button type="submit" id="login-btn" href="<?= $this->project_url.'/attendee/register'?>" class="btn btn text-white" style="background-color:#EF5D21">Login</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<?php if($this->session->flashdata('msg')): ?>
  <script>
      Swal.fire({
          icon: 'error',
          title: 'Oops...',
          html: '<div style="color:#EF5D21"><?=$this->session->flashdata('msg')?><div>',
      })
  </script>
<?php endif; ?>
<script type="text/javascript">
    $(document).ready(function () {

        $("#btn_login").on("click", function () {
            if ($("#username").val().trim() == "") {
                $("#erroremail").text("Please Enter Username").fadeIn('slow').fadeOut(5000);

                return false;
            } else if ($("#password").val() == "") {
                $("#errorpassword").text("Please Enter Password").fadeIn('slow').fadeOut(5000);
                return false;
            } else {
                return true; //submit form
            }
            return false; //Prevent form to submitting
        });

    });

	$(function () {

		$('#login-btn').on('click', function (e) {
				e.preventDefault();

			// console.log(session_id);return false;
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
			// let session_id = $('#sess_id').val();
			let email = $('#email').val();
			let password = $('#password').val();
			let session_id = $('#sess_id').val();

			$.post( "<?=$this->project_url.'/authentication/login'?>",
				{
					email: email,
					password: password,
					access_level: 'mobile_attendee'
				})
				.done(function( data ) {

					data = JSON.parse(data);
					console.log(data);
					if (data.status === 'success')
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
							window.location = '<?=$this->project_url?>/mobile/sessions/view/'+ session_id;
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
