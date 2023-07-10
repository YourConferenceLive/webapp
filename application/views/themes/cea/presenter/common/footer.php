<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$ci_controller = $this->router->fetch_class();
$ci_method = $this->router->fetch_method();
?>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
	<!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<!-- Main Footer -->
<footer
	class="main-footer bg-transparent border-0"
	style="<?=($ci_controller == 'sessions' && $ci_method == 'view')?'margin-left: unset !important':''?>; font-size:11px">
	<span>@ 2023 </span> All rights reserved.
	<div id="attendeesOnline" class="float-right d-none d-sm-inline-block"> <!-- Filled by JS only in sessions/view pages -->

	</div>
</footer>
</div>
<!-- ./wrapper -->

</body>
</html>
<!-- Modal Push Notification -->
<div class="modal fade" id="pushNotificationModal" tabindex="-1" aria-labelledby="pushNotificationModalLabel" aria-hidden="true">
	<input type="hidden" id="push_notification_id" value="">
	<div class="modal-dialog ml-5 shadow" style="position: fixed; bottom:0; max-width:500px; min-width:300px">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title text-info" id="pushNotificationModalTitle"><i class="fas fa-bell"></i> Notification </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="pushNotificationModalBody" style="min-height:100px">
				<div id="pushNotificationMessage" style=" font-size: 16px; font-weight: 600" class="ml-2"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<script>
	$(function(){
		push_notification();
		socket.on('push_notification_change', function(){
			push_notification();
		})
	})

	function push_notification(){

		let push_notification_id = $("#push_notification_id").val();

		$.post('<?=$this->project_url?>/push_notification/getPushNotification/',
			function(response){
				if(response.status === 'success'){
					if (push_notification_id == "0") {
						$("#push_notification_id").val(response.data.id);
					}

					if (push_notification_id != response.data.id && response.data.session_id == null && response.data.project_id == "<?=$this->project->id?>") {
						if (response.data.notify_to == "Presenter" || response.data.notify_to == "All" || response.data.notify_to == null){
							$("#push_notification_id").val(response.data.id);
							$("#pushNotificationMessage").text(response.data.message);
							$('#pushNotificationModal').modal('show');
						}
					}

					if (push_notification_id != response.data.id && response.data.session_id != null  && response.data.project_id == "<?=$this->project->id?>") {
						if (response.data.notify_to == "Presenter" || response.data.notify_to == "All" || response.data.notify_to == null){
							if (typeof session_id !== 'undefined' && session_id == response.data.session_id){
								$("#push_notification_id").val(response.data.id);
								$("#pushNotificationMessage").text(response.data.message);
								$('#pushNotificationModal').modal('show');
							}
						}
					}
				}else{
					$('#pushNotificationModal').modal('hide');
				}

			}, 'json')
	}


	

</script>

<script src="<?= ycl_base_url ?>/ycl_assets/js/translater.js"></script>

<!-- Switch Languange  -->
<!-- Update Version V.3 -->
<!-- Simplified Version -->

<script>
    const userType= "presenter";
    const baseUrl = "<?=$this->project_url?>/" +userType+"/"; // use this as url

    $(document).ready(function() {
        
        // Initialize the language and translate if not english
        initializeLanguageSettings();

        // Reinitialize the language when sorting table
        $('table.dataTable thead th').on('click', function() {
            initializeLanguageSettings();
        });

        // Onchange event for switching language
        const languageSelect = document.getElementById("languageSelect");
        $(languageSelect).on("change", function() {
            Swal.fire({
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                willOpen: () => {
                    Swal.showLoading();
                    Swal.getContainer().style.pointerEvents = 'none'; // Disable user input
                }
            });

            let language = languageSelect.value;
            (async () => {
                console.log("Initializing : " + language);
                await updateUserLanguage(language);
                await updatePageLanguage(language);
                await closeSwal();
            })();

        });


    });

</script>



