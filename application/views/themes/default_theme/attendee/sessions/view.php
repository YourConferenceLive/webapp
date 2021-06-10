<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<style>
	body{overflow: hidden;}
</style>

<link href="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/css/sessions.css?v=<?=rand()?>" rel="stylesheet">

<div class="sessions-view-container container-fluid p-0">
		<?php if (isset($session->millicast_stream) && $session->millicast_stream != ''): ?>
			<iframe id="millicastIframe" class="" src="https://viewer.millicast.com/v2?streamId=pYVHx2/<?=str_replace(' ', '', $session->millicast_stream)?>&autoPlay=true&muted=true&disableFull=true" width="100%" style="height: 100%"></iframe>
		<?php else: ?>
			<div style="height: 100%; width: 100%; background-image: url('<?=ycl_root?>/ycl_assets/animations/particle_animation.gif');background-repeat: no-repeat;background-size: cover;">
				<div class="middleText">
					<h3>No Stream Found</h3>
				</div>
			</div>
		<?php endif; ?>
</div>
<!--<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/dRp5VbWCQ3A?playlist=dRp5VbWCQ3A&controls=1&autoplay=1&mute=1&loop=1"></iframe>-->

<script type="application/javascript">
	$(function (){
		iframeResize();
		$(window).on('resize', function(){
			iframeResize();
		});
	});

	function iframeResize()
	{
		let totalHeight = window.innerHeight;
		let menuHeight = document.getElementById('mainMenu').offsetHeight;
		let iFrameHeight = totalHeight-menuHeight;

		$('#millicastIframe').css('height', iFrameHeight+'px');
	}
</script>

<script>
	$(function () {
		socket.on('openPollNotification', ()=>{
			$('#pollModal').modal('show');
			$('#pollResultModal').modal('hide');
		});

		socket.on('closePollNotification', ()=>{
			$('#pollModal').modal('hide');
		});

		socket.on('openResultNotification', ()=>{
			$('#pollModal').modal('hide');
			$('#pollResultModal').modal('show');
		});

		socket.on('closeResultNotification', ()=>{
			$('#pollResultModal').modal('hide');
		});
	});
</script>
