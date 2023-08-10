<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo"<pre>";print_r($sessions);exit("</pre>");
?>

<style>
	#sessionsTable_filter, #sessionsTable_paginate{
		float: right;
	}
	.form-control::placeholder{
		color: lightblue;
	}
	.datatable-container {
    height: 100%; /* Set the container to occupy full height */
	}
	#pollsTable_wrapper{
		width: 97%;
		margin: auto;
	}

</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="background-image:linear-gradient(#D7D7D7, #D7D7D7); background-size:cover; height:100vh; width:100vw;">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Session Polls</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=$this->project_url.'/admin/dashboard'?>">Dashboard</a></li>
						<li class="breadcrumb-item active"><a href="<?=$this->project_url.'/admin/sessions'?>">Sessions</a></li>
						<li class="breadcrumb-item active">Polls</li>
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
					<div class="card"style="height:100vh;" >
						<div class="card-header">
							<h3 class="card-title">All polls for the session: [<?=$session->id?>] <?=$session->name?></h3>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<div class="card" style="overflow-x:auto; padding-top:10px">
								<table id="pollsTable" class="table table-bordered table-striped" style="">
									<thead>
									<tr>
										<th>Poll ID</th>
										<th>Name</th>
										<th>Question</th>
										<th>Type</th>
										<th>Comparison ID</th>
										<th>Slide Number</th>
										<th>Instruction</th>
										<th>Poll Answer</th>
									</tr>
									</thead>
									<tbody id="pollsTableBody">

									</tbody>
								</table>
							</card>
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

		listPolls();
		

	});

	function listPolls()
	{
		const translationData = fetchAllText(); // Fetch the translation data

		translationData.then((arrData) => {
			const selectedLanguage = $('#languageSelect').val(); // Get the selected language

			// Find the translations for the dialog text
			let dialogTitle = 'Please Wait';
			let dialogText = 'Loading poll data...';
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

			$.get(project_admin_url+"/sessions/getAllPollsJson/<?=$session->id?>", function (polls) {
				polls = JSON.parse(polls);
	
				$('#pollsTableBody').html('');
				if ($.fn.DataTable.isDataTable('#pollsTable'))
				{
					$('#pollsTable').dataTable().fnClearTable();
					$('#pollsTable').dataTable().fnDestroy();
				}
	
				$.each(polls, function(key, poll)
				{
					let show_result = (poll.show_result==1)?'Yes':'No';
					let launchPollBtn = ((poll.is_launched === '0')?'<button class="launch-poll-btn btn btn-sm btn-info" poll-id="'+poll.id+'"><i class="fas fa-list-ol"></i> Launch</button>' : '<button class="launch-poll-btn btn btn-sm btn-warning" poll-id="'+poll.id+'"><i class="fas fa-sync-alt"></i> Launch Again</button>' );
					let startTimer10 = '<button class="startTimer10 btn btn-sm btn-info" poll-id="'+poll.id+'" timer="10"><i class="fas fa-clock"></i> Start Timer 10s'+"'"+'</button>';
					let startTimer15 = '<button class="startTimer15 btn btn-sm btn-info" poll-id="'+poll.id+'" timer="15"><i class="fas fa-clock"></i> Start Timer 15s'+"'"+'</button>';
					let closePoll = '<button class="closePoll btn btn-sm '+(poll.is_poll_closed == 1 ? "btn-danger-muted": "btn-danger")+' mt-md-2" poll-id="'+poll.id+'" session-id="'+poll.session_id+'"> <i class="fas fa-ban"></i>  Close Poll</button>';
	
					$('#pollsTableBody').append(
						'<tr>' +
						'	<td>' +
						'		'+poll.id+
						'	</td>' +
						'	<td>' +
						'		'+poll.poll_name+
						'	</td>' +
						'	<td>' +
						'		'+poll.poll_question+
						'	</td>' +
						'	<td>' +
						'		'+poll.poll_type+
						'	</td>' +
						'	<td>' +
						'		'+((poll.poll_comparison_id !=='0')? poll.poll_comparison_id :'')+
						'	</td>' +
						'	<td>' +
						'		'+((poll.slide_number !== null)? poll.slide_number : '')+
						'	</td>' +
						'	<td>' +
						'		'+((poll.poll_instruction !== null)? poll.poll_instruction : '')+
						'	</td>' +
						'	<td style="width:120px">' +
						'		<div>'+((poll.correct_answer1 !== null && poll.correct_answer1 !== '0')? "<span>Answer 1: <span><span style='color:red; font-size:25px'>"+poll.correct_answer1+"</span>" : '')+'</div>'+
						'		<div>'+((poll.correct_answer2 !== null && poll.correct_answer2 !== '0')? "<span>Answer 2: <span><span style='color:red; font-size:25px'>"+poll.correct_answer2+"</span>" : '')+'</div>'+
						'	</td>' +
					
						'</tr>'
					);
				});
	
				$('[data-toggle="tooltip"]').tooltip();
	
				$('#pollsTable').DataTable({
					"paging": false,
					"lengthChange": true,
					"searching": true,
					"ordering": true,
					"info": true,
					"autoWidth": true,
					"responsive": false,
					"order": [[ 0, "asc" ]],
					"destroy": true
				});
	
				Swal.close();
			});
		});
	}
</script>
