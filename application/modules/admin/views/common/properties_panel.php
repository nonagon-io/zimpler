<form class="n-properties-panel uk-panel uk-width-1-1 uk-width-medium-2-3 uk-width-large-6-10 uk-form ng-hide"
	  ng-show="propertiesPanel.isOpen" n-dirty-check=""
	  name="propertiesForm" ng-init="baseUrl = '<?= base_url() ?>';" novalidate>
	<shortcut></shortcut>
	<?php if($this->config->item("csrf_protection")) : ?>
	<input type="hidden" 
		   ng-init='<?php 
			   echo 'csrf = {' .
			   		'"' . $this->security->get_csrf_token_name() . '": ' .
			   		'"' . $this->security->get_csrf_hash() . '"' .
			   		'}'; ?>'
		   name="<?php echo $this->security->get_csrf_token_name(); ?>" 
		   value="<?php echo $this->security->get_csrf_hash();?>" />
	<?php endif ?>
	<div class="n-header" ng-class="{'n-drop-shadow': propertiesPanel.scrollTop > 0}">
		<?= $header ?>
		<div class="n-bottom-border" ng-hide="propertiesPanel.scrollTop > 0"></div>
	</div>
	<div class="n-body uk-form-stacked">
		<?= $body ?>
	</div>
	<div class="n-footer">
		<div class="n-scroll-for-more ng-hide" 
			 title="Scroll down for more" 
			 data-uk-tooltip=""
			 ng-show="!propertiesPanel.scrollMaxReached"></div>
		<div class="n-top-border"></div>
		<?= $footer ?>
	</div>
	<div class="n-mask uk-vertical-align uk-text-center ng-hide" ng-class="{'ng-show':loading}">
		<div class="uk-vertical-align-middle uk-display-inline-block">
			<i class="uk-icon-spinner uk-icon-spin uk-icon-small"></i>
		</div>
	</div>
	<div class="n-mask n-solid uk-vertical-align uk-text-center ng-hide" ng-class="{'ng-show':connectionError}">
		<div class="uk-vertical-align-middle uk-display-inline-block">
			<span class="uk-text-muted">
				<i class="uk-icon-times-circle-o uk-icon-large"></i>
				<p ng-if="connectionErrorMessage" class="uk-container-center"
				   ng-bind-html="connectionErrorMessage">
				</p>
			</span>
			<button type="button" class="uk-button" ng-click="propertiesPanel.close()">
				Close
			</button>
		</div>
	</div>
</form>