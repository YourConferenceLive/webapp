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
			<div class="card card-default" style="max-width:800px">
				<div class="card-header">
					Attendee Settings
				</div>
				<form id="formAttendeeSettings" action="" method="post">
				<div class="card-body">
					<div class="card">
						<div class="mx-2 mt-2">
							<label>Header Menu</label>
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
									<input  name="session_background_color" show-color="sessionBackground-color-picked" type="text" class="form-control color-pick " style="max-width:200px" value="<?=(isset($settings) && !empty($settings) && !empty($settings[0]->session_background_color))?$settings[0]->session_background_color:'#6D8FA7'?>">
									<div class="form-control" id="sessionBackground-color-picked" style="max-width:40px; background-image:<?=(isset($settings) && !empty($settings) && !empty($settings[0]->session_background_color))?$settings[0]->session_background_color:'#6D8FA7'?>"></div>
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
							<input  name="live_support_color" show-color="livesupport-color-picked" type="text" class="form-control color-pick" style="max-width:200px" value="<?=(isset($settings) && !empty($settings) && !empty($settings[0]->live_support_color))?$settings[0]->live_support_color:'#6D8FA7'?>">
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
	</section>
<script>
	$(function(){
		$('#formAttendeeSettings').on('submit', function(e){
			e.preventDefault();
			$.ajax({
				url: "<?=$this->project_url.'/admin/settings/saveAttendeeViewSetting'?>",
				type: 'post',
				dataType: 'json',
				data: $('#formAttendeeSettings').serialize(),
				success: function(data) {
					toastr.success(data.msg)
				}
			});

		})
		$('.color-pick').on('change', function(){
			let show_color = $(this).attr('show-color');
			console.log();
			$('#'+show_color).css('background-color', $(this).val());
		})
	})

	function color(){

	}
</script>
