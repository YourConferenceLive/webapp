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
<div class="content-wrapper" >
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
										<th>View Options</th>
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
<div class="modal fade overflow-auto" id="addPollModal" tabindex="-1" role="dialog" aria-labelledby="addPollModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content overflow-auto">
			<div class="modal-header">
				<h5 class="modal-title" id="addPollModalLabel"><i class="fas fa-poll-h"></i> Add New Poll</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body overflow-auto">

				<form id="addPollForm">

					<h4>Poll Name</h4>
					<div class="form-group m">
						<input type="text" class="form-control form-control-border" id="pollNameInput" name="pollNameInput" placeholder="Enter Poll Name">
					</div>
					
					<h4>Question</h4>
					<div class="form-group m">
						<textarea type="text" class="form-control form-control-border" id="pollQuestionInput" name="pollQuestionInput" placeholder="Enter the poll question"></textarea>
					</div>

					<h4>External Reference</h4>
					<div class="form-group m">
						<input type="text" class="form-control form-control-border" id="pollQuestionReferenceInput" name="pollQuestionReferenceInput" placeholder="Enter the poll external reference">
					</div>

					<h4>Slide Number</h4>
					<div class="form-group m">
						<input type="text" class="form-control form-control-border" id="slideNumberInput" name="slideNumberInput" placeholder="Enter how many slides">
					</div>

					<h4>Poll Instruction</h4>
					<div class="form-group m">
						<textarea type="text" class="form-control form-control" id="pollInstructionInput" name="pollInstructionInput" placeholder="Poll Instruction"></textarea>
					</div>


					<h5 class="mb-3">Poll Options
						<button type="button" class="add-new-option-btn btn btn-sm btn-outline-success ml-1" data-toggle="tooltip" data-placement="right" title="Click to add one more option"><i class="fas fa-plus"></i></button></h5>
					<div id="pollOptionsInputDiv">

						<div class="input-group input-group-sm mb-2">
							<input type="text" name="pollOptionsInput[]" class="form-control pollOptions" onkeyup="appendCorrectAnswer1(); appendCorrectAnswer2()">
							<span class="input-group-append">
								<button type="button" class="delete-option-button btn btn-danger btn-flat"><i class="fas fa-trash"></i></button>
							</span>
						</div>

						<div class="input-group input-group-sm mb-2">
							<input type="text" name="pollOptionsInput[]" class="form-control pollOptions" onkeyup="appendCorrectAnswer1()">
							<span class="input-group-append">
								<button type="button" class="delete-option-button btn btn-danger btn-flat"><i class="fas fa-trash"></i></button>
							</span>
						</div>



					</div>

					<div class="form-group mt-5">
						<label>Type</label>
						<select class="form-control" name="poll_type" id="poll_type_select">
							<option value="poll">Poll</option>
							<option value="presurvey">Presurvey</option>
							<option value="assessment">Assessment</option>
						</select>
					</div>

					<div class="form-group mt-5">
						<label>Poll Answer 1</label>
						<select class="form-control" name="poll_answer1" id="poll_answer1">
							<option value="">None</option>
						</select>
					</div>

					<div class="form-group mt-1">
						<label>Poll Answer 2</label>
						<select class="form-control" name="poll_answer2" id="poll_answer2">
							<option value="">None</option>
						</select>
					</div>

					<div class="form-group mt-5">
						<label>Poll Comparison with Us: </label>
						<select class="form-control" name="poll_comparison" id="poll_comparison_select">
							<option value="">None</option>
							<option value="poll">Poll</option>
							<option value="presurvey">Presurvey</option>
							<option value="assessment">Assessment</option>
						</select>
					</div>

					<div class="form-group">
						<div class="custom-control custom-switch">
							<input type="checkbox" class="custom-control-input" name="autoPollResult" id="autoPollResult">
							<label class="custom-control-label" for="autoPollResult">Automatically show result (for 5 seconds)</label>
						</div>
					</div>


					<input type="hidden" id="pollId" name="pollId" value="0">
				</form>

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>



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
		let pollOptionsDeleted;
		$('#pollsTable').on('click', '.viewOptions', function(){
			pollOptionsDeleted = [];
			// toastr.warning('Under development'); return false;
			$('#poll_comparison_select').css('display', 'none')
			$('#pollId').val($(this).attr('poll-id'));
			// $('#save-poll').html('Update');
			$.get(project_presenter_url+"/sessions/getPollByIdJson/"+$(this).attr('poll-id'), function (poll) {
				if(poll){

					$('#poll_type_select').val(poll.poll_type)
					$('#addPollModal').modal('show');
					$('#pollOptionsInputDiv').html('');
					$('#pollQuestionInput').html('');

					$('#pollNameInput').val(poll.poll_name);
					$('#slideNumberInput').val(poll.slide_number);
					$('#pollInstructionInput').val(poll.poll_instruction);
					$('#pollQuestionReferenceInput').val(poll.external_reference);

					$.each(poll.options, function(i, obj){
						$("#pollQuestionInput").summernote("code", poll.poll_question)
						$('#pollOptionsInputDiv').append(
							'<div class="card bg-light">'+
							'<div class="card-header p-0">'+
							'<span class="float-left"> ' +
							'Option' +
							'</span>' +
							'<span class="float-right"> ' +
							'<button type="button" class="delete-option-button btn btn-sm btn-danger btn-flat" option_id="'+obj.id+'"><i class="fas fa-times"></i></button> ' +
							'</span>' +
							'<div class="input-group input-group-sm">' +
							'<textarea type="text" name="pollOptionsInput[]" option_id="'+obj.id+'" class="form-control pollOptions" onkeyup="appendCorrectAnswer1(); appendCorrectAnswer2()">'+obj.option_text+'</textarea>' +
							'</div>'+
							'<div class="mb-3">'+
							'<input type="text" name="optionExternalReference[]" class="form-control border-bottom text-white optionExternalReference" id="" style="border:0; background-color: lightslategray" placeholder="External Reference" value="'+obj.external_reference+'"> '+
							'</div>'+
							'</div>'+
							'</div>'
						);
						summerNoteOption($('.pollOptions'))
					})
				}
			}, 'json').fail((error)=>{
				getTranslatedSelectAccess('Error!').then((msg) => {
					Swal.fire(
						msg,
						error,
						'error');
				});
			}).then(function(poll){
				console.log(poll.correct_answer1)
				appendCorrectAnswer1(poll.correct_answer1)
				appendCorrectAnswer2(poll.correct_answer2)
			});

		})

	});

	function appendCorrectAnswer1(answer1 = null){
		let selected1 = "";
		$('#poll_answer1').html(
			'<option value="0">None</option>'
		);
		$('.pollOptions').each(function(i, obj){

			if(answer1 == (i+1)) selected1 = "selected";
			else selected1 = "";

			$('#poll_answer1').append(
				'<option option_id="'+(i+1)+'" value="'+(i+1)+'" '+selected1+'>'+obj.value+'</option>'
			)
		})
	}

	function appendCorrectAnswer2(answer2 = null){
		let selected2 = "";
		$('#poll_answer2').html(
			'<option value="0">None</option>'
		);
		$('.pollOptions').each(function(i, obj){
			if(answer2 == (i+1)) selected2 = "selected";
			else selected2 = "";
			$('#poll_answer2').append(
				'<option option_id="'+(i+1)+'" value="'+(i+1)+'" '+selected2+'>'+obj.value+'</option>'
			)
		})
	}

	function checkAllFilledPollOption(){
		let emptyOption = 0;
		$('.pollOptions').each(function(e){
			if($(this).summernote('isEmpty'))
				emptyOption = emptyOption+1;
		})
		return emptyOption;
	}

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

			$.get(project_presenter_url+"/sessions/getAllPollsJson/<?=$session->id?>", function (polls) {
				polls = JSON.parse(polls);
				// console.log(polls)
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
					let viewOptions = '<button class="viewOptions btn btn-info" poll-id="'+poll.id+'">View Details</button>'
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
						'	<td>' +
						'		'+viewOptions+
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

	function summerNoteOption(object){
		$(object).summernote({
			dialogsInBody: true,
			inheritPlaceholder: true,
			height: 100,
			toolbar:
				[
					["history", ["undo", "redo"]],
					["style", ["style"]],
					["font", ["bold", "italic", "underline", "fontname", "strikethrough", "superscript", "subscript", "clear"]],
					['fontsize', ['fontsize']],
					["color", ["color"]],
					["paragraph", ["ul", "ol", "paragraph", "height"]],
					["table", ["table"]],
					["insert", ["link", "resizedDataImage", "picture", "video"]],
					["view", ["codeview"] ]
				],
			fontSizes: ['8', '9', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24', '25', '26', '36', '48' , '64', '82', '150'],
			callbacks: {
				onKeyup: function (e) {

					appendCorrectAnswer1();
					appendCorrectAnswer2();
				},
				onPaste: function (e) {
					var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');

					e.preventDefault();

					// Firefox fix
					setTimeout(function () {
						document.execCommand('insertText', false, bufferText);
					}, 10);
				},
				// onInit: function() {
				// 	var $noteEditable = $('.note-editable');
				// 	$noteEditable.html($noteEditable.html().replace(/^<br>/i, ''));
				// }
			}
		});
	}
</script>
