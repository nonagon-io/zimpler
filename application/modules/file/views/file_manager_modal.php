<div class="n-file-browser uk-modal">
	<div class="uk-modal-dialog uk-modal-dialog-large">
		<a class="uk-close" ng-click="fileManagerPopup.close()"></a>
		<div class="uk-modal-header">
			<h2>File Manager</h2>
		</div>
		<div class="n-modal-body">
			<?php $this->load->view('file_manager', 
				array('item_deletable' => TRUE, 'item_selectable' => TRUE)) ?>
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
