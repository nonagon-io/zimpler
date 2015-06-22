<div class="n-file-manager n-abs-fit" ng-controller="FileManagerController" ng-init="refresh();">
	<div class="ng-hide" ng-show="initialized">
		<div class="n-options-header uk-form" 
			 ng-class="{'n-drop-shadow': fileScrollTop > 0}">
			<div class="uk-grid uk-grid-collapse">
				<div class="uk-width-1-2 uk-width-medium-2-3">
					<div class="uk-button-group">
						<button type="button" class="uk-button n-tool-button"
								ng-class="{'uk-active': viewMode == 'tile'}"
								ng-click="switchToTileMode()">
							<i class="uk-icon-th"></i>
						</button>
						<button type="button" class="uk-button n-tool-button"
								ng-class="{'uk-active': viewMode == 'columns'}"
								ng-click="switchToColumnsMode()">
							<i class="uk-icon-columns"></i>
						</button>
					</div>
				</div>
				<div class="uk-width-1-2 uk-width-medium-1-3 uk-text-right">
					<button class="uk-button" ng-click="newFolder()">
						<i class="uk-icon-plus"></i> New Folder
					</button>
					<button class="uk-button uk-button-success"
							ngf-select
						    ng-model="upload[path].uploadList"
						    ng-model-rejected="upload[path].rejectedList"
						    ngf-multiple="true"
						    ngf-capture="'camera'"
						    accept="video/*, audio/*, image/*, .docx, .xlsx, .pptx, .pdf, .txt, .md, .zip"
						    ngf-keep="true"
						    ngf-keep-distinct="true"
						    ngf-reset-on-click="true"
						    ngf-reset-model-on-click="true">
						<i class="uk-icon-upload"></i> Upload
					</button>
				</div>
			</div>
		</div>

		<div class="n-files-zone n-abs-fit uk-overflow-container">
			<div class="n-folder-container" ng-if="folders.length > 0 || paths.length > 0"
				 ng-class="{'n-snap-left n-overflow-container': viewMode == 'columns'}">
				<ul class="uk-breadcrumb" ng-if="paths.length > 0 &amp;&amp; viewMode == 'tile'">
					<li><a ng-click="drillUp('/')">Root</a></li>
					<li ng-repeat="name in paths">
						<a ng-click='drillUp(paths.length - ($index + 1))' ng-if="!$last">
							{{name}}
						</a>
						<span ng-if="$last">
							{{name}}
						</span>
					</li>
				</ul>
				<div data-uk-grid="{gutter: 20}" 
					 class="n-folder-list uk-grid-width-1-1 uk-grid-width-small-1-3 
					 		uk-grid-width-medium-1-5 uk-grid-width-large-1-8">
					<div class="n-folder-item" ng-if="paths.length > 0">
						<div class="uk-panel-box uk-panel-box-primary uk-text-center" ng-click="drillUp()"
							 data-drop="true" data-jqyoui-options="{hoverClass: 'n-droppable-hover'}" 
							 jqyoui-droppable="{onDrop: 'onFileDrop()'}" />
							<div class="uk-text-center">
								<i class="uk-icon-folder-open uk-icon-large"></i>
							</div>
							<div class="uk-margin-small-top uk-text-small uk-text-primary uk-text-center">
								<label>..</label>
							</div>
						</div>
					</div>
					<div ng-repeat="item in folders" class="n-folder-item">
						<div class="uk-panel-box uk-panel-box-primary" ng-click="drillDown(item)"
							 data-drop="true" data-jqyoui-options="{hoverClass: 'n-droppable-hover'}" 
							 jqyoui-droppable="{onDrop: 'onFileDrop(item)'}">
							<?php if(isset($item_deletable) && $item_deletable) : ?>
							<a class="n-delete uk-button uk-button-danger" ng-click="deleteFolder($event, item)">
								<i class="uk-icon-trash"></i>
							</a>
							<?php endif ?>
							<div class="uk-text-center">
								<i class="uk-icon-folder uk-icon-large"></i>
							</div>
							<div class="uk-margin-small-top uk-text-small uk-text-primary uk-text-center">
								<label>{{item.name}}</label>
							</div>
						</div>
					</div>
				</div>
				<hr ng-if="viewMode != 'columns'" />
			</div>
			<div ng-class="{'n-blank-left': viewMode == 'columns'}">
				<ul class="uk-breadcrumb" ng-if="paths.length > 0 &amp;&amp; viewMode == 'columns'">
					<li><a ng-click="drillUp('/')">Root</a></li>
					<li ng-repeat="name in paths">
						<a ng-click='drillUp(paths.length - ($index + 1))' ng-if="!$last">
							{{name}}
						</a>
						<span ng-if="$last">
							{{name}}
						</span>
					</li>
				</ul>
				<div ng-if="upload[path].uploadList.length">
					<h2 class="uk-text-muted"><i>Uploading...</i></h2>
					<div data-uk-grid="{gutter: 20}" 
						 class="n-upload-list uk-grid-width-1-1"
						 ng-class="{'uk-grid-width-small-1-3 uk-grid-width-large-1-5': viewMode == 'tile',
									'uk-grid-width-medium-1-2 uk-grid-width-large-1-4': viewMode == 'columns'}">
						<div ng-repeat="item in upload[path].uploadList" class="n-upload-item n-uploading"
							 ng-class="{'uk-active': selectedItem == item}">
							<div class="uk-panel-box uk-text-center" 
								 <?php if(isset($item_selectable) && $item_selectable) : ?>
								 ng-click="select(item)" 
								 <?php endif ?>>

								<?php if(isset($item_deletable) && $item_deletable) : ?>
								<a class="n-delete uk-button uk-button-danger" ng-click="deleteUpload(item)">
									<i class="uk-icon-trash"></i>
								</a>
								<?php endif ?>
								<img ngf-src="item"
								     ngf-default-src="'placeholder.jpg'"
								     ngf-accept="'image/*'" /> 
								<div class="uk-margin-small-top uk-text-small uk-text-primary uk-text-center">
									<label>{{item.name}}</label>
								</div>
								<div class="uk-margin-small-top uk-text-small uk-text-center">
									<label>{{item.size | filesize}}</label>
								</div>
								<div class="uk-margin-small-top uk-text-small uk-text-muted uk-text-center"
									 ng-hide="item.uploadError">
									<div class="uk-progress uk-progress-mini">
									    <div class="uk-progress-bar" ng-style="getProgressStyle(item)"></div>
									</div>
								</div>
								<div ng-if="item.uploadError">
									<i class="uk-icon-times-circle uk-text-danger"></i>
									<span class="uk-text-small uk-text-danger">{{item.errorMessage}}</span>
								</div>
							</div>
						</div>
					</div>
					<hr/>
				</div>
				<div data-uk-grid="{gutter: 20}" 
					 class="n-file-list uk-grid-width-1-1"
					 ng-class="{'uk-grid-width-small-1-3 uk-grid-width-large-1-5': viewMode == 'tile',
								'uk-grid-width-medium-1-2 uk-grid-width-large-1-4': viewMode == 'columns'}">
					<div ng-repeat="item in files" class="n-file-item" ng-class="{'uk-active': selectedItem == item}">
						<div class="uk-panel-box uk-text-center" 
							 data-drag="true" 
							 jqyoui-draggable="{animate: true, 
							 					onStart: 'onDragStart(item)', 
							 					onStop: 'onDragStop(item)'}"
							 data-jqyoui-options="{revert: 'invalid'}" ng-model="item"
							 <?php if(isset($item_selectable) && $item_selectable) : ?>
							 ng-click="select(item)" 
							 <?php endif ?>
							 ng-dblclick="preview(item)">
							<?php if(isset($item_deletable) && $item_deletable) : ?>
							<a class="n-delete uk-button uk-button-danger" ng-click="deleteFile(item)">
								<i class="uk-icon-trash"></i>
							</a>
							<?php endif ?>
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
		</div>
	</div>

	<div class="n-abs-fit n-progress-mask uk-text-center uk-vertical-align" ng-show="isRefreshing">
		<div class="uk-vertical-align-middle">
			<i class="uk-icon-spinner uk-icon-spin"></i>
		</div>
	</div>

	<div class="n-drop-zone n-abs-fit"
		 ngf-drop="true"
	     ng-model="upload[path].uploadList"
	     ng-model-rejected="upload[path].rejectedList"
	     ngf-change="fileDropped($files, $event, $rejectedFiles)"
	     ngf-multiple="true"
	     ngf-capture="'camera'"
	     ngf-keep="true"
	     ngf-keep-distinct="true"
	     accept="video/*, audio/*, image/*, .docx, .xlsx, .pptx, .pdf, .txt, .md, .zip"
	     ngf-allow-dir="true"
	     ngf-drag-over-class="{accept:'n-file-drop-accept', reject:'n-file-drop-reject', delay:100}"
	     ngf-drop-available="upload.dropSupported"
	     ngf-stop-propagation="true"
	     ngf-hide-on-drop-not-available="true">
		<div class="n-decor uk-vertical-align uk-text-center">
			<div class="uk-vertical-align-middle">
				<i class="uk-icon-folder-open uk-icon-large"></i>
				<h3>/{{path}}</h3>
				<h1 class="uk-text-muted">Drop files here</h1>
			</div>
		</div>
	</div>

	<div class="n-create-folder-dialog uk-modal uk-form">
		<div class="uk-modal-dialog">
			<div class="uk-modal-header">
				<h2>New Folder</h2>
			</div>
			<div class="n-modal-body">
				<label>Folder Name</label>
				<input type="text" class="uk-width-1-1 uk-margin-small-top" maxlength="30" 
					   ng-model="newFolderName" placeholder="Folder name must be unique" />
			</div>
			<div class="uk-modal-footer">
				<div class="uk-grid uk-grid-collapse">
					<div class="uk-width-1-2">
						<div ng-show="newFolderNameDuplicated" class="uk-text-danger">
							<i class="uk-icon-times-circle"></i>
							The folder is already exists.
						</div>
						<div ng-show="!newFolderNameDuplicated &amp;&amp; 
									  !newFolderNameValid &amp;&amp; 
									   newFolderName" 
							 class="uk-text-danger">
							<i class="uk-icon-times-circle"></i>
							Invalid folder name.
						</div>
						<div ng-show="newFolderCreating">
							<i class="uk-icon-spinner uk-icon-spin"></i>
							Creating...
						</div>
					</div>
					<div class="uk-width-1-2 uk-text-right">
						<button class="uk-button uk-button-primary"
								ng-click="commitNewFolder()"
								ng-disabled="!newFolderNameValid || newFolderCreating"
								style="width: 80px">
							OK
						</button>
						<button class="uk-button" ng-click="cancelNewFolder()"
								style="width: 80px">
							Cancel
						</button>
					</div>
				</div>
				<div class="uk-alert uk-alert-warning uk-margin-top" ng-show="newFolderServerError">
					We have communication error. Please try again later.
				</div>
			</div>
		</div>
	</div>
</div>