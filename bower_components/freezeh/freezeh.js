$(function() {
	$.fn.freezeHeader = function() {
		
		if(!this.offset()) return;
		
		var header = 
			$("<table class='" + this.attr("class") + "'><thead>" + 
				this.find("thead").html() + "</thead></table>");
				
		$(header).css({
			"position": "fixed",
			"margin-top": "0px",
			"top": this.offset().top + "px",
			"width": this.width() + "px"
		});
		
		this.parent().append(header);
		
		var $this = this;
		var arrangeSize = function() {
			
			header.css({ "width": $this.width() + "px" });

			var tableHeaders = $this.find("thead tr").children();
			var fixedHeaders = header.find("thead tr").children();

			var len = tableHeaders.length;

			for(var i=len - 1; i>=0; i--) {

				var elem = tableHeaders[i];
				$(fixedHeaders[i]).css({ "width": ($(elem).width() + 1) + "px" });
			}
		}
		
		$(window).resize(function() {
			
			arrangeSize();
		});
		
		arrangeSize();
	}
});