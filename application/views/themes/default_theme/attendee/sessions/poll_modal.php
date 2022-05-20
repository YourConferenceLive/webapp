<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo"<pre>";print_r($sessions);exit("</pre>");
?>
<!-- Poll Modal - attendee -->
<div class="modal fade" id="pollModal" tabindex="-1" role="dialog" aria-labelledby="pollModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg" role="document" style="margin: 10rem auto !important;">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="pollModalLabel"><span id="pollQuestion"></span></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<form id="pollAnswerForm">
							<!-- poll radio -->
							<div class="form-group">

								<div id="pllOptions">
								</div>

								<input type="hidden" id="pollId" name="pollId" value="0">

							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<span id="howMuchSecondsLeft"></span> seconds left
				<button id="voteBtn" type="button" class="btn btn-primary"><i class="fas fa-vote-yea"></i> Vote</button>
			</div>
		</div>
	</div>
</div>

<script>
	$(function () {
		$('#voteBtn').on('click', function () {

			Swal.fire({
				title: 'Please Wait',
				text: 'Saving...',
				imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
				imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
				imageAlt: 'Loading...',
				showCancelButton: false,
				showConfirmButton: false,
				allowOutsideClick: false
			});

			let formData = new FormData(document.getElementById('pollAnswerForm'));

			$.ajax({
				type: "POST",
				url: project_url+"/sessions/vote",
				data: formData,
				processData: false,
				contentType: false,
				error: function(jqXHR, textStatus, errorMessage)
				{
					Swal.close();
					$('#pollModal').modal('hide');
					//toastr.error(errorMessage);
					//console.log(errorMessage); // Optional
				},
				success: function(data)
				{
					Swal.close();

					data = JSON.parse(data);

					if (data.status == 'success')
					{
						toastr.success('Vote recorded');
						$('#pollModal').modal('hide');

					}else{
						$('#pollModal').modal('hide');
						//toastr.error("Error");
					}
				}
			});
		});
	})
</script>
