<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<?php
//print_r($evaluation);exit;
//foreach ($question_answer as $answer ){
//	print_r($answer->answer);
//}
//exit;
?>
<style>
	body
	{
		background-color: #eaeaea;
		margin-top: 100px;
	}
	.survey_option{
		width: 20px;
		height: 20px;
		cursor: pointer;
	}

	@media only screen and (max-width: 40em) {
		thead th:not(:first-child) {
			display: none;
		}

		td, th {
			display: block;
			clear: both;
		}

		td[data-th]:before  {
			content: attr(data-th);
			float: left;

		}
		.survey_option {
			float:right;
		}
	}
</style>
<img id="full-screen-background" src="<?=ycl_root?>/cms_uploads/projects/<?=$this->project->id?>/theme_assets/sessions/sessions_listing_background.jpg">
<body>
	<main role="main" class="mx-lg-5 mx-md-0">
		<div class="container-fluid mb-5" >
			<div class="row">
				<div class="col-md-12 text-center mx-lg-5">
					<div>
						<h1><?=$evaluation->title?></span></h1>
					</div>
					<div class="mt-5 text-justify mx-lg-5">
						<h5>
							<?=$evaluation->description?>
						</h5>
					</div>
					<div class="mt-5 text-justify mx-lg-5">
						<h5>
							<?=$evaluation->instruction?>
						</h5>
					</div>
				</div>
			</div>

			<div class="row mt-5">
				<div class="col">
					<form id="form1" method="post" action="">
						<input type="text" name="evaluation_id" value="<?=$evaluation->id?>" style="display: none">
						<table class="table table-responsive pb-5" style="background-color: white; position: sticky">
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

								if($question->question_type == 'radio_opt'){
									?>
										<tr>
										<td class="text-justify <?=($question->is_subquestion)?'pl-5':''?>">
											<?=$question->name?><br>
											<span style="color: #4773C5"><?= $question->translation ?></span>
										</td>
											<td class="text-center align-middle "  data-th="Strongly Disagree">	<input value="1" <?=(isset($question->answer) && !empty($question->answer))?($question->answer=='1')?'checked':'':''?>  class="survey_option <?=$question->is_required?'required':''?>" data-question_id="<?=$question->id?>" data-question_title="<?=$question->name?>" type="radio" data-input_type="<?=$question->question_type?>" id="question_<?=$question->id?>" name="answer[<?=$question->id?>]" > </td>
											<td class="text-center align-middle "  data-th="Disagree ">			<input value="2" <?=(isset($question->answer) && !empty($question->answer))?($question->answer=='2')?'checked':'':''?>   class="survey_option <?=$question->is_required?'required':''?>" data-question_id="<?=$question->id?>" data-question_title="<?=$question->name?>" type="radio"  data-input_type="<?=$question->question_type?>" id="question_<?=$question->id?>" name="answer[<?=$question->id?>]" > </td>
											<td class="text-center align-middle "  data-th="Neutral ">			<input value="3" <?=(isset($question->answer) && !empty($question->answer))?($question->answer=='3')?'checked':'':''?> class="survey_option  <?=$question->is_required?'required':''?>" data-question_id="<?=$question->id?>" data-question_title="<?=$question->name?>" type="radio"  data-input_type="<?=$question->question_type?>" id="question_<?=$question->id?>" name="answer[<?=$question->id?>]" > </td>
											<td class="text-center align-middle "  data-th="Agree ">			<input value="4" <?=(isset($question->answer) && !empty($question->answer))?($question->answer=='4')?'checked':'':''?>   class="survey_option  <?=$question->is_required?'required':''?>" data-question_id="<?=$question->id?>" data-question_title="<?=$question->name?>" type="radio" data-input_type="<?=$question->question_type?>"  id="question_<?=$question->id?>"  name="answer[<?=$question->id?>]" > </td>
											<td class="text-center align-middle "  data-th="Strongly Agree ">	<input value="5" <?=(isset($question->answer) && !empty($question->answer))?($question->answer=='5')?'checked':'':''?>  class="survey_option <?=$question->is_required?'required':''?>" data-question_id="<?=$question->id?>" data-question_title="<?=$question->name?>" type="radio"  data-input_type="<?=$question->question_type?>" id="question_<?=$question->id?>"  name="answer[<?=$question->id?>]" > </td>
										</tr>
										<?php
								}if ($question->question_type == null || $question->question_type == ''	){
									?>
										<tr>
											<td colspan="6"><?=$question->name?><br><span style="color: #4773C5"><?= $question->translation ?></span></td>
											<td><input type="text" value="" name="answer[<?=$question->id?>]" hidden></td>
										</tr>
									<?php
								}
								if($question->question_type == 'text_input'){
									?>
									<tr>
									<td class="text-justify">
										<?=$question->name?><br><span style="color: #4773C5"><?=$question->translation?></span>
									</td>
									<td colspan="5"><textarea class="w-100 form-control shadow-none border-info <?=$question->is_required?'required':''?>" data-question_id="<?=$question->id?>"  rows="3" name="answer[<?=$question->id?>]" data-input_type="<?=$question->question_type?>"  data-question_title="<?=$question->name?>" id="question_<?=$question->id?>" ><?=(isset($question->answer) && !empty($question->answer))?$question->answer:''?></textarea></td>
									</tr>
									<?php
								}
								if($question->question_type == 'yes_no'){
									?>
									<tr>
										<td class="text-justify">
											<?=$question->name?><br><span style="color: #4773C5"><?=$question->translation?></span>
										</td>
										<td colspan="3" class="text-center align-middle " > <lable>Yes </lable><input type="radio" value="yes" <?=(isset($question->answer) && !empty($question->answer))?($question->answer=='yes')?'checked':'':''?>  class="survey_option  <?=$question->is_required?'required':''?>" data-question_id="<?=$question->id?>"  name="answer[<?=$question->id?>]" data-input_type="<?=$question->question_type?>"  data-question_title="<?=$question->name?>" id="question_<?=$question->id?>" ></td>
										<td colspan="2" class="text-center align-middle " > <lable>No </lable><input type="radio" value="no" <?=(isset($question->answer) && !empty($question->answer))?($question->answer=='no')?'checked':'':''?>  class="survey_option <?=$question->is_required?'required':''?>" data-question_id="<?=$question->id?>"  name="answer[<?=$question->id?>]" data-input_type="<?=$question->question_type?>"  data-question_title="<?=$question->name?>" id="question_<?=$question->id?>" ></td>
									</tr>
										<?php
								}
							?>
							<?php
							}
							?>
							</tbody>
						</table>
						<input type="submit" class="btn btn-success float-right btn-lg" id="btn-submit" value="Submit">
					</form>

				</div>
			</div>
		</div>
	</main>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js" integrity="sha512-37T7leoNS06R80c8Ulq7cdCDU5MNQBwlYoy1TX/WUsLFC2eYNqtKlV0QjH7r8JpG/S0GUMZwebnVFLPd6SU5yg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
	$(function(){

		$('#btn-submit').on('click', function(e){
			e.preventDefault();
			validate();
		});

		function validate(){
			var confirm_title = "<?=$evaluation->confirm_title?>";
			var confirm_message = "<?=$evaluation->confirm_message?>";
			var success_title = "<?=$evaluation->success_title?>";
			var success_message = "<?=$evaluation->success_message?>";
			$('.required').each(function(){
				var data = $(this).attr('data-question_id');
				var question = $(this).attr('data-question_title');
				var input_name = "answer["+data+"]";
				if($(this).attr('data-input_type')==='radio_opt'){
					if(!$("input[name='" +input_name+ "']").is(":checked")){
					toastr['warning']('Required field #'+question)
						$(this).addClass('border-danger');
					return false;
				}
				} else if ($(this).attr('data-input_type')==='text_input' && ($("textarea[name='" + input_name + "']").val() === '')) {
						toastr['warning']('Required field #'+question)
						$(this).addClass('border-danger');
						return false;

				}else{
					Swal.fire({
						title: confirm_title,
						html: confirm_message,
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Continue!'
					}).then((result) => {
						if (result.isConfirmed) {
							$.post('<?=$this->project_url . '/evaluation/save_evaluation'?>', $('#form1').serialize(), function (response) {
								if (response) {
									Swal.fire({
										icon: 'success',
										title: "<span class='text-success'>"+success_title+"</span>",
										html: success_message,
										confirmButtonText: "ok",
									});
								}
							});
						}
					})
				}
			})
		}
	});

</script>
