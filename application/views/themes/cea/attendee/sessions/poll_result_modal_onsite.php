<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo"<pre>";print_r($sessions);exit("</pre>");
?>
<!-- Poll Result Modal - attendee -->
<div class="modal fade" id="pollResultModal" tabindex="-1" role="dialog" aria-labelledby="pollResultModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document" style=" width:100% !important; min-width:100%">
		<div class="modal-content" style="background-color: #F1F3F4" >
			<div class="modal-header">
				<i class="zoom-tool-bar2" style="width:100%"></i>
				<div class="modal-title"><label  id="pollResultModalLabel"></label></div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body " id="contentResult">
					<!-- <div class="modal-title" id="pollResultModalLabel"></div> -->
					<!-- <hr> -->
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
				<div id="legend" class="m-auto"></div>
				<span id="howMuchSecondsLeftResult"></span>
			</div>
		</div>
	</div>
</div>
<!-- <script src="<?= base_url() ?>front_assets/js/jquery-3.5.1.min.js"></script> -->
