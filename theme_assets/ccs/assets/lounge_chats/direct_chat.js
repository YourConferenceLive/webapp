$(function () {
	$("#directChatUserSearch").keyup(function () {
		var filter = $(this).val();
		$("#directChatUsersList li").each(function () {
			if ($(this).text().search(new RegExp(filter, "i")) < 0) {
				$(this).hide();
			} else {
				$(this).show()
			}
		});
	});

	$('.directChatUsersListItem').on('click', function () {

		Swal.fire({
			title: 'Please Wait',
			text: 'We are loading the chat...',
			imageUrl: ycl_root+'/cms_uploads/projects/'+project_id+'/theme_assets/loading.gif',
			imageUrlOnError: ycl_root+'/ycl_assets/ycl_anime_500kb.gif',
			imageAlt: 'Loading...',
			showCancelButton: false,
			showConfirmButton: false,
			allowOutsideClick: false
		});

		let userId = $(this).attr('user-id');
		let userName = $(this).attr('user-name');

		$.get(project_url+"/lounge/getDirectChatsWith/"+userId, function (chats) {
			chats = JSON.parse(chats);

			$('#otoChatMessages').html('');
			$.each(chats, function (key, chat) {

				if (chat.from_id == lounge_user_id)
				{
					$('#otoChatMessages').prepend('' +
						'<div class="direct-chat-msg right">\n' +
						' <div class="direct-chat-infos clearfix">\n' +
						'  <span class="direct-chat-name float-right">'+lounge_user_name+'</span>\n' +
						'  <span class="direct-chat-timestamp float-left">'+moment.tz(chat.date_time).format("MMMM D h:m A")+'</span>\n' +
						' </div>\n' +
						''+ycl_root+' <img class="direct-chat-img" src="/ycl_assets/images" onerror="this.onerror=null;this.src=`'+lounge_user_photo+''+ycl_root+'/ycl_assets/images/person_dp_placeholder.png`;" alt="DP Image">\n' +
						' <div class="direct-chat-text">'+chat.message+'</div>\n' +
						'</div>');
				}else{
					$('#otoChatMessages').prepend('' +
						'<div class="direct-chat-msg">\n' +
						' <div class="direct-chat-infos clearfix">\n' +
						'  <span class="direct-chat-name float-left">'+chat.name+' '+chat.surname+'</span>\n' +
						'  <span class="direct-chat-timestamp float-right">'+moment.tz(chat.date_time).format("MMMM D h:m A")+'</span>\n' +
						' </div>\n' +
						' <img class="direct-chat-img" src="'+ycl_root+'ycl_assets/images/'+chat.photo+'" onerror="this.onerror=null;this.src=`'+ycl_root+'/ycl_assets/images/person_dp_placeholder.png`;" alt="DP Image">\n' +
						' <div class="direct-chat-text">'+chat.message+'</div>\n' +
						'</div>');
				}

			});

			$('#directChatWithName').text(' ('+userName+')');
			$('#directChatSendBtn').attr('user-id', userId);

			Swal.close();
		});


	});

	$('#directChatSendBtn').on('click', function () {

		$('#directChatSendBtn').prop('disable', true);
		$('#directChatMessage').prop('disable', true);

		let userId = $(this).attr('user-id');
		let message = $('#directChatMessage').val();

		if (userId == 0)
		{
			toastr.warning('Please select a person to send text');
			return false;
		}

		if (message == '')
		{
			toastr.warning("Please enter your message");
			return false;
		}

		$.post(project_url+"/lounge/sendDirectChat",
			{
				message:message,
				to:userId
			},
			function (response) {
				if (response!=1)
					toastr.error('Unable to send message');
				else
				{
					$('#otoChatMessages').prepend('' +
						'<div class="direct-chat-msg right">\n' +
						' <div class="direct-chat-infos clearfix">\n' +
						'  <span class="direct-chat-name float-right">'+lounge_user_name+'</span>\n' +
						'  <span class="direct-chat-timestamp float-left">'+moment.tz(project_timezone).format("MMMM D h:m A")+'</span>\n' +
						' </div>\n' +
						''+ycl_root+' <img class="direct-chat-img" src="/ycl_assets/images" onerror="this.onerror=null;this.src=`'+lounge_user_photo+''+ycl_root+'/ycl_assets/images/person_dp_placeholder.png`;" alt="DP Image">\n' +
						' <div class="direct-chat-text">'+message+'</div>\n' +
						'</div>');

					socket.emit("ycl_lounge_direct_chat",
						{
							message:message,
							toId:userId,
							projectId:project_id,
							fromId:lounge_user_id,
							fromName:lounge_user_name,
							fromCredentials:lounge_user_credentials,
							fromPhoto:lounge_user_photo,
							fromCompanyName:lounge_user_company_name,
							date_time:moment.tz(project_timezone).format("MMMM D h:m A")
						});
				}

				$('#directChatMessage').val('');
				$('#directChatSendBtn').prop('disable', false);
				$('#directChatMessage').prop('disable', false);
			}).fail((error)=>{
			toastr.error('Unable to send message');
			$('#directChatMessage').val('');
			$('#directChatSendBtn').prop('disable', false);
			$('#directChatMessage').prop('disable', false);
		});

	});
	$('#directChatMessage').on('keyup', function (e) {
		if (e.key === 'Enter' || e.keyCode === 13)
			$('#directChatSendBtn').click();
	});

	socket.on("ycl_lounge_direct_chat", function (data) {
		if (data.projectId == project_id && data.toId == lounge_user_id)
		{
			if (data.fromId == $('#directChatSendBtn').attr('user-id'))
			{
				$('#otoChatMessages').prepend('' +
					'<div class="direct-chat-msg">\n' +
					' <div class="direct-chat-infos clearfix">\n' +
					'  <span class="direct-chat-name float-left">'+data.fromName+'</span>\n' +
					'  <span class="direct-chat-timestamp float-right">'+data.date_time+'</span>\n' +
					' </div>\n' +
					' <img class="direct-chat-img" src="'+ycl_root+'ycl_assets/images/'+data.fromPhoto+'" onerror="this.onerror=null;this.src=`'+ycl_root+'/ycl_assets/images/person_dp_placeholder.png`;" alt="DP Image">\n' +
					' <div class="direct-chat-text">'+data.message+'</div>\n' +
					'</div>');
			}else{
				toastr.info("New message from "+data.fromName);
			}
		}
	});


	socket.on('ycl_active_users_list', function (users) {
		let activeUsers = [];
		$.each(users, function (socketId, userId) {
			if(userId != "")
				activeUsers.push(userId);
		});
		let uniqueActiveUsers = [...new Set(activeUsers)];

		console.log(uniqueActiveUsers);

		$('.user-active-status-icon').css('color', '#ffb425');
		$.each(uniqueActiveUsers, function (key, userId) {
			if (userId != '')
				$('.user-active-status-icon[user-id='+userId+']').css('color', '#3ec800');
		});
	});
	socket.emit('ycl_get_active_users_list');
})
