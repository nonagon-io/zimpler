<div class="n-abs-fit uk-form" ng-controller="CmsNavigationController"
	 ng-init="baseUrl = '<?= base_url("/admin/cms/navigations"); ?>'">
	<div class="n-options-header" 
		 ng-class="{'n-drop-shadow': mainContentBodyScrollTop > 0}">
		<select id="cultureSelection" name="culture">
			<option value="en-us" <?= $culture == 'en-us' ? 'selected' : '' ?>>English</option>
			<option value="th-th" <?= $culture == 'th-th' ? 'selected' : '' ?>>Thai</option>
		</select>
		<div class="uk-button-group">
			<a class="uk-button" title="Columns View" data-uk-tooltip=""><i class="uk-icon-columns"></i></a>
			<a class="uk-button" title="Sitemap View" data-uk-tooltip=""><i class="uk-icon-sitemap"></i></a>
			<a class="uk-button" title="List View" data-uk-tooltip=""><i class="uk-icon-th-list"></i></a>
		</div>
	</div>
	<div class="n-content n-single-page">
		<div class="n-columns-view">
			<div class="n-column">
				<div class="n-title">
					Level 1
				</div>
			</div><div class="n-column">
				<div class="n-title">
					Level 2
				</div>
			</div><div class="n-column">
				<div class="n-title">
					Level 3
				</div>
			</div><div class="n-column">
				<div class="n-title">
					Level 4
				</div>
			</div><div class="n-column">
				<div class="n-title">
					Level 5
				</div>
			</div>
		</div>
	</div>
</div>