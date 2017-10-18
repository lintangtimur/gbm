
function load_level(url, id){
	bootbox.modal('<div class="loading-progress"></div>');
    $.ajax({
		url: url,
		method: "GET",
		dataType: "json"
	}).done(function(result) {
		$(".bootbox").modal("hide");
		// $("."+id).append(result);
		// $('.'+id).chosen().trigger("chosen:updated");
		$(".select2").html("");
		for (var i=0; i <= result.length - 1; i++){
			$(".select2").append("<option value='"+result[i].kode+"'>" + result[i].nama + "</option>");
		}
	});
}