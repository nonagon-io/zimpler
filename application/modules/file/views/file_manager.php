<div class="n-file-manager n-abs-fit" 
	 ng-controller="FileManagerController"
	 ng-init="baseUrl = '<?= base_url(''); ?>'; refresh();">

	<div class="ng-hide" ng-show="initialized">
		<div class="n-files-zone n-abs-fit uk-overflow-container">
			<div data-uk-grid="{gutter: 20}" 
				 class="n-folder-list uk-grid-width-1-1 uk-grid-width-small-1-3 
				 		uk-grid-width-medium-1-5 uk-grid-width-large-1-8">
				<div class="n-folder-item" ng-if="paths.length > 0">
					<div class="uk-panel-box uk-panel-box-primary uk-text-center" ng-click="drillUp()">
						<div class="uk-text-center">
							<i class="uk-icon-folder-open uk-icon-large"></i>
						</div>
						<div class="uk-margin-small-top uk-text-small uk-text-primary uk-text-center">
							<label>..</label>
						</div>
					</div>
				</div>
				<div ng-repeat="item in folders" class="n-folder-item">
					<div class="uk-panel-box uk-panel-box-primary" ng-click="drillDown(item)">
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
			<hr/>
			<div ng-if="upload[path].uploadList.length">
				<h2 class="uk-text-muted"><i>Uploading...</i></h2>
				<div data-uk-grid="{gutter: 20}" 
					 class="n-upload-list uk-grid-width-1-1 uk-grid-width-small-1-3 
					 		uk-grid-width-medium-1-5 uk-grid-width-large-1-8">
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
							<div class="uk-margin-small-top uk-text-small uk-text-muted uk-text-center">
								<label>{{item.lastModified | date : 'medium'}}</label>
							</div>
						</div>
					</div>
				</div>
				<hr/>
			</div>
			<div data-uk-grid="{gutter: 20}" 
				 class="n-file-list uk-grid-width-1-1 uk-grid-width-small-1-3 
				 		uk-grid-width-medium-1-5 uk-grid-width-large-1-8">
				<div ng-repeat="item in files" class="n-file-item" ng-class="{'uk-active': selectedItem == item}">
					<div class="uk-panel-box uk-text-center" 
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

	<div class="n-abs-fit n-progress-mask uk-text-center uk-vertical-align"
		 ng-show="isRefreshing">
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
				<h1 class="uk-text-muted">Drop files here</h1>
			</div>
		</div>
	</div>
</div>