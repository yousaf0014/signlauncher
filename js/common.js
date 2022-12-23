show_errors = function(refer,errorMap,errorList,position){
	$.each(refer.successList, function(index, value) {
		return $(value).popover("hide");
	});
	return $.each(errorList, function(index, value) {
		var _popover;
		_popover = $(value.element).popover({
			trigger: "manual",
			placement: position,
			content: value.message,
			template: "<div class=\"popover error w100p\"><div class=\"arrow\"></div><div class=\"popover-inner\"><div class=\"popover-content\"><p></p></div></div></div>"
		});
		// Bootstrap 3:
		_popover.data("bs.popover").options.content = value.message
		// Bootstrap 2.x:
	  	//_popover.data("popover").options.content = value.message;
	  	return $(value.element).popover("show");
	});
}

jQuery(document).on("click","a.ajax_link",function(event){
	event.preventDefault();
	jQuery.ajax({
		url : jQuery(this).attr("href")
	}).done(function(data){
		try{
			data = jQuery.parseJSON(data);
        }catch(e){
        	data = data;
        }
		if(typeof data == "object"){
			addCustomer(data);
			jQuery("#myModal1").modal("hide");
		}else{
			jQuery("#myModal1").html(data);
		}
	});
});