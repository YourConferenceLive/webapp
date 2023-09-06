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


<script>

    $(document).ready(function() {

        $('table thead th').on('click', function() {
            initializeLanguageSettings();
        });

        $('#languageSelect').on("change", function() {
            // Swal Loading
            disableUserInput();

            const languageSelect = document.getElementById("languageSelect");
            let language = languageSelect.value;

            (async () => {
                await updateUserLanguage(language);
                await updatePageLanguage(language);
                await closeSwal();
            })();
            
        });
    });
    

</script>

</body>
</html>


