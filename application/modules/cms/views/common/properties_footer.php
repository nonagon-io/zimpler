<div class="uk-grid uk-grid-collapse uk-margin-small-top">
	<div class="uk-width-1-5">
		<?php if(isset($allow_delete) && $allow_delete) : ?>
		<button type="button" class="uk-button uk-button-danger" 
				ng-click="<?= $panel_name ?>.delete()"
				ng-if="editingData.id && (
						editingData.revision == 1 || editingData.status == 'published')" 
				style="width: auto"
				ng-hide="<?= $panel_name ?>.isCommandsHidden">
			<i class="uk-icon-trash"></i>
		</button>
		<button type="button" class="uk-button n-button-warning" 
				ng-click="<?= $panel_name ?>.deleteRev()"
				ng-if="editingData.revision > 1 && editingData.status == 'draft'" 
				style="width: auto"
				ng-hide="<?= $panel_name ?>.isCommandsHidden">
			<i class="uk-icon-trash"></i>
		</button>
		<?php endif ?>
	</div>
	<div class="uk-width-4-5 uk-text-right">
		<?php if(isset($allow_publish) && $allow_publish) : ?>
		<button type="button" class="uk-button uk-button-primary" 
				ng-if="editingData.status != 'published'"
				ng-disabled="!<?= $panel_name ?>.publishable()"
				ng-click="<?= $panel_name ?>.publish($event, { alsoClose: true })"
				ng-hide="<?= $panel_name ?>.isCommandsHidden">
			Publish
		</button>
		<?php endif ?>
		<?php if(isset($allow_publish) && $allow_publish) : ?>
		<button type="button" class="uk-button uk-button-primary" 
				ng-if="editingData.status == 'published'"
				ng-disabled="!<?= $panel_name ?>.propertiesForm.$valid"
				ng-click="<?= $panel_name ?>.newRevision()"
				ng-hide="<?= $panel_name ?>.isCommandsHidden">
			New
		</button>
		<?php endif ?>
		<button type="submit" class="uk-button uk-button-success"
				ng-hide="<?= $panel_name ?>.isCommandsHidden">
			Save <span ng-show="<?= $panel_name ?>.propertiesForm.$dirty">*</span>
		</button>
		<button type="button" class="uk-button" ng-click="<?= $panel_name ?>.close()">
			<span>Cancel</span>
		</button>
	</div>
</div>
