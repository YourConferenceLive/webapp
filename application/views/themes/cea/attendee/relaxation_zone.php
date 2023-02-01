<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<link href="<?= ycl_root ?>/theme_assets/<?= $this->project->theme ?>/css/relaxation_zone.css?v=<?= rand() ?>"
	  rel="stylesheet">

<div class="bg"></div>

<div class="custom-container">
	<div class="content">
		<div class="video">
			<div style="padding:56.25% 0 0 0;position:relative;">
				<iframe src="https://player.vimeo.com/video/559225315?badge=0&amp;autopause=0&amp;player_id=0&amp;app_id=58479"
						frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen
						style="position:absolute;top:0;left:0;width:100%;height:100%;" title="relaxation_01"></iframe>
			</div>
		</div>
		<div class="blurred-area">
			<div class="custom-write diamond">Diamond/Diamant</div>
			<div class="custom-write platinum">Platinum/Platine</div>
			<div class="top">
				<img src="<?= ycl_root ?>/theme_assets/<?=$this->project->theme?>/images/relaxation_zone/Allergan.png">
				<img src="<?= ycl_root ?>/theme_assets/<?=$this->project->theme?>/images/relaxation_zone/Bayer.png">
			</div>
			<div class="bottom">
				<img src="<?= ycl_root ?>/theme_assets/<?=$this->project->theme?>/images/relaxation_zone/alcon.png">
				<img src="<?= ycl_root ?>/theme_assets/<?=$this->project->theme?>/images/relaxation_zone/Novartis.png">
				<img src="<?= ycl_root ?>/theme_assets/<?=$this->project->theme?>/images/relaxation_zone/Santen.png">
			</div>
		</div>
	</div>
</div>

<script src="https://player.vimeo.com/api/player.js%22%3E</script>
