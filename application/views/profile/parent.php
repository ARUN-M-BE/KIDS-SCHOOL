<?php
$widget = (is_superadmin_loggedin() ? 3 : 4);
?>
<div class="row appear-animation" data-appear-animation="<?=$global_config['animations'] ?>">
	<div class="col-md-12 mb-lg">
		<div class="profile-head social">
			<div class="col-md-12 col-lg-4 col-xl-3">
				<div class="image-content-center user-pro">
					<div class="preview">
						<ul class="social-icon-one">
							<li><a href="<?=empty($parent['facebook_url']) ? '#' : $parent['facebook_url']?>"><span class="fab fa-facebook-f"></span></a></li>
							<li><a href="<?=empty($parent['twitter_url']) ? '#' : $parent['twitter_url']?>"><span class="fab fa-twitter"></span></a></li>
							<li><a href="<?=empty($parent['linkedin_url']) ? '#' : $parent['linkedin_url']?>"><span class="fab fa-linkedin-in"></span></a></li>
						</ul>
						<img src="<?=get_image_url('parent', $parent['photo'])?>">
					</div>
				</div>
			</div>
			<div class="col-md-12 col-lg-5 col-xl-5">
				<h5><?=html_escape($parent['name'])?></h5>
				<p><?=ucfirst('parent')?></p>
				<ul>
					<li><div class="icon-holder" data-toggle="tooltip" data-original-title="<?=translate('relation')?>"><i class="fas fa-bezier-curve"></i></div> <?=html_escape($parent['relation'])?></li>
					<li><div class="icon-holder" data-toggle="tooltip" data-original-title="<?=translate('occupation')?>"><i class="fas fa-user-tag"></i></div> <?=html_escape(empty($parent['occupation']) ? 'N/A' : $parent['occupation']);?></li>
					<li><div class="icon-holder" data-toggle="tooltip" data-original-title="<?=translate('income')?>"><i class="fas fa-dollar-sign"></i></div> <?=html_escape(empty($parent['income']) ? 'N/A' : $parent['income']);?></li>
					<li><div class="icon-holder" data-toggle="tooltip" data-original-title="<?=translate('mobile_no')?>"><i class="fas fa-phone"></i></div> <?=html_escape(empty($parent['mobileno']) ? 'N/A' : $parent['mobileno']);?></li>
					<li><div class="icon-holder" data-toggle="tooltip" data-original-title="<?=translate('email')?>"><i class="far fa-envelope"></i></div> <?=html_escape(!empty($parent['email']) ? $parent['email'] : 'N/A')?></li>
					<li><div class="icon-holder" data-toggle="tooltip" data-original-title="<?=translate('address')?>"><i class="fas fa-home"></i></div> <?=html_escape(!empty($parent['address']) ? $parent['address'] : 'N/A'); ?></li>
				</ul>
			</div>
		</div>
	</div>

	<div class="col-md-12">
		<section class="panel">
			<header class="panel-heading">
				<h4 class="panel-title"><i class="far fa-edit"></i> <?php echo translate('profile'); ?></h4>
			</header>
            <?php echo form_open_multipart($this->uri->uri_string()); ?>
				<div class="panel-body">
					<fieldset>
						<input type="hidden" name="parent_id" value="<?php echo $parent['id']; ?>" id="parent_id">
						<!-- parents details -->
						<div class="headers-line mt-md">
							<i class="fas fa-user-check"></i> <?=translate('parents_details')?>
						</div>
						<div class="row">
							<div class="col-md-6 mb-sm">
								<div class="form-group">
									<label class="control-label"><?=translate('name')?> <span class="required">*</span></label>
									<div class="input-group">
										<span class="input-group-addon"><i class="far fa-user"></i></span>
										<input class="form-control" name="name" type="text" value="<?=set_value('name', $parent['name'])?>" autocomplete="off" />
									</div>
									<span class="error"><?php echo form_error('name'); ?></span>
								</div>
							</div>
							<div class="col-md-6 mb-sm">
								<div class="form-group">
									<label class="control-label"><?=translate('relation')?> <span class="required">*</span></label>
									<input type="text" class="form-control" name="relation" value="<?=set_value('relation', $parent['relation'])?>" autocomplete="off" />
									<span class="error"><?php echo form_error('relation'); ?></span>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 mb-sm">
								<div class="form-group">
									<label class="control-label"><?=translate('father_name')?></label>
									<input class="form-control" name="father_name" type="text" value="<?=set_value('father_name', $parent['father_name'])?>" autocomplete="off" />
								</div>
							</div>
							<div class="col-md-6 mb-sm">
								<div class="form-group">
									<label class="control-label"><?=translate('mother_name')?></label>
									<input type="text" class="form-control" name="mother_name" value="<?=set_value('mother_name', $parent['mother_name'])?>" autocomplete="off" />
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-4 mb-sm">
								<div class="form-group">
									<label class="control-label"><?=translate('occupation')?> <span class="required">*</span></label>
									<input type="text" class="form-control" name="occupation" value="<?=set_value('occupation', $parent['occupation'])?>" autocomplete="off" />
									<span class="error"><?php echo form_error('occupation'); ?></span>
								</div>
							</div>
							<div class="col-md-4 mb-sm">
								<div class="form-group">
									<label class="control-label"><?=translate('income')?></label>
									<input type="text" class="form-control" name="income" value="<?=set_value('income', $parent['income'])?>" autocomplete="off" />
									<span class="error"><?php echo form_error('income'); ?></span>
								</div>
							</div>
							<div class="col-md-4 mb-sm">
								<div class="form-group">
									<label class="control-label"><?=translate('education')?></label>
									<input type="text" class="form-control" name="education" value="<?=set_value('education', $parent['education'])?>" autocomplete="off" />
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-3 mb-sm">
								<div class="form-group">
									<label class="control-label"><?=translate('city')?></label>
									<input type="text" class="form-control" name="city" value="<?=set_value('city', $parent['city'])?>" autocomplete="off" />
								</div>
							</div>
							<div class="col-md-3 mb-sm">
								<div class="form-group">
									<label class="control-label"><?=translate('state')?></label>
									<input type="text" class="form-control" name="state" value="<?=set_value('state', $parent['state'])?>" autocomplete="off" />
								</div>
							</div>
							<div class="col-md-3 mb-sm">
								<div class="form-group">
									<label class="control-label"><?=translate('mobile_no')?> <span class="required">*</span></label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fas fa-phone-volume"></i></span>
										<input type="text" class="form-control" name="mobileno" value="<?=set_value('mobileno', $parent['mobileno'])?>" autocomplete="off" />
									</div>
									<span class="error"><?php echo form_error('mobileno'); ?></span>
								</div>
							</div>
							<div class="col-md-3 mb-sm">
								<div class="form-group">
									<label class="control-label"><?=translate('email')?></label>
									<div class="input-group">
										<span class="input-group-addon"><i class="far fa-envelope-open"></i></span>
										<input type="email" class="form-control" name="email" id="email" value="<?=set_value('email', $parent['email'])?>" />
									</div>
									<span class="error"><?php echo form_error('email'); ?></span>
								</div>
							</div>
						</div>
						<div class="row mb-md">
							<div class="col-md-12 mb-sm">
								<div class="form-group">
									<label class="control-label"><?=translate('address')?></label>
									<textarea name="address" rows="2" class="form-control" aria-required="true"><?=set_value('address', $parent['address'])?></textarea>
								</div>
							</div>
						</div>
						<div class="row mb-md">
							<div class="col-md-12 mb-lg">
								<div class="form-group">
									<label class="control-label"><?=translate('profile_picture')?> <span class="required">*</span></label>
									<input type="file" name="user_photo" class="dropify" data-default-file="<?=get_image_url('parent', $parent['photo'])?>" />
								</div>
								<span class="error"><?php echo form_error('user_photo'); ?></span>
							</div>
							<input type="hidden" name="old_user_photo" value="<?=html_escape($parent['photo'])?>">
						</div>
						
						<!-- social links -->
						<div class="headers-line">
							<i class="fas fa-globe"></i> <?=translate('social_links')?>
						</div>

						<div class="row mb-md">
							<div class="col-md-4 mb-xs">
								<div class="form-group">
									<label class="control-label">Facebook</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fab fa-facebook-f"></i></span>
										<input type="text" class="form-control" name="facebook" placeholder="eg: https://www.facebook.com/username" value="<?=set_value('facebook', $parent['facebook_url'])?>" />
									</div>
									<span class="error"><?php echo form_error('facebook'); ?></span>
								</div>
							</div>
							<div class="col-md-4 mb-xs">
								<div class="form-group">
									<label class="control-label">Twitter</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fab fa-twitter"></i></span>
										<input type="text" class="form-control" name="twitter" placeholder="eg: https://www.twitter.com/username" value="<?=set_value('twitter', $parent['twitter_url'])?>" />
									</div>
									<span class="error"><?php echo form_error('twitter'); ?></span>
								</div>
							</div>
							<div class="col-md-4 mb-xs">
								<div class="form-group">
									<label class="control-label">Linkedin</label>
									<div class="input-group">
										<span class="input-group-addon"><i class="fab fa-linkedin-in"></i></span>
										<input type="text" class="form-control" name="linkedin" placeholder="eg: https://www.linkedin.com/username" value="<?=set_value('linkedin', $parent['linkedin_url'])?>" />
									</div>
									<span class="error"><?php echo form_error('linkedin'); ?></span>
								</div>
							</div>
						</div>
					</fieldset>
				</div>
				<div class="panel-footer">
					<div class="row">
						<div class="col-md-offset-9 col-md-3">
							<button class="btn btn-default btn-block" type="submit"><i class="fas fa-plus-circle"></i> <?php echo translate('update'); ?></button>
						</div>	
					</div>
				</div>
			<?php echo form_close(); ?>
		</section>
	</div>
</div>
