<form name="mainForm" class="uk-form n-abs-fit" novalidate="" ng-submit="save($event)" 
	  ng-modules="setting-general" ng-controller="SettingGeneralController" 
	  action="<?= base_url("/admin/setting/general"); ?>"
	  ng-init="successMessage = '<?= lang("setting_save_success_message") ?>';"
	  n-dirty-check="" n-focus-on-error="" ng-cloak="">
		  
	<input type="hidden" 
		   name="<?php echo $this->security->get_csrf_token_name(); ?>" 
		   value="<?php echo $this->security->get_csrf_hash();?>" />

	<div class="n-content n-single-page" ng-class="{'n-semi-collapse': mainForm.$dirty}">
		<?php if($setting_instruction) : ?>
		<div class="uk-alert uk-alert-primary uk-margin-bottom uk-text-center">
			<?= $setting_instruction ?>
		</div>
		<?php endif ?>

		<div class="uk-panel uk-panel-box" ng-init="editingData.approvalOption = '<?= $approval_option ?>'">
			<div class="uk-panel-title">
				<?= lang("setting_content_approval_title") ?>
				<hr/>
			</div>
			<div class="uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="approvalOption" id="approvalOptionDisable" 
						   ng-model="editingData.approvalOption" value="disable">
					<label for="approvalOptionDisable"><?= lang("setting_content_approval_disabled") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_content_approval_disabled_desc") ?>
				</div>
			</div>
			<hr/>
			<div class="uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="approvalOption" id="approvalOptionEnable" 
						   ng-model="editingData.approvalOption" value="enable">
					<label for="approvalOptionEnable"><?= lang("setting_content_approval_enabled") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_content_approval_enabled_desc") ?>
				</div>
			</div>
		</div>
		
		<div class="uk-panel uk-panel-box uk-margin-top" ng-init="editingData.fileManagerOption = '<?= $file_manager_option ?>'">
			<div class="uk-panel-title">
				<?= lang("setting_file_manager_title") ?>
				<hr/>
			</div>
			<div class="uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="fileManagerOption" id="fileManagerOptionDisable" 
						   ng-model="editingData.fileManagerOption" value="disable" />
					<label for="fileManagerOptionDisable"><?= lang("setting_file_manager_disabled") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_file_manager_file_disabled_desc") ?>
				</div>
			</div>
			<hr/>
			<div class="uk-margin-small-top uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="fileManagerOption" id="fileManagerOptionFileSystem" value="file" 
						   ng-model="editingData.fileManagerOption" />
					<label for="fileManagerOptionFileSystem"><?= lang("setting_file_manager_file_system") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_file_manager_file_system_desc") ?>
				</div>
			</div>
			<div class="uk-margin-top uk-panel uk-panel-box n-setting-details ng-hide"
				 ng-show="editingData.fileManagerOption == 'file'">
				<div ng-init="editingData.filePath = '<?= $file_path ?>'">
					<label class="uk-form-label" for="filePath">
						<?= lang("setting_file_manager_fs_root") ?>
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_file_manager_fs_root_require_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.filePath.$error.required && mainForm.$submitted"></i>
					</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="filePath" 
						   name="filePath" ng-model="editingData.filePath"
						   ng-class="{'uk-form-danger': mainForm.filePath.$error.required && mainForm.$submitted }"
						   placeholder="<?= lang("setting_file_manager_fs_root_placeholder") ?>"
						   maxlength="255" ng-required="editingData.fileManagerOption == 'file'" />
				</div>
			</div>
			<hr/>
			<div class="uk-margin-small-top uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="fileManagerOption" id="fileManagerOptionDatabase" value="db" 
						   ng-model="editingData.fileManagerOption" />
					<label for="fileManagerOptionDatabase"><?= lang("setting_file_manager_database") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_file_manager_database_desc") ?>
				</div>
			</div>
			<div class="uk-margin-top uk-panel uk-panel-box n-setting-details ng-hide"
				 ng-show="editingData.fileManagerOption == 'db'">
				<label class="uk-form-label" for="dbTableName">
					<?= lang("setting_file_manager_db_table") ?>
					<i class="uk-icon-times-circle uk-text-danger" 
					   title="<?= lang("setting_file_manager_db_table_require_error") ?>"
					   data-uk-tooltip="{pos:'right'}"
					   ng-show="mainForm.dbTableName.$error.required && mainForm.$submitted"></i>
					<i class="uk-icon-times-circle uk-text-danger" 
					   title="<?= lang("setting_file_manager_db_table_pattern_error") ?>"
					   data-uk-tooltip="{pos:'right'}"
					   ng-show="mainForm.dbTableName.$error.pattern && mainForm.$submitted"></i>
				</label>
				<input type="text" class="uk-width-1-1 uk-margin-small-top" id="dbTableName" 
					   name="dbTableName" ng-model="editingData.dbTableName"
					   ng-class="{'uk-form-danger': (
					   		mainForm.dbTableName.$error.required ||
					   		mainForm.dbTableName.$error.pattern) && mainForm.$submitted }"
					   placeholder="<?= lang("setting_file_manager_db_table_placeholder") ?>"
					   pattern="{{fileManagerOption == 'db' ? '[a-zA-Z0-9][\\w#@]{0,127}$' : ''}}"
					   maxlength="20" ng-required="editingData.fileManagerOption == 'db'" />
			</div>
			<hr/>
			<div class="uk-margin-small-top uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="fileManagerOption" id="fileManagerOptionS3" value="s3" 
						   ng-model="editingData.fileManagerOption" />
					<label for="fileManagerOptionS3"><?= lang("setting_file_manager_s3") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_file_manager_s3_desc") ?>
				</div>
			</div>
			<div class="uk-margin-top uk-panel uk-panel-box n-setting-details ng-hide"
				 ng-show="editingData.fileManagerOption == 's3'">
				<?php if(!($aws_access_key_id && $aws_secret_access_key)) : ?>
				<div class="uk-alert uk-alert-warning">
					<?= lang("setting_aws_warning") ?>
				</div>
				<?php else : ?>
				<div class="uk-alert uk-alert-success">
					<?= lang("setting_aws_success") ?>
				</div>
				<?php endif ?>
				<div ng-init="editingData.S3Key = '<?= $aws_access_key_id ?>'">
					<label class="uk-form-label uk-text-primary" for="S3Key">
						AWS Access Key ID
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_aws_access_key_id_require_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.S3Key.$error.required && mainForm.$submitted"></i>
					</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="S3Key" 
						   name="S3Key" ng-model="editingData.S3Key"
						   ng-class="{'uk-form-danger': mainForm.S3Key.$error.required && mainForm.$submitted }"
						   placeholder="<?= lang("setting_aws_access_key_id_placeholder") ?>" maxlength="200"
						   readonly 
						   ng-required="editingData.fileManagerOption == 's3'" />
				</div>
				<div class="uk-margin-small-top" ng-init="editingData.S3Secret = '<?= $aws_secret_access_key ?>'">
					<label class="uk-form-label uk-text-primary" for="S3Secret">
						AWS Secret Access Key
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_aws_secret_access_key_require_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.S3Secret.$error.required && mainForm.$submitted"></i>
					</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="S3Secret" 
						   name="S3Secret" ng-model="editingData.S3Secret"
						   ng-class="{'uk-form-danger': mainForm.S3Secret.$error.required && mainForm.$submitted }"
						   placeholder="<?= lang("setting_aws_secret_access_key_placeholder") ?>" maxlength="200"
						   readonly 
						   ng-required="editingData.fileManagerOption == 's3'" />
				</div>
				<div class="uk-margin-small-top" ng-init="editingData.S3Bucket = '<?= $s3_bucket ?>'">
					<label class="uk-form-label" for="S3Bucket">
						Bucket
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_aws_bucket_require_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.S3Bucket.$error.required && mainForm.$submitted"></i>
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_aws_bucket_pattern_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.S3Bucket.$error.pattern && mainForm.$submitted"></i>
					</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="S3Bucket" 
						   name="S3Bucket" ng-model="editingData.S3Bucket"
						   ng-class="{'uk-form-danger': (
						   		mainForm.S3Bucket.$error.required ||
						   		mainForm.S3Bucket.$error.pattern) && mainForm.$submitted }"
						   placeholder="<?= lang("setting_aws_bucket_placeholder") ?>"
						   pattern="{{fileManagerOption == 's3' ? '^[a-z0-9](-*[a-z0-9]){2,62}$' : ''}}"
						   maxlength="63" ng-required="editingData.fileManagerOption == 's3'" />
				</div>
			</div>
			<hr/>
			<div class="uk-margin-small-top uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="fileManagerOption" id="fileManagerOptionGCloud" value="gcloud" 
						   ng-model="editingData.fileManagerOption" />
					<label for="fileManagerOptionGCloud"><?= lang("setting_file_manager_gcloud") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_file_manager_gcloud_desc") ?>
				</div>
			</div>
			<div class="uk-margin-top uk-panel uk-panel-box n-setting-details ng-hide"
				 ng-show="editingData.fileManagerOption == 'gcloud'">
				<div class="uk-margin-small-top" ng-init="editingData.GcloudBucket = '<?= $gcloud_bucket ?>'">
					<label class="uk-form-label" for="GcloudBucket">
						Bucket
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_gcloud_bucket_require_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.GcloudBucket.$error.required && mainForm.$submitted"></i>
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_gcloud_bucket_pattern_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.GcloudBucket.$error.pattern && mainForm.$submitted"></i>
					</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="GcloudBucket" 
						   name="GcloudBucket" ng-model="editingData.GcloudBucket"
						   ng-class="{'uk-form-danger': (
						   		mainForm.GcloudBucket.$error.required ||
						   		mainForm.GcloudBucket.$error.pattern) && mainForm.$submitted }"
						   placeholder="<?= lang("setting_gcloud_bucket_placeholder") ?>"
						   pattern="{{fileManagerOption == 'gcloud' ? '^[0-9a-z]((-*|\.{0,1})[a-z0-9]){2,62}' : ''}}"
						   maxlength="30" ng-required="editingData.fileManagerOption == 'gcloud'" />
				</div>
			</div>
		</div>
		
		<div class="uk-panel uk-panel-box uk-margin-top" ng-init="editingData.emailOption = '<?= $email_option ?>'">
			<div class="uk-panel-title">
				<?= lang("setting_email_title") ?>
				<hr/>
			</div>
			<div class="uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="emailOption" id="emailOptionDisable" value="disable"
						   ng-model="editingData.emailOption" />
					<label for="emailOptionDisable"><?= lang("setting_email_disabled") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_email_disabled_desc") ?>
				</div>
			</div>
			<hr/>
			<div class="uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="emailOption" id="emailOptionBuildIn" value="mail"
						   ng-model="editingData.emailOption" />
					<label for="emailOptionBuildIn"><?= lang("setting_email_build_in") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_email_build_in_desc") ?>
				</div>
			</div>
			<hr/>
			<div class="uk-margin-small-top uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="emailOption" id="emailOptionSendMail" value="sendmail"
						   ng-model="editingData.emailOption" />
					<label for="emailOptionSendMail"><?= lang("setting_email_send_mail") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_email_send_mail_desc") ?>
				</div>
			</div>
			<div class="uk-margin-top uk-panel uk-panel-box n-setting-details ng-hide"
				 ng-show="editingData.emailOption == 'sendmail'">
				<div ng-init="editingData.sendMailPath = '<?= $sendmail_path ?>'">
					<label class="uk-form-label" for="sendMailPath">
						SendMail Path
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_email_send_mail_path_require_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.sendMailPath.$error.required && mainForm.$submitted"></i>
					</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="sendMailPath" 
						   name="sendMailPath" ng-model="editingData.sendMailPath"
						   placeholder="<?= lang("setting_email_send_mail_path_placeholder") ?>" maxlength="500"
						   ng-class="{'uk-form-danger': mainForm.sendMailPath.$error.required && mainForm.$submitted }"
						   ng-required="editingData.emailOption == 'sendmail'" />
				</div>
			</div>
			<hr/>
			<div class="uk-margin-small-top uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="emailOption" id="emailOptionSMTP" value="smtp"
						   ng-model="editingData.emailOption" />
					<label for="emailOptionSMTP"><?= lang("setting_email_smtp") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_email_smtp_desc") ?>
				</div>
			</div>
			<div class="uk-margin-top uk-panel uk-panel-box n-setting-details ng-hide"
				 ng-show="editingData.emailOption == 'smtp'">
				<?php if(!($smtp_username && $smtp_password)) : ?>
				<div class="uk-alert uk-alert-warning">
					<?= lang("setting_email_warning") ?>
				</div>
				<?php else : ?>
				<div class="uk-alert uk-alert-success">
					<?= lang("setting_email_success") ?>
				</div>
				<?php endif ?>
				<div ng-init="editingData.smtpUsername = '<?= $smtp_username ?>'">
					<label class="uk-form-label" for="smtpUsername">
						Username
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_email_smtp_username_require_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.smtpUsername.$error.required && mainForm.$submitted"></i>
					</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="smtpUsername" 
						   name="smtpUsername" ng-model="editingData.smtpUsername"
						   placeholder="<?= lang("setting_email_smtp_username_placeholder") ?>" maxlength="200"
						   ng-class="{'uk-form-danger': mainForm.smtpUsername.$error.required }"
						   readonly 
						   ng-required="editingData.emailOption == 'smtp'" />
				</div>
				<div class="uk-margin-small-top" ng-init="editingData.smtpPassword = '<?= $smtp_password ?>'">
					<label class="uk-form-label" for="smtpPassword">
						Password
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_email_smtp_password_require_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.smtpPassword.$error.required && mainForm.$submitted"></i>
					</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="smtpPassword" 
						   name="smtpPassword" ng-model="editingData.smtpPassword"
						   placeholder="<?= lang("setting_email_smtp_password_placeholder") ?>" maxlength="200"
						   ng-class="{'uk-form-danger': mainForm.smtpPassword.$error.required }"
						   readonly 
						   ng-required="editingData.emailOption == 'smtp'" />
				</div>
				<div class="uk-margin-small-top" ng-init="editingData.smtpServer = '<?= $smtp_server ?>'">
					<label class="uk-form-label" for="smtpServer">
						Server
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_email_smtp_server_require_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.smtpServer.$error.required && mainForm.$submitted"></i>
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_email_smtp_server_pattern_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.smtpServer.$error.pattern && mainForm.$submitted"></i>
					</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="smtpServer" 
						   name="smtpServer" ng-model="editingData.smtpServer"
						   ng-class="{'uk-form-danger':
						   		(mainForm.smtpServer.$error.required ||
						   		 mainForm.smtpServer.$error.pattern) && mainForm.$submitted}"
						   placeholder="<?= lang("setting_email_smtp_server_placeholder") ?>" 
						   maxlength="100" 
						   pattern="^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$|^(([a-zA-Z]|[a-zA-Z][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z]|[A-Za-z][A-Za-z0-9\-]*[A-Za-z0-9])$"
						   ng-required="editingData.emailOption == 'smtp'" />
				</div>
				<div class="uk-margin-small-top" ng-init="editingData.smtpPort = '<?= $smtp_port ?>'">
					<label class="uk-form-label" for="smtpPort">
						Port
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_email_smtp_port_require_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.smtpPort.$error.required && mainForm.$submitted"></i>
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_email_smtp_port_pattern_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.smtpPort.$error.pattern && mainForm.$submitted"></i>
					</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="smtpPort" 
						   name="smtpPort" ng-model="editingData.smtpPort"
						   ng-class="{'uk-form-danger': 
						   		(mainForm.smtpPort.$error.required ||
						   		 mainForm.smtpPort.$error.pattern) && mainForm.$submitted}"
						   placeholder="<?= lang("setting_email_smtp_port_placeholder") ?>" 
						   maxlength="5" 
						   pattern="^([0-9]{1,4}|[1-5][0-9]{4}|6[0-4][0-9]{3}|65[0-4][0-9]{2}|655[0-2][0-9]|6553[0-5])$" 
						   required />
				</div>
				<div class="uk-margin-small-top" ng-init="editingData.smtpTimeout = '<?= $smtp_timeout ?>'">
					<label class="uk-form-label" for="smtpTimeout">
						Timeout
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_email_smtp_timeout_require_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.smtpTimeout.$error.required && mainForm.$submitted"></i>
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_email_smtp_timeout_pattern_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.smtpTimeout.$error.pattern && mainForm.$submitted"></i>
					</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="smtpTimeout" 
						   name="smtpTimeout" ng-model="editingData.smtpTimeout"
						   ng-class="{'uk-form-danger': 
						   		(mainForm.smtpTimeout.$error.required ||
						   		 mainForm.smtpTimeout.$error.pattern) && mainForm.$submitted}"
						   placeholder="<?= lang("setting_email_smtp_timeout_placeholder") ?>" 
						   maxlength="3" 
						   pattern="^([0-9]{1,2}|[12][0-9]{2}|300)$" 
						   required />
				</div>
			</div>
			<hr/>
			<div class="uk-margin-small-top uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="emailOption" id="emailOptionGAE" value="gae"
						   ng-model="editingData.emailOption" />
					<label for="emailOptionGAE"><?= lang("setting_email_gae") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_email_gae_desc") ?>
				</div>
			</div>
		</div>

		<?php

		foreach($additional_setting_panels as $item)
		{
			$data = $item['load']($this);
			$this->load->view($item['view'], $data);
		}

		?>

	</div>
	<div class="n-footer ng-hide" ng-show="mainForm.$dirty">
		<div class="n-scroll-for-more ng-hide" 
			 title="Scroll down for more" 
			 data-uk-tooltip=""
			 ng-show="!mainContentBodyScrollMaxReached"></div>
		<div class="n-top-border"></div>
		<div class="n-commands uk-grid">
			<div class="uk-width-2-3">
				&nbsp;
			</div>
			<div class="uk-width-1-3 uk-text-right">
				<button type="submit" class="uk-button uk-button-success" style="width: 100px">
					Save
				</button>
				<button type="button" class="uk-button" style="width: 100px"
						ng-click="cancel()">
					Cancel
				</button>
			</div>
		</div>
	</div>
</form>

<div id="aws-key-instruction" class="uk-modal">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <h2><?= lang("setting_aws_instruction_title") ?></h2>
        <p>
	        <?= lang("setting_general_security_intro") ?>
        </p>
        <hr/>
        <p>
	        <?= lang("setting_general_security_env_apache") ?>
			<div class="n-code-block">
				<code>SetEnv AWS_ACCESS_KEY_ID &lt;AWS-ACCESS-KEY-ID&gt;</code><br/>
				<code>SetEnv AWS_SECRET_ACCESS_KEY &lt;AWS-SCRET-ACCESS-KEY&gt;</code>
			</div>
        </p>
        <p>
	        <?= sprintf(
		        lang("setting_general_security_env_apache_replace"), 
		        	 "AWS-ACCESS-KEY-ID", "AWS-SCRET-ACCESS-KEY") ?>
        </p>
        <p>
	        <span class="uk-badge">Note</span>
	        <?= lang("setting_general_security_env_apache_note") ?>
        </p>
        <hr/>
        <p>
	        <?= lang("setting_general_security_env_nginx") ?>
			<div class="n-code-block">
				<code>fastcgi_param AWS_ACCESS_KEY_ID &lt;AWS-ACCESS-KEY-ID&gt;</code><br/>
				<code>fastcgi_param AWS_SECRET_ACCESS_KEY &lt;AWS-SCRET-ACCESS-KEY&gt;</code>
			</div>
        </p>
        <p>
	        <?= lang("setting_general_security_env_nginx_more") ?>
        </p>
        <hr/>
        <p>
	        <?= sprintf(
		        lang("setting_general_security_env_heroku_replace"), 
		        	 "AWS_ACCESS_KEY_ID", "AWS_SCRET_ACCESS_KEY") ?>
        </p>
        <hr/>
        <p>
	        <?= lang("setting_general_security_env_gae") ?>
        </p>
    </div>
</div>

<div id="email-key-instruction" class="uk-modal">
    <div class="uk-modal-dialog">
        <a class="uk-modal-close uk-close"></a>
        <h2><?= lang("setting_email_instruction_title") ?></h2>
        <p>
	        <?= lang("setting_general_security_intro") ?>
        </p>
        <hr/>
        <p>
	        <?= lang("setting_general_security_env_apache") ?>
			<div class="n-code-block">
				<code>SetEnv EMAIL_USERNAME &lt;EMAIL-USERNAME&gt;</code><br/>
				<code>SetEnv EMAIL_PASSWORD &lt;EMAIL-PASSWORD&gt;</code>
			</div>
        </p>
        <p>
	        <?= sprintf(
		        lang("setting_general_security_env_apache_replace"), 
		        	 "EMAIL-USERNAME", "EMAIL-PASSWORD") ?>
        </p>
        <p>
	        <span class="uk-badge">Note</span>
	        <?= lang("setting_general_security_env_apache_note") ?>
        </p>
        <hr/>
        <p>
	        <?= lang("setting_general_security_env_nginx") ?>
			<div class="n-code-block">
				<code>fastcgi_param EMAIL_USERNAME &lt;EMAIL-USERNAME&gt;</code><br/>
				<code>fastcgi_param EMAIL_PASSWORD &lt;EMAIL-PASSWORD&gt;</code>
			</div>
        </p>
        <p>
	        <?= lang("setting_general_security_env_nginx_more") ?>
        </p>
        <hr/>
        <p>
	        <?= sprintf(
		        lang("setting_general_security_env_heroku_replace"), 
		        	 "EMAIL_USERNAME", "EMAIL_PASSWORD") ?>
        </p>
        <hr/>
        <p>
	        <?= lang("setting_general_security_env_gae") ?>
        </p>
    </div>
</div>