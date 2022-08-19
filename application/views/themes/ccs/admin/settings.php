<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0">Settings</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=$this->project_url.'/admin/settings'?>">Settings</a></li>
						<li class="breadcrumb-item active">Settings</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<section class="content">
		<div class="container-fluid">
			<div class="row row-cols-2">
				<div class="col">
					<div class="card card-default" style="max-width:800px">
						<div class="card-header">
							Attendee Settings
						</div>
						<form id="formAttendeeSettings" action="" method="post" enctype="multipart/form-data">
							<div class="card-body">
								<div class="card">
									<div class="mx-2 mt-2">
										<label>Header</label>
										<div class="custom-control custom-switch">
											<input name="lobby" type="checkbox" class="custom-control-input" <?=(isset($settings) && !empty($settings) && $settings[0]->lobby == 1)?'checked':''?> id="lobbySwitch">
											<label class="custom-control-label" for="lobbySwitch">Lobby</label>
										</div>
										<div class="custom-control custom-switch">
											<input name="agenda" type="checkbox" class="custom-control-input" <?=(isset($settings) && !empty($settings) && $settings[0]->agenda == 1)?'checked':''?> id="agendaSwitch">
											<label class="custom-control-label" for="agendaSwitch">Agenda</label>
										</div>
										<div class="custom-control custom-switch">
											<input name="eposter" type="checkbox" class="custom-control-input" <?=(isset($settings) && !empty($settings) && $settings[0]->eposter == 1)?'checked':''?> id="eposterSwitch">
											<label class="custom-control-label" for="eposterSwitch">Eposter</label>
										</div>
										<div class="custom-control custom-switch">
											<input name="lounge" type="checkbox" class="custom-control-input" <?=(isset($settings) && !empty($settings) && $settings[0]->lounge == 1)?'checked':''?> id="loungeSwitch">
											<label class="custom-control-label" for="loungeSwitch">Lounge</label>
										</div>
										<div class="custom-control custom-switch">
											<input name="exhibitionHall" type="checkbox" class="custom-control-input" <?=(isset($settings) && !empty($settings) && $settings[0]->exhibition_hall == 1)?'checked':''?> id="exhibitionHallSwitch">
											<label class="custom-control-label" for="exhibitionHallSwitch">Exhibition Hall</label>
										</div>
										<div class="custom-control custom-switch">
											<input name="scavengerHunt" type="checkbox" class="custom-control-input" <?=(isset($settings) && !empty($settings) && $settings[0]->scavenger_hunt == 1)?'checked':''?> id="scavengerSwitch">
											<label class="custom-control-label" for="scavengerSwitch">Scavenger Hunt</label>
										</div>
										<div class="custom-control custom-switch">
											<input name="relaxation" type="checkbox" class="custom-control-input" <?=(isset($settings) && !empty($settings) && $settings[0]->relaxation_zone == 1)?'checked':''?> id="relaxationSwitch">
											<label class="custom-control-label" for="relaxationSwitch">Relaxation Zone</label>
										</div>
										<div class="custom-control custom-switch">
											<input name="evaluation" type="checkbox" class="custom-control-input" <?=(isset($settings) && !empty($settings) && $settings[0]->evaluation == 1)?'checked':''?> id="evaluationSwitch">
											<label class="custom-control-label" for="evaluationSwitch">Evaluation</label>
										</div>

										<div class="custom-control custom-switch">
											<input name="mail_menu" type="checkbox" class="custom-control-input" <?=(isset($settings) && !empty($settings) && $settings[0]->mail_menu == 1)?'checked':''?> id="mailMenuSwitch">
											<label class="custom-control-label" for="mailMenuSwitch">Mail Menu Icon</label>
										</div>
										<div class="custom-control custom-switch">
											<input name="profile_menu" type="checkbox" class="custom-control-input" <?=(isset($settings) && !empty($settings) && $settings[0]->profile_menu == 1)?'checked':''?> id="profileMenuSwtich">
											<label class="custom-control-label" for="profileMenuSwtich">Profile Menu Icon</label>
											<ul>
												<li style="list-style-type: none">
													<div class="custom-control custom-switch">
														<input name="profile" type="checkbox" class="custom-control-input" <?=(isset($settings) && !empty($settings) && $settings[0]->profile == 1)?'checked':''?> id="profileSwitch">
														<label class="custom-control-label" for="profileSwitch">Profile</label>
													</div>
												</li>
												<li style="list-style-type: none">
													<div class="custom-control custom-switch">
														<input name="briefcase" type="checkbox" class="custom-control-input" <?=(isset($settings) && !empty($settings) && $settings[0]->briefcase == 1)?'checked':''?> id="briefcaseSwitch">
														<label class="custom-control-label" for="briefcaseSwitch">Briefcase</label>
													</div>
												</li>
											</ul>
										</div>
										<div class=" my-1">
											<small class="text-danger">Use CSS units for logo size. ex: 240px, 100vh etc. Without white space.</small>
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">Logo Size (Width x Height) </div>
												</div>
												<input  name="header_logo_width" type="text" class="form-control" style="max-width:100px" value=" <?=(isset($settings) && !empty($settings) && $settings[0]->header_logo_width)?$settings[0]->header_logo_width:''?> ">
												<input  name="header_logo_height" type="text" class="form-control" style="max-width:100px;" value="<?=(isset($settings) && !empty($settings) && $settings[0]->header_logo_height)?$settings[0]->header_logo_height:''?> ">
											</div>
										</div>
									</div>
								</div>
								<div class="card">
									<div class="mx-2">
										<label>Session Listing</label>
										<div class="custom-control custom-switch">
											<input name="session_background_image" type="checkbox" class="custom-control-input" <?=(isset($settings) && !empty($settings) && $settings[0]->session_background_image == 1)?'checked':''?> id="sessionBackgroundSwitch">
											<label class="custom-control-label" for="sessionBackgroundSwitch">Set Background</label>
										</div>
										<div class=" my-1">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">Session Background</div>
												</div>
												<input  name="session_background_color" show-color="sessionBackground-color-picked" type="text" class="form-control bgImage-pick " style="max-width:200px" value="<?=(isset($settings) && !empty($settings) && !empty($settings[0]->session_background_color))?$settings[0]->session_background_color:''?>">
												<div class="form-control" id="sessionBackground-color-picked" style="max-width:40px; background-image:<?=(isset($settings) && !empty($settings) && !empty($settings[0]->session_background_color))?$settings[0]->session_background_color:''?>"></div>
											</div>
										</div>

										<br>
										<label>Session View</label>
										<div class=" my-1">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">Right Sticky Icon</div>
												</div>
												<input  name="stickIcon_color" show-color="stickyIcon-color-picked" type="text" class="form-control bgColor-pick " style="max-width:200px" value="<?=(isset($settings) && !empty($settings) && !empty($settings[0]->stickyIcon_color))?$settings[0]->stickyIcon_color:''?>">
												<div class="form-control" id="stickyIcon-color-picked" style="max-width:40px; background-color:<?=(isset($settings) && !empty($settings) && !empty($settings[0]->stickyIcon_color))?$settings[0]->stickyIcon_color:''?>"></div>
											</div>
										</div>
										<div class=" my-1">
											<div class="input-group">
												<div class="input-group-prepend">
													<div class="input-group-text">Poll Music  &nbsp;</div>
												</div>
												<input  name="poll_music" id="poll_music" type="file"  accept=".mp3"  class="form-control bgColor-pick " style="max-width:250px" value="">
												<span class="form-control" style="max-width:40px"> <i class="fas fa-music"></i></span>
											</div>
										</div>
									</div>
								</div>
								<div>
									<div class="card">

									</div>
									<div class=" my-1">
										<div class="input-group">
											<div class="input-group-prepend">
												<div class="input-group-text">Live Support Color</div>
											</div>
											<input  name="live_support_color" show-color="livesupport-color-picked" type="text" class="form-control bgColor-pick" style="max-width:200px" value="<?=(isset($settings) && !empty($settings) && !empty($settings[0]->live_support_color))?$settings[0]->live_support_color:'#6D8FA7'?>">
											<div class="form-control" id="livesupport-color-picked" style="max-width:40px; background-color:<?=(isset($settings) && !empty($settings) && !empty($settings[0]->live_support_color))?$settings[0]->live_support_color:'#6D8FA7'?>"></div>
										</div>
									</div>
									<div class=" my-1">
										<div class="input-group">
											<div class="input-group-prepend">
												<div class="input-group-text">Homepage</div>
											</div>
											<select name="homepage_redirect" class="custom-select">
												<option value=""> Select Homepage </option>
												<option value="lobby" <?=(isset($settings) && !empty($settings) && $settings[0]->homepage_redirect == 'lobby')?'selected':''?>> Lobby </option>
												<option value="sessions" <?=(isset($settings) && !empty($settings) && $settings[0]->homepage_redirect == 'sessions')?'selected':''?> > Agenda </option>
											</select>
										</div>
									</div>
								</div>

								<div class="card-footer mt-3">
									<div class="text-right">
										<input type="submit" class="btn btn-success" value="Save">
									</div>
								</div>
						</form>
					</div>
				</div>
			</div>
<!--				end col-->
				<div class="col">
					<div class="card card-default" style="max-width:800px">
						<div class="card-header">
							Presenter Settings
						</div>
						<form id="formPresenterSettings" action="" method="post" enctype="multipart/form-data">
							<div class="card-body">
								<div class="card">
									<div class="mx-2 mt-2">
										<label>Presenter Session View</label>
										<div class="input-group">
											<div class="input-group-prepend">
												<div class="input-group-text">Presenter Time Zone </div>
											</div>
											<input  name="presenter_timezone" type="text" class="form-control" style="max-width:200px" value=" <?=(isset($presenter_settings) && !empty($presenter_settings) && $presenter_settings[0]->time_zone) ? $presenter_settings[0]->time_zone:''?>">
										</div>
										<small class="text-danger"> This will change the presenter countdown timer on presenter/session/view </small>
									</div>
								</div>
							</div>

							<div class="card-footer mt-3">
								<div class="text-right">
									<input type="submit" class="btn btn-success" value="Save">
								</div>
							</div>
						</form>
					</div>
				</div>
<!--				end col-->
			</div>

		</div>
	</section>
<script>
	$(function(){
		$('#formAttendeeSettings').on('submit', function(e){
			e.preventDefault();
			let formData = new FormData(document.getElementById('formAttendeeSettings'));
				formData.append('poll_music',$('#poll_music')[0].files[0])
			$.ajax({
				url: "<?=$this->project_url.'/admin/settings/saveAttendeeViewSetting'?>",
				type: 'post',
				dataType: 'json',
				data: formData ,
				processData: false,
				contentType: false,
				success: function(data) {
					toastr.success(data.msg)
				}
			});

		})
		$('.bgImage-pick').on('change', function(){
			let show_color = $(this).attr('show-color');
			$('#'+show_color).css('background-image', $(this).val());
		})

		$('.bgColor-pick').on('change', function(){
			let show_color = $(this).attr('show-color');
			$('#'+show_color).css('background-color', $(this).val());
		})
	})


	$('#formPresenterSettings').on('submit', function(e){
		e.preventDefault();
		let formData = new FormData(document.getElementById('formPresenterSettings'));
		$.ajax({
			url: "<?=$this->project_url.'/admin/settings/savePresenterViewSetting'?>",
			type: 'post',
			dataType: 'json',
			data: formData ,
			processData: false,
			contentType: false,
			success: function(data) {
				toastr.success(data.msg)
			}
		});
	})

	function color(){

	}
</script>
