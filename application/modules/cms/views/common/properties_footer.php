<div class="uk-grid uk-margin-small-top">
	<div class="uk-width-1-5">
		<button type="button" class="uk-button uk-button-primary" 
				ng-if="editingData.status != 'published'"
				ng-disabled="!propertiesForm.$valid"
				ng-click="publishPropertiesData()">
			Publish
		</button>
		<span class="uk-margin-small-top uk-text-primary uk-display-inline-block" 
			  ng-if="editingData.status == 'published'">
			Published
		</span>
	</div>
	<div class="uk-width-4-5 uk-text-right">
		<button type="button" class="uk-button uk-button-primary" 
				ng-if="editingData.status == 'published'"
				ng-disabled="!propertiesForm.$valid"
				ng-click="newRevision()">
			New
		</button>
		<button type="button" class="uk-button uk-button-danger" 
				ng-if="editingData.status == 'draft' && editingData.revision > 1"
				ng-click="deleteRevision()"
				style="width: auto">
			<i class="uk-icon-trash"></i>
		</button>
		<button type="submit" class="uk-button uk-button-success" 
				ng-click="savePropertiesData({alsoClose: true})">
			Save <span ng-show="propertiesForm.$dirty">*</span>
		</button>
		<button type="button" class="uk-button" ng-click="propertiesPanel.close()">
			Cancel
		</button>
	</div>
</div>
