<div class="uk-form-row">
	<label class="uk-form-label" for="title">Private Title</label>
	<div class="uk-form-controls">
		<input type="text" id="title" name="title" class="uk-width-1-1" 
			   ng-model="editingData.privateTitle"
			   ng-class="{'uk-form-danger': propertiesForm.title.$error.required && propertiesForm.$submitted}"
			   placeholder="The private title for you to identify the content"
			   required/>
	</div>
</div>
<div class="uk-form-row">
	<label class="uk-form-label" for="label">URL</label>
	<div class="uk-form-controls">
		<input type="text" id="label" name="label" class="uk-width-1-1" 
			   ng-model="editingData.url"
			   ng-readonly="editingData.status == 'published'"
			   ng-class="{'uk-form-danger': propertiesForm.label.$error.required && propertiesForm.$submitted}"
			   placeholder="The title that will be public in the selected language"
			   required/>
	</div>
</div>
<div class="uk-form-row">
	<label class="uk-form-label" for="label">Public Title (English)</label>
	<div class="uk-form-controls">
		<input type="text" id="label" name="label" class="uk-width-1-1" 
			   ng-model="editingData.publicTitle"
			   ng-readonly="editingData.status == 'published'"
			   ng-class="{'uk-form-danger': propertiesForm.label.$error.required && propertiesForm.$submitted}"
			   placeholder="The title that will be public in the selected language"
			   required/>
	</div>
</div>