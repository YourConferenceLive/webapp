<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo"<pre>";print_r($user);exit("</pre>");
?>
<style>
	html,
	body,
	.wrapper,
	#presentationEmbed,
	#presentationRow,
	#presentationColumn
	{
		height: 100% !important;
		overflow: hidden;
	}

	#presentationEmbed
	{
		margin-top: calc(3.5rem + 1px);
	}
	#presentationEmbed iframe
	{
		padding: unset !important;
	}

	.middleText
	{
		position: absolute;
		width: auto;
		height: 50px;
		top: 30%;
		left: 45%;
		margin-left: -50px; /* margin is -0.5 * dimension */
		margin-top: -25px;
	}
</style>


<div id="presentationEmbed">
	<div id="presentationRow" class="row m-0 p-0">
		<?php if (isset($session->id)): ?>

			<div class="col-12 m-0 p-0">

				<!-- Host Chat -->
				<div class="card card-primary card-outline card-tabs" style="height: 45vh;">
					<div class="card-header p-0 pt-1 border-bottom-0">
						<ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true"><i class="fas fa-user-tie"></i> Host Chat</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false"><i class="fas fa-users"></i> Attendee Chat</a>
							</li>
						</ul>
					</div>
					<div class="card-body p-0">
						<div class="tab-content" id="custom-tabs-three-tabContent" style="height: 88%;">

							<!-- Host Chat Tab -->
							<div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab" style="height: 100%;overflow: scroll;">

								<!-- Conversations are loaded here -->
								<div id="hostChatDiv" class="direct-chat-messages" style="height: 100% !important;">
									<!-- Automatically filled by the JS:loadAllHostChats() (theme_assets/{theme_name}/js/presenter/sessions/host_chat.js) -->
								</div>


								<!--/.direct-chat-messages-->

								<!-- /.direct-chat-pane -->

								<div class="input-group" style="position: absolute;bottom: 5px">
									<input id="hostChatNewMessage" type="text" placeholder="Type Message... (Host Chat)" class="form-control">
									<span class="input-group-append">
											<button id="sendHostChatBtn" type="button" class="btn btn-primary">Send</button>
										</span>
								</div>

							</div>

							<!-- Attendee Chat Tab -->
							<div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab" style="height: 100%;overflow: scroll;">
								<!-- Conversations are loaded here -->
								<div class="direct-chat-messages" style="height: 100% !important;">



								</div>
								<!--/.direct-chat-messages-->

								<!-- /.direct-chat-pane -->
								<div class="input-group" style="position: absolute;bottom: 5px">
									<input type="text" name="message" placeholder="Type Message ..." class="form-control">
									<span class="input-group-append">
											<button type="button" class="btn btn-primary">Send</button>
										</span>
								</div>
							</div>
						</div>
					</div>
					<!-- /.card -->
				</div>

				<!-- Questions and Starred Questions -->
				<div class="card card-primary card-outline card-tabs" style="height: 45vh;">
					<div class="card-header p-0 pt-1 border-bottom-0">
						<ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" id="questions-tab" data-toggle="pill" href="#questions-tab-content" role="tab" aria-controls="questions-tab-content" aria-selected="true"><i class="far fa-question-circle"></i> Questions</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" id="starred-questions-tab" data-toggle="pill" href="#starred-questions-tab-content" role="tab" aria-controls="starred-questions-tab-content" aria-selected="false"><i class="fas fa-star"></i> Starred Questions</a>
							</li>
						</ul>
					</div>
					<div class="card-body p-0" style="height: 100%; overflow: scroll;">
						<div class="tab-content" id="custom-tabs-three-tabContent">

							<!-- Questions tab -->
							<div class="tab-pane fade active show pb-5" id="questions-tab-content" role="tabpanel" aria-labelledby="questions-tab">

								<!-- Question -->
<!--								<div class="container-fluid mr-2">-->
<!--									<div class="row" style="padding-right: 15px">-->
<!--										<div class="col-7">-->
<!--											<strong>Maria Gonzales</strong>-->
<!--										</div>-->
<!--										<div class="col-3">-->
<!--											<small class="text-secondary">10:00 AM</small>-->
<!--										</div>-->
<!--										<div class="col-1">-->
<!--											<small class="text-secondary"><i class="fas fa-ban" style="color: white;cursor: pointer;"></i></small>-->
<!--										</div>-->
<!--										<div class="col-1">-->
<!--											<small class="text-secondary"><i class="far fa-star" style="color: yellow;cursor: pointer;"></i></small>-->
<!--										</div>-->
<!--									</div>-->
<!--									<div class="row">-->
<!--										<div class="col-12">-->
<!--											It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.-->
<!--										</div>-->
<!--									</div>-->
<!--								</div>-->
<!--								<div class="col"><hr></div>-->

								<!-- Question -->
<!--								<div class="container-fluid mr-2">-->
<!--									<div class="row" style="padding-right: 15px">-->
<!--										<div class="col-7">-->
<!--											<strong>John Doe</strong>-->
<!--										</div>-->
<!--										<div class="col-3">-->
<!--											<small class="text-secondary">10:00 AM</small>-->
<!--										</div>-->
<!--										<div class="col-1">-->
<!--											<small class="text-secondary"><i class="fas fa-ban" style="color: white;cursor: pointer;"></i></small>-->
<!--										</div>-->
<!--										<div class="col-1">-->
<!--											<small class="text-secondary"><i class="far fa-star" style="color: white;cursor: pointer;"></i></small>-->
<!--										</div>-->
<!--									</div>-->
<!--									<div class="row">-->
<!--										<div class="col-12">-->
<!--											What is the best way to treat this patient?-->
<!--										</div>-->
<!--									</div>-->
<!--								</div>-->
<!--								<div class="col"><hr></div>-->

								<!-- Question -->
<!--								<div class="container-fluid mr-2">-->
<!--									<div class="row" style="padding-right: 15px">-->
<!--										<div class="col-7">-->
<!--											<strong>Richard Lu</strong>-->
<!--										</div>-->
<!--										<div class="col-3">-->
<!--											<small class="text-secondary">10:00 AM</small>-->
<!--										</div>-->
<!--										<div class="col-1">-->
<!--											<small class="text-secondary"><i class="fas fa-ban" style="color: white;cursor: pointer;"></i></small>-->
<!--										</div>-->
<!--										<div class="col-1">-->
<!--											<small class="text-secondary"><i class="far fa-star" style="color: yellow;cursor: pointer;"></i></small>-->
<!--										</div>-->
<!--									</div>-->
<!--									<div class="row">-->
<!--										<div class="col-12">-->
<!--											Can you elaborate on this information?-->
<!--										</div>-->
<!--									</div>-->
<!--								</div>-->
<!--								<div class="col"><hr></div>-->
<!---->
<!--							</div>-->

							<!-- Starred questions tab -->
							<div class="tab-pane fade pb-5" id="starred-questions-tab-content" role="tabpanel" aria-labelledby="starred-questions-tab-content">

								<!-- Starred Question -->
<!--								<div class="container-fluid mr-2">-->
<!--									<div class="row">-->
<!--										<div class="col-8">-->
<!--											<strong>Maria Gonzales</strong>-->
<!--										</div>-->
<!--										<div class="col-4">-->
<!--											<small class="text-secondary">10:00 AM</small>-->
<!--										</div>-->
<!--									</div>-->
<!--									<div class="row">-->
<!--										<div class="col-12">-->
<!--											It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.-->
<!--										</div>-->
<!--									</div>-->
<!--								</div>-->
<!--								<div class="col"><hr></div>-->

								<!-- Starred Question -->
<!--								<div class="container-fluid mr-2">-->
<!--									<div class="row">-->
<!--										<div class="col-8">-->
<!--											<strong>Richard Lu</strong>-->
<!--										</div>-->
<!--										<div class="col-4">-->
<!--											<small class="text-secondary">10:00 AM</small>-->
<!--										</div>-->
<!--									</div>-->
<!--									<div class="row">-->
<!--										<div class="col-12">-->
<!--											Can you elaborate on this informatiion?-->
<!--										</div>-->
<!--									</div>-->
<!--								</div>-->
<!--								<div class="col"><hr></div>-->

							</div>
						</div>
					</div>
					<!-- /.card -->
				</div>

			</div>
		<?php else: ?>
			<div style="height: 100%; width: 100%; background-image: url('<?=ycl_root?>/ycl_assets/animations/particle_animation.gif');background-repeat: no-repeat;background-size: cover;">
				<div class="middleText">
					<h3><?=$error_text?></h3>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>

<script>

	let controllerPath = project_presenter_url;

	let session_id = "<?=$session->id?>";

	let user_id = "<?=$user->user_id?>";
	let user_name = "<?=$user->name?> <?=$user->surname?>";
	let user_photo = "<?=$user->photo?>";

	let session_start_datetime = "<?= date('M j, Y H:i:s', strtotime($session->start_date_time)).' UTC-5' ?>"; // UTC-5 from March 14 2021 | UTC-4 from November 7 2021
	let session_end_datetime = "<?= date('M j, Y H:i:s', strtotime($session->end_date_time)).' UTC-5' ?>"; // UTC-5 from March 14 2021 | UTC-4 from November 7 2021

	console.log(session_start_datetime);
	console.log(session_end_datetime);

	$(function () {
		$('#mainTopMenu').css('margin-left', 'unset !important');
		$('#pushMenuItem').hide();

		startsIn();
		$('#presenter_timer').show();

		$('#attendeesOnline').html('<span class="badge badge-danger" data-toggle="tooltip" data-placement="top" title="Number of attendees watching this session"><i class="fas fa-eye"></i> 0</span>');
		$('[data-toggle="tooltip"]').tooltip()

		fillQuestions();

		socket.on('ycl_session_question', function (data) {
			if (data.sessionId == session_id)
			{
				let question = '' +
						'<div class="container-fluid mr-2">' +
						'<div class="row" style="padding-right: 15px">' +
						'<div class="col-7">' +
						'<strong></strong>' +
						'</div>' +
						'<div class="col-3">' +
						'<small class="text-secondary"></small>' +
						'</div>' +
						'<div class="col-1">' +
						'<small class="text-secondary"><i class="fas fa-ban" style="color: white;cursor: pointer;"></i></small>' +
						'</div>' +
						'<div class="col-1">' +
						'<small class="text-secondary"><i class="far fa-star" style="color: yellow;cursor: pointer;"></i></small>' +
						'</div>' +
						'</div>' +
						'<div class="row">' +
						'<div class="col-12">'+data.question+'</div>' +
						'</div>' +
						'</div>' +
						'<div class="col"><hr></div>';

				$('#questions-tab-content').append(question);
			}
		});

		socket.on('ycl_launch_poll', (data)=>{

			if(data.session_id == session_id)
			{
				$('#pollId').val(data.session_id);
				$('#pollQuestion').text(data.poll_question);
				$('#howMuchSecondsLeft').text('');

				$('#pllOptions').html('');
				$.each(data.options, function (key, option) {
					$('#pllOptions').append('' +
							'<div class="form-check mb-2">' +
							'  <input class="form-check-input" type="radio" name="poll_option" value="'+option.id+'">' +
							'  <label class="form-check-label">'+option.option_text+'</label>' +
							'</div>');
				});

				$('#pollResultModal').modal('hide');
				$('#noteModal').modal('hide');

				$('#pollModal').modal({
					backdrop: 'static',
					keyboard: false
				});

				var timeleft = 10;
				var downloadTimer = setInterval(function(){
					if(timeleft <= 0){
						clearInterval(downloadTimer);
						$('#pollModal').modal('hide');

						if (data.show_result == 1) // Show result automatically
						{
							$.get(project_presenter_url+"/sessions/getPollResultAjax/"+data.id, function (results) {
								results = JSON.parse(results);

								$('#pollResults').html('');
								$('#pollResultModalLabel').text(data.poll_question);
								$.each(results, function (poll_id, option_details) {
									$('#pollResults').append('' +
											'<div class="form-group">' +
											'  <label class="form-check-label">'+option_details.option_name+'</label>' +
											'  <div class="progress" style="height: 25px;">' +
											'    <div class="progress-bar" role="progressbar" style="width: '+option_details.vote_percentage+'%;" aria-valuenow="'+option_details.vote_percentage+'" aria-valuemin="0" aria-valuemax="100">'+option_details.vote_percentage+'%</div>' +
											'  </div>' +
											'</div>');
								});

								$('#pollResultModal').modal({
									backdrop: 'static',
									keyboard: false
								});

								var resultTimeleft = 5;
								var resultTimer = setInterval(function(){
									if(resultTimeleft <= 0){
										clearInterval(resultTimer);
										$('#pollResultModal').modal('hide');
									} else {
										$('#howMuchSecondsLeftResult').text(resultTimeleft);
									}
									resultTimeleft -= 1;
								}, 1000);

							});
						}

					} else {
						$('#howMuchSecondsLeft').text(timeleft);
					}
					timeleft -= 1;
				}, 1000);
			}
		});

		socket.on('ycl_launch_poll_result', (data)=>{
			if(data.session_id == session_id)
			{
				$.get(project_url+"/sessions/getPollResultAjax/"+data.poll_id, function (results) {
					results = JSON.parse(results);

					$('#pollResults').html('');
					$('#pollResultModalLabel').text(data.poll_question);
					$.each(results, function (poll_id, option_details) {
						$('#pollResults').append('' +
								'<div class="form-group">' +
								'  <label class="form-check-label">'+option_details.option_name+'</label>' +
								'  <div class="progress" style="height: 25px;">' +
								'    <div class="progress-bar" role="progressbar" style="width: '+option_details.vote_percentage+'%;" aria-valuenow="'+option_details.vote_percentage+'" aria-valuemin="0" aria-valuemax="100">'+option_details.vote_percentage+'%</div>' +
								'  </div>' +
								'</div>');
					});

					$('#pollResultModal').modal({
						backdrop: 'static',
						keyboard: false
					});

					var resultTimeleft = 5;
					var resultTimer = setInterval(function(){
						if(resultTimeleft <= 0){
							clearInterval(resultTimer);
							$('#pollResultModal').modal('hide');
						} else {
							$('#howMuchSecondsLeftResult').text(resultTimeleft);
						}
						resultTimeleft -= 1;
					}, 1000);

				});
			}
		});

		socket.on('ycl_close_poll_result', (data)=>{
			if(data.session_id == session_id)
			{
				$('#pollResultModal').modal('hide');
			}
		});

	});

	function startsIn() {
		// Set the date we're counting down to
		var countDownDate = new Date(session_start_datetime).getTime();

		console.log("session_start_datetime: " + session_start_datetime);

		// Update the count down every 1 second
		var x = setInterval(function() {

			// Get today's date and time
			var now = new Date().getTime();

			// console.log("now: "+now);

			// Find the distance between now and the count down date
			var distance = countDownDate - now;

			// Time calculations for days, hours, minutes and seconds
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);

			let days_label = "day";
			let hours_label = "hour";
			let minutes_label = "minute";
			let seconds_label = "second";

			if (pad(days) > 1)
				days_label = "days";
			if (pad(hours) > 1)
				hours_label = "hours";
			if (pad(minutes) > 1)
				minutes_label = "minutes";
			if (pad(seconds) > 1)
				seconds_label = "seconds";

			let countdown_str = "";

			console.log(distance);
			if (distance > 86400000)
				countdown_str = `${days} ${days_label}, ${hours} ${hours_label}, ${minutes} ${minutes_label}, ${seconds} ${seconds_label}`;
			else if(distance > 3600000)
				countdown_str = `${hours} ${hours_label}, ${minutes} ${minutes_label}, ${seconds} ${seconds_label}`;
			else if(distance > 60000)
				countdown_str = `${minutes} ${minutes_label}, ${seconds} ${seconds_label}`;
			else
				countdown_str = `${seconds} ${seconds_label}`;

			$('#presenter_timer').text("Starts in: "+countdown_str);

			// If the count down is finished,
			if (distance < 0) {
				clearInterval(x);
				//$('#presenter_timer').hide();
				endsIn();
			}
		}, 1000);
	}

	function endsIn() {
		// Set the date we're counting down to
		var countDownDate = new Date(session_end_datetime).getTime();

		console.log("session_end_datetime: " + session_end_datetime);

		// Update the count down every 1 second
		var x = setInterval(function() {

			// Get today's date and time
			var now = new Date().getTime();

			// console.log("now: "+now);

			// Find the distance between now and the count down date
			var distance = countDownDate - now;

			// Time calculations for days, hours, minutes and seconds
			var days = Math.floor(distance / (1000 * 60 * 60 * 24));
			var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
			var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
			var seconds = Math.floor((distance % (1000 * 60)) / 1000);

			let days_label = "day";
			let hours_label = "hour";
			let minutes_label = "minute";
			let seconds_label = "second";

			if (pad(days) > 1)
				days_label = "days";
			if (pad(hours) > 1)
				hours_label = "hours";
			if (pad(minutes) > 1)
				minutes_label = "minutes";
			if (pad(seconds) > 1)
				seconds_label = "seconds";

			let countdown_str = "";

			if (distance > 86400000)
				countdown_str = `${days} ${days_label}, ${hours} ${hours_label}, ${minutes} ${minutes_label}, ${seconds} ${seconds_label}`;
			else if(distance > 3600000)
				countdown_str = `${hours} ${hours_label}, ${minutes} ${minutes_label}, ${seconds} ${seconds_label}`;
			else if(distance > 60000)
				countdown_str = `${minutes} ${minutes_label}, ${seconds} ${seconds_label}`;
			else
				countdown_str = `${seconds} ${seconds_label}`;

			$('#presenter_timer').text("Ends in: "+countdown_str);

			// If the count down is finished,
			if (distance < 0) {

				if (pad(Math.abs(days)) > 1)
					days_label = "days";
				if (pad(Math.abs(hours)) > 1)
					hours_label = "hours";
				if (pad(Math.abs(minutes)) > 1)
					minutes_label = "minutes";
				if (pad(Math.abs(seconds)) > 1)
					seconds_label = "seconds";

				if (distance < -86400000)
					countdown_str = `${Math.abs(days)} ${days_label}, ${Math.abs(hours)} ${hours_label}, ${Math.abs(minutes)} ${minutes_label}, ${Math.abs(seconds)} ${seconds_label}`;
				else if(distance < -3600000)
					countdown_str = `${Math.abs(hours)} ${hours_label}, ${Math.abs(minutes)} ${minutes_label}, ${Math.abs(seconds)} ${seconds_label}`;
				else if(distance < -60000)
					countdown_str = `${Math.abs(minutes)} ${minutes_label}, ${Math.abs(seconds)} ${seconds_label}`;
				else
					countdown_str = `${Math.abs(seconds)} ${seconds_label}`;

				//clearInterval(x);
				$('#presenter_timer').html('<badge class="badge badge-danger">This session ended ('+countdown_str+') ago</badge>');
				//$('#presenter_timer').hide();
			}
		}, 1000);
	}

	function fillQuestions() {
		$.get(project_presenter_url+"/sessions/getQuestionsAjax/"+session_id, function (questions) {
			questions = JSON.parse(questions);

			$('#questions-tab-content').html('');
			$.each(questions, function (poll_id, question) {
				$('#questions-tab-content').append('' +
						'<div class="container-fluid mr-2">' +
						'<div class="row" style="padding-right: 15px">' +
						'<div class="col-7">' +
						'<strong></strong>' +
						'</div>' +
						'<div class="col-3">' +
						'<small class="text-secondary"></small>' +
						'</div>' +
						'<div class="col-1">' +
						'<small class="text-secondary"><i class="fas fa-ban" style="color: white;cursor: pointer;"></i></small>' +
						'</div>' +
						'<div class="col-1">' +
						'<small class="text-secondary"><i class="far fa-star" style="color: yellow;cursor: pointer;"></i></small>' +
						'</div>' +
						'</div>' +
						'<div class="row">' +
						'<div class="col-12">'+question.question+'</div>' +
						'</div>' +
						'</div>' +
						'<div class="col"><hr></div>');
			});

			$('#pollResultModal').modal({
				backdrop: 'static',
				keyboard: false
			});

		});
	}
</script>
<script src="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/js/common/sessions/host_chat.js"></script>
