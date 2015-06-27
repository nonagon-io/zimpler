<div class="n-cms-settings-scope uk-panel uk-panel-box uk-margin-top">
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
				   ng-model="editingData.languages['<?= $code ?>'].selected" 
				   ng-change="cmsLanguagesChanged()"/>
			<label for="lang-<?= $code ?>"><?= $name ?></label>
		</div>
		<?php endforeach ?>
	</div>
	<input type="hidden" name="cms_enabled_languages" value="{{ editingData.languages | json }}" />
	<input type="hidden" name="cmsEnabledLanguages" ng-model="editingData.selectedLanguages" required />
	<div class="uk-margin-top uk-alert uk-alert-warning"
		 ng-show="mainForm.cmsEnabledLanguages.$error.required && mainForm.$submitted">
		<i class="uk-icon-times-circle uk-text-danger"></i>
		At least one language must be selected
	</div>
</div>
<script>
	document.addEventListener("DOMContentLoaded", function(event) { 

		setTimeout(function() {

			angular.element(".n-cms-settings-scope").scope().$apply(function($scope) {

				var collectSelectedLanguages = function() {

					var selectedLanguages = [];

					for(var key in $scope.editingData.languages) {

						var isSelected = $scope.editingData.languages[key].selected;
						if(isSelected)
							selectedLanguages.push(key);
					}

					$scope.editingData.selectedLanguages = selectedLanguages.join(',');

					console.debug($scope.editingData.selectedLanguages);
				}

				$scope.cmsLanguagesChanged = function() {

					collectSelectedLanguages();
				}

				$scope.$watchCollection("languages", function() {

					collectSelectedLanguages();
				});
			});
		}, 1);
	});
</script>