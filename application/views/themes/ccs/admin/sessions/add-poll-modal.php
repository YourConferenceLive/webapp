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
							<input type="text" name="pollOptionsInput[]" class="form-control">
							<span class="input-group-append">
								<button type="button" class="delete-option-button btn btn-danger btn-flat"><i class="fas fa-trash"></i></button>
							</span>
						</div>

						<div class="input-group input-group-sm mb-2">
							<input type="text" name="pollOptionsInput[]" class="form-control">
							<span class="input-group-append">
								<button type="button" class="delete-option-button btn btn-danger btn-flat"><i class="fas fa-trash"></i></button>
							</span>
						</div>

					</div>

					<div class="form-group mt-5">
						<label>Type</label>
						<select class="form-control" name="poll_type">
							<option value="poll">Poll</option>
							<option value="presurvey">Presurvey</option>
							<option value="assessment">Assessment</option>
						</select>
					</div>

					<div class="form-group mt-5">
						<label>Poll Comparison with Us: </label>
						<select class="form-control" name="poll_comparison">
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

		$('[data-toggle="tooltip"]').tooltip();

		$('.add-new-option-btn').on('click', function () {
			$('#pollOptionsInputDiv').append('' +
					'<div class="input-group input-group-sm mb-2">' +
					'  <input type="text" name="pollOptionsInput[]" class="form-control">' +
					'  <span class="input-group-append">' +
					'    <button type="button" class="delete-option-button btn btn-danger btn-flat"><i class="fas fa-trash"></i></button>' +
					'  </span>' +
					'</div>');
		});

		$('#pollOptionsInputDiv').on('click', '.delete-option-button', function () {
			$(this).parent().parent().remove();
		});

		$('#pollsTable').on('click', '.remove-poll-btn', function () {
			toastr.warning('Under development');
		});

		$('#pollsTable').on('click', '.edit-poll-btn', function () {
			// toastr.warning('Under development'); return false;
			$('.save-poll-btn').removeAttr('id')
			$('.save-poll-btn').attr('id', 'update-poll')

			$.get(project_admin_url+"/sessions/getPollByIdJson/"+$(this).attr('poll-id'), function (poll) {
				if(poll){
					console.log(poll)
					$('#addPollModal').modal('show');
					$('#pollOptionsInputDiv').html('');
					$.each(poll.options, function(i, obj){
						$('#pollOptionsInputDiv').append(
							'<div class="input-group input-group-sm mb-2">' +
							'<input type="text" name="pollOptionsInput[]" class="form-control" value="'+obj.option_text+'"> ' +
							'<span class="input-group-append"> ' +
							'<button type="button" class="delete-option-button btn btn-danger btn-flat"><i class="fas fa-trash"></i></button>' +
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
			});
		});

		$('#save-poll').on('click', function () {
			if ($('#pollId').val() == 0)
				addPoll();
			else
				updatePoll();
		});

	});

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

</script>
