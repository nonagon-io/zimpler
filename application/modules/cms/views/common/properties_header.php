<div class="uk-panel-title uk-grid">
	<div class="uk-width-1-2">
		<div style="margin-top: 5px">
			<i class="uk-icon-edit"></i> {{editingData.headerTitle}}
		</div>
	</div>
	<div class="uk-width-1-2 uk-text-right" style="font-size: 14px">
		<div class="uk-display-inline-block" style="margin-top: 3px; margin-right: 5px;">
			Rev. {{editingData.revision}}
		</div>
		<select class="n-culture-selection uk-align-right uk-vertical-align-middle" ng-model="editingData.culture"
				ng-disabled="!(<?= $panel_name ?>.propertiesForm.$valid)"
				ng-click="<?= $panel_name ?>.save()"
				ng-change="<?= $panel_name ?>.fire('culture-changed', editingData.culture)">
			<?php foreach($enabled_languages as $code) : ?>
			<option value="<?= $code ?>">
				<?= explode(' (', $languages[$code])[0] . 
					(isset(explode('-', $code)[1]) ? ' (' . strtoupper(explode('-', $code)[1]) . ')' : '') ?>
			</option>
			<?php endforeach ?>
		</select>
	</div>
</div>
