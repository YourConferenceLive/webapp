<?php
//echo "<pre>";
//print_r($types);
//exit("</pre>");
?>
<!--Add Session Modal-->
<style>
	.note-editable
	{
		background-color: white;
		color: black;
	}

	.select2-container--default
	.select2-selection--multiple
	{
		background-color: #343a40 !important;
	}

	.select2-container--default
	.select2-selection--multiple
	.select2-selection__choice
	{
		background-color: #006cac !important;
	}

</style>

<div class="modal fade" id="addPollModal" tabindex="-1" role="dialog" aria-labelledby="addPollModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="addPollModalLabel"><i class="fas fa-poll-h"></i> Add New Poll</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<form id="addPollForm">

					<h4>Question</h4>
					<div class="form-group m">
						<input type="text" class="form-control form-control-border" id="pollQuestionInput" name="pollQuestionInput" placeholder="Enter the poll question">
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
				<button id="save-poll" type="button" class="btn btn-success save-poll-btn"><i class="fas fa-plus"></i> Add</button>
			</div>
		</div>
	</div>
</div>



<script>

	$(function () {
		let pollOptionsDeleted;
		$('[data-toggle="tooltip"]').tooltip();

		$('.add-new-option-btn').on('click', function () {
			$('#pollOptionsInputDiv').append('' +
					'<div class="input-group input-group-sm mb-2">' +
					'  <input type="text" name="pollOptionsInput[]" class="form-control pollOptions" onkeyup="appendCorrectAnswer1(); appendCorrectAnswer2()">' +
					'  <span class="input-group-append">' +
					'    <button type="button" class="delete-option-button btn btn-danger btn-flat"><i class="fas fa-trash"></i></button>' +
					'  </span>' +
					'</div>');
			appendCorrectAnswer1();
			appendCorrectAnswer2();
		})


		$('#pollOptionsInputDiv').on('click', '.delete-option-button', function (e) {
			e.preventDefault();
			if(pollOptionsDeleted) {
				pollOptionsDeleted.push($(this).attr('option_id'))
			}
			$(this).parent().parent().remove();
			appendCorrectAnswer1();
			appendCorrectAnswer2();
		});

		$('#pollsTable').on('click', '.remove-poll-btn', function () {
			toastr.warning('Under development');
		});

		$('#pollsTable').on('click', '.edit-poll-btn', function () {
			pollOptionsDeleted = [];
			// toastr.warning('Under development'); return false;
			$('#poll_comparison_select').css('display', 'none')
			$('#pollId').val($(this).attr('poll-id'));
			$('#save-poll').html('Update');
			$.get(project_admin_url+"/sessions/getPollByIdJson/"+$(this).attr('poll-id'), function (poll) {
				if(poll){
					// console.log(poll)
					$('#poll_type_select').val(poll.poll_type)
					$('#addPollModal').modal('show');
					$('#pollOptionsInputDiv').html('');
					$('#pollQuestionInput').html('');
					$.each(poll.options, function(i, obj){

						$('#pollQuestionInput').val(poll.poll_question);
						$('#pollOptionsInputDiv').append(
							'<div class="input-group input-group-sm mb-2">' +
							'<input type="text" name="pollOptionsInput[]" option_id="'+obj.id+'" class="form-control pollOptions" value="'+obj.option_text+'" onkeyup="appendCorrectAnswer1(); appendCorrectAnswer2()"> ' +
							'<span class="input-group-append"> ' +
							'<button type="button" class="delete-option-button btn btn-danger btn-flat" option_id="'+obj.id+'" ><i class="fas fa-trash"></i></button>' +
							'</span>' +
							'</div>'
						);
					})
				}
			}, 'json').fail((error)=>{
				Swal.fire(
						'Error!',
						error,
						'error');
			}).then(function(){
				appendCorrectAnswer1()
				appendCorrectAnswer2()
			});

		})

		$('#save-poll').on('click', function () {
			if ($('#pollId').val() == 0)
				addPoll();
			else
				updatePoll(pollOptionsDeleted);
		});

	});


	function appendCorrectAnswer1(){
		$('#poll_answer1').html(
			'<option value="0">None</option>'
		);
		$('.pollOptions').each(function(i, obj){
			$('#poll_answer1').append(
				'<option option_id="'+(i+1)+'" value="'+(i+1)+'">'+obj.value+'</option>'
			)
		})
	}

	function appendCorrectAnswer2(){
		$('#poll_answer2').html(
			'<option value="0">None</option>'
		);
		$('.pollOptions').each(function(i, obj){
			console.log(obj)
			$('#poll_answer2').append(
				'<option option_id="'+(i+1)+'" value="'+(i+1)+'">'+obj.value+'</option>'
			)
		})
	}

	function addPoll()
	{
		Swal.fire({
			title: 'Please Wait',
			text: 'Adding the poll...',
			imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/ccs/loading.gif',
			imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
			imageAlt: 'Loading...',
			showCancelButton: false,
			showConfirmButton: false,
			allowOutsideClick: false
		});

		let formData = new FormData(document.getElementById('addPollForm'));

		$.ajax({
			type: "POST",
			url: project_admin_url+"/sessions/addPollJson/<?=$session->id?>",
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
					listPolls();
					toastr.success(data.msg);
					$('#addPollModal').modal('hide');

				}else{
					toastr.error(data.msg);
				}
			}
		});
	}

	function updatePoll(pollOptionsDeleted){
		// console.log(pollOptionsDeleted);
		Swal.fire({
			title: 'Please Wait',
			text: 'Updating the poll...',
			imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/ccs/loading.gif',
			imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
			imageAlt: 'Loading...',
			showCancelButton: false,
			showConfirmButton: false,
			allowOutsideClick: false
		});

		let formData = new FormData(document.getElementById('addPollForm'));

		$('.pollOptions').each(function(i){
			formData.append('option_'+i, $(this).attr('option_id'))
		})
		if(pollOptionsDeleted.length > 0) {
			$.each(pollOptionsDeleted, function (i, val) {
				formData.append('option_deleted[]', val);
			})
		}

		$.ajax({
			type: "POST",
			url: project_admin_url+"/sessions/updatePollJson/<?=$session->id?>",
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
					listPolls();
					toastr.success(data.msg);
					$('#addPollModal').modal('hide');

				}else{
					toastr.error(data.msg);
				}
			}
		});
	}

</script>
