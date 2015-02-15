<form name="mainForm" class="uk-form n-abs-fit" novalidate="" ng-submit="save()" 
	  ng-modules="cms-general" ng-controller="CmsSiteInfoController" n-focus-on-error
	  ng-init="successMessage = '<?= lang("cms_save_success_message") ?>'; baseUrl = '<?= base_url("/admin/cms/siteinfo"); ?>'"
	  n-dirty-check="">
	<div class="n-culture-header" 
		 ng-class="{'n-drop-shadow': mainContentBodyScrollTop > 0}">
		<select id="cultureSelection" name="culture">
			<option value="en-us" <?= $culture == 'en-us' ? 'selected' : '' ?>>English</option>
			<option value="th-th" <?= $culture == 'th-th' ? 'selected' : '' ?>>Thai</option>
		</select>
	</div>
	<div class="n-content n-single-page" ng-class="{'n-semi-collapse': mainForm.$dirty}">
		<div class="uk-panel uk-panel-box">
			<div class="uk-panel-title">
				<?= lang("cms_admin_siteinfo_site_title") ?>
				<hr/>
			</div>
			<div class="uk-grid" ng-init="editingData.title = '<?= $site_title_main ?>'">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-2-5">
					<label for="mainTitleText"><?= lang("cms_admin_siteinfo_site_title_main_label") ?></label>
					<input type="text" name="title" id="mainTitleText" 
						   ng-model="editingData.title" class="uk-width-1-1 uk-margin-small-top" 
						   placeholder="<?= lang("cms_admin_siteinfo_site_title_main_placeholder") ?>"
						   maxlength="100" />
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-5 uk-text-muted">
					<?= lang("cms_admin_siteinfo_site_title_main_desc") ?>
				</div>
			</div>
			<hr/>
			<div class="uk-grid" ng-init="editingData.sub = '<?= $site_title_sub ?>'">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-2-5">
					<label for="mainTitleText"><?= lang("cms_admin_siteinfo_site_title_sub_label") ?></label>
					<input type="text" name="sub" id="subTitleText" 
						   ng-model="editingData.sub" class="uk-width-1-1 uk-margin-small-top" 
						   placeholder="<?= lang("cms_admin_siteinfo_site_title_sub_placeholder") ?>"
						   maxlength="100" />
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-5 uk-text-muted">
					<?= lang("cms_admin_siteinfo_site_title_sub_desc") ?>
				</div>
			</div>
			<hr/>
			<div class="uk-grid" ng-init="editingData.style = '<?= $site_title_style ?>'">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-2-5">
					<div>
						<input type="radio" name="style" id="siteTitleStyleMainAndPage" 
							   ng-model="editingData.style" value="smain">
						<label for="siteTitleStyleMainAndPage">
							<?= lang("cms_admin_siteinfo_title_style_main_and_page") ?>
						</label>
					</div>
					<div class="uk-margin-top">
						<input type="radio" name="style" id="siteTitleStylePageAndMain" 
							   ng-model="editingData.style" value="spage">
						<label for="siteTitleStylePageAndMain">
							<?= lang("cms_admin_siteinfo_title_style_page_and_main") ?>
						</label>
					</div>
					<div class="uk-margin-top" ng-init="editingData.separator = '<?= $site_title_separator ?>'">
						<label for="siteTitleSeparator"><?= lang("cms_admin_siteinfo_site_title_separator_label") ?>:</label>
						<input type="text" name="separator" id="siteTitleSeparator" 
							   ng-model="editingData.separator"
							   placeholder="<?= lang("cms_admin_siteinfo_site_title_separator_placeholder") ?>"
							   maxlength="3" style="width: 150px" />
					</div>
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-5 uk-text-muted">
					<?= lang("cms_admin_siteinfo_site_title_style_desc") ?>
					<div class="uk-margin-top uk-width-1-1">
						<div class="uk-alert uk-alert-success" ng-cloak=""
							 ng-if="editingData.style == 'smain'">
							<code>
								&lt;title&gt;{{editingData.title}} {{editingData.separator}} {{editingData.sub}}&lt;/title&gt;
							</code>
						</div>
						<div class="uk-alert uk-alert-success" ng-cloak=""
							 ng-if="editingData.style == 'spage'">
							<code>
								&lt;title&gt;{{editingData.sub}} {{editingData.separator}} {{editingData.title}}&lt;/title&gt;
							</code>
						</div>
					</div>
				</div>
			</div>
		</div>
		
		<div class="uk-panel uk-panel-box uk-margin-top">
			<div class="uk-panel-title">
				<?= lang("cms_admin_siteinfo_copyright") ?>
				<hr/>
			</div>
			<div class="uk-grid" ng-init="editingData.author = '<?= $copyright_author ?>'">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-2-5">
					<label for="author"><?= lang("cms_admin_siteinfo_copyright_author_label") ?></label>
					<input type="text" name="author" id="author" 
						   ng-model="editingData.author" class="uk-width-1-1 uk-margin-small-top" 
						   placeholder="<?= lang("cms_admin_siteinfo_copyright_author_placeholder") ?>"
						   maxlength="100" />
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-5 uk-text-muted">
					<?= lang("cms_admin_siteinfo_copyright_author_desc") ?>
				</div>
			</div>
			<hr/>
			<div class="uk-grid" ng-init="editingData.copyright = '<?= $copyright_text ?>'">
				<div class="uk-width-1-1 uk-width-medium-1-3 uk-width-large-2-5">
					<label for="copyright"><?= lang("cms_admin_siteinfo_copyright_text_label") ?></label>
					<input type="text" name="copyright" id="copyright" 
						   ng-model="editingData.copyright" class="uk-width-1-1 uk-margin-small-top" 
						   placeholder="<?= lang("cms_admin_siteinfo_copyright_text_placeholder") ?>"
						   maxlength="100" />
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-width-medium-2-3 uk-width-large-3-5 uk-text-muted">
					<?= lang("cms_admin_siteinfo_copyright_text_desc") ?>
				</div>
			</div>
		</div>
		
		<div class="uk-panel uk-panel-box uk-margin-top">
			<div class="uk-panel-title">
				<?= lang("cms_admin_siteinfo_seo") ?>
				<hr/>
			</div>
			<div class="uk-grid" ng-init="editingData.description = '<?= $seo_description ?>'">
				<div class="uk-width-1-1">
					<label for="description"><?= lang("cms_admin_siteinfo_seo_description_label") ?></label>
					<input type="text" name="description" id="description" 
						   ng-model="editingData.description" class="uk-width-1-1 uk-margin-small-top" 
						   placeholder="<?= lang("cms_admin_siteinfo_seo_description_placeholder") ?>"
						   maxlength="256" />
				</div>
				<div class="uk-hidden-small uk-width-1-1 uk-text-muted uk-margin-small-top">
					<?= lang("cms_admin_siteinfo_seo_description_desc") ?>
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