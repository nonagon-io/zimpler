<section class="n-content" ng-app="startup" ng-controller="StartupController">
	
	<div class="n-startup-front uk-form">
		<div class="uk-panel uk-panel-box uk-container-center uk-width-large-1-2 uk-width-medium-2-3 uk-width-1-1 uk-text-center">
			<?php 
				$attributes = array('name' => 'startupForm', 'novalidate' => '', 'ng-submit' => 'submit($event)');
				echo form_open("user/startup", $attributes);
			?>
			
			<div class="uk-text-center">
				<img src="<?php echo base_url('assets/images/logo.png') ?>" style="width:50px" />
			</div>

			<h1><?php echo lang('startup_heading') ?></h1>
			
			<hr/>
			
			<p class="uk-text-muted uk-width-9-10 uk-container-center">
				<?php echo lang('startup_intro') ?></p>
			</p>
			
			<div class="n-login-general uk-text-left uk-width-1-2 uk-container-center">
				<div class="uk-form-row">
					<label class="uk-form-label" for="firstName"><?= lang('startup_fname_label') ?></label>
					<div class="uk-form-controls">
						<input type="text" id="firstName" name="firstName" class="uk-width-1-1" 
							   maxlength="50" required="" ng-model="firstName"
							   ng-class="{'uk-form-danger': startupForm.firstName.$error.required && startupForm.$submitted}"
							   placeholder="<?= lang('startup_fname_placeholder') ?>" />
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label" for="lastName"><?= lang('startup_lname_label') ?></label>
					<div class="uk-form-controls">
						<input type="text" id="lastName" name="lastName" class="uk-width-1-1" 
							   maxlength="50" required="" ng-model="lastName"
							   ng-class="{'uk-form-danger': startupForm.lastName.$error.required && startupForm.$submitted}"
							   placeholder="<?= lang('startup_lname_placeholder') ?>" />
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label" for="company"><?= lang('startup_company_label') ?></label>
					<div class="uk-form-controls">
						<input type="text" id="company" name="company" class="uk-width-1-1" 
							   maxlength="100" ng-model="company"
							   placeholder="<?= lang('startup_company_placeholder') ?>" />
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label" for="email"><?= lang('startup_email_label') ?></label>
					<div class="uk-form-controls">
						<input type="email" id="email" name="email" class="uk-width-1-1" 
							   maxlength="100" required="" ng-model="email"
							   ng-class="{'uk-form-danger': 
							   				(startupForm.email.$error.required || 
							   				 startupForm.email.$error.email) && startupForm.$submitted}"
							   placeholder="<?= lang('startup_email_placeholder') ?>" />
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label" for="phone"><?= lang('startup_phone_label') ?></label>
					<div class="uk-form-controls">
						<input type="text" id="phone" name="phone" class="uk-width-1-1" 
							   maxlength="20"
							   ng-class="{'uk-form-danger': startupForm.phone.$error.format && startupForm.$submitted}"
							   placeholder="<?= lang('startup_phone_placeholder') ?>" />
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label" for="username"><?= lang('startup_username_label') ?></label>
					<div class="uk-form-controls">
						<input type="text" id="username" name="username" class="uk-width-1-1" 
							   maxlength="20" required=""
							   ng-class="{'uk-form-danger': startupForm.username.$error.required && startupForm.$submitted}"
							   placeholder="<?= lang('startup_username_placeholder') ?>" />
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label" for="password"><?= lang('startup_password_label') ?></label>
					<div class="uk-form-controls">
						<input type="password" id="password" name="password" class="uk-width-1-1" 
							   maxlength="20" required=""
							   ng-class="{'uk-form-danger': startupForm.password.$error.required && startupForm.$submitted}"
							   placeholder="<?= lang('startup_password_placeholder') ?>" />
					</div>
				</div>
				<div class="uk-form-row">
					<label class="uk-form-label" for="passwordConfirm"><?= lang('startup_password_confirm_label') ?></label>
					<div class="uk-form-controls">
						<input type="password" id="passwordConfirm" name="passwordConfirm" class="uk-width-1-1" 
							   maxlength="20" required=""
							   ng-class="{'uk-form-danger': startupForm.password.$error.required && startupForm.$submitted}"
							   placeholder="<?= lang('startup_password_confirm_placeholder') ?>" />
					</div>
				</div>
			</div>
			
			<?php if($message) : ?>
			<div id="infoMessage" class="uk-alert uk-alert-warning"><?php echo $message;?></div>
			<?php endif ?>
			
			<button type="submit" class="uk-button uk-button-success uk-width-1-3 uk-margin-large-top">
				<span style="text-transform: uppercase">
					<?= lang('startup_submit_btn') ?>
				</span>
			</button>
			
			<p class="uk-text-muted uk-margin-large-top">
				Powered by <a href="https://www.github.com/nonagon-x/zimpler" target="zimpler">Zimpler</a> - 
				The Micro CMS
			</p>
			
			<?php echo form_close();?>
			
		</div>
	</div>
</section>