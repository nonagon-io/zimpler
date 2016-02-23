<div class="n-file-browser uk-modal">
	<div class="uk-modal-dialog uk-modal-dialog-large">
		<a class="uk-close" ng-click="fileManagerPopup.close()"></a>
		<div class="uk-modal-header">
			<h2>File Manager</h2>
		</div>
		<div class="n-modal-body">
			<?php $this->load->view('file_manager', 
				array('item_deletable' => TRUE, 'item_selectable' => TRUE)) ?>
			<div class="n-blocker ng-hide" ng-show="fileManager.scope.itemToDelete || fileManager.scope.isDeleting">
				<div class="uk-panel uk-panel-box">
					<i class="uk-icon-exclamation-circle uk-text-danger uk-icon-medium"></i>
					Are you sure you want to delete this file?
					<div class="uk-margin-top uk-text-right">
						<button type="button" class="uk-button uk-margin-small-right" 
								ng-click="fileManager.scope.itemToDelete = null">No</button>
						<button type="button" class="uk-button uk-button-danger" 
								ng-click="fileManager.scope.deleteProceed()"
								ng-disabled="fileManager.scope.isDeleting">
							<i class="uk-icon-spinner uk-icon-spin" ng-show="fileManager.scope.isDeleting"></i> 
							Yes
						</button>
					</div>
				</div>
			</div>
		</div>
		<div class="uk-modal-footer">
			<div class="uk-grid uk-grid-collapse">
				<div class="uk-width-1-2">
					&nbsp;
				</div>
				<div class="uk-width-1-2 uk-text-right">
					<button class="uk-button uk-button-primary"
							ng-click="fileManagerPopup.commit()"
							ng-disabled="!fileManager.scope.selectedItem"
							style="width: 80px">
						OK
					</button>
					<button class="uk-button" ng-click="fileManagerPopup.close()"
							style="width: 80px">
						Cancel
					</button>
				</div>
			</div>
		</div>
	</div>
</div>
