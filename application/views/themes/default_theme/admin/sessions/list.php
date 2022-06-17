<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>
<style>
#sessionsTable_filter, #sessionsTable_paginate{float: right;}
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Sessions</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=$this->project_url.'/admin/dashboard'?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Sessions</li>
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
							<h3 class="card-title">All sessions</h3>
							<button class="add-session-btn btn btn-success float-right"><i class="fas fa-plus"></i> Add</button>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<table id="sessionsTable" class="table table-bordered table-striped">
								<thead>
									<tr>
										<th>Session ID</th>
										<th>Day</th>
										<th>Start Time</th>
										<th>End Time</th>
										<th>People</th>
										<th>Credits</th>
										<th>Name</th>
										<th>Actions</th>
										<th>Manage</th>
									</tr>
								</thead>
								<tbody id="sessionsTableBody">
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

		listSessions();

		$('#sessionsTable').DataTable({
			"paging": true,
			"lengthChange": true,
			"searching": true,
			"ordering": true,
			"info": true,
			"autoWidth": false,
			"responsive": true,
		});

		$('.add-session-btn').on('click', function () {

			$('#addSessionForm')[0].reset();
			$('#currentPhotoDiv').hide();
			$('#sessionDescription').summernote('reset');
			$('.removeall').click();
			// $('#sponsorId').val(0);
			// $('#logo_preview').hide();
			// $('#logo_label').text('');
			// $('#banner_preview').hide();
			// $('#banner_label').text('');
			$('#save-session').html('<i class="fas fa-plus"></i> Create');

			$('#addSessionModal').modal({
				backdrop: 'static',
				keyboard: false
			});
		});

		$('#sessionsTable').on('click', '.manageSession', function () {

			let session_id = $(this).attr('session-id');

			Swal.fire({
				title: 'Please Wait',
				text: 'Loading session data...',
				imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
				imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
				imageAlt: 'Loading...',
				showCancelButton: false,
				showConfirmButton: false,
				allowOutsideClick: false
			});

			$.get(project_admin_url+"/sessions/getByIdJson/"+session_id, function (session) {
				session = JSON.parse(session);
				console.log(session);
				$('#sessionId').val(session.id);
				$('#sessionName').val(session.name);
				$('#sessionNameOther').val(session.other_language_name);
				$(`#sessionTrack option[value="${session.track}"]`).prop('selected', true);

				$('#sessionExternalUrl').val('');
				$('#sessionExternalUrlDiv').hide();
				$('#sessionExternalUrl').val(session.external_meeting_link);

				if (session.external_meeting_link != null || session.external_meeting_link == '' )
					$('#sessionExternalUrlDiv').show();

				$(`#sessionType option[value="${session.session_type}"]`).prop('selected', true);

				$('#sessionCredits').val(session.credits);
				$("#sessionDescription").summernote("code", session.description);
				$('#startDateTimeInput').datetimepicker('date', moment(session.start_date_time, 'YYYY-MM-DD HH:mm:ss'));
				$('#endDateTimeInput').datetimepicker('date', moment(session.end_date_time, 'YYYY-MM-DD HH:mm:ss'));

				$('#sessionPhoto').val('');
				if (session.thumbnail != '') {
					$('#currentPhotoImg').attr('src', '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/thumbnails/'+session.thumbnail);
					$('#currentPhotoDiv').show();
				}else{
					$('#currentPhotoDiv').hide();
				}

				$("#sessionAgenda").summernote("code", session.agenda);
				$('#millicastStream').val(session.millicast_stream);
				$('#zoomLink').val(session.zoom_link);
				$('#sessionVideo').val(session.video_url);
				$('#slidesHtml').html(session.presenter_embed_code);

				// Moderators
				$('select[name="sessionModerators[]"] option').prop('selected', false);
				$('select[name="sessionModerators[]"]').bootstrapDualListbox('refresh', true);
				$.each(session.moderators, function(key, moderator){
					$('select[name="sessionModerators[]"] option[value="'+moderator.id+'"]').prop('selected', true);
				});
				$('select[name="sessionModerators[]"]').bootstrapDualListbox('refresh', true);

				// Keynote Speakers
				$('select[name="sessionKeynoteSpeakers[]"] option').prop('selected', false);
				$('select[name="sessionKeynoteSpeakers[]"]').bootstrapDualListbox('refresh', true);
				$.each(session.keynote_speakers, function(key, keynote_speaker){
					$('select[name="sessionKeynoteSpeakers[]"] option[value="'+keynote_speaker.id+'"]').prop('selected', true);
				});
				$('select[name="sessionKeynoteSpeakers[]"]').bootstrapDualListbox('refresh', true);

				// Presenters
				$('select[name="sessionPresenters[]"] option').prop('selected', false);
				$('select[name="sessionPresenters[]"]').bootstrapDualListbox('refresh', true);
				$.each(session.presenters, function(key, presenter){
					$('select[name="sessionPresenters[]"] option[value="'+presenter.id+'"]').prop('selected', true);
				});
				$('select[name="sessionPresenters[]"]').bootstrapDualListbox('refresh', true);

				// Invisible Moderators
				$('select[name="sessionInvisibleModerators[]"] option').prop('selected', false);
				$('select[name="sessionInvisibleModerators[]"]').bootstrapDualListbox('refresh', true);
				$.each(session.invisible_moderators, function(key, invisible_moderator){
					$('select[name="sessionInvisibleModerators[]"] option[value="'+invisible_moderator.id+'"]').prop('selected', true);
				});
				$('select[name="sessionInvisibleModerators[]"]').bootstrapDualListbox('refresh', true);


				//Settings
				if(session.header_toolbox_status == 1){
					$('#headerToolboxSwitch').attr('checked','checked')
				}
				if(session.right_sticky_notes == 1){
					$('#rightNotesSwitch').attr('checked','checked')
				}
				if(session.right_sticky_resources == 1){
					$('#rightResourcesSwitch').attr('checked','checked')
				}
				if(session.right_sticky_question == 1){
					$('#rightQuestionSwitch').attr('checked','checked')
				}

				$('#save-session').html('<i class="fas fa-save"></i> Save');

				Swal.close();

				$('#addSessionModal').modal({
					backdrop: 'static',
					keyboard: false
				});
			});
		});

		$('#sessionsTable').on('click', '.removeSession', function () {
			let session_id = $(this).attr('session-id');
			let session_name = $(this).attr('session-name');

			Swal.fire({
				title: 'Are you sure?',
				html: '<span class="text-white">You are about to remove<br>['+session_id+'] '+session_name+'<br><br><small>(We will still keep it in our records for auditing)</small></span>',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, remove it!'
			}).then((result) => {
				if (result.isConfirmed) {

					Swal.fire({
						title: 'Please Wait',
						text: 'Removing the session...',
						imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
						imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
						imageAlt: 'Loading...',
						showCancelButton: false,
						showConfirmButton: false,
						allowOutsideClick: false
					});

					$.get(project_admin_url+"/sessions/remove/"+session_id, function (response) {
						response = JSON.parse(response);

						if (response.status == 'success') {
							listSessions();
							toastr.success(session_name+" has been removed!");
						}else{
							Swal.fire(
									'Error!',
									'Unable to remove '+session_name,
									'error'
							);
						}
					});
				}
			});
		});

		$('#sessionsTable').on('click', '.openPoll', function () {
			socket.emit('openPoll');
		});

		$('#sessionsTable').on('click', '.closePoll', function () {
			socket.emit('closePoll');
		});

		$('#sessionsTable').on('click', '.openResult', function () {
			socket.emit('openResult');
		});

		$('#sessionsTable').on('click', '.closeResult', function () {
			socket.emit('closeResult');
		});
	});

	function listSessions()
	{
		Swal.fire({
			title: 'Please Wait',
			text: 'Loading sessions data...',
			imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
			imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
			imageAlt: 'Loading...',
			showCancelButton: false,
			showConfirmButton: false,
			allowOutsideClick: false
		});

		$.get(project_admin_url+"/sessions/getAllJson", function (sessions) {
			sessions = JSON.parse(sessions);

			$('#sessionsTableBody').html('');
			if ($.fn.DataTable.isDataTable('#sessionsTable'))
			{
				$('#sessionsTable').dataTable().fnClearTable();
				$('#sessionsTable').dataTable().fnDestroy();
			}

			$.each(sessions, function(key, session)
			{
				// Moderators badge
				let moderatorsList = '';
				let moderatorsNumber = Object.keys(session.moderators).length;
				let moderatorsBadgeType = 'badge-danger';

				if (moderatorsNumber > 0)
					moderatorsList += '<strong>Moderators List</strong><br><br>';

				$.each(session.moderators, function(key, moderator)
				{
					moderatorsList += moderator.name+' '+moderator.surname+' <br>('+moderator.email+')<br><br>';
				});

				if (moderatorsNumber > 0)
					moderatorsBadgeType = 'badge-success';

				let moderatorsBadge = '<badge class="badge badge-pill '+moderatorsBadgeType+'" data-html="true" data-toggle="tooltip" title="'+moderatorsList+'">M ('+moderatorsNumber+')</badge>';

				// Invisible Moderators badge
				let invisibleModeratorsList = '';
				let invisibleModeratorsNumber = Object.keys(session.invisible_moderators).length;
				let invisibleModeratorsBadgeType = 'badge-danger';

				if (invisibleModeratorsNumber > 0)
					invisibleModeratorsList += '<strong>Invisible Moderators</strong><br><br>';

				$.each(session.invisible_moderators, function(key, moderator)
				{
					invisibleModeratorsList += moderator.name+' '+moderator.surname+' <br>('+moderator.email+')<br><br>';
				});

				if (invisibleModeratorsNumber > 0)
					invisibleModeratorsBadgeType = 'badge-success';

				let invisibleModeratorsBadge = '<badge class="badge badge-pill '+invisibleModeratorsBadgeType+'" data-html="true" data-toggle="tooltip" title="'+invisibleModeratorsList+'">InM ('+invisibleModeratorsNumber+')</badge>';

				// Keynote Speakers badge
				let keynoteSpeakersList = '';
				let keynoteSpeakersNumber = Object.keys(session.keynote_speakers).length;
				let keynoteSpeakerBadgeType = 'badge-danger';

				if (keynoteSpeakersNumber > 0)
					keynoteSpeakersList += '<strong>Keynote Speakers List</strong><br><br>';

				$.each(session.keynote_speakers, function(key, keynote_speaker)
				{
					keynoteSpeakersList += keynote_speaker.name+' '+keynote_speaker.surname+' <br>('+keynote_speaker.email+')<br><br>';
				});

				if (keynoteSpeakersNumber > 0)
					keynoteSpeakerBadgeType = 'badge-success';

				let keynoteSpeakersBadge = '<badge class="badge badge-pill '+keynoteSpeakerBadgeType+'" data-html="true" data-toggle="tooltip" title="'+keynoteSpeakersList+'">K ('+keynoteSpeakersNumber+')</badge>';

				// Presenters badge
				let presentersList = '';
				let presentersNumber = Object.keys(session.presenters).length;
				let presenterBadgeType = 'badge-danger';

				if (presentersNumber > 0)
					presentersList += '<strong>Presenters List</strong><br><br>';

				$.each(session.presenters, function(key, presenter)
				{
					presentersList += presenter.name+' '+presenter.surname+' <br>('+presenter.email+')<br><br>';
				});

				if (presentersNumber > 0)
					presenterBadgeType = 'badge-success';

				let presentersBadge = '<badge class="badge badge-pill '+presenterBadgeType+'" data-html="true" data-toggle="tooltip" title="'+presentersList+'">P ('+presentersNumber+')</badge>';

				$('#sessionsTableBody').append(
					'<tr>' +
					'	<td>' +
					'		'+session.id+
					'	</td>' +
					'	<td>' +
					'		'+moment.tz(session.start_date_time, "<?=$this->project->timezone?>").format("MMMM Do (dddd)")+
					'	</td>' +
					'	<td>' +
					'		'+moment.tz(session.start_date_time, "<?=$this->project->timezone?>").format("h:mmA")+
					'	</td>' +
					'	<td>' +
					'		'+moment.tz(session.end_date_time, "<?=$this->project->timezone?>").format("h:mmA")+
					'	</td>' +
					'	<td>' +
					'		'+moderatorsBadge+' '+keynoteSpeakersBadge+' '+presentersBadge+' '+invisibleModeratorsBadge+
					'	</td>' +
					'	<td>' +
					'		'+session.credits+
					'	</td>' +
					'	<td>' +
					'		'+session.name+
					'	</td>' +
					'	<td>' +
					'		<a href="'+project_admin_url+'/sessions/view/'+session.id+'">' +
					'			<button class="btn btn-sm btn-info m-1"><i class="fas fa-tv"></i> View</button>' +
					'		</a>' +
					'		<a target="_blank" href="'+project_admin_url+'/sessions/polls/'+session.id+'">' +
					'			<button class="btn btn-sm btn-success m-1">Polls <i class="fas fa-external-link-alt"></i></button>' +
					'		</a>' +
					'	</td>' +
					'	<td>' +
					'		<button class="manageSession btn btn-sm btn-primary m-1" session-id="'+session.id+'"><i class="fas fa-edit"></i> Edit</button>' +
					'		<button class="removeSession btn btn-sm btn-danger m-1" session-id="'+session.id+'" session-name="'+session.name+'"><i class="fas fa-trash-alt"></i> Remove</button>' +
					'		<!--<button class="openPoll btn btn-sm btn-primary">Open Poll</button>-->' +
					'		<!--<button class="closePoll btn btn-sm btn-primary">Close Poll</button>-->' +
					'		<!--<button class="openResult btn btn-sm btn-primary">Open Result</button>-->' +
					'		<!--<button class="closeResult btn btn-sm btn-primary">Close Result</button>-->' +
					'	</td>' +
					'</tr>'
				);
			});

			$('[data-toggle="tooltip"]').tooltip();

			$('#sessionsTable').DataTable({
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
