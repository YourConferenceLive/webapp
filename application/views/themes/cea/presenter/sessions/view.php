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
		height: calc(100% - 10px) !important;
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

	.direct-chat-text{
		background-color: white !important;
		color:black !important;
		border-color: white !important;

	}

	.show-toolbox{
		background-color: <?=(isset($settings) && $settings->stickyIcon_color!== '')? $settings->stickyIcon_color:''?> !important;
		right: -140px !important;
		transition: 1s !important;
	}
	.show-toolbox:hover{
		right: 0 !important;
		transition: 1s !important;
	}
	.dark-mode .nav-tabs .nav-item.show .nav-link, .dark-mode .nav-tabs .nav-link.active{
		border-color: white !important;
	}
</style>

<?php //print_r($settings);exit;?>
<div id="presentationEmbed">
	<div id="presentationRow" class="row m-0 p-0">
<!--		<span style="position: absolute;color: white;z-index: 2;left: 15px;"><a class="btn btn-sm btn-info mt-2" href="<?/*=$session->zoom_link*/?>" target="_blank" <?/*=($session->zoom_link == null || $session->zoom_link = '')?'onclick="toastr.warning(`Zoom is not configured yet.`); return false;"':''*/?>><i class="fas fa-video"></i> Join Zoom</a></span>-->
		<?php if (isset($session->id)): ?>
			<div id="presentationColumn" class="col-12 m-0 p-0">
				<?php if (isset($session->presenter_embed_code) && $session->presenter_embed_code != ''): ?>
					<?=$session->presenter_embed_code?>
				<?php else: ?>
					<div style="height: 100%; width: 100%; background-image: url('<?=ycl_root?>/ycl_assets/animations/particle_animation.gif');background-repeat: no-repeat;background-size: cover;">
						<div class="middleText">
							<h3><?=$error_text?></h3>
						</div>
					</div>
				<?php endif; ?>

			</div>
			<div class="ml-2 col-2 show-toolbox" style="width:229px; z-index:1; position:fixed; right:0px; bottom:57px; height:40px; background-color:#343a40"  title="minimize">Toolbox <span class="float-right mr-2" style="cursor:pointer"><i class="fas fa-window-maximize"></i></span></div>
			<div class="col-2 m-0 p-0 tool-box-section" style="background-color:<?=(isset($settings) && $settings->stickyIcon_color!== '')? $settings->stickyIcon_color:''?>" >
				<div class="ml-2 hide-toolbox">Toolbox <span class="float-right mr-2" style="cursor:pointer" title="minimize"><i class="fas fa-window-minimize"></i></span></div>
				<!-- Host Chat -->
				<div class="card card-primary card-tabs" style="height: 45vh;">
					<div class="card-header p-0 pt-1 border-bottom-0" style="background-color:<?=(isset($settings) && $settings->stickyIcon_color!== '')? $settings->stickyIcon_color:''?>">
						<ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist" >

							<li class="nav-item" >
								<a class="nav-link text-white" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true" style="background-color:<?=(isset($settings) && $settings->stickyIcon_color!== '')? $settings->stickyIcon_color:''?>"><i class="fas fa-user-tie"></i> Host Chat</a>
							</li>
						</ul>
					</div>
					<div class="card-body p-0 bg-white text-black	">
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
									<input id="hostChatNewMessage" type="text" placeholder="Type Message... (Host Chat)" class="form-control text-dark bg-white">
									<span class="input-group-append" >
											<button id="sendHostChatBtn" type="button" class="btn text-white" style="background-color:<?=(isset($settings) && $settings->stickyIcon_color!== '')? $settings->stickyIcon_color:''?>">Send</button>
										</span>
								</div>

							</div>


						</div>
					</div>
					<!-- /.card -->
				</div>

				<!-- Questions and Starred Questions -->
				<div class="card card-primary card-tabs" style="height: 45vh;">
					<div class="card-header p-0 pt-1 border-bottom-0 text-white" style="background-color:<?=(isset($settings) && $settings->stickyIcon_color!== '')? $settings->stickyIcon_color:''?>">
						<ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
							<li class="nav-item" >
								<a class="nav-link active text-white" id="questions-tab" data-toggle="pill" href="#questions-tab-content" role="tab" aria-controls="questions-tab-content" aria-selected="true" style="background-color:<?=(isset($settings) && $settings->stickyIcon_color!== '')? $settings->stickyIcon_color:''?>"><i class="far fa-question-circle"></i> Questions</a>
							</li>
							<li class="nav-item">
								<a class="nav-link text-white" id="starred-questions-tab" data-toggle="pill" href="#starred-questions-tab-content" role="tab" aria-controls="starred-questions-tab-content" aria-selected="false" style="background-color:<?=(isset($settings) && $settings->stickyIcon_color!== '')? $settings->stickyIcon_color:''?>"><i class="fas fa-star"></i> Favorited </a>
							</li>
						</ul>
					</div>
					<div class="card-body p-0 bg-white text-dark" style="height: 100%; overflow: scroll;">
						<div class="tab-content" id="custom-tabs-three-tabContent">

							<!-- Questions tab -->
							<div class="tab-pane fade active show pb-5" id="questions-tab-content" role="tabpanel" aria-labelledby="questions-tab">

							</div>

							<!-- Starred questions tab -->
							<div class="tab-pane fade pb-5" id="starred-questions-tab-content" role="tabpanel" aria-labelledby="starred-questions-tab-content">

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

<!-- Direct attendee chat modal -->
<div class="modal fade" id="attendeeChatModal" tabindex="-1" role="dialog" aria-labelledby="attendeeChatModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="attendeeChatModalLabel">Chat with <span id="chatAttendeeName"></span></h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="user-question">Question: <span id="chattAttendeeQuestion" ></span><br></div><br>
			<div class="attendeeChatmodal-body card " style="max-height: 300px; overflow: auto;">
				<div class="panel panel-default">
					<div id="attendeeChatModalBody" style="" class="panel-body attendeeChatModalBody">

					</div>
				</div>
			</div>
			<div class="col-md-12 mb-2" style="height:300px">
				<div style="height:30px"> <span class="typing-icon" style="display:none">Someone is typing <span style="" class="dot-flashing"></span></span>
				</div>
				<div class="input-group">
					<input id="chatToAttendeeText" type="text" class="form-control" placeholder="Enter your message">
					<span class="input-group-btn">
                                <button id="sendMessagetoAttendee" class="btn btn-success" type="button"><i class="fas fa-paper-plane"></i> Send</button>
                            </span>
				</div>
			</div>
			<div class="modal-footer">
				<button id="endChatBtn" type="button" class="btn btn-danger" userId=""><i class="fas fa-times-circle"></i> End Chat</button>
				<button type="button" class="btn btn-info" data-dismiss="modal"><i class="fas fa-folder-minus"></i> Minimize</button>
			</div>
		</div>
	</div>
</div>

<script>

	let controllerPath = project_presenter_url;

	let projectId = "<?=$this->project->id?>";
	let session_id = "<?=$session->id?>";

	let user_id = "<?=$user->user_id?>";
	let user_name = "<?=$user->name?> <?=$user->surname?>";
	let user_photo = "<?=$user->photo?>";

	<?php
	$dtz = new DateTimeZone($this->project->timezone);
	$time_in_project = new DateTime('now', $dtz);
	$gmtOffset = $dtz->getOffset( $time_in_project ) / 3600;
	$gmtOffset = "GMT" . ($gmtOffset < 0 ? $gmtOffset : "+".$gmtOffset);
	$timezone = (isset($settings->time_zone) && !empty($settings->time_zone)) ? $settings->time_zone:'';

	?>
	let session_start_datetime = "<?= date('M j, Y H:i:s', strtotime($session->start_date_time)).' '.(($timezone != '') ? $timezone : $gmtOffset ) ?>";
	let session_end_datetime = "<?= date('M j, Y H:i:s', strtotime($session->end_date_time)).' '.(($timezone != '') ? $timezone : $gmtOffset ) ?>";

	//var socket_session_name = "<?//=getAppName('_admin-to-attendee-chat')?>//";

	$(function () {
		$('#mainTopMenu').css('margin-left', 'unset !important');
		$('#pushMenuItem').hide();

		startsIn();
		$('#presenter_timer').show();

		$('#attendeesOnline').html('<span class="badge badge-danger" data-toggle="tooltip" data-placement="top" title="Number of attendees on this session page"><i class="fas fa-eye"></i> 0</span>');
		$('[data-toggle="tooltip"]').tooltip();

		fillQuestions();
		fillSavedQuestions();

		socket.on('ycl_session_question', function (data) {
			// console.log(data.question_id);
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
						'<small class="text-secondary"><i class="fas fa-ban" style="color: black;cursor: pointer;"></i></small>' +
						'</div>' +
						'<div class="col-1">' +
						'<small class="text-secondary"><i class="far fa-star" style="color: black;cursor: pointer;"></i></small>' +
						'</div>' +
						'</div>' +
						'<div class="row"><a class="questionList" href="#" style="cursor:pointer" question-id="'+data.question_id+'" question="'+data.question+'" sender_id="'+data.sender_id+'" sender_name="'+data.sender_name+'" sender_surname="'+data.sender_surname+'">' +
						'<div class="col-12">'+data.sender_name+' '+ data.sender_surname+'</div>' +
						'<div class="col-12">'+data.question+'</div>' +
						'</div></a>' +
						'</div>' +
						'<div class="col"><hr></div>';

				$('#questions-tab-content').prepend(question);
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

				});
			}
		});

		socket.on('ycl_close_poll_result', (data)=>{
			if(data.session_id == session_id)
			{
				$('#pollResultModal').modal('hide');
			}
		});

		$('#starred-questions-tab').on('click', function(){
			fillSavedQuestions();
		})
	});

	function startsIn() {
		// Set the date we're counting down to
		var countDownDate = new Date(session_start_datetime).getTime();

		console.log("session_start_datetime: " + session_start_datetime);
		console.log("countDateTime: " + countDownDate);

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

			//console.log(distance);
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
				//console.log("here");
				clearInterval(x);
				//$('#presenter_timer').hide();
				endsIn();
			}
		}, 1000);
	}

	function endsIn() {
		// Set the date we're counting down to
		var countDownDate = new Date(session_end_datetime).getTime();

		//console.log("session_end_datetime: " + session_end_datetime);

		// Update the count down every 1 second
		var x = setInterval(function() {
			//console.log("then here");

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
				console.log(question)
				$('#questions-tab-content').prepend('' +
						'<div class="container-fluid mr-2">' +
						'<div class="row" style="padding-right: 15px">' +
						'<div class="col-7">' +
						'<strong></strong>' +
						'</div>' +
						'<div class="col-3">' +
						'<small class="text-secondary"></small>' +
						'</div>' +
						'<div class="col-1">' +
						'<small class="text-secondary hide-question" id="hide-question-'+question.id+'" question-id="'+question.id+'"><i class="fas fa-ban" style="color: black;cursor: pointer;"></i></small>' +
						'</div>' +
						'<div class="col-1">' +
						'<small class="text-secondary save-question" id="save-question-'+question.id+'" question-id="'+question.id+'"><i class="far fa-star" style="color: black;cursor: pointer;"></i></small>' +
						'</div>' +
						'</div>' +
						'<div class="row">' +
						'<div class="col-12"><a class="questionList" href="#" style="cursor:pointer" question-id="'+question.id+'" question="'+question.question+'" session_id="'+session_id+'" sender_id="'+question.user_id+'" sender_name="'+question.user_name+'" sender_surname="'+question.user_surname+'">'+question.user_name+' '+ question.user_surname+'</a></div>' +
						'<div class="col-12">'+question.question+'</div>' +
						'</div>' +
						'<div class="col"><hr></div>');
			});

		});
	}

	function fillSavedQuestions() {
		$.get(project_presenter_url+"/sessions/getSavedQuestions/"+session_id, function (questions) {
			questions = JSON.parse(questions);
			// console.log(questions)
			$('#starred-questions-tab-content').html('');
			$.each(questions.data, function (poll_id, question) {
				// console.log(question)
				$('#starred-questions-tab-content').prepend('' +
					'<div class="container-fluid mr-2">' +
					'<div class="row" style="padding-right: 15px">' +
					'<div class="col-7">' +
					'<strong></strong>' +
					'</div>' +
					'<div class="col-3">' +
					'<small class="text-secondary"></small>' +
					'</div>' +
					'<div class="col-1">' +
					'<small class="text-secondary hide-saved-question" id="hide-saved-question-'+question.id+'" question-id="'+question.id+'"><i class="fas fa-ban" style="color: black;cursor: pointer;"></i></small>' +
					'</div>' +
					// '<div class="col-1">' +
					// '<small class="text-secondary save-question" id="'+question.id+'" question-id="'+question.id+'"><i class="far fa-star" style="color: yellow;cursor: pointer;"></i></small>' +
					// '</div>' +
					'</div>' +
					'<div class="row">' +
					'<div class="col-12"><a class="questionList" href="#" style="cursor:pointer" question-id="'+question.id+'" question="'+question.question+'" session_id="'+session_id+'" sender_id="'+question.user_id+'" sender_name="'+question.q_from_name+'" sender_surname="'+question.q_from_surname+'" >'+question.q_from_name+' '+ question.q_from_surname+'</a></div>' +
					'<div class="col-12">'+question.question+'</div>' +
					'</div>' +
					'<div class="col"><hr></div>');
			});

		});
	}
</script>
<script>
	$(function(){
		$('.hide-toolbox').on('click', function(){
			$('.tool-box-section').hide();
			$('#presentationColumn').removeClass('col-10').addClass('col-12');
			$('.show-toolbox').css('display', 'block');
		});
		$('.show-toolbox').on('click', function(){
			$('.tool-box-section').show();
			$('#presentationColumn').removeClass('col-12').addClass('col-10');
			$('.show-toolbox').css('display', 'none');
		});

		$('#questions-tab-content').on('click','.questionList', function(e){
			e.preventDefault();

			let sender_id = $(this).attr('sender_id');
			let sender_name = $(this).attr('sender_name');
			let sender_surname = $(this).attr('sender_surname');
			let question_selected = $(this).attr('question');
			let question_id = $(this).attr('question-id');

			questionListClick(sender_id,sender_name,sender_surname,question_selected, question_id)
		})

		$('#starred-questions-tab-content').on('click','.questionList', function(e){
			e.preventDefault();

			let sender_id = $(this).attr('sender_id');
			let sender_name = $(this).attr('sender_name');
			let sender_surname = $(this).attr('sender_surname');
			let question_selected = $(this).attr('question');

			questionListClick(sender_id,sender_name,sender_surname,question_selected)
		})

		$('#chatToAttendeeText').on('input', function(){
			let question_id = $(this).attr('question-id');
			socket.emit('typing-attendee-admin-chat',{
				'userType': 'presenter',
				'user_id': user_id,
				'project_id': project_id,
				'question_id': question_id,
			})
		})

		socket.on('typing-attendee-admin-chat-notification', function(data){
			// console.log($('#attendeeChatModal').attr('question-id'));
			if(data.user_id !== user_id && data.project_id === project_id){
				// console.log(data.question_id);
				if(data.question_id == $('#attendeeChatModal').attr('question-id')){
					let timeout = 1000;
					$('.typing-icon').css('display', 'block')
					setTimeout(function () {
						$('.typing-icon').css('display', 'none')
					}, timeout);
				}

			}
		})

		$('#sendMessagetoAttendee').on('click', function(){
			let chat = $('#chatToAttendeeText').val();
			let sender_id = $(this).attr('sender_id');

			if(chat == ''){
				toastr.info('Cannot send empty message');
				return false;
			}
			let url = project_presenter_url+"/sessions/save_presenter_attendee_chat";

			$.post(url,
				{
					'chat': chat,
					'sender_id': sender_id,
					'session_id': session_id
				}, function(response){
					// console.log(response);
					if(response.status == 'success') {

						socket.emit('new-attendee-to-admin-chat', {"session_id":session_id, "sent_from":"admin", "sender_id": sender_id, "chat_text":chat, "from_id": user_id, 'presenter_name': user_name });
						// socket.emit('update-admin-attendee-chat', {"socket_session_name":socket_session_name, "session_id":session_id, "to_id": sender_id, "to_name":currently_chatting_with_attendee, 'current_question':chat,'replied_status':comment_question_id });

						$('#attendeeChatModalBody').append('<span class="admin-to-attendee-chat btn btn-warning float-right mr-2 my-1" style="width:90%"><span style="float: right; text-right margin-left:5px"><strong>' + user_name + ': </strong>' + chat + '</span></span>')
						$('#chatToAttendeeText').val('');


						$(".attendeeChatmodal-body").scrollTop($(".attendeeChatmodal-body")[0].scrollHeight);
					}else{
						toastr.error(response.status)
					}
			}, 'json')
		})

		socket.on('new-attendee-to-admin-chat-notification', function (data) {
			// console.log(data);
				if (data.sent_from == 'attendee')
				{
					admin_chat_presenter_ids=data.cp_ids;
					if(data.cp_ids.includes(user_id)){
						attendeeChatPopup(data.from_id, data.user_name);
					}
				}
		});

		$('#questions-tab-content').on('click', '.save-question', function(){
			let question_id = $(this).attr('question-id');

			$.post(project_presenter_url+'/sessions/saveQuestionAjax/',
				{
					'question_id':question_id
				},function(response){
				if(response){
					console.log(response);
					fillSavedQuestions();
					socket.emit('presenter_like_questions', {
						"type": "like",
						"question": response,
					});
				}
					// console.log(response);
			})
		})

		$('#questions-tab-content').on('click', '.hide-question', function(){
			let question_id = $(this).attr('question-id');

			$.post(project_presenter_url+'/sessions/hideQuestionAjax/',
				{
					'question_id':question_id
				},function(response){
					// console.log(response);
				if(response){
					fillQuestions();
				}
				})
		})

	})

	function attendeeChatPopup(attendee_id, attendee_name, attendee_question, question_id){

		$('#attendeeChatModalLabel').html("Chat With: "+attendee_name);
		$('#chattAttendeeQuestion').text(attendee_question);
		$('#chattAttendeeQuestion').attr('question-id', question_id)
		$('#sendMessagetoAttendee').attr('sender_id', attendee_id);
		$('#endChatBtn').attr('userId', attendee_id);


		$.post(project_presenter_url+"/sessions/getAttendeeChatsAjax/",

			{
				session_id: session_id,
				sender_id: attendee_id,
			}

		).done(function(response) {
				response = JSON.parse(response)
				if (response.status == 'success') {
					$('#attendeeChatModalBody').html('');
					$.each(response.chats, function (i, chat) {
						if (chat.sent_from == 'admin' || chat.sent_from == 'presenter') {
							if (chat.sent_from == 'presenter') {
								$('#attendeeChatModalBody').append('<span class="attendee-to-admin-chat btn btn-warning mr-2 m-1 float-right" style="width:90%"><span style="float: right; margin-left:5px"><strong>'+chat.first_name+' '+chat.last_name+': </strong>'+chat.chats+'</span></span>')
							} else {
								$('#attendeeChatModalBody').append('<span class="attendee-to-admin-chat btn btn-warning mr-2 m-1 float-right" style="width:90%"><span style="float: right; margin-left:5px"><strong>'+chat.first_name+' '+chat.last_name+': </strong>'+chat.chats+'</span></span>')
							}
						} else {
							$('#attendeeChatModalBody').append('<span class="admin-to-attendee-chat btn btn-primary float-left ml-2 m-1" style="width:90%"><span style="float: left; text-right margin-right:5px"><strong>'+chat.first_name+' '+chat.last_name+': </strong>'+chat.chats+'</span></span>')
						}
					});
					$(".attendeeChatmodal-body").scrollTop($(".attendeeChatmodal-body")[0].scrollHeight + 100);
				}
			}
		).fail((error)=>{
			toastr.error('Unable to load the chat.');
		});

		$('#attendeeChatModal').modal('show');
		$(".attendeeChatmodal-body").scrollTop($(".attendeeChatmodal-body")[0].scrollHeight + 100);
	}

	function questionListClick(sender_id, sender_name, sender_surname, question_selected, question_id)
	{

		// console.log(question_id);
		$('#sendMessagetoAttendee').attr(
			{
				'sender_id': sender_id,
				'sender_name': sender_name,
				'sender_surname': sender_surname
			});
		$('#chatToAttendeeText').attr('question-id', question_id)

		$.post(project_presenter_url+'/sessions/getAttendeeChatsAjax/',
			{
				'sender_id': sender_id,
				'session_id': session_id
			}, function(response){
				response = JSON.parse(response)
				$('#attendeeChatModalBody').html('');
				if(response.status == 'success'){
					$('#attendeeChatModalBody').html('');
					$.each(response.chats, function(i, chat){
						// console.log(chat);

						if(chat.sent_from == 'attendee'){
							$('#attendeeChatModalBody').append('<span class="attendee-to-admin-chat btn btn-primary ml-2 my-1" style="width:90%"><span style="float: left; margin-right:5px"><strong>'+chat.first_name+' '+chat.last_name+': </strong>'+chat.chats+'</span></span><br><span class="float-right" style="margin-right:73px; margin-top: -8px">'+chat.date_time+'</span><br>')
						}else{
							$('#attendeeChatModalBody').append('<span class="admin-to-attendee-chat btn btn-warning float-right mr-2 my-1" style="width:90%"><span style="float: right; text-right margin-left:5px"><strong>'+chat.first_name+' '+chat.last_name+': </strong>'+chat.chats+'</span></span><br><span class="float-left" style="margin-left:73px; margin-top: -8px; margin-bottom:20px">'+chat.date_time+'</span><br><br>')
						}
					})
				}
			})


		$('#attendeeChatModalLabel').html('Chat With: '+sender_name+' '+sender_surname)
		$('#chattAttendeeQuestion').html(question_selected);
		$('#attendeeChatModal').attr('question-id', question_id)
		$('#attendeeChatModal').modal('show');

		$(".attendeeChatmodal-body").scrollTop($(".attendeeChatmodal-body")[0].scrollHeight);
	}

	$('#endChatBtn').on('click', function () {

		let userId = $(this).attr('userId');

		Swal.fire({
			title: 'Are you sure?',
			text: "Ending chat will disable attendee from sending you texts until you texts attendee.",
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, end it!'
		}).then((result) => {
			if (result.isConfirmed) {
				socket.emit('end-attendee-to-admin-chat', {"session_id":session_id, "from_id":"admin", "to_id":userId});

				$('#attendeeChatModal').modal('hide');
			}
		})
	});



	/** Live users per session **/
	socket.emit(`ycl_session_active_users`, `${projectId}_${session_id}`);
	socket.on(`ycl_session_active_users_count`, function (total_users) {
		$('#attendeesOnline').html(`<span class="badge badge-danger" data-toggle="tooltip" data-placement="top" title="Number of attendees on this session page"><i class="fas fa-eye"></i> ${total_users}</span>`);
		$('[data-toggle="tooltip"]').tooltip();
	});
	/** End of live users per session **/

</script>
<script src="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/assets/js/common/sessions/host_chat.js"></script>
<link rel="stylesheet" href="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/assets/css/presenter/view_session.css" type="text/css">
