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
		class="main-footer"
		<?=($ci_controller == 'sessions' && $ci_method == 'view')?'style="margin-left: unset !important;"':''?>
>
	<strong>Copyright &copy; 2021 <a href="https://yourconference.live">Your Conference Live</a>. </strong>
	All rights reserved.
<!--	<div class="float-right d-none d-sm-inline-block">-->
<!--		<b>Version</b> 3.1.0-->
<!--	</div>-->
</footer>
</div>
<!-- ./wrapper -->

<script src="<?= ycl_base_url ?>/ycl_assets/js/translater.js"></script>

<!-- Lang-Translate Version 3 -->
<script>
    const userType= "admin";
    const baseUrl = "<?=$this->project_url?>/" + userType + "/";
   
    $(document).ready(function() {

        const currentUrl = "<?= current_url() ?>";
        const projUrl = "<?= $this->project_url?>";

        // Used on logged in, if the url is for login => dont translate
        if(currentUrl != projUrl)
        {
            initializeLanguageSettings();
        }


        // Reinitialize the language when sorting table
        $('table thead th').on('click', function() {
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
                await updatePageLanguage(language);
                await updateUserLanguage(language);
                await closeSwal();
            })();
            
        });
    });
    

</script>

</body>
</html>


