<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/assets/css/sessions.css?v=<?=rand()?>" rel="stylesheet">

<?php if(isset($view_settings) && !empty($view_settings)):?>
	<?php if($view_settings[0]->session_background_image == 1):?>
		<img id="full-screen-background" style="background-image:<?=$view_settings[0]->session_background_color?>">
	<?php else: ?>
		<img id="full-screen-background" src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/sessions/sessions_listing_background.jpg">
	<?php endif;?>
<?php else:?>
		<img id="full-screen-background" src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/sessions/sessions_listing_background.jpg">
<?php endif;?>

<?php
//print_r($session->);exit;
?>
<div class="clearfix" style="margin-bottom: 7rem;"></div>
<div class="sessions-container container-fluid pl-md-6 pr-md-6">
	<div class="col-12">
		<div class="row">
			<div class="col-md-12 card " style="max-width:800px; padding:20px; margin:auto">
				<div class="text-center btn ">
					<?php if(isset($session->session_end_image) && !empty($session->session_end_image)):?>
					<img class=""  src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/images/<?=$session->session_end_image?>" style="max-width:300px; max-height: 300px" >
					<?php endif ?>
					<?php if(isset($session->session_end_text) && !empty($session->session_end_text)):?>
						<h1><?= $session->session_end_text?></h1>
					<?php else: ?>
					<h1>Session Ended</h1>
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
</div>
