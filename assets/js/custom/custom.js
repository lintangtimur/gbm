//Add by Aditya Noman

function lookup_pimpinan_sos(id, idName = ''){
	var message = '';
	var icon = 'icon-remove-sign';
	var color = '#ac193d;';
	var link = $('#'+id).attr('data-source');
	var input = $('#'+id).val();
	var arr = [];
	$.post(link,{param:input}, function(res) {
		message += '<div class="box-title" style="color:' + color + '"><i class="' + icon + '"></i> Data Tidak Ada</div>';
		message += 'Silahkan Input Data Secara Manual';
		if(res[0]==true){
			arr = res[1];
			var idJab = '';
			if (idName == ''){
				idName = id.replace('peserta_nip','peserta_nama');
				idJab = id.replace('peserta_nip','peserta_jabatan');
				$("#"+idJab).focus();
			}
			$("#"+idName).val(arr['user_nama']);
		}else{
			bootbox.alert(message);
		}
	},'json');
}

function addrowPesertaternal(id,link){
	var rowPeserta = $('#'+id+' tbody').children().length;
	var valueEks = '<tr>'+
	'<td align="center"><input type="text"  id="peserta-'+rowPeserta+'-peserta_nip" name="peserta['+rowPeserta+'][peserta_nip]" class="span12" onkeydown="getAgt(this.id, event)" data-source='+link+'></td>'+
	'<td align="center"><input type="text" id="peserta-'+rowPeserta+'-peserta_nama" name="peserta['+rowPeserta+'][peserta_nama]" class="span12"></td>'+
	'<td align="center"><input type="text" id="peserta-'+rowPeserta+'-peserta_jabatan" name="peserta['+rowPeserta+'][peserta_jabatan]" class="span12"></td>'+
	'<td align="center"><div class="btn red" id="removeRow" style="margin-left: 5px;"><i class="icon icon-minus"></i></div></td>'+
	'</tr>';
	$("#"+id+" tbody").append(valueEks);
	rowPeserta++;
}


