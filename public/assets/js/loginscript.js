// JavaScript Document
$(document).ready(function(){
		$("#login_user").focus();
		$("#forget_email").focus();
		$("#forgetbox").hide();
	 });
	 
	 $(document).ready(function(){
		 $(".forgot-pwd").click(function () {
			$("#loginbox").hide();
			$("#forgetbox").show();
		});
	 });
	
	 $(document).ready(function() {
		$(".backlogin").click(function() {
			$("#loginbox").show();
			$("#forgetbox").hide();
		});
	 });