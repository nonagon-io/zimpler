<section class="n-content" ng-app="login" ng-controller="LoginController">
	<div class="n-login-front uk-form">
		<div class="uk-panel uk-panel-box uk-container-center uk-width-large-1-2 uk-width-medium-2-3 uk-width-1-1 uk-text-center">
			<?php 
				$attributes = array('name' => 'loginForm', 'novalidate' => '', 'ng-submit' => 'submit($event)');
				echo form_open("user/login", $attributes);
			?>
			
			<div class="uk-text-center">
				<img src="<?php echo base_url('assets/images/logo.png') ?>" style="width:50px" />
			</div>

			<h1><?php echo lang('login_heading');?></h1>
			<div class="n-login-general uk-width-1-2 uk-container-center">
				<div class="uk-form-row">
					<div class="uk-form-controls">
						<input type="text" class="uk-form-large uk-width-1-1"
							   id="identity" name="identity" ng-model="identity"
							   placeholder="<?= lang('login_identity_label') ?>"
							   ng-class="{'uk-form-danger': loginForm.identity.$error.required && loginForm.$submitted}"
							   ng-init="identity = '<?= $identity ?>'" required />
							   
						<i class="uk-icon-exclamation-circle uk-icon-small uk-text-danger" 
						   ng-if="loginForm.identity.$error.required && loginForm.$submitted"
						   title="<?= lang('required_error_username') ?>" data-uk-tooltip="{pos:'right'}"></i>
					</div>
				</div>
				<div class="uk-margin-small-top">
					<div class="uk-form-controls">
						<input type="text" class="uk-form-large uk-width-1-1"
							   name="password" ng-model="password"
							   placeholder="<?= lang('login_password_label') ?>"
							   ng-class="{'uk-form-danger': loginForm.password.$error.required && loginForm.$submitted}"
							   ng-init="password = '<?= $password ?>'" required />

						<i class="uk-icon-exclamation-circle uk-icon-small uk-text-danger" 
						   ng-if="loginForm.password.$error.required && loginForm.$submitted"
						   title="<?= lang('required_error_password') ?>" data-uk-tooltip="{pos:'right'}"></i>
					</div>
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
	
	<?php if(form_error('identity') || form_error('password')) : ?>
	<div ng-init="loginForm.$submitted = true"></div>
	<?php endif ?>
	
	<?php if(isset($message) && $message) : ?>
	<div ng-init="notify('<?= strip_tags($message) ?>', 'warning')"></div>
	<?php endif ?>
</section>
