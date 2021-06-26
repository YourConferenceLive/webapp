<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo"<pre>";print_r($sessions);exit("</pre>");
?>
<!-- Poll Result Modal - attendee -->
<div class="modal fade" id="pollResultModal" tabindex="-1" role="dialog" aria-labelledby="pollResultModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="pollResultModalLabel">What would you do next?</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div id="pollResults" class="col-12">

						<!-- poll results -->

						<div class="form-group">
							<label class="form-check-label">A</label>
							<div class="progress" style="height: 25px;">
								<div class="progress-bar" role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100">10%</div>
							</div>
						</div>

						<div class="form-group">
							<label class="form-check-label">B. Switch to preservative free drops (Cosopt and Monoprost)</label>
							<div class="progress" style="height: 25px;">
								<div class="progress-bar" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100">70%</div>
							</div>
						</div>

						<div class="form-group">
							<label class="form-check-label">C. Refer for surgery now</label>
							<div class="progress" style="height: 25px;">
								<div class="progress-bar" role="progressbar" style="width: 20%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">20%</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="modal-footer">
				<span id="howMuchSecondsLeftResult"></span>
			</div>
		</div>
	</div>
</div>
