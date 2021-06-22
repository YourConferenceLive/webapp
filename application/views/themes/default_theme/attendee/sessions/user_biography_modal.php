<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo"<pre>";print_r($sessions);exit("</pre>");
?>
<!-- User Bio Modal -->
<div class="modal fade" id="speaker-modal" tabindex="-1" aria-labelledby="speaker-modal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<div class="text-left w-100" id="speaker-header">
					<h3 id="speaker-modal-speaker-name" class="ml-4" style="color:#487391; font-weight: 650">Speaker Name</h3>
				</div>
			</div>
			<div class="modal-body">
				<div class="text-center keynote-photo">

				</div>
				<div class=" mb-3">
					<span class="bio-body text-left ">

					</span>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary " data-dismiss="modal" >Close</button>
			</div>
		</div>
	</div>
</div>
<script>
	$('.keynote-link').on('click', function (){
		if($("bio[session-id="+$(this).attr('keynote-id')+"]").html() !== ''){
			$("#speaker-modal .modal-body .bio-body").html('<h5 class="text-center">Biography:</h5>' + $("bio[session-id="+$(this).attr('keynote-id')+"]").html());
		}else{
			$("#speaker-modal .modal-body .bio-body").html('');
		}
		if($(this).attr('keynote-photo') !=='') {
			$('#speaker-modal .modal-body .keynote-photo').html('<img style="width: 150px;height: 150px" class="img-thumbnail" id="" src="'+ycl_root + '/cms_uploads/user_photo/profile_pictures/' + $(this).attr('keynote-photo')+'" >');
		}else{
			$('#speaker-modal .modal-body .keynote-photo img').remove();
		}
		$('#speaker-modal-speaker-name').text($(this).attr('speaker-name'));
		$("#speaker-modal ").modal('show');
	});
</script>
