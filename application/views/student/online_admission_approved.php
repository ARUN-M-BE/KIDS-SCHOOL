<?php 

$branchID = $stuDetails['branch_id'];
 ?>
<div class="row">
	<div class="col-md-12">
		<section class="panel">
			<?php echo form_open_multipart($this->uri->uri_string()); ?>
			<header class="panel-heading">
				<h4 class="panel-title"><i class="fas fa-graduation-cap"></i> <?=translate('student_admission')?></h4>
			</header>
			<div class="panel-body">
				<!-- academic details-->
				<div class="headers-line">
					<i class="fas fa-school"></i> <?=translate('academic_details')?>
				</div>
				
				<?php $academic_year = get_session_id(); ?>
				<div class="row">
					<div class="col-md-3 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('academic_year')?> <span class="required">*</span></label>
							<?php
								$arrayYear = array("" => translate('select'));
								$years = $this->db->get('schoolyear')->result();
								foreach ($years as $year){
									$arrayYear[$year->id] = $year->school_year;
								}
								echo form_dropdown("year_id", $arrayYear, set_value('year_id', $academic_year), "class='form-control' id='academic_year_id'
								data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
							?>
							<span class="error"><?=form_error('year_id')?></span>
						</div>
					</div>
					
					<div class="col-md-3 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('register_no')?> <span class="required">*</span></label>
							<input type="text" class="form-control" name="register_no" value="<?=set_value('register_no', $register_id)?>" />
							<span class="error"><?=form_error('register_no')?></span>
						</div>
					</div>
				
					<div class="col-md-3 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('roll')?></label>
							<input type="text" class="form-control" name="roll" value="<?=set_value('roll')?>" />
							<span class="error"><?=form_error('roll')?></span>
						</div>
					</div>
					<?php 
					$admission_date = $this->student_fields_model->getStatus('admission_date', $branchID);
					if ($admission_date['status']) {
					?>
					<div class="col-md-3 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('admission_date')?> <span class="required">*</span></label>
							<div class="input-group">
								<span class="input-group-addon"><i class="far fa-calendar-alt"></i></span>
								<input type="text" class="form-control" name="admission_date" value="<?=set_value('admission_date', date('Y-m-d'))?>" data-plugin-datepicker
								data-plugin-options='{ "todayHighlight" : true }' />
							</div>
							<span class="error"><?=form_error('admission_date')?></span>
						</div>
					</div>
					<?php } ?>
				</div>

				<div class="row mb-md">
					<div class="col-md-3 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('branch')?> <span class="required">*</span></label>
							<input type="text" class="form-control" readonly="" name="branch_id" value="<?=$getBranch['name']?>" />
						</div>
					</div>
					<div class="col-md-3 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('class')?> <span class="required">*</span></label>
							<?php
								$arrayClass = $this->app_lib->getClass($stuDetails['branch_id']);
								echo form_dropdown("class_id", $arrayClass, set_value('class_id', $stuDetails['class_id']), "class='form-control' id='class_id' onchange='getSectionByClass(this.value,0)'
								data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
							?>
							<span class="error"><?=form_error('class_id')?></span>
						</div>
					</div>
					<?php 
					$section = $this->student_fields_model->getStatus('section', $branchID);
					$category = $this->student_fields_model->getStatus('category', $branchID);
					if ($section['status']) {
					?>
					<div class="col-md-3 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('section')?> <span class="required">*</span></label>
							<?php
								$arraySection = $this->app_lib->getSections(set_value('class_id', $stuDetails['class_id']), false);
								echo form_dropdown("section_id", $arraySection, set_value('section_id', $stuDetails['section_id']), "class='form-control' id='section_id' 
								data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
							?>
							<span class="error"><?=form_error('section_id')?></span>
						</div>
					</div>
					<?php } if ($category['status']) { ?>
					<div class="col-md-3 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('category')?> <span class="required">*</span></label>
							<?php
								$arrayCategory = $this->app_lib->getStudentCategory($stuDetails['branch_id']);
								echo form_dropdown("category_id", $arrayCategory, set_value('category_id'), "class='form-control'
								data-plugin-selectTwo data-width='100%' id='category_id' data-minimum-results-for-search='Infinity' ");
							?>
							<span class="error"><?=form_error('category_id')?></span>
						</div>
					</div>
					<?php } ?>
				</div>
				
				<!-- student details -->
				<div class="headers-line mt-md">
					<i class="fas fa-user-check"></i> <?=translate('student_details')?>
				</div>

				<div class="row">
					<div class="col-md-4 mb-sm">
						<div class="form-group">
							<label class="control-label"> <?=translate('first_name')?> <span class="required">*</span></label>
							<div class="input-group">
								<span class="input-group-addon"><i class="fas fa-user-graduate"></i></span>
								<input type="text" class="form-control" name="first_name" value="<?=set_value('first_name', $stuDetails['first_name'])?>"/>
							</div>
							<span class="error"><?=form_error('first_name')?></span>
						</div>
					</div>
					<?php 
					$last_name = $this->student_fields_model->getStatus('last_name', $branchID);
					$gender = $this->student_fields_model->getStatus('gender', $branchID);
					if ($last_name['status']) {
					?>
					<div class="col-md-4 mb-sm">
						<div class="form-group">
							<label class="control-label"> <?=translate('last_name')?> <span class="required">*</span></label>
							<div class="input-group">
								<span class="input-group-addon"><i class="fas fa-user-graduate"></i></span>
								<input type="text" class="form-control" name="last_name" value="<?=set_value('last_name', $stuDetails['last_name'])?>" />
							</div>
						</div>
						<span class="error"><?=form_error('last_name')?></span>
					</div>
					<?php } if ($gender['status']) { ?>
					<div class="col-md-4 mb-sm">
						<div class="form-group">
							<label class="control-label"> <?=translate('gender')?> </label>
							<?php
								$arrayGender = array(
									'male' => translate('male'),
									'female' => translate('female')
								);
								echo form_dropdown("gender", $arrayGender, set_value('gender', $stuDetails['gender']), "class='form-control' data-plugin-selectTwo
								data-width='100%' data-minimum-results-for-search='Infinity' ");
							?>
						</div>
					</div>
					<?php } ?>
				</div>

				<div class="row">
					<?php 
					$blood_group = $this->student_fields_model->getStatus('blood_group', $branchID);
					$birthday = $this->student_fields_model->getStatus('birthday', $branchID);
					if ($blood_group['status']) {
					?>
					<div class="col-md-6 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('blood_group')?></label>
							<?php
								$bloodArray = $this->app_lib->getBloodgroup();
								echo form_dropdown("blood_group", $bloodArray, set_value("blood_group"), "class='form-control populate' data-plugin-selectTwo 
								data-width='100%' data-minimum-results-for-search='Infinity' ");
							?>
						</div>
					</div>
					<?php } if ($birthday['status']) { ?>
					<div class="col-md-6 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('birthday')?></label>
							<div class="input-group">
								<span class="input-group-addon"><i class="fas fa-birthday-cake"></i></span>
								<input type="text" autocomplete="off" class="form-control" name="birthday" value="<?=set_value('birthday', $stuDetails['birthday'])?>" data-plugin-datepicker
								data-plugin-options='{ "startView": 2 }' />
							</div>
						</div>
					</div>
					<?php } ?>
				</div>

				<div class="row">
					<?php 
					$mother_tongue = $this->student_fields_model->getStatus('mother_tongue', $branchID);
					$religion = $this->student_fields_model->getStatus('religion', $branchID);
					$caste = $this->student_fields_model->getStatus('caste', $branchID);
					if ($mother_tongue['status']) {
					?>
					<div class="col-md-4 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('mother_tongue')?></label>
							<input type="text" class="form-control" name="mother_tongue" value="<?=set_value('mother_tongue')?>" />
						</div>
					</div>
					<?php } if ($religion['status']) { ?>
					<div class="col-md-4 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('religion')?></label>
							<input type="text" class="form-control" name="religion" value="<?=set_value('religion')?>" />
						</div>
					</div>
					<?php } if ($caste['status']) { ?>
					<div class="col-md-4 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('caste')?></label>
							<input type="text" class="form-control" name="caste" value="<?=set_value('caste')?>" />
						</div>
					</div>
					<?php } ?>
				</div>

				<div class="row">
					<?php 
					$student_mobile_no = $this->student_fields_model->getStatus('student_mobile_no', $branchID);
					$student_email = $this->student_fields_model->getStatus('student_email', $branchID);
					$city = $this->student_fields_model->getStatus('city', $branchID);
					$state = $this->student_fields_model->getStatus('state', $branchID);
					if ($student_mobile_no['status']) {
					?>
					<div class="col-md-3 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('mobile_no')?> <span class="required">*</span></label>
							<div class="input-group">
								<span class="input-group-addon"><i class="fas fa-phone-volume"></i></span>
								<input type="text" class="form-control" name="mobileno" value="<?=set_value('mobileno', $stuDetails['mobile_no'])?>" />
							</div>
							<span class="error"><?=form_error('mobileno')?></span>
						</div>
					</div>
					<?php } if ($student_email['status']) { ?>
					<div class="col-md-3 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('email')?></label>
							<div class="input-group">
								<span class="input-group-addon"><i class="far fa-envelope-open"></i></span>
								<input type="text" class="form-control" name="email" id="email" value="<?=set_value('email', $stuDetails['email'])?>" />
							</div>
							<span class="error"><?=form_error('email')?></span>
						</div>
					</div>
					<?php } if ($city['status']) { ?>
					<div class="col-md-3 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('city')?></label>
							<input type="text" class="form-control" name="city" value="<?=set_value('city')?>" />
						</div>
					</div>
					<?php } if ($state['status']) { ?>
					<div class="col-md-3 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('state')?></label>
							<input type="text" class="form-control" name="state" value="<?=set_value('state')?>" />
						</div>
					</div>
					<?php } ?>
				</div>

				<div class="row">
					<?php 
					$present_address = $this->student_fields_model->getStatus('present_address', $branchID);
					$permanent_address = $this->student_fields_model->getStatus('permanent_address', $branchID);
					if ($present_address['status']) {
					?>
					<div class="col-md-6 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('present_address')?></label>
							<textarea name="current_address" rows="2" class="form-control" aria-required="true"><?=set_value('current_address', $stuDetails['present_address'])?></textarea>
						</div>
					</div>
					<?php } if ($permanent_address['status']) { ?>
					<div class="col-md-6 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('permanent_address')?></label>
							<textarea name="permanent_address" rows="2" class="form-control" aria-required="true"><?=set_value('permanent_address', $stuDetails['permanent_address'])?></textarea>
						</div>
					</div>
					<?php } ?>
				</div>

				<!--custom fields details-->
				<div class="row" id="customFields">
					<?php echo render_online_custom_fields('online_admission', $stuDetails['branch_id'], $stuDetails['id']); ?>
				</div>
				
				<div class="row">
					<div class="col-md-12 mb-sm">
						<div class="form-group">
							<label for="input-file-now"><?=translate('profile_picture')?></label>
							<input type="file" name="user_photo" class="dropify" />
							<span class="error"><?=form_error('user_photo')?></span>
						</div>
					</div>
				</div>
				<div class="<?=$getBranch['stu_generate'] == 1 || $getBranch['stu_generate'] == "" ? 'hidden-div' : '' ?>" id="stuLogin">
					<!-- login details -->
					<div class="headers-line mt-md">
						<i class="fas fa-user-lock"></i> <?=translate('login_details')?>
					</div>
					<div class="row mb-md">
						<div class="col-md-6 mb-sm">
							<div class="form-group">
								<label class="control-label"><?=translate('username')?> <span class="required">*</span></label>
								<div class="input-group">
									<span class="input-group-addon"><i class="far fa-user"></i></span>
									<input type="text" class="form-control" name="username" id="username" value="<?=set_value('username')?>" />
								</div>
								<span class="error"><?=form_error('username')?></span>
							</div>
						</div>
						<div class="col-md-3 mb-sm">
							<div class="form-group">
								<label class="control-label"><?=translate('password')?> <span class="required">*</span></label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-unlock-alt"></i></span>
									<input type="password" class="form-control" name="password" value="<?=set_value('password')?>" />
								</div>
								<span class="error"><?=form_error('password')?></span>
							</div>
						</div>
						<div class="col-md-3 mb-sm">
							<div class="form-group">
								<label class="control-label"><?=translate('retype_password')?> <span class="required">*</span></label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-unlock-alt"></i></span>
									<input type="password" class="form-control" name="retype_password" value="<?=set_value('retype_password')?>" />
								</div>
								<span class="error"><?=form_error('retype_password')?></span>
							</div>
						</div>
					</div>
				</div>

				<!--guardian details-->
				<div class="headers-line">
					<i class="fas fa-user-tie"></i> <?=translate('guardian_details')?>
				</div>

				<div id="guardian_form">
					<div class="row">
						<div class="col-md-6 mb-sm">
							<div class="form-group">
								<label class="control-label"><?=translate('name')?> <span class="required">*</span></label>
								<input class="form-control" name="grd_name" type="text" value="<?=set_value('grd_name', $stuDetails['guardian_name'])?>">
							</div>
							<span class="error"><?=form_error('grd_name')?></span>
						</div>
						<div class="col-md-6 mb-sm">
							<div class="form-group">
								<label class="control-label"><?=translate('relation')?> <span class="required">*</span></label>
								<input type="text" class="form-control" name="grd_relation" value="<?=set_value('grd_relation', $stuDetails['guardian_relation'])?>" />
								<span class="error"><?=form_error('grd_relation')?></span>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-6 mb-sm">
							<div class="form-group">
								<label class="control-label"><?=translate('father_name')?></label>
								<input type="text" class="form-control" name="father_name" value="<?=set_value('father_name', $stuDetails['father_name'])?>" />
							</div>
						</div>
						<div class="col-md-6 mb-sm">
							<div class="form-group">
								<label class="control-label"><?=translate('mother_name')?></label>
								<input type="text" class="form-control" name="mother_name" value="<?=set_value('mother_name', $stuDetails['mother_name'])?>" />
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4 mb-sm">
							<div class="form-group">
								<label class="control-label"><?=translate('occupation')?> <span class="required">*</span></label>
								<input class="form-control" name="grd_occupation" value="<?=set_value('grd_occupation', $stuDetails['grd_occupation'])?>" type="text">
								<span class="error"><?=form_error('grd_occupation')?></span>
							</div>
						</div>
						<div class="col-md-4 mb-sm">
							<div class="form-group">
								<label class="control-label"><?=translate('income')?></label>
								<input class="form-control" name="grd_income" value="<?=set_value('grd_income', $stuDetails['grd_income'])?>" type="text">
							</div>
						</div>
						<div class="col-md-4 mb-sm">
							<div class="form-group">
								<label class="control-label"><?=translate('education')?></label>
								<input class="form-control" name="grd_education" value="<?=set_value('grd_education', $stuDetails['grd_education'])?>" type="text">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-3 mb-sm">
							<div class="form-group">
								<label class="control-label"><?=translate('city')?></label>
								<input class="form-control" name="grd_city" value="<?=set_value('grd_city')?>" type="text">
							</div>
						</div>
						<div class="col-md-3 mb-sm">
							<div class="form-group">
								<label class="control-label"><?=translate('state')?></label>
								<input class="form-control" name="grd_state" value="<?=set_value('grd_state')?>" type="text">
							</div>
						</div>
						<div class="col-md-3 mb-sm">
							<div class="form-group">
								<label class="control-label"><?=translate('mobile_no')?> <span class="required">*</span></label>
								<div class="input-group">
									<span class="input-group-addon"><i class="fas fa-phone-volume"></i></span>
									<input class="form-control" name="grd_mobileno" type="text" value="<?=set_value('grd_mobileno', $stuDetails['grd_mobile_no'])?>">
								</div>
								<span class="error"><?=form_error('grd_mobileno')?></span>
							</div>
						</div>
						<div class="col-md-3 mb-sm">
							<div class="form-group">
								<label class="control-label"><?=translate('email')?></label>
								<div class="input-group">
									<span class="input-group-addon"><i class="far fa-envelope-open"></i></span>
									<input type="email" class="form-control" name="grd_email" id="grd_email" value="<?=set_value('grd_email', $stuDetails['grd_email'])?>" />
								</div>
								<span class="error"><?=form_error('grd_email')?></span>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 mb-sm">
							<div class="form-group">
								<label class="control-label"><?=translate('address')?></label>
								<textarea name="grd_address" rows="2" class="form-control" aria-required="true"><?=set_value('grd_address', $stuDetails['grd_address'])?></textarea>
							</div>
						</div>
					</div>
					<div class="<?=$getBranch['grd_generate'] == 1 || $getBranch['grd_generate'] == "" ? 'hidden-div' : ''?>" id="grdLogin">
						<div class="row mb-lg">
							<div class="col-md-6 mb-sm">
								<div class="form-group">
									<label class="control-label"><?=translate('usename')?> <span class="required">*</span></label>
									<div class="input-group">
										<span class="input-group-addon"><i class="far fa-user"></i></span>
										<input type="email" class="form-control" name="grd_username" id="grd_username" value="<?=set_value('grd_username')?>" />
									</div>
									<span class="error"><?=form_error('grd_username')?></span>
								</div>
							</div>
							<div class="col-md-3 mb-sm">
								<div class="form-group">
									<label class="control-label"><?=translate('password')?> <span class="required">*</span></label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fas fa-unlock-alt"></i></span>
										<input type="password" class="form-control" name="grd_password" value="<?=set_value('grd_password')?>" />
									</div>
									<span class="error"><?=form_error('grd_password')?></span>
								</div>
							</div>
							<div class="col-md-3 mb-sm">
								<div class="form-group">
									<label class="control-label"><?=translate('retype_password')?> <span class="required">*</span></label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fas fa-unlock-alt"></i></span>
										<input type="password" class="form-control" name="grd_retype_password" value="<?=set_value('grd_retype_password')?>" />
									</div>
									<span class="error"><?=form_error('grd_retype_password')?></span>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- transport details -->
				<div class="headers-line">
					<i class="fas fa-bus-alt"></i> <?=translate('transport_details')?>
				</div>

				<div class="row mb-md">
					<div class="col-md-6 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('transport_route')?></label>
							<?php
								$arrayRoute = $this->app_lib->getSelectByBranch('transport_route', $branch_id);
								echo form_dropdown("route_id", $arrayRoute, set_value('route_id'), "class='form-control' id='route_id'
								data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
							?>
						</div>
					</div>
					<div class="col-md-6 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('vehicle_no')?></label>
							<?php
								$arrayVehicle = $this->app_lib->getVehicleByRoute(set_value('route_id'));
								echo form_dropdown("vehicle_id", $arrayVehicle, set_value('vehicle_id'), "class='form-control' id='vehicle_id'
								data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
							?>
						</div>
					</div>
				</div>
				
				<!-- hostel details -->
				<div class="headers-line">
					<i class="fas fa-hotel"></i> <?=translate('hostel_details')?>
				</div>
				
				<div class="row mb-md">
					<div class="col-md-6 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('hostel_name')?></label>
							<?php
								$arrayHostel = $this->app_lib->getSelectByBranch('hostel', $branch_id);
								echo form_dropdown("hostel_id", $arrayHostel, set_value('hostel_id'), "class='form-control' id='hostel_id'
								data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
							?>
						</div>
					</div>
					<div class="col-md-6 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('room_name')?></label>
							<?php
								$arrayRoom = $this->app_lib->getRoomByHostel(set_value('hostel_id'));
								echo form_dropdown("room_id", $arrayRoom, set_value('room_id'), "class='form-control' id='room_id'
								data-plugin-selectTwo data-width='100%' data-minimum-results-for-search='Infinity' ");
							?>
						</div>
					</div>
				</div>
				
				<!-- previous school details -->
				<div class="headers-line">
					<i class="fas fa-bezier-curve"></i> <?=translate('previous_school_details')?>
				</div>
				<div class="row">
					<div class="col-md-6 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('school_name')?></label>
							<input type="text" class="form-control" name="school_name" value="<?=set_value('school_name')?>" />
						</div>
					</div>
					<div class="col-md-6 mb-sm">
						<div class="form-group">
							<label class="control-label"><?=translate('qualification')?></label>
							<input type="text" class="form-control" name="qualification" value="<?=set_value('qualification')?>" />
						</div>
					</div>
				</div>
				<div class="row mb-lg">
					<div class="col-md-12">
						<div class="form-group">
							<label class="control-label"><?=translate('remarks')?></label>
							<textarea name="previous_remarks" rows="2" class="form-control"><?=set_value('previous_remarks')?></textarea>
						</div>
					</div>
				</div>
			</div>
			<footer class="panel-footer">
				<div class="row">
					<div class="col-md-offset-10 col-md-2">
						<button type="submit" name="save" value="1" class="btn btn btn-default btn-block">
							<i class="fas fa-plus-circle"></i> <?=translate('save')?>
						</button>
					</div>
				</div>
			</footer>
			<?php echo form_close();?>
		</section>
	</div>
</div>