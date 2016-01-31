$(function() {
	$.fn.freezeHeader = function() {
		
		if(!this.offset()) return;

		var elems = this;
		elems.each(function(index, elem) {

			if($(elem).hasClass("no-freezeh"))
				return;

			var header = 
				$("<table class='freeze-header " + $(elem).attr("class") + "'><thead>" + 
					$(elem).find("thead").html() + "</thead></table>");
					
			$(header).css({
				"position": "fixed",
				"margin-top": "0px",
				"top": $(elem).offset().top + "px",
				"width": $(elem).width() + "px"
			});
			
			$(elem).parent().append(header);
			
			var arrangeSize = function() {
				
				header.css({ "width": $(elem).width() + "px" });

				var tableHeaders = $(elem).find("thead tr").children();
				var fixedHeaders = header.find("thead tr").children();

				var len = tableHeaders.length;

				for(var i=len - 1; i>=0; i--) {

					var elem = tableHeaders[i];
					$(fixedHeaders[i]).css({ "width": ($(elem).width() + 1) + "px" });
				}
			}

			$(elem).parent().on("scroll", function(e) {

				var scrollLeft = $(e.target).scrollLeft();
				$(header).css("margin-left", -scrollLeft + "px");
			});
			
			$(window).resize(function() {
				
				arrangeSize();
			});
			
			arrangeSize();
		});
	}
});