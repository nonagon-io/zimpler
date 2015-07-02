<div class="uk-grid uk-margin-small-top">
	<div class="uk-width-1-5">
		<?php if(isset($allow_delete) && $allow_delete) : ?>
		<button type="button" class="uk-button uk-button-danger" 
				ng-click="<?= $panel_name ?>.delete()"
				ng-if="editingData.status != 'published'"
				style="width: auto">
			<i class="uk-icon-trash"></i>
		</button>
		<?php endif ?>
		<?php if(isset($allow_publish) && $allow_publish) : ?>
		<button type="button" class="uk-button uk-button-primary" 
				ng-if="editingData.status != 'published'"
				ng-disabled="!<?= $panel_name ?>.propertiesForm.$valid"
				ng-click="<?= $panel_name ?>.publish()">
			Publish
		</button>
		<span class="uk-margin-small-top uk-text-primary uk-display-inline-block" 
			  ng-if="editingData.status == 'published'">
			Published
		</span>
		<?php else : ?>
		&nbsp;
		<?php endif ?>
	</div>
	<div class="uk-width-4-5 uk-text-right">
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
		<button type="submit" class="uk-button uk-button-success" ng-if="editingData.status != 'published'">
			Save <span ng-show="<?= $panel_name ?>.propertiesForm.$dirty">*</span>
		</button>
		<button type="button" class="uk-button" ng-click="<?= $panel_name ?>.close()">
			<span ng-if="editingData.status == 'published'">Close</span>
			<span ng-if="editingData.status == 'draft' || !editingData.status">Cancel</span>
		</button>
	</div>
</div>
