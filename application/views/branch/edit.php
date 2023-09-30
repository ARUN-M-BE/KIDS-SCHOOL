<section class="panel">
	<div class="tabs-custom">
		<ul class="nav nav-tabs">
			<li>
				<a href="<?=base_url('branch')?>"><i class="fas fa-list-ul"></i> <?=translate('branch_list')?></a>
			</li>
			<li class="active">
				<a href="#edit" data-toggle="tab"><i class="far fa-edit"></i> <?=translate('edit_branch')?></a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="edit">
				<?php echo form_open_multipart($this->uri->uri_string(), array('class' => 'form-horizontal form-bordered validate')); ?>
					<input type="hidden" name="branch_id" id="branch_id" value="<?php echo $data->id; ?>">
					<div class="form-group mt-md">
						<label class="col-md-3 control-label"><?=translate('branch_name')?> <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="branch_name" value="<?=set_value('branch_name', $data->name)?>" />
							<span class="error"><?=form_error('branch_name') ?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"><?=translate('school_name')?> <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="school_name" value="<?=set_value('school_name', $data->school_name)?>" />
							<span class="error"><?=form_error('school_name') ?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"><?=translate('email')?> <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="email" value="<?=set_value('email', $data->email)?>"  />
							<span class="error"><?=form_error('email') ?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"><?=translate('mobile_no')?> <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="mobileno" value="<?=set_value('mobileno', $data->mobileno)?>" />
							<span class="error"><?=form_error('mobileno') ?></span>
						</div>
					</div>
					<div class="form-group">
						<label  class="col-md-3 control-label"><?=translate('currency')?> <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="currency" value="<?=set_value('currency', $data->currency)?>" />
							<span class="error"><?=form_error('currency') ?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"><?=translate('currency_symbol')?> <span class="required">*</span></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="currency_symbol" value="<?=set_value('currency_symbol', $data->symbol)?>" />
							<span class="error"><?=form_error('currency_symbol') ?></span>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"><?=translate('city')?></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="city" value="<?=set_value('city', $data->city)?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label"><?=translate('state')?></label>
						<div class="col-md-6">
							<input type="text" class="form-control" name="state" value="<?=set_value('state', $data->state)?>">
						</div>
					</div>
					<div class="form-group">
						<label  class="col-md-3 control-label"><?=translate('address')?></label>
						<div class="col-md-6">
							<textarea type="text" rows="3" class="form-control" name="address" ><?=set_value('address', $data->address)?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-3 col-md-3">
							<label class="control-label pt-none"><?=translate('system_logo');?></label>
							<input type="file" name="logo_file" class="dropify" data-allowed-file-extensions="png" data-default-file="<?=$this->application_model->getBranchImage($data->id, 'logo')?>" />
						</div>
						<div class="col-md-3 mb-md">
							<label class="control-label pt-none"><?=translate('text_logo');?></label>
							<input type="file" name="text_logo" class="dropify" data-allowed-file-extensions="png" data-default-file="<?=$this->application_model->getBranchImage($data->id, 'logo-small')?>" />
						</div>
					</div>
					<div class="form-group">
						<div class="col-md-offset-3 col-md-3">
							<label class="control-label pt-none"><?=translate('printing_logo');?></label>
							<input type="file" name="print_file" class="dropify" data-allowed-file-extensions="png" data-default-file="<?=$this->application_model->getBranchImage($data->id, 'printing-logo')?>" />
						</div>
						<div class="col-md-3 mb-md">
							<label class="control-label pt-none"><?=translate('report_card');?></label>
							<input type="file" name="report_card" class="dropify" data-allowed-file-extensions="png" data-default-file="<?=$this->application_model->getBranchImage($data->id, 'report-card-logo')?>" />
						</div>
					</div>
					<footer class="panel-footer mt-lg">
						<div class="row">
							<div class="col-md-2 col-md-offset-3">
								<button type="submit" class="btn btn-default btn-block" name="submit" value="save">
									<i class="fas fa-plus-circle"></i> <?=translate('update')?>
								</button>
							</div>
						</div>	
					</footer>
				<?php echo form_close();?>
			</div>
		</div>
	</div>
</section>