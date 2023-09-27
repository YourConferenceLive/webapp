<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/assets/css/sessions.css?v=<?=rand()?>" rel="stylesheet">
<style>
	.card{
		width: 70vw ;
		padding:0;
	}

	.card-bg{
		background-size:100% 100%;
	}

	.card-header{
		padding:0;
		background-color:#58595B;
		color:white;
	}
	.card-body{
		padding:0;
		height: 70vh; 
	}


	@media screen and (max-width: 1300px){
		.card-body{
			max-height: 500px; 
		}

		.card{
			width: 100vw !important;
			
		}	
		.row{
			margin:0
		}
	}


	@media screen and (max-width: 750px){
		.card-body{
			max-height: 400px; 
		}

		.card{
			width: 100vw !important;
			
		}	
		.row{
			margin:0
		}
	}

	@media screen and (max-width: 420px){
		.card-body{
			max-height: 200px; 
		}

		.card{
			width: 100vw;
			
		}
		.row{
			margin:0
		}
	}

</style>

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
		<div class="row d-flex justify-content-center">
			<div class="card" style="">
				<?php if(isset($session->session_end_text) && !empty($session->session_end_text)):?>
					<div class="card-header d-flex justify-content-center"><h1 class="my-2 mx-4"><?= $session->session_end_text?></h1></div>
				<?php endif ?>
				<?php if(isset($session->session_end_image) && !empty($session->session_end_image)):?>
				<div class="card-body card-bg" style="background-image: url(<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/images/<?=$session->session_end_image?>)">
					<div class="text-center btn ">
					</div>
				</div>
				<?php endif ?>
			</div>
		</div>
	</div>
</div>