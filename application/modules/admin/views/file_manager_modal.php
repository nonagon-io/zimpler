<div class="n-file-browser uk-modal">
	<div class="uk-modal-dialog uk-modal-dialog-large">
		<div class="uk-close"></div>
		<div class="uk-modal-header">
			<h2>File Manager</h2>
		</div>
		<div class="n-modal-body">
			<?php $this->load->view('file_manager') ?>
		</div>
		<div class="uk-modal-footer">
			<div class="uk-grid uk-grid-collapse">
				<div class="uk-width-1-2">
					<button class="uk-button uk-button-success"
							ngf-select
						    ng-model="fileManager.scope.upload.uploadList"
						    ng-model-rejected="fileManager.scope.upload.rejectedList"
						    ngf-multiple="true"
						    ngf-capture="'camera'"
						    accept="video/*, audio/*, image/*, .docx, .xlsx, .pptx, .pdf, .txt, .md, .zip"
						    ngf-keep="true"
						    ngf-keep-distinct="true"
						    ngf-reset-on-click="true"
						    ngf-reset-model-on-click="true">Upload</button>
					&nbsp;
					You can also drag and drop the files on above panel.
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
