<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/css/lobby.css?v=<?=rand()?>" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/maphilight/1.4.0/jquery.maphilight.min.js" integrity="sha512-AXsnvY/qS75ZpZGBz0CkJHMY55DNWyTeXmjZU2W8IZNHcnxSP31UuAaiCWfdajWk+a3kAeSX8VpYLsP635IGuA==" crossorigin="anonymous"></script>
<script type="text/javascript">
	$(function()
	{
	// $('#full-screen-background').maphilight({
	// fill: true,
	// fillColor: '000000',
	// fillOpacity: 0.2,
	// stroke: true,
	// strokeColor: 'd22929',
	// strokeOpacity: 1,
	// strokeWidth: 1,
	// fade: true,
	// alwaysOn: true, // Turn on for debug
	// neverOn: false,
	// groupBy: false,
	// wrapClass: true,
	// shadow: false,
	// shadowX: 0,
	// shadowY: 0,
	// shadowRadius: 6,
	// shadowColor: '000000',
	// shadowOpacity: 0.8,
	// shadowPosition: 'outside',
	// shadowFrom: false
	// 		});
	// });
	}
</script>

<img id="full-screen-background" src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/other_images/lobby.jpeg" usemap="#workmap">

<!--<map name="workmap">-->
<!--	<area shape="circle" coords="665,647,70" alt="Sessions" href="sessions">-->
<!--	<area shape="circle" coords="865,647,70" alt="Lounge" href="lounge">-->
<!--	<area shape="circle" coords="1067,647,70" alt="Exhibits" href="exhibits">-->
<!--	<area shape="circle" coords="1269,647,70" alt="Support" href="support">-->
<!--</map>-->

<script src="<?=ycl_root?>/vendor_frontend/imageResizer/imageMapResizer.min.js"></script>
<script>
	//$('map').imageMapResize();
</script>
