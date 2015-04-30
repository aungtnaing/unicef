// JavaScript Document
$(document).ready(function() {
	$("#addeventportfolio").hide();
	
	$("#check").click(function() { 
		$(".sel-cover").attr("checked", "checked");
	});
	
	$("#uncheck").click(function() { 
		$(".sel-cover").removeAttr("checked"); 
	});	
});

function showproject() {	
	$("#addeventportfolio").show().css({
										'border-left' : '1px solid #c3c3c3',
										'padding-left' : '30px',
										'float': 'left',
									  });
	$("#add_form").append("<input type='file' name='photo[]' /><br/><br/>");
	$("#add_form > *").css({'width' : '200px'});
}