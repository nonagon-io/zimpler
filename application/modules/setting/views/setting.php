<div class="n-content">
	<form class="uk-form" novalidate="">

		<div class="uk-panel uk-panel-box">
			<div class="uk-panel-title">
				<?= lang("setting_content_approval_title") ?>
				<hr/>
			</div>
			<div class="uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="approvalOption" id="approvalOptionDisable" value="disable" checked="">
					<label for="approvalOptionDisable"><?= lang("setting_content_approval_disabled") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_content_approval_disabled_desc") ?>
				</div>
			</div>
			<hr/>
			<div class="uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="approvalOption" id="approvalOptionEnable" value="enable">
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
				<label class="uk-form-label" for="uploadFilePath">Upload Root Path</label>
				<input type="text" class="uk-width-1-1 uk-margin-small-top" id="uploadFilePath" 
					   placeholder="Enter path elative to your web root directory" />
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
					For security reason, AWS Access Key ID and AWS Secret Access Key must be setup
					by using server environment variables as AWS-ACCESS-KEY-ID and AWS-SECRET-ACCESS-KEY.
					Please follow the instruction <a href="#aws-key-instruction" data-uk-modal="">here</a>.
				</div>
				<?php else : ?>
				<div class="uk-alert uk-alert-success">
					You have successfully setup AWS Access Key ID and AWS Secret Access Key. 
					If you want to change it please update server environment variables by 
					following the instruction <a href="#aws-key-instruction" data-uk-modal="">here</a>.
				</div>
				<?php endif ?>
				<div>
					<label class="uk-form-label" for="uploadS3Key">Access Key</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="uploadS3Key" 
						   placeholder="AWS Access Key ID" maxlength="200"
						   value="<?= $aws_access_key_id ?>" readonly />
				</div>
				<div class="uk-margin-small-top">
					<label class="uk-form-label" for="uploadS3Secret">Secret Key</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="uploadS3Secret" 
						   placeholder="AWS Secret Access Key" maxlength="200"
						   value="<?= $aws_secret_access_key ?>" readonly />
				</div>
				<div class="uk-margin-small-top">
					<label class="uk-form-label" for="uploadS3Bucket">Bucket</label>
					<input type="text" class="uk-width-1-1 uk-margin-small-top" id="uploadS3Bucket" 
						   placeholder="Bucket Name (will be created if not exists)" 
						   maxlength="30" />
				</div>
			</div>
			
			<div id="aws-key-instruction" class="uk-modal">
			    <div class="uk-modal-dialog">
			        <a class="uk-modal-close uk-close"></a>
			        <h2>Setup environment variables for AWS</h2>
			        <p>
				        Due to the security concerns, Zimpler will just force you to always use environment variable 
				        to store any secret data instead of database or configuration file.
			        </p>
			        <hr/>
			        <p>
				        In Apache, you can put the following lines into httpd.conf
						<div class="n-code-block">
							<code>SetEnv AWS_ACCESS_KEY_ID &lt;AWS-ACCESS-KEY-ID&gt;</code><br/>
							<code>SetEnv AWS_SECRET_ACCESS_KEY &lt;AWS-SCRET-ACCESS-KEY&gt;</code>
						</div>
			        </p>
			        <p>
						Just replace <code>&lt;AWS-ACCESS-KEY-ID&gt;</code> and <code>&lt;AWS-SCRET-ACCESS-KEY&gt;</code>
						with the actual keys you own and restart the web server.
			        </p>
			        <p>
				        <span class="uk-badge">Note</span> If you are using <b>alias</b>, the above code
				        must be put under its <code>&lt;Directory&gt;</code> block.
			        </p>
			        <hr/>
			        <p>
				        If you host it on Enginx, the above variables must be set as fastcgi_param as following:
						<div class="n-code-block">
							<code>fastcgi_param AWS_ACCESS_KEY_ID &lt;AWS-ACCESS-KEY-ID&gt;</code><br/>
							<code>fastcgi_param AWS_SECRET_ACCESS_KEY &lt;AWS-SCRET-ACCESS-KEY&gt;</code>
						</div>
			        </p>
			        <p>
				        Please see this
				        <a href="http://nginx.org/en/docs/http/ngx_http_fastcgi_module.html" target="_blank">link</a> 
				        for more details.
			        </p>
			        <hr/>
			        <p>
				        In Heroku, you can use its UI to reveals all Config Variables. Then put
				        <code>AWS_ACCESS_KEY_ID</code> and <code>AWS_SECRET_ACCESS_KEY</code> as keys.
			        </p>
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
					<input type="radio" name="emailOption" id="emailOptionDisable" value="disable" checked="">
					<label for="emailOptionDisable"><?= lang("setting_email_disabled") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_email_disabled_desc") ?>
				</div>
			</div>
			<hr/>
			<div class="uk-margin-small-top uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="emailOption" id="emailOptionBuildIn" value="buildin">
					<label for="emailOptionBuildIn"><?= lang("setting_email_build_in") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_email_build_in_desc") ?>
				</div>
			</div>
			<hr/>
			<div class="uk-margin-small-top uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="emailOption" id="emailOptionExternal" value="gae">
					<label for="emailOptionExternal"><?= lang("setting_email_external") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_email_external_desc") ?>
				</div>
			</div>
		</div>

		<div class="uk-panel uk-panel-box uk-margin-top">
			<div class="uk-panel-title">
				<?= lang("setting_social_title") ?>
				<hr/>
			</div>
			<div class="uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="socialOption" id="socialOptionDisable" value="disable" checked="">
					<label for="socialOptionDisable"><?= lang("setting_social_disabled") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_social_disabled_desc") ?>
				</div>
			</div>
			<hr/>
			<div class="uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="socialOption" id="socialOptionAddThis" value="addthis">
					<label for="socialOptionAddThis"><?= lang("setting_social_addthis") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_social_addthis_desc") ?>
				</div>
			</div>
			<hr/>
			<div class="uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="socialOption" id="socialOptionShareThis" value="sharethis">
					<label for="socialOptionShareThis"><?= lang("setting_social_sharethis") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_social_sharethis_desc") ?>
				</div>
			</div>
		</div>

	</form>
</div>