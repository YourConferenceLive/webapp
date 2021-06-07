<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo"<pre>";print_r($session);exit("</pre>");
?>

<style>
	html,
	body,
	.wrapper,
	#presentationEmbed
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
	<?php if ($session->presenter_embed_code != ''): ?>
		<?=$session->presenter_embed_code?>
	<?php else: ?>
		<div style="height: 100%; width: 100%; background-image: url('<?=ycl_root?>/ycl_assets/animations/particle_animation.gif');background-repeat: no-repeat;background-size: cover;">
			<div class="middleText">
				<h3>No Presentation Found</h3>
			</div>
		</div>
	<?php endif; ?>

</div>

<script>

	let session_start_datetime = "<?= date('M d, Y', strtotime($session->start_date_time)).' UTC-4' ?>";

	$(function () {
		$('#mainTopMenu').css('margin-left', 'unset !important');
		$('#pushMenuItem').hide();

		startsIn();
		$('#presenter_timer').show();
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
				//timeleft();
			}
		}, 1000);
	}
</script>
