(function ($) {
	var d = new Date();
	var month = d.getMonth()+1;
	var day = d.getDate();
	var year = d.getFullYear()-2000;
	
	$(document).ready(function() {
        $("#inputurl").select();
		$("#facebook").click(function() {
			$("#outputurl").val($("#inputurl").val() + "?utm_source=facebook&utm_medium=nsfbpage");
		});
		
		$("#twitter").click(function() {
			$("#outputurl").val($("#inputurl").val() + "?utm_source=twitter&utm_medium=nstwitter");
		});
	
		$("#outreach").click(function() {
			$("#outputurl").val($("#inputurl").val() + "?utm_source=outreach&utm_campaign=nsO" + month + day + year);
		});
		
		$("#buttonrow").click(function() {
			$("#outputurl").select();
		});
	});
})(jQuery);