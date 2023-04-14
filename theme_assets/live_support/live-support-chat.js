let live_support_chat_room = project_name+project_id+"_live_support";
let supportChatStatus = 1;
let isActivelyChatting = false;

$(document).ready(function () {

    if (typeof socket === "undefined") {
        console.log("Socket IO is not loaded!");
        toastr.error("Unable to load live support config");
        return false;
    }

    socket.on("supportChatStatusChange", function (data){

			console.log(data.room);
			if (data.room === live_support_chat_room)
				supportChatStatus = data.status;
			if (data.status == 1) {
				$('.live-support-open-button').show();
				$('#help-desk').hide();
			} else {
				$('.live-support-open-button').hide();
				$('#liveSupportChatForm').hide();
				$('#help-desk').show();
			}


    });

    fillAllPreviousChats();

    /**
     * Send/Type text listeners
     */
    $('#sendLiveSupportText').on('click', function () {
        sendNewText();
    });
    $("#liveSupportText").on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) { // Send the text
            sendNewText();

        }else{ // Typing something
            socket.emit('typingLiveSupportText', {'room':live_support_chat_room, 'fromType':'attendee', 'fromName':attendee_name, 'fromId':attendee_id});
        }
    });


});

function fillAllPreviousChats()
{
    $.get(project_url+"/live_support_chat/allChatsJSON", function (chats) {
        $('#live-support-chat-texts').html('');
        chats = JSON.parse(chats);
        $.each(chats, function(i, chat) {
            if (chat.chat_from_type == 'admin')
            {
                $('#live-support-chat-texts').append(
                    '<span class="live-support-text-admin">\n' +
                    '  <span class="live-support-admin-desc"><i class="fas fa-user-tie"></i> Admin</span><br>\n' +
                    '  <span class="live-support-admin-text">'+chat.text+'</span>\n' +
                    '</span>'
                );
            }else{
                $('#live-support-chat-texts').append(
                    '<span class="live-support-text-attendee">\n' +
                    '  <span class="live-support-attendee-desc">You <i class="fas fa-user"></i></span><br>\n' +
                    '  <span class="live-support-attendee-text">'+chat.text+'</span>\n' +
                    '</span>'
                );
            }
        });
        document.getElementById("live-support-chat-texts").scrollTop = document.getElementById("live-support-chat-texts").scrollHeight;
    }).fail(()=>{
        toastr.error("Error loading live support chat");
    });
}

function sendNewText()
{
    if (!supportChatStatus)
    {
        toastr.warning("Live support chat is turned off by the admin");
        return false;
    }

    let text = $('#liveSupportText').val();
    if (text == '')
    {
        toastr.warning("Please enter your message");
        return false;
    }

    $.post(base_url+"/live_support_chat/newText",
        {
            text:text
        },
        function (response)
        {
        	console.log(response);
            try { $.parseJSON(response);}
            catch(error) { toastr.error("You are not logged-in"); return false; }

            response = JSON.parse(response);
            if (response.status == 'success')
            {
                socket.emit('newLiveSupportText', {'room':live_support_chat_room, 'text':text, 'fromType':'attendee', 'fromName':attendee_name, 'fromId':attendee_id});

                $('#liveSupportText').val('');
                $('#live-support-chat-texts').append(
                    '<span class="live-support-text-attendee ">\n' +
                    '  <span class="live-support-attendee-desc">You <i class="fas fa-user"></i></span><br>\n' +
                    '  <span class="live-support-attendee-text">'+text+'</span>\n' +
                    '</span>'
                );
                document.getElementById("live-support-chat-texts").scrollTop = document.getElementById("live-support-chat-texts").scrollHeight;
            }else{
                toastr.error("Unable to send");
            }

        }).fail(()=>{
            toastr.error("Unable to send");
    });


    /*** Listen for new texts ***/
    socket.on("newLiveSupportText", function (data) {
        if (data.room == live_support_chat_room && data.fromType == "admin" && data.to_id == attendee_id) // Chat is to this user in this app
        {
            $('#live-support-chat-texts').append(
                '<span class="live-support-text-admin">\n' +
                '  <span class="live-support-admin-desc"><i class="fas fa-user-tie"></i> Admin</span><br>\n' +
                '  <span class="live-support-admin-text">'+data.text+'</span>\n' +
                '</span>'
            );
            document.getElementById("live-support-chat-texts").scrollTop = document.getElementById("live-support-chat-texts").scrollHeight;
        }
    });

    /*** Listen for typing ***/
    socket.on("typingLiveSupportText", function (data) {
        if (data.room == live_support_chat_room && data.fromType == "admin" && data.to_id == attendee_id) // Typing for this user in this app
        {
            $('#adminTypingHint').show();
            setTimeout(function () {
                $('#adminTypingHint').hide();
            }, 1000);
        }
    });
}


function openLiveSupportChat() {
    // If not already in the queue, add to the queue
    socket.emit("addMeToLiveSupportQueue", {'room':live_support_chat_room, 'attendeeName':attendee_name, 'attendeeId':attendee_id});
}

socket.on("liveSupportChatStarted", function (data) {
    document.getElementById("liveSupportChatForm").style.display = "block";
    document.getElementById("live-support-chat-texts").scrollTop = document.getElementById("live-support-chat-texts").scrollHeight;
});

socket.on("liveSupportChatOffline", function (data) {
    document.getElementById("liveSupportChatForm").style.display = "none";
    toastr.error("Live support chat is unavailable at this moment");
});

function endLiveSupportChat() {
    Swal.fire({
        title: 'Are you sure?',
        text: "You are about to end this chat",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28A745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
    }).then((result) => {
        if (result.isConfirmed) {
            socket.emit("endLiveSupportChat", {'room':live_support_chat_room, 'by':'attendee', 'id':attendee_id});
            document.getElementById("liveSupportChatForm").style.display = "none";
            toastr.success("Live support chat ended");
        }
    });
}
