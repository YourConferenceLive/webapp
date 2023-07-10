<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
<style>
#eposterTable_filter, #eposterTable_paginate{float: right;}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">ePosters</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=$this->project_url.'/admin/dashboard'?>">Dashboard</a></li>
						<li class="breadcrumb-item active">ePosters</li>
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
							<h3 class="card-title">All ePosters</h3>
							<button class="add-eposter-btn btn btn-success float-right"><i class="fas fa-plus"></i> Add</button>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<table id="eposterTable" class="table table-bordered table-striped">
								<thead>
								<tr>
									<th>ePoster ID</th>
									<th>Track</th>
									<th>Type</th>
									<th>Title</th>
									<th>Credit</th>
									<th>Authors</th>
									<th>Prize</th>
									<th>Status</th>
									<th>Actions</th>
									<th>Manage</th>
								</tr>
								</thead>
								<tbody id="eposterTableBody">
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
	$(function () {

		listePosters();

		$('#eposterTable').DataTable({
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": false,
			"responsive": true,
		});

		$('.add-eposter-btn').on('click', function () {
			$('#addePosterForm')[0].reset();
			$('#currentPhotoDiv').hide();
			// $('.removeall').click();
			// $('#sponsorId').val(0);
			// $('#logo_preview').hide();
			// $('#logo_label').text('');
			// $('#banner_preview').hide();
			// $('#banner_label').text('');
			$('#save-eposter').html('<i class="fas fa-plus"></i> Create');

			$('#addePosterModal').modal({
				backdrop: 'static',
				keyboard: false
			});
		});

		$('#eposterTable').on('click', '.manageEposter', function () {

			let eposter_id = $(this).attr('eposter-id');


			const translationData = fetchAllText(); // Fetch the translation data

            translationData.then((arrData) => {
                const selectedLanguage = $('#languageSelect').val(); // Get the selected language

                // Find the translations for the dialog text
                let dialogTitle = 'Please Wait';
                let dialogText = 'Loading ePoster data...';
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
                
            });

			$.get(project_admin_url+"/eposters/getByIdJson/"+eposter_id, function (eposter) {
				eposter = JSON.parse(eposter);

				$('#eposterId').val(eposter.id);
				$('#eposterName').val(eposter.title);
				$(`#eposterPrize option[value="${eposter.prize}"]`).prop('selected', true);
				$(`#eposterTrack option[value="${eposter.track}"]`).prop('selected', true);
				$(`#eposterType option[value="${eposter.eposter_type}"]`).prop('selected', true);
				$(`#eposterStatus option[value="${eposter.status}"]`).prop('selected', true);
				$('#eposterCredits').val(eposter.credits);
				$('#eposterControlNumber').val(eposter.control_number);

				$('#eposterPhoto').val('');

				if (typeof(eposter.eposter) == 'undefined')
					eposter.eposter = '';

				if (typeof(eposter.eposter) == null)
					eposter.eposter = '';


				if (eposter.eposter != '') {
					$('#eposterOldPoster').val(eposter.eposter);
					$('#currentPhotoImg').attr('src', '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/eposters/thumbnails/'+eposter.eposter);
					$('#currentPhotoDiv').show();
				}else{
					$('#currentPhotoDiv').hide();
				}

				$('#videoLink').val(eposter.video_url);

				// Authors
				$('select[name="eposterAuthors[]"] option').prop('selected', false);
				$('select[name="eposterAuthors[]"]').bootstrapDualListbox('refresh', true);
				$.each(eposter.authors, function(key, author) {
					$('select[name="eposterAuthors[]"] option[value="'+author.id+'"]').prop('selected', true);
				});
				$('select[name="eposterAuthors[]"]').bootstrapDualListbox('refresh', true);

				$('#save-eposter').html('<i class="fas fa-save"></i> Save');

				Swal.close();

				$('#addePosterModal').modal({
					backdrop: 'static',
					keyboard: false
				});
			});
		});

		$('#eposterTable').on('click', '.removeEposter', function () {
			let eposter_id = $(this).attr('eposter-id');
			let eposter_name = $(this).attr('eposter-name');
			let eposter_poster = $(this).attr('eposter-eposter');



			const translationData = fetchAllText(); // Fetch the translation data

            translationData.then((arrData) => {
                const selectedLanguage = $('#languageSelect').val(); // Get the selected language

                // Find the translations for the dialog text
                let dialogTitle = 'Are you sure?';
				let html1 = "You are about to remove";
                let confirmButtonText = 'Yes, remove it!';
                let cancelButtonText = 'Cancel';

				// Swal 2
				let dialogTitle2 = 'Please Wait';
				let dialogText2 = "Removing the ePoster...";
				let imageAltText = 'Loading...';
				
				// Toast
				let removedText = "has been removed!";
				let errorText ="Error!";
				let errorMsg = "Unable to remove";


                for (let i = 0; i < arrData.length; i++) {
                    if (arrData[i].english_text === dialogTitle) {
                        dialogTitle = arrData[i][selectedLanguage + '_text'];
                    }
					if (arrData[i].english_text === html1) {
                        html1 = arrData[i][selectedLanguage + '_text'];
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
                    if (arrData[i].english_text === dialogText2) {
                        dialogText2 = arrData[i][selectedLanguage + '_text'];
                    }
                    if (arrData[i].english_text === imageAltText) {
                        imageAltText = arrData[i][selectedLanguage + '_text'];
                    }

					if (arrData[i].english_text === removedText) {
                        removedText = arrData[i][selectedLanguage + '_text'];
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
					html: '<span class="text-white">'+html1+'<br>['+eposter_id+'] '+eposter_name+'<br></span>',
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
							text: dialogText2,
							imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
							imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
							imageAlt: imageAltText,
							showCancelButton: false,
							showConfirmButton: false,
							allowOutsideClick: false
						});
	
						$.get(project_admin_url+"/eposters/remove/"+eposter_id, function (response) {
							response = JSON.parse(response);
	
							if (response.status == 'success')
							{
								listePosters();
								toastr.success(eposter_name+" "+removedText);
							}else{
								Swal.fire(
									errorText,
										errorMsg+' '+eposter_name,
										'error'
								);
							}
						}); 
					}
				});
                
            });
		});

		$('#eposterTable').on('click', '.openPoll', function () {
			socket.emit('openPoll');
		});

		$('#eposterTable').on('click', '.closePoll', function () {
			socket.emit('closePoll');
		});

		$('#eposterTable').on('click', '.openResult', function () {
			socket.emit('openResult');
		});

		$('#eposterTable').on('click', '.closeResult', function () {
			socket.emit('closeResult');
		});
	});

	function listePosters()
	{


		const translationData = fetchAllText(); // Fetch the translation data

		translationData.then((arrData) => {
			const selectedLanguage = $('#languageSelect').val(); // Get the selected language

			// Find the translations for the dialog text
			let dialogTitle = 'Please Wait';
			let dialogText = 'Loading ePosters data...';
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
			
		});




		$.get(project_admin_url+"/eposters/getAllJson", function (eposters) {
			eposters = JSON.parse(eposters);

			$('#eposterTableBody').html('');
			if ($.fn.DataTable.isDataTable('#eposterTable'))
			{
				$('#eposterTable').dataTable().fnClearTable();
				$('#eposterTable').dataTable().fnDestroy();
			}

			$.each(eposters, function(key, eposter)
			{
				// Authors badge
				let authorsList = '';
				let authorsNumber = Object.keys(eposter.authors).length;
				let authorBadgeType = 'badge-danger';
				if (authorsNumber > 0)
					authorsList += '<strong>Authors List</strong><br><br>';
				$.each(eposter.authors, function(key, author)
				{
					authorsList += author.name+' '+author.surname+' <br>('+author.email+')<br><br>';
				});

				if (authorsNumber > 0)
					authorBadgeType = 'badge-success';
				let authorsBadge = '<badge class="badge badge-pill '+authorBadgeType+'" data-html="true" data-toggle="tooltip" title="'+authorsList+'">A ('+authorsNumber+')</badge>';

				let iPrize = 'N/A';

				if (typeof(eposter.prize) == 'string') {
					iPrize = eposter.prize;
					iPrize = iPrize.toLowerCase().replace(/\b[a-z]/g, function(letter) {
	    				return letter.toUpperCase();
					});
				}

				$('#eposterTableBody').append(
					'<tr>' +
					'	<td>' +
					'		'+eposter.id+
					'	</td>' +
					'	<td>' +
					'		'+eposter.track+
					'	</td>' +
					'	<td>' +
					'		'+((eposter.type == 'eposter') ? 'ePoster' : 'Surgical Video' )+
					'	</td>' +
					'	<td>' +
					'		'+eposter.title+
					'	</td>' +
					'	<td>' +
					'		'+eposter.credits+
					'	</td>' +
					'	<td>' +
					'		'+authorsBadge+
					'	</td>' +
					'	<td>' +
					'		'+iPrize+
					'	</td>' +
					'	<td>' +
					'		'+((eposter.status == 1) ? 'Active' : 'Inactive' )+
					'	</td>' +
					'	<td>' +
					'		<a href="'+project_url+'/admin/eposters/view/'+eposter.id+'">' +
					'			<button class="btn btn-sm btn-info"><i class="fas fa-tv"></i> View</button>' +
					'		</a>' +
					'	</td>' +
					'	<td>' +
					'		<button class="manageEposter btn btn-sm btn-primary m-1" eposter-id="'+eposter.id+'"><i class="fas fa-edit"></i> Edit</button>' +
					'		<button class="removeEposter btn btn-sm btn-danger m-1" eposter-id="'+eposter.id+'" eposter-name="'+eposter.title+'"><i class="fas fa-trash-alt"></i> Remove</button>' +
					'	</td>' +
					'</tr>'
				);
			});

			$('[data-toggle="tooltip"]').tooltip();

			$('#eposterTable').DataTable({
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
</script>
