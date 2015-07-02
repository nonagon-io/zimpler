<div ng-show="!isLoadingEditingData">
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
			<i class="uk-icon-times-circle uk-text-danger" 
			   title="The specified key is already exists"
			   data-uk-tooltip="{pos:'right'}"
			   ng-show="<?= $panel_name ?>.propertiesForm.key.$error.duplicated && 
			   			<?= $panel_name ?>.propertiesForm.$submitted"></i>
		</label>
		<div class="uk-form-controls">
			<input type="text" id="key" name="key" class="uk-width-1-1" 
				   ng-model="editingData.key"
				   ng-class="{'uk-form-danger': (
				   		<?= $panel_name ?>.propertiesForm.key.$error.required ||
				   		<?= $panel_name ?>.propertiesForm.key.$error.duplicated) && 
				   		<?= $panel_name ?>.propertiesForm.$submitted}"
				   placeholder="The unique key of content (e.g. why-us, home-highlight, 12345, etc.)"
				   ng-readonly="currentStatus == 'published'"
				   maxlength="50"
				   required/>
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
				<option value="html">Composition</option>
				<option value="label">Label</option>
				<option value="list">List</option>
			</select>
		</div>
	</div>
	<hr/>
	<div ng-show="editingData.type == 'html'">
		<div class="uk-form-row">
			<label class="uk-form-label" for="publicTitle">
				Public Title - {{currentCultureFullName}}
				<i class="uk-icon-times-circle uk-text-danger" 
				   title="Public Title is required"
				   data-uk-tooltip="{pos:'right'}"
				   ng-show="<?= $panel_name ?>.propertiesForm.publicTitle.$error.required && 
				   			<?= $panel_name ?>.propertiesForm.$submitted"></i>
			</label>
			<div class="uk-form-controls">
				<input type="text" id="publicTitle" name="publicTitle" class="uk-width-1-1" 
					   ng-model="editingData.publicTitle"
					   placeholder="The title of content in the selected language"
					   ng-class="{'uk-form-danger': 
					   		<?= $panel_name ?>.propertiesForm.publicTitle.$error.required && 
					   		<?= $panel_name ?>.propertiesForm.$submitted}"
					   maxlength="80" ng-required="editingData.type == 'html'" />
			</div>
		</div>
		<div class="uk-form-row">
			<label class="uk-form-label" for="html">
				Content - {{currentCultureFullName}}
			</label>
			<div class="uk-form-controls">
				<textarea name="html" ui-tinymce="tinymceOptions" ng-model="editingData.html"></textarea>
			</div>
		</div>
	</div>
	<div ng-show="editingData.type == 'label'">
		<div class="uk-form-row">
			<label class="uk-form-label" for="label">
				Label - {{currentCultureFullName}}
				<i class="uk-icon-times-circle uk-text-danger" 
				   title="Label is required"
				   data-uk-tooltip="{pos:'right'}"
				   ng-show="<?= $panel_name ?>.propertiesForm.label.$error.required && 
				   			<?= $panel_name ?>.propertiesForm.$submitted"></i>
			</label>
			<div class="uk-form-controls">
				<input type="text" id="label" name="label" class="uk-width-1-1" 
					   ng-model="editingData.label"
					   placeholder="The label in the selected language"
					   maxlength="80" ng-required="editingData.type == 'label'" />
			</div>
		</div>
	</div>
	<hr/>
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
</div>

<div class="n-abs-fit n-progress-panel n-properties-panel-progress uk-vertical-align uk-text-center ng-hide"
	 ng-show="isLoadingEditingData">
	<div class="uk-vertical-align-middle">
		<i class="uk-icon-spinner uk-icon-spin"></i>
	</div>
</div>