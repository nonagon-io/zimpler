<div class="n-abs-fit uk-form" ng-controller="CmsDesignController"
	 ng-init="restBaseUrl = '<?= base_url('/cms/rest/design') ?>'; refreshItems();">
	<div class="n-options-header" 
		 ng-class="{'n-drop-shadow': mainContentBodyScrollTop > 0}">
		<div class="uk-grid uk-grid-collapse">
			<div class="uk-width-1-2">
				<button class="uk-button uk-button-success" ng-click="add()">
					<i class="uk-icon-plus"></i>
				</button>
			</div>
			<div class="uk-width-1-2 uk-text-right">
				<button class="uk-button uk-button">
					<i class="uk-icon-upload"></i> Import
				</button>
			</div>
		</div>
	</div>
	<div class="n-list">
		<div class="n-item-host uk-grid uk-grid-collapse">
			<div class="n-item uk-width-1-5" ng-repeat="item in items">
				<div class="uk-panel uk-panel-box">
					{{item.name}}
				</div>
			</div>
		</div>
	</div>
</div>