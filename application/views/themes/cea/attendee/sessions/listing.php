<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/assets/sessions.css?v=<?=rand()?>" rel="stylesheet">

<?php if(isset($view_settings) && !empty($view_settings)):?>
	<?php if($view_settings[0]->session_background_image == 1):?>
		<img id="full-screen-background" style="background-image:<?=$view_settings[0]->session_background_color?>">
	<?php else: ?>
		<img id="full-screen-background" src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/sessions/sessions_listing_background.jpg">
<?php endif;?>
	<?php else:?>
	<img id="full-screen-background" src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/sessions/sessions_listing_background.jpg">
<?php endif;?>

<div class="clearfix" style="margin-bottom: 7rem;"></div>
<div class="sessions-container container-fluid pl-md-6 pr-md-6">
	<div class="col-12">
		<div class="row">
			<div class="col-md-12">
<!--				<div class="text-center btn card mb-5" style="height: 80px;color:#212529;"><h1>Agenda</h1></div>-->
			</div>
		</div>
		<!-- Date tabs -->
<!--		--><?php //print_r($all_sessions_week)?>
		<?php if(isset($all_sessions_week)): ?>
		<div>
			<div class="row mb-5">

				<?php foreach ($all_sessions_week as $session_day ): ?>
					<div class="col-md-3">
						<a href="<?=$this->project_url?>/sessions/day/<?=(date('Y-m-d', strtotime($session_day->start_date_time)))?>" style="text-decoration: none">
							<div class="card">
								<?php $current_date = $this->uri->segment(4)?>
								<?php if ($current_date == (date('Y-m-d', strtotime($session_day->start_date_time)))):?>
								<div class="card-body p-0 pt-4 text-dark text-center rounded" style="height: 130px; background-color: #F78E1E">
									<?php else:?>
									<div class="card-body p-0 pt-4 text-center bg-light" style="height: 130px;color:#212529;">
										<?php endif;?>
										<h3><?= date('l', strtotime($session_day->start_date_time))?><br> <?= date('F d Y', strtotime($session_day->start_date_time)) ?></h3>
									</div>
								</div>
						</a>
					</div>
				<?php endforeach; ?>
			</div>
			<!--	End	Date tabs -->
	<?php
	/*		$session_ids 	= array();
			$track_ids 		= array();
			$keynote_ids 	= array();
			$presenter_ids 	= array();
			$keyword = '';

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
			echo form_open($this->project_url.'/sessions/day', $options);*/?><!--
			<div class="form-row">
				<div class="col-md-3 my-1">
					<label for="date" class="sr-only">Date</label>
					<select id="date" name="date" class="form-control">
						<option value="<?/*=date('Y-m-d')*/?>">Filter by Date</option>
						<?php /*foreach ($sessions as $session ):*/?>
							<option value="<?/*= date('Y-m-d', strtotime ($session->start_date_time)) */?>"<?php /*echo (($current_date == date('Y-m-d', strtotime($session->start_date_time))) ? ' selected' : '' );*/?>><?/*= date('l F d Y', strtotime($session->start_date_time))*/?></option>
						<?php /*endforeach; */?>
					</select>
				</div>
				<div class="col-md-2 my-1">
					<label for="track" class="sr-only">Tracks</label>
					<select id="track" name="track" class="form-control">
						<option value="">Filter By Tracks</option>
	<?php
	/*			foreach ($tracks as $row):
					if (in_array($row->id, $track_ids)):*/?>
						<option value="<?php /*echo $row->id*/?>"<?php /*echo (($row->id == $track_id) ? ' selected' : '' );*/?>><?php /*echo $row->name;*/?></option>
	<?php
	/*				endif;
				endforeach;*/?>
					</select>
				</div>

				<div class="col-md-2 my-1">
					<label for="keynote" class="sr-only">Keynotes</label>
					<select id="keynote" name="keynote" class="form-control">
						<option value="">Filter By Keynote</option>
	<?php
	/*			foreach ($keynote_speakers as $row):
					if (in_array($row->id, $keynote_ids)):*/?>
						<option value="<?php /*echo $row->id*/?>"<?php /*echo (($row->id == $keynote_id) ? ' selected' : '' );*/?>><?/*= $row->name." ".$row->surname.(!empty($row->credentials)?' '.$row->credentials:'')*/?></option>
	<?php
	/*				endif;
				endforeach;*/?>
					</select>
				</div>

				<div class="col-md-2 my-1">
					<label for="speaker" class="sr-only">Speakers</label>
					<select id="speaker" name="speaker" class="form-control">
						<option value="">Filter By Speakers</option>
	<?php
	/*			foreach ($speakers as $row):
					if (in_array($row->id, $presenter_ids)):*/?>
						<option value="<?php /*echo $row->id*/?>"<?php /*echo (($row->id == $speaker_id) ? ' selected' : '' );*/?>><?/*= $row->name." ".$row->surname.(!empty($row->credentials)?' '.$row->credentials:'')*/?></option>
	<?php
	/*				endif;
				endforeach;*/?>
					</select>
				</div>

				<div class="col-md-2 my-1">
					<label for="keyword" class="sr-only">Keyword</label>
					<input type="text" class="form-control" id="keyword" name="keyword" value="<?php /*echo $keyword;*/?>" placeholder="Search">
				</div>
				<div class="col-auto my-1">
					<button type="button" class="btn btn-info">Search</button>
				</div>
			</div>
			<div class="clearfix"></div>
	--><?php
	/*		echo form_close();*/?>

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
										<span><?=date("l, jS F, Y g:iA", strtotime($session->start_date_time))?> - <?=date("g:iA", strtotime($session->end_date_time))?>  <?=$session->time_zone?></span>
									</div>
									<?php if(isset($session->session_track)):?>
								<!--	<div class="col-4 text-right float-right p-0 ">
										<span class="badge badge-pill badge-primary pull-right"><?php /*echo $session->session_track;*/?></span>
									</div>-->
									<div class="clearfix"></div>
									<h3 class="p-0 m-0 mt-1 mb-1"><a href="<?php echo (($session->session_track != 'Exhibit Hall' && $session->video_url == '') ? $this->project_url.'/sessions/join/'.$session->id : (($session->video_url != '') ? $this->project_url.'/sessions/view/'.$session->id : 'javascript:;' ) );?>" class="p-0 mt-1" style="color:#F78E1E; font-weight:800"><?=$session->name?></a></h3>
									<h3 class="p-0 m-0 mt-1 mb-1"><a href="<?php echo (($session->session_track != 'Exhibit Hall' && $session->video_url == '') ? $this->project_url.'/sessions/join/'.$session->id : (($session->video_url != '') ? $this->project_url.'/sessions/view/'.$session->id : 'javascript:;' ) );?>" class="" style="color:#212529;"><?=$session->other_language_name?></a></h3>
									<?php endif;?>
									<p>
										<?php /*if($session->moderators != new stdClass()):*/?><!--
										<span><strong>Moderator:</strong></span>
										<?php /*foreach ($session->moderators as $index=> $moderator):*/?>
										<?/*=(isset($index) && ($index >= 1))?',':''*/?>
										<?/*=$moderator->name." ".$moderator->surname.(!empty($moderator->credentials)?' '.$moderator->credentials:'')*/?>
										<?php /*endforeach; */?><br>
										<?php /*endif;*/?>

										<?php /*if($session->keynote_speakers != new stdClass()):*/?>
										<span><strong>Keynote:</strong></span>
										<?php /*foreach ($session->keynote_speakers as $index=> $keynote):*/?>
										<?/*=(isset($index) && ($index >= 1))?',':''*/?>
										<a style="cursor: pointer" class="keynote-link" keynote-id="<?/*=$keynote->id*/?>" keynote-photo="<?/*=$keynote->photo*/?>" speaker-name="<?/*= $keynote->name." ".$keynote->surname.(!empty($keynote->credentials)?' '.$keynote->credentials:'')*/?>">
											<?/*=$keynote->name." ".$keynote->surname.(!empty($keynote->credentials)?' '.$keynote->credentials:'')*/?>
										</a>
										<bio style="display: none;" session-id="<?/*=$keynote->id*/?>"><?/*=$keynote->bio*/?></bio>
										<disclosure style="display: none;" session-id="<?/*=$keynote->id*/?>"><?/*=$keynote->disclosures*/?></disclosure>
										<?php /*endforeach; */?><br>
										--><?php /*endif; */?>
										<?php if($session->presenters != new stdClass()):?>
											<!--<span><strong>Speakers:</strong></span>-->
	<?php
											foreach ($session->presenters as $index=>$presenter):
												echo trim($presenter->name)." ".trim($presenter->surname).(!empty(trim($presenter->credentials)) ?' '.trim($presenter->credentials):'');
												echo '<br>';
											endforeach;?><br>
										<?php endif; ?>
									</p>
									<hr>
									<p><?=$session->description?></p>
								</div>

								<div class="col-12 text-md-right text-sm-center" style="position: relative;bottom: 0;">
<!--	<?php
/*									if (isset($session->session_track) &&  $session->session_track != 'Exhibit Hall'):*/?>
									<a class="btn btn-sm btn-primary m-1 rounded-0 agenda-btn" session-id ="<?/*=$session->id*/?>" session-title ="<?/*=$session->name*/?>" ><i class="fas fa-clipboard-list"></i> Agenda</a>
	<?php
/*									endif;*/?>
									<a class="btn btn-sm btn-success m-1 rounded-0<?php /*echo (($session->briefcase != new stdClass()) ? ' disabled not-allowed' : ' briefcase-btn' );*/?>" data-session-id ="<?/*=$session->id*/?>" data-session-title ="<?/*=$session->name*/?>"><i class="fas fa-calendar-check"></i> <?php /*echo (($session->briefcase != new stdClass()) ? 'Already in the Briefcase' : 'Add to Briefcase' );*/?></a>
	--><?php
									if (isset($session->session_track) &&  $session->session_track != 'Exhibit Hall'):
										if ($session->end_date_time < date('Y-m-d H:i:s') && $session->video_url == ''):?>
											<a href="<?=$this->project_url?>/sessions/join/<?=$session->id?>" class="btn btn-sm btn-secondary m-1 rounded-0 disabled"><i class="far fa-play-circle"></i> Recording Coming Soon</a>
	<?php
										elseif ($session->video_url != ''):?>
											<a href="<?=$this->project_url?>/sessions/view/<?=$session->id?>" class="btn btn-sm btn-warning m-1 rounded-0"><i class="fas fa-search"></i> View Recording</a>
	<?php
										else:?>
											<a href="<?=$this->project_url?>/sessions/join/<?=$session->id?>" class="btn m-1 rounded-0 " style="background-color: #F78E1E"><!--<i class="fas fa-plus"></i>--> Attend</a>
	<?php
										endif;
									endif;?>
								</div>
								<agenda style="display: none;" session-id="<?=$session->id?>"><?=$session->agenda?></agenda>

							</div>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
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
			</div>
			<div class="modal-body" style="height: 80vh;">
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

	$('.briefcase-btn').on('click', function() {

		const translationData = fetchAllText(); // Fetch the translation data

        translationData.then((arrData) => {
            const selectedLanguage = $('#languageSelect').val(); // Get the selected language

            // Find the translations for the dialog text
            let dialogTitle = 'Please Wait';
            let dialogText = 'Adding to your briefcase...';
			let imageAltText = 'Loading...';

			// Toast
			let addedText = "Added successfully.";

            for (let i = 0; i < arrData.length; i++) {
                if (arrData[i].english_text === dialogTitle) {
                    dialogTitle = arrData[i][selectedLanguage + '_text'];
                }
                if (arrData[i].english_text === dialogText) {
                    dialogText = arrData[i][selectedLanguage + '_text'];
                }
				if (arrData[i].english_text === imageAltText) {
                    imageAltText = arrData[i][selectedLanguage + '_text'];
                }

				if (arrData[i].english_text === addedText) {
                    addedText = arrData[i][selectedLanguage + '_text'];
                }
            }
			Swal.fire({
				title: dialogTitle,
				text: dialogText,
				imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
				imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
				imageAlt: imageAltText,
				showCancelButton: false,
				showConfirmButton: false,
				allowOutsideClick: false
			});
	
			var buttonElement = $(this);
	
			$.ajax({type: "POST",
					url: project_url+"/briefcase/add",
					data: {'session_id' : $(this).data('session-id')},
					error: function(jqXHR, textStatus, errorMessage)
					{
						Swal.close();
						toastr.error(errorMessage);
						//console.log(errorMessage); // Optional
					},
					success: function(response){
						$(buttonElement).addClass('disabled not-allowed').removeClass('briefcase-btn').html('<i class="fas fa-calendar-check"></i> Added in Briefcase');
						Swal.close();
						toastr.success(addedText);
					}
			});
        });

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

		const translationData = fetchAllText(); // Fetch the translation data

        translationData.then((arrData) => {
            const selectedLanguage = $('#languageSelect').val(); // Get the selected language

            // Find the translations for the dialog text
            let dialogTitle = 'Please Wait';
            let dialogText = 'Loading Sessions...';
			let imageAltText = 'Loading...';

            for (let i = 0; i < arrData.length; i++) {
                if (arrData[i].english_text === dialogTitle) {
                    dialogTitle = arrData[i][selectedLanguage + '_text'];
                }
                if (arrData[i].english_text === dialogText) {
                    dialogText = arrData[i][selectedLanguage + '_text'];
                }
				if (arrData[i].english_text === imageAltText) {
					imageAltText = arrData[i][selectedLanguage + '_text'];
				}
                
            }
			Swal.fire({
				title: dialogTitle,
				text: dialogText,
				imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
				imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
				imageAlt: imageAltText,
				showCancelButton: false,
				showConfirmButton: false,
				allowOutsideClick: false
			});
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
