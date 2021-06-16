$(function () {

	$('.call-admin').on('click', function () {
		callAdmin($(this).attr('admin-id'), $(this).attr('admin-name'));
	});
});

function callAdmin(adminId, adminName='') {

	if (adminId == user_id)
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
				myVideo.play();
				videoGrid.append(myVideo);
				myVideo.style.height = '100%';
			});

			$('#callingAdminName').text(adminName);
			$('#modal-call-sponsor').modal('show');

			$('#hangUp').on('click', function () {
				myVideo.pause();
				myVideo.src = "";
				console.log(myVideoStream);
				myVideoStream.getVideoTracks()[0].stop();
				$('#modal-call-sponsor').modal('hide');
			});
		});
}
