<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
		<!-- Notes Modal - attendee -->
		<div class="modal fade" id="viewNoteModal" tabindex="-1" role="dialog" aria-labelledby="viewNoteModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document" style="overflow-y: initial !important">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="viewNoteModalLabel"><i class="fas fa-pen"></i> <?php echo $user['name'].' '.$user['surname'].'\'s';?> Notes</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body" style="height: 65vh;overflow-y: auto;">
						<div class="row">
							<div class="col-12">
							</div>
						</div>
					</div>
					<div class="modal-footer"></div>
				</div>
			</div>
		</div>
