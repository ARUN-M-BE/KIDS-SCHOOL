<!-- Main Banner Starts -->
<div class="main-banner" style="background: url(<?php echo base_url('uploads/frontend/banners/' . $page_data['banner_image']); ?>) center top;">
    <div class="container px-md-0">
        <h2><span><?php echo $page_data['page_title']; ?></span></h2>
    </div>
</div>
<div class="breadcrumb">
    <div class="container px-md-0">
        <ul class="list-unstyled list-inline">
            <li class="list-inline-item"><a href="<?php echo base_url('home') ?>">Home</a></li>
            <li class="list-inline-item active"><?php echo $page_data['page_title']; ?></li>
        </ul>
    </div>
</div>
<div class="container px-md-0 main-container">
    <!-- Contact Info Section Starts -->
    <div class="contact-info-box">
        <!-- Nested Row Starts -->
        <div class="row">
            <div class="col-md-5 col-sm-12 d-none d-md-block">
                <div class="box-img">
                    <img src="<?php echo base_url('uploads/frontend/images/' . $page_data['box_image']); ?>" alt="Image" />
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="info-box">
                    <h3><?php echo $page_data['box_title']; ?></h3>
                    <h5><?php echo nl2br($page_data['box_description']); ?></h5>
                </div>
            </div>
            <div class="col-md-1 col-sm-12 d-none d-md-block"></div>
        </div>
        <!-- Nested Row Ends -->
    </div>
    <div class="contact-content">
        <!-- Nested Row Starts -->
        <div class="row">
            <!-- Contact Form Starts -->
            <div class="col-md-8 col-sm-12">
                <h3><?php echo $page_data['form_title']; ?></h3>
                <?php if($this->session->flashdata('msg_success')): ?>
                <div class="alert alert-success">
                    <i class="icon-text-ml far fa-check-circle"></i> <?php echo $this->session->flashdata('msg_success'); ?>
                </div>
                <?php endif; ?>
                <?php if($this->session->flashdata('msg_error')): ?>
                <div class="alert alert-danger">
                    <?php echo $this->session->flashdata('msg_error'); ?>
                </div>
                <?php endif; ?>
                <?php echo form_open($this->uri->uri_string(), array('class' => 'form-horizontal contact-form')); ?>
                    <div class="row">
                        <!-- Name Field Starts -->
                    <form action="postToGooggleSheet.php" method="post">
<lable>Full Name:</label>
<input name="name" type="text" />
<br/>
<lable>Email:</label>
<input name="email" type="email" />
<br/>
<lable>Phone:</label>
<input name="phone" type="tel" />
<br/>
<lable>Message:</label>
<textarea name="message"></textarea>

<button type="submit" name="submit">Submit</button>
</form> 
                        <?php if ($cms_setting['captcha_status'] == 'enable'): ?>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <?php echo $recaptcha['widget']; echo $recaptcha['script']; ?>
                                <span class="text-danger"><?php echo form_error('g-recaptcha-response'); ?></span>
                            </div>
                        </div>
                        <?php endif; ?>
                        <!-- Message Field Ends -->
                        <div class="col-sm-12">
                            <button type="submit" name="new_patient" value="1"
                                class="btn btn-black"><?php echo $page_data['submit_text']; ?></button>
                        </div>
                    </div>
                <?php echo form_close(); ?>
            </div>
            <div class="w-100 d-block d-md-none">
                <p>&nbsp;</p>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="cblock-1">
                    <span class="icon-wrap"><i class="fas fa-map-marker-alt"></i></span>
                    <h4>Address</h4>
                    <p><?php echo nl2br($page_data['address']); ?></p>
                </div>

                <div class="cblock-1">
                    <span class="icon-wrap"><i class="fas fa-phone"></i></span>
                    <h4>Phone</h4>
                    <p><?php echo nl2br($page_data['phone']); ?></p>
                </div>
                <div class="cblock-1">
                    <span class="icon-wrap"><i class="far fa-envelope"></i></span>
                    <h4>Email</h4>
                    <p><?php echo nl2br($page_data['email']); ?></p>
                </div>
            </div>
            <!-- Address Ends -->
        </div>
        <!-- Nested Row Ends -->
    </div>
    <!-- Contact Content Ends -->
</div>
<!--Map Start-->
<div class="map">
    <iframe width="100%" height="350" id="gmap_canvas" src="<?php echo $page_data['map_iframe']; ?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0"></iframe>
</div>
<!--Map End-->