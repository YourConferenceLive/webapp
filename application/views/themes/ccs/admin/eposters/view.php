<?php
defined('BASEPATH') OR exit('No direct script access allowed');?>

<style>
html, body, .wrapper, #presentationEmbed, #presentationRow, #presentationColumn {height: 100% !important;}
#presentationEmbed{margin-top: calc(3.5rem + 1px);}
#presentationEmbed iframe {padding: unset !important;}
.middleText {position: absolute; width: auto; height: 50px; top: 30%; left: 45%; margin-left: -50px; /* margin is -0.5 * dimension */margin-top: -25px;}
</style>
<div id="presentationEmbed">
	<div id="presentationRow" class="row m-0 p-0">
<?php
		if (isset($eposter->id)):?>
		<div id="presentationColumn" class="col-12 m-0 p-0">
<?php
			if (isset($eposter->eposter) && $eposter->eposter != ''):?>
			<div class="card card-success mt-3">
			  <div class="card-body">
			    <div class="row">
			      <div class="col-md-12">
			        <div class="card mb-2 bg-gradient-dark">
<?php
					if ($eposter->type == 'surgical_video'):
						$video_url = preg_replace('/[^0-9]/', '', $eposter->video_url);
						// $video_url = str_replace(array('http://', 'https://', 'www.', 'vimeo.com/', 'player.', 'video/'), array(''), $old_video_url);?>
						<div style="height: 400px;">
						<iframe id="vimeo_player" src="https://player.vimeo.com/video/<?=$video_url;?>?color=f7dfe9&title=0&byline=0&portrait=0" style="/*position:absolute;top:0;left:0;*/width:100%;height:90%;" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
						<script src="https://player.vimeo.com/api/player.js"></script>
						</div>
<?php

					else:?>
			        	<img class="card-img-top"
							 src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/eposters/<?=$eposter->eposter?>"
							 onerror="this
							 .src='<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/eposters/default.jpg'" id="eposter-img">
<?php
					endif;?>
			          <div class="card-img d-flex flex-column">
						<div class="info-box shadow-none">
						  <div class="info-box-content">
				            <h5 class="card-title text-primary text-white"><?php echo $eposter->title;?></h5>
<?php
						foreach ($eposter->authors as $author) {?>
				            <span class="info-box-text"><?php echo $author->name.' '.$author->surname; ?></span>
<?php
						}?>
						  </div>
						  <!-- /.info-box-content -->
						</div>
			            <p class="card-text text-white pb-2 pt-1"></p>
			          </div>
			        </div>
			      </div>
			    </div>
			  </div>
			</div>
<?php
				else:?>
			<div style="height: 100%; width: 100%; background-image: url('<?=ycl_root?>/ycl_assets/animations/particle_animation.gif');background-repeat: no-repeat;background-size: cover;">
				<div class="middleText">
					<h3><?=$error_text?></h3>
				</div>
			</div>
<?php
				endif;?>
		</div>
<?php
			else:?>
		<div style="height: 100%; width: 100%; background-image: url('<?=ycl_root?>/ycl_assets/animations/particle_animation.gif');background-repeat: no-repeat;background-size: cover;">
			<div class="middleText">
				<h3><?=$error_text?></h3>
			</div>
		</div>
<?php
			endif;?>
	</div>
</div>
