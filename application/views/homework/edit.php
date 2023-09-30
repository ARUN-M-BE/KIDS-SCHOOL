<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<?php echo form_open_multipart($this->uri->uri_string(), array('class' => 'form-bordered form-horizontal frm-submit-data'));?>
			<input type="hidden" name="homework_id" value="<?=$homework['id']?>">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="fas fa-plus-circle"></i> <?=translate('edit') . " " . translate('homework')?></h4>
			</header>
			<div class="panel-body mb-md">
				<div class="mt-md"></div>
				<?php if (is_superadmin_loggedin()): ?>
					<div class="form-group">
						<label class="control-label col-md-3"><?=translate('branch')?> <span class="required">*</span></label>
						<div class="col-md-6">
							<?php
								$arrayBranch = $this->app_lib->getSelectList('branch');
								echo form_dropdown("branch_id", $arrayBranch, $homework['branch_id'], "class='form-control' id='branch_id'
								data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity'");
							?>
							<span class="error"></span>
						</div>
					</div>
				<?php endif; ?>
				<div class="form-group">
					<label class="col-md-3 control-label"><?=translate('class')?> <span class="required">*</span></label>
					<div class="col-md-6">
						<?php
							$arrayClass = $this->app_lib->getClass($homework['branch_id']);
							echo form_dropdown("class_id", $arrayClass, $homework['class_id'], "class='form-control' id='class_id' onchange='getSectionByClass(this.value,0)'
							data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
						?>
						<span class="error"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label"><?=translate('section')?> <span class="required">*</span></label>
					<div class="col-md-6">
						<?php
							$arraySection = $this->app_lib->getSections($homework['class_id'], true);
							echo form_dropdown("section_id", $arraySection, $homework['section_id'], "class='form-control' id='section_id'
							data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
						?>
						<span class="error"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label"><?=translate('subject')?> <span class="required">*</span></label>
					<div class="col-md-6">
						<?php
							if(!empty($homework['class_id'])) {
								$arraySubject = array("" => translate('select'));
								$query = $this->subject_model->getSubjectByClassSection($homework['class_id'], $homework['section_id']);
								$subjects = $query->result_array();
								foreach ($subjects as $row){
									$subjectID = $row['subject_id'];
									$arraySubject[$subjectID] = $row['subjectname'];
								}
							} else {
								$arraySubject = array("" => translate('select_class_first'));
							}
							echo form_dropdown("subject_id", $arraySubject, $homework['subject_id'], "class='form-control' id='subject_id'
							data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
						?>
						<span class="error"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label"><?=translate('date_of_homework')?> <span class="required">*</span></label>
					<div class="col-md-6">
						<div class="input-group">
							<span class="input-group-addon"><i class="far fa-calendar-alt"></i></span>
							<input type="text" class="form-control" name="date_of_homework" id="date_of_homework" value="<?=$homework['date_of_homework']?>" autocomplete="off" data-plugin-datepicker
							data-plugin-options='{ "todayHighlight" : true }' />
						</div>
						<span class="error"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label"><?=translate('date_of_submission')?> <span class="required">*</span></label>
					<div class="col-md-6">
						<div class="input-group">
							<span class="input-group-addon"><i class="far fa-calendar-alt"></i></span>
							<input type="text" class="form-control" name="date_of_submission" value="<?=$homework['date_of_submission']?>" autocomplete="off" data-plugin-datepicker
							data-plugin-options='{ "todayHighlight" : true }' />
						</div>
						<span class="error"></span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-3 col-md-6">
						<div class="checkbox-replace">
							<label class="i-checks"><input type="checkbox" name="published_later" <?=$homework['status'] == 1 ? 'checked' : '';?> id="published_later"><i></i> Published later</label>
						</div>
					</div>
					<div class="col-md-12 mt-sm"></div>
					<label class="col-md-3 control-label">Schedule Date <span class="required">*</span></label>
					<div class="col-md-6">
						<div class="input-group">
							<span class="input-group-addon"><i class="far fa-calendar-alt"></i></span>
							<input type="text" class="form-control" name="schedule_date" id="schedule_date" <?=$homework['status'] == 0 ? 'disabled' : '';?> autocomplete="off" value="<?=$homework['schedule_date']?>" data-plugin-datepicker
							data-plugin-options='{ "todayHighlight" : true }' />
						</div>
						<span class="error"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label"><?=translate('homework')?> <span class="required">*</span></label>
					<div class="col-md-6">
						<textarea name="homework" class="summernote"><?=$homework['description']?></textarea>
						<span class="error"></span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Attachment File <span class="required">*</span></label>
					<input type="hidden" name="old_document" value="<?=$homework['document']?>">
					<div class="col-md-6">
						<div class="fileupload fileupload-new" data-provides="fileupload">
							<div class="input-append">
								<div class="uneditable-input">
									<i class="fas fa-file fileupload-exists"></i>
									<span class="fileupload-preview"></span>
								</div>
								<span class="btn btn-default btn-file">
									<span class="fileupload-exists">Change</span>
									<span class="fileupload-new">Select file</span>
									<input type="file" name="attachment_file" />
								</span>
								<a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload">Remove</a>
							</div>
						</div>
						<span class="error"></span>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-3 col-md-6">
						<div class="checkbox-replace">
							<label class="i-checks"><input type="checkbox" name="notification_sms" <?=$homework['sms_notification'] == 1 ? 'checked' : '';?>><i></i> Send Notification SMS</label>
						</div>
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-offset-3 col-md-2">
						<button type="submit" class="btn btn-default btn-block" data-loading-text="<i class='fas fa-spinner fa-spin'></i> Processing">
							<i class="fas fa-plus-circle"></i> <?=translate('update')?>
						</button>
					</div>
				</div>
			</footer>
			<?php echo form_close(); ?>
		</section>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		$('#branch_id').on('change', function() {
			var branchID = $(this).val();
			getClassByBranch(branchID);
			$('#subject_id').html('').append('<option value=""><?=translate("select")?></option>');
		});

		$('#section_id').on('change', function() {
			var classID = $('#class_id').val();
			var sectionID =$(this).val();
			$.ajax({
				url: base_url + 'subject/getByClassSection',
				type: 'POST',
				data: {
					classID: classID,
					sectionID: sectionID
				},
				success: function (data) {
					$('#subject_id').html(data);
				}
			});
		});

		$('#published_later').on('change', function() {
			if($(this).is(':checked') ){
				var date_of_homework =$('#date_of_homework').val()
				$('#schedule_date').val(date_of_homework);
				$('#schedule_date').prop("disabled", false);
			} else {
				$('#schedule_date').val("");
				$('#schedule_date').prop("disabled", true);
			}
		});
	});
</script>