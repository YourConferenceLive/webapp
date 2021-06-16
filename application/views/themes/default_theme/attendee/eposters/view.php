<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

<style>
	body{background-color: #487391;overflow: hidden;}
</style>

<link href="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/css/eposters.css?v=<?=rand()?>" rel="stylesheet">

<div class="clearfix" style="margin-top: 77px;"></div>

<div class="eposters-view-container container-fluid pl-md-6 pr-md-6 text-center" id="eposter-container">
<?php
			if (($eposter->type == 'surgical_video' && $eposter->video_url != '') || $eposter->type == 'eposter'): 
				if ($eposter->type == 'surgical_video'):?>
			<iframe id="vimeo_player" src="https://player.vimeo.com/video/<?=str_replace(array('https://', 'vimeo.com/'), array(''), $eposter->video_url);?>?color=f7dfe9&title=0&byline=0&portrait=0" style="/*position:absolute;top:0;left:0;*/width:100%;height:90%;" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
			<script src="https://player.vimeo.com/api/player.js"></script>
<?php
				else: ?>
			<img class="eposter-img"
				 src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/eposters/<?=$eposter->eposter?>"
				 onerror="this
				 .src='<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/eposters/default'" id="eposter-img">
<?php
				endif;?>
			<br clear="all">
			<div class="row">
	    		<div class="col-auto my-1 mx-auto">
<?php
					if ($eposter->type == 'eposter') {?>
					<button type="button" class="btn btn-primary btn-sm" id="enlargeable">View Full Screen</button>
<?php
					}?>
					<a role="button" class="btn btn-secondary btn-sm" href="<?=$this->project_url?>/eposters">Return to ePoster Listing</a>
				</div>
			</div>
<?php
			if ($eposter->prize){?>
			<div class="tool-btns prize hide">
				<a><img class="img-fluid img-thumbnail"
					  		 src="<?= ycl_root ?>/theme_assets/default_theme/images/eposters/thumb/<?=str_replace(' ', '_', $eposter->prize).'.png';?>"
							 onerror="this.src='<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/eposters/thumbnails/default'"></a>
			</div>
<?php
			}?>
			<div class="custom_pagination">
<?php
				if(@$previous->id) {?>
				<a role="button" title="Previous" class="eposter_view-browse" href="<?=$this->project_url?>/eposters/view/<?=$previous->id;?>" rel="prev">
					<i class="fas fa-chevron-left"></i>
				</a>
<?php
				}
				if(@$next->id) {?>
				<a role="button" title="Next" class="eposter_view-browse eposter_view-browse--right" href="<?=$this->project_url?>/eposters/view/<?=$next->id;?>" rel="next">
					<i class="fas fa-chevron-right"></i>
				</a>
<?php
				}?>
			</div>

			<div class="tool-btns credits"><a href="javascript:void(0);" class="claim-credits"><i class="fas fa-cog"></i></a></div>
<?php
			foreach ($eposter->author as $row) {
				if ($row->contact) {?>
			<div class="tool-btns email"><a href="mailto:<?php echo $row->email;?>" class="email-author" title="Contact <?php echo $row->author;?>"><i class="fas fa-envelope"></i></a></div>
<?php
					break;
				}
			}?>
			<div class="tool-btns comments"><a href="javascript:void(0);" class="comments-section"><i class="fas fa-comment"></i></a></div>
<?php
			else: ?>//In case eposter is deactivated or deleted
			<div style="height: 100%; width: 100%; background-image: url('<?=ycl_root?>/ycl_assets/animations/particle_animation.gif');background-repeat: no-repeat;background-size: cover;">
				<div class="middleText">
					<h3>No ePoster found!</h3>
				</div>
			</div>
<?php
			endif; ?>
</div>

<script type="application/javascript">

	$(function (){
		iframeResize();
		$(window).on('resize', function(){
			iframeResize();
		});

		$('.comments').click(function() {
			$('#commentsModal').modal('show');
		});
	});

	function iframeResize()
	{
		let totalHeight = window.innerHeight;
		let menuHeight = document.getElementById('mainMenu').offsetHeight;
		let iFrameHeight = totalHeight-menuHeight;

		$('#eposter-container').css('height', iFrameHeight+'px');

		$('.eposter-img').css('height', (iFrameHeight - 50) +'px');
	}
<?php
	if ($eposter->type == 'eposter') {?>
	window.addEventListener("load", startup, false);

	function startup() {
		// Get the reference to elem
		const elem = document.getElementById("eposter-img");

		document.getElementById("enlargeable").addEventListener("click", function() {
		  toggleFullScreen(elem);
		});

		// On pressing ENTER call toggleFullScreen method
	  	document.addEventListener("keypress", function(e) {
	    	if (e.key === 'Enter') {
	      		toggleFullScreen(elem);
	    	}
	  	}, false);
	}

	function toggleFullScreen(elem) {
		if (!document.fullscreenElement) {
			// If the document is not in full screen mode
			// make the elem full screen
			elem.requestFullscreen();
		} else {
			// Otherwise exit the full screen
			if (document.exitFullscreen) {
				document.exitFullscreen();
			}
		}
	}
<?php
	}?>
</script>
