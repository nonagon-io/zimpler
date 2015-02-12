<form name="mainForm" class="uk-form n-abs-fit" novalidate="">
	<div class="n-content" ng-class="{'n-semi-collapse': mainForm.$dirty}">
		<div class="uk-panel uk-panel-box">
			<div class="uk-panel-title">
				<?= lang("setting_content_approval_title") ?>
				<hr/>
			</div>
			<div class="uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="approvalOption" id="approvalOptionDisable" 
						   ng-model="approvalOption" value="disable" checked="">
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
						   ng-model="approvalOption" value="enable">
					<label for="approvalOptionEnable"><?= lang("setting_content_approval_enabled") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_content_approval_enabled_desc") ?>
				</div>
			</div>
		</div>
		
		<div class="uk-panel uk-panel-box uk-margin-top">
			<div class="uk-panel-title">
				<?= lang("setting_file_upload_title") ?>
				<hr/>
			</div>
			<div class="uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="uploadOption" id="uploadOptionDisable" 
						   ng-model="uploadOption" value="disable" checked="" />
					<label for="uploadOptionDisable"><?= lang("setting_file_upload_disabled") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_file_upload_file_disabled_desc") ?>
				</div>
			</div>
			<hr/>
			<div class="uk-margin-small-top uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="uploadOption" id="uploadOptionFileSystem" value="file" 
						   ng-model="uploadOption" />
					<label for="uploadOptionFileSystem"><?= lang("setting_file_upload_file_system") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_file_upload_file_system_desc") ?>
				</div>
			</div>
			<div class="uk-margin-top uk-panel uk-panel-box n-setting-details ng-hide"
				 ng-show="uploadOption == 'file'">
				<label class="uk-form-label" for="uploadFilePath">
					<?= lang("setting_file_upload_fs_root") ?>
					<i class="uk-icon-times-circle uk-text-danger" 
					   title="<?= lang("setting_file_upload_fs_root_require_error") ?>"
					   data-uk-tooltip="{pos:'right'}"
					   ng-show="mainForm.uploadFilePath.$error.required && mainForm.$submitted"></i>
				</label>
				<input type="text" class="uk-width-1-1 uk-margin-small-top" id="uploadFilePath" 
					   name="uploadFilePath" ng-model="uploadFilePath"
					   ng-class="{'uk-form-danger': mainForm.uploadFilePath.$error.required && mainForm.$submitted }"
					   placeholder="<?= lang("setting_file_upload_fs_root_placeholder") ?>"
					   maxlength="255" ng-required="uploadOption == 'file'" />
			</div>
			<hr/>
			<div class="uk-margin-small-top uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="uploadOption" id="uploadOptionDatabase" value="db" 
						   ng-model="uploadOption" />
					<label for="uploadOptionDatabase"><?= lang("setting_file_upload_database") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_file_upload_database_desc") ?>
				</div>
			</div>
			<div class="uk-margin-top uk-panel uk-panel-box n-setting-details ng-hide"
				 ng-show="uploadOption == 'db'">
				<label class="uk-form-label" for="uploadDbTable">
					<?= lang("setting_file_upload_db_table") ?>
					<i class="uk-icon-times-circle uk-text-danger" 
					   title="<?= lang("setting_file_upload_db_table_require_error") ?>"
					   data-uk-tooltip="{pos:'right'}"
					   ng-show="mainForm.uploadDbTable.$error.required && mainForm.$submitted"></i>
					<i class="uk-icon-times-circle uk-text-danger" 
					   title="<?= lang("setting_file_upload_db_table_pattern_error") ?>"
					   data-uk-tooltip="{pos:'right'}"
					   ng-show="mainForm.uploadDbTable.$error.pattern && mainForm.$submitted"></i>
				</label>
				<input type="text" class="uk-width-1-1 uk-margin-small-top" id="uploadDbTable" 
					   name="uploadDbTable" ng-model="uploadDbTable"
					   ng-class="{'uk-form-danger': (
					   		mainForm.uploadDbTable.$error.required ||
					   		mainForm.uploadDbTable.$error.pattern) && mainForm.$submitted }"
					   placeholder="<?= lang("setting_file_upload_db_table_placeholder") ?>"
					   pattern="{{uploadOption == 'db' ? '[a-zA-Z0-9][\\w#@]{0,127}$' : ''}}"
					   maxlength="20" ng-required="uploadOption == 'db'" />
			</div>
			<hr/>
			<div class="uk-margin-small-top uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="uploadOption" id="uploadOptionS3" value="s3" 
						   ng-model="uploadOption" />
					<label for="uploadOptionS3"><?= lang("setting_file_upload_s3") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_file_upload_s3_desc") ?>
				</div>
			</div>
			<div class="uk-margin-top uk-panel uk-panel-box n-setting-details ng-hide"
				 ng-show="uploadOption == 's3'">
				<?php if(!($aws_access_key_id && $aws_secret_access_key)) : ?>
				<div class="uk-alert uk-alert-warning">
					<?= lang("setting_aws_warning") ?>
				</div>
				<?php else : ?>
				<div class="uk-alert uk-alert-success">
					<?= lang("setting_aws_success") ?>
				</div>
				<?php endif ?>
				<div>
					<label class="uk-form-label uk-text-primary" for="uploadS3Key">
						AWS Access Key ID
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_aws_access_key_id_require_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.uploadS3Key.$error.required && mainForm.$submitted"></i>
					</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="uploadS3Key" 
						   name="uploadS3Key" ng-model="uploadS3Key"
						   ng-class="{'uk-form-danger': mainForm.uploadS3Key.$error.required && mainForm.$submitted }"
						   placeholder="<?= lang("setting_aws_access_key_id_placeholder") ?>" maxlength="200"
						   value="<?= $aws_access_key_id ?>" readonly 
						   ng-required="uploadOption == 's3'" />
				</div>
				<div class="uk-margin-small-top">
					<label class="uk-form-label uk-text-primary" for="uploadS3Secret">
						AWS Secret Access Key
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_aws_secret_access_key_require_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.uploadS3Secret.$error.required && mainForm.$submitted"></i>
					</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="uploadS3Secret" 
						   name="uploadS3Secret" ng-model="uploadS3Secret"
						   ng-class="{'uk-form-danger': mainForm.uploadS3Secret.$error.required && mainForm.$submitted }"
						   placeholder="<?= lang("setting_aws_secret_access_key_placeholder") ?>" maxlength="200"
						   value="<?= $aws_secret_access_key ?>" readonly 
						   ng-required="uploadOption == 's3'" />
				</div>
				<div class="uk-margin-small-top">
					<label class="uk-form-label" for="uploadS3Bucket">
						Bucket
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_aws_bucket_require_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.uploadS3Bucket.$error.required && mainForm.$submitted"></i>
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_aws_bucket_pattern_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.uploadS3Bucket.$error.pattern && mainForm.$submitted"></i>
					</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="uploadS3Bucket" 
						   name="uploadS3Bucket" ng-model="uploadS3Bucket"
						   ng-class="{'uk-form-danger': (
						   		mainForm.uploadS3Bucket.$error.required ||
						   		mainForm.uploadS3Bucket.$error.pattern) && mainForm.$submitted }"
						   placeholder="<?= lang("setting_aws_bucket_placeholder") ?>"
						   pattern="{{uploadOption == 's3' ? '^[a-z0-9](-*[a-z0-9]){2,62}$' : ''}}"
						   maxlength="63" ng-required="uploadOption == 's3'" />
				</div>
			</div>
			<hr/>
			<div class="uk-margin-small-top uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="uploadOption" id="uploadOptionGCloud" value="gcloud" 
						   ng-model="uploadOption" />
					<label for="uploadOptionGCloud"><?= lang("setting_file_upload_gcloud") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_file_upload_gcloud_desc") ?>
				</div>
			</div>
			<div class="uk-margin-top uk-panel uk-panel-box n-setting-details ng-hide"
				 ng-show="uploadOption == 'gcloud'">
				<div class="uk-margin-small-top">
					<label class="uk-form-label" for="uploadGcloudBucket">
						Bucket
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_gcloud_bucket_require_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.uploadGcloudBucket.$error.required && mainForm.$submitted"></i>
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_gcloud_bucket_pattern_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.uploadGcloudBucket.$error.pattern && mainForm.$submitted"></i>
					</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="uploadS3Bucket" 
						   name="uploadGcloudBucket" ng-model="uploadGcloudBucket"
						   ng-class="{'uk-form-danger': (
						   		mainForm.uploadGcloudBucket.$error.required ||
						   		mainForm.uploadGcloudBucket.$error.pattern) && mainForm.$submitted }"
						   placeholder="<?= lang("setting_gcloud_bucket_placeholder") ?>"
						   pattern="{{uploadOption == 'gcloud' ? '^[0-9a-z]((-*|\.{0,1})[a-z0-9]){2,62}' : ''}}"
						   maxlength="30" ng-required="uploadOption == 'gcloud'" />
				</div>
			</div>
		</div>
		
		<div class="uk-panel uk-panel-box uk-margin-top">
			<div class="uk-panel-title">
				<?= lang("setting_email_title") ?>
				<hr/>
			</div>
			<div class="uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="emailOption" id="emailOptionDisable" value="disable" checked=""
						   ng-model="emailOption" />
					<label for="emailOptionDisable"><?= lang("setting_email_disabled") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_email_disabled_desc") ?>
				</div>
			</div>
			<hr/>
			<div class="uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="emailOption" id="emailOptionBuildIn" value="mail" checked=""
						   ng-model="emailOption" />
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
						   ng-model="emailOption" />
					<label for="emailOptionSendMail"><?= lang("setting_email_send_mail") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_email_send_mail_desc") ?>
				</div>
			</div>
			<div class="uk-margin-top uk-panel uk-panel-box n-setting-details ng-hide"
				 ng-show="emailOption == 'sendmail'">
				<div>
					<label class="uk-form-label" for="emailSendMailPath">
						SendMail Path
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_email_send_mail_path_require_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.emailSendMailPath.$error.required && mainForm.$submitted"></i>
					</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="emailSendMailPath" 
						   name="emailSendMailPath" ng-model="emailSendMailPath"
						   placeholder="<?= lang("setting_email_send_mail_path_placeholder") ?>" maxlength="500"
						   ng-class="{'uk-form-danger': mainForm.emailSendMailPath.$error.required && mainForm.$submitted }"
						   ng-required="emailOption == 'sendmail'" />
				</div>
			</div>
			<hr/>
			<div class="uk-margin-small-top uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="emailOption" id="emailOptionSMTP" value="smtp"
						   ng-model="emailOption" />
					<label for="emailOptionSMTP"><?= lang("setting_email_smtp") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_email_smtp_desc") ?>
				</div>
			</div>
			<div class="uk-margin-top uk-panel uk-panel-box n-setting-details ng-hide"
				 ng-show="emailOption == 'smtp'">
				<?php if(!($email_username && $email_password)) : ?>
				<div class="uk-alert uk-alert-warning">
					<?= lang("setting_email_warning") ?>
				</div>
				<?php else : ?>
				<div class="uk-alert uk-alert-success">
					<?= lang("setting_email_success") ?>
				</div>
				<?php endif ?>
				<div>
					<label class="uk-form-label" for="emailSmtpUsername">
						Username
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_email_smtp_username_require_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.emailSmtpUsername.$error.required && mainForm.$submitted"></i>
					</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="emailSmtpUsername" 
						   name="emailSmtpUsername" ng-model="emailSmtpUsername"
						   placeholder="<?= lang("setting_email_smtp_username_placeholder") ?>" maxlength="200"
						   ng-class="{'uk-form-danger': mainForm.emailSmtpUsername.$error.required }"
						   ng-value="<?= $email_username ?>" readonly 
						   ng-required="emailOption == 'smtp'" />
				</div>
				<div class="uk-margin-small-top">
					<label class="uk-form-label" for="emailSmtpPassword">
						Password
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_email_smtp_password_require_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.emailSmtpPassword.$error.required && mainForm.$submitted"></i>
					</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="emailSmtpPassword" 
						   name="emailSmtpPassword" ng-model="emailSmtpPassword"
						   placeholder="<?= lang("setting_email_smtp_password_placeholder") ?>" maxlength="200"
						   ng-class="{'uk-form-danger': mainForm.emailSmtpPassword.$error.required }"
						   ng-value="<?= $email_password ?>" readonly 
						   ng-required="emailOption == 'smtp'" />
				</div>
				<div class="uk-margin-small-top">
					<label class="uk-form-label" for="emailSmtpServer">
						Server
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_email_smtp_server_required_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.emailSmtpServer.$error.required && mainForm.$submitted"></i>
						<i class="uk-icon-times-circle uk-text-danger" 
						   title="<?= lang("setting_email_smtp_server_pattern_error") ?>"
						   data-uk-tooltip="{pos:'right'}"
						   ng-show="mainForm.emailSmtpServer.$error.pattern && mainForm.$submitted"></i>
					</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="emailSmtpServer" 
						   name="emailSmtpServer" ng-model="emailSmtpServer"
						   ng-class="{'uk-form-danger':
						   		(mainForm.emailSmtpServer.$error.required ||
						   		 mainForm.emailSmtpServer.$error.pattern) && mainForm.$submitted}"
						   placeholder="<?= lang("setting_email_smtp_server_placeholder") ?>" 
						   maxlength="100" 
						   pattern="^(([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])\.){3}([0-9]|[1-9][0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$|^(([a-zA-Z]|[a-zA-Z][a-zA-Z0-9\-]*[a-zA-Z0-9])\.)*([A-Za-z]|[A-Za-z][A-Za-z0-9\-]*[A-Za-z0-9])$"
						   required />
				</div>
				<div class="uk-margin-small-top">
					<label class="uk-form-label" for="emailSmtpPort">Port</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="emailSmtpPort" 
						   name="emailSmtpPort" ng-model="emailSmtpPort"
						   ng-class="{'uk-form-danger': 
						   		(mainForm.emailSmtpPort.$error.required ||
						   		 mainForm.emailSmtpPort.$error.pattern) && mainForm.$submitted}"
						   placeholder="<?= lang("setting_email_smtp_port_placeholder") ?>" 
						   maxlength="5" 
						   pattern="^([0-9]{1,4}|[1-5][0-9]{4}|6[0-4][0-9]{3}|65[0-4][0-9]{2}|655[0-2][0-9]|6553[0-5])$" 
						   required />
				</div>
				<div class="uk-margin-small-top">
					<label class="uk-form-label" for="emailSmtpTimeout">Timeout</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="emailSmtpTimeout" 
						   name="emailSmtpTimeout" ng-model="emailSmtpTimeout"
						   ng-class="{'uk-form-danger': 
						   		(mainForm.emailSmtpTimeout.$error.required ||
						   		 mainForm.emailSmtpTimeout.$error.pattern) && mainForm.$submitted}"
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
						   ng-model="emailOption" />
					<label for="emailOptionGAE"><?= lang("setting_email_gae") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_email_gae_desc") ?>
				</div>
			</div>
		</div>
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
				<button type="submit" class="uk-button uk-button-success" 
						style="width: 100px">
					Save
				</button>
				<button type="button" class="uk-button" style="width: 100px"
						ng-click="mainForm.$setPristine(); mainForm.$setUntouched();">
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
