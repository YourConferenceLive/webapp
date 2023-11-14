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
<link rel="stylesheet" href="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=ycl_root?>/vendor_frontend/adminlte/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script>
	let notification_url = "<?= $this->project_url ?>/admin/push_notification/"
	$(function(){
		getSessions();

		$('.savePushNotificationBtn').on('click', function(){
			if($('.notification_message').val() == ''){
				getTranslatedSelectAccess('Message can not be empty').then((msg) => {
					toastr.warning(msg);
				});
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

						let successText = "Success!";
						getTranslatedSelectAccess(successText).then((msg) => {
							successText = msg;
						});

						swal.fire(
							successText,
							response.msg,
							'success'
						)
						getAllPushNotifications();
					}else{
						toastr.error(response.msg);
					}
			}, 'json')
		})

		getAllPushNotifications();

		$('.push_notification_table_body').on('click', '.sendNotificationBtn', function(){
			let project_id = $(this).attr('project_id')
			let notification_id = $(this).attr('notification_id')
			$('.sendNotificationBtn').prop('disabled', true);
			$(this).hide();
			$this = $(this);

			$.post(notification_url+'send_notification/'+ notification_id,
				function(response){

					let timerInterval

					const translationData = fetchAllText(); // Fetch the translation data

					translationData.then((arrData) => {
						const selectedLanguage = $('#languageSelect').val(); // Get the selected language

						// Find the translations for the dialog text
						let dialogTitle = 'Are you sure you want to logout?';
						let html1 = "Sending Notification";
						let html2 = "Please Wait...";

						for (let i = 0; i < arrData.length; i++) {
							if (arrData[i].english_text === dialogTitle) {
								dialogTitle = arrData[i][selectedLanguage + '_text'];
							}
							if (arrData[i].english_text === html1) {
								html1 = arrData[i][selectedLanguage + '_text'];
							}
							if (arrData[i].english_text === html2) {
								html2 = arrData[i][selectedLanguage + '_text'];
							}
							
						}

						Swal.fire({
							title: dialogTitle,
							html: html1+' <br>'+html2+'<b>',
							timer: 3000,
							timerProgressBar: true,
							didOpen: () => {
								Swal.showLoading()
								const b = Swal.getHtmlContainer().querySelector('b')
								timerInterval = setInterval(() => {
									b.textContent = Swal.getTimerLeft()
								}, 100)
							},
							willClose: () => {
								clearInterval(timerInterval)
							}
						}).then((result) => {
							/* Read more about handling dismissals below */
							if (result.dismiss === Swal.DismissReason.timer) {
								console.log('Notification updated')
							}
						})
						
					});
					socket.emit('send_push_notification', {
						'project_id': project_id
					})
					var delayInMilliseconds = 3000; //1 second
					setTimeout(function () {
						console.log('time');
						socket.emit('close_push_notification', project_id);
						$.ajax({
							url: notification_url+'close_notification/'+ notification_id,
							type: "post",
							dataType: "json",
							success: function (response) {
								let cr_data = response;
								console.log(cr_data);
								if (cr_data.status == "success")
								{
									$this.show();
									$('.sendNotificationBtn').prop('disabled', false);
								}
								$('.sendNotificationBtn').prop('disabled', false);
							}
						});
					}, delayInMilliseconds);
				},'json')
		})

		$('.push_notification_table_body').on('click', '.deleteNotificationBtn', function(){
			let notification_id = $(this).attr('notification_id')
			let id = "&idno="+notification_id;
			$('.sendNotificationBtn').prop('disabled', true);
			$(this).hide();
			$this = $(this);

			const translationData = fetchAllText(); // Fetch the translation data

			translationData.then((arrData) => {
				const selectedLanguage = $('#languageSelect').val(); // Get the selected language

				// Find the translations for the dialog text
				let dialogTitle = 'Are you sure?';
				let dialogText = "You won't undo this!";
				let confirmButtonText = 'Yes, delete it!';
				let cancelButtonText = 'Cancel';

				// Swal 2
				let dialogTitle2 = 'Your work has been saved';

				for (let i = 0; i < arrData.length; i++) {
					if (arrData[i].english_text === dialogTitle) {
						dialogTitle = arrData[i][selectedLanguage + '_text'];
					}
					if (arrData[i].english_text === dialogText) {
						dialogText = arrData[i][selectedLanguage + '_text'];
					}
					if (arrData[i].english_text === confirmButtonText) {
						confirmButtonText = arrData[i][selectedLanguage + '_text'];
					}
					if (arrData[i].english_text === cancelButtonText) {
						cancelButtonText = arrData[i][selectedLanguage + '_text'];
					}

					if (arrData[i].english_text === dialogTitle2) {
						dialogTitle2 = arrData[i][selectedLanguage + '_text'];
					}
				}

				Swal.fire({
					title: dialogTitle,
					text: dialogText,
					icon: 'warning',
					allowOutsideClick: false,
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: confirmButtonText,
					cancelButtonText: cancelButtonText
				}).then((result) => {
					console.log("<?=$this->project_url?>/push_notification/deleteNofification/");
					base_url = "<?=$this->project_url?>/push_notification/deleteNofification/";
					if(result.value)
					{
						$('.sendNotificationBtn').prop('disabled', true);
						$('.deleteNotificationBtn').prop('disabled', true);
						$.ajax({
							url: base_url,
							method: "post",
							data: id,
							dataType: "json",
							success: function (response) {
								let cr_data = response;
								if (cr_data.status == "success")
								{
									Swal.fire({
										icon: 'success',
										title: dialogTitle2,
										text: cr_data.msg,
										allowOutsideClick: false
									}).then((result) => {
										if(result.value)
										{
											window.location.href ="<?=$this->project_url?>/admin/push_notification";
										}
									});
								}
								else
								{
									Swal.fire({
										icon: 'error',
										title: cr_data.msg,
										allowOutsideClick: false
									});
								}
							}
						});
					}
					else
					{
						console.log("Cancelled");
					}
				});
				
			});

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

				if ($.fn.DataTable.isDataTable('.push_notification_table')) {
					$('.push_notification_table').DataTable().destroy();
				}

				if(response.data.length > 0){
					$('.push_notification_table_body').html('');
					$.each(response.data, function(i, data){
						console.log(data.session_id);
						let sendNotificationBtn = '<button class="btn btn-success btn-sm sendNotificationBtn " notification_id="'+data.id+'" session_id="'+data.session_id+'" project_id="'+data.project_id+'" notify_to="'+data.notify_to+'" message="'+data.message+'" ><i class="fas fa-paper-plane" aria-hidden="true"></i> Send Notification</button>'
						let deleteNotificationBtn = '<button class="btn btn-danger btn-sm mt-1 deleteNotificationBtn " notification_id="'+data.id+'" session_id="'+data.session_id+'" project_id="'+data.project_id+'" message="'+data.message+'" ><i class="fas fa-trash" aria-hidden="true"></i> Delete Notification</button>'
						$('.push_notification_table_body').append(
							'<tr>' +
							'<td>'+(i+1)+'</td>' +
							'<td>'+((data.session_id == null)? "Whole Site":data.session_id)+'</td>' +
							'<td>'+((data.session_name == null)? "":data.session_name)+'</td>' +
							'<td>'+data.message+'</td>' +
							'<td>'+data.notify_to+'</td>' +
							'<td class="text-center" >'+sendNotificationBtn+deleteNotificationBtn+'</td>' +
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
