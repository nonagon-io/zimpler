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
	<label class="uk-form-label" for="lat">Latitude, Longitude and Zoom Level</label>
	<div class="uk-form-controls">
		<input type="text" id="lat" name="lat" class="uk-width-1-3" 
			   ng-model="editingData.lat" placeholder="Latitude"
			   ng-class="{'uk-form-danger': propertiesForm.lat.$error.required && propertiesForm.$submitted}"
			   required readonly />
		<input type="text" id="lng" name="lng" class="uk-width-1-3" 
			   ng-model="editingData.lng" placeholder="Longitude"
			   ng-class="{'uk-form-danger': propertiesForm.lng.$error.required && propertiesForm.$submitted}"
			   required readonly />
		<input type="text" id="zoom" name="zoom" class="uk-width-1-10" 
			   ng-class="{'uk-form-danger': propertiesForm.zoom.$error.required && propertiesForm.$submitted}"
			   ng-model="editingData.zoom" placeholder="Zoom"
			   required readonly />
		<button type="button" class="uk-button" ng-click="browseLocation()">
			<i class="uk-icon-globe"></i>
		</button>
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
<div class="uk-form-row">
	<label class="uk-form-label" for="brief">Brief Description (English)</label>
	<div class="uk-form-controls">
		<textarea type="text" id="brief" class="uk-width-1-1"
				  data-uk-htmleditor='{markdown:true, toolbar: ["bold", "italic"]}'
				  ng-readonly="editingData.status == 'published'"
				  ng-model="editingData.brief"
			   	  placeholder="Breif description (optional)"></textarea>
	</div>
</div>
