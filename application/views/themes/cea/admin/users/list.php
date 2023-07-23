<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo"<pre>";print_r($sponsors);exit("</pre>");
?>


<style>
	#sponsorsTable_filter, #sponsorsTable_paginate{
		float: right;
	}
	.swal2-html-container{
		color: #fdfdfd;
	}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Users</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=$this->project_url.'/admin/dashboard'?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Users</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<!-- Main content -->
	<section class="content">
		<div class="container-fluid">
			<!-- Info boxes -->
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title">All users</h3>
							<button class="add-user-btn btn btn-success float-right"><i class="fas fa-plus"></i> Add</button>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<table id="usersTable" class="table table-bordered table-striped">
								<thead>
								<tr>
									<th>User ID</th>
									<th>Project ID</th>
									<th>Project Name</th>
									<th>First Name</th>
									<th>Surname</th>
									<th>Email</th>
									<th>Memb Type</th>
									<th>Memb Sub Type</th>
									<th>Accesses</th>
									<th>Actions</th>
								</tr>
								</thead>
								<tbody id="usersTableBody">
									<!-- Will be filled by the JQuery -->
								</tbody>
							</table>
						</div>
						<!-- /.card-body -->
					</div>
					<!-- /.card -->
				</div>
			</div>
			<!-- /.row -->
		</div><!--/. container-fluid -->
	</section>
	<!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- DataTables  & Plugins -->
<link rel="stylesheet" href="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/jszip/jszip.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
	$(function ()
	{
		
		listUsers();

		$('.add-user-btn').on('click', function () {

			$('#addUserForm')[0].reset();

			$('#userId').val(0);
			$('#password').prop('disabled', false);
			$('#password').css('background-color', '#343a40');
			$('#password').css('color', '#fff');
			// $('#sponsorId').val(0);
			// $('#logo_preview').hide();
			// $('#logo_label').text('');
			// $('#banner_preview').hide();
			// $('#banner_label').text('');
			$('#save-sponsor').html('<i class="fas fa-plus"></i> Add');

			$('#addUserModal').modal({
				backdrop: 'static',
				keyboard: false
			});
		});

		$('#usersTable').on('click', '.manage-user', function () {

			const translationData = fetchAllText(); // Fetch the translation data

			translationData.then((arrData) => {
				let selectedLanguage = $('#languageSelect').val(); // Get the selected language

				// Find the translations for the dialog text
				let dialogTitle = 'Please Wait';
				let dialogText = 'Loading user details...';
				let imageAltText = 'Loading...';

				for (let i = 0; i < arrData.length; i++) {
					if (arrData[i].english_text === dialogTitle) {
						dialogTitle = arrData[i][selectedLanguage + '_text'];
					}
					if (arrData[i].english_text === dialogText) {
						dialogText = arrData[i][selectedLanguage + '_text'];
					}
					if (arrData[i].english_text === imageAltText) {
						imageAltText = arrData[i][selectedLanguage + '_text'];
					}
				}

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
				
				let userId = $(this).attr('user-id');
	
				$.get(project_admin_url+"/users/getByIdJson/"+userId, function (user)
				{
					user = JSON.parse(user);
	
					$('#userId').val(user.id);
	
					$('#email').val(user.email);
	
					$('#password').val('#######################');
					$('#password').prop('disabled', true);
					$('#password').css('background-color', '#232e3a');
					$('#password').css('color', '#a80000');
	
					$('#reset-pass-update-modal').attr('user-id', user.id);
					$('#reset-pass-update-modal').attr('user-name', user.name);
	
					$('#idFromApi').val(user.idFromApi);
					$('#membership_type').val(user.membership_type);
					$('#membership_sub_type').val(user.membership_sub_type);
	
					$('#name_prefix').val(user.name_prefix);
					$('#credentials').val(user.credentials);
					$('#first_name').val(user.name);
					$('#surname').val(user.surname);
	
					$('#bio').val(user.bio);
					$('#disclosure').val(user.disclosures);
	
					if(user.photo){
						$('#user-photo_label').text((user.photo).substring((user.photo).indexOf('_') + 1));
						$('#user-photo-preview').attr('src', '<?=ycl_base_url?>/cms_uploads/user_photo/profile_pictures/'+user.photo).show();
					}else{
						$('#user-photo_label').text('');
						$('#user-photo-preview').attr('src', '').hide();
					}
	
					$('#attendee_access, #presenter_access, #moderator_access, #admin_access, #exhibitor_access').prop('checked', false);
					$.each(user.accesses, function(key, access){
						$('#'+access.level+'_access').prop('checked', true);
					});
	
					$('#save-user').html('<i class="fas fa-save"></i> Save');
	
					$('#addUserModal').modal({
						backdrop: 'static',
						keyboard: false
					});
	
					Swal.close();
				});
			});


		});

		$('#sponsorsTable').on('click', '.delete-sponsor', function () {
			let sponsorId = $(this).attr('sponsor-id');
			let sponsorName = $(this).attr('sponsor-name');

			const translationData = fetchAllText(); // Fetch the translation data

            translationData.then((arrData) => {
                const selectedLanguage = $('#languageSelect').val(); // Get the selected language

                // Swal 1 msg
                let dialogTitle = 'Are you sure?';
				let html1 = 'This will delete all the assets, admins attached, chats etc of this sponsor';
				let html2 = "(This won't delete the accounts of admins attached to this booth though)";
				let html3 = "You won't be able to revert this!";
                let confirmButtonText = 'Yes, delete it!';
                let cancelButtonText = 'Cancel';

				// Swal 2 msg
				let dialogTitle2 = 'Please Wait';
				let dialogMsg2 = 'Deleting the sponsor...';
				let imageAltText = 'Loading...';

				// Toast
				let sponsorText = 'Sponsor';
				let deletedText = 'deleted';
				let errorText = 'Error';

                for (let i = 0; i < arrData.length; i++) {
                    if (arrData[i].english_text === dialogTitle) {
                        dialogTitle = arrData[i][selectedLanguage + '_text'];
                    }
                    if (arrData[i].english_text === html1) {
                        html1 = arrData[i][selectedLanguage + '_text'];
                    }
                    if (arrData[i].english_text === html2) {
                        html2 = arrData[i][selectedLanguage + '_text'];
                    }
                    if (arrData[i].english_text === html3) {
                        html3 = arrData[i][selectedLanguage + '_text'];
                    }
					if (arrData[i].english_text === confirmButtonText) {
                        confirmButtonText = arrData[i][selectedLanguage + '_text'];
                    }
                    if (arrData[i].english_text === cancelButtonText) {
                        cancelButtonText = arrData[i][selectedLanguage + '_text'];
                    }

					if (arrData[i].english_text === dialogTitle2) {
                        dialogTitle2 = arrData[i][selectedLanguage + '_text'];
                    }
					if (arrData[i].english_text === dialogMsg2) {
                        dialogMsg2 = arrData[i][selectedLanguage + '_text'];
                    }
                    if (arrData[i].english_text === imageAltText) {
                        imageAltText = arrData[i][selectedLanguage + '_text'];
                    }

					if (arrData[i].english_text === sponsorText) {
                        sponsorText = arrData[i][selectedLanguage + '_text'];
                    }
                    if (arrData[i].english_text === deletedText) {
                        deletedText = arrData[i][selectedLanguage + '_text'];
                    }
					if (arrData[i].english_text === errorText) {
                        errorText = arrData[i][selectedLanguage + '_text'];
                    }
                }

				Swal.fire({
					title: dialogTitle,
					html:
							`${html1} (`+sponsorName+`)
							 <br><small>${html2}</small>
							 <br><br> ${html3}`,
					icon: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: confirmButtonText,
                    cancelButtonText: cancelButtonText
				}).then((result) => {
					if (result.isConfirmed) {
	
						Swal.fire({
							title: dialogTitle2,
							text: dialogMsg2,
							imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
							imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
							imageAlt: imageAltText,
							showCancelButton: false,
							showConfirmButton: false,
							allowOutsideClick: false
						});
	
						$.get(project_admin_url+"/sponsors/delete/"+sponsorId, function (response)
						{
							Swal.close();
	
							response = JSON.parse(response);
	
							if (response.status == 'success')
								toastr.success(sponsorText+' ('+sponsorName+') '+deletedText);
							else
								toastr.error(errorText);
	
							listSponsors();
						});
					}
				})
                
            });
		});

		$('#usersTable').on('click', '.reset-user-pass-btn', function () {
			resetUserPassword($(this).attr('user-id'), $(this).attr('user-name'));
		});

	});

	function listUsers()
	{
		const translationData = fetchAllText(); // Fetch the translation data

		translationData.then((arrData) => {
			const selectedLanguage = $('#languageSelect').val(); // Get the selected language
			// Find the translations for the dialog text
			let dialogTitle = 'Please Wait';
			let dialogText = 'Loading users data...';
			let imageAltText = 'Loading...';

			// Get Method msg
			let manageText = 'Manage';
			let resetPassText = 'Reset Password';
			let suspendText = 'Suspend';
			

			for (let i = 0; i < arrData.length; i++) {
				if (arrData[i].english_text === dialogTitle) {
					dialogTitle = arrData[i][selectedLanguage + '_text'];
				}
				if (arrData[i].english_text === dialogText) {
					dialogText = arrData[i][selectedLanguage + '_text'];
				}
				if (arrData[i].english_text === imageAltText) {
					imageAltText = arrData[i][selectedLanguage + '_text'];
				}

				if (arrData[i].english_text === manageText) {
					manageText = arrData[i][selectedLanguage + '_text'];
				}
				if (arrData[i].english_text === resetPassText) {
					resetPassText = arrData[i][selectedLanguage + '_text'];
				}
				if (arrData[i].english_text === suspendText) {
					suspendText = arrData[i][selectedLanguage + '_text'];
				}
				
			}

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

			$.get(project_admin_url+"/users/getAllNoProjectidJson", function (users) {
				users = JSON.parse(users);
				$('#usersTableBody').html('');
				if ($.fn.DataTable.isDataTable('#usersTable'))
				{
					$('#usersTable').dataTable().fnClearTable();
					$('#usersTable').dataTable().fnDestroy();
				}
	
				$.each(users, function(key, user)
				{
					let accessList = '';
					$.each(user.accesses, function(key, access)
					{
						let color_code = access_color_codes[access.level];
						let icon = access_icons[access.level];
						access.level = access.level[0].toUpperCase()+access.level.substring(1);
						accessList += '<small class="badge badge-primary mr-1" style="background-color:'+color_code+';"><i class="'+icon+'"></i> '+access.level+'</small>';
					});
	
					$('#usersTableBody').append(
							'<tr>' +
							'	<td>' +
							'		'+user.id+
							'	</td>' +
							'	<td>' +
							'		'+user.project_id+
							'	</td>' +
							'	<td>' +
							'		'+user.project_name+
							'	</td>' +
							'	<td>' +
							'		'+user.name+
							'	</td>' +
							'	<td>' +
							'		'+user.surname+
							'	</td>' +
							'	<td>' +
							'		'+user.email+
							'	</td>' +
							'	<td>' +
							'		'+user.membership_type+
							'	</td>' +
							'	<td>' +
							'		'+user.membership_sub_type+
							'	</td>' +
							'	<td>' +
							'		'+accessList+
							'	</td>' +
							'	<td>' +
							'		<button class="manage-user btn btn-sm btn-info m-2" user-id="'+user.id+'"><i class="fas fa-edit"></i> '+manageText+'</button>' +
							'		<button class="reset-user-pass-btn btn btn-sm btn-success m-2 text-white" user-id="'+user.id+'" user-name="'+user.name+'"><i class="fas fa-lock-open"></i> '+resetPassText+'</button>'+
							'		<button onclick="suspendUser()" class="suspend-user btn btn-sm btn-warning m-2 text-white" user-id="'+user.id+'" user-name="'+user.name+'"><i class="fas fa-user-slash"></i> '+suspendText+'</button>'+
							'	</td>' +
							'</tr>'
					);
				});
	
				$('#usersTable').DataTable({
					"paging": true,
					"lengthChange": true,
					"searching": true,
					"ordering": true,
					"info": true,
					"autoWidth": true,
					"responsive": false,
					"order": [[ 0, "desc" ]],
					"destroy": true
				});
	
				Swal.close();
			});


			
		});
	}

	function resetUserPassword(userId, userName)
	{
		const translationData = fetchAllText(); // Fetch the translation data

		translationData.then((arrData) => {
			const selectedLanguage = $('#languageSelect').val(); // Get the selected language

			// Find the translations for the dialog text
			let dialogTitle = 'Are you sure?';
			let html1 = "You are about to reset";
			let html2 = "password to '12345' (without quotes)";
			let confirmButtonText = 'Yes, reset it!';
			let cancelButtonText = 'Cancel';

			// Swal 2
			let dialogTitle2 = 'Please Wait';
			let html21 = "Resetting";
			let html22 = "password...";
			let imageAltText = 'Loading...'; 

			// Toast
			doneText = "Done!";
			doneMsg = "password is now reset to 12345";
			errorText = "Error!";
			errorMsg = "Unable to reset the password";


			for (let i = 0; i < arrData.length; i++) {
				if (arrData[i].english_text === dialogTitle) {
					dialogTitle = arrData[i][selectedLanguage + '_text'];
				}
				if (arrData[i].english_text === html1) {
					html1 = arrData[i][selectedLanguage + '_text'];
				}
				if (arrData[i].english_text === html2) {
					html2 = arrData[i][selectedLanguage + '_text'];
				}
				if (arrData[i].english_text === confirmButtonText) {
					confirmButtonText = arrData[i][selectedLanguage + '_text'];
				}
				if (arrData[i].english_text === cancelButtonText) {
					cancelButtonText = arrData[i][selectedLanguage + '_text'];
				}

				if (arrData[i].english_text === dialogTitle2) {
					dialogTitle2 = arrData[i][selectedLanguage + '_text'];
				}
				if (arrData[i].english_text === html21) {
					html21 = arrData[i][selectedLanguage + '_text'];
				}
				if (arrData[i].english_text === html22) {
					html22 = arrData[i][selectedLanguage + '_text'];
				}
				if (arrData[i].english_text === imageAltText) {
					imageAltText = arrData[i][selectedLanguage + '_text'];
				}

				if (arrData[i].english_text === doneText) {
					doneText = arrData[i][selectedLanguage + '_text'];
				}
				if (arrData[i].english_text === doneMsg) {
					doneMsg = arrData[i][selectedLanguage + '_text'];
				}
				if (arrData[i].english_text === errorText) {
					errorText = arrData[i][selectedLanguage + '_text'];
				}
				if (arrData[i].english_text === errorMsg) {
					errorMsg = arrData[i][selectedLanguage + '_text'];
				}
			}

			Swal.fire({
				title: dialogTitle,
				html: html1+" <strong>"+userName+"</strong>'s "+html2,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: confirmButtonText,
				cancelButtonText: cancelButtonText
			}).then((result) => {
				if (result.isConfirmed) {
					Swal.fire({
						title: dialogTitle2,
						text: html21+" "+userName+"'s "+html22,
						imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
						imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
						imageAlt: imageAltText,
						showCancelButton: false,
						showConfirmButton: false,
						allowOutsideClick: false
					});
	
					$.get(project_admin_url+"/users/resetPasswordOf/"+userId, function (response) {
						response = JSON.parse(response);
	
						if (response.status == 'success')
							Swal.fire(
									doneText,
									userName+"'s "+doneMsg,
									'success'
							);
						else
							Swal.fire(
									errorText,
									errorMsg,
									'error'
							);
					});
	
				}
			})
			
		});
	}

	function suspendUser(){
		getTranslatedSelectAccess('Unavailable').then((msg) => {
			toastr.warning(msg);
		});
	}

</script>
