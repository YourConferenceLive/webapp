<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<body>
<img id="full-screen-background" src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/ccs/sessions/sessions_listing_background.jpg">
<div class="clearfix" style="margin-bottom: 7rem;"></div>

<main role="main">
	<div class="container-fluid" style="margin-top: 100px">
		<form id="form_profile" enctype="multipart/form-data">
			<div class="row justify-content-center">
				<div class="col-lg-3 col-md-4">
					<input type="text" name="userId" value="<?=$this->user['user_id']?>" style="display: none">

					<div class="card"  style="height: 620px;">
						<div class="card-header">
							<h6><?=ucfirst($profile_data->name).' '.ucfirst($profile_data->surname)?> <i class="fas fa-id-card-alt"></i><h6>
						</div>
						<div class="card-body align-content-center">
							<div class="row">
								<div class="col-md-12 text-center">
									<input type="hidden" name="old_user_photo" id="old_user_photo" value="<?php echo @$profile_data->photo;?>">
									<input type="file" name="user-photo" id="user-photo" style="display: none;">
<?php
									if(isset($profile_data->photo)):?>
									<img src="<?=ycl_root?>/cms_uploads/user_photo/profile_pictures/<?=$profile_data->photo?>" 
										 onerror="this.src='<?=ycl_root?>/ycl_assets/images/person_dp_placeholder.png'"
										 class="img-fluid justify-content-center mt-3" id="user-photo-preview" style="width:150px;height:150px;"><br>
<?php
									else:?>
									<div style="width: 150px ; height: 150px" class="justify-content-center mt-3 m-auto bg-secondary text-white" >
										<h1 class="justify-content-center mt-3 position-absolute" style="transform: translate(-50%, -50%); left: 50%; top:25%"><?=ucfirst($profile_data->surname)?></h1>
										<img class="img-fluid" width="150" height="150" id="user-photo-preview">
									</div>
<?php
									endif;?>
									<a class="btn badge badge-info" id="upload-btn">Update Photo</a>
								</div>
							</div>

							<?php if(1==2): ?> <!-- Hiding BIOGRAPHY & DISCLOSURES -->
							<div class="row">
								<div class="col-md-12 text-center mt-3 text-left" >
									<h6 class="text-left">BIOGRAPHY</h6>
									<textarea class="form-control" name="bio" rows="4" id="bio" readonly><?=$profile_data->bio?></textarea>

								</div>
							</div>
							<div class="row">
								<div class="col-md-12 text-center mt-2">
									<h6 class="text-left">DISCLOSURES</h6>
									<textarea class="form-control" name="disclosure" rows="4" id="disclosure" readonly><?=$profile_data->disclosures?></textarea>
								</div>
							</div>
							<?php endif; ?>

						</div>
					</div>
				</div>
				<div class="col-md-5">
					<div class="row">
						<div class="col-md-12">
							<div class="card"  style="min-height: 400px">
								<div class="card-header">
									<h6>Personal Information <i class="fas fa-id-card"></i>
<!--										<span class="float-right btn btn-success btn-sm ml-2 save-btn"><i class="far fa-check-circle"></i> Save</span>-->
<!--										<span class="float-right btn btn-info btn-sm edit-btn"><i class="far fa-edit"></i> Edit</span></h6>-->
								</div>
								<div class="card-body">
									<div class="row">
										<div class="col-md-5">
											<div class="form-group">
												<label for="first_name">First Name</label>
												<input type="text" class="form-control" id="first_name" name="first_name" value="<?=$profile_data->name?>">
											</div>
											<div class="form-group">
												<label for="surname">Last Name</label>
												<input type="text" class="form-control" id="surname" name="surname" value="<?=$profile_data->surname?>">
											</div>
											<div class="form-group">
												<label for="degree">Degree</label>
												<input type="text" class="form-control" id="degree" name="degree" value="<?=$profile_data->credentials?>">
											</div>
										</div>
										<div class="col-md-7">
											<div class="form-group">
												<label for="rcpn">Royal College of Physicians Number</label>
												<input type="text" class="form-control" id="rcpn" name="rcpn"  value="<?=$profile_data->rcp_number?>">
											</div>
											<div class="form-group">
												<label for="city">City</label>
												<input type="text" class="form-control" id="city" name="city" value="<?=$profile_data->city?>">
											</div>
											<div class="form-group">
												<label for="country">Country</label>
												<input type="text" class="form-control" id="country" name="country" value="<?=$profile_data->country?>">
											</div>
										</div>
									</div>
								</div>
								<div class="card-footer">
								</div>
							</div>
						</div>
					</div>
					<div class="row mb-5">
						<div class="col-md-12" style="margin-top: 20px">
							<div class="card"  style=" min-height: 200px">
								<div class="card-header">
									<h6>
										Account Information <i class="fas fa-user-lock"></i>
									</h6>
								</div>
								<div class="card-body">
									<div clas="row">
										<div class="col">
											<div class="input-group">
												<div class="input-group-prepend">
													<label class="input-group-text mb-3" for="email" >Email</label>
												</div>
												<input type="text" class="form-control" id="email" name="email" value="<?=$profile_data->email?>">
											</div>
											<div class="input-group">
												<div class="input-group-prepend">
													<label class="input-group-text" for="password">Password</label>
												</div>
												<input type="password" class="form-control" id="password" name="password" placeholder="***********">
												<div class="input-group-append">
													<label class="input-group-text btn btn-warning" for="password" style="cursor: pointer" id="show_password"><i class="fas fa-eye"></i></label>
												</div>
											</div>
											<small>(Leave the password field blank if you don't want to update the password)</small>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-12">
							<div class="card">
								<div class="card-body">
									<div clas="row">
										<div class="col">
											<button class="save-btn btn btn-success float-right"><i class="far fa-save"></i> Save</button>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
		</form>
	</div>
</main>
</body>
<script>
		$(function(){
			$('#upload-btn').on('click', function(){
				$('#user-photo').trigger('click');
			});

			$('.edit-btn').on('click', function(){
				$('#rcpn').attr('readonly',false)
				$('#password').attr('readonly',false)
				$('#email').attr('readonly',false)
				$('#upload-btn').attr('hidden',false)
			})

			$('.save-btn').on('click', function(){
				//$('#rcpn').attr('readonly', true)
				//$('#password').attr('readonly', true)
				//$('#email').attr('readonly', true)
				//$('#upload-btn').attr('hidden', true)
			})

			$('#show_password').click(function(){
				if($('#password').attr('type')==='password'){
					$('#password').attr('type', 'text');
				}else{
					$('#password').attr('type', 'password');
				}
			})

			$('#password').on('input', function(){
				if($('#password').val().length > 5 )
				{
					$('.confirm-password-section').attr('hidden', false);
				}
			});

			$('#user-photo').on('change',function(){
				let item = $(this);
				let fileName = ($(this).val()).replace(/^.*[\\\/]/, '');
				let reader = new FileReader();
				let valid_ext = ['jpeg', 'jpg', 'png', 'gif']
				let fileExtension = fileName.substr(fileName.lastIndexOf('.')+1);

				if (!valid_ext.includes(fileExtension)) {
					toastr.error("File type "+fileExtension+" is not supported");
					return false;
				}

				reader.onload = function (e) { 
					$('#user-photo-preview').attr('src', e.target.result);
				}
				reader.readAsDataURL(this.files[0]);
				$('#user-photo-preview').show();
				fileName = fileName.replace("C:\\fakepath\\", "");
				$(this).next('.custom-file-label').html(fileName);
			});


			$('.save-btn').on('click', function(e) {
				e.preventDefault();

				let formData = new FormData(document.getElementById('form_profile'));

				// if($('#rcpn').val() === ''){
				// 	toastr['warning']('Royal College of Physicians Number Required!')
				// 	return false;
				// }

					Swal.fire({
						title: 'Are you sure?',
						html: "You are about to update your profile data <br><br>" +
								"<small>(Some data are automatically synced from COS everytime you login)</small>",
						icon: 'question',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Yes, save!'
					}).then((result) => {
						if (result.isConfirmed) {
							$.ajax({
								type: "POST",
								url: project_url + "/profile/update_profile_data",
								data: formData,
								processData: false,
								contentType: false,
								error: function (jqXHR, textStatus, errorMessage) {
									// Swal.close();
									toastr.error(errorMessage);
									//console.log(errorMessage); // Optional
								},
								success: function (data) {
									data = JSON.parse(data);
									// console.log(data);
									if (data.status == 'success')
									{
										Swal.fire(
											'Success',
											'Profile Information Updated',
											'success'
										)
									}else{
										toastr['error']('Something went wrong')
									}
								}
							})
						}
					})
				})

			$('.edit-btn').click();
		})
</script>
