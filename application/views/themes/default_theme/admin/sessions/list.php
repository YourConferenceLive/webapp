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
									<th>Name</th>
									<th>Actions</th>
									<th>Manage</th>
								</tr>
								</thead>
								<tbody id="sessionsTableBody">
								<?php if (isset($sessions)) {
									foreach ($sessions as $session): ?>
										<tr>
											<td><?=$session->id?></td>
											<td><?=date("l - jS M", strtotime($session->start_date_time))?></td>
											<td><?=date("g:iA", strtotime($session->start_date_time))?></td>
											<td><?=date("g:iA", strtotime($session->end_date_time))?></td>
											<td><?=$session->name?></td>
											<td>
												<a href="<?=$this->project_url.'/admin/sessions/view/'.$session->id?>">
													<button class="btn btn-sm btn-info"><i class="fas fa-tv"></i> View</button>
												</a>

											</td>
											<td>
												<a href="#">
													<button class="btn btn-sm btn-primary"><i class="fas fa-edit"></i> Manage</button>
													<button id="openPoll" class="btn btn-sm btn-primary">Open Poll</button>
													<button id="closePoll" class="btn btn-sm btn-primary">Close Poll</button>
													<button id="openResult" class="btn btn-sm btn-primary">Open Result</button>
													<button id="openResult" class="btn btn-sm btn-primary">Close Result</button>
												</a>
											</td>
										</tr>
									<?php endforeach;
								} ?>
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
				$('#sessionTrack option[value="'+session.track+'"]').prop('selected', true);
				$("#sessionDescription").summernote("code", session.description);
				$('#startDateTimeInput').datetimepicker('date', moment(session.start_date_time, 'YYYY-MM-DD HH:mm:ss'));
				$('#endDateTimeInput').datetimepicker('date', moment(session.end_date_time, 'YYYY-MM-DD HH:mm:ss'));

				if (session.thumbnail != '')
				{
					$('#currentPhotoImg').attr('src', '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/thumbnails/'+session.thumbnail);
					$('#currentPhotoDiv').show();
				}

				$("#sessionAgenda").summernote("code", session.agenda);
				$('#millicastStream').val(session.millicast_stream);
				$('#slidesHtml').html(session.presenter_embed_code);

				$.each(session.presenters, function(key, presenter){
					$('select[name="sessionPresenters[]"] option[value="'+presenter.id+'"]').prop('selected', true);
					$('select[name="sessionPresenters[]"]').bootstrapDualListbox('refresh', true);
					//$('#bootstrap-duallistbox-selected-list_sessionPresenters').append('<option value="'+presenter.id+'">'+presenter.name+' '+presenter.surname+' ('+presenter.email+')</option>');
				});

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
				$('#sessionsTableBody').append(
					'<tr>' +
					'	<td>' +
					'		'+session.id+
					'	</td>' +
					'	<td>' +
					'		'+moment.tz(session.start_date_time, "<?=$this->project->timezone?>").format("dddd - Do of MMM")+
					'	</td>' +
					'	<td>' +
					'		'+moment.tz(session.start_date_time, "<?=$this->project->timezone?>").format("h:mmA")+
					'	</td>' +
					'	<td>' +
					'		'+moment.tz(session.end_date_time, "<?=$this->project->timezone?>").format("h:mmA")+
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
