<?php $zoom_version = '2.6.0'; ?>
<!DOCTYPE html>
    <head>
        <title>School Live Class</title>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.css');?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/vendor/font-awesome/css/all.min.css');?>">
        <link type="text/css" rel="stylesheet" href='<?php echo is_secure("source.zoom.us/$zoom_version/css/react-select.css");?>' />
        <meta name="format-detection" content="telephone=no">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    </head>
    <body oncontextmenu="return false;">
        <style type="text/css">
            body {
                padding-top: 50px;
            }
            .navbar-inverse {
                background-color: #313131;
                border-color: #404142;
            }
            .navbar-header h4 {
                margin: 0;
                padding: 15px 15px;
                color: #c4c2c2;
            }
            .navbar-right h5 {
                margin: 0;
                padding: 9px 5px;
                color: #c4c2c2;
            }
            .navbar-inverse .navbar-collapse, .navbar-inverse .navbar-form{
                border-color: transparent;
            }
        </style>
        <?php 
            $getStaff = $this->app_lib->get_table('staff', get_loggedin_user_id(), true);
            $meetingID = $this->input->get('meeting_id', true);
            $liveID = $this->input->get('live_id', true);
            $this->db->where('id', $liveID);
            $this->db->where('meeting_id', $meetingID);
            $liveClass = $this->db->get('live_class')->row_array();
            if (!is_array($liveClass)) {
                access_denied();
            }
            $config = $this->db->where('branch_id', $liveClass['branch_id'])->get('live_class_config')->row_array();
            $zoom_api_key = $config['zoom_api_key'];
            $zoom_api_secret = $config['zoom_api_secret'];
            if ($liveClass['own_api_key'] == 1) {
                $getSelfAPI = $this->live_class_model->get('zoom_own_api', array('user_type' => 1, 'user_id' => $liveClass['created_by']), true);
                if ($getSelfAPI['zoom_api_key'] == '' || $getSelfAPI['zoom_api_secret'] == '') {
                    set_alert('error', "You created by your own zoom account, API Credential is missing.");
                    redirect(base_url('live_class'));
                } else {
                    $zoom_api_key = $getSelfAPI['zoom_api_key'];
                    $zoom_api_secret = $getSelfAPI['zoom_api_secret'];
                }
            }
        ?>
        <nav id="nav-tool" class="navbar navbar-inverse navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <h4><i class="fab fa-chromecast"></i> Live Class Title : <?=$liveClass['title']?></h4>
                </div>
                <div class="navbar-form navbar-right">
                    <h5><i class="far fa-user-circle" style=""></i> Host By : <?=get_type_name_by_id('staff', $liveClass['created_by'])?></h5>
                </div>
            </div>
        </nav>
        <script src="https://source.zoom.us/<?=$zoom_version; ?>/lib/vendor/react.min.js"></script>
        <script src="https://source.zoom.us/<?=$zoom_version; ?>/lib/vendor/react-dom.min.js"></script>
        <script src="https://source.zoom.us/<?=$zoom_version; ?>/lib/vendor/redux.min.js"></script>
        <script src="https://source.zoom.us/<?=$zoom_version; ?>/lib/vendor/redux-thunk.min.js"></script>
        <script src="https://source.zoom.us/<?=$zoom_version; ?>/lib/vendor/lodash.min.js"></script>
        <script src="https://source.zoom.us/zoom-meeting-<?=$zoom_version; ?>.min.js"></script>
        <script src="<?php echo base_url('assets/vendor/jquery/jquery.min.js');?>"></script>
        <script type="text/javascript">
            document.onkeydown = function(e) {
				if(event.keyCode == 123) {
					return false;
				}
				if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
					return false;
				}
				if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
					return false;
				}
				if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
					return false;
				}
				if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
					return false;
				}
            }

            ZoomMtg.preLoadWasm();
            ZoomMtg.prepareJssdk();
            var meetConfig = {
                apiKey: "<?=$zoom_api_key?>",
                apiSecret: "<?=$zoom_api_secret?>",
                meetingNumber: "<?=$meetingID?>",
                userName: "<?=$getStaff['name']?>",
                passWord: "<?=$liveClass['meeting_password']?>",
                leaveUrl: "<?php echo base_url('live_class');?>",
                role: parseInt(1, 10)
            };
            var signature = ZoomMtg.generateSignature({
                meetingNumber: meetConfig.meetingNumber,
                apiKey: meetConfig.apiKey,
                apiSecret: meetConfig.apiSecret,
                role: meetConfig.role,
                success: function(res){
                    console.log(res.result);
                }
            });
            ZoomMtg.i18n.load("en-US");
            ZoomMtg.init({
                leaveUrl: meetConfig.leaveUrl,
                isSupportAV: true,
                success: function () {
                    ZoomMtg.i18n.load("en-US");
                    ZoomMtg.join({
                        meetingNumber: meetConfig.meetingNumber,
                        userName: meetConfig.userName,
                        signature: signature,
                        apiKey: meetConfig.apiKey,
                        passWord: meetConfig.passWord,
                        success: function(res){
                            $('#nav-tool').hide();
                            console.log(res);
                        },
                        error: function(res) {
                            console.log(res);
                        }
                    });
                },
                error: function(res) {
                    console.log(res);
                }
            });
        </script>
    </body>
</html>
