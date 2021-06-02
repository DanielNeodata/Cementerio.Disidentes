
function showReport() {
	//alert("report");
	var desde = $('#TB-aDesde').val();
	var hasta = $('#TB-aHasta').val();

	const fechadesde = new Date(desde + ' 00:00:00');

	var fechadesdestr = _TOOLS.getFormattedDate(fechadesde, "dmy", "/");

	const fechahasta = new Date(hasta + ' 00:00:00');

	var fechahastastr = _TOOLS.getFormattedDate(fechahasta, "dmy", "/");

	var titulo = "" + fechadesdestr + " - " + fechahastastr;

	//alert(desde + "-" + hasta+ "-"+b);

	var myJSON = '{"DESDE":"' + desde + '", "HASTA":"' + hasta + '"}';
	var myObj = JSON.parse(myJSON);
	//alert("report2");

	_AJAX.UiGetRenocacionesXFecha(myObj).then(function (datajson) {
		var _html = "";
		//alert("JSON: " + JSON.stringify(datajson.rubros));


		_html += "<br/><table style='width: 100%;padding: 10px' border=0>";
		_html += "<tr><th style='text-align:left;border-bottom: 2px solid black'>Fecha</th><th style='text-align:left;border-bottom: 2px solid black'>Número Recibo</th><th style='text-align:left;border-bottom: 2px solid black'>Sección</th><th style='text-align:left;border-bottom: 2px solid black'>Sepultura</th><th style='text-align:left;border-bottom: 2px solid black'>Responsable</th><th style='text-align:left;border-bottom: 2px solid black'>Concepto</th><th style='text-align:left;border-bottom: 2px solid black'>Importe</th></tr>";
		var total = Number(0);
		var filas = Number(0);
		$.each(datajson.renovaciones, function (j, val1) {
			_html += "<tr><td style='text-align:left;'>" + val1.FECHA_EMIS_SPA + "</td><td style='text-align:left;'>" + val1.NRO_RECIBO + "</td><td style='text-align:left;'>" + val1.SECCION + "</td><td style='text-align:left;'>" + val1.SEPULTURA + "</td><td style='text-align:left;'>" + _TOOLS.nullToEmpty(val1.RESPONSABL) + "</td><td style='text-align:left;'>" + val1.CONCEPTO + "</td><td style='text-align:left;'>" + val1.IMPORTE + "</td></tr>";
			total = total + Number(val1.IMPORTE);
			filas++;
		});
		_html += "<tr><td style='text-align:left;border-top: 2px solid black'>TOTAL: </td><td style='text-align:left;border-top: 2px solid black'></td><td style='text-align:left;border-top: 2px solid black'>" + filas + "</td><td style='text-align:left;border-top: 2px solid black'></td><td style='text-align:left;border-top: 2px solid black'></td><td style='text-align:left;border-top: 2px solid black'></td><td style='text-align:left;border-top: 2px solid black'>" + _TOOLS.showNumber(total,2,"",0) + "</td></tr>";
		_html += "</table>";

		////$("#REPORT-CONTAINER").html(_html);

		var win = window.open("", "Reporte", "toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1024,height=768,top=" + (screen.height - 0) + ",left=" + (screen.width - 0));
		win.document.body.innerHTML = "<html><title>Renovaciones por fecha</title><body><img src='" + _AJAX._here + "/assets/img/print.jpg' style='height:35px;' onclick='window.print();'/><br/><br/>Cementerio Disidentes <br/> Fecha: " + _TOOLS.getTodayDate("dmy", "/") + "<br/><br/> <h2 class='m-0 p-0' style='font-weight: bold; color: rgb(0,71,186);'>Listado de Renovaciones por fecha: " + titulo + "</h2>" + _html + "</body></html>";
	});


}
