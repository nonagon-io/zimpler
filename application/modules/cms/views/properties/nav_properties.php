<div class="uk-form-row">
	<label class="uk-form-label" for="key">
		Key
		<i class="uk-icon-times-circle uk-text-danger" 
		   title="Key is required"
		   data-uk-tooltip="{pos:'right'}"
		   ng-show="<?= $panel_name ?>.propertiesForm.key.$error.required && 
		   			<?= $panel_name ?>.propertiesForm.$submitted"></i>
	</label>
	<div class="uk-form-controls">
		<input type="text" id="key" name="key" class="uk-width-1-1" 
			   ng-model="editingData.key"
			   ng-class="{'uk-form-danger': 
			   		<?= $panel_name ?>.propertiesForm.key.$error.required && 
			   		<?= $panel_name ?>.propertiesForm.$submitted}"
			   placeholder="The unique key to identify the navigation item (e.g. home)"
			   ng-readonly="currentStatus == 'published'"
			   required/>
	</div>
</div>
<div class="uk-form-row">
	<label class="uk-form-label" for="url">
		URL
		<i class="uk-icon-times-circle uk-text-danger" 
		   title="URL is required"
		   data-uk-tooltip="{pos:'right'}"
		   ng-show="<?= $panel_name ?>.propertiesForm.url.$error.required && 
		   			<?= $panel_name ?>.propertiesForm.$submitted"></i>
	</label>
	<div class="uk-form-controls">
		<input type="text" id="url" name="url" class="uk-width-1-1" 
			   ng-model="editingData.url"
			   ng-class="{'uk-form-danger': 
			   		<?= $panel_name ?>.propertiesForm.url.$error.required && 
			   		<?= $panel_name ?>.propertiesForm.$submitted}"
			   placeholder="The url of the page. Relative url indicates internal page."
			   ng-readonly="currentStatus == 'published'"
			   required/>
			   
		<button type="button" class="uk-button uk-width-1-1" ng-disabled="currentStatus == 'published'">
			Select Page...
		</button>
	</div>
</div>
<div class="uk-form-row">
	<label class="uk-form-label" for="target">
		Link Target
	</label>
	<div class="uk-form-controls">
		<div class="uk-grid uk-grid-small">
			<div class="uk-width-1-3">
				<select id="target" name="target" class="uk-width-1-1"
						ng-disabled="currentStatus == 'published'"
					    ng-model="editingData.target">
					<option value="normal">Normal</option>
					<option value="new">New Tab / Window</option>
				</select>
			</div>
			<div class="uk-width-2-3">
				<input type="text" id="targetKey" name="targetKey" class="uk-width-1-1" 
					   ng-model="editingData.targetKey"
					   ng-show="editingData.target == 'new'"
					   ng-readonly="currentStatus == 'published'"
					   placeholder="Target Key (Optional)">
			</div>
		</div>
	</div>
</div>
<div class="uk-form-row">
	<label class="uk-form-label" for="label">
		Public Title (English)
		<i class="uk-icon-times-circle uk-text-danger" 
		   title="Public Title is required"
		   data-uk-tooltip="{pos:'right'}"
		   ng-show="<?= $panel_name ?>.propertiesForm.publicTitle.$error.required && 
		   			<?= $panel_name ?>.propertiesForm.$submitted"></i>
	</label>
	<div class="uk-form-controls">
		<input type="text" id="label" name="publicTitle" class="uk-width-1-1" 
			   ng-model="editingData.publicTitle"
			   ng-readonly="currentStatus == 'published'"
			   ng-class="{'uk-form-danger': 
			   		<?= $panel_name ?>.propertiesForm.publicTitle.$error.required && 
			   		<?= $panel_name ?>.propertiesForm.$submitted}"
			   placeholder="The title that will be public in the selected language"
			   required/>
	</div>
</div>