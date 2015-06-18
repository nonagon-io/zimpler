<div ng-controller="FileManagerController"
	 ng-init="baseUrl = '<?= base_url(''); ?>'; refresh();">

	<div data-uk-grid="{gutter: 20}" 
		 class="n-folder-list uk-grid-width-1-1 uk-grid-width-small-1-3 uk-grid-width-medium-1-5 uk-grid-width-large-1-8">
		<div ng-repeat="item in folders">
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
		<div ng-repeat="item in files">
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
</div>