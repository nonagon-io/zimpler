<form class="n-properties-panel uk-panel {{<?= $panel_name ?>.widthClasses}} uk-form ng-hide"
	  ng-show="<?= $panel_name ?>.isOpen" n-dirty-check=""
	  name="<?= $panel_name ?>.propertiesForm" 
	  ng-submit="<?= $panel_name ?>.save($event, {alsoClose:true})"
	  action="<?= base_url('/admin/cms/navigations/') ?>" novalidate>
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
	<div class="n-header" ng-class="{'n-drop-shadow': <?= $panel_name ?>.scrollTop > 0}">
		<?= $header ?>
		<div class="n-bottom-border" ng-hide="<?= $panel_name ?>.scrollTop > 0"></div>
	</div>
	<div class="n-body uk-form-stacked">
		<?= $body ?>
	</div>
	<div class="n-footer">
		<div class="n-scroll-for-more ng-hide" 
			 title="Scroll down for more" 
			 data-uk-tooltip=""
			 ng-show="!<?= $panel_name ?>.scrollMaxReached"></div>
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
			<button type="button" class="uk-button" ng-click="<?= $panel_name ?>.close()">
				Close
			</button>
		</div>
	</div>
</form>