<section class="panel">
    <header class="panel-heading">
        <h4 class="panel-title"><i class="fas fa-id-card"></i> <?=translate('report_card')?></h4>
    </header>
    <div class="panel-body">
	<?php
	$this->db->where('class_id', $stu['class_id']);
	$this->db->where('section_id', $stu['section_id']);
	$this->db->where('session_id', get_session_id());
	$this->db->group_by('exam_id');
	$variable = $this->db->get('timetable_exam')->result_array();
	foreach ($variable as  $erow) {
		$examID = $erow['exam_id'];
	?>
        <section class="panel panel-subl-shadow mt-md mb-md">
            <header class="panel-heading">
                <h4 class="panel-title"><?=$this->application_model->exam_name_by_id($examID);?></h4>
					<div class="panel-btn">
						<button type="submit" class="btn btn-default btn-circle" onclick="fn_printElem('card<?php echo $examID ?>');">
							<i class="fas fa-print"></i> <?=translate('print')?>
						</button>
					</div>
            </header>
            <div class="panel-body" id="card<?php echo $examID ?>">
			<style type="text/css">
				@media print {
					.mark-container {
					    background: #fff;
					    width: 1000px;
					    position: relative;
					    z-index: 2;
					    margin: 0 auto;
					    padding: 20px 30px;
					}
					table {
					    border-collapse: collapse;
					    width: 100%;
					    margin: 0 auto;
					}
				}
			</style>
			<?php
				$result = $this->exam_model->getStudentReportCard($stu['student_id'], $examID, get_session_id());
				if (!empty($result['exam'])) {
				$student = $result['student'];
				$getMarksList = $result['exam'];
				$getExam = $this->db->where(array('id' => $examID))->get('exam')->row_array();
				$getSchool = $this->db->where(array('id' => $getExam['branch_id']))->get('branch')->row_array();
				$schoolYear = get_type_name_by_id('schoolyear', get_session_id(), 'school_year');
			?>
			<div class="mark-container">
				<table class="visible-print" border="0" style="margin-top: 20px; height: 100px;">
					<tbody>
						<tr>
						<td style="width:40%;vertical-align: top;"><img style="max-width:225px;" src="<?=$this->application_model->getBranchImage($getExam['branch_id'], 'report-card-logo')?>"></td>
						<td style="width:60%;vertical-align: top;">
							<table align="right" class="table-head text-right" >
								<tbody>
									<tr><th style="font-size: 26px;" class="text-right"><?=$getSchool['school_name']?></th></tr>
									<tr><th style="font-size: 14px; padding-top: 4px;" class="text-right">Academic Session : <?=$schoolYear?></th></tr>
									<tr><td><?=$getSchool['address']?></td></tr>
									<tr><td><?=$getSchool['mobileno']?></td></tr>
									<tr><td><?=$getSchool['email']?></td></tr>
								</tbody>
							</table>
						</td>
						</tr>
					</tbody>
				</table>
				<table class="table table-bordered visible-print" style="margin-top: 20px;">
					<tbody>
						<tr>
							<th>Name</th>
							<td><?=$student['first_name'] . " " . $student['last_name']?></td>
							<th>Register No</th>
							<td><?=$student['register_no']?></td>
							<th>Roll Number</th>
							<td><?=$student['roll']?></td>
						</tr>
						<tr>
							<th>Father Name</th>
							<td><?=$student['father_name']?></td>
							<th>Admission Date</th>
							<td><?=_d($student['admission_date'])?></td>
							<th>Date of Birth</th>
							<td><?=_d($student['birthday'])?></td>
						</tr>
						<tr>
							<th>Mother Name</th>
							<td><?=$student['mother_name']?></td>
							<th>Class</th>
							<td><?=$student['class_name'] . " (" . $student['section_name'] . ")"?></td>
							<th>Gender</th>
							<td><?=ucfirst($student['gender'])?></td>
						</tr>
					</tbody>
				</table>


				<div class="table-responsive">
					<table class="table table-condensed table-bordered mt-sm" >
						<thead>
							<tr>
								<th>Subjects</th>
							<?php 
							$markDistribution = json_decode($getExam['mark_distribution'], true);
							foreach ($markDistribution as $id) {
								?>
								<th><?php echo get_type_name_by_id('exam_mark_distribution',$id)  ?></th>
							<?php } ?>
							<?php if ($getExam['type_id'] == 1) { ?>
								<th>Total</th>
							<?php } elseif($getExam['type_id'] == 2) { ?>
								<th>Grade</th>
								<th>Point</th>
							<?php } elseif ($getExam['type_id'] == 3) { ?>
								<th>Total</th>
								<th>Grade</th>
								<th>Point</th>
							<?php } ?>
							</tr>
						</thead>
						<tbody>
						<?php
						$colspan = count($markDistribution) + 1;
						$total_grade_point = 0;
						$grand_obtain_marks = 0;
						$grand_full_marks = 0;
						$result_status = 1;
						foreach ($getMarksList as $row) {
						?>
							<tr>
								<td valign="middle" width="35%"><?=$row['subject_name']?></td>
							<?php 
							$total_obtain_marks = 0;
							$total_full_marks = 0;
							$fullMarkDistribution = json_decode($row['mark_distribution'], true);
							$obtainedMark = json_decode($row['get_mark'], true);
							foreach ($fullMarkDistribution as $i => $val) {
								$obtained_mark = floatval($obtainedMark[$i]);
								$fullMark = floatval($val['full_mark']);
								$passMark = floatval($val['pass_mark']);
								if ($obtained_mark < $passMark) {
									$result_status = 0;
								}

								$total_obtain_marks += $obtained_mark;
								$obtained = $row['get_abs'] == 'on' ? 'Absent' : $obtained_mark;
								$total_full_marks += $fullMark;
								?>
							<?php if ($getExam['type_id'] == 1 || $getExam['type_id'] == 3){ ?>
								<td valign="middle">
									<?php 
										if ($row['get_abs'] == 'on') {
											echo 'Absent';
										} else {
											echo $obtained_mark . '/' . $fullMark;
										}
									?>
								</td>
							<?php } if ($getExam['type_id'] == 2){ ?>
								<td valign="middle">
									<?php 
										if ($row['get_abs'] == 'on') {
											echo 'Absent';
										} else {
											$percentage_grade = ($obtained_mark * 100) / $fullMark;
											$grade = $this->exam_model->get_grade($percentage_grade, $getExam['branch_id']);
											echo $grade['name'];
										}
									?>
								</td>
							<?php } ?>
							<?php
							}
							$grand_obtain_marks += $total_obtain_marks;
							$grand_full_marks += $total_full_marks;
							?>
							<?php if($getExam['type_id'] == 1 || $getExam['type_id'] == 3) { ?>
								<td valign="middle"><?=$total_obtain_marks . "/" . $total_full_marks?></td>
							<?php } if($getExam['type_id'] == 2) { 
								$percentage_grade = ($total_obtain_marks * 100) / $total_full_marks;
								$grade = $this->exam_model->get_grade($percentage_grade, $getExam['branch_id']);
								$total_grade_point += $grade['grade_point'];
								?>
								<td valign="middle"><?=$grade['name']?></td>
								<td valign="middle"><?=number_format($grade['grade_point'], 2, '.', '')?></td>
							<?php } if ($getExam['type_id'] == 3) {
								$colspan += 2;
								$percentage_grade = ($total_obtain_marks * 100) / $total_full_marks;
								$grade = $this->exam_model->get_grade($percentage_grade, $getExam['branch_id']);
								$total_grade_point += $grade['grade_point'];
								?>
								<td valign="middle"><?=$grade['name']?></td>
								<td valign="middle"><?=number_format($grade['grade_point'], 2, '.', '')?></td>
							<?php } ?>
							</tr>
						<?php } ?>
						<?php if ($getExam['type_id'] == 1 || $getExam['type_id'] == 3) { ?>
							<tr class="text-weight-semibold">
								<td valign="top" >GRAND TOTAL :</td>
								<td valign="top" colspan="<?=$colspan?>"><?=$grand_obtain_marks . '/' . $grand_full_marks; ?>, Average : <?php $percentage = ($grand_obtain_marks * 100) / $grand_full_marks; echo number_format($percentage, 2, '.', '')?>%</td>
							</tr>
							<?php $extINTL = extension_loaded('intl');
							if ($extINTL == true) {
							?>
							<tr class="text-weight-semibold">
								<td valign="top" >GRAND TOTAL IN WORDS :</td>
								<td valign="top" colspan="<?=$colspan?>">
									<?php
									$f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
									echo ucwords($f->format($grand_obtain_marks));
									?>
								</td>
							</tr>
							<?php } ?>
						<?php } if ($getExam['type_id'] == 2) { ?>
							<tr class="text-weight-semibold">
								<td valign="top" >GPA :</td>
								<td valign="top" colspan="<?=$colspan+1?>"><?=number_format(($total_grade_point / count($getMarksList)), 2, '.', '')?></td>
							</tr>
						<?php } if ($getExam['type_id'] == 3) { ?>
							<tr class="text-weight-semibold">
								<td valign="top" >GPA :</td>
								<td valign="top" colspan="<?=$colspan?>"><?=number_format(($total_grade_point / count($getMarksList)), 2, '.', '')?></td>
							</tr>
						<?php } if ($getExam['type_id'] == 1 || $getExam['type_id'] == 3) { ?>
							<tr class="text-weight-semibold">
								<td valign="top" >RESULT :</td>
								<td valign="top" colspan="<?=$colspan?>"><?=$result_status == 0 ? 'Fail' : 'Pass'; ?></td>
							</tr>
						<?php } ?>
						</tbody>
					</table>
		        </div>
			</div>
		    <?php } else { ?>
				<div class="alert alert-subl mb-none text-center">
					<i class="fas fa-exclamation-triangle"></i> <?=translate('no_information_available')?>
				</div>
		    <?php } ?>
            </div>
        </section>
	<?php } ?>
    </div>
</section>