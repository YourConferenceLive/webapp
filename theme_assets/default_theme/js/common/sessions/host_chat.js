// Hooks/events on page load
$(function () {

	loadAllHostChats(session_id);

	/**
	 * Send message
	 */
	$('#sendHostChatBtn').on('click', function () {
		sendHostChatMessage();
	});
	$('#hostChatNewMessage').on('keyup', function (e) {
		if (e.key === 'Enter' || e.keyCode === 13)
			sendHostChatMessage();
	});

	/**
	 * Receive message
	 */
	socket.on('ycl_host_chat', function (chat) {
		if (chat.session_id == session_id)
			receiveHostChatMessage(chat);
	});


});

// Once on page load
function loadAllHostChats(session_id)
{
	$.get(controllerPath+"/sessions/getHostChatsJson/"+session_id, function (chats) {
		chats = JSON.parse(chats);

		$('#hostChatDiv').html('');
		$.each(chats, function (key, chat) {

			if (chat.host_id == user_id)
			{
				$('#hostChatDiv').prepend('' +
					'<div class="direct-chat-msg right">' +
					'  <div class="direct-chat-infos clearfix">' +
					'    <span class="direct-chat-name float-right">'+chat.host_name+'</span>' +
					'    <span class="direct-chat-timestamp float-left" data-toggle="tooltip" title="'+moment.tz(chat.date_time, project_timezone).format("D MMMM h:mmA")+'">'+moment.tz(chat.date_time, project_timezone).fromNow()+'</span>' +
					'  </div>' +
					'  <img class="direct-chat-img" src="'+ycl_root+'/cms_uploads/projects/'+project_id+'/user_assets/user_photos/'+chat.host_photo+'" onerror="this.onerror=null;this.src=`'+ycl_root+'/ycl_assets/images/person_dp_placeholder.png`;" alt="DP Image">' +
					'  <div class="direct-chat-text">' +
					'  '+chat.message+
					'  </div>' +
					'</div>');
			}else{
				$('#hostChatDiv').prepend('' +
					'<div class="direct-chat-msg">' +
					'  <div class="direct-chat-infos clearfix">' +
					'   <span class="direct-chat-name float-left">'+chat.host_name+'</span>' +
					'   <span class="direct-chat-timestamp float-right" data-toggle="tooltip" title="'+moment.tz(chat.date_time, project_timezone).format("D MMMM h:mmA")+'">'+moment.tz(chat.date_time, project_timezone).fromNow()+'</span>' +
					'  </div>' +
					'  <img class="direct-chat-img" src="'+ycl_root+'/cms_uploads/projects/'+project_id+'/user_assets/user_photos/'+chat.host_photo+'" onerror="this.onerror=null;this.src=`'+ycl_root+'/ycl_assets/images/person_dp_placeholder.png`;" alt="DP Image">' +
					'  <div class="direct-chat-text">' +
					'    '+chat.message+
					'  </div>' +
					'</div>');
			}
		});

		$('[data-toggle="tooltip"]').tooltip();
	});
}

// Each time user sends a message
function sendHostChatMessage()
{

	if ($('#hostChatNewMessage').val() == '')
	{
		toastr.warning("You haven't entered any message");
		return false;
	}

	$('#hostChatNewMessage').attr('disabled', 'disabled');
	$('#sendHostChatBtn').attr('disabled', 'disabled');

	let chat =
		{
			'session_id' : session_id,
			'from_id' : user_id,
			'host_id' : user_id,
			'host_name' : user_name,
			'host_photo' : user_photo,
			'message' : $('#hostChatNewMessage').val(),
			'date_time' : moment().tz(project_timezone).format('YYYY-MM-DD kk:mm:ss')
		};

	$.post(controllerPath+"/sessions/sendHostChat", chat,
		function (response)
		{
			response = JSON.parse(response);
			if (response.status == 'success')
			{
				socket.emit('ycl_host_chat', chat);

				$('#hostChatNewMessage').val('');

				$('#hostChatDiv').prepend('' +
					'<div class="direct-chat-msg right">' +
					'  <div class="direct-chat-infos clearfix">' +
					'    <span class="direct-chat-name float-right">'+chat.host_name+'</span>' +
					'    <span class="direct-chat-timestamp float-left" data-toggle="tooltip" title="'+moment.tz(chat.date_time, project_timezone).format("D MMMM h:mmA")+'">'+moment.tz(chat.date_time, project_timezone).fromNow()+'</span>' +
					'  </div>' +
					'  <img class="direct-chat-img" src="'+ycl_root+'/cms_uploads/projects/'+project_id+'/user_assets/user_photos/'+chat.host_photo+'" onerror="this.onerror=null;this.src=`'+ycl_root+'/ycl_assets/images/person_dp_placeholder.png`;" alt="DP Image">' +
					'  <div class="direct-chat-text">' +
					'  '+chat.message+
					'  </div>' +
					'</div>');

			}else{
				toastr.error('Unable to send the message!');
			}

			$('#hostChatNewMessage').removeAttr('disabled');
			$('#sendHostChatBtn').removeAttr('disabled');

		}).fail(function (error) {
			toastr.error('Network Error!');
			$('#hostChatNewMessage').removeAttr('disabled');
			$('#sendHostChatBtn').removeAttr('disabled');
	});
}


// Each time when someone else from this Host Chat sends a text
function receiveHostChatMessage(chat)
{
	if (chat.host_id == user_id)
	{
		$('#hostChatDiv').prepend('' +
			'<div class="direct-chat-msg right">' +
			'  <div class="direct-chat-infos clearfix">' +
			'    <span class="direct-chat-name float-right">'+chat.host_name+'</span>' +
			'    <span class="direct-chat-timestamp float-left" data-toggle="tooltip" title="'+moment.tz(chat.date_time, project_timezone).format("D MMMM h:mmA")+'">'+moment.tz(chat.date_time, project_timezone).fromNow()+'</span>' +
			'  </div>' +
			'  <img class="direct-chat-img" src="'+ycl_root+'/cms_uploads/projects/'+project_id+'/user_assets/user_photos/'+chat.host_photo+'" onerror="this.onerror=null;this.src=`'+ycl_root+'/ycl_assets/images/person_dp_placeholder.png`;" alt="DP Image">' +
			'  <div class="direct-chat-text">' +
			'  '+chat.message+
			'  </div>' +
			'</div>');
	}else{
		$('#hostChatDiv').prepend('' +
			'<div class="direct-chat-msg">' +
			'  <div class="direct-chat-infos clearfix">' +
			'   <span class="direct-chat-name float-left">'+chat.host_name+'</span>' +
			'   <span class="direct-chat-timestamp float-right" data-toggle="tooltip" title="'+moment.tz(chat.date_time, project_timezone).format("D MMMM h:mmA")+'">'+moment.tz(chat.date_time, project_timezone).fromNow()+'</span>' +
			'  </div>' +
			'  <img class="direct-chat-img" src="'+ycl_root+'/cms_uploads/projects/'+project_id+'/user_assets/user_photos/'+chat.host_photo+'" onerror="this.onerror=null;this.src=`'+ycl_root+'/ycl_assets/images/person_dp_placeholder.png`;" alt="DP Image">' +
			'  <div class="direct-chat-text">' +
			'    '+chat.message+
			'  </div>' +
			'</div>');
	}
}
