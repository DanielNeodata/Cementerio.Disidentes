
function nullToEmpty(valor) {
	if (valor == null) { return ""; }
	if (valor == "null") { return ""; }
	if (typeof valor === "undefined") { return ""; }
	return valor;
}


function showReport() {
	//alert("report");
	var fdesde = $('#TB-fDesde').val();
	var fhasta = $('#TB-fHasta').val();

	var cdesde = $('#TB-aDesde').val();
	var chasta = $('#TB-aHasta').val();

	var prefijo = $("#TB-PREFIJO").val();
	var destino = $("input:radio[name=DESTINO]:checked").val();
	var adicionales = $("input:radio[name=ADICIONALES]:checked").val();

	var IDE = $('#id_ejercicio option:selected').val();

	//alert("d: " + cdesde + " h: " + chasta + " r: " + destino + " d: " + IDE);

	var myJSON = '{"FDESDE":"' + fdesde + '", "FHASTA":"' + fhasta + '","CDESDE":"' + cdesde + '", "CHASTA":"' + chasta + '", "PREFIJO":"' + prefijo + '", "DESTINO":"' + destino + '", "ADICIONALES":"' + adicionales + '", "IDE":"' + IDE + '"}';
	var myObj = JSON.parse(myJSON);

	//alert("report2");

	const fechadesde = new Date(fdesde + " 00:00:00");
	var fechadesdestr = _TOOLS.getFormattedDate(fechadesde, "dmy", "/");

	const fechahasta = new Date(fhasta + " 00:00:00");
	var fechahastastr = _TOOLS.getFormattedDate(fechahasta, "dmy", "/");

	var titulo = "" + fechadesdestr + " - " + fechahastastr;


	_AJAX.UiGetLibroMayorHistorico(myObj).then(function (datajson) {
		var _html = "";

		//alert("JSON: " + JSON.stringify(datajson.estadistica));



		//alert("come back");
		var _header = "";
		var _footer = "";
		_header += "<br/><table style='width: 100%;padding: 10px' border=0 cellspacing=0>";
		_header += "<tr><th style='text-align:center;border: 2px solid black'>Nro de Cuenta</th><th style='text-align:center;border: 2px solid black'>Nombre</th><th style='text-align:center;border: 2px solid black' >Fecha</th><th style='text-align:center;border: 2px solid black' >N.ASTO</th><th style='text-align:center;border: 2px solid black'  >TC</th><th style='text-align:center;border: 2px solid black' >N.COMP</th><th style='text-align:center;border: 2px solid black' >Débitos</th><th style='text-align:center;border: 2px solid black'>Créditos</th><th style='text-align:center;border: 2px solid black' >Sdo Acumulado</th></tr>";
		_header += "<tr><th style='text-align:center;border: 2px solid black' colspan=2>Comentario del asiento</th><th style='text-align:center;border: 2px solid black' colspan=3>Saldo Anterior</th><th style='text-align:center;border: 2px solid black' colspan=2>&nbsp;</th><th style='text-align:center;border: 2px solid black' colspan=2>Saldo Actual</th></tr>";

		var _tituloAnt = "";

		var _sumaDebito = 0;
		var _sumaCredito = 0;
		var _sumaImp = 0;
		var _totalDebito = 0;
		var _totalCredito = 0;
		var _totalImp = 0;
		var _fecha = "";
		var _fechaAnt = "N/A";
		var _numeroAnt = "N/A";
		var _numero = "";
		var txtCre = "";
		var txtDeb = "";
		var cre = 0;
		var deb = 0;
		var fila = 0;
		var acocom = "";
		var qrySdoAnt = 0;
		var tot = 0;
		var _formattedDate = "";
		var totalqrySdoAnt = 0;

		$.each(datajson.estadistica, function (j, val1) {


			_numero = val1.NUMERO;

			if (_numero != _numeroAnt) {
				/*antes de reset cierro tabla anterior siempre y cuando no sea la primer fila*/
				if (_numeroAnt != "N/A") {
					//alert(_sumaDebito);
					//alert(_sumaCredito);
					tot = Number(qrySdoAnt) + Number(_sumaImp);
					_html += "<tr><td style='text-align:left;border-bottom: 2px solid black;padding:8px;' colspan=2> TOTALES: " + _tituloAnt + "</td><td style='text-align:right;border-bottom: 2px solid black;padding:8px;' colspan=3>" + _TOOLS.showNumber(qrySdoAnt, 2, "", "0") + "</td><td style='text-align:right;border-top: 2px solid black;border-bottom: 2px solid black;padding:8px;'>&nbsp;</td><td style='text-align:right;border-top: 2px solid black;border-bottom: 2px solid black;padding:8px;'>" + _TOOLS.showNumber(_sumaDebito, 2, "", "0") + "</td><td style='text-align:right;border-top: 2px solid black;border-bottom: 2px solid black;padding:8px;'>" + _TOOLS.showNumber(_sumaCredito, 2, "", "0") + "</td><td style='text-align:right;border-top: 2px solid black;border-bottom: 2px solid black;padding:8px;'>" + _TOOLS.showNumber(tot, 2, "", "0") + "</td></tr>";

				}
				_tituloAnt = val1.NUMERO;
				qrySdoAnt = val1.qrySdoAnt;
				_sumaCredito = 0;
				_sumaDebito = 0;
				_sumaImp = 0;
				_html += "<tr><td style='text-align:center;padding:5px;' colspan=1> " + val1.NUMERO + "</td><td style='text-align:center;padding:5px;' colspan=6>" + val1.NOMBRE + "</td></tr>";
			};
			try {
				if (isNaN(val1.qryCre)) {
					txtCre = "";
				}
				else {
					cre = Number(val1.qryCre);
					_sumaCredito += cre;
					_totalCredito += cre;
					txtCre = _TOOLS.showNumber(cre, 2, "", "");
				}

			} catch (errort) { txtCre = ""; }

			try {
				if (isNaN(val1.qryDeb)) {
					txtDeb = "";
				}
				else {
					deb = Number(val1.qryDeb);
					_sumaDebito += deb;
					_totalDebito += deb;
					txtDeb = _TOOLS.showNumber(deb, 2, "", "");
				}

			} catch (errort1) { txtDeb = ""; }

			_sumaImp = _sumaDebito - _sumaCredito;
			totalqrySdoAnt += qrySdoAnt;

			if (adicionales == "A") { acocom = _TOOLS.showNumber(_sumaImp, 2, "", ""); } else { acocom = val1.qryObsRen; }
			try {
				_formattedDate = nullToEmpty(val1.FECHA);
				if (val1.NUMERO == "111303") {
					//alert("1" +_formattedDate);
				}
				if (_formattedDate != "") { _formattedDate = _TOOLS.getTextAsFormattedDate(_formattedDate, "dmy", "/"); } else { _formattedDate = ""; }

			} catch (errord) { _formattedDate = ""; }

			_html += "<tr><td style='text-align:left;' colspan=2>" + nullToEmpty(val1.COMENTARIO) + "</td><td style='text-align:left;'>" + _formattedDate + "</td><td style='text-align:left;'>" + nullToEmpty(val1.ASIENTO) + "</td><td style='text-align:left;'>" + nullToEmpty(val1.TIPCOM) + "</td><td style='text-align:right;'>" + nullToEmpty(val1.NUMCOM) + "</td><td style='text-align:right;'>" + txtDeb + "</td><td style='text-align:right;'>" + txtCre + "</td><td style='text-align:right;'>" + nullToEmpty(acocom) + "</td></tr>";

			_numeroAnt = _numero;
			fila = fila + 1;
		});
		/*renlon d cierre*/
		if (fila > 0) {
			var totfin = Number(totalqrySdoAnt) + Number(_totalDebito) - Number(_totalCredito);
			//	_html += "<tr><td style='text-align:left;border-bottom: 2px solid black;padding:8px;' colspan=4>" + _tituloAnt + "</td><td style='text-align:right;border-top: 2px solid black;border-bottom: 2px solid black;padding:8px;'>" + _TOOLS.showNumber(_sumaDebito, 2, "", "") + "</td><td style='text-align:right;border-top: 2px solid black;border-bottom: 2px solid black;padding:8px;'>" + _TOOLS.showNumber(_sumaCredito, 2, "", "") + "</td></tr>";
			_html += "<tr><td style='text-align:left;border-bottom: 2px solid black;padding:8px;' colspan=2> TOTALES: " + _tituloAnt + "</td><td style='text-align:right;border-bottom: 2px solid black;padding:8px;' colspan=3>" + _TOOLS.showNumber(qrySdoAnt, 2, "", "0") + "</td><td style='text-align:right;border-top: 2px solid black;border-bottom: 2px solid black;padding:8px;'>&nbsp;</td><td style='text-align:right;border-top: 2px solid black;border-bottom: 2px solid black;padding:8px;'>" + _TOOLS.showNumber(_sumaDebito, 2, "", "0") + "</td><td style='text-align:right;border-top: 2px solid black;border-bottom: 2px solid black;padding:8px;'>" + _TOOLS.showNumber(_sumaCredito, 2, "", "0") + "</td><td style='text-align:right;border-top: 2px solid black;border-bottom: 2px solid black;padding:8px;'>" + _TOOLS.showNumber(tot, 2, "", "0") + "</td></tr>";
			_html += "<tr><td style='text-align:left;' colspan=2> TOTAL DÉBITOS y CRËDITOS </td><td style='text-align:right;' colspan=3>" + _TOOLS.showNumber(totalqrySdoAnt, 2, "", "") + "</td><td style='text-align:right;'>&nbsp;</td><td style='text-align:right;'>" + _TOOLS.showNumber(_totalDebito, 2, "", "") + "</td><td style='text-align:right;'>" + _TOOLS.showNumber(_totalCredito, 2, "", "") + "</td><td style='text-align:right;'>" + _TOOLS.showNumber(totfin, 2, "", "") + "</td></tr>";
		}


		//if (totimptad != 0) {
		//	_adelantados += "<tr><td style='text-align:center;border: 1px solid black'>TOTALES</td><td style='text-align:center;border: 1px solid black'>" + totcantad + "</td><td style='text-align:left;border: 1px solid black'>" + _TOOLS.showNumber(totportad, 1, "", 0) + "</td><td style='text-align:right;border: 1px solid black'>" + _TOOLS.showNumber(totimptad, 2, "", 0) + "</td></tr>";
		//}

		//if (totimptal != 0) {
		//	_aldia += "<tr><td style='text-align:center;border: 1px solid black'>TOTALES</td><td style='text-align:center;border: 1px solid black'>" + totcantal + "</td><td style='text-align:left;border: 1px solid black'>" + _TOOLS.showNumber(totportal, 1, "", 0) + "</td><td style='text-align:right;border: 1px solid black'>" + _TOOLS.showNumber(totimptal, 2, "", 0) + "</td></tr>";
		//}

		//if (totimptat != 0) {
		//	_atrasados += "<tr><td style='text-align:center;border: 1px solid black'>TOTALES</td><td style='text-align:center;border: 1px solid black'>" + totcantat + "</td><td style='text-align:left;border: 1px solid black'>" + _TOOLS.showNumber(totportat, 1, "", 0) + "</td><td style='text-align:right;border: 1px solid black'>" + _TOOLS.showNumber(totimptat, 2, "", 0) + "</td></tr>";
		//}

		_footer += "</table>";
		//alert("after chabon " + _adelantados);
		_html = _header + _html + _footer + "<br/><br/>";



		//////$("#REPORT-CONTAINER").html(_html);

		var win = window.open("", "Reporte", "toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1024,height=768,top=" + (screen.height - 0) + ",left=" + (screen.width - 0));
		win.document.body.innerHTML = "<html><title>Libro Mayor Histórico</title><body><img src='" + _AJAX._here + "/assets/img/print.jpg' style='height:35px;' onclick='window.print();'/><br/>Cementerio Disidentes <br/> Fecha: " + _TOOLS.getTodayDate("dmy", "/") + "<br/><h2 class='m-0 p-0' style='font-weight: bold; color: rgb(0,71,186);'><center>PERIODO " + titulo + "<br/>MAYOR DE LAS CUENTAS HISTÓRICO AL " + _TOOLS.getTodayDate("dmy", "/") + "</center></h2>" + _html + "</body></html>";
	});

}

