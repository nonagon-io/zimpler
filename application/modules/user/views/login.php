<section class="n-content" ng-app="login" ng-controller="LoginController">
	<div class="n-login-front uk-form">
		<div class="uk-panel uk-panel-box uk-container-center uk-width-large-1-2 uk-width-medium-2-3 uk-width-1-1 uk-text-center">
			<?php echo form_open("user/login");?>
			
			<h1><?php echo lang('login_heading');?></h1>
			<div class="uk-grid uk-grid-preserve uk-grid-small">
				<div class="uk-width-1-1 uk-width-small-1-2">
					<div class="n-login-social">
		            	<button class="uk-button uk-button-large uk-button-primary uk-width-1-1 n-login-fb" type="button">
		            		<i class="uk-icon-facebook-square"> Log In with Facebook</i>
		            	</button>
		            	<button class="uk-button uk-button-large uk-button-primary uk-width-1-1 n-login-tt" type="button">
		            		<i class="uk-icon-twitter-square"> Log In with Twitter</i>
		            	</button>
		            	<button class="uk-button uk-button-large uk-button-primary uk-width-1-1 n-login-gp" type="button">
		            		<i class="uk-icon-google-plus-square"> Log In with Google</i>
		            	</button>
					</div>
				</div>
				<div class="uk-width-1-1 uk-width-small-1-2">
					<div class="n-login-general">
						<?php echo form_input($identity);?>
						<?php echo form_input($password);?>
						<div class="uk-text-left">
							<span class="uk-display-inline-block" style="margin-top: 10px;">
								<?php echo lang('login_remember_label', 'remember');?>
								<?php echo form_checkbox('remember', '1', FALSE, 'id="remember" style="margin-top: -2px;"');?>
							</span>
							<button type="submit" name="submit" style="width: 90px"
									class="uk-button uk-button-success uk-button-large uk-align-right">
								<?= lang('login_submit_btn') ?>
							</button>
						</div>
					</div>
				</div>
			</div>
			
			<?php if($message) : ?>
			<div id="infoMessage" class="uk-alert uk-alert-warning"><?php echo $message;?></div>
			<?php endif ?>

			<p>
				<i class="uk-icon-edit uk-icon-small uk-text-primary"></i>
				<a href="signup" class="uk-text-primary"><b><?php echo lang('login_signup');?></b></a>
				|
				<a href="forgot_password"><?php echo lang('login_forgot_password');?></a>
			</p>
			
			<?php echo form_close();?>
			
		</div>
	</div>
</section>