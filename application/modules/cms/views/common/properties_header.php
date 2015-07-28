<div class="uk-panel-title uk-grid uk-grid-collapse">
	<div class="uk-width-2-3">
		<div class="n-header-title">
			<i class="uk-icon-edit"></i> {{editingData.headerTitle}}
		</div>
	</div>
	<div class="uk-width-1-3 uk-text-right" style="font-size: 14px">
		<div class="uk-display-inline-block" style="margin-top: 3px; margin-right: 5px;">
			Rev. {{editingData.revision}}
		</div>
		<select class="n-culture-selection uk-align-right uk-vertical-align-middle" ng-model="editingData.culture"
				ng-disabled="!(<?= $panel_name ?>.propertiesForm.$valid)"
				ng-click="<?= $panel_name ?>.saveIfDirty($event)"
				ng-change="<?= $panel_name ?>.fire('culture-changed', editingData.culture)">
			<?php foreach($enabled_languages as $code) : ?>
			<option value="<?= $code ?>">
				<?= explode(' (', $languages[$code])[0] . 
					(isset(explode('-', $code)[1]) ? ' (' . strtoupper(explode('-', $code)[1]) . ')' : '') ?>
			</option>
			<?php endforeach ?>
		</select>
	</div>
	<?php if(isset($allow_publish) && $allow_publish) : ?>
	<div class="uk-text-center uk-width-1-1">
		<span class="uk-margin-small-top uk-text-primary uk-text-small uk-display-inline-block" 
			  ng-if="editingData.status == 'published'">
			Published {{ editingData.published | date :'yyyy-MM-dd hh:mm:ss a'}}
		</span>
		<span class="uk-margin-small-top uk-text-muted uk-text-small uk-display-inline-block" 
			  ng-if="editingData.status == 'draft'">
			Drafted {{ editingData.modified | date :'yyyy-MM-dd hh:mm:ss a'}}
		</span>
	</div>
	<?php endif ?>
</div>