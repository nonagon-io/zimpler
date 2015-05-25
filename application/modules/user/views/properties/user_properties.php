<div class="uk-form-row">
	<label class="uk-form-label" for="firstName">
		First Name
		<i class="uk-icon-times-circle uk-text-danger" 
		   title="First Name is required"
		   data-uk-tooltip="{pos:'right'}"
		   ng-show="<?= $panel_name ?>.propertiesForm.firstName.$error.required && 
		   			<?= $panel_name ?>.propertiesForm.$submitted"></i>
	</label>
	<div class="uk-form-controls">
		<input type="text" id="firstName" name="firstName" class="uk-width-1-1" 
			   ng-model="editingData.firstName"
			   ng-class="{'uk-form-danger': 
			   		<?= $panel_name ?>.propertiesForm.firstName.$error.required && 
			   		<?= $panel_name ?>.propertiesForm.$submitted}"
			   placeholder="First Name"
			   required/>
	</div>
</div>
<div class="uk-form-row">
	<label class="uk-form-label" for="lastName">
		Last Name
		<i class="uk-icon-times-circle uk-text-danger" 
		   title="Last Name is required"
		   data-uk-tooltip="{pos:'right'}"
		   ng-show="<?= $panel_name ?>.propertiesForm.lastName.$error.required && 
		   			<?= $panel_name ?>.propertiesForm.$submitted"></i>
	</label>
	<div class="uk-form-controls">
		<input type="text" id="lastName" name="lastName" class="uk-width-1-1" 
			   ng-model="editingData.lastName"
			   ng-class="{'uk-form-danger': 
			   		<?= $panel_name ?>.propertiesForm.lastName.$error.required && 
			   		<?= $panel_name ?>.propertiesForm.$submitted}"
			   placeholder="Last Name"
			   required/>
	</div>
</div>
<div class="uk-form-row">
	<label class="uk-form-label" for="email">
		Email
	</label>
	<div class="uk-form-controls">
		<input type="text" id="email" name="email" class="uk-width-1-1" 
			   ng-model="editingData.email"
			   ng-class="{'uk-form-danger': 
			   		<?= $panel_name ?>.propertiesForm.email.$error.required && 
			   		<?= $panel_name ?>.propertiesForm.$submitted}"
			   placeholder="Email"
			   required/>
	</div>
</div>