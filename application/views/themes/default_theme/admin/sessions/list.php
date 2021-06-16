<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo"<pre>";print_r($sessions);exit("</pre>");
?>

<style>
	#sessionsTable_filter, #sessionsTable_paginate{
		float: right;
	}
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

				$('#sessionId').val(session.id);
				$('#sessionName').val(session.name);
				$('#sessionNameOther').val(session.other_language_name);
				$('#sessionTrack option[value="'+session.track+'"]').prop('selected', true);
				$("#sessionDescription").summernote("code", session.description);
				$('#startDateTimeInput').datetimepicker('date', moment(session.start_date_time, 'YYYY-MM-DD HH:mm:ss'));
				$('#endDateTimeInput').datetimepicker('date', moment(session.end_date_time, 'YYYY-MM-DD HH:mm:ss'));

				if (session.thumbnail != '')
				{
					$('#currentPhotoImg').attr('src', '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/thumbnails/'+session.thumbnail);
					$('#currentPhotoDiv').show();
				}else{
					$('#currentPhotoDiv').hide();
				}

				$("#sessionAgenda").summernote("code", session.agenda);
				$('#millicastStream').val(session.millicast_stream);
				$('#zoomLink').val(session.zoom_link);
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

				$('#save-session').html('<i class="fas fa-save"></i> Save');

				Swal.close();

				$('#addSessionModal').modal({
					backdrop: 'static',
					keyboard: false
				});
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
					'		'+moderatorsBadge+' '+keynoteSpeakersBadge+' '+presentersBadge+
					'	</td>' +
					'	<td>' +
					'		'+session.name+
					'	</td>' +
					'	<td>' +
					'		<a href="'+project_admin_url+'/sessions/view/'+session.id+'">' +
					'			<button class="btn btn-sm btn-info"><i class="fas fa-tv"></i> View</button>' +
					'		</a>' +
					'	</td>' +
					'	<td>' +
					'		<button class="manageSession btn btn-sm btn-primary" session-id="'+session.id+'"><i class="fas fa-edit"></i> Manage</button>' +
					'		<button class="openPoll btn btn-sm btn-primary">Open Poll</button>' +
					'		<button class="closePoll btn btn-sm btn-primary">Close Poll</button>' +
					'		<button class="openResult btn btn-sm btn-primary">Open Result</button>' +
					'		<button class="closeResult btn btn-sm btn-primary">Close Result</button>' +
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
