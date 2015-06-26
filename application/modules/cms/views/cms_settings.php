<div class="uk-panel uk-panel-box uk-margin-top">
	<div class="uk-panel-title">
		CMS - Enabled Languages
		<hr/>
	</div>
	<div class="uk-grid uk-grid-small uk-grid-width-1-1 
				uk-grid-width-small-1-2 uk-grid-width-medium-1-3 
				uk-grid-width-xlarge-1-4"
		 ng-init="editingData.languages = {
		 <?php foreach($enabled_languages as $code) : ?>
		 	'<?= $code ?>': { selected: true },
		 <?php endforeach ?>
		 };">
	<?php foreach($languages as $code => $name) : ?>
		<div>
			<input type="checkbox" id="lang-<?= $code ?>" value="<?= $code ?>" 
				   ng-model="editingData.languages['<?= $code ?>'].selected" />
			<label for="lang-<?= $code ?>"><?= $name ?></label>
		</div>
	<?php endforeach ?>
	</div>
	<input type="hidden" name="cms_enabled_languages" value="{{ editingData.languages | json }}" />
</div>