<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/css/eposters.css?v=<?=rand()?>" rel="stylesheet">

<img id="full-screen-background" src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/sessions/sessions_listing_background.jpg">

<div class="clearfix" style="margin-bottom: 7rem;"></div>
<div class="eposters-container container-fluid pl-md-6 pr-md-6">
	<div class="col-12">
		<div class="row">
			<div class="col-md-12">
				<div class="text-center btn card mb-2 page-title"><h1 class="mb-0">ePosters and Surgical Videos</h1></div>
			</div>
		</div>
<?php
		// echo substr(str_replace(array(' ', ' - ', '-', ':', '.', ',', '(', ')', '\'', 'è'), array('_', ''), strtolower('Combined Versus Sequential Phacoemulsification and Pars Plana Vitrectomy, A Meta-Analysis')), 0, 142);
		$options = array('method' => 'get', 'id' => 'frm-search');
		echo form_open($this->project_url.'/eposters/index', $options);?>
		<div class="form-row">
    		<div class="col-md-2 my-1">
				<label for="track" class="sr-only">Tracks</label>
				<select id="track" name="track" class="form-control">
					<option value="">Filter By Tracks</option>
<?php
			foreach ($tracks as $row): ?>
					<option value="<?php echo $row->id?>"<?php echo (($row->id == $track_id) ? ' selected' : '' );?>><?php echo $row->track?></option>
<?php
			endforeach;?>
				</select>
			</div>
    		<div class="col-md-2 my-1">
				<label for="author" class="sr-only">Author</label>
				<select id="author" name="author" class="form-control">
					<option value="">Filter By Author</option>
<?php
			foreach ($authors as $row): ?>
					<option value="<?php echo $row->id?>"<?php echo (($row->id == $author_id) ? ' selected' : '' );?>><?php echo $row->author.(!empty(trim($row->credentials))?' '.trim($row->credentials):'');?></option>
<?php
			endforeach;?>
				</select>
			</div>
    		<div class="col-md-3 pt-2 my-1">
				<div class="form-check form-check-inline">
					<input class="form-check-input" type="radio" name="type" id="eposter" value="eposter"<?php echo (($type == 'eposter') ? ' checked' : '' );?>>
  					<label class="form-check-label" for="eposter">ePoster</label>
				</div>
				<div class="form-check form-check-inline">
  					<input class="form-check-input" type="radio" name="type" id="video" value="surgical_video"<?php echo (($type == 'surgical_video') ? ' checked' : '' );?>>
  					<label class="form-check-label" for="video">Video</label>
				</div>
				<div class="form-check form-check-inline">
  					<input class="form-check-input" type="radio" name="type" id="all" value=""<?php echo (($type == '') ? ' checked' : '' );?>>
  					<label class="form-check-label" for="inlineRadio3">All</label>
				</div>
			</div>
    		<div class="col-md-3 offset-md-1 my-1">
			    <label for="keyword" class="sr-only">Keyword</label>
			    <input type="text" class="form-control" id="keyword" name="keyword" value="<?php echo $keyword;?>" placeholder="Search">
			</div>
    		<div class="col-auto my-1">
			    <button type="button" class="btn btn-info">Search</button>
    		</div>
  		</div>
  		<div class="clearfix"></div>
<?php
		echo form_close();
		if (!count((array)$eposters)) {?>
		<div class="no-eposter-found container-fluid ml-0 text-center">
			<div style="height: 100%; width: 100%; background-image: url('<?=ycl_root?>/ycl_assets/animations/particle_animation.gif');background-repeat: no-repeat;background-size: cover;background-position:center;">
				<div class="middleText">
					<h3>Sorry, no ePoster found!</h3>
				</div>
			</div>
		</div>
<?php
		} else {
			foreach ($eposters as $eposter): 
				$eposter_url = (($eposter->eposter != '') ? $this->project_url.'/eposters/view/'.$eposter->id : '' );?>
		<!-- ePoster Listing Item -->
		<div class="eposters-listing-item pb-3">
			<div class="container-fluid">
				<div class="row mt-2">
					<div class="col-md-3 col-sm-12 p-0">
						<div class="eposter-img-div pl-2 pt-2 pb-2 pr-2 text-center">
<?php
							if ($eposter_url) {?>
							<a href="<?php echo $eposter_url;?>" title="<?=$eposter->title;?>">
<?php
							}?>
							<img class="eposter-img img-fluid"
								 src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/eposters/thumbnails/<?=(($eposter->eposter) ? $eposter->eposter : 'default.jpg' );?>"
								 onerror="this.src='<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/eposters/thumbnails/default.jpg'">
							</a>
						</div>
					</div>
					<div class="col-md-9 col-sm-12 pl-0 pt-2">
						<div class="col-12 text-md-left text-sm-center">
							<div class="col-12 text-md-right text-sm-right p-0 ">
								<span class="badge badge-pill badge-primary"><?php echo $eposter->track;?></span>  
								<span class="badge badge-pill<?php echo (($eposter->type == 'eposter') ? ' badge-success badge-eposter' : ' badge-info' );?>"><?php echo (($eposter->type == 'eposter') ? 'ePoster' : 'Surgical Video' );?></span>
								<div class="clearfix"></div>
							</div>
							<h4>
<?php
							if ($eposter_url) {?>
								<a href="<?=$eposter_url;?>" title="<?=$eposter->title;?>">
<?php
							}
								// echo $eposter->title.'<br>'.$eposter->eposter.'<br>'.$eposter->id.'_'.substr(str_replace(array(' ', ' - ', '-', ':', '.', ',', '(', ')', '\'', 'è'), array('_', ''), strtolower( $eposter->title)), 0, 142).'<br>';
								// echo $eposter->id.'-';
								// echo $eposter->id.'-';
								echo $eposter->title;
							if ($eposter_url) {?>
								</a>
<?php
							}?></h4>
							<p class="author"><?php foreach($eposter->author as $index=>$item){echo (($index) ? ', ' : '').$item->author.((!empty(trim($item->credentials))) ? ' '.$item->credentials: '' );}?></p>
<?php
						if ($eposter->prize) {?>
					  	<img data-toggle="tooltip" data-placement="right" title="<?php echo (($eposter->prize != 'hot topic') ? 'Won ' : '' ).ucwords($eposter->prize);?>" class="img-fluid img-prize img-thumbnail"
					  		 src="<?= ycl_root ?>/theme_assets/default_theme/images/eposters/thumb/<?=str_replace(' ', '_', $eposter->prize).'.png';?>">
						<div class="clearfix"></div>
<?php
						}?>
						</div>
<?php
							if ($eposter_url) {?>
						<div class="col-12 text-md-right text-sm-right" style="position: absolute; bottom: 0;">
							<a href="<?=$eposter_url;?>" class="btn btn-sm btn-success m-1 rounded-0"><i class="fas fa-search"></i> VIEW</a>
						</div>
<?php
							}?>
					</div>
				</div>
			</div>
		</div>
<?php
			endforeach;?>
		<div class="mt-3 text-center">
        	<?php echo $links;?>
	    </div>
<?php
		}?>
	</div>
</div>
<script type="application/javascript">
	$(function () {
		$('[data-toggle="tooltip"]').tooltip();

		$("#frm-search").submit(function( event ) {
			event.preventDefault();
			applySearch();
		});

		$('#frm-search select[name="track"], #frm-search select[name="author"]').change(function() {
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
				text: 'Loading ePosters...',
				imageUrl: '<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/loading.gif',
				imageUrlOnError: '<?=ycl_root?>/ycl_assets/ycl_anime_500kb.gif',
				imageAlt: 'Loading...',
				showCancelButton: false,
				showConfirmButton: false,
				allowOutsideClick: false
			});

			var track 	= (($('#frm-search select[name="track"]').children("option:selected").val()) ? $('#frm-search select[name="track"]').children("option:selected").val() : 'NaN');
			var author 	= (($('#frm-search select[name="author"]').children("option:selected").val()) ? $('#frm-search select[name="author"]').children("option:selected").val() : 'NaN' );
			var type 	= (($('#frm-search input[type="radio"][name="type"]').filter(':checked').val()) ? $('#frm-search input[type="radio"][name="type"]').filter(':checked').val() : 'NaN' );
			var keyword = (($('#frm-search input[type="text"]').val()) ? $('#frm-search input[type="text"]').val() : 'NaN' );

			$(location).attr('href', project_url + '/eposters/index/' + track + '/' + author + '/' + type + '/' + keyword + '/');
	    }
	});
</script>
