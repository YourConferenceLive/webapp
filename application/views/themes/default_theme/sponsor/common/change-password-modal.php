<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="changePasswordModalLabel"><i class="fas fa-lock"></i> Change your password</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<div class="input-group">
					<div class="input-group-prepend">
						<label class="input-group-text" for="password">Password</label>
					</div>
					<input type="password" class="form-control" id="password" name="password" placeholder="Enter your new password">
					<div class="input-group-append">
						<label class="input-group-text btn btn-warning" for="password" style="cursor: pointer" id="show_password"><i class="fas fa-eye"></i></label>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="save-password-btn btn btn-success"><i class="far fa-save"></i> Save password</button>
			</div>
		</div>
	</div>
</div>

<script>
	$(function () {

		$('.change-password-btn').on('click', function () {
			$('#changePasswordModal').modal('show');
		});

		$('#show_password').click(function(){
			if($('#password').attr('type')==='password'){
				$('#password').attr('type', 'text');
			}else{
				$('#password').attr('type', 'password');
			}
		});

		$('.save-password-btn').on('click', function(e) {
			e.preventDefault();

			let newPassword = $('#password').val()

			if(newPassword == ''){
				toastr['warning']('Password cannot be empty!')
				return false;
			}

			$.post(project_url+"/sponsor/admin/home/changePasswordAjax", {password: newPassword}, function (success) {
				if (success)
				{
					$('#changePasswordModal').modal('hide');
					Swal.fire(
							'Done!',
							'Your password has been changed.',
							'success'
					);

				}else{
					Swal.fire(
							'Error!',
							'Unable to update the password.',
							'error'
					)
				}
			}).fail((error)=>{
				toastr['error'](error);
			});
		});
	})
</script>
