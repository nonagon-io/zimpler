<div class="n-abs-fit uk-form" ng-controller="CmsNavigationController"
	 ng-init="baseUrl = '<?= base_url("/admin/cms/navigations"); ?>'">
	<div class="n-options-header" 
		 ng-class="{'n-drop-shadow': mainContentBodyScrollTop > 0}">
		<div class="uk-grid uk-grid-divider uk-grid-preserve">
			<div class="uk-width-1-2" style="padding-right: 10px">
				<div class="uk-grid uk-grid-preserve uk-grid-small">
					<div class="uk-width-2-3">
						<div class="uk-button-group">
							<a class="uk-button" title="Columns View" data-uk-tooltip=""><i class="uk-icon-columns"></i></a>
							<a class="uk-button" title="Sitemap View" data-uk-tooltip=""><i class="uk-icon-sitemap"></i></a>
							<a class="uk-button" title="List View" data-uk-tooltip=""><i class="uk-icon-th-list"></i></a>
						</div>
					</div>
					<div class="uk-width-1-3 uk-text-right">
						<div class="uk-text-primary ng-hide" style="margin-top: 5px;">Published</div>
						<button type="button" class="uk-button uk-button-danger ng-hide">
							<i class="uk-icon-trash"></i>
						</button>
					</div>
				</div>
			</div>
			<div class="uk-width-1-2" style="padding-left: 10px">
				<div class="uk-grid uk-grid-preserve uk-grid-small">
					<div class="uk-width-1-3">
						<button type="button" class="uk-button uk-button-primary" style="width:80px">
							Publish
						</button>
					</div>
					<div class="uk-width-2-3 uk-text-right">
						<div class="uk-display-inline-block">Rev. 1</div>
						<select id="cultureSelection" name="culture">
							<option value="en-us" <?= $culture == 'en-us' ? 'selected' : '' ?>>English</option>
							<option value="th-th" <?= $culture == 'th-th' ? 'selected' : '' ?>>Thai</option>
						</select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="n-content n-single-page">
		<div class="n-columns-view">
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
									ng-click="addItem($index)">
								<i class="uk-icon-plus"></i>
							</button>
						</div>
					</div>
				</div>
				<ul class="n-items" ui-sortable="sortableOptions" ng-model="level.items">
					<li class="n-item" ng-repeat="item in level.items" 
						ng-class="{'uk-active': item == editingData, 'n-drilling-down': item.expanded}"
						ng-click="edit(item)">
						<div class="uk-grid uk-grid-preserve uk-grid-small">
							<div class="uk-width-1-10">
								<i class="uk-icon-bars n-handle"></i>
							</div>
							<div class="uk-width-7-10">
								{{item.name}}
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
	</div>
</div>