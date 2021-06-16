<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/css/sessions.css?v=<?=rand()?>" rel="stylesheet">

<img id="full-screen-background" src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/sessions/sessions_listing_background.jpg">

<div class="clearfix" style="margin-bottom: 7rem;"></div>
<div class="sessions-container container-fluid pl-md-6 pr-md-6">
	<div class="col-12">
		<div class="row session-week">
			<?php if(isset($sessions_week) && !empty($sessions_week)): ?>
				<?php foreach ($sessions_week as $session_week):?>
					<div class="col-md-3">
						<a href="<?=$this->project_url?>/sessions/getSessions_byDate/<?=date('Y-m-d',strtotime( $session_week->start_date_time))?>">
							<div class="card btn" id="session_date" >
								<?php $current_date = $this->uri->segment(4)  ?>
								<?php if($current_date == ''){
									$current_date = date('Y-m-d', strtotime($sessions_week[0]->start_date_time));
								}?>
								<?php if ($current_date == date('Y-m-d',strtotime( $session_week->start_date_time))):?>
								<div class="card-body p-0 pt-4 bg-info text-white" style="height: 130px;">
									<?php else:?>
									<div class="card-body p-0 pt-4" style="height: 130px">
										<?php endif;?>
										<h3 class="text-center"><?=$session_week->dayname?><br><?= date('M-d-Y', strtotime($session_week->start_date_time))?></h3>
									</div>
								</div>
						</a>
					</div>
				<?php endforeach;?>
			<?php endif;?>
		</div>
		<?php if(isset($sessions) && !empty($sessions)):?>
			<?php foreach ($sessions as $session): ?>
				<!-- Session Listing Item -->
				<div class="sessions-listing-item pb-3">
					<div class="container-fluid">
						<div class="row mt-2">
							<div class="col-md-3 col-sm-12 p-0">
								<div class="session-img-div pl-2 pt-2 pb-2 pr-2 text-center">
									<img class="session-img img-fluid"
										 src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/thumbnails/<?=$session->thumbnail?>"
										 onerror="this.src='<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/sessions/thumbnails/default'">
								</div>
							</div>
							<div class="col-md-9 col-sm-12 pl-0 pt-2">
								<div class="col-12 text-md-left text-sm-center">
									<?=date("l, jS F, Y g:iA", strtotime($session->start_date_time))?> - <?=date("g:iA", strtotime($session->end_date_time))?> EST
									<br>
									<a href="<?=$this->project_url?>/sessions/join/<?=$session->id?>" class="" style="color:#487391"><h4><?=$session->name?></h4></a>
									<a href="<?=$this->project_url?>/sessions/join/<?=$session->id?>" class="" style="color: #8B4513"><h4><?=$session->other_language_name?></h4></a>
									<p>

										<?php foreach ($session->presenters as $index=> $presenter):?>
											<?=(isset($index) && ($index >=1))?', ':''?>
											<?= $presenter->name." ".$presenter->surname.(!empty($presenter->credentials)?', '.$presenter->credentials:'').', Speaker'?>
										<?php endforeach;?>

										<?php foreach ($session->moderators as $index=> $moderator):?>
											<?=(isset($index) && ($index >= 1))?', ':''?>
											<?= $moderator->name." ".$moderator->surname.(!empty($moderator->credentials)?', '.$moderator->credentials:'').', Moderator'?>
										<?php endforeach; ?>

										<?php foreach ($session->keynote_speakers as $index=> $keynote):?>
											<?=(isset($index) && ($index >= 1))?', ':''?>
											<?= $keynote->name." ".$keynote->surname.(!empty($keynote->credentials)?', '.$keynote->credentials:'').', Keynote'?>
										<?php endforeach; ?>
										<!--								todo: need to confirm to shannon the order -->
									</p>
									<p><?=$session->description?></p>
								</div>
								<div class="col-12 text-md-right text-sm-center" style="position: absolute;bottom: 0;">
									<a class="btn btn-sm btn-primary m-1 rounded-0"><i class="fas fa-clipboard-list"></i> Agenda</a>
									<a class="btn btn-sm btn-info m-1 rounded-0"><i class="fas fa-calendar-check"></i> Add to Briefcase</a>
									<a href="<?=$this->project_url?>/sessions/join/<?=$session->id?>" class="btn btn-sm btn-success m-1 rounded-0"><i class="fas fa-plus"></i> Join</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif;?>
	</div>
</div>
