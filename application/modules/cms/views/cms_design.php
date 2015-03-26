<div class="n-abs-fit" ng-controller="CmsDesignController"
	 ng-init="restBaseUrl = '<?= base_url('/cms/rest/design') ?>'; refreshItems();">
	<div class="n-abs-fit uk-form n-sliding-panel" 
		 ng-class="{'n-on': currentView == 'list', 'n-off-prev': currentView == 'designer'}">
		<div class="n-options-header" 
			 ng-class="{'n-drop-shadow': mainContentBodyScrollTop > 0}">
			<div class="uk-grid uk-grid-collapse">
				<div class="uk-width-1-2">
					<button class="uk-button uk-button-success" ng-click="add()">
						<i class="uk-icon-plus"></i>
					</button>
				</div>
				<div class="uk-width-1-2 uk-text-right">
					<button class="uk-button">
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

	<div class="n-abs-fit uk-form n-sliding-panel" style="background: white"
		 ng-class="{'n-on': currentView == 'designer', 'n-off-next': currentView == 'list'}">
		<div class="n-options-header" 
			 ng-class="{'n-drop-shadow': mainContentBodyScrollTop > 0}">
			<div class="uk-grid uk-grid-collapse">
				<div class="uk-width-1-2">
					<div class="uk-button-group">
						<button class="uk-button">
							<i class="uk-icon-bars"></i>
						</button>
						<button class="uk-button">
							<i class="uk-icon-code"></i>
						</button>
					</div>
				</div>
				<div class="uk-width-1-2 uk-text-right">
					<button class="uk-button uk-button-primary" style="width: 80px">
						Save
					</button>
					<button class="uk-button" style="width: 80px" ng-click="cancel()">
						Cancel
					</button>
				</div>
			</div>
		</div>
	</div>

</div>