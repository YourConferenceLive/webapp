<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Note Modal - attendee -->
<div class="modal fade" id="noteModal" tabindex="-1" role="dialog" aria-labelledby="noteModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<p class="modal-title text-left" id="notesModalLabel" style="font-weight: bold;"><?php echo $session->name;?> Notes</p>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-12">
						<div class="note-text text-left"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
