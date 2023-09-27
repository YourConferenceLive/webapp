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
						<li class="breadcrumb-item active"><a href="<?=$this->project_url.'/admin/users'?>">Users</a></li>
						<li class="breadcrumb-item active">Exhibitors without booth</li>
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
							<h3 class="card-title">Exhibitors without booths</h3>
							<button class="add-user-btn btn btn-success float-right"><i class="fas fa-plus"></i> Add</button>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<table id="usersTable" class="table table-bordered table-striped">
								<thead>
								<tr>
									<th>User ID</th>
									<th>First Name</th>
									<th>Surname</th>
									<th>Email</th>
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

			Swal.fire({
				title: 'Please Wait',
				text: 'Loading user details...',
				imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
				imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
				imageAlt: 'Loading...',
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


		$('#sponsorsTable').on('click', '.delete-sponsor', function () {
			let sponsorId = $(this).attr('sponsor-id');
			let sponsorName = $(this).attr('sponsor-name');
				
			Swal.fire({
				title: 'Are you sure?',
				html:
						`This will delete all the assets, admins attached, chats etc of this sponsor (`+sponsorName+`)
							<br><small>(This won't delete the accounts of admins attached to this booth though)</small>
							<br><br> Yes, I want to logout!`,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, delete it!',
				cancelButtonText: 'Cancel'
			}).then((result) => {
				if (result.isConfirmed) {

					Swal.fire({
						title: 'Please Wait',
						text: 'Deleting the sponsor...',
						imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
						imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
						imageAlt: 'Loading...',
						showCancelButton: false,
						showConfirmButton: false,
						allowOutsideClick: false
					});

					$.get(project_admin_url+"/sponsors/delete/"+sponsorId, function (response)
					{
						Swal.close();

						response = JSON.parse(response);

						if (response.status == 'success')
							toastr.success(`Sponsor ${sponsorName} deleted`);

						else
							toastr.error('Error');

						listSponsors();
					});
				}
			})
		});

		$('#usersTable').on('click', '.reset-user-pass-btn', function () {
			resetUserPassword($(this).attr('user-id'), $(this).attr('user-name'));
		});

	});

	function listUsers()
	{
		Swal.fire({
			title: 'Please Wait',
			text: 'Loading users data...',
			imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
			imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
			imageAlt: 'Loading...',
			showCancelButton: false,
			showConfirmButton: false,
			allowOutsideClick: false
		});

		$.get(project_admin_url+"/users/getAllExhibitorsWithoutBoothJson", function (users) {
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
						'		'+user.name+
						'	</td>' +
						'	<td>' +
						'		'+user.surname+
						'	</td>' +
						'	<td>' +
						'		'+user.email+
						'	</td>' +
						'	<td>' +
						'		'+accessList+
						'	</td>' +
						'	<td>' +
						'		<button class="manage-user btn btn-sm btn-info m-2" user-id="'+user.id+'"><i class="fas fa-edit"></i> Manage</button>' +
						'		<button class="reset-user-pass-btn btn btn-sm btn-success m-2 text-white" user-id="'+user.id+'" user-name="'+user.name+'"><i class="fas fa-lock-open"></i> Reset Password</button>'+
						'		<button class="suspend-user btn btn-sm btn-warning m-2 text-white" user-id="'+user.id+'" user-name="'+user.name+'"><i class="fas fa-user-slash"></i> Suspend</button>'+
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
	}

	function resetUserPassword(userId, userName)
	{
		Swal.fire({
			title: 'Are you sure?',
			html: "You are about to reset<strong>"+userName+"</strong>'s password to 'COS2021' (without quotes)",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, reset it!',
			cancelButtonText: 'Cancel'
		}).then((result) => {
			if (result.isConfirmed) {
				Swal.fire({
					title: 'Please Wait',
					text: "Resetting "+userName+"'s password...",
					imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
					imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
					imageAlt: 'Loading...',
					showCancelButton: false,
					showConfirmButton: false,
					allowOutsideClick: false
				});

				$.get(project_admin_url+"/users/resetPasswordOf/"+userId, function (response) {
					response = JSON.parse(response);

					if (response.status == 'success')
						Swal.fire(
							'Done!',
							userName+"'s password is now reset to COS2021",
							'success'
						);
					else
						Swal.fire(
							"Error!",
							"Unable to reset the password",
							'error'
						);
				});

			}
		})
	}
</script>
