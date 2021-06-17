<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/css/lobby.css?v=<?=rand()?>" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/maphilight/1.4.0/jquery.maphilight.min.js" integrity="sha512-AXsnvY/qS75ZpZGBz0CkJHMY55DNWyTeXmjZU2W8IZNHcnxSP31UuAaiCWfdajWk+a3kAeSX8VpYLsP635IGuA==" crossorigin="anonymous"></script>
<script type="text/javascript">
	$(function()
	{
		// $('#full-screen-background').maphilight({
		// 	fill: true,
		// 	fillColor: '000000',
		// 	fillOpacity: 0.2,
		// 	stroke: true,
		// 	strokeColor: 'd22929',
		// 	strokeOpacity: 1,
		// 	strokeWidth: 1,
		// 	fade: true,
		// 	alwaysOn: true, // Turn on for debug
		// 	neverOn: false,
		// 	groupBy: false,
		// 	wrapClass: true,
		// 	shadow: false,
		// 	shadowX: 0,
		// 	shadowY: 0,
		// 	shadowRadius: 6,
		// 	shadowColor: '000000',
		// 	shadowOpacity: 0.8,
		// 	shadowPosition: 'outside',
		// 	shadowFrom: false
		// });
	});
</script>

<img id="full-screen-background" src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/other_images/lobby.jpeg" usemap="#workmap">
<!--<img id="full-screen-background" src="--><?//=ycl_root?><!--/theme_assets/default_theme/images/background-images/lobby_bg.png" usemap="#workmap">-->

<div class="lobby-content">
	<div class="custom-container">
		<div class="middle">
			<div class="top-banner">
				<img src="<?=ycl_root?>/theme_assets/default_theme/images/lobby/banner_top.png">
			</div>
			<div class="menu">
				<?php
				$menu=[["Agenda","Fransizcssi horaire","sessions"],["Networking Lounge","Résautage","lounge"],["Exhibition","Exposition","sponsor"],["Relaxation Zone","Espace bien-étre","relaxation_zone"],["ePosters","","#"],["Evaluation","Evaluation","evaluation"]];

				for($i=0; $i < count($menu); $i++){
					?>
					<a href="<?=base_url().$this->project->main_route?>/<?=$menu[$i][2]?>" class="circle">
						<div class="icon"></div>
						<h3><?=$menu[$i][0]?></h3>
						<h3><?=$menu[$i][1]?></h3>
					</a>
					<?php
				}
				?>
			</div>
			<div class="bottom-peoples">
				<img src="<?=ycl_root?>/theme_assets/default_theme/images/lobby/peoples.png">
			</div>
		</div>
		<div class="left">
			<img src="<?=ycl_root?>/theme_assets/default_theme/images/lobby/banner_left.png">
		</div>
		<div class="right">
			<img src="<?=ycl_root?>/theme_assets/default_theme/images/lobby/banner_right.png">
			<a href="#" class="support-button"></a>
		</div>
	</div>
</div>

<map name="workmap">
<!--	<area shape="circle" coords="665,647,70" alt="Sessions" href="sessions">-->
	<area shape="circle" coords="1035,575,80" alt="Lounge" href="<?=base_url().$this->project->main_route?>/lounge">
	<area shape="circle" coords="1420,575,80" alt="Exhibits" href="<?=base_url().$this->project->main_route?>/sponsor">
	<area shape="circle" coords="625,855,80" alt="Relaxation Zone" href="<?=base_url().$this->project->main_route?>/relaxation_zone">
<!--	<area shape="circle" coords="1067,647,70" alt="Exhibits" href="exhibits">-->
<!--	<area shape="circle" coords="1269,647,70" alt="Support" href="support">-->
</map>

<script src="<?=ycl_root?>/vendor_frontend/imageResizer/imageMapResizer.min.js"></script>
<script>
	$('map').imageMapResize();
</script>
