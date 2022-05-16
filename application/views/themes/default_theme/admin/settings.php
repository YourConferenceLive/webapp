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
						<input name="briefcase" type="checkbox" class="custom-control-input" <?=(isset($settings) && !empty($settings) && $settings[0]->briefcase == 1)?'checked':''?> id="briefcaseSwitch">
						<label class="custom-control-label" for="briefcaseSwitch">Briefcase</label>
					</div>
					<div class=" my-1">
						<div class="input-group">
							<div class="input-group-prepend">
								<div class="input-group-text">Homepage</div>
							</div>
							<select name="homepage_redirect" class="custom-select">
								<option value=""> Select Homepage </option>
								<option value="lobby"> Lobby </option>
								<option value="agenda"> Agenda </option>
							</select>
						</div>
					</div>
				</div>

				<div class="card-footer">
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
				dataType: 'application/json',
				data: $('#formAttendeeSettings').serialize(),
				success: function(data) {
					console.log(data)
				}
			});

		})
	})
</script>
