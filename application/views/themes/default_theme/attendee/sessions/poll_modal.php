<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo"<pre>";print_r($sessions);exit("</pre>");
?>
<!-- Poll Modal - attendee -->
<div class="modal fade" id="pollModal" tabindex="-1" role="dialog" aria-labelledby="pollModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="pollModalLabel">What would you do next?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<!-- poll radio -->
						<div class="form-group">
							<div class="form-check mb-2">
								<input class="form-check-input" type="radio" name="poll_option">
								<label class="form-check-label">A. Continue current management and follow-up for IOP check and repeat visual field and OCT</label>
							</div>
							<div class="form-check mb-2">
								<input class="form-check-input" type="radio" name="poll_option">
								<label class="form-check-label">B. Switch to preservative free drops (Cosopt and Monoprost)</label>
							</div>
							<div class="form-check mb-2">
								<input class="form-check-input" type="radio" name="poll_option">
								<label class="form-check-label">C. Refer for surgery now</label>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fas fa-vote-yea"></i> Vote</button>
			</div>
		</div>
	</div>
</div>