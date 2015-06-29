<div class="uk-form-row">
	<label class="uk-form-label" for="title">
		Private Title
		<i class="uk-icon-button uk-icon-question" 
		   title="The private title will help you find the content in the future. Plus
		   		  it will be the default title in case the title of the certain language
		   		  is missing."
		   data-uk-tooltip></i>
		<i class="uk-icon-times-circle uk-text-danger" 
		   title="Private Title is required"
		   data-uk-tooltip="{pos:'right'}"
		   ng-show="<?= $panel_name ?>.propertiesForm.title.$error.required && 
		   			<?= $panel_name ?>.propertiesForm.$submitted"></i>
	</label>
	<div class="uk-form-controls">
		<input type="text" id="title" name="title" class="uk-width-1-1" 
			   ng-model="editingData.title"
			   ng-class="{'uk-form-danger': 
			   		<?= $panel_name ?>.propertiesForm.title.$error.required && 
			   		<?= $panel_name ?>.propertiesForm.$submitted}"
			   placeholder="The private title of the content"
			   ng-readonly="currentStatus == 'published'"
			   maxlength="150"
			   required/>
	</div>
</div>
<div class="uk-form-row">
	<label class="uk-form-label" for="key">
		Key
		<i class="uk-icon-button uk-icon-question" 
		   title="The key is used by web developer to reference to the content with the code.
		   		  It can be anything but must be uniqued."
		   data-uk-tooltip></i>
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
			   placeholder="The unique key of content (e.g. why-us, home-highlight, 12345, etc.)"
			   ng-readonly="currentStatus == 'published'"
			   maxlength="50"
			   required/>
	</div>
</div>
<div class="uk-form-row">
	<label class="uk-form-label" for="group">
		Group
	</label>
	<div class="uk-form-controls">
		<input type="text" id="group" name="group" class="uk-width-1-1" 
			   ng-model="editingData.group"
			   placeholder="The group of the content (optional)"
			   ng-readonly="currentStatus == 'published'"
			   maxlength="80" />
	</div>
</div>
<div class="uk-form-row">
	<label class="uk-form-label" for="description">
		Description
		<i class="uk-icon-button uk-icon-question" 
		   title="The description will help you find the content in case the private title is not enough."
		   data-uk-tooltip></i>
	</label>
	<div class="uk-form-controls">
		<input type="text" id="description" name="description" class="uk-width-1-1" 
			   ng-model="editingData.description"
			   placeholder="The description of the content (optional)"
			   maxlength="250" />
	</div>
</div>
<div class="uk-form-row">
	<label class="uk-form-label" for="type">
		Content Type
	</label>
	<div class="uk-form-controls">
		<select id="type=" name="type" class="uk-width-1-1"
				ng-model="editingData.type"
				ng-disabled="currentStatus == 'published'">
			<option value="html">HTML</option>
			<option value="label">Label</option>
			<option value="list">List</option>
		</select>
	</div>
</div>
<hr/>
<div ng-show="editingData.type == 'html'">
	<div class="uk-form-row">
		<label class="uk-form-label" for="type">
			Public Title ({{editingData.cultureFullName}})
		</label>
		<div class="uk-form-controls">
			<select id="type=" name="type" class="uk-width-1-1"
					ng-model="editingData.type"
					ng-disabled="currentStatus == 'published'">
				<option value="html">HTML</option>
				<option value="label">Label</option>
				<option value="list">List</option>
			</select>
		</div>
	</div>
	<div class="uk-form-row">
		<div class="uk-form-controls">
			<textarea ui-tinymce="tinymceOptions" ng-model="editingData.html"></textarea>
		</div>
	</div>
</div>