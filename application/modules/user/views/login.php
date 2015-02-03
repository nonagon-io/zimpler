<?php

$identity['class'] = 'uk-form-large uk-width-1-2';
$identity['placeholder'] = lang('login_identity_label');
$password['class'] = 'uk-form-large uk-width-1-2';
$password['placeholder'] = lang('login_password_label');
	
?>
<section class="n-content" ng-app="login" ng-controller="LoginController">
	
	<div class="n-login-front uk-form">
		<div class="uk-panel uk-panel-box uk-container-center uk-width-large-1-2 uk-width-medium-2-3 uk-width-1-1 uk-text-center">
			<?php echo form_open("user/login");?>
			
			<div class="uk-text-center">
				<img src="<?php echo base_url('assets/images/logo.png') ?>" style="width:50px" />
			</div>

			<h1><?php echo lang('login_heading');?></h1>
			<div class="n-login-general">
				<div>
					<?php echo form_input($identity);?>
				</div>
				<div class="uk-margin-small-top">
					<?php echo form_input($password);?>
				</div>
				<div>
					<span class="uk-display-inline-block" style="margin-top: 10px;">
						<?php echo lang('login_remember_label', 'remember');?>
						<?php echo form_checkbox('remember', '1', FALSE, 'id="remember" style="margin-top: -2px;"');?>
					</span>
				</div>
				<button type="submit" name="submit"
						class="uk-button uk-button-success uk-button-large uk-margin-top">
					<?= lang('login_submit_btn') ?>
				</button>
			</div>
			
			<?php if($message) : ?>
			<div id="infoMessage" class="uk-alert uk-alert-warning"><?php echo $message;?></div>
			<?php endif ?>

			<?php if($this->config->item("allow_signup", "zimpler")) : ?>
			<p>
				<i class="uk-icon-edit uk-icon-small uk-text-primary"></i>
				<a href="signup"><b><?php echo lang('login_signup');?></b></a>
				|
				<a href="forgot_password"><?php echo lang('login_forgot_password');?></a>
			</p>
			<?php endif ?>
			
			<p class="uk-text-muted uk-margin-large-top">
				Powered by <a href="https://www.github.com/nonagon-x/zimpler" target="zimpler">Zimpler</a> - 
				The Micro CMS
			</p>
			
			<?php echo form_close();?>
			
		</div>
	</div>
</section>