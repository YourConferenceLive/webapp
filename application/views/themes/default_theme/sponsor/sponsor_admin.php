<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//echo "<pre>";
//print_r($booth);
//echo "</pre>";
//exit;
?>

<link href="<?=ycl_root?>/theme_assets/default_theme/css/admin_booth.css?v=3" rel="stylesheet">
<script src="<?=ycl_root?>/theme_assets/default_theme/js/sponsor/sponsor_admin.js?v=1"></script>

<!-- Full Calendar-->
<link rel="stylesheet" href="<?=ycl_root?>/vendor_frontend/adminlte/plugins/fullcalendar/main.css">
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/moment/moment.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/fullcalendar/main.js"></script>

<!-- Date Range Picker-->
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<div class="container-fluid p-0 mt-5">
	<div class="jumbotron rounded-0" id="cover_photo" style="background-image: url('<?= (isset($booth->cover_photo) && !empty($booth->cover_photo))? ycl_root.'/cms_uploads/projects/'.$this->project->id.'/sponsor_assets/uploads/cover_photo/'.$booth->cover_photo:''?>')">
		<div class="">
			<input type="file" name="cover_upload " id="cover-upload" class="cover-upload" accept=".jpg,.png,.jpeg" style="display: none">
			<span class="btn badge badge-primary float-right btn-cover"  ><i class="fa fa-upload" aria-hidden="true" ></i> upload cover</span>
		</div>
		<div class="col">
			<?php if (isset($booth->main_video_url) && !empty($booth->main_video_url)): ?>

				<div id="tv-container">
					<div id="monitor">
						<div id="monitorscreen">
							<?=($booth->main_video_url)?>
						</div>
					</div>
				</div>
			<?php endif; ?>
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
									<?php if(isset($booth->logo) && !empty($booth->logo)):?>
										<img class="sponsor-main-logo img-thumbnail " width="250px" height="250px" src="<?= ycl_root.'/cms_uploads/projects/'.$this->project->id.'/sponsor_assets/uploads/logo/'.$booth->logo?>"  >
									<?php endif;?>
									<input type="file" name="logo_upload" id="logo-upload" class="logo-upload" accept=".jpg,.png,.jpeg" style="display: none">
									<div><span class="btn badge badge-primary float-right btn-logo " hidden><i class="fa fa-upload" aria-hidden="true"></i> upload logo</span></div>
								</div>
								<div class="row mb-5 mt-2">
									<input type="text" class="form-control sponsor-name w-50 shadow-none" disabled placeholder="sponsor name" value="<?=(isset($booth->name) && !empty($booth->name))?$booth->name:''?>">
									<span><a class="btn badge badge-primary mt-2 save-sponsor-name" hidden>save</a></span>

								</div>
							</div>
						</div>

						<div class="col-md-4 col-sm-12">
							<div class="text-center">
								<h4> About Us </h4>
								<textarea class="text-about-us form-control shadow-none" cols="25" rows="8" disabled><?=(isset($booth->about_us) && !empty($booth->about_us))?$booth->about_us:''?></textarea>
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
													<input type="text" id="website" disabled class="form-control shadow-none" placeholder="website.com" value="<?=(isset($booth->website_link) && !empty($booth->website_link))?$booth->website_link:''?>">
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
													<input type="text" id="twitter" disabled class="form-control shadow-none" placeholder="twitter_id" value="<?=(isset($booth->twitter_link) && !empty($booth->twitter_link))?$booth->twitter_link:''?>">
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
													<input type="text" id="facebook" disabled class="form-control shadow-none" placeholder="facebook_id" value="<?=(isset($booth->facebook_link) && !empty($booth->facebook_link))?$booth->facebook_link:''?>">
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
													<input type="text" id="linkedin" disabled class="form-control shadow-none" placeholder="linkedin_id" value="<?=(isset($booth->linkedin_link) && !empty($booth->linkedin_link))?$booth->linkedin_link:''?>">
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
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
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

			<div class="col-xl-8 col-lg-8 col-md-8 col-sm-12">
				<div class="sponsor-card card ">
					<div class="card-header bg-blue text-white"> Attendees <i class="far fa-comments"> </i>
						<span class="btn btn-outline-info fa fa-bars fa-2x float-left show-attendees mr-4 text-white" style="cursor: pointer;"></span>
						<span class="btn float-right fas fa-minus ml-5 text-blue btn-outline-info text-white" id="btn-collapse-sc" data-toggle="collapse" data-target="#collapse-sponsor-chat"></span>
					</div>
					<div >
						<div class="collapse show" id="collapse-sponsor-chat">
							<div class="row ">
								<div class="col-4 pr-0">
									<div class="card w-md-100 overflow-auto attendee-list">
										<div class="card-header ">
											<div class="input-group ">
												<input type="text" id="search-attendee-chat" class="form-control shadow-none">
												<div class="input-group-append"><span class="btn form-control bg-blue" aria-hidden="true" ><i class="fas fa-search text-white"></i></span></div>
											</div>
										</div>

										<div class="card-body attendee-list-body p-0">
											<span><strong>Attendees in your booth</strong></span>
											<ul id="usersInThisBooth" class="list-group mb-3">

											</ul>

											<span><strong>Other attendees</strong></span>
											<ul id="other_attendees_list" class="list-group">

											</ul>
										</div>

									</div>

								</div>
								<!--				############# SPONSOR CHAT ##########################-->
								<div class="col-8 pl-0">
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
							<span class="h5 float-left" style="color: #3C763D"> <i class="far fa-calendar-check fa-2x"></i>Current Bookings </span>
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
</div>

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


<!-- Modal CALL-->
<div class="modal fade" id="modal-call-sponsor" tabindex="-1" role="dialog" aria-labelledby="modal-schedule-meet" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modal-schedule-meet">Calling <span id="callingUserName"></span>...</h5>
			</div>
			<div class="modal-body p-0 m-0">
				<div id="videoChatContainer" class="container-fluid text-center" style="height: 50vh;background: black;">

					<div id="myVideo" style="height: 100%">

					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button id="hangUp" type="button" class="btn btn-danger"><i class="fas fa-phone-slash"></i> Hang Up</button>
			</div>
		</div>
	</div>
</div>

<script>
	var logo = "<?=$booth->logo?>";
	var date_now = "<?=date('Y-m-d H:i:s')?>";
	var current_id = "<?=$this->session->userdata('sponsor_id')?>";
	var current_booth_id = "<?=$_SESSION['project_sessions']["project_{$this->project->id}"]['exhibitor_booth_id']?>";
	var sponsor_name = "<?=$booth->name?>";

</script>
<script>
	$(document).ready(function(){
		$('.show-attendees').on('click', function(){

			$('.attendee-list').toggle('transisition');
		});

		var calendarEl = document.getElementById('calendar');
		var calendar = new FullCalendar.Calendar(calendarEl, {
			initialView: 'dayGridMonth'
		});
		calendar.render();


		socket.on('ycl_active_users_list', function (users) {
			console.log(users);
			let activeUsers = [];
			$.each(users, function (socketId, userId) {
				activeUsers.push(userId);
			});
			let uniqueActiveUsers = [...new Set(activeUsers)];
			$('.user-status-indicator').css('color', 'grey');
			$.each(uniqueActiveUsers, function (key, userId) {
				if (userId != '')
					$('.user-status-indicator[user-id='+userId+']').css('color', 'springgreen');
			});
		});
		socket.emit('ycl_get_active_users_list');


		socket.on('ycl_active_user_on_booth', function (user) {
			if (user.booth_id == current_booth_id && user_id != '')
			{
				$('.video-call[user-id="'+user.user_id+'"]').show();

				let userHtml = $('.all-users-item[user-id="'+user.user_id+'"]').clone();

				$('.all-users-item[user-id="'+user.user_id+'"]').remove();
				$('#usersInThisBooth').append('' +
						'<li class="all-users-item list-group-item" socket-id="'+user.socket_id+'" user-id="' + userHtml.attr('user-id')+ '" active-status="0" style="cursor: pointer;" data-list_id = "' + userHtml.attr('data-list_id') + '" data-chatting_to ="' + userHtml.attr('data-chatting_to') + '" data-to_id="' + userHtml.attr('data-to_id') + '">' +
						''+userHtml.html()+
						'</li>');
			}
		});

	});

</script>

<script src="<?=ycl_root?>/theme_assets/default_theme/js/sponsor/video-chat.js?v=2"></script>
