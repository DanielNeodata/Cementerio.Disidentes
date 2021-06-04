

function showTable() {
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

	_AJAX.UiGetResumenCajaXFecha(myObj).then(function (datajson) {
		var _html = "";
		//alert("JSON: " + JSON.stringify(datajson.rubros));


		_html += "<br/><table style='width: 20%;padding: 10px' border=0>";
		_html += "<tr><th style='text-align:left;border-bottom: 2px solid black'>&nbsp;</th><th style='text-align:center;border-bottom: 2px solid black'>Importe</th></tr>";
		var total = Number(0);
		var filas = Number(0);
		$.each(datajson.portipo, function (j, val1) {
			_html += "<tr><td style='text-align:left;'>" + val1.DENOMINACION + "</td><td style='text-align:right;'>" + _TOOLS.showNumber(val1.SumOfIMPORTE, 2, "", 0) + "</td></tr>";
			total = total + Number(val1.SumOfIMPORTE);
			filas++;
		});
		_html += "<tr><td style='text-align:left;border-top: 2px solid black'>SUB TOTAL: </td><td style='text-align:right;border-top: 2px solid black'>" + _TOOLS.showNumber(total, 2, "", 0) + "</td></tr>";
		_html += "</table>";

		_html += "&nbsp;&nbsp;&nbsp;&nbsp;"

		_html += "<br/><table style='width: 70%;padding: 10px' border=1>";
		_html += "<tr><th style='text-align:center;border-bottom: 2px solid black'>Pesos</th><th style='text-align:center;border-bottom: 2px solid black'>Cheques</th><th style='text-align:center;border-bottom: 2px solid black'>Dólares</th><th style='text-align:center;border-bottom: 2px solid black'>Dólares en Pesos</th><th style='text-align:center;border-bottom: 2px solid black'>Cheque Diferido/Tarjetas</th><th style='text-align:center;border-bottom: 2px solid black'>Transf. Banco</th></tr>";

		var total = Number(0);
		var filas = Number(0);
		$.each(datajson.pormedio, function (j, val1) {
			_html += "<tr><td style='text-align:right;'>" + _TOOLS.showNumber(val1.SumOfPESOS, 2, "", 0) + "</td><td style='text-align:right;'>" + _TOOLS.showNumber(val1.SumOfCHEQUE, 2, "", 0) + "</td><td style='text-align:right;'>" + _TOOLS.showNumber(val1.SumOfDOLARES, 2, "", 0) + "</td><td style='text-align:right;'>" + _TOOLS.showNumber(val1.SumOfDolaresEnPesos, 2, "", 0) + "</td><td style='text-align:right;'>" + _TOOLS.showNumber(val1.SumOfTARJETA, 2, "", 0) + "</td><td style='text-align:right;'>" + _TOOLS.showNumber(val1.SumOfTransf, 2, "", 0) + "</td></tr>";
			total = total + Number(val1.qrySubTotal);
			filas++;
		});
		_html += "<tr><td style='text-align:left;border-top: 2px solid black'>TOTAL: </td><td style='text-align:right;border-top: 2px solid black'>" + _TOOLS.showNumber(total, 2, "", 0) + "</td><td colspan=4></td></tr>";
		_html += "</table><br/>";

		//_html += " <div class='form-row'>   ";
		_html += " 	<div class='col-12' style='padding-top: 15px; '>";
		_html += " 		<a href='#' class='btnAction btnAccept btn btn-success btn-raised pull-right' onclick='showReport(); '>Ver Detalle</a>";
		_html += " 	</div>";
		//_html += " </div>";

		$("#REPORT-CONTAINER").html(_html);

	});


}


function showReport() {
	//alert("report");
	var desde = $('#TB-aDesde').val();
	var hasta = $('#TB-aHasta').val();

	const fechadesde = new Date(desde + ' 00:00:00');

	var fechadesdestr = _TOOLS.getFormattedDate(fechadesde, "dmy", "/");

	const fechahasta = new Date(hasta + ' 00:00:00');

	var fechahastastr = _TOOLS.getFormattedDate(fechahasta, "dmy", "/");

	var titulo = "<center> Del " + fechadesdestr + " a " + fechahastastr +" </center>";

	//alert("d: " + desde + " h: " + hasta + " r: " + recalcula + " d: " + detallado);

	var myJSON = '{"DESDE":"' + desde + '", "HASTA":"' + hasta + '"}';
	var myObj = JSON.parse(myJSON);
	//alert("report2");

	var _recant = "";
	var pesos = 0;
	var dolares = 0;
	var cheque = 0;
	var transf = 0;
	var tarj = 0;
	var tot = 0;

	var _rec1 = "";

	var tpesos = 0;
	var tdolares = 0;
	var tcheque = 0;
	var ttransf = 0;
	var ttarj = 0;
	var ttot = 0;
	var tsubtot = 0;
	var dolpes = 0;
	var tdolpes = 0;
	var subtot = 0;

	_AJAX.UiGetDetalleCajaXFecha(myObj).then(function (datajson) {
		var _html = "";
		//alert("JSON: " + JSON.stringify(datajson.detalle));


		var _header = "";
		var _formattedDate = "";

		var conta = 0;

		$.each(datajson.detalle, function (j, val1) {

			//alert("init");


			//alert(bimestre);

			if (_recant == "") { _rec1 = val1.NRO_RECIBO;}

			_formattedDate = val1.FECHA_EMIS;
			//alert("init2");
			if (_formattedDate != "") { _formattedDate = _TOOLS.getTextAsFormattedDate(_formattedDate, "dmy", "/"); } else { _formattedDate = ""; }
			//alert("init3");

			if ((_recant != val1.NRO_RECIBO)) {
				//alert("recibo " + val1.NRO_RECIBO);
				if (_recant != "") {
					//si el recibo no es el primero, tengo que hacer el cierre
					tpesos = tpesos + pesos;
					tdolares += dolares;
					tcheque += cheque;
					ttransf += transf;
					ttarj += tarj;
					ttot += tot;
					tsubtot += Number(val1.qrySubTotal);
					tdolpes += dolpes;
					conta++;
					_header += "<tr><td style='text-align:right;border: 1px solid black' colspan=4>Total recibo: </td><td style='text-align:right;border: 1px solid black'>" + _TOOLS.showNumber(tot, 2, "", 0) + "</td></tr>";
					_header += "<tr><td style='text-align:center;border: 1px solid black'>Pesos: " + _TOOLS.showNumber(pesos, 2, "", 0) + "</td><td style='text-align:center;border: 1px solid black'>Dólares: " + _TOOLS.showNumber(dolares, 2, "", 0) + " ($ " + _TOOLS.showNumber(dolpes, 2, "", 0) + ")</td><td style='text-align:left;border: 1px solid black'>Cheque: " + _TOOLS.showNumber(cheque, 2, "", 0) + "</td><td style='text-align:right;border: 1px solid black'> Cheque Diferido / Tarjeta: " + _TOOLS.showNumber(tarj, 2, "", 0) + "</td><td style='text-align:right;border: 1px solid black'> Transferencia: " + _TOOLS.showNumber(transf, 2, "", 0) + "</td></tr></table>";
				}

				_header += "<br/><table style='width: 100%;padding: 10px' border=0 cellspacing=0>";
				_header += "<tr><th style='text-align:center;border-bottom: 2px solid black' colspan=5>Fecha: " + _formattedDate+" Recibo: "+val1.NRO_RECIBO+"</th></tr>";
			}


			_header += "<tr><td style='text-align:left;' colspan=4>" + val1.CONCEPTO + "</td><td style='text-align:right;'>" + _TOOLS.showNumber(val1.IMPORTE, 2, "", 0) + "</td></tr>";

			pesos = Number(val1.qryPESOS);
			dolares = Number(val1.qryDOLARES);
			dolpes = Number(val1.qryDolaresEnPesos);
			cheque = Number(val1.qryCHEQUE);
			transf = Number(val1.qryTRANSFERENCIAS);
			tarj = Number(val1.qryTARJETA);
			tot = Number(val1.qryTotal);
			subtot = Number(val1.qrySubTotal);
			

			
			_recant = val1.NRO_RECIBO;
		});
		//_html += "<tr><td style='text-align:left;border-top: 2px solid black'>TOTAL: </td><td style='text-align:left;border-top: 2px solid black'></td><td style='text-align:left;border-top: 2px solid black'>" + filas + "</td><td style='text-align:left;border-top: 2px solid black'></td><td style='text-align:left;border-top: 2px solid black'></td><td style='text-align:left;border-top: 2px solid black'></td><td style='text-align:left;border-top: 2px solid black'>" + _TOOLS.showNumber(total, 2, "", 0) + "</td></tr>";
		_header += "<tr><td style='text-align:right;border: 1px solid black' colspan=4>Total recibo: </td><td style='text-align:right;border: 1px solid black'>" + _TOOLS.showNumber(tot, 2, "", 0) + "</td></tr>";
		_header += "<tr><td style='text-align:center;border: 1px solid black'>Pesos: " + _TOOLS.showNumber(pesos, 2, "", 0) + "</td><td style='text-align:center;border: 1px solid black'>Dólares: " + _TOOLS.showNumber(dolares, 2, "", 0) + "</td><td style='text-align:left;border: 1px solid black'>Cheque: " + _TOOLS.showNumber(cheque, 2, "", 0) + "</td><td style='text-align:right;border: 1px solid black'> Cheque Diferido / Tarjeta: " + _TOOLS.showNumber(tarj, 2, "", 0) + "</td><td style='text-align:right;border: 1px solid black'> Transferencia: " + _TOOLS.showNumber(transf, 2, "", 0) + "</td></tr></table>";
		conta++;
		tpesos = tpesos + pesos;
		tdolares += dolares;
		tcheque += cheque;
		ttransf += transf;
		ttarj += tarj;
		ttot += tot;
		tsubtot += subtot;
		tdolpes += dolpes;

		_header += "<br/><table style='width: 100%;padding: 10px' border=0 cellspacing=0>";
		_header += "<tr><th style='text-align:center;border-bottom: 2px solid black;border-top: 2px solid black' colspan=1>Cantidad de recibos: " + conta + "</th><th style='text-align:center;border-bottom: 2px solid black;border-top: 2px solid black' colspan=2>Del número  " + _rec1 + " al número " + _recant + "</th></tr>";
		_header += "<tr><th style='text-align:center;border-bottom: 2px solid black' colspan=1>&nbsp;</th><th style='text-align:center;border-bottom: 2px solid black' colspan=2>TOTALES</th></tr>";
		_header += "<tr><td style='text-align:center' colspan=1>&nbsp;</td><td style='text-align:left;' colspan=1>Pesos</td><td style='text-align:right;' colspan=1>" + _TOOLS.showNumber(tpesos, 2, "", 0) + "</td></tr>";
		_header += "<tr><td style='text-align:center' colspan=1>&nbsp;</td><td style='text-align:left;' colspan=1>Cheque</td><td style='text-align:right;' colspan=1>" + _TOOLS.showNumber(tcheque, 2, "", 0) + "</td></tr>";
		_header += "<tr><td style='text-align:center' colspan=1>&nbsp;</td><td style='text-align:left;' colspan=1>Cheque diferido / Tarjeta </td><td style='text-align:right;' colspan=1>" + _TOOLS.showNumber(ttarj, 2, "", 0) + "</td></tr>";
		_header += "<tr><td style='text-align:center' colspan=1>&nbsp;</td><td style='text-align:left;' colspan=1>Transferencias</td><td style='text-align:right;' colspan=1>" + _TOOLS.showNumber(ttransf, 2, "", 0) + "</td></tr>";
		_header += "<tr><td style='text-align:center' colspan=1>&nbsp;</td><td style='text-align:left;' colspan=1>Sub Total</td><td style='text-align:right;' colspan=1>" + _TOOLS.showNumber(tsubtot, 2, "", 0) + "</td></tr>";
		_header += "<tr><td style='text-align:center' colspan=1>&nbsp;</td><td style='text-align:left;' colspan=1>Dólares</td><td style='text-align:right;' colspan=1>" + _TOOLS.showNumber(tdolares, 2, "", 0) + " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; " + _TOOLS.showNumber(tdolpes, 2, "", 0) + "</td></tr>";
		_header += "<tr><td style='text-align:center;border: 1px solid black' colspan=1>&nbsp;</td><td style='text-align:right;border: 1px solid black' colspan=1>Total: </td><td style='text-align:right;border: 1px solid black'>" + _TOOLS.showNumber(ttot, 2, "", 0) + "</td></tr>";
		_header += "";
		//alert("cont: " + conta);

		//alert(totimptad);


		//alert("after chabon " + _adelantados);
		_html += _header;

		//////$("#REPORT-CONTAINER").html(_html);

		var win = window.open("", "Reporte", "toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1024,height=768,top=" + (screen.height - 0) + ",left=" + (screen.width - 0));
		win.document.body.innerHTML = "<html><title>Detalle de movimientos de caja</title><body><img src='" + _AJAX._here + "/assets/img/print.jpg' style='height:35px;' onclick='window.print();'/><br/>Cementerio Disidentes <br/> Fecha: " + _TOOLS.getTodayDate("dmy", "/") + "<br/><h2 class='m-0 p-0' style='font-weight: bold; color: rgb(0,71,186);'><center>LISTADO DE CAJA DIARIA DETALLADO</center></h2>" + titulo + _html + "</body></html>";
	});

}
