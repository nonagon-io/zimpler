<form name="mainForm" class="uk-form n-abs-fit" novalidate="" ng-submit="save()" 
	  ng-modules="cms-general" ng-controller="CmsGeneralController" n-focus-on-error
	  ng-init="successMessage = '<?= lang("cms_save_success_message") ?>';"
	  n-dirty-check="">
	<div class="n-content n-single-page" ng-class="{'n-semi-collapse': mainForm.$dirty}">
		<div class="uk-panel uk-panel-box">
			<div class="uk-panel-title">
				<?= lang("cms_admin_general_site_title") ?>
				<hr/>
			</div>
		</div>
	</div>
</form>