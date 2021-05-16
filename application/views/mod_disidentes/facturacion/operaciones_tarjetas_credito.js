//alert("hello");

function getYears() {

	var d = new Date();
	var year = d.getFullYear();
	var year1 = Number(year) - 1;
	//alert(year + " " + year1);
	var _html = "";
	_html += '<br/>';
	_html += _TOOLS.getComboFromList("cboYrs", "Año:&nbsp;&nbsp; ", 3, year, year1 + "," + year, year1 + "&nbsp;&nbsp;&nbsp;," + year, "N ", "", "Y", " width=100px ", "N");
	_html += '<br/>';
	_html += '<br/>';
	_html += _TOOLS.getComboFromList("cboMes", "Mes:&nbsp;&nbsp; ", 3,1 ,"1,2,3,4,5,6,7,8,9,10,11,12", "Enero,Febrero,Marzo,Abril,Mayo,Junio,Julio,Agosto,Septiembre&nbsp;&nbsp;&nbsp;,Octubre,Nomviembre,Diciembre", "N ", "", "Y", " width=100px ", "N");
	_html += '<br/>';
	_html += '<br/>';
	_html += _TOOLS.getComboFromList("cboTarj", "Tarjeta:&nbsp;&nbsp; ", 3,"Visa" ,"Visa,Mastercard", "Visa,Mastercard&nbsp;&nbsp;&nbsp;", "N ", "", "Y", " width=100px ", "N");
	_html += '<br/>';

	_html += '<div class="row"><div class="col-12" style = "padding-top:15px;" ><a href="#" class="btnAction btnAccept btn btn-success btn-raised pull-right" onclick="previewMontosAGenerar();">Genreación de recibos</a>    </div >    </div >';

	//alert(_html);
	$("#selectAnio").html(_html);

}

function GenerarTC_CEM() {
	//"ANIO":"' + anio + '", "MES":"' + mes + '", "TARJETA":"' + tarjeta + '"
	var myJSON = '{';
	var count = 0;


	$('.importe_tc').each(function () {
		
		if ($(this).is(':visible')) {
			alert($(this).attr('id') + '-' + $(this).val());
			var res = $(this).attr('id').split("_");
			alert(res[1]);
			if (count != 0) {
				myJSON += ',"ID_' + count + '":"' + res[1] + '","VAL_' + count +'":"'+$(this).val()+'"';
			} else {
				myJSON += '"ID_' + count + '": "' + res[1] + '", "VAL_' + count +'":"'+$(this).val()+'"';
			}
			count = count + 1;
		}
	});

	if (count == 0) { elert("No se seleccionaron registros!"); return;}

	var anio = $('#cboYrs option:selected').val();
	var mes = $('#cboMes option:selected').val();


	

	myJSON += ',"REG":"' + count + '","ANIO":"' + anio + '", "MES":"' + mes + '"}';

	alert(myJSON);
	var myObj = JSON.parse(myJSON);
	alert("json done");

	_AJAX.UiProcesarLotesParaRecibotarjetas(myObj).then(function (datajson) {
		alert("come back");
	});
}

function ToggleTC_CEM(oThis) {
	if (!oThis.checked) {
		$('#tr_' + oThis.value).css('background-color', 'transparent');
		$('#txtimporte_' + oThis.value).hide();
	}
	else {
		$('#tr_' + oThis.value).css('background-color', 'lightgreen');
		$('#txtimporte_' + oThis.value).show();
	}
	Recalcular_LoteTC_CEM();
}

function Recalcular_LoteTC_CEM() {
	var _total = 0;
	$('.importe_tc').each(function () {
		if ($(this).is(':visible')) {
			$(this).val($(this).val().replace(',', '.'));
			_total += ($(this).val() * 1);
		}
	});
	$('#td_total').html(_total);
	if (isNaN(_total)) {
		alert("Error al recalcular...");
		$('#btnProcesar').hide();
	}
	else {
		$('#msg_alerta').hide();
		$('#btnProcesar').show();
	}
}

function previewMontosAGenerar() {

	//alert("preview");
	var anio = $('#cboYrs option:selected').val();
	var mes = $('#cboMes option:selected').val();
	var tarjeta = $('#cboTarj option:selected').val();

	//alert("anio: " + anio + " mes: " + mes + " tarjeta: " + tarjeta );

	var myJSON = '{"ANIO":"' + anio + '", "MES":"' + mes + '", "TARJETA":"' + tarjeta + '"}';
	var myObj = JSON.parse(myJSON);
	//alert("report2");

	_AJAX.UiGetLotesParaRecibotarjetas(myObj).then(function (datajson) {
		var _html = "";
		alert("JSON: " + JSON.stringify(datajson.preview));

		var titulo = "";
		var _header = "";
		var _footer = "";

		//alert("sarasa");

		_html += "<table width='100%' cellspacing='0' cellpadding='3'>";
		_html += "<tr bgcolor='silver'>";
		_html += "<td><b>Sección</b></td>";
		_html += "<td><b>Sepultura</b></td>";
		_html += "<td><b>Titular</b></td>";
		_html += "<td><b>Tarjeta</b></td>";
		_html += "<td><b>Nºde tarjeta</b></td>";
		_html += "<td align='center'><b>Generar</b></td>";
		_html += "<td align='right'><b>Importe</b></td>";
		_html += "</tr>";

		var _id = "";
		var _seccion = "";
		var _sepultura = "";
		var _titular = "";
		var _tarjeta = "";
		var _numero_tarjeta = "";
		var _importe = 0;
		var _importe_total = 0;

		$.each(datajson.preview, function (j, val1) {

			try {

				_id = val1.ID;
				_seccion = val1.SECCION;
				_sepultura = val1.SEPULTURA;
				_titular = val1.TITULAR;
				_tarjeta = val1.tarjeta;
				_numero_tarjeta = val1.numero_tarjeta;

				try {
					_importe = 0;
					_importe = Number(val1.importe);
				}
				catch (errimp) {
					alert("Error en importe para: Seccion: " + _seccion + " Sepultura: " + _sepultura + " importe: " + val1.importe);
					_importe = 0;
				}

				if (typeof _numero_tarjeta === "undefined") {
					_numero_tarjeta = "";
				}

				if (_numero_tarjeta == null) {
					_numero_tarjeta = "";
				}

				//alert("-" + _numero_tarjeta + "-");

				_importe_total += _importe;

				_html += "<tr id='tr_" + _id + "' style='background-color:lightgreen;'>";
				_html += "<td>" + _seccion + "</td>";
				_html += "<td>" + _sepultura + "</td>";
				_html += "<td>" + _titular + "</td>";
				_html += "<td>" + _tarjeta + "</td>";
				_html += "<td>" + _numero_tarjeta + "</td>";
				//checked
				_html += "<td align='center'><input style='border:solid 0px white;' class='generar' checked type='checkbox' id='chkGenerar' name='chkGenerar' value='" + _id + "' onchange='javascript:ToggleTC_CEM(this);'></td>";
				_html += "<td align='right'><input style='text-align:right;display:block;' type='text' class='text importe_tc' id='txtimporte_" + _id + "' name='txtimporte_" + _id + "' value='" + _importe + "' size='6' onkeyup='javascript:Recalcular_LoteTC_CEM();'/></td>";
				_html += "</tr>";


			} catch (error1) { email = ""; }


			//_html += email + sepChar + titular + newline;

		});


		_html += "   <tr><td colspan='7'><hr></td></tr>";
		_html += "   <tr id='tr_total'>";
		_html += "      <td colspan='6'></td>";
		_html += "      <td id='td_total' align='right' style='font-size:18px;'>" + _TOOLS.showNumber(_importe_total, 2, "", 0) + "</td>";
		_html += "   </tr>";
		_html += "</table>";
		_html += "<hr>";
		_html += "<h2>Todos los registros marcados en verde, GENERARAN RECIBO!</h2>";
		_html += "<input id='btnProcesar' type='button' class='button' value='Procesar la generación de todos los lotes marcados' onclick='javascript:GenerarTC_CEM();'>";
		_html += "<h1 id='msg_alerta' style='display:none;'>Importes incorrectos, no puede procesarse la generación!</h1>";

		$("#REPORT-CONTAINER").html(_html);
	});
			//_html = _header + _html + _footer;
			//alert(_html);

}
