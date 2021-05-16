<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php
if(isset($sponsor_data) && !empty($sponsor_data)){
	$data=$sponsor_data[0];
}

//?>
<link href="<?= ycl_root ?>/theme_assets/default_theme/css/booth.css" rel="stylesheet">
<script src="<?=ycl_root?>/theme_assets/default_theme/js/sponsor/sponsor_attendee.js"></script>

<!-- Date Time Picker-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.16/jquery.datetimepicker.full.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.16/jquery.datetimepicker.css">

<main role="main">
		<div class="jumbotron rounded-0" style="background-image: url('<?= (isset($data->cover_photo) && !empty($data->cover_photo)) ?  ycl_root . '/cms_uploads/projects/'.$this->project->id.'/sponsor_assets/uploads/cover_photo/' . $data->cover_photo:'' ?> ')">
			<div class="">
				<div class="col">
					<?php if (isset($data->main_video_url) && !empty($data->main_video_url)) {
						?>
						<div id="tv-container">
							<div id="monitor">
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
					<div class="row mb-2 about-us-video align-content-center ">
						<div class="col p-0 m-0 h-100 w-100">
							<iframe src="https://player.vimeo.com/video/448010668?title=0&amp;byline=0&amp;portrait=0"
									style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0"
									allow="autoplay; fullscreen" allowfullscreen=""></iframe>
							<script src="https://player.vimeo.com/api/player.js"></script>

						</div>
					</div>
					<div class="row justify-content-center mb-2">
						<div class="col website-icons text-center">
							<a href="<?=(isset($data->website_link) && !empty($data->website_link)?$data->website_link : '')?>" target="_blank" class="btn p-0" title="<?=(isset($data->website_link) && !empty($data->website_link)?$data->website_link : '')?>"><i class="fa fa-globe fa-2x"></i></a>
							<a href="https://www.facebook.com/<?=(isset($data->facebook_link) && !empty($data->facebook_link)?$data->facebook_link : '')?>" target="_blank" class="btn p-0" title="<?=(isset($data->facebook_link) && !empty($data->facebook_link)?$data->facebook_link : '')?>"><i class="fab fa-facebook fa-2x" aria-hidden="true"></i></a>
							<a href="https://www.twitter.com/<?=(isset($data->twitter_link) && !empty($data->twitter_link)?$data->twitter_link : '')?>" target="_blank" class="btn p-0" title="twitter.com/<?=(isset($data->twitter_link) && !empty($data->twitter_link)?$data->twitter_link : '')?>"><i class="fab fa-twitter fa-2x" aria-hidden="true"></i></a>
							<a class="btn p-0" title="<?=(isset($data->linkedin_link) && !empty($data->linkedin_link)?$data->linkedin_link : '')?>"><i class="fab fa-linkedin fa-2x" aria-hidden="true"></i></a>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-8 col-md-12 mt-5 ">
				<div class="row">
					<!--				##############   GROUP CHAT #############################-->
					<div class="col-xl-6 col-lg-12 mb-3 mt-5">
						<div class="group-chat card border border-secondary  shadow ml-2">
							<div class="">
								<div class="group-chat-header card-header" style="background-color: #337AB7">
									<div class="row">
										<div class="col text-white">
											Group Chat
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
					<!--				##############   GROUP CHAT #############################-->
					<div class="col-xl-6 col-lg-12 mt-5">
						<!--################## SPONSOR CHAT #######################-->
						<div class="sponsor-chat card border-secondary shadow ml-2">
							<div class="row">
								<div class="col-md-12 float-right">
									<div class="card">
										<div class="sponsor-chat-header card-header text-white"
											 style="background-color: #337AB7">
											Sponsor Chat
											<i class="btn badge badge-light float-right ml-2" id="sponsor-call"><span class="fas fa-phone-alt"> call </span></i>
											<i class="btn badge badge-light float-right" id="schedule-a-meet"><span class="far fa-calendar-check"> schedule a meet </span></i>
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

<!-- Modal -->
<div class="modal fade" id="modal-schedule-meet" tabindex="-1" role="dialog" aria-labelledby="modal-schedule-meet" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-schedule-meet">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<select name="sponsor_list" class="form-control shadow-none" id="sponsor-list">
				</select><br>
				<div class=" input-group">
					<input type="text" id="date-time-picker" class="form-control p-4 shadow-none" style="cursor: pointer" readonly><span class="btn btn-success" ><i class="far fa-calendar-plus fa-2x"></i> BOOK</span>
				</div>
				</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div>
	</div>
</div>
<script>
	var project_id ="<?= $this->project->id?>";
	var logo = "<?=$data->logo?>";
	var date_now = "<?=date('Y-m-d H:i:s')?>";

	var current_user_id ="<?= ($this->session->userdata('project_sessions')["project_{$this->project->id}"]['user_id'])?>";
	var current_booth_id="<?=$data->id?>";

</script>

