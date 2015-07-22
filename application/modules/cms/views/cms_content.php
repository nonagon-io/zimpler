<div class="n-content n-abs-fit uk-form" ng-controller="CmsContentController">
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
				<select id="cultureSelection" name="culture">
					<?php foreach($enabled_languages as $code) : ?>
					<option value="<?= $code ?>" <?= $culture == $code ? 'selected' : '' ?>>
						<?= explode(' (', $languages[$code])[0] . 
							(isset(explode('-', $code)[1]) ? ' (' . strtoupper(explode('-', $code)[1]) . ')' : '') ?>
					</option>
					<?php endforeach ?>
				</select>
			</div>
		</div>
	</div>
	<div class="n-list n-content-list">
		<div id="list-container" class="n-abs-fit uk-overflow-container">
			<table class="n-table uk-table uk-table-striped">
				<thead>
					<tr>
						<th style="width: 20px" class="uk-text-center">
							<input type="checkbox" />
						</th>
						<th>Title</th>
						<th style="width: 100px">Group</th>
						<th style="width: 90px">Type</th>
						<th style="width: 30px">Rev.</th>
						<th style="width: 200px">Modified</th>
						<th style="width: 80px; text-align: center">Status</th>
					</tr>
				</thead>
				<tbody ng-class="{'n-check-activated': checkableListManager.isCheckActivated}">
					<tr ng-repeat="item in list.items"
						ng-class="{'uk-active': selectedItem.id == item.id, 'n-selected': item.checked}"
						n-scroll-if="item.id == lastEditedItem.id" scroll-container="#list-container"
						n-item-loaded="activateItem($event, item)">
						<td class="uk-text-center">
							<input type="checkbox" ng-model="item.checked" 
								   ng-change="checkableListManager.itemCheckStateChanged()" 
								   ng-disabled="selectedItem" />
						</td>
						<td ng-click="select(item)">
							<div ng-bind="item.publicTitle || item.title"
								 ng-class="{'uk-text-danger': !item.publicTitle}"></div>
							<div ng-bind="item.description" class="uk-text-muted uk-text-small"></div>
						</td>
						<td ng-bind="item.group" ng-click="select(item)"></td>
						<td ng-bind="item.displayType" ng-click="select(item)"></td>
						<td ng-bind="item.revision" ng-click="select(item)"></td>
						<td ng-bind="item.modified | date:'yyyy-MM-dd hh:mm:ss a'" ng-click="select(item)"></td>
						<td ng-bind="item.status || 'n/a'" ng-click="select(item)"
							ng-class="{'uk-text-muted': !item.status}" 
							style="text-align: center; text-transform: capitalize"></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="n-abs-fit uk-vertical-align uk-text-center n-progress-panel" ng-show="isRefreshing">
			<div class="uk-vertical-align-middle">
				<i class="uk-icon-spinner uk-icon-spin uk-icon-medium"></i>
			</div>
		</div>
	</div>
	<div class="n-controller">
		<div class="uk-grid uk-grid-collapse" ng-hide="checkableListManager.isCheckActivated">
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
		<div class="uk-grid uk-grid-collapse" ng-show="checkableListManager.isCheckActivated">
			<div class="uk-width-1-4">
				<div ng-cloak="" class="uk-margin-small-top">
					<ng-pluralize count="checkableListManager.checkedItems.length"
					    when="{'0': 'Nothing selected',
					    	   'one': '1 item selected',
					           'other': '{} items selected'}">
					</ng-pluralize>
				</div>
			</div>
			<div class="uk-width-3-4 uk-text-right">
				<button type="button" class="uk-button uk-button-primary" ng-click="publishSelected()">
					Publish
				</button>
				<button type="button" class="uk-button uk-button-danger" ng-click="deleteSelected()">
					<i class="uk-icon-trash uk-icon-small"></i> Delete
				</button>
			</div>
		</div>
	</div>
	
	<?php 
		
		$data = array(
			'panel_name' => 'propertiesPanel',
			'action' => base_url('/cms/rest/content'),
			'allow_delete' => TRUE,
			'allow_publish' => TRUE);

		$data['header'] = $this->load->view("cms/common/properties_header", $data, TRUE);
		$data['body'] = $this->load->view("cms/properties/content_properties", $data, TRUE);
		$data['footer'] = $this->load->view("cms/common/properties_footer", $data, TRUE);
		
		$this->load->view("admin/common/properties_panel", $data);
	?>

</div>