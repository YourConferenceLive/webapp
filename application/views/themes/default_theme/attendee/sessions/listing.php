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
		<!-- Date tabs -->
		<div class="row mb-5">
			<div class="col-md-3">
				<a href="<?=$this->project_url?>/sessions/day/2021-06-24" style="text-decoration: none">
					<div class="card">
						<?php $current_date = $this->uri->segment(4);?>
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
<?php
						$current_date = $this->uri->segment(4);
						if ($current_date == '2021-06-27'):?>
						<div class="card-body p-0 pt-4 text-center text-white rounded" style="height: 130px; background-color: #487391">
<?php
						else:?>
						<div class="card-body p-0 pt-4 text-center bg-light" style="height: 130px;color:#487391;">
<?php
						endif;?>
							<h3>Sunday <br> June 27, 2021</h3>
						</div>
					</div>
				</a>
			</div>
		</div>
		<!--	End	Date tabs -->
<?php
		$session_ids 	= array();
		$track_ids 		= array();
		$keynote_ids 	= array();
		$presenter_ids 	= array();

		foreach ($sessions as $session):
			$session_ids[] = $session->id;

			if (!in_array($session->track, $track_ids))
				$track_ids[] = $session->track;

			if($session->keynote_speakers != new stdClass()):
				foreach ($session->keynote_speakers as $index=> $keynote):
					if (!in_array($keynote->id, $keynote_ids))
						$keynote_ids[] = $keynote->id;
				endforeach;
			endif;

			if($session->presenters != new stdClass()):
				foreach ($session->presenters as $index=>$presenter):
					if (!in_array($presenter->id, $presenter_ids))
						$presenter_ids[] = $presenter->id;
				endforeach;
			endif;

			if($session->presenters != new stdClass()):
				foreach ($session->presenters as $index=>$presenter):
					if (!in_array($presenter->id, $presenter_ids))
						$presenter_ids[] = $presenter->id;
				endforeach;
			endif;

		endforeach;

		$options = array('method' => 'get', 'id' => 'frm-search');
		echo form_open($this->project_url.'/sessions/day', $options);?>
		<div class="form-row">
    		<div class="col-md-3 my-1">
				<label for="date" class="sr-only">Date</label>
				<select id="date" name="date" class="form-control">
					<option value="2021-06-24"<?php echo (($current_date == '2021-06-24') ? ' selected' : '' );?>>Thursday June 24, 2021</option>
					<option value="2021-06-25"<?php echo (($current_date == '2021-06-25') ? ' selected' : '' );?>>Friday  June 25, 2021</option>
					<option value="2021-06-26"<?php echo (($current_date == '2021-06-26') ? ' selected' : '' );?>>Saturday June 26, 2021</option>
					<option value="2021-06-27"<?php echo (($current_date == '2021-06-27') ? ' selected' : '' );?>>Sunday June 27, 2021</option>
				</select>
			</div>
			<div class="col-md-2 my-1">
				<label for="track" class="sr-only">Tracks</label>
				<select id="track" name="track" class="form-control">
					<option value="">Filter By Tracks</option>
<?php
			foreach ($tracks as $row):
				if (in_array($row->id, $track_ids)):?>
					<option value="<?php echo $row->id?>"<?php echo (($row->id == $track_id) ? ' selected' : '' );?>><?php echo $row->name;?></option>
<?php
				endif;
			endforeach;?>
				</select>
			</div>

    		<div class="col-md-2 my-1">
				<label for="keynote" class="sr-only">Keynotes</label>
				<select id="keynote" name="keynote" class="form-control">
					<option value="">Filter By Keynote</option>
<?php
			foreach ($keynote_speakers as $row):
				if (in_array($row->id, $keynote_ids)):?>
					<option value="<?php echo $row->id?>"<?php echo (($row->id == $keynote_id) ? ' selected' : '' );?>><?= $row->name." ".$row->surname.(!empty($row->credentials)?' '.$row->credentials:'')?></option>
<?php
				endif;
			endforeach;?>
				</select>
			</div>

    		<div class="col-md-2 my-1">
				<label for="speaker" class="sr-only">Speakers</label>
				<select id="speaker" name="speaker" class="form-control">
					<option value="">Filter By Speakers</option>
<?php
			foreach ($speakers as $row):
				if (in_array($row->id, $presenter_ids)):?>
					<option value="<?php echo $row->id?>"<?php echo (($row->id == $speaker_id) ? ' selected' : '' );?>><?= $row->name." ".$row->surname.(!empty($row->credentials)?' '.$row->credentials:'')?></option>
<?php
				endif;
			endforeach;?>
				</select>
			</div>

    		<div class="col-md-2 my-1">
			    <label for="keyword" class="sr-only">Keyword</label>
			    <input type="text" class="form-control" id="keyword" name="keyword" value="<?php echo $keyword;?>" placeholder="Search">
			</div>
    		<div class="col-auto my-1">
			    <button type="button" class="btn btn-info">Search</button>
    		</div>
  		</div>
  		<div class="clearfix"></div>
<?php
		echo form_close();?>

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
								<div class="col-6 text-left float-left p-0">
									<span><?=date("l, jS F, Y g:iA", strtotime($session->start_date_time))?> - <?=date("g:iA", strtotime($session->end_date_time))?> EST</span>  
								</div>
								<div class="col-4 text-right float-right p-0 ">
									<span class="badge badge-pill badge-primary pull-right"><?php echo $session->session_track;?></span>  
								</div>
								<div class="clearfix"></div>
								<h4 class="p-0 m-0 mt-1 mb-1"><a href="<?=$this->project_url?>/sessions/join/<?=$session->id?>" class="p-0 mt-1" style="color:#487391"><?=$session->name?></a></h4>
								<h4 class="p-0 m-0 mt-1 mb-1"><a href="<?=$this->project_url?>/sessions/join/<?=$session->id?>" class="" style="color: #284050;"><?=$session->other_language_name?></a></h4>
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
<?php
										foreach ($session->presenters as $index=>$presenter):
											echo ((isset($index) && ($index>=1))?", ":'').trim($presenter->name)." ".trim($presenter->surname).(!empty(trim($presenter->credentials))?' '.trim($presenter->credentials):'');
										endforeach;?><br>
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
	});

	$("#frm-search").submit(function( event ) {
		event.preventDefault();
		applySearch();
	});

	$('#frm-search select[name="date"], #frm-search select[name="track"], #frm-search select[name="keynote"], #frm-search select[name="speaker"]').change(function() {
		applySearch();
	});

	$('#frm-search input[type="radio"]').change(function() {
		applySearch();
    });

	$('#frm-search button').click(function(){
		applySearch();
	});

    function applySearch() {
		Swal.fire({
			title: 'Please Wait',
			text: 'Loading Sessions...',
			imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
			imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
			imageAlt: 'Loading...',
			showCancelButton: false,
			showConfirmButton: false,
			allowOutsideClick: false
		});

		var date 	= (($('#frm-search select[name="date"]').children("option:selected").val()) ? $('#frm-search select[name="date"]').children("option:selected").val() : 'NaN');
		var track 	= (($('#frm-search select[name="track"]').children("option:selected").val()) ? $('#frm-search select[name="track"]').children("option:selected").val() : 'NaN');
		var keynote	= (($('#frm-search select[name="keynote"]').children("option:selected").val()) ? $('#frm-search select[name="keynote"]').children("option:selected").val() : 'NaN' );
		var speaker	= (($('#frm-search select[name="speaker"]').children("option:selected").val()) ? $('#frm-search select[name="speaker"]').children("option:selected").val() : 'NaN' );
		var keyword = (($('#frm-search input[type="text"]').val()) ? $('#frm-search input[type="text"]').val() : 'NaN' );

		$(location).attr('href', project_url + '/sessions/day/' + date + '/' + track + '/' + keynote + '/' + speaker + '/' + keyword + '/');
    }
});
</script>
