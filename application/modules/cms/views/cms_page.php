<div class="n-content n-abs-fit uk-form" 
	 ng-controller="PageListController" 
	 ng-init="restBaseUrl = '<?= base_url('/user/rest') ?>';">
	<div class="n-options-header" 
		 ng-class="{'n-drop-shadow': mainContentBodyScrollTop > 0}">
		<div class="uk-grid uk-grid-collapse">
			<div class="uk-width-7-10 uk-width-medium-2-3">
				<input type="text" placeholder="Keyword" ng-model="searchKeyword" ng-keydown="detectSearch($event)"
					   style="width: 250px"/>
				<button type="button" class="uk-button uk-button-primary" ng-click="search()">
					<i class="uk-icon-search"></i>
					<span class="uk-hidden-small uk-hidden-medium">Search</span>
				</button>
				<button type="button" class="uk-button uk-button-danger ng-hide" ng-click="clearSearch()"
						ng-show="isKeywordActive">
					<i class="uk-icon-times"></i>
					<span class="uk-hidden-small uk-hidden-medium">Clear</span>
				</button>
			</div>
			<div class="uk-width-3-10 uk-width-medium-1-3 uk-text-right">
				<div class="uk-margin-small-top">
					Total Pages: <?= $total_pages ?> 
				</div>
			</div>
		</div>
	</div>
	<div class="n-list n-user-list" ng-init="refresh()">
		<table class="n-table uk-table uk-table-striped">
			<thead>
				<tr>
					<th style="width: 20px" class="uk-text-center"><input type="checkbox" /></th>
					<th>Name</th>
					<th style="width: 200px">Created</th>
					<th style="width: 200px">Modified</th>
					<th style="width: 80px">Status</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="item in list.items"
					ng-class="{'uk-active': selectedItem.id == item.id, 'n-selected': item.checked}">
					<td class="uk-text-center">
						<input type="checkbox" ng-model="item.checked" ng-disabled="selectedItem" />
					</td>
					<td ng-bind="item.name" ng-click="select(item)"></td>
					<td ng-bind="item.created" ng-click="select(item)"></td>
					<td ng-bind="item.modified" ng-click="select(item)"></td>
					<td ng-bind="item.status ? 'Active' : 'Inactive'" ng-click="select(item)"></td>
				</tr>
			</tbody>
		</table>
		<div class="n-abs-fit uk-vertical-align uk-text-center uk-panel uk-panel-box" ng-show="isRefreshing">
			<div class="uk-vertical-align-middle">
				<i class="uk-icon-spinner uk-icon-spin"></i>
			</div>
		</div>
	</div>
	<div class="n-controller">
		<div class="uk-grid uk-grid-collapse">
			<div class="uk-width-1-4">
				<div ng-cloak="" class="uk-margin-small-top">
					Displaying from {{list.from}} to {{list.to}} of {{list.total}}
				</div>
			</div>
			<div class="uk-width-2-4">
				<ul class="uk-pagination"></ul>
			</div>
			<div class="uk-width-1-4 uk-text-right">
				<button type="button" class="uk-button uk-button-primary" ng-click="newItem()">
					<i class="uk-icon-plus uk-icon-small"></i>
				</button>
			</div>
		</div>
	</div>
	
	<?php 
		
		$data = array(
			'panel_name' => 'propertiesPanel',
			'action' => base_url('/user/rest/user'),
			'allow_delete' => TRUE);

		$data['header'] = $this->load->view("admin/common/properties_header", $data, TRUE);
		$data['body'] = $this->load->view("user/properties/user_properties", $data, TRUE);
		$data['footer'] = $this->load->view("admin/common/properties_footer", $data, TRUE);
		
		$this->load->view("admin/common/properties_panel", $data);
	?>

</div>