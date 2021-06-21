// Free public STUN servers provided by Google.
const iceServers = {
	iceServers: [
		{ urls: 'stun:stun.l.google.com:19302' },
		{ urls: 'stun:stun1.l.google.com:19302' },
		{ urls: 'stun:stun2.l.google.com:19302' },
		{ urls: 'stun:stun3.l.google.com:19302' },
		{ urls: 'stun:stun4.l.google.com:19302' },
	],
}
const mediaConstraints = {
	audio: true,
	video: true,
};
let localStream;
let remoteStream;
let isRoomCreator;
let rtcPeerConnection; // Connection between the local device and the remote peer.
let roomId;
let callingUserName = '';
let callingUserId = 0;
let isEngaged = false;

// DOM elements.
//const roomSelectionContainer = document.getElementById('room-selection-container')
//const roomInput = document.getElementById('room-input')
//const connectButton = document.getElementById('connect-button')

//const videoChatContainer = document.getElementById('videoChatContainer')
//const localVideoComponent = document.getElementById('local-video')
//const remoteVideoComponent = document.getElementById('remote-video')


$(function ()
{
	$('.video-call').on('click', function () {
		//callUser($(this).attr('user-id'), $(this).attr('user-name'));
		callingUserId = $(this).attr('user-id');
		callingUserName = $(this).attr('user-name');
		let roomId = $(this).attr('room-id');

		joinRoom(roomId)

	});

	$('#usersInThisBooth').on('click', '.video-call', function () {
		//callUser($(this).attr('user-id'), $(this).attr('user-name'));
		callingUserId = $(this).attr('user-id');
		callingUserName = $(this).attr('user-name');
		let roomId = $(this).attr('room-id');

		joinRoom(roomId)

	});

});

// BUTTON LISTENER ============================================================
// connectButton.addEventListener('click', () => {
// 	joinRoom(roomInput.value)
// })

// SOCKET EVENT CALLBACKS =====================================================
socket.on('ycl_oto_vc_ring', (data) => {

	console.log(data);
	console.log(current_user_id);

	if (data.toId == current_user_id)
	{
		$('#incomingCallFromUserName').text(data.fromName+' is calling you...');
		$('#modal-call-notification').modal({ backdrop: 'static', keyboard: false });

		$('#acceptVideoCall').on('click', function () {
			callingUserId = data.fromId;
			callingUserName = data.fromName;
			let roomId = data.roomId;

			isEngaged = true;

			$('#modal-call-notification').modal('hide');
			joinRoom(roomId);
		});
	}
});


socket.on('ycl_oto_vc_room_created', async () => {
	console.log('Socket event callback: room_created')

	await setLocalStream(mediaConstraints)
	isRoomCreator = true
})

socket.on('ycl_oto_vc_room_joined', async () => {
	console.log('Socket event callback: room_joined')

	await setLocalStream(mediaConstraints)
	socket.emit('ycl_oto_vc_start_call', roomId)
})

socket.on('ycl_oto_vc_full_room', () => {
	console.log('Socket event callback: full_room')

	alert(callingUserName+' is busy, please try again later')
})

// FUNCTIONS ==================================================================
function joinRoom(room) {
	if (room === '') {
		alert('Please type a room ID')
	} else {
		roomId = room
		socket.emit('ycl_oto_vc_join', {roomId:room, fromId:current_user_id, fromName:current_user_name, toId:callingUserId, toName:callingUserName})
		showVideoConference()
	}
}

function showVideoConference() {
	//roomSelectionContainer.style = 'display: none'
	//videoChatContainer.style = 'display: block'
}

async function setLocalStream(mediaConstraints) {
	let stream
	try {
		stream = await navigator.mediaDevices.getUserMedia(mediaConstraints)
	} catch (error) {
		console.error('Could not get user media', error)
	}

	localStream = stream
	document.getElementById('local-video').srcObject = stream

	$('#callingUserName').text("Connecting"+ callingUserName+'...');
	$('#modal-call-sponsor').modal({ backdrop: 'static', keyboard: false });
}

// SOCKET EVENT CALLBACKS =====================================================
socket.on('ycl_oto_vc_start_call', async () => {
	console.log('Socket event callback: start_call')

	if (isRoomCreator) {
		rtcPeerConnection = new RTCPeerConnection(iceServers)
		addLocalTracks(rtcPeerConnection)
		rtcPeerConnection.ontrack = setRemoteStream
		rtcPeerConnection.onicecandidate = sendIceCandidate
		await createOffer(rtcPeerConnection)
	}
})

socket.on('ycl_oto_vc_webrtc_offer', async (event) => {
	console.log('Socket event callback: webrtc_offer')

	if (!isRoomCreator) {
		rtcPeerConnection = new RTCPeerConnection(iceServers)
		addLocalTracks(rtcPeerConnection)
		rtcPeerConnection.ontrack = setRemoteStream
		rtcPeerConnection.onicecandidate = sendIceCandidate
		rtcPeerConnection.setRemoteDescription(new RTCSessionDescription(event))
		await createAnswer(rtcPeerConnection)
	}
})

socket.on('ycl_oto_vc_webrtc_answer', (event) => {
	console.log('Socket event callback: webrtc_answer')

	rtcPeerConnection.setRemoteDescription(new RTCSessionDescription(event))
})

socket.on('ycl_oto_vc_webrtc_ice_candidate', (event) => {
	console.log('Socket event callback: webrtc_ice_candidate')

	// ICE candidate configuration.
	var candidate = new RTCIceCandidate({
		sdpMLineIndex: event.label,
		candidate: event.candidate,
	})
	rtcPeerConnection.addIceCandidate(candidate)
})

// FUNCTIONS ==================================================================
function addLocalTracks(rtcPeerConnection) {
	localStream.getTracks().forEach((track) => {
		rtcPeerConnection.addTrack(track, localStream)
	})
}

async function createOffer(rtcPeerConnection) {
	let sessionDescription
	try {
		sessionDescription = await rtcPeerConnection.createOffer()
		rtcPeerConnection.setLocalDescription(sessionDescription)
	} catch (error) {
		console.error(error)
	}

	socket.emit('ycl_oto_vc_webrtc_offer', {
		type: 'webrtc_offer',
		sdp: sessionDescription,
		roomId,
	})
}

async function createAnswer(rtcPeerConnection) {
	let sessionDescription
	try {
		sessionDescription = await rtcPeerConnection.createAnswer()
		rtcPeerConnection.setLocalDescription(sessionDescription)
	} catch (error) {
		console.error(error)
	}

	socket.emit('ycl_oto_vc_webrtc_answer', {
		type: 'webrtc_answer',
		sdp: sessionDescription,
		roomId,
	})
}

function setRemoteStream(event) {
	document.getElementById('remote-video').srcObject = event.streams[0]
	remoteStream = event.stream

	$('#callingUserName').text("Connected with "+ callingUserName+'...');
}

function sendIceCandidate(event) {
	if (event.candidate) {
		socket.emit('ycl_oto_vc_webrtc_ice_candidate', {
			roomId,
			label: event.candidate.sdpMLineIndex,
			candidate: event.candidate.candidate,
		})
	}
}
