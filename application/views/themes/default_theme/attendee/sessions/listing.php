<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/css/sessions.css?v=<?=rand()?>" rel="stylesheet">

<img id="full-screen-background" src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/sessions/sessions_listing_background.jpg">

<div class="clearfix" style="margin-bottom: 7rem;"></div>
<div class="sessions-container container-fluid pl-md-6 pr-md-6">
	<div class="col-12">
		<?php foreach ($sessions as $session): ?>
			<!-- Session Listing Item -->
			<div class="sessions-listing-item pb-3">
				<div class="container-fluid">
					<div class="row mt-2">
						<div class="col-md-3 col-sm-12 p-0">
							<div class="session-img-div pl-2 pt-2 pb-2 pr-2 text-center">
								<img class="session-img img-fluid"
									 src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/thumbnails/<?=$session?>"
									 onerror="this.src='<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/thumbnails/default'">
							</div>
						</div>
						<div class="col-md-9 col-sm-12 pl-0 pt-2">
							<div class="col-12 text-md-left text-sm-center">
								<small>Thursday 24 June, 2021  10PM</small>
								<h4>This is a long session title, This is a long session title and This is a long session title</h4>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. An eiusdem modi? Nunc vides, quid faciat. Utilitatis causa amicitia est quaesita. Duo Reges: constructio interrete. Sint ista Graecorum.</p>
							</div>
							<div class="col-12 text-md-right text-sm-center">
								<a class="btn btn-sm btn-info m-1 rounded-0"><i class="fas fa-calendar-check"></i> Export To Calender</a>
								<a href="<?=$this->project_url?>/sessions/join/<?=$session?>" class="btn btn-sm btn-success m-1 rounded-0"><i class="fas fa-plus"></i> JOIN</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>