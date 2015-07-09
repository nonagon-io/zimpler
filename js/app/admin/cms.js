angular.module("admin-cms", ['generic-modal', 'admin'])

.factory("cmsPropertiesPanel", 
	['propertiesPanel', function(propertiesPanel) {

    var $this = $.extend(true, {}, propertiesPanel);

	$this.publishable = function() {

		if($this.publishableCheck)
			return $this.publishableCheck();
	}

    $this.publish = function($event, option) {

		var proceed = function() {

			$this.fire("publish", null, function(result) {

				if(result && option && option.alsoClose) {

					$this.close();
				}
			});
		};

		$this.saveIfDirty($event, { alsoClose: false, doNext: proceed });
    };

    $this.newRevision = function() {

    	$this.fire("new-revision", null);
    }

    $this.deleteRev = function() {

    	$this.fire("delete-rev", null);
    }

    return $this;

}]);