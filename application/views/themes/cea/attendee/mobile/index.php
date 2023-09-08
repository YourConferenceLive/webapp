<style>
    body{
        text-rendering: optimizelegibility;
        margin-top: 0;
        color: #222222;
        font-family: "Open Sans", sans-serif;
        font-size: 16px;
    }
    .parallax {
        /* Set a specific height */
        min-height: 500px;

        /* Create the parallax scrolling effect */
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>

<?php //echo"<pre>"; print_r($sessions[0]->presenter);exit;
//print_r($sess_data);exit;
?>
<section class="parallax" style="background-image: url(https://yourconference.live/CCO/front_assets/images/bg_login.png); top: 0; padding-top: 0; height: 100vh" >
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12" style="margin-top: 100px; margin-left: 20px; margin-right: 20px;">
                <div class="card m-auto text-center">
                    <div class="row">
                        <div class="col-sm-12" style="margin: 30px 0px" >
                            <h6 style="color:#EF5D21">Welcome to the</h6>
                            <h4  style="color:#EF5D21"><b><?=$this->project->name?></b> Learner Resource App</b></h4>
                            <div style="height: 1px;background-color: #EF5D21;" class="my-3"></div>
                            <div class="mx-3">
                            <?php if(isset($sess_data) && !empty($sess_data)): ?>

                            <b><p id="sessionTitle"><?=$sess_data->name?></b>

                            <?php if(isset($sess_data->presenters) && !empty($sess_data->presenters)) :
                                foreach ($sess_data->presenters as $presenter): 
                                if(!in_array($presenter->email, array('q@a.com', 'q@a2.com'))):?>
                           <p id="moderators" style="line-height: 0">
                            <?=$presenter->name.' '.$presenter->surname.', '.$presenter->credentials?>
                           </p>
                                <?php endif; endforeach;?>
                            <?php endif;?>
                            <?php endif; ?>
                            </div>
                            <div style="height: 2px;background-color: #EF5D21;" class="mb-5"></div>
                            <p style="" class="ms-2"> Signing in will allow you to  participate in <br> polling, access resources and other valuable <br>features available in this session.</p>
<!--                            <a href="--><?//=base_url().'mobile/register'?><!--" class="btn btn-sm text-white" style="background-color:#EF5D21">Create a new user</a>-->
                            <br><br>
                            <label style="">
                                Already have account ?
                                <a href="<?= $this->project_url.'/mobile/login/id/'.$sess_data->id?>" class="" style="color:#EF5D21;"> Login</a>
                            </label>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    $(document).ready(function () {
        $("#btn_login").on("click", function () {
            if ($("#email").val().trim() == "") {
                $("#erroremail").text("Please Enter Email").fadeIn('slow').fadeOut(5000);

                return false;
            } else if ($("#password").val() == "") {
                $("#errorpassword").text("Please Enter Password").fadeIn('slow').fadeOut(5000);
                return false;
            } else {
                return true; //submit form
            }
            return false; //Prevent form to submitting
        });

    });

</script>
