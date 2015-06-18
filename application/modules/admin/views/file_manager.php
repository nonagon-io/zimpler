<div class="n-file-manager n-abs-fit uk-overflow-container" 
	 ng-controller="FileManagerController"
	 ng-init="baseUrl = '<?= base_url(''); ?>'; refresh();">

	<div data-uk-grid="{gutter: 20}" 
		 class="n-folder-list uk-grid-width-1-1 uk-grid-width-small-1-3 uk-grid-width-medium-1-5 uk-grid-width-large-1-8">
		<div class="n-folder-item" ng-click="drillUp()" ng-if="paths.length > 0">
			<div class="uk-panel-box">
				<div class="uk-text-center">
					<i class="uk-icon-folder-open uk-icon-large"></i>
				</div>
				<div class="uk-margin-small-top uk-text-small uk-text-primary uk-text-center">
					<label>..</label>
				</div>
			</div>
		</div>
		<div ng-repeat="item in folders" class="n-folder-item" ng-click="drillDown(item)">
			<div class="uk-panel-box">
				<div class="uk-text-center">
					<i class="uk-icon-folder uk-icon-large"></i>
				</div>
				<div class="uk-margin-small-top uk-text-small uk-text-primary uk-text-center">
					<label>{{item.name}}</label>
				</div>
			</div>
		</div>
	</div>
	<hr/>
	<div data-uk-grid="{gutter: 20}" 
		 class="n-file-list uk-grid-width-1-1 uk-grid-width-small-1-3 uk-grid-width-medium-1-5 uk-grid-width-large-1-8">
		<div ng-repeat="item in files" class="n-file-item" ng-click="select(item)" ng-dblclick="preview(item)"
			 ng-class="{'uk-active': selectedItem == item}">
			<div class="uk-panel-box">
				<img ng-src="{{item.url}}" />
				<div class="uk-margin-small-top uk-text-small uk-text-primary uk-text-center">
					<label>{{item.name}}</label>
				</div>
				<div class="uk-margin-small-top uk-text-small uk-text-center">
					<label>{{item.size | filesize}}</label>
				</div>
				<div class="uk-margin-small-top uk-text-small uk-text-muted uk-text-center">
					<label>{{item.modified | date : 'medium'}}</label>
				</div>
			</div>
		</div>
	</div>

	<div class="n-abs-fit n-progress-mask uk-text-center uk-vertical-align"
		 ng-show="isRefreshing">
		<div class="uk-vertical-align-middle">
			<i class="uk-icon-spinner uk-icon-spin"></i>
		</div>
	</div>
</div>