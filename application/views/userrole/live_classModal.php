<?php 
$uID = explode('|', $meetingID);
$this->db->select('live_class.*,staff.name as staffname');
$this->db->from('live_class');
$this->db->join('staff', 'staff.id = live_class.created_by', 'left');
$this->db->order_by('live_class.id', 'ASC');
$this->db->where('live_class.meeting_id', $uID[0]);
$this->db->where('live_class.id', $uID[1]);
$row = $this->db->get()->row_array();

$getConfig = $this->userrole_model->get('live_class_config', array('branch_id' => $row['branch_id']), true);
?>
<div class="row">
	<div class="col-md-8">
		<label><span class="text-weight-semibold"><?=translate('remarks')?> :</span></label>
		<?php if (empty($row['remarks'])) { ?>
			<div class="alert alert-subl text-dark text-center"><i class="fas fa-exclamation-circle"></i> No information was found</div>
		<?php } else { ?>
			<div class="alert alert-subl text-dark"><?=nl2br($row['remarks'])?></div>
		<?php }  ?>
	</div>
	<div class="col-md-4">
		<label><span class="text-weight-semibold"><i class="far fa-calendar"></i> <?=translate('date')?></span> : <span class="text-dark"><?=_d($row['date'])?></span></label><br>
		<label><span class="text-weight-semibold"><i class="far fa-clock"></i> <?=translate('start_time')?></span> : <span class="text-dark"><?php echo date("h:i A", strtotime($row['start_time'])); ?></span> </label><br>
		<label><span class="text-weight-semibold"><i class="far fa-clock"></i> <?=translate('end_time')?></span> : <span class="text-dark"><?php echo date("h:i A", strtotime($row['end_time'])); ?></span> </label><br>
		<label><span class="text-weight-semibold"><i class="far fa-user-circle"></i> <?=translate('host') . " " . translate('by')?></span> : <span class="text-dark"><?=$row['staffname']?></span></label><br>
		<label><span class="text-weight-semibold"> <?=translate('status')?></span> : <?php  
								$status = '<i class="far fa-clock"></i> ' . translate('waiting');
								$labelmode = 'label-info-custom';
								if (strtotime($row['date']) == strtotime(date("Y-m-d")) && strtotime($row['start_time']) <= time() && time() >= strtotime(date("h:i"))) {
									$status = '<i class="fas fa-video"></i> ' . translate('live');
									$labelmode = 'label-success-custom';
								}
								if (strtotime($row['date']) < strtotime(date("Y-m-d")) || strtotime($row['end_time']) <= time()) {
									$status = '<i class="far fa-check-square"></i> ' . translate('expired');
									$labelmode = 'label-danger-custom';
								}
								echo "<span class='label " . $labelmode . " '>" . $status . "</span>";
								?></label><br>
<?php if ($row['live_class_method'] == 1 && $getConfig['student_api_credential'] ) {
	if (empty($row['bbb'])) {
		$joinURL = "#";
	} else {
		$joinURL = json_decode($row['bbb'])->join_url;
	}
?>
		<a href="<?=$joinURL?>" class="joinbtn btn btn-default mt-md mb-md"><i class="fas fa-video"></i> <?=translate('join_live_class')?></a>
<?php } else { ?>
		<a href="<?=base_url('userrole/livejoin?meeting_id=' . $row['meeting_id'] . "&live_id=" . $row['id'])?>" class="joinbtn btn btn-default mt-md mb-md"><i class="fas fa-video"></i> <?=translate('join_live_class')?></a>
<?php } ?>
	</div>
</div>

<script type="text/javascript">
    $('a.joinbtn').on('click', function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        var live_id = <?php echo $row['id']; ?>;
        $.ajax({
            url: "<?php echo site_url("userrole/live_atten") ?>",
            type: "POST",
            data: {"live_id": live_id},
            dataType: 'json',
            success: function (res)
            {
                if (res.status == 1) {
                    window.open(url, "_self");
                }
            },
            complete: function () {
            }
        });
    });
</script>