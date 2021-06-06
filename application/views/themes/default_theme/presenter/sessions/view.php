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
	$(function () {
		$('#mainTopMenu').css('margin-left', 'unset !important');
		$('#pushMenuItem').hide();
	});
</script>
