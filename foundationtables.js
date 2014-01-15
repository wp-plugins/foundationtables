/* Foundation Tables handlers */

	jQuery(document).ready(function() {
	// enlarge cell for better edit experience
	jQuery('.foundtab textarea').focus(function() {
		var $ta = jQuery(this);
		var $tap = $ta.position();
		$ta.attr("data-pl",$tap.left);
		$ta.attr("data-pt",$tap.top);
		var $rowp = $ta.closest("tr").position;
		//var $window = jQuery( window );				console.log("Window: "+$window.height()+"x"+$window.width());
		$ta.animate({top:$rowp.top+"px", left:"12px"},100).addClass("active");
	});
	jQuery('.foundtab textarea').blur(function() {
		jQuery(this).animate({top:  jQuery(this).data("pt")+"px", 
							  left: jQuery(this).data("pt")+"px"},100).removeClass("active");
	});
	
	//makes nextrow visible
	jQuery('.foundtab_addrow').click(function() {
		jQuery(this).prev("table").find(".vis0:first").removeClass();
	});

	//make a new table
	jQuery('.foundtab_addtab').click(function() {
		var $newID;
		var $prev = jQuery(".foundtab").last();
		console.log($prev);
		var $clone = jQuery($prev).clone(true);
		console.log($clone.attr("id"));

	    // Find all elements in $clone that have an ID or NAME, and iterate using each()
		var regex = /^foundtab\[(\d)\](.*)$/ig;
		$clone.find('[name]').each(function() { 
			var name = this.name || ""; console.log("testing name: "+name);
			jQuery(this).attr("name", jQuery(this).attr("name").replace(regex, function(match, $1, $2) {
				$newID = (parseInt($1)+1);
				return("foundtab["+ $newID +"]"+$2);
			}));
		});
		//update ID
		$clone.attr("id","foundtab["+$newID+"]");
		//update description
		$clone.find(".tab").html("foundtab_"+$newID);
		$clone.insertBefore(".foundtab_addtab");
		jQuery("<input type='button' class='foundtab_addrow' value='Add Row' />").insertAfter($clone);
	});
	
	//donate form
	var $donateform = jQuery("div.donate").html();
	jQuery("div.donate").html("<form action='https://www.paypal.com/cgi-bin/webscr' method='post' id='donate' target='_blank'>"+$donateform+"</form>").css("display","block");
	

});