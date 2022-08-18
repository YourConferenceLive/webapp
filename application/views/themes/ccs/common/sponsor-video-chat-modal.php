<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
	#myVideo video{
		height: 100%;
	}
	#otherUserVideo video {
		height: 100%;
	}
</style>
<!-- Sponsor Video Chat Modal-->
<div class="modal fade" id="modal-call-sponsor" tabindex="-1" role="dialog" aria-labelledby="modal-schedule-meet" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-schedule-meet"><span id="callingUserName"></span></h5>
			</div>
			<div class="modal-body p-0 m-0">
				<div id="videoChatContainer" class="container-fluid text-center" style="height: 50vh;background: black;">
					<div id="otherUserVideo" style="height: 100%;">
						<video id="remote-video" autoplay="autoplay"></video>
					</div>
					<div id="myVideo" style="height: 125px;position: absolute;right: 0;bottom: 0;">
						<video id="local-video" autoplay="autoplay" muted></video>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button id="hangUp" type="button" class="btn btn-danger"><i class="fas fa-phone-slash"></i> Hangup</button>
			</div>
		</div>
	</div>
</div>

<!-- Sponsor Video Call Notification Modal-->
<div class="modal fade" id="modal-call-notification" tabindex="-1" role="dialog" aria-labelledby="modal-schedule-meet" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-schedule-meet"><span id="incomingCallFromUserName"></span></h5>
			</div>
			<div class="modal-body text-center">
				<button id="acceptVideoCall" class="btn btn-success"><i class="fas fa-phone-alt"></i> Accept</button>
				<button id="rejectVideoCall" class="btn btn-danger">Reject <i class="fas fa-phone-slash"></i></button>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>
<script src="<?=ycl_root?>/theme_assets/ccs/<?=$this->project->theme?>/js/sponsor/video-chat.js?v=2"></script>
