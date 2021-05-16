
function showReport() {
	//alert("report");
	var desde = $('#TB-aDesde').val();
	var hasta = $('#TB-aHasta').val();
	var recalcula = "N";
	var detallado = "N";

	if ($('#recalcula').is(":checked")) {
		recalcula = "S";
	}

	if ($('#detallado').is(":checked")) {
		detallado = "S";
	}

	//alert("d: " + desde + " h: " + hasta + " r: " + recalcula + " d: " + detallado);

	var myJSON = '{"DESDE":"' + desde + '", "HASTA":"' + hasta + '", "RECALCULA":"' + recalcula + '", "DETALLADO":"' + detallado + '"}';
	var myObj = JSON.parse(myJSON);
	//alert("report2");



	_AJAX.UiGetEstadisticasGenerales(myObj).then(function (datajson) {
		var _html = "";
		//alert("JSON: " + JSON.stringify(datajson.totsecc));

		var s = datajson.totsecc;
		//alert(s);
		var bi = datajson.totbim;
		//alert(bi);

		dif = Number(s) - Number(bi);

		var titulo = "<div style='float: right'><table width:100%><tr width:100%><tbody></tbody><td  width:100% align=right>Total de Lotes: " + s + "</td></tr/>";
		titulo = titulo + "<tr width:100%><td  width:100% aligh=right> EX / UC / OS / Disponibles: " + dif + "</td></tr>";
		titulo = titulo + "<tr width:100%><td  width:100% align=right> Total: " + bi + "</td></tr></table></div>";

		//alert(titulo);
		var _header = "";
		var _footer = "";
		_header += "<br/><table style='width: 100%;padding: 10px' border=0 cellspacing=0>";
		_header += "<tr><th style='text-align:left;border-bottom: 2px solid black'>Bimestre</th><th style='text-align:left;border-bottom: 2px solid black'>Cantidad</th><th style='text-align:left;border-bottom: 2px solid black'>% Deudor</th><th style='text-align:left;border-bottom: 2px solid black'>Total $</th></tr>";

		var _adelantados = "";
		var _atrasados = "";
		var _aldia = "";
		var _bimant = "";

		var bimestre = 0;

		var totcantad = 0;
		var totportad = 0;
		var totimptad = 0;

		var totcantat = 0;
		var totportat = 0;
		var totimptat = 0;

		var totcantal = 0;
		var totportal = 0;
		var totimptal = 0;

		$.each(datajson.estadistica, function (j, val1) {

			bimestre = Number(val1.BIMESTRE);
			//alert(bimestre);

			if ((_bimant != bimestre)) {

				if (bimestre < 0) {
					_adelantados += "<tr><td style='text-align:center;border: 1px solid black'>" + bimestre * -1 + "</td><td style='text-align:center;border: 1px solid black'>" + val1.CANTIDAD + "</td><td style='text-align:left;border: 1px solid black'>" + _TOOLS.showNumber(val1.PORCENT1, 1, "", 0) + "</td><td style='text-align:right;border: 1px solid black'>" + _TOOLS.showNumber(val1.IMPORTE, 2, "", 0) + "</td></tr>";

					totcantad += Number(val1.CANTIDAD);
					totportad += Number(val1.PORCENT1);
					totimptad += Number(val1.IMPORTE);


				} else if (bimestre == 0) {
					_aldia += "<tr><td style='text-align:center;border: 1px solid black'>" + bimestre + "</td><td style='text-align:center;border: 1px solid black'>" + val1.CANTIDAD + "</td><td style='text-align:left;border: 1px solid black'>" + _TOOLS.showNumber(val1.PORCENT1, 1, "", 0) + "</td><td style='text-align:right;border: 1px solid black'>" + _TOOLS.showNumber(val1.IMPORTE, 2, "", 0) + "</td></tr>";
					totcantal += Number(val1.CANTIDAD);
					totportal += Number(val1.PORCENT1);
					totimptal += Number(val1.IMPORTE);
				} else {
					_atrasados += "<tr><td style='text-align:center;border: 1px solid black'>" + bimestre + "</td><td style='text-align:center;border: 1px solid black'>" + val1.CANTIDAD + "</td><td style='text-align:left;border: 1px solid black'>" + _TOOLS.showNumber(val1.PORCENT1, 1, "", 0) + "</td><td style='text-align:right;border: 1px solid black'>" + _TOOLS.showNumber(val1.IMPORTE, 2, "", 0) + "</td></tr>";
					totcantat += Number(val1.CANTIDAD);
					totportat += Number(val1.PORCENT1);
					totimptat += Number(val1.IMPORTE);
				}
			}
			_bimant = bimestre;
			if (detallado == "S") {
				if (bimestre < 0) {
					_adelantados += "<tr><td style='text-align:right;'>" + val1.SECCION + "</td><td style='text-align:right;'>" + val1.SEPULTURA + "</td><td style='text-align:left;'>" + val1.TITULAR + "</td><td style='text-align:right;'>" + _TOOLS.showNumber(val1.IMPORTEDETALLE, 2, "", 0) + "</td></tr>";
				} else if (bimestre == 0) {
					_aldia += "<tr><td style='text-align:right;'>" + val1.SECCION + "</td><td style='text-align:right;'>" + val1.SEPULTURA + "</td><td style='text-align:left;'>" + val1.TITULAR + "</td><td style='text-align:right;'>" + _TOOLS.showNumber(val1.IMPORTEDETALLE, 2, "", 0) + "</td></tr>";
				} else {
					_atrasados += "<tr><td style='text-align:right;'>" + val1.SECCION + "</td><td style='text-align:right;'>" + val1.SEPULTURA + "</td><td style='text-align:left;'>" + val1.TITULAR + "</td><td style='text-align:right;'>" + _TOOLS.showNumber(val1.IMPORTEDETALLE, 2, "", 0) + "</td></tr>";
				}
			}

			//	_html += "<tr><td style='text-align:left;'>" + val1.FECHA_EMIS_SPA + "</td><td style='text-align:left;'>" + val1.NRO_RECIBO + "</td><td style='text-align:left;'>" + val1.SECCION + "</td><td style='text-align:left;'>" + val1.SEPULTURA + "</td><td style='text-align:left;'>" + _TOOLS.nullToEmpty(val1.RESPONSABL) + "</td><td style='text-align:left;'>" + val1.CONCEPTO + "</td><td style='text-align:left;'>" + val1.IMPORTE + "</td></tr>";
			//	total = total + Number(val1.IMPORTE);
			//	filas++;
		});
		//_html += "<tr><td style='text-align:left;border-top: 2px solid black'>TOTAL: </td><td style='text-align:left;border-top: 2px solid black'></td><td style='text-align:left;border-top: 2px solid black'>" + filas + "</td><td style='text-align:left;border-top: 2px solid black'></td><td style='text-align:left;border-top: 2px solid black'></td><td style='text-align:left;border-top: 2px solid black'></td><td style='text-align:left;border-top: 2px solid black'>" + _TOOLS.showNumber(total, 2, "", 0) + "</td></tr>";

		//alert(totimptad);

		if (totimptad != 0) {
			_adelantados += "<tr><td style='text-align:center;border: 1px solid black'>TOTALES</td><td style='text-align:center;border: 1px solid black'>" + totcantad + "</td><td style='text-align:left;border: 1px solid black'>" + _TOOLS.showNumber(totportad, 1, "", 0) + "</td><td style='text-align:right;border: 1px solid black'>" + _TOOLS.showNumber(totimptad, 2, "", 0) + "</td></tr>";
		}

		if (totimptal != 0) {
			_aldia += "<tr><td style='text-align:center;border: 1px solid black'>TOTALES</td><td style='text-align:center;border: 1px solid black'>" + totcantal + "</td><td style='text-align:left;border: 1px solid black'>" + _TOOLS.showNumber(totportal, 1, "", 0) + "</td><td style='text-align:right;border: 1px solid black'>" + _TOOLS.showNumber(totimptal, 2, "", 0) + "</td></tr>";
		}

		if (totimptat != 0) {
			_atrasados += "<tr><td style='text-align:center;border: 1px solid black'>TOTALES</td><td style='text-align:center;border: 1px solid black'>" + totcantat + "</td><td style='text-align:left;border: 1px solid black'>" + _TOOLS.showNumber(totportat, 1, "", 0) + "</td><td style='text-align:right;border: 1px solid black'>" + _TOOLS.showNumber(totimptat, 2, "", 0) + "</td></tr>";
		}

		_footer += "</table>";
		//alert("after chabon " + _adelantados);
		_html += "<h3>PAGOS ADELANTADOS</h3>" + _header + _adelantados + _footer + "<br/><br/>";
		_html += "<h3>PAGOS ATRASADOS</h3>" + _header + _atrasados + _footer + "<br/><br/>";
		_html += "<h3>PAGOS AL DIA</h3>" + _header + _aldia + _footer + "<br/><br/>";


		//////$("#REPORT-CONTAINER").html(_html);

		var win = window.open("", "Reporte", "toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1024,height=768,top=" + (screen.height - 0) + ",left=" + (screen.width - 0));
		win.document.body.innerHTML = "<html><title>Renovaciones por fecha</title><body><img src='" + _AJAX._here + "/assets/img/print.jpg' style='height:35px;' onclick='window.print();'/><br/>Cementerio Disidentes <br/> Fecha: " + _TOOLS.getTodayDate("dmy", "/") + "<br/><h2 class='m-0 p-0' style='font-weight: bold; color: rgb(0,71,186);'><center>Estadisticas completas de deudas</center></h2>" + titulo + _html + "</body></html>";
	});

}
