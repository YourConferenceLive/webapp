<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
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

<style>

</style>

<body class="text-center">
<div class="card mx-auto mt-5" style="width:600px">
<form class="form-change-password">

	<div class="mb-4">
		<img src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/logo.png" alt="<?=$this->project->name?> Logo" onerror="this.src='<?=ycl_root?>/ycl_assets/ycl_logo.png'" style="max-width: 100%;max-height: 100%;">
	</div>

	<h1 class="h3 mb-3 font-weight-normal">Change Password</h1>

	<label for="inputEmail" class="sr-only">New Password</label>
	<input type="password" id="new_password" class="form-control mb-2 new_password" placeholder="New Password" required autofocus>

	<label for="inputPassword" class="sr-only">Confirm Password</label>
	<input type="confirm_new_password" id="confirm_new_password" class="form-control mb-2 confirm_new_password" placeholder="Re-type Password" required>

	<button id="save_new_password" class="btn btn-lg btn-primary btn-block" type="button">Save</button>

</form>
</div>
</body>

<script>

	$(function () {
		$('#save_new_password').on('click', function(){
			let url = "<?=$this->project_url?>/forgot_password/updatePassword/";
			let new_password = $('#new_password').val();
			let c_password = $('#confirm_new_password').val();
			let user_id = "<?=$user_id?>";

			if(new_password == "" || c_password == ""){
				toastr.error('Password is empty')
				return false
			}
			if((new_password) == (c_password)){
				console.log(user_id);
				$.post(url,
					{
						'new_password':new_password,
						'user_id':user_id
					}, function(response){
					if(response){
						Swal.fire(
							response.status,
							response.msg,
							response.status
						)}
					},'json')
			}else{
				Swal.fire(
					'Error',
					'Password did not match',
					'error'
				)
			}
		})
});
</script>
