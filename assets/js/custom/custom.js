
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
		if (idllevel == "1"){
			$("#level1").show();
		}
		else if(idllevel == "2"){
			$("#level1").show();
			$("#level2").show();
		}
		else if(idllevel == "3"){
			$("#level1").show();
			$("#level2").show();
			$("#level3").show();
		}else if (idllevel == "4"){
			$("#level1").show();
			$("#level2").show();
			$("#level3").show();
			$("#level4").show();
		}			
		
		$(idcbo).append("<option value=''>--Pilih Level--</option>");
		for (var i=0; i <= result.length - 1; i++){
			$(idcbo).append("<option value='"+result[i].kode+"'>" + result[i].nama + "</option>");
		}
	});
}

function load_dynamic_levelgroup(url, kodelevel, idcbo, level){
	spltidcbo = idcbo.split(",");
	bootbox.modal('<div class="loading-progress"></div>');
	$.ajax({
		url: url,
		method: "GET",
		dataType: "json"
	}).done(function(result) {
		$(".bootbox").modal("hide");
		if (level == "R"){
			$("#regional").show();
			$(spltidcbo[0]).html("<option value=''>--Pilih Regional--</option>");
			for (var i=0; i <= result["regional"].length - 1; i++){
				select = '';
				if (kodelevel == result["regional"][i].kode)
					select = "selected";
				$(spltidcbo[0]).append("<option " + select + " value='"+result["regional"][i].kode+"'>" + result["regional"][i].nama + "</option>");
			}
		}
		if (level === "1"){
			$("#regional").show();
			$(spltidcbo[1]).html("<option value=''>--Pilih Regional--</option>");
			for (var i=0; i <= result["regional"].length - 1; i++){
				select = '';
				if (result["idregional"] == result["regional"][i].kode)
					select = "selected";
				$(spltidcbo[1]).append("<option " + select + " value='"+result["regional"][i].kode+"'>" + result["regional"][i].nama + "</option>");
			}
			$("#level1").show();
			$(spltidcbo[0]).html("<option value=''>--Pilih Level 1--</option>");
			for (var i=0; i <= result["level1"].length - 1; i++){
				select = '';
				if (kodelevel == result["level1"][i].kode)
					select = "selected";
				$(spltidcbo[0]).append("<option " + select + " value='"+result["level1"][i].kode+"'>" + result["level1"][i].nama + "</option>");
			}
			
		}
		if (level === "2"){
			$("#regional").show();
			$(spltidcbo[2]).html("<option value=''>--Pilih Regional--</option>");
			for (var i=0; i <= result["regional"].length - 1; i++){
				select = '';
				if (result["idregional"] == result["regional"][i].kode)
					select = "selected";
				$(spltidcbo[2]).append("<option " + select + " value='"+result["regional"][i].kode+"'>" + result["regional"][i].nama + "</option>");
			}
			$("#level1").show();
			$(spltidcbo[1]).html("<option value=''>--Pilih Level 1--</option>");
			for (var i=0; i <= result["level1"].length - 1; i++){
				select = '';
				if (result["idlevel1"] == result["level1"][i].kode)
					select = "selected";
				$(spltidcbo[1]).append("<option " + select + " value='"+result["level1"][i].kode+"'>" + result["level1"][i].nama + "</option>");
			}
			$("#level2").show();
			$(spltidcbo[0]).html("<option value=''>--Pilih Level 2--</option>");
			for (var i=0; i <= result["level2"].length - 1; i++){
				select = '';
				if (kodelevel == result["level2"][i].kode)
					select = "selected";
				$(spltidcbo[0]).append("<option " + select + " value='"+result["level2"][i].kode+"'>" + result["level2"][i].nama + "</option>");
			}	
		}
		
		if (level === "3"){
			$("#regional").show();
			$(spltidcbo[3]).html("<option value=''>--Pilih Regional--</option>");
			for (var i=0; i <= result["regional"].length - 1; i++){
				select = '';
				if (result["idregional"] == result["regional"][i].kode)
					select = "selected";
				$(spltidcbo[3]).append("<option " + select + " value='"+result["regional"][i].kode+"'>" + result["regional"][i].nama + "</option>");
			}
			$("#level1").show();
			$(spltidcbo[2]).html("<option value=''>--Pilih Level 1--</option>");
			for (var i=0; i <= result["level1"].length - 1; i++){
				select = '';
				if (result["idlevel1"] == result["level1"][i].kode)
					select = "selected";
				$(spltidcbo[2]).append("<option " + select + " value='"+result["level1"][i].kode+"'>" + result["level1"][i].nama + "</option>");
			}
			$("#level2").show();
			$(spltidcbo[1]).html("<option value=''>--Pilih Level 2--</option>");
			for (var i=0; i <= result["level2"].length - 1; i++){
				select = '';
				if (result["idlevel2"] == result["level2"][i].kode)
					select = "selected";
				$(spltidcbo[1]).append("<option " + select + " value='"+result["level2"][i].kode+"'>" + result["level2"][i].nama + "</option>");
			}
			$("#level3").show();
			$(spltidcbo[0]).html("<option value=''>--Pilih Level 3--</option>");
			for (var i=0; i <= result["level3"].length - 1; i++){
				select = '';
				if (kodelevel == result["level3"][i].kode)
					select = "selected";
				$(spltidcbo[0]).append("<option " + select + " value='"+result["level3"][i].kode+"'>" + result["level3"][i].nama + "</option>");
			}
			
		}
		if (level === "4"){
			$("#regional").show();
			$(spltidcbo[4]).html("<option value=''>--Pilih Regional--</option>");
			for (var i=0; i <= result["regional"].length - 1; i++){
				select = '';
				if (result["idregional"] == result["regional"][i].kode)
					select = "selected";
				$(spltidcbo[4]).append("<option " + select + " value='"+result["regional"][i].kode+"'>" + result["regional"][i].nama + "</option>");
			}
			$("#level1").show();
			$(spltidcbo[3]).html("<option value=''>--Pilih Level 1--</option>");
			for (var i=0; i <= result["level1"].length - 1; i++){
				select = '';
				if (result["idlevel1"] == result["level1"][i].kode)
					select = "selected";
				$(spltidcbo[3]).append("<option " + select + " value='"+result["level1"][i].kode+"'>" + result["level1"][i].nama + "</option>");
			}
			$("#level2").show();
			$(spltidcbo[2]).html("<option value=''>--Pilih Level 2--</option>");
			for (var i=0; i <= result["level2"].length - 1; i++){
				select = '';
				if (result["idlevel2"] == result["level2"][i].kode)
					select = "selected";
				$(spltidcbo[2]).append("<option " + select + " value='"+result["level2"][i].kode+"'>" + result["level2"][i].nama + "</option>");
			}
			$("#level3").show();
			$(spltidcbo[1]).html("<option value=''>--Pilih Level 3--</option>");
			for (var i=0; i <= result["level3"].length - 1; i++){
				select = '';
				if (result["idlevel3"] == result["level3"][i].kode)
					select = "selected";
				$(spltidcbo[1]).append("<option " + select + " value='"+result["level3"][i].kode+"'>" + result["level3"][i].nama + "</option>");
			}
			$("#level4").show();
			$(spltidcbo[0]).html("<option value=''>--Pilih Level 4--</option>");
			for (var i=0; i <= result["level4"].length - 1; i++){
				select = '';
				if (kodelevel == result["level4"][i].kode)
					select = "selected";
				$(spltidcbo[0]).append("<option " + select + " value='"+result["level4"][i].kode+"'>" + result["level4"][i].nama + "</option>");
			}
			
		}
		
	});
}

function load_jenis_bbm(url, id){
	bootbox.modal('<div class="loading-progress"></div>');
	$.ajax({
		url: url,
		method: "GET",
		dataType: "json"
	}).done(function(result) {
		$(".bootbox").modal("hide");
		html = '';
		
		for (val in result){
			html += "<option value='"+val+"'>" + result[val] + "</option>";
		}
		$(id).html(html);
	});
}

function check_jenis_bbm(url, div_komponen, cbo_komponen){
	bootbox.modal('<div class="loading-progress"></div>');
	$.ajax({
		url: url,
		method: "GET",
		dataType: "json"
	}).done(function(result) {
		$(".bootbox").modal("hide");
		html = "";
		$("#ismix").val("0");
		if (Object.keys(result).length > 1){
			$(div_komponen).show();
			for (val in result){
				html += "<option value='"+val+"'>" + result[val] + "</option>";
			}
			$("#ismix").val("1");
			$(cbo_komponen).html(html);
		}else
			$(div_komponen).hide();
	});
}

