
<link href="<?=ycl_root?>/theme_assets/default_theme/css/admin_booth.css" rel="stylesheet">
<script src="<?=ycl_root?>/theme_assets/default_theme/js/sponsor/sponsor_admin.js"></script>

<!-- Full Calendar-->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.2.0/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.2.0/main.min.js'></script>

<!-- Date Range Picker-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if(isset($sponsor_data) && !empty($sponsor_data)){
$data=$sponsor_data[0];
}
//print_r($data->sponsor_name);exit;
?>
	<main role="main">
			<div class="jumbotron rounded-0" id="cover_photo" style="background-image: url('<?= (isset($data->cover_photo) && !empty($data->cover_photo))? ycl_root.'/cms_uploads/projects/'.$this->project->id.'/sponsor_assets/uploads/cover_photo/'.$data->cover_photo:''?>')">
				<div class="">
						<input type="file" name="cover_upload " id="cover-upload" class="cover-upload" accept=".jpg,.png,.jpeg" style="display: none">
						<span class="btn badge badge-primary float-right btn-cover"  ><i class="fa fa-upload" aria-hidden="true" ></i> upload cover</span>
				</div>
					<div class="col">
						<?php if (isset($data->main_video_url) && !empty($data->main_video_url)) {?>

							<div id="tv-container">
								<div id="monitor">
									<div id="monitorscreen">
										<?=($data->main_video_url)?>
									</div>
								</div>
							</div>
						<div class="row justify-content-center">
							<h4 class="text-white"><?= $data->main_video_description ?></h4>
							<?php } ?>
						</div>
					</div>
			</div>

		<div class="container-fluid px-lg-5">
<!--			<div class="row mb-4">-->
<!--				<div class="col ">-->
<!--					<div class="btn btn-outline-info float-right  btn-customize "><i class="fas  fa-wrench "></i> customize </div>-->
<!--				</div>-->
<!--			</div>-->
			<div>
				<div class="row-cols-12 w-100 bg-light rounded mb-5">

					<div class="w-100 btn btn-secondary  rounded-0 " style="background-color: #337AB7"><span class="float-left mt-2" style="font-size: 20px">ABOUT US</span><span class=" btn btn-outline-info fas fa-minus float-right my-2 ml-3 text-white" id="btn-hide-about" data-toggle="collapse" data-target="#collapse-about"></span> <span class="btn btn-outline-info btn-customize fas fa-wrench float-right my-2 ml-3 text-white"> Customize</span></div>
					<div class="collapse show" id="collapse-about">
						<div class="row  mt-4 about-us-section" >
							<div class="col-md-4  mt-3 col-sm-12">
								<div class="col ml-3">
									<div class="row">
										<?php if(isset($data->logo) && !empty($data->logo)):?>
										<img class="sponsor-main-logo img-thumbnail " width="250px" height="250px" src="<?= ycl_root.'/cms_uploads/projects/'.$this->project->id.'/sponsor_assets/uploads/logo/'.$data->logo?>"  >
										<?php endif;?>
										<input type="file" name="logo_upload" id="logo-upload" class="logo-upload" accept=".jpg,.png,.jpeg" style="display: none">
										<div><span class="btn badge badge-primary float-right btn-logo " hidden><i class="fa fa-upload" aria-hidden="true"></i> upload logo</span></div>
									</div>
									<div class="row mb-5 mt-2">
										<input type="text" class="form-control sponsor-name w-50 shadow-none" disabled placeholder="sponsor name" value="<?=(isset($data->name) && !empty($data->name))?$data->name:''?>">
										<span><a class="btn badge badge-primary mt-2 save-sponsor-name" hidden>save</a></span>

									</div>
								</div>
							</div>

						<div class="col-md-4 col-sm-12">
							<div class="text-center">
								<h4> About Us </h4>
								<textarea class="text-about-us form-control shadow-none" cols="25" rows="8" disabled><?=(isset($data->about_us) && !empty($data->about_us))?$data->about_us:''?></textarea>
								<span class="float-right"><a class="btn badge badge-primary save-about-us" hidden>save</a></span>
							</div>
						</div>
						<div class="col-md-4 mt-3 px-lg-5">
							<div class="row">
								<div class="col-md-12">
		<!-- ######################## Icons List Start ################################-->

									<div class="form-group float-md-right mx-sm-auto mr-m-2 w-100">
										<label class="sr-only" for="website" ></label>
										<div class="input-group ">
											<div class="input-group-prepend w-100">
												<div class="input-group-text py-0  bg-light w-100">
													<a target="_blank" class="btn p-0 " ><i class="fas fa-globe fa-2x m-0"></i></a>
													<input type="text" id="website" disabled class="form-control shadow-none" placeholder="website.com" value="<?=(isset($data->website_link) && !empty($data->website_link))?$data->website_link:''?>">
												</div>
												<div class="input-group-text btn bg-light btn-save-website" hidden>
													<i class="far fa-edit  text-primary text-secondary"  aria-hidden="true">save</i>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group  float-md-right mx-sm-auto mr-m-2  w-100">
										<label class="sr-only" for="twitter"  ></label>
										<div class="input-group ">
											<div class="input-group-prepend w-100">
												<div class="input-group-text py-0 bg-light w-100">
													<a target="_blank" class="btn p-0"><i class="fab fa-twitter fa-2x  m-0"></i></a>
													<input type="text" id="twitter" disabled class="form-control shadow-none" placeholder="twitter_id" value="<?=(isset($data->twitter_link) && !empty($data->twitter_link))?$data->twitter_link:''?>">
												</div>
												<div class="input-group-text btn bg-light btn-save-twitter" hidden>
													<i class="far fa-edit text-secondary"  aria-hidden="true">save</i>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group  float-md-right mx-sm-auto mr-m-2  w-100">
										<label class="sr-only " for="facebook" ></label>
										<div class="input-group">
											<div class="input-group-prepend w-100">
												<div class="input-group-text py-0 bg-light w-100">
													<a target="_blank" class="btn p-0"><i class="fab fa-facebook fa-2x  m-0"></i></a>
													<input type="text" id="facebook" disabled class="form-control shadow-none" placeholder="facebook_id" value="<?=(isset($data->facebook_link) && !empty($data->facebook_link))?$data->facebook_link:''?>">
												</div>
												<div class="input-group-text btn bg-light btn-save-facebook" hidden>
													<i class="far fa-edit  text-secondary"  aria-hidden="true">save</i>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group  float-md-right mx-sm-auto mr-m-2  w-100">
										<label class="sr-only" for="linkedin" ></label>
										<div class="input-group">
											<div class="input-group-prepend w-100 ">
												<div class="input-group-text py-0 bg-light w-100">
													<a target="_blank" class="btn p-0"><i class="fab fa-linkedin fa-2x m-0"></i></a>
													<input type="text" id="linkedin" disabled class="form-control shadow-none" placeholder="linkedin_id" value="<?=(isset($data->linkedin_link) && !empty($data->linkedin_link))?$data->linkedin_link:''?>">
												</div>
												<div class="input-group-text btn bg-light btn-save-linkedin" hidden>
													<i class="far fa-edit  text-secondary"  aria-hidden="true">save</i>
												</div>
											</div>
										</div>
									</div>
				<!--		###################			Icon List End  ###########################-->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			</div>
			<div class="row mb-5 d-flex flex-row justify-content-between rounded mb-4">
				<!--				############      GROUP CHAT #####################-->
				<div class="col-lg-4 col-md-12 col-sm-12 mb-3">
					<div class="group-chat card ">
							<div class="group-chat-header card-header text-white bg-blue ">
								<div class="row">
									<div class="col">
                                        Group Chat <span class="fa fa-users ml-2"></span>
										<span class="btn float-right fas fa-minus ml-2 text-blue btn-outline-info text-white"  id="btn-collapse-gc" data-toggle="collapse" data-target="#collapse-gc-body"></span>
										<div class="dropdown-menu-left float-right">
											<button class="btn btn-outline-info  fas fa-cog text-white " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											</button>
											<div class="dropdown-menu " aria-labelledby="dropdownMenuButton">
												<i class="dropdown-item btn  float-right ml-2 mt-2" id="btn-save-group-chat"><span class="far fa-save "> save </span></i>
												<i class="dropdown-item btn  float-right ml-2 mt-2 " id="btn-clear-group-chat"><span class="far fa-trash-alt"> clear </span></i>
												<i class="dropdown-item btn  float-right mt-2"  id="btn-show-saved-chat"><span class="far fa-clipboard"> Show saved chats</span></i>
											</div>
										</div>
									</div>
                                </div>
							</div>
							<div class="collapse show" id="collapse-gc-body">
								<div class="group-chat-body card-body overflow-auto">

								</div>
								<div class="group-chat-footer card-footer bg-light">
									<div class="input-group">
										<input type="text" id="group-chat-text" class="form-control shadow-none">
										<div class="input-group-append"><span class="btn form-control bg-blue text-white btn-group-send" aria-hidden="true"><i class="fas fa-paper-plane"></i> send</span></div>
									</div>
								</div>
							</div>
					</div>
				</div>

<!--				############     END GROUP CHAT #####################-->
<!--				############# SPONSOR CHAT ##########################-->

				<div class="col-xl-7 col-lg-8 col-md-12 ">
					<div class="sponsor-card card ">
						<div class="card-header bg-blue text-white"> Attendees <i class="far fa-comments"> </i>
							<span class="btn btn-outline-info fa fa-bars fa-2x float-left show-attendees mr-4 text-white" style="cursor: pointer;"></span>
							<span class="btn float-right fas fa-minus ml-5 text-blue btn-outline-info text-white" id="btn-collapse-sc" data-toggle="collapse" data-target="#collapse-sponsor-chat"></span>
						</div>
						<div >
							<div class="collapse show" id="collapse-sponsor-chat">
								<div class="row ">
									<div class="col-lg-4 col-xs-3 col-md-8 col-sm-12 w-100">
										<div class="card w-md-100 overflow-auto attendee-list position-absolute ">
											<div class="card-header ">
												<div class="input-group ">
													<input type="text" id="search-attendee-chat" class="form-control shadow-none"><span	class="btn fas fa-times position-absolute text-danger pt-2" id="clear-search" style="right: 40px; cursor: pointer"></span>
													<div class="input-group-append"><span class="btn form-control bg-blue" aria-hidden="true" ><i class="fas fa-search text-white"></i></span></div>
												</div>
											</div>

												<div class="card-body attendee-list-body pl-0">
														<!--<div class="card ml-3 my-1 btn pl-1"><div class="card-header p-0 bg-white border-0 btn btn-xs text-right mr-3"><span class=" fa fa-user text-primary position-absolute "></span></div><div class="card-body p-0"><a class="float-left"><img class=" btn p-0 " src="https://via.placeholder.com/150" style="width: 50px;height: 50px; border-radius: 50%"></a><div class="attendee-name mt-2 text-left ">Rexter Dayuta</div></div></div>-->
												</div>
												<div class="footer"></div>

										</div>

									</div>
									<!--				############# SPONSOR CHAT ##########################-->
									<div class="col-lg-8 float-right ">
										<div class="card sponsor-card">
											<div class="sponsor-chat-header card-header text-white bg-blue " >

											</div>
											<div class="sponsor-bg "></div>
											<div class="sponsor-chat-body card-body overflow-auto">

											<br>
											</div>
											<div class="sponsor-chat-footer card-footer ">
												<div class="input-group">
													<input type="text" id="sponsor-chat-text" class="form-control shadow-none">
													<div class="input-group-append">
														<span class="btn form-control bg-blue text-white btn-sponsor-send" aria-hidden="true"><i class="fas fa-paper-plane"></i> send</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
			</div>
		</div>
			<!--				Resource Management  -->
			<div class="row mt-5  mb-5 justify-content-center">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<div class="card w-100">
							<div class="resource-header card-header p-0" >
								<div class="m-2">
									<span class="h5 float-left" > <i class="far fa-folder fa-2x"></i> Resource Management</span>
									<span class="btn float-right fas fa-plus ml-5 text-brown btn-outline-info mt-1"  id="btn-collapse-resource" data-toggle="collapse" data-target="#collapse-resource"></span>
									<span class="float-right"><a class="btn btn-success btn-sm btn-add-resource mt-1" ><span class="fa fa-plus text-white"></span> Add new file</a></span>
								</div>
							</div>
							<div class="collapse" id="collapse-resource">
								<div class="card-body row justify-content-between resources-body overflow-auto ">

								</div>
							</div>
						</div>
					</div>
			</div>

			<!--     ###############         END RESOURCES ##############-->
<!--		##############	 Set Availability ############-->
			<div class="row mb-5 ">
				<div class="col">
					<div class="card w-100">
						<div class="card-header availability p-0  bg-light-blue">
								<div class="m-2">
									<span class="h5 float-left" style="color: #31708F"> <i class="far fa-calendar-alt fa-2x"></i> Set Availability</span>
									<span class="btn float-right fas fa-plus ml-5 text-blue btn-outline-info mt-1" id="btn-collapse-availability" data-toggle="collapse" data-target="#availability-body"></span>
								</div>
						</div>
						<div class=" collapse" id="availability-body">
							<div class="card-body">
								<div class="row">
									<div class="col-lg-4 col-md-12">
										<div class="input-group mb-3">
											<div class="input-group-prepend ">
												<span class="input-group-text far fa-calendar-plus pt-2 bg-light-blue" id="basic-addon2"> <small> Add another availability</small> </span>
											</div>
											<input type="text" class="form-control" id="date_picker" name="date_picker">
										</div>
									</div>
									<div class="col-lg-6 col-md-12">
										<div class="card availability-list">
											<div class="availability-list-header card-header text-green bg-light-blue">
												Current Availabilities List
											</div>
											<div class=" card-body availability-list-body" style="height: auto">

											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row mb-5">
				<div class="col">
					<div class="card current-bookings w-100" >
						<div class="card-header p-0  bg-light-green btn booking-header" >
								<div class="m-2">
									<span class="h5 float-left" style="color: #3C763D"> <i class="far fa-calendar-check fa-2x"></i> 	<?= (isset($data->name) && !empty ($data->name))?$data->name:'' ?> Current Bookings </span>
									<span class="btn float-right fas fa-minus ml-5 text-green btn-outline-info mt-1" id="btn-collapse-booking" data-toggle="collapse" data-target="#collapse-booking"></span>
								</div>
						</div>
						<div class="collapse show" id="collapse-booking">
							<div class="card-body current-bookings-body h-100 ">
								<div id='calendar'>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</main>

<!-- Modal for User Info -->
<div class="modal fade" id="modal-user-info" tabindex="-1" role="dialog" aria-labelledby="modal-user-info" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-user-info-label"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal for Adding Resources -->
<div class="modal fade" id="modal-add-resource" tabindex="-1" role="dialog" aria-labelledby="modal-add-resource" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-add-resource-label">Upload New Resource File</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<input type="text" name="resource_name" id="resource_name" class="form-control shadow-none mb-3" placeholder="Enter resource name" required>
				<input type="file" name="resource_file" id="resource_file" class="form-control shadow-none btn-sm" required>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-success btn-resource-upload" data-dismiss="modal">Upload</button>
			</div>
		</div>
	</div>
</div>
<script>
 var project_id = "<?= $this->project->id?>";
 var logo = "<?=$data->logo?>";
 var date_now = "<?=date('Y-m-d H:i:s')?>";
 var current_id = "<?=$this->session->userdata('sponsor_id')?>";
 var current_booth_id = "<?=$this->session->userdata('booth_id')?>";
 var sponsor_name = "<?=$data->sponsor_name?>";

</script>
<script>
	$(document).ready(function(){
		$('.show-attendees').on('click', function(){

			$('.attendee-list').toggle('transisition');
		});
	});

</script>

