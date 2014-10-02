var d = new Date();
var month = d.getMonth()+1;
var day = d.getDate();
var year = d.getFullYear()-2000;

$(document).ready(function() {
    $("#inputurl").select();
	$("#mic").click(function() {
		$("#outputurl").val($("#inputurl").val() + "?utm_source=nationswell&utm_medium=social");
	});
	
	$("#takepart").click(function() {
		$("#outputurl").val($("#inputurl").val() + "?cmpid=tp-ptnr-nationswell");
	});

    $("#huffpostimpact").click(function() {
        $("#outputurl").val($("#inputurl").val() + "?ncid=edlinkushpmg00000068");
    });

	$("#buttonrow").click(function() {
		$("#outputurl").select();
	});
});