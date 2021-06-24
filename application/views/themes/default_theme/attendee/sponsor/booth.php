<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php
//print_r($sponsor_data);exit;

$hunting_icon="";
if(isset($sponsor_data) && !empty($sponsor_data)){
	$data=$sponsor_data[0];
}

if($hunt_item){
	$hunting_icon=$sponsor_data[0]->hunting_icon;
}

$cover_photo_url='theme_assets/booth_uploads/'.$data->cover_photo;

if(!file_exists($cover_photo_url)){
	$cover_photo_url='/cms_uploads/projects/'.$this->project->id.'/sponsor_assets/uploads/cover_photo/'.$data->cover_photo;
}
?>
<link href="<?= ycl_root ?>/theme_assets/default_theme/css/booth.css?ver=10" rel="stylesheet">
<!-- Date Time Picker-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.16/jquery.datetimepicker.full.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.16/jquery.datetimepicker.css">

<main role="main" class="template<?=$data->template?> double_banner<?=$data->double_banner?>">
	<div class="jumbotron rounded-0" style="background-image: url('<?= (isset($data->cover_photo) && !empty($data->cover_photo)) ?  ycl_root . '/'.$cover_photo_url:'' ?> ')">
		<div class="content">
			<div class="middle">
				<img src="<?= ycl_root ?>/theme_assets/booth_uploads/<?=$data->tv_banner?>" id="tv_banner">
				<?php if (isset($data->main_video_url) && !empty($data->main_video_url) && $data->video_position == '1') {
					?>
					<div id="tv-container" >
						<div id="monitor" style="z-index: 2 !important;">
							<div id="monitorscreen">
								<?=($data->main_video_url)?>
							</div>
						</div>
					</div>
					<?php
				} ?>
				<div class="row justify-content-center">
					<h4 class="text-white"><?= $data->main_video_description ?></h4>
				</div>
			</div>
			<div class="left">
				<img src="<?= ycl_root ?>/theme_assets/booth_uploads/<?=$data->left_banner?>" class="wt_booth_img" data-url="<?=$data->left_banner_url?>">
			</div>
			<div class="right">
				<img src="<?= ycl_root ?>/theme_assets/booth_uploads/<?=$data->right_banner?>" class="wt_booth_img" data-url="<?=$data->right_banner_url?>">
			</div>
		</div>
		<div class="tables">
			<div class="table_left">
				<img src="<?= ycl_root ?>/theme_assets/booth_uploads/<?=$data->left_table?>" class="wt_booth_img" data-url="<?=$data->left_table_url?>">
			</div>
			<div class="table_right">
				<img src="<?= ycl_root ?>/theme_assets/booth_uploads/<?=$data->right_table?>" class="wt_booth_img" data-url="<?=$data->right_table_url?>">
			</div>
		</div>
	</div>
	<div class="container-fluid px-lg-5">
		<div class="row mx-xl-4 mx-md-1">
			<div class="col-lg-4 col-md-12  mt-3 ">
				<div class="col ml-xl-3 ml-md-0">
					<div class="row justify-content-lg-start mx-ml-5 justify-content-md-center">
						<!--						--><?php //print_r($data->logo)?>
						<?php if (isset($data->logo) && !empty($data->logo)): ?>
							<img class="sponsor-main-logo img-thumbnail " width="250px" height="250px"
								 alt="sponsor-logo" src="<?= ycl_root . '/cms_uploads/projects/'.$this->project->id.'/sponsor_assets/uploads/logo/' . $data->logo ?> ">
						<?php endif; ?>
					</div>
					<div class="row mb-5 justify-content-lg-start mx-ml-5 justify-content-md-center">
						<h3 class="sponsor-name"> <?= $data->name ?></h3>
					</div>
					<div class="about-us">
						<h4> About Us </h4>
						<p class="text-left mr-5"><?= $data->about_us ?></p>

					</div>
					<?php if (isset($data->main_video_url) && !empty($data->main_video_url) && $data->video_position == '0') { ?>
					<div class="row mb-2 about-us-video align-content-center ">
						<div class="col p-0 m-0 h-100 w-100">
							<?=($data->main_video_url)?>
						</div>
					</div>
					<?php } ?>
					<div class="row justify-content-center mb-2">
						<div class="col website-icons">
							<?=(isset($data->website_link) && !empty($data->website_link)?'<a href="'.$data->website_link.'" target="_blank" class="btn p-0" title="'.$data->website_link.'"><i class="fa fa-globe fa-2x"></i></a>' : '')?>
							<?=(isset($data->facebook_link) && !empty($data->facebook_link)?'<a href="'.$data->facebook_link .'" target="_blank" class="btn p-0" title="'.(isset($data->facebook_link) && !empty($data->facebook_link)?$data->facebook_link : '').'"><i class="fab fa-facebook fa-2x" aria-hidden="true"></i></a>': '')?>
							<?=(isset($data->facebook_link2) && !empty($data->facebook_link2)?'<a href="'.$data->facebook_link2 .'" target="_blank" class="btn p-0" title="'.(isset($data->facebook_link2) && !empty($data->facebook_link2)?$data->facebook_link2 : '').'"><i class="fab fa-facebook fa-2x" aria-hidden="true"></i></a>': '')?>
							<?=(isset($data->twitter_link) && !empty($data->twitter_link)?'<a href="'.$data->twitter_link.'" target="_blank" class="btn p-0" title="twitter.com/'.(isset($data->twitter_link) && !empty($data->twitter_link)?$data->twitter_link : '').'"><i class="fab fa-twitter fa-2x" aria-hidden="true"></i></a>' : '')?>
							<?=(isset($data->twitter_link2) && !empty($data->twitter_link2)?'<a href="'.$data->twitter_link.'" target="_blank" class="btn p-0" title="twitter.com/'.(isset($data->twitter_link2) && !empty($data->twitter_link2)?$data->twitter_link2 : '').'"><i class="fab fa-twitter fa-2x" aria-hidden="true"></i></a>' : '')?>
							<?=(isset($data->linkedin_link) && !empty($data->linkedin_link)?'<a class="btn p-0" href="'.$data->linkedin_link.'" target="_blank" class="btn p-0" title="linkedin.com/'.(isset($data->linkedin_link) && !empty($data->linkedin_link)?$data->linkedin_link : '').'"><i class="fab fa-linkedin fa-2x" aria-hidden="true"></i></a>' : '')?>
						</div>
					</div>

					<div class="extra_videos">
						<div class="extra_video_1"><?=$data->extra_video_1?></div>
						<div class="extra_video_2"><?=$data->extra_video_2?></div>
					</div>
				</div>
			</div>
			<div class="col-lg-8 col-md-12 mt-5 ">
				<div class="row">
					<!--				##############   GROUP CHAT #############################-->
					<?php
					if($data->show_group_chat){
						?>
						<div class="col-xl-6 col-lg-12 mb-3 mt-5">
							<div class="group-chat card border border-secondary  shadow ml-2">
								<div class="">
									<div class="group-chat-header card-header" style="background-color: #337AB7">
										<div class="row">
											<div class="col text-white">
												Group Chat <span class="fas fa-users"></span>
											</div>
										</div>
									</div>
									<div class="group-chat-body card-body overflow-auto ">

									</div>
									<div class="group-chat-footer card-footer bg-light">
										<div class="input-group">
											<input type="text" id="group-chat-text" class="form-control  shadow-none"
												   placeholder="You can also press enter to send">
											<div class="input-group-append btn-group-send">
												<i class="btn btn-primary far  fa-paper-plane form-control send-group-message pt-2"
												   aria-hidden="true" style="background-color: #337AB7"> send</i>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php
					}
					?>
					<!--				##############   GROUP CHAT #############################-->
					<div class="col-xl-6 col-lg-12 mt-5">
						<!--################## SPONSOR CHAT #######################-->
						<div class="sponsor-chat card border-secondary shadow ml-2">
							<div class="row">
								<div class="col-md-12 float-right">
									<div class="card">
										<div class="sponsor-chat-header card-header text-white"
											 style="background-color: #337AB7">
											Sponsor Chat <span class="far fa-comments"></span>

											<div class="dropdown float-right ml-2">
												<button class="btn btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
													<i class="fas fa-video"></i> Call
												</button>
												<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
													<?php foreach ($admins as $admin): ?>
														<button class="dropdown-item video-call" room-id="booth_oto_vc_<?=$admin->id?>" user-id="<?=$admin->id?>" user-name="<?=$admin->name?> <?=$admin->surname?>"><?=$admin->name?> <?=$admin->surname?></button>
													<?php endforeach; ?>
												</div>
											</div>

											<button class="btn btn-sm btn-success float-right" id="schedule-a-meet"><span class="far fa-calendar-check"> Schedule a meet </span></button>
										</div>
										<div class="sponsor-chat-body card-body overflow-auto">
											<br>
										</div>
										<div class="sponsor-chat-footer card-footer ">
											<div class="input-group">
												<input type="text" id="sponsor-chat-text" class="form-control shadow-none" placeholder="You can also press enter to send">
												<div class="input-group-append btn-sponsor-send">
													<span class="btn btn-primary far  fa-paper-plane form-control send-sponsor-message pt-2" aria-hidden="true" style="background-color: #337AB7"> send</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--################## END SPONSOR CHAT #######################-->
					</div>
				</div>

			</div>
		</div>
		<div class="row m-4">
			<?php if ( isset($data->special_link) && !empty($data->special_link) && isset($data->special_link_title) && !empty($data->special_link_title)) {
				?>
					<div class="offset-lg-4 col-lg-4 col-md-12">
						<a type="button" class="btn btn-link" href="<?=($data->special_link)?>"><?=($data->special_link_title)?></a>
					</div>
					<?php
			} ?>
		</div>
		<div class="row m-xl-4 mb-md-1 justify-content-center flex-lg-row flex-sm-column-reverse flex-row-reverse">

			<div class="col-lg-4 col-md-12">
				<div class="row justify-content-center">
					<div class="card w-100 mb-5 mx-4">
						<div class="card-header">
						</div>
						<div class="card-footer embed-section ">
							<a class="twitter-timeline" href="https://twitter.com/@<?= $data->twitter_link ?>?ref_src=twsrc%5Etfw">Tweets by @<?= $data->twitter_link ?></a>
							<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
						</div>
					</div>
				</div>
			</div>

			<!--				SPONSOR RESOURCES -->
			<div class="col-lg-8 col-md-12 my-xl-0 my-sm-5 ">
				<div class="resources-box">
					<div class="card">
						<div class="card-header" style="background-color: #337AB7">
							<h4 class="text-center text-white">Resources</h4>
						</div>
						<div class="card-body row justify-content-between resources-body overflow-auto ">
<!--							<div class=" col-md-6 "><div class="card col-md-12 w-100 p-0"><div class="card-header w-100 "><h5 class="text-brown"> NAME</h5></div><div class="card-footer"><a class="btn btn-success float-right"><small><span class="fa fa-external-link"> </span> Open</small>  </a></div></div></div>-->
<!--			-->

						</div>
					</div>
				</div>
			</div>
			<!--     ###############         END RESOURCES ##############-->
		</div>
	</div>
</main>

<!-- Modal SCHEDULE-->
<div class="modal fade" id="modal-schedule-meet" tabindex="-1" role="dialog" aria-labelledby="modal-schedule-meet" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-schedule-meet">Book Sponsor Meet</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<select name="sponsor_list" class="form-control shadow-none" id="sponsor-list">
				</select><br>
				<div class=" input-group">
					<input type="text" id="date-time-picker" class="form-control p-4 shadow-none"  style="cursor: pointer" readonly><a class="btn btn-success book-meet-btn " style="border-radius: 0px 5px 5px 0px"><i class="far fa-calendar-plus fa-2x"></i> Book</a>
				</div>
				</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<script>
	var logo = "<?= $data->logo ?>";
	var date_now = "<?= date('Y-m-d H:i:s') ?>";

	var current_user_id = "<?= ($this->session->userdata('project_sessions')["project_{$this->project->id}"]['user_id']) ?>";
	var current_booth_id= "<?= $data->id ?>";
	var current_user_name = "<?=$this->session->userdata('project_sessions')["project_{$this->project->id}"]['name']?> <?=$this->session->userdata('project_sessions')["project_{$this->project->id}"]['surname']?>";
	var current_user_surname = "<?= (isset($this->session->userdata('project_sessions')["project_{$this->project->id}"]['surname']))?$this->session->userdata('project_sessions')["project_{$this->project->id}"]['surname']:'' ?>";
	var current_user_fullname = current_user_name+' '+current_user_surname;
	var company_name = "<?=$data->name?>";
	var hunting_icon = "<?=$hunting_icon?>";
</script>

<script src="<?=ycl_root?>/theme_assets/default_theme/js/sponsor/sponsor_attendee.js?ver=10"></script>
<script>
	socket.emit('ycl_booth_visit', {'booth_id':current_booth_id, 'user_id' : user_id});
</script>
