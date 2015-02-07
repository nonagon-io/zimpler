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
			
			/*
			$this.find("thead tr").children().each(function(i, elem) {
				
				$(header.find("thead tr").children()[i]).css({ "width": $(elem).width() + "px" });
			});
			*/
		}
		
		$(window).resize(function() {
			
			arrangeSize();
		});
		
		arrangeSize();
	}
});