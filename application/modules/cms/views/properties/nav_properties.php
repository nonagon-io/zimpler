<div class="uk-form-row">
	<label class="uk-form-label" for="key">Key</label>
	<div class="uk-form-controls">
		<input type="text" id="key" name="key" class="uk-width-1-1" 
			   ng-model="editingData.key"
			   ng-class="{'uk-form-danger': form.propertiesForm.key.$error.required && propertiesForm.$submitted}"
			   placeholder="The unique key to identify the navigation item (e.g. home)"
			   required/>
	</div>
</div>
<div class="uk-form-row">
	<label class="uk-form-label" for="url">URL</label>
	<div class="uk-form-controls">
		<input type="text" id="url" name="url" class="uk-width-1-1" 
			   ng-model="editingData.url"
			   ng-class="{'uk-form-danger': form.propertiesForm.url.$error.required && propertiesForm.$submitted}"
			   placeholder="The url of the page. Relative url indicates internal page."
			   required/>
			   
		<button type="button" class="uk-button uk-width-1-1">Select Page...</button>
	</div>
</div>
<div class="uk-form-row">
	<label class="uk-form-label" for="target">Link Target</label>
	<div class="uk-form-controls">
		<div class="uk-grid uk-grid-small">
			<div class="uk-width-1-3">
				<select id="target" name="target" class="uk-width-1-1"
					    ng-model="editingData.target"
					    ng-class="{'uk-form-danger': form.propertiesForm.target.$error.required && propertiesForm.$submitted}">
					<option value="normal">Normal</option>
					<option value="new">New Tab / Window</option>
				</select>
			</div>
			<div class="uk-width-2-3">
				<input type="text" id="targetKey" name="targetKey" class="uk-width-1-1" 
					   ng-model="editingData.targetKey"
					   ng-class="{'uk-form-danger': form.propertiesForm.targetKey.$error.required && propertiesForm.$submitted}"
					   placeholder="Target Key (Optional)"
					   required/>
			</div>
		</div>
	</div>
</div>
<div class="uk-form-row">
	<label class="uk-form-label" for="label">Public Title (English)</label>
	<div class="uk-form-controls">
		<input type="text" id="label" name="publicTitle" class="uk-width-1-1" 
			   ng-model="editingData.publicTitle"
			   ng-readonly="editingData.status == 'published'"
			   ng-class="{'uk-form-danger': form.propertiesForm.publicTitle.$error.required && propertiesForm.$submitted}"
			   placeholder="The title that will be public in the selected language"
			   required/>
	</div>
</div>