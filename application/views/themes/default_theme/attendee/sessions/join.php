<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/css/sessions.css?v=<?=rand()?>" rel="stylesheet">

<div id="full-screen-background" class="sessions-join"></div>

<div class="clearfix" style="margin-bottom: 7rem;"></div>
<div class="sessions-join-container container-fluid pl-md-6 pr-md-6">
	<div class="col-12">
		<div class="session-join-title p-3">
			This is a long session title, This is a long session title
		</div>
		<div class="session-join-info p-1 pb-3">
			<div class="row mt-2 ml-1">
				<div class="col-8 border-right border-dark">
					<div class="row">
						<div class="col-4">
							<img class="session-img img-fluid"
								 src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/thumbnails/1?v2"
								 onerror="this.src='<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/thumbnails/default'">
						</div>
						<div class="col-8">
							<div>
								<small>Thursday 24 June, 2021  10PM</small>
								<h4>This is a long session title, This is a long session title</h4>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. An eiusdem modi? Nunc vides, quid faciat. Utilitatis causa amicitia est quaesita. Duo Reges: constructio interrete. Sint ista Graecorum.</p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-4">

				</div>
			</div>
			<div class="row mt-5">
				<div class="col-12 text-center">
					<div class="container border border-dark">
						<div class="row">
							<div class="col-12 pt-5 pb-5">
								<p>You will automatically enter the session 15 minutes before it is due to begin.</p>
								<p>Entry will be enabled in 2 hours, 30 minutes</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
