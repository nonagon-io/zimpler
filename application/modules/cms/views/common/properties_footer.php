<div class="uk-grid uk-grid-collapse uk-margin-small-top">
	<div class="uk-width-1-5">
		<?php if(isset($allow_delete) && $allow_delete) : ?>
		<button type="button" class="uk-button uk-button-danger" 
				ng-click="<?= $panel_name ?>.delete()"
				ng-if="editingData.id"
				style="width: auto">
			<i class="uk-icon-trash"></i>
		</button>
		<?php endif ?>
	</div>
	<div class="uk-width-4-5 uk-text-right">
		<?php if(isset($allow_publish) && $allow_publish) : ?>
		<button type="button" class="uk-button uk-button-primary" 
				ng-if="editingData.status != 'published'"
				ng-disabled="!<?= $panel_name ?>.publishable()"
				ng-click="<?= $panel_name ?>.publish($event, { alsoClose: true })">
			Publish
		</button>
		<?php endif ?>
		<?php if(isset($allow_publish) && $allow_publish) : ?>
		<button type="button" class="uk-button uk-button-primary" 
				ng-if="editingData.status == 'published'"
				ng-disabled="!<?= $panel_name ?>.propertiesForm.$valid"
				ng-click="<?= $panel_name ?>.new()">
			New
		</button>
		<button type="button" class="uk-button uk-button-danger" 
				ng-if="editingData.status == 'draft' && editingData.revision > 1"
				ng-click="<?= $panel_name ?>.delete()"
				style="width: auto">
			<i class="uk-icon-trash"></i>
		</button>
		<?php endif ?>
		<button type="submit" class="uk-button uk-button-success">
			Save <span ng-show="<?= $panel_name ?>.propertiesForm.$dirty">*</span>
		</button>
		<button type="button" class="uk-button" ng-click="<?= $panel_name ?>.close()">
			<span ng-if="editingData.status == 'published'">Close</span>
			<span ng-if="editingData.status == 'draft' || !editingData.status">Cancel</span>
		</button>
	</div>
</div>
