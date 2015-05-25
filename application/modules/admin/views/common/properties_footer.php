<div class="uk-grid uk-margin-small-top">
	<div class="uk-width-1-5">
		<?php if(isset($allow_delete) && $allow_delete) : ?>
		<button type="button" class="uk-button uk-button-danger" 
				ng-click="<?= $panel_name ?>.delete()"
				ng-if="editingData.allowDelete"
				style="width: auto">
			<i class="uk-icon-trash"></i>
		</button>
		<?php endif ?>
	</div>
	<div class="uk-width-4-5 uk-text-right">
		<button type="submit" class="uk-button uk-button-success" ng-if="currentStatus != 'published'">
			Save <span ng-show="<?= $panel_name ?>.propertiesForm.$dirty">*</span>
		</button>
		<button type="button" class="uk-button" ng-click="<?= $panel_name ?>.close()">
			Cancel
		</button>
	</div>
</div>
