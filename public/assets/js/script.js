// JavaScript Document
$(document).ready(function() {
	$("#btndelete").live("click", function(){
		var retVal = confirm("Are you sure to delete it?");
		if( retVal == true ) {
		  return true;
	    } else {
		  return false;
	    }
	});
});