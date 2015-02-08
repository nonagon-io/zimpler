<section class="n-content">
	<form class="uk-form">

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
					<input type="radio" name="uploadOption" id="uploadOptionDisable" value="disable" checked="">
					<label for="uploadOptionDisable"><?= lang("setting_file_upload_disabled") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_file_upload_file_disabled_desc") ?>
				</div>
			</div>
			<hr/>
			<div class="uk-margin-small-top uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="uploadOption" id="uploadOptionFileSystem" value="file">
					<label for="uploadOptionFileSystem"><?= lang("setting_file_upload_file_system") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_file_upload_file_system_desc") ?>
				</div>
			</div>
			<hr/>
			<div class="uk-margin-small-top uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="uploadOption" id="uploadOptionDatabase" value="db">
					<label for="uploadOptionDatabase"><?= lang("setting_file_upload_database") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_file_upload_database_desc") ?>
				</div>
			</div>
			<hr/>
			<div class="uk-margin-small-top uk-grid">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-1-4">
					<input type="radio" name="uploadOption" id="uploadOptionS3" value="s3">
					<label for="uploadOptionS3"><?= lang("setting_file_upload_s3") ?></label>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-4 uk-text-muted">
					<?= lang("setting_file_upload_s3_desc") ?>
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
</section>