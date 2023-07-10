<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<link href="<?=ycl_root?>/theme_assets/<?=$this->project->theme?>/assets/css/evaluation.css?v=<?=rand()?>" rel="stylesheet">

<img id="full-screen-background" src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/sessions/sessions_listing_background.jpg">
<div class="clearfix" style="margin-bottom: 7rem;"></div>
<div class="evolution-container container-fluid pl-md-6 pr-md-6">
	<div class="row">
		<div class="col-md-12">
			<div class="text-center btn card mb-2 page-title"><h1 class="mb-0"><?=$evaluation->title?></span></h1></div>
		</div>
	</div>

	<div class="row mt-3">
		<div class="col">
			<table class="table table-responsive evaluation-description p-3" style="position: sticky">
				<tbody>
				<tr>
					<td style="border-top: 0px;">
						<div class="pb-3">
							<div class="container-fluid">
								<div class="row">
									<div class="col-md-12 text-center">
										<div class="mt-2 text-justify">
											<h4><?=$evaluation->description?></h4>
										</div>
										<div class="mt-5 text-justify">
											<h4><?=$evaluation->instruction?></h4>
										</div>
									</div>
								</div>
							</div>
						</div>
					</td>
				</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div class="row mt-3 mb-5">
		<div class="col">
			<form id="form1" method="post" action="">
				<input type="text" name="evaluation_id" value="<?=$evaluation->id?>" style="display: none">
				<table class="table table-responsive evaluation-description" style="position: sticky">
					<thead class="" >
					<th></th>
					<th class="text-center">Strongly Disagree</th>
					<th class="text-center">Disagree</th>
					<th class="text-center">Neutral</th>
					<th class="text-center">Agree</th>
					<th class="text-center">Strongly Agree</th>
					</thead>
					<tbody>
					<?php
					foreach ($evaluation->questions as $question) {
						if($question->question_type == 'radio_opt') {?>
							<tr><td class="text-justify <?=($question->is_subquestion)?'pl-5':''?>"><?=$question->name?><br><span style="color: #284050"><?= $question->translation ?></span></td>
								<td class="text-center align-middle" data-th="Strongly Disagree"><input value="1" <?=(isset($question->answer) && !empty($question->answer))?($question->answer=='1')?'checked':'':''?>  class="survey_option <?=$question->is_required?'required':''?>" data-question_id="<?=$question->id?>" data-question_title="<?=$question->name?>" type="radio" data-input_type="<?=$question->question_type?>" id="question_<?=$question->id?>" name="answer[<?=$question->id?>]"></td>
								<td class="text-center align-middle" data-th="Disagree"><input value="2" <?=(isset($question->answer) && !empty($question->answer))?($question->answer=='2')?'checked':'':''?>   class="survey_option <?=$question->is_required?'required':''?>" data-question_id="<?=$question->id?>" data-question_title="<?=$question->name?>" type="radio"  data-input_type="<?=$question->question_type?>" id="question_<?=$question->id?>" name="answer[<?=$question->id?>]"></td>
								<td class="text-center align-middle" data-th="Neutral"><input value="3" <?=(isset($question->answer) && !empty($question->answer))?($question->answer=='3')?'checked':'':''?> class="survey_option  <?=$question->is_required?'required':''?>" data-question_id="<?=$question->id?>" data-question_title="<?=$question->name?>" type="radio"  data-input_type="<?=$question->question_type?>" id="question_<?=$question->id?>" name="answer[<?=$question->id?>]" > </td>
								<td class="text-center align-middle" data-th="Agree"><input value="4" <?=(isset($question->answer) && !empty($question->answer))?($question->answer=='4')?'checked':'':''?>   class="survey_option  <?=$question->is_required?'required':''?>" data-question_id="<?=$question->id?>" data-question_title="<?=$question->name?>" type="radio" data-input_type="<?=$question->question_type?>"  id="question_<?=$question->id?>"  name="answer[<?=$question->id?>]" > </td>
								<td class="text-center align-middle" data-th="Strongly Agree"><input value="5" <?=(isset($question->answer) && !empty($question->answer))?($question->answer=='5')?'checked':'':''?>  class="survey_option <?=$question->is_required?'required':''?>" data-question_id="<?=$question->id?>" data-question_title="<?=$question->name?>" type="radio"  data-input_type="<?=$question->question_type?>" id="question_<?=$question->id?>"  name="answer[<?=$question->id?>]" > </td>
							</tr>
							<?php
						}
						if ($question->question_type == null || $question->question_type == ''){?>
							<tr>
								<td><?=$question->name?><br><span style="color: #284050"><?= $question->translation ?></span></td>
								<td colspan="5"><input type="text" value="" name="answer[<?=$question->id?>]" hidden></td>
							</tr>
							<?php
						}
						if($question->question_type == 'text_input') {?>
							<tr>
								<td class="text-justify"><?=$question->name?><br><span style="color: #284050"><?=$question->translation?></span></td>
								<td colspan="5"><textarea class="w-100 form-control shadow-none border-info<?=$question->is_required?' required':''?>" data-question_id="<?=$question->id?>" rows="2" name="answer[<?=$question->id?>]" data-input_type="<?=$question->question_type?>"  data-question_title="<?=$question->name?>" id="question_<?=$question->id?>" ><?=(isset($question->answer) && !empty($question->answer))?$question->answer:''?></textarea></td>
							</tr>
							<?php
						}
						if($question->question_type == 'yes_no'){?>
							<tr>
								<td class="text-justify">
									<?=$question->name?><br><span style="color: #284050"><?=$question->translation?></span>
								</td>
								<td colspan="3" class="text-center align-middle"><input type="radio" value="yes" <?=(isset($question->answer) && !empty($question->answer))?($question->answer=='yes')?'checked':'':''?>  class="survey_option  <?=$question->is_required?'required':''?>" data-question_id="<?=$question->id?>" name="answer[<?=$question->id?>]" data-input_type="<?=$question->question_type?>" data-question_title="<?=$question->name?>" id="question_<?=$question->id?>"> <label for="question_<?=$question->id?>"> Yes </label></td>
								<td colspan="2" class="text-center align-middle "><input type="radio" value="no" <?=(isset($question->answer) && !empty($question->answer))?($question->answer=='no')?'checked':'':''?>  class="survey_option <?=$question->is_required?'required':''?>" data-question_id="<?=$question->id?>" name="answer[<?=$question->id?>]" data-input_type="<?=$question->question_type?>" data-question_title="<?=$question->name?>" id="question_no_<?=$question->id?>"> <label for="question_no_<?=$question->id?>"> No </label></td>
							</tr>
							<confirm_title style="display: none"><?=$evaluation->confirm_title?> </confirm_title>
							<confirm_message style="display: none"><?=$evaluation->confirm_message?> </confirm_message>
							<success_title style="display: none"><?=$evaluation->success_title?> </success_title>
							<success_message style="display: none"><?=$evaluation->success_message?> </success_message>
							<?php
						}
					}?>
					</tbody>
					<tfoot>
					<tr>
						<td colspan="6"><input type="submit" class="btn btn-success float-right btn-lg" id="btn-submit" value="Submit"></td>
					</tr>
					</tfoot>
				</table>
			</form>
		</div>
	</div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
	$(function(){
		$('#btn-submit').on('click', function(e){
			e.preventDefault();
			validate();
		});

		function validate(){
			const translationData = fetchAllText(); // Fetch the translation data

			translationData.then((arrData) => {
				const selectedLanguage = $('#languageSelect').val(); // Get the selected language

				// Toast
				let requiredText = 'Required field #';

				// Swal
				let confirmButtonText = 'Continue!';
				let cancelButtonText = 'Cancel';

				// Swal 2
				let confirmButtonText2 = 'ok';

				for (let i = 0; i < arrData.length; i++) {
					if (arrData[i].english_text === requiredText) {
						requiredText = arrData[i][selectedLanguage + '_text'];
					}

					if (arrData[i].english_text === confirmButtonText) {
						confirmButtonText = arrData[i][selectedLanguage + '_text'];
					}
					if (arrData[i].english_text === cancelButtonText) {
						cancelButtonText = arrData[i][selectedLanguage + '_text'];
					}
					if (arrData[i].english_text === confirmButtonText2) {
						confirmButtonText2 = arrData[i][selectedLanguage + '_text'];
					}
					
				}
				$('.required').each(function(){
					var question_id = $(this).attr('data-question_id');
					var question_title = $(this).attr('data-question_title');
					var input_name = "answer["+question_id+"]";
					if($(this).attr('data-input_type')==='radio_opt') {
						if(!$("input[name='" +input_name+ "']").is(":checked")) {
							toastr['warning'](requiredText + question_title)
							$(this).addClass('border-danger');
							return false;
						}
					} else if ($(this).attr('data-input_type')=='text_input') {
						if (($("textarea[name='" + input_name + "']").val() == '')) {
							toastr['warning'](requiredText + question_title)
							$(this).addClass('border-danger');
							return false;
						}
					} else {
						Swal.fire({
							title: $('confirm_title').html(),
							html: $('confirm_message').html(),
							showCancelButton: true,
							confirmButtonColor: '#3085d6',
							cancelButtonColor: '#d33',
							confirmButtonText: confirmButtonText,
							cancelButtonText: cancelButtonText
						}).then((result) => {
							if (result.isConfirmed) {
								$.post('<?=$this->project_url . '/evaluation/save_evaluation'?>', $('#form1').serialize(), function (response) {
									if (response) {
										Swal.fire({
											icon: 'success',
											title: "<span class='text-success'>"+$('success_title').html()+"</span>",
											html: $('success_message').html(),
											confirmButtonText: confirmButtonText2,
										});
									}
								});
							}
						});
					}
				});
			});
			
		}
	});
</script>
