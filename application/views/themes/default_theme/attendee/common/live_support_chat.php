
<!-- Live Support Chat -->
<?php 	$this->user = ($_SESSION['project_sessions']["project_{$this->project->id}"]); ?>

<script>
	var base_url = "<?=$this->project_url?>";
	let attendee_id = "<?=$this->user['user_id']?>";
	let attendee_name = "<?=$this->user['name'].' '.$this->user['surname']?>";
</script>

<link rel="stylesheet" href="<?=ycl_root?>/theme_assets/live_support/style.css?v=2">
<script src="<?=ycl_root?>/theme_assets/live_support/live-support-chat.js?v=2"></script>
<div class="live-support-chat-popup mr-2" id="liveSupportChatForm" data-toggle="collapse" data-target="#chat-collapse" style="cursor: pointer">

	<span class="live-support-chat-title card text-white" style="background-color: #487391"><i class="far fa-life-ring"></i> Live Support</span>
	<div class="live-support-chat-body card-body w-100 p-0" style="background-color: white">

		<div id="live-support-chat-texts" class="live-support-chat-texts">
			<!-- Will be filled by fillAllPreviousChats() function on pageReady -->
		</div>

		<div class="input-group text-center" style="width: 100%;position: absolute;bottom: 90px;">
			<span id="adminTypingHint" style="display: none;">Admin is typing...</span>
		</div>
		<div class="input-group" style="position: absolute;bottom: 45px;">
			<input id="liveSupportText" type="text" class="form-control" placeholder="Enter your message here...">
			<span class="input-group-btn">
				<button id="sendLiveSupportText" class="btn btn-info" type="button"><i class="far fa-paper-plane"></i> Send</button>
			</span>
		</div>

	</div>

	<button type="button" class="btn btn-sm end-chat-btn" onclick="endLiveSupportChat()">End Chat <i class="fas fa-times-circle"></i></button>
</div>
<!-- End of Live Support Chat -->
