<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//print_r($countdownSeconds); exit;
?>
<link href="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/css/sessions.css?v=<?=rand()?>" rel="stylesheet">

<div id="full-screen-background" class="sessions-join"></div>

<div class="clearfix" style="margin-bottom: 7rem;"></div>
<div class="sessions-join-container container-fluid pl-md-6 pr-md-6">
	<div class="col-12">
		<div class="session-join-title p-3">
			<?=$session->name?>
		</div>
		<div class="session-join-info p-1 pb-3">
			<div class="row mt-2 ml-1">
				<div class="col-8 border-right border-dark">
					<div class="row">
						<div class="col-4">
							<img class="session-img img-fluid"
								 src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/thumbnails/<?=$session->id?>"
								 onerror="this.src='<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/thumbnails/default'">
						</div>
						<div class="col-8">
							<div>
								<small><?=date("l jS M, Y g:iA", strtotime($session->start_date_time))?></small>
								<h4><?=$session->name?></h4>
								<p><?=$session->description?></p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-4">
					<p>
					<?php if($session->moderators != new stdClass()):?>
						<span>Moderator:</span>
						<?php foreach ($session->moderators as $index=> $moderator):?>
							<?=(isset($index) && ($index >= 1))?', ':''?>
							<?= $moderator->name." ".$moderator->surname.(!empty($moderator->credentials)?', '.$moderator->credentials:'')?>
						<?php endforeach; ?><br>
					<?php endif;?>

					<?php if($session->keynote_speakers != new stdClass()):?>
						<span>Keynote:</span>
						<?php foreach ($session->keynote_speakers as $index=> $keynote):?>
							<?=(isset($index) && ($index >= 1))?', ':''?>
								<?= $keynote->name." ".$keynote->surname.(!empty($keynote->credentials)?', '.$keynote->credentials:'')?>
						<?php endforeach; ?><br>
					<?php endif; ?>

					<?php if($session->presenters != new stdClass()):?>
						<span>Speakers:</span>
						<?php foreach ($session->presenters as $index=> $presenter):?>
							<?=(isset($index) && ($index >=1))?', ':''?>
							<?= $presenter->name." ".$presenter->surname.(!empty($presenter->credentials)?', '.$presenter->credentials:'')?>
						<?php endforeach;?><br>
					<?php endif; ?>
					</p>

				</div>
			</div>
			<div class="row mt-5">
				<div class="col-12 text-center">
					<div class="container border border-dark">
						<div class="row">
							<div class="col-12 pt-5 pb-5">
								<p>You will automatically enter the session 15 minutes before it is due to begin.</p>
								<p>Entry will be enabled in <strong><span id="countdown_timer">...</span></strong></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>

	let countdown_seconds = "<?=$countdownSeconds?>";

	$(function () {

		if (countdown_seconds > 0)
			setInterval('timer()', 1000);
		else
		{
			// What to do if the countdown is already finished
			timer();
		}
	});

	function pad(n) {
		return (n < 10 ? "0" + n : n);
	}

	let secondsToCount = countdown_seconds;
	function timer() {
		let days = Math.floor(secondsToCount / 24 / 60 / 60);
		let hoursLeft = Math.floor((secondsToCount) - (days * 86400));
		let hours = Math.floor(hoursLeft / 3600);
		let minutesLeft = Math.floor((hoursLeft) - (hours * 3600));
		let minutes = Math.floor(minutesLeft / 60);
		let seconds = secondsToCount % 60;

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

		if (secondsToCount > 86400)
			countdown_str = `${days} ${days_label}, ${hours} ${hours_label}, ${minutes} ${minutes_label}, ${seconds} ${seconds_label}`;
		else if(secondsToCount > 3600)
			countdown_str = `${hours} ${hours_label}, ${minutes} ${minutes_label}, ${seconds} ${seconds_label}`;
		else if(secondsToCount > 60)
			countdown_str = `${minutes} ${minutes_label}, ${seconds} ${seconds_label}`;
		else
			countdown_str = `${seconds} ${seconds_label}`;

		document.getElementById('countdown_timer').innerHTML = countdown_str;
		if (secondsToCount <= 0) {
			window.location = `${project_url}/sessions/view/<?=$session->id?>`;
		} else {
			secondsToCount--;
		}
	}
</script>
