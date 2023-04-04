$(function () {

	$('#sendGroupChatBtn').on('click', function () {

		$('#sendGroupChatBtn').prop('disable', true);
		$('#groupChatMsg').prop('disable', true);

		let message = ($('#groupChatMsg').val()).replace(/<[^>]*>?/gm, '');

		if (message == '')
		{
			toastr.warning('Please enter your message');
			return false;
		}

		$.post(
			project_url+"/lounge/sendGroupChat",
			{
				message:message
			},
			function (response) {
				if (response!=1)
					toastr.error('Unable to send message');
				else{
					$('#groupChatMessages').prepend('' +
						'<div class="direct-chat-msg right">\n' +
						' <div class="direct-chat-infos clearfix">\n' +
						'  <span class="direct-chat-name float-right">'+lounge_user_name+lounge_user_credentials+'<br><small>'+lounge_user_company_name+'</small></span>\n' +
						'  <span class="direct-chat-timestamp float-left">'+moment.tz(project_timezone).format("MMMM D h:m A")+'</span>\n' +
						' </div>\n' +
						' <img class="direct-chat-img" src="'+ycl_root+'/cms_uploads/user_photo/profile_pictures/'+lounge_user_photo+'" onerror="this.onerror=null;this.src=`'+ycl_root+'/ycl_assets/images/person_dp_placeholder.png`;" alt="DP Image">\n' +
						' <div class="direct-chat-text">'+message+'</div>\n' +
						'</div>');

					socket.emit("ycl_lounge_group_chat",
						{
							message:message,
							projectId:project_id,
							fromId:lounge_user_id,
							fromName:lounge_user_name,
							fromCredentials:lounge_user_credentials,
							fromPhoto:lounge_user_photo,
							fromCompanyName:lounge_user_company_name,
							date_time:moment.tz(project_timezone).format("MMMM D h:m A")
						});
					}

				$('#groupChatMsg').val('');
				$('#sendGroupChatBtn').prop('disable', false);
				$('#groupChatMsg').prop('disable', false);
		}).fail((error)=>{
			toastr.error('Unable to send message');
			$('#sendGroupChatBtn').prop('disable', false);
			$('#groupChatMsg').prop('disable', false);
		});
	});
	$('#groupChatMsg').on('keyup', function (e) {
		if (e.key === 'Enter' || e.keyCode === 13)
			$('#sendGroupChatBtn').click();
	});


	socket.on("ycl_lounge_group_chat", function (data) {
		if (data.projectId == project_id)
		{
			$('#groupChatMessages').prepend('' +
				'<div class="direct-chat-msg">\n' +
				' <div class="direct-chat-infos clearfix">\n' +
				'  <span class="direct-chat-name float-left">'+data.fromName+data.fromCredentials+'<br><small>'+data.fromCompanyName+'</small></span>\n' +
				'  <span class="direct-chat-timestamp float-right">'+data.date_time+'</span>\n' +
				' </div>\n' +
				' <img class="direct-chat-img" src="'+ycl_root+'/cms_uploads/user_photo/profile_pictures/'+data.fromPhoto+'" onerror="this.onerror=null;this.src=`'+ycl_root+'/ycl_assets/images/person_dp_placeholder.png`;" alt="DP Image">\n' +
				' <div class="direct-chat-text">'+data.message+'</div>\n' +
				'</div>');
		}
	});
})
