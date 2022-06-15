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
					<h1 class="m-0">Push Notification</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="<?=$this->project_url.'/admin/dashboard'?>">Dashboard</a></li>
						<li class="breadcrumb-item active">Push Notification</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->

	<section class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title mb-5">All Push Notification</h3>

								<div class="card-body">

									<!-- ######### body contents ####### -->

									<div class="input-group">
										<div class="input-group-prepend">
											<div class="input-group-text">Visibility</div>
										</div>
										<select name="push_notification_select" class="custom-select push_notification_select" >
											<option value="NULL"> Whole Site </option>
										</select>
									</div>

									<div class="custom-control custom-switch mt-2">
										<input name="notify_presenter" type="checkbox" class="custom-control-input notify_presenter" id="notify_presenterSwitch">
										<label class="custom-control-label" for="notify_presenterSwitch">Presenter</label>
									</div>

									<div class="custom-control custom-switch mt-2">
										<input name="notify_attendee" type="checkbox" class="custom-control-input notify_attendee" id="notify_attendeeSwitch">
										<label class="custom-control-label" for="notify_attendeeSwitch">Attendee</label>
									</div>

									<div class="mt-5">
									<label> Message : </label>
									<textarea  type="textarea" name="notification_message" class="form-control notification_message" rows="4" ></textarea>
									</div>

									<div class="mt-2 mb-5">
										<button type="button" class="btn btn-success float-right  savePushNotificationBtn"> Save </button>
									</div>
									<br>
									<div class="mt-5 mb-2">
										<table class="table  table-striped table-bordered push_notification_table">
											<thead>
												<th>#</th>
												<th>Session</th>
												<th>Session Name</th>
												<th>Message</th>
												<th>Notify to</th>
												<th>Action</th>
											</thead>
											<tbody class="push_notification_table_body">

											</tbody>
										</table>
									</div>
									<!-- ######### end body contents ####### -->

								</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<script>
	let notification_url = "<?= $this->project_url ?>/admin/push_notification_admin/"
	$(function(){
		getSessions();

		$('.savePushNotificationBtn').on('click', function(){
			if($('.notification_message').val() == ''){
				toastr.warning('Message can not be empty')
				return false
			}

			$.post(notification_url+'savePushNotification',
				{
					'session_id':$('.push_notification_select').val(),
					'presenter':($('.notify_presenter').is(':checked'))?'on':'',
					'attendee':($('.notify_attendee').is(':checked'))?'on':'',
					'message':$('.notification_message').val()

				}, function(response){

					if(response.status == 'success'){
						$('.push_notification_select').val('NULL');
						$('.notify_presenter').prop('checked', false);
						$('.notify_attendee').prop('checked', false);
						$('.notification_message').val('');

						swal.fire(
							'Success!',
							response.msg,
							'success'
						)
					}else{
						toastr.error(response.msg);
					}
			}, 'json')
		})

		getAllPushNotifications();

		$('.push_notification_table_body').on('click', '.sendNotificationBtn', function(){
			let session_id = $(this).attr('session_id')
			let project_id = $(this).attr('project_id')
			let notify_to = $(this).attr('notify_to')
			let message = $(this).attr('message')
			let notification_id = $(this).attr('notification_id')
			$.post(notification_url+'send_notification/'+notification_id,
				function(response){
				console.log(response);
					socket.emit('send_push_notification', {
						'notification_id':notification_id
					})
				},'json')



		})
	})

	function getSessions(){
		$.post(notification_url+'getAllSession', function(response){
			$('.push_notification_select').html();
			$.each(response, function(i, val){
				// console.log(val)
				$('.push_notification_select').append('<option value="'+val.id+'">(Session '+val.id+') '+val.name+'</option>');
			})
		}, 'json')
	}

	function getAllPushNotifications(){
		$.post(notification_url+'getAllPushNotification', function(response){

			if(response.status == 'success'){

				if(response.data.length > 0){
					$.each(response.data, function(i, data){
						console.log(data.session_id);
						let sendNotificationBtn = '<button class="btn btn-success btn-sm sendNotificationBtn" notification_id="'+data.id+'" session_id="'+data.session_id+'" project_id="'+data.project_id+'" notify_to="'+data.notify_to+'" message="'+data.message+'" ><i class="fas fa-paper-plane" aria-hidden="true"></i> Send Notification</button>'
						$('.push_notification_table_body').append(
							'<tr>' +
							'<td>'+(i+1)+'</td>' +
							'<td>'+((data.session_id == null)? "Whole Site":data.session_id)+'</td>' +
							'<td>'+((data.session_name == null)? "":data.session_name)+'</td>' +
							'<td>'+data.message+'</td>' +
							'<td>'+data.notify_to+'</td>' +
							'<td>'+sendNotificationBtn+'</td>' +
							'</tr>'
						)
					})
				}
			}
			$('.push_notification_table').DataTable(
				{
					className: 'text-white'
				}
			);
		},'json')
	}
</script>
