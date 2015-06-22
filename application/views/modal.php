<div id="genericModal" class="uk-modal" ng-modules="generic-modal" ng-controller="ModalController">
    <div class="uk-modal-dialog">
        <button ng-if="modal.bgclose" type="button" class="uk-modal-close uk-close"></button>
        <div class="uk-modal-header">
            <h2 ng-class="{'uk-text-danger': modal.danger}">
	            <span ng-bind-html="modal.icon"></span> <span ng-bind-html="modal.header"></span>
	        </h2>
        </div>
        <p ng-bind-html="modal.message"></p>
        <div class="uk-modal-footer uk-text-right">
	        <button type="button" class="n-ok uk-button" 
	        		ng-class="{'uk-button-danger': modal.danger, 'uk-button-primary': !modal.danger}"
	        		style="width:100px" ng-click="ok()">{{modal.okTitle}}</button>
            <button type="button" class="n-cancel uk-button" ng-if="!modal.okOnly"
            		style="width:100px" ng-click="cancel()">{{modal.cancelTitle}}</button>
        </div>
    </div>
</div>