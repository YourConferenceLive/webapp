<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo"<pre>";print_r($session);exit("</pre>");
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
		<span style="position: absolute;color: white;z-index: 2;left: 15px;"><a class="btn btn-sm btn-info mt-2" href="<?=$session->zoom_link?>" target="_blank" <?=($session->zoom_link == null || $session->zoom_link = '')?'onclick="toastr.warning(`Zoom is not configured yet.`); return false;"':''?>><i class="fas fa-video"></i> Join Zoom</a></span>
		<?php if (isset($session->id)): ?>
			<div id="presentationColumn" class="col-10 m-0 p-0">
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
			<div class="col-2 m-0 p-0">

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
								<div class="direct-chat-messages" style="height: 100% !important;">

									<!-- Message. Default to the left -->
									<div class="direct-chat-msg">
										<div class="direct-chat-infos clearfix">
											<span class="direct-chat-name float-left">Alexander Pierce</span>
											<span class="direct-chat-timestamp float-right">23 Jan 2:00 pm</span>
										</div>
										<!-- /.direct-chat-infos -->
										<img class="direct-chat-img" src="<?=ycl_root?>/vendor_frontend/adminlte/dist/img/user1-128x128.jpg" alt="Message User Image">
										<!-- /.direct-chat-img -->
										<div class="direct-chat-text">
											This is a sample chat text!
										</div>
										<!-- /.direct-chat-text -->
									</div>
									<!-- /.direct-chat-msg -->

									<!-- Message to the right -->
									<div class="direct-chat-msg right">
										<div class="direct-chat-infos clearfix">
											<span class="direct-chat-name float-right">Sarah Bullock</span>
											<span class="direct-chat-timestamp float-left">23 Jan 2:05 pm</span>
										</div>
										<!-- /.direct-chat-infos -->
										<img class="direct-chat-img" src="<?=ycl_root?>/vendor_frontend/adminlte/dist/img/user3-128x128.jpg" alt="Message User Image">
										<!-- /.direct-chat-img -->
										<div class="direct-chat-text">
											This is another sample chat text!
										</div>
										<!-- /.direct-chat-text -->
									</div>
									<!-- /.direct-chat-msg -->

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
								<div class="container-fluid mr-2">
									<div class="row" style="padding-right: 15px">
										<div class="col-7">
											<strong>Maria Gonzales</strong>
										</div>
										<div class="col-3">
											<small class="text-secondary">10:00 AM</small>
										</div>
										<div class="col-1">
											<small class="text-secondary"><i class="fas fa-ban" style="color: white;cursor: pointer;"></i></small>
										</div>
										<div class="col-1">
											<small class="text-secondary"><i class="far fa-star" style="color: yellow;cursor: pointer;"></i></small>
										</div>
									</div>
									<div class="row">
										<div class="col-12">
											It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
										</div>
									</div>
								</div>
								<div class="col"><hr></div>

								<!-- Question -->
								<div class="container-fluid mr-2">
									<div class="row" style="padding-right: 15px">
										<div class="col-7">
											<strong>John Doe</strong>
										</div>
										<div class="col-3">
											<small class="text-secondary">10:00 AM</small>
										</div>
										<div class="col-1">
											<small class="text-secondary"><i class="fas fa-ban" style="color: white;cursor: pointer;"></i></small>
										</div>
										<div class="col-1">
											<small class="text-secondary"><i class="far fa-star" style="color: white;cursor: pointer;"></i></small>
										</div>
									</div>
									<div class="row">
										<div class="col-12">
											What is the best way to treat this patient?
										</div>
									</div>
								</div>
								<div class="col"><hr></div>

								<!-- Question -->
								<div class="container-fluid mr-2">
									<div class="row" style="padding-right: 15px">
										<div class="col-7">
											<strong>Richard Lu</strong>
										</div>
										<div class="col-3">
											<small class="text-secondary">10:00 AM</small>
										</div>
										<div class="col-1">
											<small class="text-secondary"><i class="fas fa-ban" style="color: white;cursor: pointer;"></i></small>
										</div>
										<div class="col-1">
											<small class="text-secondary"><i class="far fa-star" style="color: yellow;cursor: pointer;"></i></small>
										</div>
									</div>
									<div class="row">
										<div class="col-12">
											Can you elaborate on this information?
										</div>
									</div>
								</div>
								<div class="col"><hr></div>

							</div>

							<!-- Starred questions tab -->
							<div class="tab-pane fade pb-5" id="starred-questions-tab-content" role="tabpanel" aria-labelledby="starred-questions-tab-content">

								<!-- Starred Question -->
								<div class="container-fluid mr-2">
									<div class="row">
										<div class="col-8">
											<strong>Maria Gonzales</strong>
										</div>
										<div class="col-4">
											<small class="text-secondary">10:00 AM</small>
										</div>
									</div>
									<div class="row">
										<div class="col-12">
											It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.
										</div>
									</div>
								</div>
								<div class="col"><hr></div>

								<!-- Starred Question -->
								<div class="container-fluid mr-2">
									<div class="row">
										<div class="col-8">
											<strong>Richard Lu</strong>
										</div>
										<div class="col-4">
											<small class="text-secondary">10:00 AM</small>
										</div>
									</div>
									<div class="row">
										<div class="col-12">
											Can you elaborate on this informatiion?
										</div>
									</div>
								</div>
								<div class="col"><hr></div>

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

	let session_start_datetime = "<?= date('M d, Y', strtotime($session->start_date_time)).' UTC-4' ?>";

	$(function () {
		$('#mainTopMenu').css('margin-left', 'unset !important');
		$('#pushMenuItem').hide();

		startsIn();
		$('#presenter_timer').show();

		$('#attendeesOnline').html('<span class="badge badge-danger" data-toggle="tooltip" data-placement="top" title="Number of attendees watching this session"><i class="fas fa-eye"></i> 0</span>');
		$('[data-toggle="tooltip"]').tooltip()

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

			if (distance > 86400)
				countdown_str = `${days} ${days_label}, ${hours} ${hours_label}, ${minutes} ${minutes_label}, ${seconds} ${seconds_label}`;
			else if(distance > 3600)
				countdown_str = `${hours} ${hours_label}, ${minutes} ${minutes_label}, ${seconds} ${seconds_label}`;
			else if(distance > 60)
				countdown_str = `${minutes} ${minutes_label}, ${seconds} ${seconds_label}`;
			else
				countdown_str = `${seconds} ${seconds_label}`;

			$('#presenter_timer').text("Starts in: "+countdown_str);

			// If the count down is finished,
			if (distance < 0) {
				clearInterval(x);
				$('#presenter_timer').hide();
			}
		}, 1000);
	}
</script>
