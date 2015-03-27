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
					<div class="uk-panel uk-panel-box" ng-cloak>
						{{item.name}}
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="n-design-editor n-abs-fit uk-form n-sliding-panel n-off-next"
		 ng-class="{'n-on': currentView == 'designer', 'n-off-next': currentView == 'list', 'n-expanded': fullScreen}">
		<div class="n-options-header" 
			 ng-class="{'n-drop-shadow': mainContentBodyScrollTop > 0}">
			<div class="uk-grid uk-grid-collapse">
				<div class="uk-width-1-2">
					<button class="uk-button n-tool-button" ng-click="toggle('fullScreen')"
							ng-class="{'uk-active': fullScreen}">
						<i class="uk-icon-expand" ng-if="!fullScreen"></i>
						<i class="uk-icon-compress" ng-if="fullScreen"></i>
					</button>

					<div class="uk-button-group">
						<button class="uk-button n-tool-button"
								ng-class="{'uk-active': designerView == 'edit-canvas'}"
								ng-click="designerView = 'edit-canvas'">
							<i class="uk-icon-th"></i>
						</button>
						<button class="uk-button n-tool-button"
								ng-class="{'uk-active': designerView == 'preview-desktop'}"
								ng-click="designerView = 'preview-desktop'">
							<i class="uk-icon-desktop"></i>
						</button>
						<button class="uk-button n-tool-button"
								ng-class="{'uk-active': designerView == 'preview-tablet'}"
								ng-click="designerView = 'preview-tablet'">
							<i class="uk-icon-tablet"></i>
						</button>
						<button class="uk-button n-tool-button"
								ng-class="{'uk-active': designerView == 'preview-mobile'}"
								ng-click="designerView = 'preview-mobile'">
							<i class="uk-icon-mobile"></i>
						</button>
						<button class="uk-button n-tool-button"
								ng-class="{'uk-active': designerView == 'edit-code'}"
								ng-click="designerView = 'edit-code'">
							<i class="uk-icon-code"></i>
						</button>
					</div>

					<div class="uk-button-group" 
						 ng-show="designerView == 'preview-tablet' || designerView == 'preview-mobile'">
						<button class="uk-button n-tool-button"
								ng-class="{'uk-active': !landscape}"
								ng-click="landscape = false">
							<i class="uk-icon-arrows-v"></i>
						</button>
						<button class="uk-button n-tool-button"
								ng-class="{'uk-active': landscape}"
								ng-click="landscape = true">
							<i class="uk-icon-arrows-h"></i>
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
		<div class="n-designer">
			<div class="n-abs-fit n-overflow-auto" ng-show="designerView == 'edit-canvas'">
				<div class="n-canvas-panel" ng-class="{'n-expanded': canvasExpanded}">
				</div>
				<div class="n-components-panel" ng-class="{'n-collapsed': canvasExpanded}">
					<button class="uk-button n-tool-button" 
							ng-class="{'uk-active': !canvasExpanded}"
							ng-click="toggle('canvasExpanded')">
						<i class="uk-icon-circle" ng-if="!canvasExpanded"></i>
						<i class="uk-icon-thumb-tack" ng-if="canvasExpanded"></i>
					</button>
				</div>
			</div>
			<div class="n-abs-fit n-overflow-auto" ng-show="designerView == 'preview-desktop'">

			</div>
			<div class="n-abs-fit n-overflow-auto" ng-show="designerView == 'preview-tablet'">
				<div class="n-tablet-preview n-device-preview" ng-class="{'n-landscape': landscape}">
				</div>
			</div>
			<div class="n-abs-fit n-overflow-auto" ng-show="designerView == 'preview-mobile'">
				<div class="n-mobile-preview n-device-preview" ng-class="{'n-landscape': landscape}">
				</div>
			</div>
		</div>
	</div>

</div>