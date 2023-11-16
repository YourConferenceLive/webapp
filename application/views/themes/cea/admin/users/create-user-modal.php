<!--Add User Modal-->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addUserModalLabel"><i class="fas fa-user-plus"></i> Add New User</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<form id="addUserForm">

					<div class="card">
						<div class="card-header">
							<i class="fas fa-key"></i> Login Credentials
						</div>
						<div class="card-body">

							<div class="form-group">
								<label>Email</label>
								<input name="email" id="email" class="form-control" type="text" placeholder="User's email" required>
								<small id="emailExistsError" class="form-text text-muted text-red" style="display: none;">Email already exists.</small>
							</div>

							<div class="form-group">
								<label>Password</label>
								<input name="password" id="password" class="form-control mb-2" type="text" placeholder="User's password" required>
								<small class="mt-2">
									Passwords are encrypted and cannot be displayed or updated in cleartext, you can only
									<button type="button" id="reset-pass-update-modal" class="reset-user-pass-btn btn btn-xs btn-success text-white ml-2 mr-2" user-id="" user-name=""><i class="fas fa-lock-open"></i> Reset</button>
									them.</small>
							</div>

						</div>
					</div>

					<div class="card d-none">
						<div class="card-header">
							<i class="far fa-address-card"></i> <?=$this->project->name?> Membership
						</div>
						<div class="card-body">
							<div class="form-group">
								<label><?=$this->project->name?> Party ID</label>
								<input name="idFromApi" id="idFromApi" class="form-control" type="text" placeholder="User's ID in <?=$this->project->name?> database" required>
							</div>
							<div class="form-group">
								<label>Membership Type</label>
								<input name="membership_type" id="membership_type" class="form-control" type="text" placeholder="User's membership type eg; C for contact" required>
							</div>
							<div class="form-group">
								<label>Membership Sub Type</label>
								<input name="membership_sub_type" id="membership_sub_type" class="form-control" type="text" placeholder="User's membership sub type eg; MS for Medical Student (only some Non-members will have sub type)" required>
							</div>
						</div>
					</div>

					<div class="card">
						<div class="card-header">
							<i class="far fa-address-card"></i> Profile Details
						</div>
						<div class="card-body">

							<div class="form-group d-none">
								<label>Display Photo</label>
								<div class="custom-file">
									<input name="user-photo" id="user-photo" type="file" class="custom-file-input">
									<label id="user-photo_label" class="custom-file-label" for="user-photo"></label>
								</div>
							</div>
							<img class="image-preview" id="user-photo-preview" src="" style="display: none;" width="75px">


							<div class="form-group d-none">
								<label>Name Prefix</label>
								<input name="name_prefix" id="name_prefix" class="form-control" type="text" placeholder="User's name prefix">
							</div>

							<div class="form-group">
								<label>Credentials</label>
								<input name="credentials" id="credentials" class="form-control" type="text" placeholder="User's credentials">
							</div>

							<div class="form-group">
								<label>First name</label>
								<input name="first_name" id="first_name" class="form-control" type="text" placeholder="User's first name">
							</div>

							<div class="form-group">
								<label>Surname</label>
								<input name="surname" id="surname" class="form-control" type="text" placeholder="User's surname">
							</div>

							<div class="form-group d-none">
								<label>Biography</label>
								<input name="bio" id="bio" class="form-control" type="text" placeholder="User's bio">
							</div>

							<div class="form-group d-none">
								<label>Disclosure</label>
								<input name="disclosure" id="disclosure" class="form-control" type="text" placeholder="User's disclosure">
							</div>

						</div>
					</div>

					<div class="card">
						<div class="card-header">
							<i class="fas fa-id-badge"></i> Accesses
						</div>
						<div class="card-body">

							<div class="row">
								<div class="col-2 offset-3">
									<div class="custom-control custom-checkbox">
										<input class="custom-control-input" type="checkbox" name="attendee_access" id="attendee_access" checked="">
										<label for="attendee_access" class="custom-control-label">Attendee</label>
									</div>
								</div>
								<div class="col-2">
									<div class="custom-control custom-checkbox">
										<input class="custom-control-input" type="checkbox" name="presenter_access" id="presenter_access">
										<label for="presenter_access" class="custom-control-label">Presenter</label>
									</div>
								</div>
								<div class="col-2">
									<div class="custom-control custom-checkbox">
										<input class="custom-control-input" type="checkbox" name="moderator_access" id="moderator_access">
										<label for="moderator_access" class="custom-control-label">Moderator</label>
									</div>
								</div>

								<div class="col-2 offset-3">
									<div class="custom-control custom-checkbox">
										<input class="custom-control-input" type="checkbox" name="admin_access" id="admin_access">
										<label for="admin_access" class="custom-control-label">Admin</label>
									</div>
								</div>
								<div class="col-2">
									<div class="custom-control custom-checkbox">
										<input class="custom-control-input" type="checkbox" name="exhibitor_access" id="exhibitor_access">
										<label for="exhibitor_access" class="custom-control-label">Exhibitor</label>
									</div>
								</div>
								<div class="col-2">
									<div class="custom-control custom-checkbox">
										<input class="custom-control-input" type="checkbox" name="guest_access" id="guest_access">
										<label for="guest_access" class="custom-control-label">Guest</label>
									</div>
								</div>
								<div class="col-2">
									<div class="custom-control custom-checkbox">
										<input class="custom-control-input" type="checkbox" name="mobile_attendee_access" id="mobile_attendee_access">
										<label for="mobile_attendee_access" class="custom-control-label">Mobile</label>
									</div>
								</div>
							</div>

						</div>
					</div>

					<input type="hidden" id="userId" name="userId" value="0">
				</form>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button id="save-user" type="button" class="btn btn-success"><i class="fas fa-plus"></i> Add</button>
			</div>
		</div>
	</div>
</div>

<script>
	// Live email existence checker
	$('#email').on("focusout", function () {
		if ($('#userId').val() != 0 || $('#email').val() == '')
		{
			$('#emailExistsError').hide();
			$('#email').removeClass('is-valid');
			$('#email').removeClass('is-invalid');
			return false;
		}

		$.get(project_admin_url+"/users/emailExists/"+$(this).val(), function (emailExists) {
			if (emailExists == 'true')
			{
				$('#emailExistsError').show();
				$('#email').addClass('is-invalid');
				$('#email').removeClass('is-valid');
			}else{
				$('#emailExistsError').hide();
				$('#email').addClass('is-valid');
				$('#email').removeClass('is-invalid');
			}
		});
	});

	$('#logo, #banner').on('change',function(){
		let item = $(this);
		let fileName = $(this).val();
		let reader = new FileReader();

		reader.onload = function (e) { item.parent().parent().next('.image-preview').attr('src', e.target.result); }
		reader.readAsDataURL(this.files[0]);
		item.parent().parent().next('.image-preview').show();
		fileName = fileName.replace("C:\\fakepath\\", "");
		$(this).next('.custom-file-label').html(fileName);
	});

	$('#save-user').on('click', function () {
		

		if
		(
				! $('#attendee_access').is(":checked") &&
				! $('#presenter_access').is(":checked") &&
				! $('#moderator_access').is(":checked") &&
				! $('#admin_access').is(":checked") && 
				! $('#mobile_attendee_access').is(":checked") &&
				! $('#guest_access').is(":checked")
		)
		{
			toastr.warning('You must select at least one access');
			return false;
		}

		if ($('#userId').val() == 0)
			addUser();
		else
			updateUser();
	});

	function addUser()
	{
		let email = $('#email').val();
		let password = $('#password').val();

		if (email.trim() === '') {
			toastr.error("Email is required.");
			return;
		}
		else if(password.trim() === '') {
			toastr.error("Password is required.");
			return; 
		}

		Swal.fire({
			title: 'Please Wait',
			text: 'Adding the user...',
			imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
			imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
			imageAlt: 'Loading...',
			showCancelButton: false,
			showConfirmButton: false,
			allowOutsideClick: false
		});

		let formData = new FormData(document.getElementById('addUserForm'));

		$.ajax({
			type: "POST",
			url: project_admin_url+"/users/create",
			data: formData,
			processData: false,
			contentType: false,
			error: function(jqXHR, textStatus, errorMessage)
			{
				Swal.close();
				toastr.error(errorMessage);
				//console.log(errorMessage); // Optional
			},
			success: function(data)
			{
				Swal.close();

				data = JSON.parse(data);
				console.log(data);
				if (data.status == 'success')
				{
					// listUsers();
					listUsersServerSide
					toastr.success("User added");
					$('#addUserModal').modal('hide');

				}else if(data.status == 'duplicate'){
					toastr.error("This user is already in the database");
				}else{
					toastr.error("Error");
				}
			}
		});
	}

	function updateUser()
	{
		let email = $('#email').val();

		if (email.trim() === '') {
			toastr.error('Email is required.');
			return;
		}

		Swal.fire({
			title: 'Please Wait',
			text: 'Updating the sponsor...',
			imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
			imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
			imageAlt: 'Loading...',
			showCancelButton: false,
			showConfirmButton: false,
			allowOutsideClick: false
		});

		let formData = new FormData(document.getElementById('addUserForm'));

		$.ajax({
			type: "POST",
			url: project_admin_url+"/users/update",
			data: formData,
			processData: false,
			contentType: false,
			error: function(jqXHR, textStatus, errorMessage)
			{
				Swal.close();
				toastr.error(errorMessage);
				//console.log(errorMessage); // Optional
			},
			success: function(data)
			{
				Swal.close();

				data = JSON.parse(data);

				if (data.status == 'success')
				{
					// listUsers();
					listUsersServerSide
					toastr.success('User updated');

				}else if(data.status == 'duplicate'){
					toastr.error("This user is already in the database");
				}else if(data.status == 'failed'){
					toastr.success('No changes made');
				}else{
					toastr.error('Error');
				}
			}
		});
	}

	$('#user-photo').on('change',function(){
		let item = $(this);
		let fileName = $(this).val();
		let reader = new FileReader();

		reader.onload = function (e) { item.parent().parent().next('.image-preview').attr('src', e.target.result); }
		reader.readAsDataURL(this.files[0]);
		item.parent().parent().next('.image-preview').show();
		fileName = fileName.replace("C:\\fakepath\\", "");
		$(this).next('.custom-file-label').html(fileName);
	});

	$('#addUserForm').on('click', '.reset-user-pass-btn', function () {
		resetUserPassword($(this).attr('user-id'), $(this).attr('user-name'));
	});

</script>
