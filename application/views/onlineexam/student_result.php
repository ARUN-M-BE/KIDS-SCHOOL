<?php 
$result = $this->onlineexam_model->examResult($exam->id, $studentID);
$correct_ans = $result['correct_ans'];
$total_question = $result['total_question'];
$total_marks = $result['total_marks'];
$total_obtain_marks = $result['total_obtain_marks'];
$wrong_ans = $result['wrong_ans'];
$total_answered = $result['total_answered'];
$total_neg_marks = ($exam->neg_mark == 0 ? 0 : $result['total_neg_marks']);
?>
<div class="table-responsive">
	<table class="table table-striped table-bordered table-condensed mb-md mt-md">
		<tbody>
			<tr>
				<th><?=translate('student') . " " . translate('name')?></th>
				<td><?php echo $this->db->select('CONCAT_WS(" ",first_name, last_name) as name')->where('id', $studentID)->get('student')->row()->name; ?></td>
				<th><?=translate('exam') . " " . translate('title')?></th>
				<td><?php echo $exam->title ?></td>
			</tr>
			<tr>
				<th><?=translate('class')?></th>
				<td><?php echo $exam->class_name . " (" . $this->onlineexam_model->getSectionDetails($exam->section_id) . ")"; ?></td>
				<th><?=translate('subject')?></th>
				<td><?php echo $this->onlineexam_model->getSubjectDetails($exam->subject_id); ?></td>
			</tr>
			<tr>
				<th><?=translate('start_time')?></th>
				<td><?php echo _d($exam->exam_start) . " <p class='text-muted'>" . date("h:i A", strtotime($exam->exam_start)) . "</p>" ?></td>
				<th><?=translate('end_time')?></th>
				<td><?php echo _d($exam->exam_end) . " <p class='text-muted'>" . date("h:i A", strtotime($exam->exam_end)) . "</p>" ?></td>
			</tr>
			<tr>
				<th><?=translate('mark') . " " . translate('type')?></th>
				<td><?php echo $exam->mark_type == 1 ? translate('percent') : translate('fixed'); ?></span></td>
				<th><?=translate('passing_mark')?></th>
				<td><?php echo $exam->passing_mark . ($exam->mark_type == 1 ? "%" : ""); ?></td>
			</tr>
			<tr>
				<th><?=translate('total') . " " . translate('question')?></th>
				<td><?php echo $total_question ?></td>
				<th><?=translate('total_answered')?></th>
				<td><?php echo $total_answered ?></td>
			</tr>
			<tr>
				<th><?=translate('total') . " " . translate('mark')?></th>
				<td><?php echo $total_marks ?></td>
				<th><?=translate('negative_mark')?></th>
				<td><?php echo $total_neg_marks ?></td>
			</tr>
			<tr>
				<th><?=translate('total_obtain_mark')?></th>
				<td><?php echo ($total_obtain_marks - $total_neg_marks) ?></td>
				<th><?=translate('score')?></th>
				<td><?php echo ($total_marks === 0) ? '0.00' : number_format(((($total_obtain_marks - $total_neg_marks) * 100) / $total_marks), 2, '.', ''); ?> (%)</td>
			</tr>
			<tr>
				<th><?=translate('correct_answer')?></th>
				<td><?php echo $correct_ans ?></td>
				<th><?=translate('incorrect_answer')?></th>
				<td><?php echo $wrong_ans ?></td>
			</tr>
			<tr>
				<th><?=translate('result')?></th>
				<td colspan="3"><?php 
					$status = '';
					if ($exam->mark_type == 1) {
						$obtain = $total_obtain_marks == 0 ? 0 : ((($total_obtain_marks - $total_neg_marks) * 100) / $total_marks);
						if ($obtain >= $exam->passing_mark) {
							echo "<span class='label label-success-custom'>Passed</span>";
						} else {
							echo "<span class='label label-danger-custom'>Failed</span>";
						}
					} else {
						$obtain = ($total_obtain_marks - $total_neg_marks);
						if ($obtain >= $exam->passing_mark) {
							echo "<span class='label label-success-custom'>Passed</span>";
						} else {
							echo "<span class='label label-danger-custom'>Failed</span>";
						}
					}
				 ?></td>
			</tr>
		</tbody>
	</table>
</div>