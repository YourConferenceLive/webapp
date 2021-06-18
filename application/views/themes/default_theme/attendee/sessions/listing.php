<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/css/sessions.css?v=<?=rand()?>" rel="stylesheet">

<img id="full-screen-background" src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/sessions/sessions_listing_background.jpg">
<div class="clearfix" style="margin-bottom: 7rem;"></div>
<div class="sessions-container container-fluid pl-md-6 pr-md-6">
	<div class="col-12">
		<div class="row">
			<div class="col-md-12">
				<div class="text-center btn card mb-5" style="height: 80px;color:#487391;"><h1>Agenda</h1></div>
			</div>
		</div>
<!--		Date tabs -->
		<div class="row mb-5">
			<div class="col-md-3">
				<a href="<?=$this->project_url?>/sessions/day/2021-06-24" style="text-decoration: none">
					<div class="card">
						<?php $current_date = $this->uri->segment(4)  ?>
						<?php if ($current_date == '2021-06-24'):?>
						<div class="card-body p-0 pt-4 text-white text-center rounded" style="height: 130px; background-color: #487391">
							<?php else:?>
							<div class="card-body p-0 pt-4 text-center bg-light" style="height: 130px;color:#487391;">
								<?php endif;?>
								<h3>Thursday <br> June 24, 2021</h3>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-3">
				<a href="<?=$this->project_url?>/sessions/day/2021-06-25" style="text-decoration: none">
					<div class="card">
						<?php $current_date = $this->uri->segment(4)  ?>
						<?php if ($current_date == '2021-06-25'):?>
						<div class="card-body p-0 pt-4 text-white text-center rounded" style="height: 130px; background-color: #487391">
							<?php else:?>
							<div class="card-body p-0 pt-4 text-center bg-light" style="height: 130px;color:#487391;">
								<?php endif;?>
								<h3>Friday <br> June 25, 2021</h3>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-3">
				<a href="<?=$this->project_url?>/sessions/day/2021-06-26" style="text-decoration: none">
					<div class="card">
						<?php $current_date = $this->uri->segment(4)  ?>
						<?php if ($current_date == '2021-06-26'):?>
						<div class="card-body p-0 pt-4 text-white text-center rounded" style="height: 130px; background-color: #487391">
							<?php else:?>
							<div class="card-body p-0 pt-4 text-center bg-light" style="height: 130px;color:#487391;">
								<?php endif;?>
								<h3>Saturday <br> June 26, 2021</h3>
						</div>
					</div>
				</a>
			</div>
			<div class="col-md-3">
				<a href="<?=$this->project_url?>/sessions/day/2021-06-27" style="text-decoration: none">
					<div class="card">
						<?php $current_date = $this->uri->segment(4)  ?>
						<?php if ($current_date == '2021-06-27'):?>
						<div class="card-body p-0 pt-4 text-white text-center rounded" style="height: 130px; background-color: #487391">
							<?php else:?>
							<div class="card-body p-0 pt-4 text-center bg-light" style="height: 130px;color:#487391;">
								<?php endif;?>
								<h3>Sunday <br> June 27, 2021</h3>
						</div>
					</div>
				</a>
			</div>
		</div>
		<!--	End	Date tabs -->
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
								<a href="<?=$this->project_url?>/sessions/join/<?=$session->id?>" class="" style="color: #1ab6cf "><h4><?=$session->other_language_name?></h4></a>
								<p>

									<?php if($session->moderators != new stdClass()):?>
									<span>Moderator:</span>
									<?php foreach ($session->moderators as $index=> $moderator):?>
										<?=(isset($index) && ($index >= 1))?',':''?>
										<?=$moderator->name." ".$moderator->surname.(!empty($moderator->credentials)?' '.$moderator->credentials:'')?>
									<?php endforeach; ?><br>
									<?php endif;?>

									<?php if($session->keynote_speakers != new stdClass()):?>
									<span>Keynote:</span>
									<?php foreach ($session->keynote_speakers as $index=> $keynote):?>
										<?=(isset($index) && ($index >= 1))?',':''?>
										<a style="cursor: pointer" class="keynote-link" keynote-id="<?=$keynote->id?>" speaker-name="<?= $keynote->name." ".$keynote->surname.(!empty($keynote->credentials)?' '.$keynote->credentials:'')?>">
											<?=$keynote->name." ".$keynote->surname.(!empty($keynote->credentials)?' '.$keynote->credentials:'')?>
										</a>
											<bio style="display: none;" session-id="<?=$keynote->id?>"><?=$keynote->bio?></bio>
											<disclosure style="display: none;" session-id="<?=$keynote->id?>"><?=$keynote->disclosures?></disclosure>
									<?php endforeach; ?><br>
									<?php endif; ?>

									<?php if($session->presenters != new stdClass()):?>
									<span>Speakers:</span>
									<?php foreach ($session->presenters as $index=> $presenter):?>
										<?=(isset($index) && ($index >=1))?",":''?>
										<?=$presenter->name." ".$presenter->surname.(!empty($presenter->credentials)?' '.$presenter->credentials:'')?>
									<?php endforeach;?><br>
									<?php endif; ?>
								</p>
								<hr>
								<p><?=$session->description?></p>
							</div>

							<div class="col-12 text-md-right text-sm-center" style="position: relative;bottom: 0;">
								<a class="agenda-btn btn btn-sm btn-primary m-1 rounded-0" session-id ="<?=$session->id?>" session-title ="<?=$session->name?>" ><i class="fas fa-clipboard-list"></i> Agenda</a>
								<a class="btn btn-sm btn-info m-1 rounded-0"><i class="fas fa-calendar-check"></i> Add to Briefcase</a>
								<a href="<?=$this->project_url?>/sessions/join/<?=$session->id?>" class="btn btn-sm btn-success m-1 rounded-0"><i class="fas fa-plus"></i> Join</a>
							</div>
							<agenda style="display: none;" session-id="<?=$session->id?>"><?=$session->agenda?></agenda>

						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
<!-- Agenda Modal  -->
<div class="modal fade" id="agenda-modal" tabindex="-1" aria-labelledby="agenda-modal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title" id="agenda-modal-label ">
					<h4 class="fas fa-clipboard-list " style="color:#487391"> Agenda</h4>
					<h5 id="agenda-modal-session-name" class="ml-4" style="color:#487391">Session Title</h5>
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary " data-dismiss="modal" >Close</button>
			</div>
		</div>
	</div>
</div>

<!-- User Bio Modal -->
<div class="modal fade" id="speaker-modal" tabindex="-1" aria-labelledby="speaker-modal" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title" id="bio-modal-label ">
					<h3 id="speaker-modal-speaker-name" class="ml-4" style="color:#487391; font-weight: 650">Speaker Name</h3>
				</div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class=" mb-3">
					<span class="bio-body text-left ">

					</span>
				</div>
				<div>
					<span class="disclosure-body text-left">

					</span>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary " data-dismiss="modal" >Close</button>
			</div>
		</div>
	</div>
</div>

<script>
	$(function(){
		$('.agenda-btn').on('click', function(){
			$('#agenda-modal-session-name').text($(this).attr('session-title'));
			$("#agenda-modal .modal-body").html($("agenda[session-id="+$(this).attr('session-id')+"]").html());
			$('#agenda-modal').modal('show');
		})

		$('.keynote-link').on('click', function (){
			if($("bio[session-id="+$(this).attr('keynote-id')+"]").html() !== ''){
				$("#speaker-modal .modal-body .bio-body").html('<h5 class="text-center">Biography:</h5>' + $("bio[session-id="+$(this).attr('keynote-id')+"]").html());
			}else{
				$("#speaker-modal .modal-body .bio-body").html('');
			}
			if($("disclosure[session-id="+$(this).attr('keynote-id')+"]").html() !== '') {
				$("#speaker-modal .modal-body .disclosure-body").html('<h5 class="text-center">Disclosures:</h5>' + $("disclosure[session-id=" + $(this).attr('keynote-id') + "]").html());
			}else{
				$("#speaker-modal .modal-body .disclosure-body").html('');
			}
			$('#speaker-modal-speaker-name').text($(this).attr('speaker-name'));
			$("#speaker-modal ").modal('show');
		})
	});
</script>
