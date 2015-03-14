<div class="n-abs-fit uk-form" ng-controller="CmsNavigationController"
	 ng-init="restBaseUrl = '<?= base_url('/cms/rest/navigation') ?>'; refreshRev(); refreshItems();">
	<div class="n-options-header" 
		 ng-class="{'n-drop-shadow': mainContentBodyScrollTop > 0}">
		<div class="uk-grid uk-grid-divider uk-grid-preserve">
			<div class="uk-width-1-2" style="padding-right: 10px">
				<div class="uk-grid uk-grid-preserve uk-grid-small">
					<div class="uk-width-1-3">
						<div class="uk-button-group">
							<a class="uk-button" title="Columns View" data-uk-tooltip="" 
							   ng-class="{'uk-active': view == 'columns'}"
							   ng-click="view = 'columns'">
								<i class="uk-icon-columns"></i>
							</a>
							<a class="uk-button" title="Sitemap View" data-uk-tooltip=""
							   ng-class="{'uk-active': view == 'sitemap'}"
							   ng-click="view = 'sitemap'">
								<i class="uk-icon-sitemap"></i>
							</a>
						</div>
					</div>
					<div class="uk-width-2-3 uk-text-right">
						<div class="uk-display-inline-block uk-vertical-align-middle" 
							 ng-if="currentStatus != null" ng-cloak="" style="margin-top: 5px;">
							Rev. {{currentRevision}}
						</div>
						<div class="uk-display-inline-block uk-text-primary uk-vertical-align-middle ng-hide" 
							 ng-show="currentStatus == 'published'" style="margin-top: 5px;">
							Published
						</div>
						<button type="button" class="uk-button uk-button-danger ng-hide">
							<i class="uk-icon-trash"></i>
						</button>
					</div>
				</div>
			</div>
			<div class="uk-width-1-2" style="padding-left: 10px">
				<div class="uk-grid uk-grid-preserve uk-grid-small">
					<div class="uk-width-1-3">
						<button type="button" class="uk-button uk-button-primary"
								ng-click="publish()"
								ng-if="currentStatus == 'draft'">
							Publish
						</button>
						<button type="button" class="uk-button uk-button-success"
								ng-click="newRev()"
								ng-if="currentStatus == 'published'">
							New Revision
						</button>
						&nbsp;
					</div>
					<div class="uk-width-2-3 uk-text-right">
						<select id="cultureSelection" name="culture">
							<option value="en-us" <?= $culture == 'en-us' ? 'selected' : '' ?>>English</option>
							<option value="th-th" <?= $culture == 'th-th' ? 'selected' : '' ?>>Thai</option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="n-content n-single-page" ng-style="{ right: contentRight() + 'px' }">
		<div class="n-columns-view n-sortable-container" ng-show="view == 'columns'">
			<div class="n-column" ng-repeat="level in levels" ng-cloak="" n-horz-stack="{{$index}}">
				<div class="n-title">
					<div class="uk-grid uk-margin-remove">
						<div class="uk-width-2-3">
							<div class="uk-margin-small-top">
								Level {{level.number}}
							</div>
						</div>
						<div class="uk-width-1-3 uk-text-right">
							<button type="button" class="uk-button uk-button-primary"
									ng-click="addItem(level)"
									ng-disabled="propertiesPanel.isOpen || currentStatus == 'published'">
								<i class="uk-icon-plus"></i>
							</button>
						</div>
					</div>
				</div>
				<ul class="n-items" ui-sortable="sortableOptions" ng-model="level.items" n-scroll-record="">
					<li class="n-item" ng-repeat="item in level.items" 
						ng-class="{'uk-active': item.id == editingData.id, 'n-drilling-down': item.expanded}"
						ng-click="edit(item, level, $index)"
						n-item-loaded="activateItem($event, item)">
						<div class="uk-grid uk-grid-preserve uk-grid-small">
							<div class="uk-width-1-10">
								<i class="uk-icon-bars n-handle"></i>
							</div>
							<div class="uk-width-7-10" ng-class="{'uk-text-danger': !item.publicTitle}">
								{{item.publicTitle || item.key}}
							</div>
							<div class="uk-width-2-10 uk-text-right">
								<button type="button" class="uk-button" style="margin: -5px -5px 0 0"
										ng-click="expand(level, item, $event)" ng-show="!item.expanded">
									<i class="uk-icon-plus-square-o"></i>
								</button>
								<button type="button" class="uk-button ng-hide" style="margin: -5px -5px 0 0"
										ng-click="collapse(level, item, $event)" ng-show="item.expanded">
									<i class="uk-icon-minus-square-o"></i>
								</button>
							</div>
						</div>
					</li>
				</ul>
			</div>
		</div>
		<div class="n-sitemap-view n-sortable-container" ng-show="view == 'sitemap'">
			<ul class="n-level uk-text-center">
				<li class="n-item uk-panel uk-panel-box uk-display-inline-block uk-margin-top">
					<?= $this->config->item('site_title') ?>
					<div class="n-connector"></div>
				</li>
			</ul>
			<div class="n-levels-container" ng-repeat="level in levels">
				<ul class="n-items n-level uk-text-center" ng-cloak="" ui-sortable="sortableOptions" ng-model="level.items">
					<li class="n-item uk-panel uk-panel-box uk-margin-top"
						ng-repeat="item in level.items"
						ng-class="{'uk-active': item.id == editingData.id, 'n-drilling-down': item.expanded}"
						n-item-loaded="activateItem($event, item)">
						<a class="n-label" ng-click="edit(item, level, $index)">{{item.publicTitle || item.key}}</a>
						<div class="n-tail">
							<i class="uk-icon-plus-square-o" ng-click="expand(level, item, $event)" 
							   ng-show="!item.expanded"></i>
							<i class="uk-icon-minus-square-o" ng-click="collapse(level, item, $event)" 
							   ng-show="item.expanded"></i>
						</div>
						<div class="n-connector" ng-show="item.expanded"></div>
					</li>
				</ul>
				<button type="button" class="n-button uk-button uk-button-small" 
						ng-click="addItem(level)"
						ng-hide="propertiesPanel.isOpen">
					<i class="uk-icon-plus"></i>
				</button>
			</div>
		</div>
	</div>
	
	<?php 
		
		$data = array(
			'panel_name' => 'propertiesPanel',
			'action' => base_url('/cms/rest/navigation/item'),
			'allow_delete' => TRUE);
		
		$data['header'] = $this->load->view("cms/common/properties_header", $data, TRUE);
		$data['body'] = $this->load->view("cms/properties/nav_properties", $data, TRUE);
		$data['footer'] = $this->load->view("cms/common/properties_footer", $data, TRUE);
		
		$this->load->view('admin/common/properties_panel', $data);
	?>

	<div class="n-abs-fit n-progress-panel" ng-show="loading">
		<div class="uk-height-1-1 uk-vertical-align uk-text-center">
			<div class="uk-vertical-align-middle">
				<i class="uk-icon-spinner uk-icon-spin uk-icon-medium"></i>
			</div>
		</div>
	</div>

</div>