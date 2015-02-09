<div class="n-content" ng-class="{'n-semi-collapse': mainForm.$dirty}">
	<form name="mainForm" class="uk-form" novalidate="">
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
				<label class="uk-form-label" for="uploadFilePath"><?= lang("setting_file_upload_fs_root") ?></label>
				<input type="text" class="uk-width-1-1 uk-margin-small-top" id="uploadFilePath" 
					   name="uploadFilePath" ng-model="uploadFilePath"
					   ng-class="{'uk-form-danger': mainForm.uploadFilePath.$error.required && mainForm.$submitted }"
					   placeholder="<?= lang("setting_file_upload_fs_root_placeholder") ?>"
					   maxlength="255" required />
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
				<label class="uk-form-label" for="uploadDbTable"><?= lang("setting_file_upload_db_table") ?></label>
				<input type="text" class="uk-width-1-1 uk-margin-small-top" id="uploadDbTable" 
					   name="uploadFilePath" ng-model="uploadDbTable"
					   ng-class="{'uk-form-danger': (
					   		mainForm.uploadDbTable.$error.required ||
					   		mainForm.uploadDbTable.$error.pattern) && mainForm.$submitted }"
					   placeholder="<?= lang("setting_file_upload_db_table_placeholder") ?>"
					   pattern="[a-zA-Z]*"
					   maxlength="20" required />
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
					<label class="uk-form-label" for="uploadS3Key">AWS Access Key ID</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="uploadS3Key" 
						   placeholder="<?= lang("setting_aws_access_key_id_placeholder") ?>" maxlength="200"
						   value="<?= $aws_access_key_id ?>" readonly />
				</div>
				<div class="uk-margin-small-top">
					<label class="uk-form-label" for="uploadS3Secret">AWS Secret Access Key</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="uploadS3Secret" 
						   placeholder="<?= lang("setting_aws_secret_access_key_placeholder") ?>" maxlength="200"
						   value="<?= $aws_secret_access_key ?>" readonly />
				</div>
				<div class="uk-margin-small-top">
					<label class="uk-form-label" for="uploadS3Bucket">Bucket</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="uploadS3Bucket" 
						   name="uploadS3Bucket" ng-model="uploadS3Bucket"
						   placeholder="<?= lang("setting_aws_bucket_placeholder") ?>" 
						   maxlength="30" required />
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
					<label for="emailOptionSendMail">SendMail</label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_email_send_mail_desc") ?>
				</div>
			</div>
			<div class="uk-margin-top uk-panel uk-panel-box n-setting-details ng-hide"
				 ng-show="emailOption == 'sendmail'">
				<div>
					<label class="uk-form-label" for="emailSendMailPath">Sendmail Path</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="emailSmtpUsername" 
						   placeholder="<?= lang("setting_email_send_mail_path_placeholder") ?>" maxlength="500"
						   name="emailSendMailPath" ng-model="emailSendMailPath"
						   ng-class="{'uk-form-danger': mainForm.emailSendMailPath.$error.required && mainForm.$submitted }"
						   required />
				</div>
			</div>
			<hr/>
			<div class="uk-margin-small-top uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="emailOption" id="emailOptionSMTP" value="smtp"
						   ng-model="emailOption" />
					<label for="emailOptionSMTP">SMTP</label>
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
					<label class="uk-form-label" for="emailSmtpUsername">Username</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="emailSmtpUsername" 
						   placeholder="<?= lang("setting_email_smtp_username_placeholder") ?>" maxlength="200"
						   ng-class="{'uk-form-danger': mainForm.emailSmtpUsername.$error.required }"
						   value="<?= $email_username ?>" readonly required />
				</div>
				<div class="uk-margin-small-top">
					<label class="uk-form-label" for="emailSmtpPassword">Password</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="emailSmtpPassword" 
						   placeholder="<?= lang("setting_email_smtp_password_placeholder") ?>" maxlength="200"
						   ng-class="{'uk-form-danger': mainForm.emailSmtpPassword.$error.required }"
						   value="<?= $email_password ?>" readonly required />
				</div>
				<div class="uk-margin-small-top">
					<label class="uk-form-label" for="emailSmtpServer">Server</label>
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
					<input type="radio" name="emailOption" id="emailOptionExternal" value="gae"
						   ng-model="emailOption" />
					<label for="emailOptionExternal"><?= lang("setting_email_external") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_email_external_desc") ?>
				</div>
			</div>
		</div>
	</form>
</div>

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
