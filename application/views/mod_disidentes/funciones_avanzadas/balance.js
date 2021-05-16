
function nullToEmpty(valor) {
	if (valor == null) { return ""; }
	if (valor == "null") { return ""; }
	if (typeof valor === "undefined") { return ""; }
	return valor;
}

function nullTo(valor,ret) {
	if (valor == null) { return ret; }
	if (valor == "null") { return ret; }
	if (typeof valor === "undefined") { return ret; }
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

	//alert("d: " + cdesde + " h: " + chasta + " r: " + destino + " d: " + adicionales);

	var myJSON = '{"FDESDE":"' + fdesde + '", "FHASTA":"' + fhasta + '","CDESDE":"' + cdesde + '", "CHASTA":"' + chasta + '", "PREFIJO":"' + prefijo + '", "DESTINO":"' + destino + '", "ADICIONALES":"' + adicionales + '"}';
	var myObj = JSON.parse(myJSON);

	//alert("report2");

	const fechadesde = new Date(fdesde + " 00:00:00");
	var fechadesdestr = _TOOLS.getFormattedDate(fechadesde, "dmy", "/");

	const fechahasta = new Date(fhasta + " 00:00:00");
	var fechahastastr = _TOOLS.getFormattedDate(fechahasta, "dmy", "/");

	var titulo = "" + fechadesdestr + " - " + fechahastastr;


	_AJAX.UiGetBalance(myObj).then(function (datajson) {
		var _html = "";

		//alert("JSON: " + JSON.stringify(datajson.estadistica));



		//alert("come back");
		var _header = "";
		var _footer = "";
		_header += "<br/><table style='width: 100%;padding: 10px' border=0 cellspacing=0>";
		_header += "<tr><th style='text-align:center;border: 2px solid black'>Nro de Cuenta</th><th style='text-align:center;border: 2px solid black'>Nombre de cuenta</th><th style='text-align:center;border: 2px solid black' >Saldo Anterior</th><th style='text-align:center;border: 2px solid black' >Total Débitos</th><th style='text-align:center;border: 2px solid black'  >Total Créditos</th><th style='text-align:center;border: 2px solid black' >Saldo Actual</th></tr>";

		var _tituloAnt = "";

		var decTotAnt = 0;
		var decTotDeb = 0;
		var decTotCre = 0;
		var decTotAct = 0;
		var fila = 0;
		
		$.each(datajson.estadistica, function (j, val1) {

			if (Number(nullTo(val1.qryHasMovs, 0)) > 0) {

				if (((adicionales == "C") && val1.ROC == "C") || ((adicionales == "R") && val1.ROC == "R") || (adicionales == "B")) {
					_html += "<tr><td style='text-align:left;'>" + nullToEmpty(val1.qryIndent) + nullToEmpty(val1.NUMERO) + "</td>";
					_html += "<td style = 'text-align:left;'> " + nullToEmpty(val1.qryIndent) + nullToEmpty(val1.NOMBRE) + "</td >";

					_html += "<td style='text-align:right;'>" + _TOOLS.showNumber(nullToEmpty(val1.qrySdoAnt), 2, "", "") + "</td>";

					_html += "<td style='text-align:right;'>" + _TOOLS.showNumber(nullToEmpty(val1.qryTotDeb), 2, "", "") + "</td>";
					_html += "<td style='text-align:right;'>" + _TOOLS.showNumber(nullToEmpty(val1.qryTotCre), 2, "", "") + "</td>";
					_html += "<td style='text-align:right;'>" + _TOOLS.showNumber(nullToEmpty(val1.qrySdoAct), 2, "", "") + "</td>";
				}

				if (val1.ROC == "C") {
					decTotAnt = decTotAnt + Number(val1.qrySdoAnt);
					decTotDeb = decTotDeb + Number(val1.qryTotDeb);
					decTotCre = decTotCre + Number(val1.qryTotCre);
					decTotAct = decTotAct + Number(val1.qrySdoAct);
				}

				fila = fila + 1;
			}
		});
		/*renlon d cierre*/
		if (fila > 0) {
		/*
				row = new TableRow();
				row.TableSection = TableRowSection.TableBody;
				row.Cells.Add(new TableCell()); row.Cells[0].Text = "TOTALES"; row.Cells[0].Style.Add("border-top-style", "solid");
				row.Cells.Add(new TableCell()); row.Cells[1].Text = ""; row.Cells[1].Style.Add("border-top-style", "solid");
				c = 2; row.Cells.Add(new TableCell()); row.Cells[c].Text = string.Format("{0:0}", decTotAnt); row.Cells[c].HorizontalAlign = HorizontalAlign.Right; row.Cells[c].Style.Add("border-top-style", "solid");
				c++; row.Cells.Add(new TableCell()); row.Cells[c].Text = string.Format("{0:0}", decTotDeb); row.Cells[c].HorizontalAlign = HorizontalAlign.Right; row.Cells[c].Style.Add("border-top-style", "solid");
				c++; row.Cells.Add(new TableCell()); row.Cells[c].Text = string.Format("{0:0}", decTotCre); row.Cells[c].HorizontalAlign = HorizontalAlign.Right; row.Cells[c].Style.Add("border-top-style", "solid");
				c++; row.Cells.Add(new TableCell()); row.Cells[c].Text = string.Format("{0:0}", decTotAct); row.Cells[c].HorizontalAlign = HorizontalAlign.Right; row.Cells[c].Style.Add("border-top-style", "solid");
				tblRpt.Rows.Add(row);
		*/
			_html += "<tr><td style='text-align:left;border-top: 2px solid black;'>TOTALES</td>";
			_html += "<td style = 'text-align:left;border-top: 2px solid black'> &nbsp;</td >";

			_html += "<td style='text-align:right;border-top: 2px solid black;'>" + _TOOLS.showNumber(nullToEmpty(decTotAnt), 2, "", "") + "</td>";

			_html += "<td style='text-align:right;border-top: 2px solid black;'>" + _TOOLS.showNumber(nullToEmpty(decTotDeb), 2, "", "") + "</td>";
			_html += "<td style='text-align:right;border-top: 2px solid black;'>" + _TOOLS.showNumber(nullToEmpty(decTotCre), 2, "", "") + "</td>";
			_html += "<td style='text-align:right;border-top: 2px solid black;'>" + _TOOLS.showNumber(nullToEmpty(decTotAct), 2, "", "") + "</td>";
		}



		_footer += "</table>";
		//alert("after chabon " + _adelantados);
		_html = _header + _html + _footer + "<br/><br/>";



		//////$("#REPORT-CONTAINER").html(_html);

		var win = window.open("", "Reporte", "toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1024,height=768,top=" + (screen.height - 0) + ",left=" + (screen.width - 0));
		win.document.body.innerHTML = "<html><title>BALANCE DE SUMAS Y SALDOS</title><body><img src='" + _AJAX._here + "/assets/img/print.jpg' style='height:35px;' onclick='window.print();'/><br/>Cementerio Disidentes <br/> Fecha: " + _TOOLS.getTodayDate("dmy", "/") + "<br/><h2 class='m-0 p-0' style='font-weight: bold; color: rgb(0,71,186);'><center>PERIODO " + titulo + "<br/>BALANCE DE SUMAS Y SALDOS </center></h2>" + _html + "</body></html>";
	});

}

