
function load_level(url, idllevel, idcbo, idlabel){
	bootbox.modal('<div class="loading-progress"></div>');
    $.ajax({
		url: url,
		method: "GET",
		dataType: "json"
	}).done(function(result) {
		$(".bootbox").modal("hide");
		$(idcbo).html("");
		$(idlabel).show();
		if (idllevel == "1")
			$("#level1").show();
		else if(idllevel == "2"){
			$("#level1").show();
			$("#level2").show();
		}
		else if(idlevel == "3"){
			$("#level1").show();
			$("#level2").show();
			$("#level3").show();
		}else if (idlevel == "4"){
			$("#level1").show();
			$("#level2").show();
			$("#level3").show();
			$("#level4").show();
		}
			
		for (var i=0; i <= result.length - 1; i++){
			$(idcbo).append("<option value='"+result[i].kode+"'>" + result[i].nama + "</option>");
		}
	});
}