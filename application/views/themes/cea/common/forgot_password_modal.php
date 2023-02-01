<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="forgotPasswordModalTitle">Forgot Password</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="basic-addon1">Email</span>
					</div>
					<input type="text" name="email" class="form-control emailAddress" placeholder="Email" aria-label="Email" aria-describedby="basic-addon1" value="">
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-success forgotPasswordSubmit">Confirm</button>
			</div>
		</div>
	</div>
</div>
<script>
	function forgotPassword(){
		$('#forgotPasswordModal').modal('show');
	}

	$(function(){
		$('.forgotPasswordSubmit').on('click', function(){
			let url = "<?=$this->project_url?>/forgot_password/forgotPresenterPassword";
			let email = $('.emailAddress').val();
			if(!email){
				toastr.error('Email should not be empty');
				return false;
			}

			$.post(url,
				{
					'email':email
				}, function(response){
					Swal.fire(
						response.status,
						response.msg,
						response.icon
					)
			},'json')

		})
	})
</script>
