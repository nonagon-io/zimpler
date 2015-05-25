<div class="n-content n-abs-fit uk-form" 
	 ng-controller="UserListController" 
	 ng-init="restBaseUrl = '<?= base_url('/user/rest') ?>'; currentUserId = <?= $current_user_id ?>;">
	<div class="n-options-header" 
		 ng-class="{'n-drop-shadow': mainContentBodyScrollTop > 0}">
		<div class="uk-grid uk-grid-collapse">
			<div class="uk-width-2-3">
				<input type="text" placeholder="Keyword" ng-model="searchKeyword" ng-keydown="detectSearch($event)"
					   style="width: 300px"/>
				<button type="button" class="uk-button uk-button-primary" ng-click="search()">
					<i class="uk-icon-search"></i> Search
				</button>
				<button type="button" class="uk-button uk-button-danger" ng-click="clearSearch()"
						ng-show="isKeywordActive">
					<i class="uk-icon-times"></i> Clear
				</button>
			</div>
			<div class="uk-width-1-3 uk-text-right">
				<div class="uk-margin-small-top">
					Total Users: <?= $total_users ?> 
				</div>
			</div>
		</div>
	</div>
	<div class="n-list n-user-list" ng-init="refresh()">
		<table class="n-table uk-table uk-table-striped">
			<thead>
				<tr>
					<th style="width: 20px" class="uk-text-center"><input type="checkbox" /></th>
					<th style="width: 250px">Username</th>
					<th>Name</th>
					<th style="width: 250px">Email</th>
					<th style="width: 200px">Last Login</th>
					<th style="width: 80px">Status</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="item in list.items"
					ng-class="{'uk-active': selectedItem.id == item.id, 'n-selected': item.checked}">
					<td class="uk-text-center">
						<input type="checkbox" ng-model="item.checked" ng-disabled="selectedItem" />
					</td>
					<td ng-bind="item.username" ng-click="select(item)"></td>
					<td ng-bind="item.name" ng-click="select(item)"></td>
					<td ng-bind="item.email" ng-click="select(item)"></td>
					<td ng-bind="item.lastLogin * 1000 | date:'yyyy-MM-dd HH:mm:ss Z'" ng-click="select(item)"></td>
					<td ng-bind="item.status ? 'Active' : 'Inactive'" ng-click="select(item)"></td>
				</tr>
			</tbody>
		</table>
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
				<button type="button" class="uk-button uk-button-primary ng-hide" ng-click="newItem()">
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