<style>
    body{
		text-rendering: optimizelegibility;
        margin: 0;
        padding: 0;
        color: #222222;
        font-family: "Open Sans", sans-serif;
        font-size: 16px;
    }
    .parallax {
		  /* Set a specific height or use min-height for responsiveness */
        height: 100%;

        /* Create the parallax scrolling effect */
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: ;
    }
	
</style>

<div class="parallax" style="background-image: url(https://yourconference.live/CCO/front_assets/images/bg_login.png); height: 100vh" >
<div class="container-fluid text-center">
	<?php foreach ($sessions as $session): ?>
					<!-- Session Listing Item -->
					<div class="card mt-3 sessionList" style="width: 100%;" href="<?=$this->project_url?>/mobile/sessions/view/<?=$session->id?>">
						<div style="height:150px; display:flex; align-items:center; margin:auto; text-align:center" >
							<img class="session-img img-fluid" style="margin:auto"
								src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/thumbnails/<?=$session->thumbnail?>"
								onerror="this.src='<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/thumbnails/default'">
						</div>
						<div class="card-body">
							<span><?=date("l, jS F, Y g:iA", strtotime($session->start_date_time))?> - <?=date("g:iA", strtotime($session->end_date_time))?>  <?=$session->time_zone?></span>
							<br><a class="h4 mt-2" href="<?=$this->project_url?>/mobile/sessions/view/<?=$session->id?>"><?=$session->name?></a>
							<p><?=$session->description?></p>
						</div>
					</div>
	<?php endforeach; ?>
</div>

<br><br>
</div>
<script>
	$(function(){
		$('.sessionList').on('click', function(e){
			e.preventDefault();
			window.location.href=$(this).attr('href');
		})
	})
</script>