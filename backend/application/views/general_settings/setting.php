<link rel="stylesheet" href="<?= base_url() ?>public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<style>
.nav-pills>li.active>a, .nav-pills>li.active>a:focus, .nav-pills>li.active>a:hover {
    color: #fff;
    background-color: #337ab7;
}
.nav-pills>li>a {
    border-radius: 0;
    border-top: 3px solid transparent;
    color: #fff;
  
}
.nav-pills>li> .d {
    border-radius: 0;
    border-top: 3px solid transparent;
    color: #fff;
   background-color: #3395ff;
}
.nav>li>a {
    position: relative;
    display: block;
    padding: 10px 15px;
}



.navbar-toggle {
    color: #fff;
    border: 0;
    margin: 0;
    padding: 15px 15px
}

@media (max-width: 991px) {
    .navbar-custom-menu .navbar-nav>li {
        float:left
    }

    .navbar-custom-menu .navbar-nav {
        margin: 0;
        float: left
    }

    .navbar-custom-menu .navbar-nav>li>a {
        padding-top: 15px;
        padding-bottom: 15px;
        line-height: 20px
    }
}

@media (max-width: 767px) {
    .main-header {
        position:relative
    }

    .main-header .logo,.main-header .navbar {
        width: 100%;
        float: none
    }

    .main-header .navbar {
        margin: 0
    }

    .main-header .navbar-custom-menu {
        float: right
    }
}

@media (max-width: 991px) {
    .navbar-collapse.pull-left {
        float:none !important
    }

    .navbar-collapse.pull-left+.navbar-custom-menu {
        display: block;
        position: absolute;
        top: 0;
        right: 40px
    }
}



.navbar-nav>.notifications-menu>.dropdown-menu,.navbar-nav>.messages-menu>.dropdown-menu,.navbar-nav>.tasks-menu>.dropdown-menu {
    width: 280px;
    padding: 0 0 0 0;
    margin: 0;
    top: 100%
}

.navbar-nav>.notifications-menu>.dropdown-menu>li,.navbar-nav>.messages-menu>.dropdown-menu>li,.navbar-nav>.tasks-menu>.dropdown-menu>li {
    position: relative
}

.navbar-nav>.notifications-menu>.dropdown-menu>li.header,.navbar-nav>.messages-menu>.dropdown-menu>li.header,.navbar-nav>.tasks-menu>.dropdown-menu>li.header {
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
    border-bottom-right-radius: 0;
    border-bottom-left-radius: 0;
    background-color: #ffffff;
    padding: 7px 10px;
    border-bottom: 1px solid #f4f4f4;
    color: #444444;
    font-size: 14px
}

.navbar-nav>.notifications-menu>.dropdown-menu>li.footer>a,.navbar-nav>.messages-menu>.dropdown-menu>li.footer>a,.navbar-nav>.tasks-menu>.dropdown-menu>li.footer>a {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    border-bottom-right-radius: 4px;
    border-bottom-left-radius: 4px;
    font-size: 12px;
    background-color: #fff;
    padding: 7px 10px;
    border-bottom: 1px solid #eeeeee;
    color: #444 !important;
    text-align: center
}

@media (max-width: 991px) {
    .navbar-nav>.notifications-menu>.dropdown-menu>li.footer>a,.navbar-nav>.messages-menu>.dropdown-menu>li.footer>a,.navbar-nav>.tasks-menu>.dropdown-menu>li.footer>a {
        background:#fff !important;
        color: #444 !important
    }
}

.navbar-nav>.notifications-menu>.dropdown-menu>li.footer>a:hover,.navbar-nav>.messages-menu>.dropdown-menu>li.footer>a:hover,.navbar-nav>.tasks-menu>.dropdown-menu>li.footer>a:hover {
    text-decoration: none;
    font-weight: normal
}

.navbar-nav>.notifications-menu>.dropdown-menu>li .menu,.navbar-nav>.messages-menu>.dropdown-menu>li .menu,.navbar-nav>.tasks-menu>.dropdown-menu>li .menu {
    max-height: 200px;
    margin: 0;
    padding: 0;
    list-style: none;
    overflow-x: hidden
}

.navbar-nav>.notifications-menu>.dropdown-menu>li .menu>li>a,.navbar-nav>.messages-menu>.dropdown-menu>li .menu>li>a,.navbar-nav>.tasks-menu>.dropdown-menu>li .menu>li>a {
    display: block;
    white-space: nowrap;
    border-bottom: 1px solid #f4f4f4
}

.navbar-nav>.notifications-menu>.dropdown-menu>li .menu>li>a:hover,.navbar-nav>.messages-menu>.dropdown-menu>li .menu>li>a:hover,.navbar-nav>.tasks-menu>.dropdown-menu>li .menu>li>a:hover {
    background: #f4f4f4;
    text-decoration: none
}

.navbar-nav>.notifications-menu>.dropdown-menu>li .menu>li>a {
    color: #444444;
    overflow: hidden;
    text-overflow: ellipsis;
    padding: 10px
}

.navbar-nav>.notifications-menu>.dropdown-menu>li .menu>li>a>.glyphicon,.navbar-nav>.notifications-menu>.dropdown-menu>li .menu>li>a>.fa,.navbar-nav>.notifications-menu>.dropdown-menu>li .menu>li>a>.ion {
    width: 20px
}

.navbar-nav>.messages-menu>.dropdown-menu>li .menu>li>a {
    margin: 0;
    padding: 10px 10px
}

.navbar-nav>.messages-menu>.dropdown-menu>li .menu>li>a>div>img {
    margin: auto 10px auto auto;
    width: 40px;
    height: 40px
}

.navbar-nav>.messages-menu>.dropdown-menu>li .menu>li>a>h4 {
    padding: 0;
    margin: 0 0 0 45px;
    color: #444444;
    font-size: 15px;
    position: relative
}

.navbar-nav>.messages-menu>.dropdown-menu>li .menu>li>a>h4>small {
    color: #999999;
    font-size: 10px;
    position: absolute;
    top: 0;
    right: 0
}

.navbar-nav>.messages-menu>.dropdown-menu>li .menu>li>a>p {
    margin: 0 0 0 45px;
    font-size: 12px;
    color: #888888
}

.navbar-nav>.messages-menu>.dropdown-menu>li .menu>li>a:before,.navbar-nav>.messages-menu>.dropdown-menu>li .menu>li>a:after {
    content: " ";
    display: table
}

.navbar-nav>.messages-menu>.dropdown-menu>li .menu>li>a:after {
    clear: both
}

.navbar-nav>.tasks-menu>.dropdown-menu>li .menu>li>a {
    padding: 10px
}

.navbar-nav>.tasks-menu>.dropdown-menu>li .menu>li>a>h3 {
    font-size: 14px;
    padding: 0;
    margin: 0 0 10px 0;
    color: #666666
}

.navbar-nav>.tasks-menu>.dropdown-menu>li .menu>li>a>.progress {
    padding: 0;
    margin: 0
}

.navbar-nav>.user-menu>.dropdown-menu {
    border-top-right-radius: 0;
    border-top-left-radius: 0;
    padding: 1px 0 0 0;
    border-top-width: 0;
    width: 280px
}

.navbar-nav>.user-menu>.dropdown-menu,.navbar-nav>.user-menu>.dropdown-menu>.user-body {
    border-bottom-right-radius: 4px;
    border-bottom-left-radius: 4px
}

.navbar-nav>.user-menu>.dropdown-menu>li.user-header {
    height: 175px;
    padding: 10px;
    text-align: center
}

.navbar-nav>.user-menu>.dropdown-menu>li.user-header>img {
    z-index: 5;
    height: 90px;
    width: 90px;
    border: 3px solid;
    border-color: transparent;
    border-color: rgba(255,255,255,0.2)
}

.navbar-nav>.user-menu>.dropdown-menu>li.user-header>p {
    z-index: 5;
    color: #fff;
    color: rgba(255,255,255,0.8);
    font-size: 17px;
    margin-top: 10px
}

.navbar-nav>.user-menu>.dropdown-menu>li.user-header>p>small {
    display: block;
    font-size: 12px
}

.navbar-nav>.user-menu>.dropdown-menu>.user-body {
    padding: 15px;
    border-bottom: 1px solid #f4f4f4;
    border-top: 1px solid #dddddd
}

.navbar-nav>.user-menu>.dropdown-menu>.user-body:before,.navbar-nav>.user-menu>.dropdown-menu>.user-body:after {
    content: " ";
    display: table
}

.navbar-nav>.user-menu>.dropdown-menu>.user-body:after {
    clear: both
}

.navbar-nav>.user-menu>.dropdown-menu>.user-body a {
    color: #444 !important
}

@media (max-width: 991px) {
    .navbar-nav>.user-menu>.dropdown-menu>.user-body a {
        background:#fff !important;
        color: #444 !important
    }
}

.navbar-nav>.user-menu>.dropdown-menu>.user-footer {
    background-color: #f9f9f9;
    padding: 10px
}

.navbar-nav>.user-menu>.dropdown-menu>.user-footer:before,.navbar-nav>.user-menu>.dropdown-menu>.user-footer:after {
    content: " ";
    display: table
}

.navbar-nav>.user-menu>.dropdown-menu>.user-footer:after {
    clear: both
}

.navbar-nav>.user-menu>.dropdown-menu>.user-footer .btn-default {
    color: #666666
}

@media (max-width: 991px) {
    .navbar-nav>.user-menu>.dropdown-menu>.user-footer .btn-default:hover {
        background-color:#f9f9f9
    }
}

.navbar-nav>.user-menu .user-image {
    float: left;
    width: 25px;
    height: 25px;
    border-radius: 50%;
    margin-right: 10px;
    margin-top: -2px
}

@media (max-width: 767px) {
    .navbar-nav>.user-menu .user-image {
        float:none;
        margin-right: 0;
        margin-top: -8px;
        line-height: 10px
    }
}



.navbar-custom-menu>.navbar-nav>li {
    position: relative
}

.navbar-custom-menu>.navbar-nav>li>.dropdown-menu {
    position: absolute;
    right: 0;
    left: auto
}

@media (max-width: 991px) {
    .navbar-custom-menu>.navbar-nav {
        float:right
    }

    .navbar-custom-menu>.navbar-nav>li {
        position: static
    }

    .navbar-custom-menu>.navbar-nav>li>.dropdown-menu {
        position: absolute;
        right: 5%;
        left: auto;
        border: 1px solid #ddd;
        background: #fff
    }
}



.nav>li>a:hover,.nav>li>a:active,.nav>li>a:focus {
    color: #444;
    background: #f7f7f7
}

.nav-pills>li>a {
    border-radius: 0;
    border-top: 3px solid transparent;
    color: #444
}

.nav-pills>li>a>.fa,.nav-pills>li>a>.glyphicon,.nav-pills>li>a>.ion {
    margin-right: 5px
}

.nav-pills>li.active>a,.nav-pills>li.active>a:hover,.nav-pills>li.active>a:focus {
    border-top-color: #3c8dbc
}

.nav-pills>li.active>a {
    font-weight: 600
}

.nav-stacked>li>a {
    border-radius: 0;
    border-top: 0;
    border-left: 3px solid transparent;
    color: #444
}

.nav-stacked>li.active>a,.nav-stacked>li.active>a:hover {
    background: transparent;
    color: #444;
    border-top: 0;
    border-left-color: #3c8dbc
}

.nav-stacked>li.header {
    border-bottom: 1px solid #ddd;
    color: #777;
    margin-bottom: 10px;
    padding: 5px 10px;
    text-transform: uppercase
}



</style>
<section class="content" id="general_settings">
<?php
$label = "Edit";
$icon="<i class='fa fa-minus-square'></i>&nbsp; {$label}</i>";
	
	?>

<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="<?= base_url() ?>assets/wysihtml5/bootstrap3-wysihtml5.min.css">
<!-- Content Header (Page header) -->
<section class="content-header">
	<div class="container-fluid">
		<div class="row mb-2">
			<div class="col-sm-6">
				<h1>Email <?= $label ?>
				</h1>
			</div>
			<div class="col-sm-6">
				<ol class="breadcrumb float-sm-right">
					<li class="breadcrumb-item"><a href="<?= base_url() ?>">Email Templates</a></li>
					<li class="breadcrumb-item"><a href="<?= base_url('general_settings') ?>">Email Templates</a></li>
					<li class="breadcrumb-item active"><?= $label ?></li>
				</ol>
			</div>
		</div>
	</div><!-- /.container-fluid -->
</section>
<!-- Content Wrapper. Contains page content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
			 <div class="template-alert-block"></div>
				<div class="card card-primary">
					<div class="card-header">
						<h3 class="card-title font-weight-bold">
							<?= $icon ?>
						</h3>
					</div>
					<!-- Message -->
		
                					<div class="card-body append_place">
                						<div class="row">
                                           <div class="col-md-12">
                
                                                <?php echo form_open_multipart(base_url('general_settings/add')); ?>	
                                                <!-- Nav tabs -->
                                                <ul class="nav nav-pills" role="tablist">
                                                 <li role="presentation" class="active"><a href="#main" aria-controls="main" role="tab" data-toggle="tab">General Setting</a></li>
                                                 <li role="presentation"><a href="#email" aria-controls="email" role="tab" data-toggle="tab" class="d">Email Setting</a></li>
                                                 <!--<li role="presentation"><a href="#social" aria-controls="social" role="tab" data-toggle="tab">Social Media Setting</a></li>-->
                                                 <!--<li role="presentation"><a href="#reCAPTCHA" aria-controls="reCAPTCHA" role="tab" data-toggle="tab">Google reCAPTCHA</a></li>-->
                                               <!--  <li role="presentation"><a href="#payments" aria-controls="payments" role="tab" data-toggle="tab">Payment Settings</a></li> -->
                                               </ul>
                                               
                                               <!-- Tab panes -->
                                               <div class="tab-content">
                                            
                                                <!-- General Setting -->
                                                <div role="tabpanel" class="tab-pane active" id="main">
                                                 <div class="form-group">
                                                  <label class="control-label">Favicon (25*25)</label><br/>
                                                  <?php if(!empty($general_settings['favicon'])): ?>
                                                   <img src="<?= base_url($general_settings['favicon']); ?>" class="favicon">
                                                 <?php endif; ?>
                                                 <input type="file" name="favicon" accept=".png, .jpg, .jpeg, .gif, .svg">
                                                 <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p>
                                                 <input type="hidden" name="old_favicon" value="<?php echo html_escape($general_settings['favicon']); ?>">
                                               </div>
                                               <div class="form-group">
                                                 <label class="control-label">Logo</label><br/>
                                                 <?php if(!empty($general_settings['logo'])): ?>
                                                   <img src="<?= base_url($general_settings['logo']); ?>" class="logo" width="150">
                                                 <?php endif; ?>
                                                 <input type="file" name="logo" accept=".png, .jpg, .jpeg, .gif, .svg">
                                                 <p><small class="text-success">Allowed Types: gif, jpg, png, jpeg</small></p>
                                                 <input type="hidden" name="old_logo" value="<?php echo html_escape($general_settings['logo']); ?>">
                                               </div>
                                               <div class="form-group">
                                                <label class="control-label">Application Name</label>
                                                <input type="text" class="form-control" name="application_name" placeholder="application name" value="<?php echo html_escape($general_settings['application_name']); ?>">
                                              </div>
                                            
                                            
                                            
                                            </div>
                                            
                                            <!-- Email Setting -->
                                            <div role="tabpanel" class="tab-pane" id="email">
                                              <div class="form-group">
                                                <label class="control-label">Admin Email</label>
                                                <input type="text" class="form-control" name="admin_email" placeholder= "my-email@admin.com" value="<?php echo html_escape($general_settings['admin_email']); ?>">
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label">Email From/ Reply to</label>
                                                <input type="text" class="form-control" name="email_from" placeholder= "no-reply@domain.com" value="<?php echo html_escape($general_settings['email_from']); ?>">
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label">SMTP Host</label>
                                                <input type="text" class="form-control" name="smtp_host" placeholder="SMTP Host" value="<?php echo html_escape($general_settings['smtp_host']); ?>">
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label">SMTP Port</label>
                                                <input type="text" class="form-control" name="smtp_port" placeholder="SMTP Port" value="<?php echo html_escape($general_settings['smtp_port']); ?>">
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label">SMTP User</label>
                                                <input type="text" class="form-control" name="smtp_user" placeholder="SMTP Email" value="<?php echo html_escape($general_settings['smtp_user']); ?>">
                                              </div>
                                              <div class="form-group">
                                                <label class="control-label">SMTP Password</label>
                                                <input type="password" class="form-control" name="smtp_pass" placeholder="SMTP Password" value="<?php echo html_escape($general_settings['smtp_pass']); ?>">
                                              </div>
                                            </div>
                                            
                                            
                                            
                                            </div>
                                            
                                            <div class="box-footer">
                                              <input type="submit" name="submit" value="Save Changes" class="btn btn-info pull-right">
                                            </div>	
                                          <?php echo form_close(); ?>
                                     </div>       
                                </div>
                            </div>
                        </div>       
                    </div>
                </div>
        </div>
    </div>
</section>

<!-- Bootstrap WYSIHTML5 -->
<script src="<?= base_url() ?>public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<script>
  $("#setting").addClass('active');
  $('#myTabs a').click(function (e) {
   e.preventDefault()
   $(this).tab('show')
 })
</script>
