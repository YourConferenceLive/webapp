<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
	body{
		background-color: #2a2a2e;
	}
</style>
<object id="shPdf" data="<?=ycl_root?>/cms_uploads/projects/3/theme_assets/scavenger_hunt/Scavenger_Hunt_Instructions.pdf" type="application/pdf" width="100%" height="900px">
	<p>It appears you don't have a PDF plugin for this browser.
		You can <a target="_blank" href="<?=ycl_root?>/cms_uploads/projects/3/theme_assets/scavenger_hunt/Scavenger_Hunt_Instructions.pdf">click here to download the PDF file.</a></p>
</object>

<script>
	$(function (){
		let documentH = $(window).height();
		$('#shPdf').height(documentH+'px');

		$(window).on('resize', function(){
			let documentH = $(window).height();
			$('#shPdf').height(documentH+'px');
		});
	});
</script>
