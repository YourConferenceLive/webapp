
let admin_chat_presenter_ids=[];

$(function(){

	/**************** Loading admin chats *********************/
	$.post(project_url+"/sessions/getAdminChatsAjax",
		{

			session_id: sessionId,
			sender_id: uid
		}

	).done(function(chats) {
			chats = JSON.parse(chats);
			// console.log(chats.data);
			$('.admin-messages').html('');

			$.each(chats.data, function(index, chat)
			{
				if (chat.sent_from == 'admin' || chat.sent_from == 'presenter'){
					if(chat.sent_from == 'presenter'){
						$('.chat_with_admin_body').append('' +
							'<span class="admin_chat_section btn btn-primary float-left text-left m-1" style="width:90%"><strong style="margin-right: 10px">'+chat.username+' '+chat.surname+'</strong>'+chat.chats+'</span>');
					}else{
						$('.chat_with_admin_body').append('' +
							'<span class="admin_chat_section btn btn-primary float-left text-left m-1" style="width:90%"><strong style="margin-right: 10px">Admin </strong>'+chat.chats+'</span>');
					}
				}else{
					$('.chat_with_admin_body').append('' +
						'<span class="admin_chat_section btn btn-warning float-right text-right m1-1" style="width:90%">'+chat.chats+'</span>');
				}
			});

			$(".chat_with_admin_body").scrollTop($(".chat_with_admin_body")[0].scrollHeight);

		}
	).fail((error)=>{
		toastr.error('Unable to load admin chat.');
	});
	/**************** End of Loading admin chats *********************/


	$('#chat_with_admin_text').on('keyup', function(e){
		if (e.key === 'Enter' || e.keyCode === 13) {
			$('#chat_with_admin_text').prop('disabled', true);

			let chat = $(this).val();

			if (chat == '') {
				toastr.warning('Please enter your message');
				return false;
			}
			$.post(project_url+"/sessions/chatAdminajax",{
					session_id:sessionId,
					chat:chat,
				},
				function (response) {
					response = JSON.parse(response);
					// console.log(response);
					if (response.status == 'success') {
						socket.emit('new-attendee-to-admin-chat', {"session_id":sessionId, "from_id":uid, "user_name":attendee_FullName, "to_id":"admin", "chat_text": chat, "cp_ids":admin_chat_presenter_ids, 'sent_from': 'attendee' });

						$('#chat_with_admin_text').val('');
						$('.chat_with_admin_body').append('' +
							'<span class="admin_chat_section btn btn-warning float-right text-right m-1" style="width:90%">'+chat+'</span>');

						toastr.success("Message sent");
						$(".chat_with_admin_body").scrollTop($(".chat_with_admin_body")[0].scrollHeight);
					} else {
						toastr.error("Unable to send the message");
					}

					$('#chat_with_admin_text').prop('disabled', false);

				}).fail((error)=>{
				toastr.error("Unable to send the message");
				$('#chat_with_admin_text').prop('disabled', false);
			});
		}
	})
})

	socket.on('new-attendee-to-admin-chat-notification', function (data) {
	// console.log(data);

		if ((data.sender_id == uid) || data.sender_id == uid)
		{
			if (data.sender_id == uid)
			{
				// console.log(uid);
				if(data.presenter_name){
					$('.chat_with_admin_body').append('' +
						'<span class="admin_chat_section btn btn-primary float-left text-left m-1" style="width:90%"><strong style="margin-right: 10px">'+data.presenter_name+'</strong>'+data.chat_text+'</span>');
				}else{
					$('.chat_with_admin_body').append('' +
						'<span class="admin_chat_section btn float-right text-right m1-1" style="width:90%"><strong style="margin-right: 10px">'+data.presenter_name+'</strong>'+data.chat_text+'</span>');
				}
				$('#adminChatStickyIcon').show();
				$('#adminChatStickyIcon').click();


				$(".chat_with_admin_body").scrollTop($(".chat_with_admin_body")[0].scrollHeight);

				admin_chat_presenter_ids.push(data.from_id);
				admin_chat_presenter_ids=Array.from(new Set(admin_chat_presenter_ids));
			}
		}

		});



