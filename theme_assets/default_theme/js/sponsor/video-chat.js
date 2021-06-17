$(function () {

	$('.video-call').on('click', function () {
		callUser($(this).attr('user-id'), $(this).attr('user-name'));
	});
});

function callUser(userId, userName='') {

	if (userId == user_id)
	{
		toastr.warning("You can't call yourself");
		return false;
	}

	let myVideoStream;
	const videoGrid = document.getElementById("myVideo");
	const myVideo = document.createElement("video");
	myVideo.muted = true;
	navigator.mediaDevices.getUserMedia({
		audio: true,
		video: true,
	})
		.then((stream) => {
			myVideoStream = stream;

			myVideo.srcObject = stream;
			myVideo.addEventListener("loadedmetadata", () => {
				videoGrid.innerHTML = '';
				myVideo.play();
				videoGrid.append(myVideo);
				myVideo.style.height = '100%';
			});

			$('#callingUserName').text(userName);
			$('#modal-call-sponsor').modal('show');

			$('#hangUp').on('click', function () {

				myVideo.pause();
				myVideo.src = "";
				myVideoStream.getVideoTracks()[0].stop();
				$('#modal-call-sponsor').modal('hide');
			});
		});
}
