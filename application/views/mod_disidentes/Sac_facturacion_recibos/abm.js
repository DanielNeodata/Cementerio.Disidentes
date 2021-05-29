
function showReport() {
	//alert("report");
	
	var recibo = $('#NRO_RECIBO').val();

	if (recibo == "") {
		alert("No hay un nro de recibo que mostrar....");
	}


	//alert(recibo);

	var myJSON = '{"NRORECIBO":"' + recibo + '"}';
	var myObj = JSON.parse(myJSON);
	//alert("report2");

	_AJAX.UiGetRecibo(myObj).then(function (datajson) {
		//alert("on ajax");
		var _html = "";
		//alert("JSON movs: " + JSON.stringify(datajson.movimientos));
		//alert("JSON data: " + JSON.stringify(datajson.data));

		var _concepto = "";
		var row = 0;
		
		$.each(datajson.movimientos, function (j, val1) {
			_concepto += val1.CONCEPTO + " " + _TOOLS.showNumber(val1.IMPORTE, 2, ",", "0") + "<br>";
			row++;
			//if (row == 5) { break; }
		});

		var nro_recibo = _TOOLS.numberWithLeadingZerosFixed(datajson.data[0].NRO_RECIBO);
		var fecha_recibo = datajson.data[0].FECHA_EMIS_SPA; //.ToString()).ToString("dd/MM/yyyy");
		var pagador_recibo = datajson.data[0].RESPONSABL;
		var fltTotal = datajson.data[0].TOTAL;
		var importe_recibo = _TOOLS.showNumber(fltTotal, 2, "", 0);
		var importe_letras_recibo_pesos = _TOOLS.numeroAtexto(importe_recibo).toUpperCase();;
		var importe_letras_recibo_dolares = "";
		if (datajson.data[0].DOLARES != 0) { importe_letras_recibo_dolares = _TOOLS.numeroAtexto(datajson.data[0].DOLARES).toUpperCase();;}

		_html += "<div id='divPrinter' style='position:absolute;left:0;top:0mm;'><img class='imgPrint' src='../media/imagenes/impresora.png' onclick=javascript:$('#divPrinter').hide();self.print() width='32'/></div>";
		_html += "<div style='position:absolute;left:135mm;top:0mm;'>" + fecha_recibo + "</div>";
		_html += "<div style='position:absolute;left:135mm;top:10mm;'>" + nro_recibo + "</div>";
		_html += "<div style='position:absolute;left:25mm;top:45mm;'>" + pagador_recibo + "</div>";
		_html += "<div style='position:absolute;left:0mm;top:55mm;'>" + _concepto + "</div>";
		_html += "<div style='position:absolute;left:135mm;top:105mm;'>" + importe_recibo + "</div>";
		_html += "<div style='position:absolute;left:20mm;top:105mm;'>" + importe_letras_recibo_pesos + "</div>";
		if (importe_letras_recibo_dolares != "") { _html += "<div style='position:absolute;left:20mm;top:117mm;'>u$s " + importe_letras_recibo_dolares + "</div>"; }

		_html += "<div style='position:absolute;left:135mm;top:140mm;'>" + fecha_recibo + "</div>";
		_html += "<div style='position:absolute;left:135mm;top:150mm;'>" + nro_recibo + "</div>";
		_html += "<div style='position:absolute;left:25mm;top:185mm;'>" + pagador_recibo + "</div>";
		_html += "<div style='position:absolute;left:0mm;top:195mm;'>" + _concepto + "</div>";
		_html += "<div style='position:absolute;left:135mm;top:250mm;'>" + importe_recibo + "</div>";
		_html += "<div style='position:absolute;left:20mm;top:250mm;'>" + importe_letras_recibo_pesos + "</div>";
		if (importe_letras_recibo_dolares != "") { _html += "<div style='position:absolute;left:20mm;top:255mm;'>u$s " + importe_letras_recibo_dolares + "</div>"; }

		

		//$("#REPORT-CONTAINER").html(_html);

		var win = window.open("", "Reporte", "toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1024,height=768,top=" + (screen.height - 0) + ",left=" + (screen.width - 0));
		win.document.body.innerHTML = "<html><title>Recibos</title><body><div id='divPrinter' style='position: absolute; left: 0; top: 0mm;'><img src='" + _AJAX._here + "/assets/img/print.jpg' style='height:35px;' onclick=\"javascript: document.getElementById('divPrinter').style.display = 'none'; self.print();\"/></div>" + _html + "</body></html>";
		//win.document.body.innerHTML = "<html><title>Recibos</title><body>" + _html + "</body></html>";
	});


}


function adjustTotalzPlain(justFormat) {
	
	var Pesos = document.getElementById('PESOS');
	var Cheque = document.getElementById('CHEQUE');
	var Tarjeta = document.getElementById('TARJETA');
	var Dolares = document.getElementById('DOLARES');
	var Cotizacion = document.getElementById('COTIZACION');
	var Transferencia = document.getElementById('TRANSFERENCIA');
	var txtTop = document.getElementById('TOTAL-1');
	var fltRta = 0.0;
	if (isNaN(parseFloat(Cheque.value))) { Cheque.value = 0; }
	if (isNaN(parseFloat(Tarjeta.value))) { Tarjeta.value = 0; }
	if (isNaN(parseFloat(Transferencia.value))) { Transferencia.value = 0; }
	if (isNaN(parseFloat(Dolares.value))) { Dolares.value = 0; }
	if (isNaN(parseFloat(Cotizacion.value))) { Cotizacion.value = 0; }
	if (txtTop == null) { txtTop = document.getElementById('TOTAL-1'); }
	if (justFormat == 0) {
		fltRta = parseFloat(txtTop.value) - (parseFloat(Transferencia.value) + parseFloat(Cheque.value) + parseFloat(Tarjeta.value) + parseFloat(Dolares.value) * parseFloat(Cotizacion.value));
	}
	else {
		fltRta = parseFloat(Pesos.value);
	}
	Cheque.value = parseFloat(Cheque.value);
	Tarjeta.value = parseFloat(Tarjeta.value);
	Dolares.value = parseFloat(Dolares.value);
	Cotizacion.value = parseFloat(Cotizacion.value);
	Transferencia.value = parseFloat(Transferencia.value);
	Pesos.value = fltRta;
}

function campoPrecio(tipo, sector, duracion) {
	var campo = "";
	switch (tipo) {
		case "AD":
			//alert("sector : AD antes");
			campo = "ARR" + sector + "DI" + duracion;
			//alert("sector : AD");
			break;
		case "AN":
			campo = "ARR" + sector + "ND" + duracion;
			//alert("sector : AN");
			break;
		case "NI":
			campo = "ARR" + sector + "DI" + duracion + "N";
			//alert("sector : NI");
			break;
		case "UA":
		case "UC":
		case "UR":
		case "CU":
			//alert("sector : UA/UC/UR/CU");
			campo = "ARR" + sector + "DI" + duracion + "U";
			break;
	}
	return campo;
}
function selectDuracionOnChange() {
	/*json precios*/
	var jsP = $("#OPER-PRECIOS").val().replace("[", "").replace("]", "");
	var obj = JSON.parse(jsP);
	/* duracion */
	var duracion = $('#cboYrs option:selected').val();
	/*tipo */
	var tipo = $('#aTipo option:selected').val();
	/*tipo */
	var sector = $('#TB-aSector').val();
	var val = 0;
	var campo = "";

	var fec = $('#FECHA_EMIS').val(); 

	if(fec.length < 11) { fec = fec + ' 00:00:00'; }

	//alert("TEST FECHA HORA: " + fec);
	const fecvvto = new Date(fec);
	fecvvto.setFullYear(fecvvto.getFullYear() + Number(duracion));
	//const nlBEFormattervto = new Intl.DateTimeFormat('en-EN');

	var sarasa = _TOOLS.getFormattedDate(fecvvto, 'amd', '-');
	//alert(sarasa);

	$('#TB-aVencimiento').val(sarasa); 
	

	
	campo = campoPrecio(tipo, sector, duracion);
	val = obj[campo];
	$('#TB-aPrecio').val(val); 
	$('#TB-aAnosArren').val(duracion); 
}

function selectLoteOnChange() {
	var idOption = Number($("#SELECT-OPER option:selected").val());

	switch (idOption) {
		case 1:
			/*validaciones para conservacion elegido el lote*/
			var idLote = $('#SELECT-LOTE option:selected').val();
			var responsable = $('#RESPONSABL').val();
			//alert("a: " + responsable);
			var myJSON = '{"ID":"' + idLote + '"}';
			var myObj = JSON.parse(myJSON);
			var valor = 0;

			var textW1 = "";
			$("#txtWarning").html(textW1);

			var jsP = $("#OPER-PRECIOS").val().replace("[", "").replace("]", "");
			var obj = JSON.parse(jsP);

			_AJAX.UiGetLote(myObj).then(function (datajson) {
				var _html = "";

				_html += "<br/>";
				_html += _TOOLS.getTextBox("Bimestres", "Cantidad Bimestres", 3, datajson.data[0].DEUDA, "Y", "class='form-control text dbase'");
				_html += "<br/>";


				if (responsable == "") { responsable = datajson.data[0].TITULAR; }
				//alert("a: ->" + responsable.trim() + "<- a titular ->" + datajson.data[0].TITULAR.trim()+"<-");
				if (datajson.data[0].TITULAR.trim() == responsable.trim()) {
					if (datajson.data[0].DEUDA < 0) {
						alert("** PAGOS ADELANTADOS **");
						var textW = "<strong><span style=\"color:blue;\">** PAGOS ADELANTADOS **</span></strong>";
						$("#txtWarning").html(textW);
					}

					var tipo = datajson.data[0].TIPO;
					//alert("b: " + tipo);
					switch (tipo) {
						case "AD":
							var p = obj.CON_ADULTO;
							valor = Number(p);
							break;
						case "AN":
							var p = obj.CON_ADULTO;
							valor = Number(p);
							break;
						case "NI":
							valor = Number(obj.CON_NIN_UR);
							break;
						case "UA":
							valor = Number(obj.CON_NIN_UR);
							break;
						case "UC":
							valor = Number(obj.CON_NIN_UR);
							break;
						case "CU":
							valor = Number(obj.CON_NIN_UR);
							break;
						case "EX": // Excento de pago
							valor = 0;
							break;
					}
					//alert("C: " + valor);
					_html += _TOOLS.getTextBox("importe", "Precio Unitario", 3, valor, "Y", "class='form-control text dbase'");
					_html += "<input id='TB-UltBimPago' type=text class='form-control text dbase' style='display: none' value='" + datajson.data[0].ULTBIMPAGO + "'/>";
					$("#OPER-CONTAINER-DETAIL").html(_html);
					$('#OPER-ADD-BTN').prop('disabled', false);
					//alert("done");

				}
				else {
					alert("No se puede otro titular de recibo");
				}

				//var j = datajson.data[0].TITULAR;
				//alert("Valor: " + j);

				//_TOOLS.loadCombo(datajson, { "target": "#SELECT-LOTE", "selected": -1, "id": "ID", "description": "ComboBusquedaRecibos" });
			});
			break;
		case 2:
			/*validaciones para renovacion elegido el lote*/
			var idLote = $('#SELECT-LOTE option:selected').val();
			var responsable = $('#RESPONSABL').val();
			//alert("a: " + responsable);
			var myJSON = '{"ID":"' + idLote + '"}';
			var myObj = JSON.parse(myJSON);
			var valor = 0;

			var textW1 = "";
			$("#txtWarning").html(textW1);

			var jsP = $("#OPER-PRECIOS").val().replace("[", "").replace("]", "");
			var obj = JSON.parse(jsP);

			_AJAX.UiGetLote(myObj).then(function (datajson) {
				//alert("renovacion2!");
				var _html = "";
				
				//_html += "<br/>";
				//_html += _TOOLS.getTextBox("Bimestres", "Cantidad Bimestres", 3, datajson.data[0].DEUDA, "Y", "class='form-control text dbase'");
				//_html += "<br/>";


				if (responsable == "") { responsable = datajson.data[0].TITULAR; }
				//alert("a: " + responsable);

				//if (sdrLot.HasRows &&
				//	string.IsNullOrEmpty(sdrLot["ULT_RENOVA"].ToString()) == false) {
					
				//}
				//alert("ult ren: "+datajson.data[0].ULT_RENOVA)
				
				if (datajson.data[0].ULT_RENOVA == "" || datajson.data[0].ULT_RENOVA == "null" || datajson.data[0].ULT_RENOVA == null) {
					//alert("vacio");
					var textW = "";
					$("#txtWarning").html(textW);
					
				}
				else {
					//alert("TEST FECHA HORA1: " + datajson.data[0].ULT_RENOVA);
					const fecha = new Date(datajson.data[0].ULT_RENOVA);
					var anos = datajson.data[0].ANOSRENOVA;
					if (anos == "" || anos == null || anos == "null") { anos = 0; }

					fecha.setFullYear(fecha.getFullYear() + anos);
					const nlBEFormatter = new Intl.DateTimeFormat('es-ES');
					

					var textW = "** VTO RENOV ACTUAL: " + nlBEFormatter.format(fecha) + " **";
					$("#txtWarning").html(textW);
					//alert("b: " + textW);
					var p = obj.CON_ADULTO;
					valor = Number(p);

					//alert("C: " + valor);
					//_html += _TOOLS.getTextBox("importe", "Precio Unitario", 3, valor, "Y", "class='form-control text dbase'");
					
					//alert("done");
				}
				
				$("#OPER-CONTAINER-DETAIL").html(_html);
				$('#OPER-ADD-BTN').prop('disabled', false);

				//var j = datajson.data[0].TITULAR;
				//alert("Valor: " + j);

				//_TOOLS.loadCombo(datajson, { "target": "#SELECT-LOTE", "selected": -1, "id": "ID", "description": "ComboBusquedaRecibos" });
			});
			break;
		case 3:
			/*validaciones para arrendamiento elegido el lote*/
			var idLote = $('#SELECT-LOTE option:selected').val();
			var responsable = $('#RESPONSABL').val();
			
			var myJSON = '{"ID":"' + idLote + '"}';
			var myObj = JSON.parse(myJSON);
			var valor = 0;

			var jsP = $("#OPER-PRECIOS").val().replace("[", "").replace("]", "");
			var obj = JSON.parse(jsP);

			_AJAX.UiGetLote(myObj).then(function (datajson) {
				var _html = "";

				if (responsable == "") { responsable = datajson.data[0].TITULAR; }
				var jFallecidos = "";

				//alert("JSON: " + JSON.stringify(datajson.fallecidos));

				if (datajson.fallecidos == null || datajson.fallecidos=="") {
					jFallecidos = "";
				}
				else {
					jFallecidos = datajson.fallecidos[0].ID;
				}

				


				var estOcup = datajson.data[0].ESTADO_OCUPACION;

				var conFallecido = "N";

				//alert(sTitDis + " <-> " + sResDis);
				var textW = "";
				$("#txtWarning").html(textW);

				if (estOcup=="REVIS" || estOcup=="ARREN") {

					//alert("vacio");
					var textW = "<strong><span style=\"color:red;\">El lote no está disponible</span></strong>";
					$("#txtWarning").html(textW);
					$("#OPER-CONTAINER-DETAIL").html("");
					$('#OPER-ADD-BTN').prop('disabled', true);

				}
				else {

					if (jFallecidos != "") {
						var textW = "<strong><span style=\"color:red;\">El lote tiene fallecidos</span></strong>";
						$("#txtWarning").html(textW);
						//$("#OPER-CONTAINER-DETAIL").html("");
						//$('#OPER-ADD-BTN').prop('disabled', DSCCR);
						if (estOcup == "DCCCR" || estOcup == "DSCCR") {
							conFallecido = "S";
						}
					}



					var p = obj.CON_ADULTO;
					valor = Number(p);
					var duracion = $('#cboYrs option:selected').val();


					//alert("C: " + valor);
					_html = "<br/><div style='width: 100%;padding: 10px;border: 2px solid gray;margin: 0;'> <table style='width: 100%;padding: 10px'><tr><td>Arrendatario </td><td><table>";
					_html += "<tr>";
					_html += "<td width=50%>" + _TOOLS.getTextBox("aSeccion", "Sección", 8, datajson.data[0].SECCION, "Y", "class='form-control text dbase' readonly") + "</td>";
					_html += "<td width=20%>" + _TOOLS.getTextBox("aSepultura", "Sepultura", 8, datajson.data[0].SEPULTURA, "Y", "class='form-control text dbase' readonly") + "</td>";
					_html += "<td width=20%>" + _TOOLS.getTextBox("aSector", "Sector", 8, datajson.data[0].SECTOR, "Y", "class='form-control text dbase' readonly") + "</td>";
					_html += "<td width=10%>" + _TOOLS.getComboFromList("aTipo", "Tipo ", 8, datajson.data[0].TIPO, "AD,AN,NI,UA,UC,EX,CU", "AD,AN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;,NI,UA,UC,EX,CU", "N", "", "Y", "", "S") + "</td>";

					_html += "</tr>";

					_html += "<tr>";
					_html += "<td colspan=4>" + _TOOLS.getTextBox("aTitular", "Titular", 8, datajson.data[0].TITULAR, "Y", "class='form-control text dbase' onkeydown='_TOOLS.limitText(this,null,50); ' onkeyup='_TOOLS.limitText(this,null,50);'") + "</td>";
					_html += "</tr>";

					_html += "<tr>";
					_html += "<td colspan=4>" + _TOOLS.getTextBox("aTitDireccion", "Dirección", 8, datajson.data[0].DIRECCION, "Y", "class='form-control text dbase' onkeydown='_TOOLS.limitText(this,null,50); ' onkeyup='_TOOLS.limitText(this,null,50);'") + "</td>";
					_html += "</tr>";

					_html += "<tr>";
					_html += "<td width=50%>" + _TOOLS.getTextBox("aTitLocalidad", "Localidad", 8, datajson.data[0].LOCALIDAD, "Y", "class='form-control text dbase' onkeydown='_TOOLS.limitText(this,null,20); ' onkeyup='_TOOLS.limitText(this,null,20);'") + "</td>";
					_html += "<td width=20%>" + _TOOLS.getTextBox("aTitCP", "Código Postal", 8, datajson.data[0].COD_POSTAL, "Y", "class='form-control text dbase' onkeydown='_TOOLS.limitText(this,null,6); ' onkeyup='_TOOLS.limitText(this,null,6);'") + "</td>";
					_html += "<td width=20% colspan=2>" + _TOOLS.getTextBox("aTitTel", "Tel", 8, datajson.data[0].TELEFONO, "Y", "class='form-control text dbase' onkeydown='_TOOLS.limitText(this,null,200); ' onkeyup='_TOOLS.limitText(this,null,200);'") + "</td>";
					_html += "</tr>";

					_html += "<tr>";
					_html += "<td colspan=4>" + _TOOLS.getTextBox("aTitEmail", "Email", 8, datajson.data[0].EMAIL, "Y", "class='form-control text dbase' onkeydown='_TOOLS.limitText(this,null,200); ' onkeyup='_TOOLS.limitText(this,null,200);'") + "</td>";
					_html += "</tr>";

					_html += "<tr>";
					_html += "<td colspan=4>" + _TOOLS.getTextBox("aResponsable", "Responsable", 8, datajson.data[0].RESPONSABL, "Y", "class='form-control text dbase' onkeydown='_TOOLS.limitText(this,null,50); ' onkeyup='_TOOLS.limitText(this,null,50);'") + "</td>";
					_html += "</tr>";

					_html += "<tr>";
					_html += "<td colspan=4>" + _TOOLS.getTextBox("aResDireccion", "Dirección", 8, datajson.data[0].RES_DIRECC, "Y", "class='form-control text dbase' onkeydown='_TOOLS.limitText(this,null,50); ' onkeyup='_TOOLS.limitText(this,null,50);'") + "</td>";
					_html += "</tr>";

					_html += "<tr>";
					_html += "<td width=50%>" + _TOOLS.getTextBox("aResLocalidad", "Localidad", 8, datajson.data[0].RES_LOCALI, "Y", "class='form-control text dbase' onkeydown='_TOOLS.limitText(this,null,20); ' onkeyup='_TOOLS.limitText(this,null,20);'") + "</td>";
					_html += "<td width=20%>" + _TOOLS.getTextBox("aResCP", "Código Postal", 8, datajson.data[0].RES_CODPOS, "Y", "class='form-control text dbase' onkeydown='_TOOLS.limitText(this,null,6); ' onkeyup='_TOOLS.limitText(this,null,6);'") + "</td>";
					_html += "<td width=20% colspan=2>" + _TOOLS.getTextBox("aResTel", "Tel", 8, datajson.data[0].RES_TELEFO, "Y", "class='form-control text dbase' onkeydown='_TOOLS.limitText(this,null,200); ' onkeyup='_TOOLS.limitText(this,null,200);'") + "</td>";
					_html += "</tr>";

					_html += "<tr>";
					_html += "<td colspan=4>" + _TOOLS.getTextBox("aResEmail", "Email", 8, datajson.data[0].RES_EMAIL, "Y", "class='form-control text dbase' onkeydown='_TOOLS.limitText(this,null,200); ' onkeyup='_TOOLS.limitText(this,null,200);'") + "</td>";
					_html += "</tr>";

					var hoy1 = _TOOLS.getTodayDate("amd", "-");
					//alert(hoy1);

					_html += "<tr>";
					_html += "<td width=50% colspan=2>" + _TOOLS.getNumberBox("aNroTitulo", "Nro Titulo", 8, datajson.data[0].NROTITULO, "Y", "class='form-control text dbase' onkeydown='_TOOLS.limitText(this,null,8); ' onkeyup='_TOOLS.limitText(this,null,8);'") + "</td>";
					_html += "<td width=20%>" + _TOOLS.getDateBox("aFechaCompra", "Fecha Compra", 8, hoy1, "Y", "class='form-control text dbase'  ") + "</td>";
					_html += "<td width=20%>" + _TOOLS.getTextBox("aPrecio", "Precio", 8, datajson.data[0].PRECIOCOMPR, "Y", "class='form-control text dbase'") + "</td>";
					_html += "</tr>";
					//alert("d");
					_html += "<tr>";
					_html += "<td width=50% colspan=2>" + _TOOLS.getDateBox("aVencimiento", "Vencimiento", 8, datajson.data[0].VENCIMIENTO, "Y", "class='form-control text dbase'") + "</td>";
					_html += "<td width=20%>" + _TOOLS.getDateBox("aUltRen", "Ultima renovación", 8, hoy1, "Y", "class='form-control text dbase'") + "</td>";
					_html += "<td width=20%>" + _TOOLS.getNumberBox("aAnosArren", "Años Arrendamiento", 8, datajson.data[0].ANOSARREND, "Y", "class='form-control text dbase' ") + "</td>";
					_html += "</tr>";

					_html += "<tr>";
					_html += "<td width=50% colspan=2>" + _TOOLS.getDateBox("aUltBimPago", "Último Bim. Pago", 8, hoy1, "Y", "class='form-control text dbase'") + "</td>";
					_html += "<td width=20% colspan=2>" + _TOOLS.getNumberBox("aDeuda", "Deuda", 8, datajson.data[0].DEUDA, "Y", "class='form-control text dbase'") + "</td>";
					_html += "</tr>";

					
					_html += "<tr>";
					_html += "<td width=50% colspan=2>" + _TOOLS.getRadioYesNoButton("Titulo", "¿Título?", 8, datajson.data[0].TITULO, "S", "N", "Si", "No", "") + "</td>";
					_html += "<td width=50% colspan=2>" + _TOOLS.getRadioYesNoButton("Reglamento", "¿Reglamento?", 8, datajson.data[0].REGLAMENTO, "S", "N", "Si", "No", "") + "</td>";
					_html += "</tr>";


					_html += "</table></td></tr></table></div><script>selectDuracionOnChange();</script>";
					if (conFallecido == "S") {
						_html += "<br/><div style='width: 100%;padding: 10px;border: 2px solid gray;margin: 0;'> ";
						_html += _TOOLS.getRadioYesNoButton("rbarr", "¿Desea arrendarlo? &nbsp;", 8, "N", "S", "N", "Si ", "No ");
						_html += "</div > ";
					}
					//_html += _TOOLS.getTextBox("importe", "Precio Unitario", 3, valor, "Y", "class='form-control text dbase'");
					$("#OPER-CONTAINER-DETAIL").html(_html);
					$('#OPER-ADD-BTN').prop('disabled', false);

					//alert("done");

				}


				//var j = datajson.data[0].TITULAR;
				//alert("Valor: " + j);

				//_TOOLS.loadCombo(datajson, { "target": "#SELECT-LOTE", "selected": -1, "id": "ID", "description": "ComboBusquedaRecibos" });
			});
			break;
		case 4:
			/*validaciones para inhumaciones elegido el lote*/
			var idLote = $('#SELECT-LOTE option:selected').val();
			var responsable = $('#RESPONSABL').val();
			
			var myJSON = '{"ID":"' + idLote + '"}';
			var myObj = JSON.parse(myJSON);
			var valor = 0;

			var jsP = $("#OPER-PRECIOS").val().replace("[", "").replace("]", "");
			var obj = JSON.parse(jsP);

			_AJAX.UiGetLote(myObj).then(function (datajson) {
				var _html = "";

				if (responsable == "") { responsable = datajson.data[0].TITULAR; }

				//alert(sTitDis + " <-> " + sResDis);
				var textW = "";
				$("#txtWarning").html(textW);
				var textW = "";
				var textA = "";
				var sep = "";

				if (!(datajson.data[0].ULT_RENOVA == "" || datajson.data[0].ULT_RENOVA == "null" || datajson.data[0].ULT_RENOVA == null)) {
					//alert("TEST FECHA HORA2: " + datajson.data[0].ULT_RENOVA);
					const fecha = new Date(datajson.data[0].ULT_RENOVA);
					var anos = datajson.data[0].ANOSRENOVA;
					if (anos == "" || anos == null || anos == "null") { anos = 0; }

					fecha.setFullYear(fecha.getFullYear() + anos);
					const nlBEFormatter = new Intl.DateTimeFormat('es-ES');

					const fecha2 = new Date();
					const fechaHoy = new Date();

					fecha2.setFullYear(fecha2.getFullYear() + 5);


					if (fecha2 > fecha) {
						/*vence antes de 5 años*/
						if (fecha < fechaHoy) {
							
							textW = textW + sep + "<strong><span style=\"color:red;\"> ** RENV.VENCIO " + nlBEFormatter.format(fecha) + " **</span></strong>";
							textA = textA + sep + "** RENV.VENCIO " + nlBEFormatter.format(fecha) + " **";
							sep = ", ";
						}
						else {
							
							textW = textW + sep + "<strong><span style=\"color:red;\"> ** RENV.VENCERA " + nlBEFormatter.format(fecha) + " **</span></strong>";
							textA = textA + sep + " ** RENV.VENCERA " + nlBEFormatter.format(fecha) + " **";
							sep = ", ";
						}

					}
				}

				var deuda = Number(datajson.data[0].DEUDA);

				if (deuda > 0) {

					//alert("vacio");
					textW = textW + sep + "<strong><span style=\"color:red;\"> ** ADEUDA " + deuda + " BIM. **</span></strong>";
					textA = textA + sep + "** ADEUDA " + deuda + " BIM. **";
					sep = ", ";
				}

				$("#txtWarning").html(textW);
				$("#OPER-CONTAINER-DETAIL").html("");

				//alert(textA);

				//const today = new Date().toLocaleDateString('en-GB', {
				//	day: 'numeric',
				//	month: 'numeric',
				//	year: 'numeric',
				//});
				//const today = new Date().toLocaleDateString(undefined, {
				//	day: '2-digit',
				//	month: '2-digit',
				//	year: 'numeric',
				//});

				//alert("hoy: "+ today);

				var p = obj.CON_ADULTO;
				valor = Number(p);

				//alert("C: " + valor);
				_html = "<br/><div style='width: 100%;padding: 10px;border: 2px solid gray;margin: 0;'> <table style='width: 100%;padding: 10px'><tr><td>Fallecido </td><td><table>";
				_html += "<tr>";
				_html += "<td width=50%>" + _TOOLS.getTextBox("aSeccion", "Sección", 8, datajson.data[0].SECCION, "Y", "class='form-control text dbase' readonly") + "</td>";
				_html += "<td width=20%>" + _TOOLS.getTextBox("aSepultura", "Sepultura", 8, datajson.data[0].SEPULTURA, "Y", "class='form-control text dbase' readonly") + "</td>";
				_html += "<td width=20%>" + _TOOLS.getTextBox("aSector", "Sector", 8, datajson.data[0].SECTOR, "Y", "class='form-control text dbase' readonly") + "</td>";
				_html += "<td width=10%>" + _TOOLS.getComboFromList("aTipo", "Tipo ", 8, datajson.data[0].TIPO, "AD,AN,NI,UA,UC,EX,CU", "AD,AN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;,NI,UA,UC,EX,CU", "N", "", "Y", "", "N") + "</td>";

				_html += "</tr>";

				_html += "<tr>";
				_html += "<td>" + _TOOLS.getTextBox("aApertura", "Nro Apertura", 8,"", "Y", "class='form-control text dbase'") + "</td>";
				_html += "<td colspan=3>" + _TOOLS.getTextBox("aNombre", "Nombre", 8, "", "Y", "class='form-control text dbase'") + "</td>";
				_html += "</tr>";

				_html += "<tr>";
				_html += "<td width=40%>" + _TOOLS.getTextBox("aEdad", "Edad", 8, "", "Y", "class='form-control text dbase'") + "</td>";
				_html += "<td width=30%>" + _TOOLS.getTextBox("aEstadoCivil", "EstadoCivil", 8, "", "Y", "class='form-control text dbase'") + "</td>";
				_html += "<td width=30%>" + _TOOLS.getTextBox("aNacionalidad", "Nacionalidad", 8, "", "Y", "class='form-control text dbase'") + "</td>";
				_html += "</tr>";

				_html += "<tr>";
				_html += "<td colspan=4>" + _TOOLS.getTextBox("aDni", "DNI", 8, "", "Y", "class='form-control text dbase'") + "</td>";
				_html += "</tr>";

				_html += "<tr>";
				_html += "<td> " + _TOOLS.getTextBox("aCausa", "Causa Deceso", 8, "", "Y", "class='form-control text dbase'") + "</td>";
				_html += "<td colspan=3>" + _TOOLS.getTextBox("aPartida", "Partida Nro", 8, "", "Y", "class='form-control text dbase'") + "</td>";
				_html += "</tr>";

				var hoy1 = _TOOLS.getTodayDate("amd", "-");
				
				_html += "<tr>";
				_html += "<td width=20%>" + _TOOLS.getDateBox("aFecha", "Fecha", 8, hoy1, "Y", "class='form-control text dbase'  ") + "</td>";
				_html += "<td width=20% colspan=3>" + _TOOLS.getTimeBox("aHora", "Hora", 8, "", "Y", "class='form-control text dbase'  ",900) + "</td>";
				_html += "</tr>";

				_html += "<tr>";
				_html += "<td colspan=4>" + _TOOLS.getTextBox("aEmpresaFunebre", "Empresa Fúnebre", 8, datajson.data[0].RES_EMAIL, "Y", "class='form-control text dbase'") + "</td>";
				_html += "</tr>";

				

				_html += "</table></td></tr></table></div>";
				//_html += _TOOLS.getTextBox("importe", "Precio Unitario", 3, valor, "Y", "class='form-control text dbase'");
				$("#OPER-CONTAINER-DETAIL").html(_html);
				$('#OPER-ADD-BTN').prop('disabled', false);
				//alert("done");



				//var j = datajson.data[0].TITULAR;
				//alert("Valor: " + j);

				//_TOOLS.loadCombo(datajson, { "target": "#SELECT-LOTE", "selected": -1, "id": "ID", "description": "ComboBusquedaRecibos" });
			});
			break;
		case 5:
			var optionName1 = $("#SELECT-OPER option:selected").text();
			if (optionName1 == "Traslado Interno") {
				var _html = "";
				_html = "<br/><div style='width: 100%;padding: 10px;border: 2px solid gray;margin: 0;'> <table style='width: 100%;padding: 10px'><tr><td>Lote Destino </td><td><table>";
				_html += "<tr>";
				_html += "<td>" + _TOOLS.getTextBox("aSeccion", "Sección", 8, "", "Y", "class='form-control text dbase'") + "</td>";
				_html += "<td>" + _TOOLS.getTextBox("aSepultura", "Sepultura", 8, "", "Y", "class='form-control text dbase'") + "</td>";
				_html += "<td>" + _TOOLS.getTextBox("aApertura", "Nro Apertura", 8, "", "Y", "class='form-control text dbase'") + "</td>";

				_html += "</tr>";

				_html += "</table></td></tr></table></div>";
				$("#OPER-CONTAINER-DETAIL").html(_html);
				$('#OPER-ADD-BTN').prop('disabled', false);
				//alert("interno");
			}
			else {
				/*validaciones para inhumaciones elegido el lote*/
				var idLote = $('#SELECT-LOTE option:selected').val();
				var responsable = $('#RESPONSABL').val();

				var myJSON = '{"ID":"' + idLote + '"}';
				var myObj = JSON.parse(myJSON);
				var valor = 0;

				var jsP = $("#OPER-PRECIOS").val().replace("[", "").replace("]", "");
				var obj = JSON.parse(jsP);

				_AJAX.UiGetLote(myObj).then(function (datajson) {
					var _html = "";

					if (responsable == "") { responsable = datajson.data[0].TITULAR; }

					//alert(sTitDis + " <-> " + sResDis);
					var textW = "";
					$("#txtWarning").html(textW); 8
					var textW = "";
					var textA = "";
					var sep = "";

					if (!(datajson.data[0].ULT_RENOVA == "" || datajson.data[0].ULT_RENOVA == "null" || datajson.data[0].ULT_RENOVA == null)) {
						//alert("TEST FECHA HORA3: " + datajson.data[0].ULT_RENOVA);
						const fecha = new Date(datajson.data[0].ULT_RENOVA);
						var anos = datajson.data[0].ANOSRENOVA;
						if (anos == "" || anos == null || anos == "null") { anos = 0; }

						fecha.setFullYear(fecha.getFullYear() + anos);
						const nlBEFormatter = new Intl.DateTimeFormat('es-ES');

						const fecha2 = new Date();
						const fechaHoy = new Date();

						fecha2.setFullYear(fecha2.getFullYear() + 5);


						if (fecha2 > fecha) {
							/*vence antes de 5 años*/
							if (fecha < fechaHoy) {

								textW = textW + sep + "<strong><span style=\"color:red;\"> ** RENV.VENCIO " + nlBEFormatter.format(fecha) + " **</span></strong>";
								textA = textA + sep + "** RENV.VENCIO " + nlBEFormatter.format(fecha) + " **";
								sep = ", ";
							}
							else {

								textW = textW + sep + "<strong><span style=\"color:red;\"> ** RENV.VENCERA " + nlBEFormatter.format(fecha) + " **</span></strong>";
								textA = textA + sep + " ** RENV.VENCERA " + nlBEFormatter.format(fecha) + " **";
								sep = ", ";
							}

						}
					}

					var deuda = Number(datajson.data[0].DEUDA);

					if (deuda > 0) {

						//alert("vacio");
						textW = textW + sep + "<strong><span style=\"color:red;\"> ** ADEUDA " + deuda + " BIM. **</span></strong>";
						textA = textA + sep + "** ADEUDA " + deuda + " BIM. **";
						sep = ", ";
					}

					$("#txtWarning").html(textW);
					$("#OPER-CONTAINER-DETAIL").html("");

					//alert(textA);

					//const today = new Date().toLocaleDateString('en-GB', {
					//	day: 'numeric',
					//	month: 'numeric',
					//	year: 'numeric',
					//});
					//const today = new Date().toLocaleDateString(undefined, {
					//	day: '2-digit',
					//	month: '2-digit',
					//	year: 'numeric',
					//});

					//alert("hoy: "+ today);

					var p = obj.CON_ADULTO;
					valor = Number(p);

					//alert("C: " + valor);
					_html = "<br/><div style='width: 100%;padding: 10px;border: 2px solid gray;margin: 0;'> <table style='width: 100%;padding: 10px'><tr><td>Fallecido </td><td><table>";
					_html += "<tr>";
					_html += "<td width=50%>" + _TOOLS.getTextBox("aSeccion", "Sección", 8, datajson.data[0].SECCION, "Y", "class='form-control text dbase' readonly") + "</td>";
					_html += "<td width=20%>" + _TOOLS.getTextBox("aSepultura", "Sepultura", 8, datajson.data[0].SEPULTURA, "Y", "class='form-control text dbase' readonly") + "</td>";
					_html += "<td width=20%>" + _TOOLS.getTextBox("aSector", "Sector", 8, datajson.data[0].SECTOR, "Y", "class='form-control text dbase' readonly") + "</td>";
					_html += "<td width=10%>" + _TOOLS.getComboFromList("aTipo", "Tipo ", 8, datajson.data[0].TIPO, "AD,AN,NI,UA,UC,EX,CU", "AD,AN&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;,NI,UA,UC,EX,CU", "N", "", "Y", "", "N") + "</td>";

					_html += "</tr>";

					_html += "<tr>";
					_html += "<td>" + _TOOLS.getTextBox("aApertura", "Nro Apertura", 8, "", "Y", "class='form-control text dbase'") + "</td>";
					_html += "<td colspan=3>" + _TOOLS.getTextBox("aNombre", "Nombre", 8, "", "Y", "class='form-control text dbase'") + "</td>";
					_html += "</tr>";

					_html += "<tr>";
					_html += "<td width=40%>" + _TOOLS.getTextBox("aEdad", "Edad", 8, "", "Y", "class='form-control text dbase'") + "</td>";
					_html += "<td width=30%>" + _TOOLS.getTextBox("aEstadoCivil", "EstadoCivil", 8, "", "Y", "class='form-control text dbase'") + "</td>";
					_html += "<td width=30%>" + _TOOLS.getTextBox("aNacionalidad", "Nacionalidad", 8, "", "Y", "class='form-control text dbase'") + "</td>";
					_html += "</tr>";


					_html += "<tr>";
					_html += "<td colspan=4>" + _TOOLS.getTextBox("aDni", "DNI", 8, "", "Y", "class='form-control text dbase'") + "</td>";
					_html += "</tr>";

					_html += "<tr>";
					_html += "<td> " + _TOOLS.getTextBox("aCausa", "Causa Deceso", 8, "", "Y", "class='form-control text dbase'") + "</td>";
					_html += "<td colspan=3>" + _TOOLS.getTextBox("aPartida", "Partida Nro", 8, "", "Y", "class='form-control text dbase'") + "</td>";
					_html += "</tr>";

					var hoy1 = _TOOLS.getTodayDate("amd", "-");

					_html += "<tr>";
					_html += "<td width=20%>" + _TOOLS.getDateBox("aFecha", "Fecha", 8, hoy1, "Y", "class='form-control text dbase'  ") + "</td>";
					_html += "<td width=20% colspan=3>" + _TOOLS.getTimeBox("aHora", "Hora", 8, "", "Y", "class='form-control text dbase'  ", 900) + "</td>";
					_html += "</tr>";

					_html += "<tr>";
					_html += "<td colspan=4>" + _TOOLS.getTextBox("aEmpresaFunebre", "Empresa Fúnebre", 8, "", "Y", "class='form-control text dbase'") + "</td>";
					_html += "</tr>";



					_html += "</table></td></tr></table></div>";
					//_html += _TOOLS.getTextBox("importe", "Precio Unitario", 3, valor, "Y", "class='form-control text dbase'");
					$("#OPER-CONTAINER-DETAIL").html(_html);
					$('#OPER-ADD-BTN').prop('disabled', false);
					//alert("done");



					//var j = datajson.data[0].TITULAR;
					//alert("Valor: " + j);

					//_TOOLS.loadCombo(datajson, { "target": "#SELECT-LOTE", "selected": -1, "id": "ID", "description": "ComboBusquedaRecibos" });
				});
				//alert("externo");
			}
			break;
		case 6:
			$('#OPER-ADD-BTN').prop('disabled', false);
			break;
		case 12:
			//$('#OPER-ADD-BTN').prop('disabled', false);
			break;
	}
}

function buscarOnClick() {
	
	var secc = $("#TB-seccion").val();
	var sep = $("#TB-sepultura").val();
	var tit = $("#TB-titular").val();
	var resp = $("#TB-responsable").val();
	var orden = $('#Sort option:selected').val()
	//alert("buscar...." + secc + "<->" + sep + "<->" + tit + "<->" +resp+"<->"+orden);
	//var myJSON = '{"Seccion":"' + secc + '", "Sepultura":"' + sep + '", "Titular":"' + tit + '", "Responsable":"' + resp + '", "Orden":"' + orden +'","function": "ReciptSearchLote", "module": "mod_disidentes", "table": "Sac_facturacion_recibos","model":"Sac_facturacion_recibos","method":"api.backend/neocommand"}';
	var myJSON = '{"Seccion":"' + secc + '", "Sepultura":"' + sep + '", "Titular":"' + tit + '", "Responsable":"' + resp + '", "Orden":"' + orden + '"}';
	var myObj = JSON.parse(myJSON);
	//alert(myObj.Seccion);
	//alert("parsed");

	var _html = "";

	_AJAX.UiReciptSearchLote(myObj).then(function (datajson) {
	
		//_FUNCTIONS._cache.receiptSearch = datajson;
		var _html = "";
		//alert("come back");
		//alert("JSON: " + JSON.stringify(datajson.data));

		_TOOLS.loadCombo(datajson, { "target": "#SELECT-LOTE", "selected": -1, "id": "ID", "description": "ComboBusquedaRecibos" });
	});
}

function buscarOnClickFallecidos() {

	var secc = $("#TB-seccion").val();
	var sep = $("#TB-sepultura").val();
	var nombre = $("#TB-sNombre").val();
	var orden = $('#Sort option:selected').val()
	//alert("buscar...." + secc + "<->" + sep + "<->" + tit + "<->" +resp+"<->"+orden);
	//var myJSON = '{"Seccion":"' + secc + '", "Sepultura":"' + sep + '", "Titular":"' + tit + '", "Responsable":"' + resp + '", "Orden":"' + orden +'","function": "ReciptSearchLote", "module": "mod_disidentes", "table": "Sac_facturacion_recibos","model":"Sac_facturacion_recibos","method":"api.backend/neocommand"}';
	var myJSON = '{"Seccion":"' + secc + '", "Sepultura":"' + sep + '", "Nombre":"' + nombre + '", "Orden":"' + orden + '"}';
	var myObj = JSON.parse(myJSON);
	//alert(myObj.Seccion);
	//alert("parsed");

	var _html = "";

	_AJAX.UiReciptSearchLoteFallecidos(myObj).then(function (datajson) {

		//_FUNCTIONS._cache.receiptSearch = datajson;
		var _html = "";
		//alert("come back");
		//alert("JSON: " + JSON.stringify(datajson.data));

		_TOOLS.loadCombo(datajson, { "target": "#SELECT-LOTE", "selected": -1, "id": "ID", "description": "ComboBusquedaRecibos" });
	});
}

function deleteRow(nombre, importe, fila) {
	//alert(nombre + "<->" + importe + "<->" + fila);
	var rows = Number($("#OPER-COUNTER").val());
	var row = Number(fila);
	//alert("done row rows");
	var total = Number($("#TOTAL-1").val());
	//alert("done tot");
	var descontar = Number($("#" + importe).val());
	var _html = "";
	//alert("antes delete");
	$("#" + nombre).remove();
	if (row < rows) {

		/*si la fila es menor a la cant de filas tengo que renumerar todo, inclusive las anteriores xq reemplazo todo el html*/
		var i = 0;
		var j = 1;/*este es el numerador*/
		//alert("en if row rows");
		for (i = 1; i <= rows; i++) {
			/*la fila a borrar ya la borre por lo que la salteo*/
			//alert("en for");
			if (fila != i) {
				//alert("en fila dis i");
				var con = $("#detail-con-" + i).val();
				//alert("con set");
				var imp = $("#detail-imp-" + i).val();
				//alert("imo set");
				var secc = $("#detail-secc-" + i).val();
				//alert("secc set");
				var sep = $("#detail-sep-" + i).val();
				//alert("sep set");
				var lote = $("#detail-lote-" + i).val();
				//alert("lote set");
				var op = $("#detail-op-" + i).val();
				//alert("vars set");
				_html += "<tr id='detail-form-row-" + j + "'>";
				_html += "   <td><a href='#' onClick=\"javascript:deleteRow('detail-form-row-" + j + "','detail-imp-" + j + "','" + j + "');return false;\">eliminar</a></td>";
				_html += "   <td id='detail-form-row-" + j + "-id'>" + j + "</td>";
				_html += "   <td id='detail-form-row-" + j + "-con'>" + con + "</td>";
				_html += "   <td id='detail-form-row-" + j + "-imp'>" + imp;
				_html += "<input type=text data-type='text' class='form-control text dbase' style='display: none' name='detail-id-" + j + "' id='detail-id-" + j + "' value='" + j + "'></input>";
				_html += "<input type=text data-type='text' class='form-control text dbase' style='display: none' name='detail-con-" + j + "' id='detail-con-" + j + "' value='" + con + "'></input>";
				_html += "<input type=text data-type='text' class='form-control text dbase' style='display: none' name='detail-imp-" + j + "' id='detail-imp-" + j + "' value='" + imp + "'></input>";
				_html += "<input type=text data-type='text' class='form-control text dbase' style='display: none' name='detail-secc-" + j + "' id='detail-secc-" + j + "' value='" + secc + "'></input>";
				_html += "<input type=text data-type='text' class='form-control text dbase' style='display: none' name='detail-sep-" + j + "' id='detail-sep-" + j + "' value='" + sep + "'></input>";
				_html += "<input type=text data-type='text' class='form-control text dbase' style='display: none' name='detail-lote-" + j + "' id='detail-lote-" + j + "' value='" + lote + "'></input>";
				_html += "<input type=text data-type='text' class='form-control text dbase' style='display: none' name='detail-op-" + j + "' id='detail-op-" + j + "' value='" + op + "'></input>";

				var aper = $("#detail-aper-" + i).val();
				_html += "<input type=text data-type='text' class='form-control text dbase' style='display: none' id='detail-aper-" + j + "' name='detail-aper-" + j + "' value='" + aper + "'></input>";
				var ubp = $("#detail-ultbim-" + i).val();
				_html += "<input type=text data-type='text' class='form-control text dbase' style='display: none' id='detail-ultbim-" + j + "' name='detail-ultbim-" + j + "' value='" + ubp + "'></input>";

				var ultbimf = $("#detail-ultbimf-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-ultbimf-" + j + "' name='detail-ultbimf-" + j + "' value='" + ultbimf + "'></input>";

				var vto = $("#detail-vto-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-vto-" + j + "' name='detail-vto-" + j + "' value='" + vto + "'></input>";

				var dni = $("#detail-dni-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-dni-" + j + "' name='detail-dni-" + j + "' value='" + dni + "'></input>";

				var duracion = $("#detail-duracion-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-duracion-" + rows + "' name='detail-duracion-" + rows + "' value='" + duracion + "'></input>";

				var ultren = $("#detail-ultren-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-ultren-" + j + "' name='detail-ultren-" + j + "' value='" + ultren + "'></input>";

				var duracion1 = $("#detail-dur-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-dur-" + j + "' name='detail-dur-" + j + "' value='" + duracion1 + "'></input>";

				var titDireccion = $("#detail-titDireccion-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-titDireccion-" + j + "' name='detail-titDireccion-" + j + "' value='" + titDireccion + "'></input>";
				var titular = $("#detail-titular-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-titular-" + j + "' name='detail-titular-" + j + "' value='" + titular + "'></input>";

				var titLocalidad = $("#detail-titLocalidad-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-titLocalidad-" + j + "' name='detail-titLocalidad-" + j + "' value='" + titLocalidad + "'></input>";

				var titCP = $("#detail-titCP-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-titCP-" + j + "' name='detail-titCP-" + j + "' value='" + titCP + "'></input>";

				var titTel = $("#detail-titTel-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-titTel-" + j + "' name='detail-titTel-" + j + "' value='" + titTel + "'></input>";

				var titMail = $("#detail-titMail-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-titMail-" + j + "' name='detail-titMail-" + j + "' value='" + titMail + "'></input>";

				var responsable = $("#detail-responsable-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-responsable-" + j + "' name='detail-responsable-" + j + "' value='" + responsable + "'></input>";

				var resDireccion = $("#detail-resDireccion-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-resDireccion-" + j + "' name='detail-resDireccion-" + j + "' value='" + resDireccion + "'></input>";

				var resLocalidad = $("#detail-resLocalidad-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-resLocalidad-" + j + "' name='detail-resLocalidad-" + j + "' value='" + resLocalidad + "'></input>";
				var resCP = $("#detail-resCP-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-resCP-" + j + "' name='detail-resCP-" + j + "' value='" + resCP + "'></input>";
				var resTel = $("#detail-resTel-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-resTel-" + j + "' name='detail-resTel-" + j + "' value='" + resTel + "'></input>";
				var resMail = $("#detail-resMail-" + i).val();

				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-resMail-" + j + "' name='detail-resMail-" + j + "' value='" + resMail + "'></input>";
				var nroTitulo = $("#detail-nroTitulo-" + i).val();

				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-nroTitulo-" + j + "' name='detail-nroTitulo-" + j + "' value='" + nroTitulo + "'></input>";
				var precio = $("#detail-precio-" + i).val();

				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-precio-" + j + "' name='detail-precio-" + j + "' value='" + precio + "'></input>";

				var deuda = $("#detail-deuda-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-deuda-" + j + "' name='detail-deuda-" + j + "' value='" + deuda + "'></input>";

				var titulo = $("#detail-titulo-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-titulo-" + j + "' name='detail-titulo-" + j + "' value='" + titulo + "'></input>";

				var reglamento = $("#detail-reglamento-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-reglamento-" + j + "' name='detail-reglamento-" + j + "' value='" + reglamento + "'></input>";

				var tipo = $("#detail-tipo-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-tipo-" + j + "' name='detail-tipo-" + j + "' value='" + tipo + "'></input>";

				var nom = $("#detail-nom-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-aper-" + j + "' name='detail-nom-" + j + "' value='" + nom + "'></input>";

				var edad = $("#detail-edad-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-aper-" + j + "' name='detail-edad-" + j + "' value='" + edad + "'></input>";

				var estadoCivil = $("#detail-ec-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-aper-" + j + "' name='detail-ec-" + j + "' value='" + estadoCivil + "'></input>";

				var nacionalidad = $("#detail-nac-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-aper-" + j + "' name='detail-nac-" + j + "' value='" + nacionalidad + "'></input>";

				var causa = $("#detail-causa-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-aper-" + j + "' name='detail-causa-"+ j + "' value='" + causa + "'></input>";

				var partida = $("#detail-partida-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-aper-" + j + "' name='detail-partida-" + j + "' value='" + partida + "'></input>";

				var fecd = $("#detail-fecd-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-aper-" + j + "' name='detail-fecd-" + j + "' value='" + fecd + "'></input>";

				var hora = $("#detail-hora-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-aper-" + j + "' name='detail-hora-" + j + "' value='" + hora + "'></input>";

				var empresa = $("#detail-empresa-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-aper-" + j + "' name='detail-empresa-" + j + "' value='" + empresa + "'></input>";

				var seccion2 = $("#detail-secc2-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-secc2-" + j + "' name='detail-secc2-" + j + "' value='" + seccion2 + "'></input>";

				var sepultura2 = $("#detail-sep2-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-sep2-" + j + "' name='detail-sep2-" + j + "' value='" + sepultura2 + "'></input>";

				var venc2 = $("#detail-vencimiento-" + i).val();
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-vencimiento-" + j + "' name='detail-vencimiento-" + j + "' value='" + venc2 + "'></input>";

				_html += "</td>";
				_html += "</tr>";
				$("#detail-form-row-"+i).remove();
				j = j + 1;
			}
		}
		/*ahora reemplazo los datos de la tabla*/
		//alert(_html);
		$("#table-detail").append(_html);
	}
	rows = rows - 1;
	//alert(rows);
	$("#OPER-COUNTER").val(rows);
	$("#TOTAL-1").val(total - descontar);
	$("#PESOS").val(total - descontar);
	//actualizar total
	//actualizar contador de filas
	
}

function insertPagoACuentaYAlertas(idlote, oper) {

	//alert("Alertas " + idlote + " oper " + oper);

	var total = Number($("#TOTAL-1").val());
	var rows = Number($("#OPER-COUNTER").val());
	rows = rows + 1;

	//alert("rows");

	var myJSON = '{"ID":"' + idlote + '"}';
	var myObj = JSON.parse(myJSON);

	//alert("json");

	_AJAX.UiGetLote(myObj).then(function (datajson) {
		var _html = "";
		//alert("inside json")	
		var recibo = datajson.data[0].ACUENTA;

		//alert("acuenta: " + recibo);

		if (recibo>0)
		{

			//alert("en if>0");
			//alert("acuenta2: " + datajson.acuenta[0].qryTot);

			var fecha = datajson.acuenta[0].qryFec;
			var importe = datajson.acuenta[0].qryTot;
			var secc = datajson.data[0].SECCION;
			var sep = datajson.data[0].SEPULTURA;

			//alert("antyes cuentas");

			total = total + importe;

			var con = "Habia un pago a cuenta: Recibo " + recibo + " de fecha " + fecha;

			//alert("con set: "+con);

			_html = "";
			_html += "<tr id='detail-form-row-" + rows + "'>";
			_html += "   <td><a href='#' onClick=\"javascript:deleteRow('detail-form-row-" + rows + "','detail-imp-" + rows + "','" + rows + "');return false;\">eliminar</a></td>";
			_html += "   <td id='detail-form-row-" + rows + "-id'>" + rows + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-con'>" + con + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-imp'>" + importe;
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-id-" + rows + "' name='detail-id-" + rows + "' value='" + rows + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-con-" + rows + "' name='detail-con-" + rows + "' value='" + con + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-imp-" + rows + "' name='detail-imp-" + rows + "' value='" + importe + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-secc-" + rows + "' name='detail-secc-" + rows + "' value='"+secc+"'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-sep-" + rows + "' name='detail-sep-" + rows + "' value='"+sep+"'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-lote-" + rows + "' name='detail-lote-" + rows + "' value='"+idlote+"'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-op-" + rows + "' name='detail-op-" + rows + "' value='PC'></input>";

			_html += "</td>";
			_html += "</tr>";
			//alert(_html);

			$("#OPER-COUNTER").val(rows);
			$("#TOTAL-1").val(total);
			$("#PESOS").val(total);
			$("#table-detail").append(_html);

		}

		//alert("qafter if acuenta " + datajson.data[0].TITULO + "-" + datajson.data[0].REGLAMENTO );

		if (datajson.data[0].TITULO == "S") {
			alert('Hay un título para entregar');
		}

		if (datajson.data[0].REGLAMENTO == "S") {
			alert('Entregar Reglamento Interno');
		}
	});

}


function insertarOnClick() {
	
	var rows = Number($("#OPER-COUNTER").val());
	//alert("rows: "+rows);
	rows = rows + 1;
	var _html = "";
	var idOption = Number($("#SELECT-OPER option:selected").val());
	var idLote = 0;
	//alert("insertar");
	switch (idOption) {
		case 0:
			alert("Debe Seleccionar una opción...");
			break;
		case 1:
			//alert("Conservacion");


			var jsP = $("#OPER-PRECIOS").val().replace("[", "").replace("]", "");
			var obj = JSON.parse(jsP);

			//alert(obj.PLACAS_CENICEROS);

			var valor = 0;
			var lote = $("#SELECT-LOTE option:selected").val();
			var nameOption = $("#SELECT-LOTE option:selected").text();
			var cadena = nameOption.split("|");

			var seccion = cadena[0].replace(/_/g, "");
			var sepultura = cadena[1].replace(/_/g, "");
			var nombre = cadena[3].replace(/_/g, "");
			var tipo = cadena[2].replace(/ /g, "");

			$('#RESPONSABL').val(nombre);

			var importe = 0;
			var bim = 0;

			try {
				importe = $("#TB-importe").val();
				//alert(apertura);
				if (importe == "") { alert("Debe ingresar un número en importe mayor o igual a cero"); return; }
				importe = Number(importe);

				if (isNaN(importe)) { alert("Debe ingresar un número en importe mayor o igual a cero"); return; }

				if (importe < 0) { alert("El número en importe tiene que ser mayor o igual a cero"); return; }
			} catch (err) {
				alert("Error al buscar número en importe");
				return;
			}

			try {
				bim = $("#TB-Bimestres").val();
				//alert(apertura);
				if (bim == "") { alert("Debe ingresar un número en cantidad mayor o igual a cero"); return; }
				bim = Number(bim);

				if (isNaN(bim)) { alert("Debe ingresar un número en cantidad mayor o igual a cero"); return; }

				if (bim < 0) { alert("El número en cantidad tiene que ser mayor o igual a cero"); return; }
			} catch (err) {
				alert("Error al buscar número en cantidad");
				return;
			}

			var tot = bim * importe;

			//alert("valor: ->" + tot + "<-");

			var ultbim = $("#TB-UltBimPago").val();
			//alert(" ult bom ->" + ultbim);

			//alert("TEST FECHA HORA4: " + ultbim);
			const fecha = new Date(ultbim);
			//alert("fecha");
			fecha.setDate(fecha.getDate() + 1);

			//alert("fecha1");
			const fecha2 = new Date(ultbim);
			//alert("fecha2");
			fecha2.setDate(fecha2.getDate() + 1);
			//alert("fecha21");
			fecha2.setMonth(fecha2.getMonth() + (bim * 2));
			///alert("fecha222");
			fecha2.setDate(fecha2.getDate() - 1);
			///alert("fecha23");

			const nlBEFormatter = new Intl.DateTimeFormat('es-ES');


			var con = "";
			con = "Conservación Sección " + seccion + "  " + "Sepultura Nº " + sepultura + "     " + nombre + "\n" + "Del " + nlBEFormatter.format(fecha) + " " + "al " + nlBEFormatter.format(fecha2);

			//alert(con);

			//alert("insertar: " + importe);
			var total = Number($("#TOTAL-1").val());
			//alert("insertar: " + total);

			var valor = Number(tot);
			//alert("insertar: " + importe);
			total = total + valor;
			//alert("insertar sumado: " + total);

			var ubp = _TOOLS.getFormattedDate(fecha2, 'amd', '-');

			//alert(ubp);

			_html = "";
			_html += "<tr id='detail-form-row-" + rows + "'>";
			_html += "   <td><a href='#' onClick=\"javascript:deleteRow('detail-form-row-" + rows + "','detail-imp-" + rows + "','" + rows + "');return false;\">eliminar</a></td>";
			_html += "   <td id='detail-form-row-" + rows + "-id'>" + rows + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-con'>" + con + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-imp'>" + valor;
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-id-" + rows + "' name='detail-id-" + rows + "' value='" + rows + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-con-" + rows + "' name='detail-con-" + rows + "' value='" + con + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-imp-" + rows + "' name='detail-imp-" + rows + "' value='" + valor + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-secc-" + rows + "' name='detail-secc-" + rows + "' value='" + seccion + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-sep-" + rows + "' name='detail-sep-" + rows + "' value='" + sepultura + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-lote-" + rows + "' name='detail-lote-" + rows + "' value='" + lote + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-aper-" + rows + "' name='detail-aper-" + rows + "' value='" + apertura + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-ultbim-" + rows + "' name='detail-ultbim-" + rows + "' value='" + ubp + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-ultbimf-" + rows + "' name='detail-ultbimf-" + rows + "' value='" + nlBEFormatter.format(fecha2) + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-op-" + rows + "' name='detail-op-" + rows + "' value='CO'></input>";

			_html += "</td>";
			_html += "</tr>";
			//alert(_html);

			$("#OPER-COUNTER").val(rows);
			$("#TOTAL-1").val(total);
			$("#PESOS").val(total);
			$("#table-detail").append(_html);

			insertPagoACuentaYAlertas(lote, idOption);

			break;
		case 2:
			//alert("Renovación");


			var jsP = $("#OPER-PRECIOS").val().replace("[", "").replace("]", "");
			var obj = JSON.parse(jsP);

			//alert(obj.PLACAS_CENICEROS);

			var valor = 0;
			var lote = $("#SELECT-LOTE option:selected").val();
			var nameOption = $("#SELECT-LOTE option:selected").text();
			var cadena = nameOption.split("|");

			var seccion = cadena[0].replace(/_/g, "");
			var sepultura = cadena[1].replace(/_/g, "");
			var nombre = cadena[3].replace(/_/g, "");
			var tipo = cadena[2].replace(/ /g, "");

			var importe = 0;

			var duracion = Number($('#cboYrs option:selected').val());
			var tot = 0;

			var sector = "";

			$('#RESPONSABL').val(nombre);

			var myJSON = '{"ID":"' + lote + '"}';
			var myObj = JSON.parse(myJSON);
			var valor = 0;
			var titular = "";
			var nrotitulo = "";
			var ultrenova = "";
			var anos = 0;
			var ultrenovastr = "";
			var ultrenf;
			var vto;
			

			const nlBEFormatter1 = new Intl.DateTimeFormat('es-ES');

			_AJAX.UiGetLote(myObj).then(function (datajson) {
				var _html = "";

				titular = datajson.data[0].TITULAR;
				nrotitulo = datajson.data[0].NROTITULO;
				ultrenova = datajson.data[0].ULT_RENOVA;
				anos = datajson.data[0].ANOSRENOVA;
				sector = datajson.data[0].SECTOR;

				//alert("a");

				if (!(datajson.data[0].ANOSRENOVA == "" || datajson.data[0].ANOSRENOVA == "null" || datajson.data[0].ANOSRENOVA == null)) {
					anosrenova = 0;
				}
				//alert("b");
				if (nrotitulo == "0") { nrotitulo = ""; }

				//alert("c " + datajson.data[0].ULT_RENOVA);

				if (!(datajson.data[0].ULT_RENOVA == "" || datajson.data[0].ULT_RENOVA == "null" || datajson.data[0].ULT_RENOVA == null)) {
					//alert("d2");
					//alert("TEST FECHA HORA5: " + datajson.data[0].ULT_RENOVA);
					const fecha = new Date(datajson.data[0].ULT_RENOVA);
					anos = datajson.data[0].ANOSRENOVA;
					if (anos == "" || anos == null || anos == "null") { anos = 0; }

					fecha.setFullYear(fecha.getFullYear() + anos);
					ultrenf = _TOOLS.getFormattedDate(fecha, "amd", "-");

					//alert("f1: " + ultrenf);

					fecha.setFullYear(fecha.getFullYear() + duracion);
					vto = _TOOLS.getFormattedDate(fecha, "amd", "-");

					//alert("f2: " + vto);
					
					ultrenovastr = nlBEFormatter1.format(fecha);

					//alert("ultren: " + ultrenovastr)

					//string.Format("{0:d}", DateTime.Parse(sdrLot["ULT_RENOVA"].ToString()).AddYears(int.Parse(sdrLot["qryUltYrs"].ToString())).AddYears(int.Parse(cboYrs.SelectedValue))));
				} else {

					ultrenovastr = "__/__/____";
					//alert("d1");
				}

				//alert("e->"+duracion+"<-");
				//alert("e->" + tipo + "<-");
				//alert("e->" + sector + "<-");

				switch (duracion) {
					case 1:
					case 2:
					case 3:
					case 4:
					case 5:
						switch (tipo) {
							case "AN":
								tot = obj["REN_ND_5"] / 5 * duracion;
								break;
							case "AD":
								tot = obj["REN_DI_5"] / 5 * duracion;
								break;
							case "NI":
								tot = obj["REN_NI_5"] / 5 * duracion;
								break;
							case "UA":
							case "CU":
							case "UC":
							case "UR":
								tot = obj["REN_UR_5"] / 5 * duracion;
								break;
						}
						break;
					case 10:
						switch (tipo) {
							case "AN":
								tot = obj["REN_ND_10"];
								break;
							case "AD":
								tot = obj["REN_DI_10"];
								//alert(tot);
								break;
							case "NI":
								tot = obj["REN_NI_10"];
								break;
							case "UA":
							case "CU":
							case "UC":
							case "UR":
								tot = obj["REN_UR_10"];
								break;
						}
						break;
					case 50:
						if (tipo == "AD") {
							tot = obj["REN" + sector + "DI50"];
						}
						else {
							tot = obj["REN" + sector + "ND50"];
						}
						break;
					case 99:
						if (tipo == "AD") {
							tot = obj["REN" + sector + "DI99"];
						}
						else {
							tot = obj["REN" + sector + "ND99"];
						}
						break;
					default:
						break;
				}



				//alert("valor: ->" + tot + "<-");

				var con = "";

				con = "Renovación de usufructo por " + duracion + " años - Sección " + seccion + " Sepultura Nº " + sepultura + "\n" +
					"Tit. " + titular + " " +
					"Nro.tit: " + nrotitulo + " " +
					"VTO: " + ultrenovastr;

				//con = "Conservación Sección " + seccion + "  " + "Sepultura Nº " + sepultura + "     " + nombre + "\n" + "Del " + nlBEFormatter.format(fecha) + " " + "al " + nlBEFormatter.format(fecha2);

				//alert(con);

				//alert("insertar: " + importe);
				var total = Number($("#TOTAL-1").val());
				//alert("insertar: " + total);

				var valor = Number(tot);
				//alert("insertar: " + importe);
				total = total + valor;
				//alert("insertar sumado: " + total);



				_html = "";
				_html += "<tr id='detail-form-row-" + rows + "'>";
				_html += "   <td><a href='#' onClick=\"javascript:deleteRow('detail-form-row-" + rows + "','detail-imp-" + rows + "','" + rows + "');return false;\">eliminar</a></td>";
				_html += "   <td id='detail-form-row-" + rows + "-id'>" + rows + "</td>";
				_html += "   <td id='detail-form-row-" + rows + "-con'>" + con + "</td>";
				_html += "   <td id='detail-form-row-" + rows + "-imp'>" + valor;
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-id-" + rows + "' name='detail-id-" + rows + "' value='" + rows + "'></input>";
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-con-" + rows + "' name='detail-con-" + rows + "' value='" + con + "'></input>";
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-imp-" + rows + "' name='detail-imp-" + rows + "' value='" + valor + "'></input>";
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-secc-" + rows + "' name='detail-secc-" + rows + "' value='" + seccion + "'></input>";
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-sep-" + rows + "' name='detail-sep-" + rows + "' value='" + sepultura + "'></input>";
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-lote-" + rows + "' name='detail-lote-" + rows + "' value='" + lote + "'></input>";
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-vto-" + rows + "' name='detail-vto-" + rows + "' value='" + vto + "'></input>";
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-duracion-" + rows + "' name='detail-duracion-" + rows + "' value='" + duracion + "'></input>";
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-ultren-" + rows + "' name='detail-ultren-" + rows + "' value='" + ultrenf  + "'></input>";
				_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-op-" + rows + "' name='detail-op-" + rows + "' value='RN'></input>";

				_html += "</td>";
				_html += "</tr>";
				//alert(_html);

				$("#OPER-COUNTER").val(rows);
				$("#TOTAL-1").val(total);
				$("#PESOS").val(total);
				$("#table-detail").append(_html);

				insertPagoACuentaYAlertas(lote, idOption);
			});



			break;
		case 3:
			//alert("Arrendamiento");

			var jsP = $("#OPER-PRECIOS").val().replace("[", "").replace("]", "");
			var obj = JSON.parse(jsP);

			//alert(obj.PLACAS_CENICEROS);

			var rblArr = $("input:radio[name=rbarr]:checked").val();

			if (typeof rblArr === "undefined") {
				rblArr = "S";
			}

			if (rblArr == "N") {
				alert("El lote tiene fallecidos y no se confirmó el arrendamiento.");
				return;
			}
			
			const nlBEFormatter3 = new Intl.DateTimeFormat('es-ES');

			var valor = 0;
			var lote = $("#SELECT-LOTE option:selected").val();
			var nameOption = $("#SELECT-LOTE option:selected").text();
			var cadena = nameOption.split("|");

			var seccion = cadena[0].replace(/_/g, "");
			var sepultura = cadena[1].replace(/_/g, "");
			var nombre = cadena[3].replace(/_/g, "");
			var tipo = cadena[2].replace(/ /g, "");
			var apertura = "";
			var sector = $("#TB-aSector").val();

			var duracion = $('#cboYrs option:selected').val();
			var campo = "";

			campo = campoPrecio(tipo, sector, duracion);

			valor = obj[campo];


			nombre = $("#TB-aTitular").val();
			var nroTitulo = $("#TB-aNroTitulo").val();

			if (nroTitulo == "0") { nroTitulo = "";}


			titDireccion = $("#TB-aTitDireccion").val();
			titLocalidad = $("#TB-aTitLocalidad").val();
			titCP = $("#TB-aTitCP").val();
			titTel = $("#TB-aTitTel").val();
			titMail = $("#TB-aTitEmail").val();
			responsable = $("#TB-aResponsable").val();
			resDireccion = $("#TB-aResDireccion").val();
			resLocalidad = $("#TB-aResLocalidad").val();
			resCP = $("#TB-aResCP").val();
			resTel = $("#TB-aResTel").val();
			resMail = $("#TB-aResEmail").val();

			vencimiento = $("#TB-aVencimiento").val();

			ultbim = $("#TB-aUltBimPago").val();
			deuda = $("#TB-aDeuda").val();
			var titulo = $("input:radio[name=Titulo]:checked").val();
			var reglamento = $("input:radio[name=Reglamento]:checked").val();

			//alert("Tit " + titulo);
			//alert("reg " + reglamento);

			//alert(seccion);
			//alert(sepultura);
			//alert(nombre);
			//alert(nroTitulo);

			const fechaHoy = new Date();
			fechaHoy.setFullYear(fechaHoy.getFullYear() + Number(duracion));

			//alert(nlBEFormatter3.format(fechaHoy));
			

			//alert("c0 " + seccion + " sep " + sepultura + " nombre " + nombre + " nro tit " + nroTitulo + " vto " );

			

			var con = "Derecho de uso por " + duracion + " años - " + "Sección " + seccion + " " + "Sepultura Nº " + sepultura + "\n" +
				"Tit. " + nombre + " " + "Nro.tit: " + nroTitulo + " " + "VTO: " + nlBEFormatter3.format(fechaHoy);

			//alert("c01");
			//alert("valor: ->" + cadena[0].replace(/_/g,"") + "<-");

			//alert(con);

			//alert("insertar: " + importe);
			var total = Number($("#TOTAL-1").val());
			//alert("insertar: " + total);
			//alert("c00");
			var importe = Number(valor);
			//alert("insertar: " + importe);
			total = total + importe;
			//alert("insertar sumado: " + total);

			//alert("c000");



			_html = "";
			_html += "<tr id='detail-form-row-" + rows + "'>";
			_html += "   <td><a href='#' onClick=\"javascript:deleteRow('detail-form-row-" + rows + "','detail-imp-" + rows + "','" + rows + "');return false;\">eliminar</a></td>";
			_html += "   <td id='detail-form-row-" + rows + "-id'>" + rows + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-con'>" + con + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-imp'>" + valor;
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-id-" + rows + "' name='detail-id-" + rows + "' value='" + rows + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-con-" + rows + "' name='detail-con-" + rows + "' value='" + con + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-imp-" + rows + "' name='detail-imp-" + rows + "' value='" + valor + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-secc-" + rows + "' name='detail-secc-" + rows + "' value='" + seccion + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-sep-" + rows + "' name='detail-sep-" + rows + "' value='" + sepultura + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-lote-" + rows + "' name='detail-lote-" + rows + "' value='" + lote + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-dur-" + rows + "' name='detail-dur-" + rows + "' value='" + duracion + "'></input>";
			//alert("c1");
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-titDireccion-" + rows + "' name='detail-titDireccion-" + rows + "' value='" + titDireccion + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-titular-" + rows + "' name='detail-titular-" + rows + "' value='" + nombre + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-titLocalidad-" + rows + "' name='detail-titLocalidad-" + rows + "' value='" + titLocalidad + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-titCP-" + rows + "' name='detail-titCP-" + rows + "' value='" + titCP + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-titTel-" + rows + "' name='detail-titTel-" + rows + "' value='" + titTel + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-titMail-" + rows + "' name='detail-titMail-" + rows + "' value='" + titMail + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-responsable-" + rows + "' name='detail-responsable-" + rows + "' value='" + responsable + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-resDireccion-" + rows + "' name='detail-resDireccion-" + rows + "' value='" + resDireccion + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-resLocalidad-" + rows + "' name='detail-resLocalidad-" + rows + "' value='" + resLocalidad + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-resCP-" + rows + "' name='detail-resCP-" + rows + "' value='" + resCP + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-resTel-" + rows + "' name='detail-resTel-" + rows + "' value='" + resTel + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-resMail-" + rows + "' name='detail-resMail-" + rows + "' value='" + resMail + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-nroTitulo-" + rows + "' name='detail-nroTitulo-" + rows + "' value='" + nroTitulo + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-precio-" + rows + "' name='detail-precio-" + rows + "' value='" + importe + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-ultbim-" + rows + "' name='detail-ultbim-" + rows + "' value='" + ultbim + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-deuda-" + rows + "' name='detail-deuda-" + rows + "' value='" + deuda + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-titulo-" + rows + "' name='detail-titulo-" + rows + "' value='" + titulo + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-vencimiento-" + rows + "' name='detail-vencimiento-" + rows + "' value='" + vencimiento + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-reglamento-" + rows + "' name='detail-reglamento-" + rows + "' value='" + reglamento + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-tipo-" + rows + "' name='detail-tipo-" + rows + "' value='" + tipo + "'></input>";
			//alert("c2");

			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-op-" + rows + "' name='detail-op-" + rows + "' value='AL'></input>";

			_html += "</td>";
			_html += "</tr>";
			//alert(_html);

			$('#RESPONSABL').val(nombre);

			$("#OPER-COUNTER").val(rows);
			$("#TOTAL-1").val(total);
			$("#PESOS").val(total);
			$("#table-detail").append(_html);

			insertPagoACuentaYAlertas(lote, idOption);

			break;
		case 4:
			//alert("Inhumaciones");

			var jsP = $("#OPER-PRECIOS").val().replace("[", "").replace("]", "");
			var obj = JSON.parse(jsP);

			//alert(obj.PLACAS_CENICEROS);

			var valor = 0;
			var lote = $("#SELECT-LOTE option:selected").val();
			var nameOption = $("#SELECT-LOTE option:selected").text();
			var cadena = nameOption.split("|");

			var seccion = cadena[0].replace(/_/g, "");
			var sepultura = cadena[1].replace(/_/g, "");
			var nombre = cadena[3].replace(/_/g, "");
			var tipo = cadena[2].replace(/ /g, "");
			var apertura = "";

			switch (tipo) {
				case "AD":
				case "AN":
					valor = obj.INH_ADULTO;
					break;
				case "NI":
					valor = obj.INH_NINOS;
					break;
				case "UA":
				case "UC":
				case "UR":
				case "CU":
					// Urnas Arrendadas
					valor = obj.INH_URNAS;
					break;
			}


			nombre = $("#TB-aNombre").val();

			try {
				apertura = $("#TB-aApertura").val();
				//alert(apertura);
				if (apertura == "") { alert("Debe ingresar un número de apertura mayor o igual a cero"); return; }
				apertura = Number(apertura);

				if (isNaN(apertura)) { alert("Debe ingresar un número de apertura mayor o igual a cero"); return; }

				if (apertura < 0) { alert("El número de apertura tiene que ser mayor o igual a cero"); return; }
			} catch (err) {
				alert("Error al buscar número de apertura");
				return;
			}

			if (tipo == "UA" || tipo == "UR" || tipo == "UC") {
				con = "Inhumación " + "Sección " + seccion + " " + "Sepultura Nº " + sepultura + " \n" + "Apertura " + apertura + " " + "URNA" + " " + nombre;
			} else {
				con = "Inhumación " + "Sección " + seccion + " " + "Sepultura Nº " + sepultura + " \n" + "Apertura " + apertura + " " + " " + nombre;
			}

			//alert("valor: ->" + cadena[0].replace(/_/g,"") + "<-");
			$('#RESPONSABL').val(nombre);
			//alert(con);

			//alert("insertar: " + importe);
			var total = Number($("#TOTAL-1").val());
			//alert("insertar: " + total);

			var importe = Number(valor);
			//alert("insertar: " + importe);
			total = total + importe;
			//alert("insertar sumado: " + total);

			var edad = $("#TB-aEdad").val();
			var estadoCivil = $("#TB-aEstadoCivil").val();
			var nacionalidad = $("#TB-aNacionalidad").val();
			var causa = $("#TB-aCausa").val();
			var partida = $("#TB-aPartida").val();
			var fecd = $("#TB-aFecha").val();
			var hora = $("#TB-aHora").val();
			var dni = $("#TB-aDni").val();
			//alert("hora: " + hora);
			var empresa = $("#TB-aEmpresaFunebre").val();

			_html = "";
			_html += "<tr id='detail-form-row-" + rows + "'>";
			_html += "   <td><a href='#' onClick=\"javascript:deleteRow('detail-form-row-" + rows + "','detail-imp-" + rows + "','" + rows + "');return false;\">eliminar</a></td>";
			_html += "   <td id='detail-form-row-" + rows + "-id'>" + rows + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-con'>" + con + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-imp'>" + valor;
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-id-" + rows + "' name='detail-id-" + rows + "' value='" + rows + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-con-" + rows + "' name='detail-con-" + rows + "' value='" + con + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-imp-" + rows + "'  name='detail-imp-" + rows + "' value='" + valor + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-secc-" + rows + "' name='detail-secc-" + rows + "' value='" + seccion + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-sep-" + rows + "' name='detail-sep-" + rows + "' value='" + sepultura + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-lote-" + rows + "' name='detail-lote-" + rows + "' value='" + lote + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-aper-" + rows + "' name='detail-aper-" + rows + "' value='" + apertura + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-tipo-" + rows + "' name='detail-tipo-" + rows + "' value='" + tipo + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-nom-" + rows + "' name='detail-nom-" + rows + "' value='" + nombre + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-edad-" + rows + "' name='detail-edad-" + rows + "' value='" + edad + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-ec-" + rows + "' name='detail-ec-" + rows + "' value='" + estadoCivil + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-nac-" + rows + "' name='detail-nac-" + rows + "' value='" + nacionalidad + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-causa-" + rows + "' name='detail-causa-" + rows + "' value='" + causa + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-partida-" + rows + "' name='detail-partida-" + rows + "' value='" + partida + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-fecd-" + rows + "' name='detail-fecd-" + rows + "' value='" + fecd + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-hora-" + rows + "' name='detail-hora-" + rows + "' value='" + hora + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-empresa-" + rows + "' name='detail-empresa-" + rows + "' value='" + empresa + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-dni-" + rows + "' name='detail-dni-" + rows + "' value='" + dni + "'></input>";


			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-op-" + rows + "' name='detail-op-" + rows + "' value='IN'></input>";

			_html += "</td>";
			_html += "</tr>";
			//alert(_html);

			$("#OPER-COUNTER").val(rows);
			$("#TOTAL-1").val(total);
			$("#PESOS").val(total);
			$("#table-detail").append(_html);
			insertPagoACuentaYAlertas(lote, idOption);
			break;
		case 5:
			//alert("Translados");

			var jsP = $("#OPER-PRECIOS").val().replace("[", "").replace("]", "");
			var obj = JSON.parse(jsP);


			var valor = obj.TRANSLADOS;
			var lote = $("#SELECT-LOTE option:selected").val();

			var idlote = lote;

			var nameOption = $("#SELECT-LOTE option:selected").text();
			var cadena = nameOption.split("|");

			var seccion = cadena[0].replace(/_/g, "");
			var sepultura = cadena[1].replace(/_/g, "");
			var nombre = cadena[3].replace(/_/g, "");
			var tipo = cadena[2].replace(/ /g, "");
			var apertura;
			var con = "";
			var seccion2 = "";
			var sepultura = "";
			var OP = "";

			var edad = "";
			var estadoCivil = "";
			var nacionalidad = "";
			var causa = "";
			var partida = "";
			var fecd = "";
			var hora = "";
			var dni = "";
			//alert("hora: " + hora);
			var empresa = "";

			var optionName1 = $("#SELECT-OPER option:selected").text();
			if (optionName1 == "Traslado Interno") {
				try {
					seccion2 = $("#TB-aSeccion").val();
					sepultura2 = $("#TB-aSepultura").val();
					if (seccion2 == "" || sepultura2 == "") { alert("Sección y/o sepultura no pueden estar vacíos"); return;}
				} catch (err) {
					alert("Error al buscar valores de sección y sepultura");
					return;
				}
				try {
					apertura = $("#TB-aApertura").val();
					//alert(apertura);
					if (apertura == "") { alert("Debe ingresar un número de apertura mayor o igual a cero"); return;}
					apertura = Number(apertura);
					 
					if (isNaN(apertura)) { alert("Debe ingresar un número de apertura mayor o igual a cero"); return; }

					if (apertura < 0) { alert("El número de apertura tiene que ser mayor o igual a cero"); return;}
				} catch (err) {
					alert("Error al buscar número de apertura");
					return;
				}
				con = "Translado Interno  de Sección " + seccion + " Sepultura Nº " + sepultura + "\n" + " a Sección " + seccion2 + " Sepultura " + sepultura2 + ".";
				OP = "TI";

				//alert("nates id lote");
				var idlote = cadena[5].replace(/_/g, "");
				//alert("after idlote");
			}
			else {

				//alert("ext");
				apertura = $("#TB-aApertura").val();
				nombre = $("#TB-aNombre").val();
				if (tipo == "UA" || tipo == "UR" || tipo == "UC") {
					con = "Translado Externo  de " + "Sección " + seccion + " " + "Sepultura Nº " + sepultura + " \n" + "Apertura " + apertura + " " + "URNA" + " " +nombre ;
				} else {
					con = "Translado Externo  de " + "Sección " + seccion + " " + "Sepultura Nº " + sepultura + " \n" + "Apertura " + apertura + " " + " " + nombre;
				}

				OP = "TE";

				edad = $("#TB-aEdad").val();
				estadoCivil = $("#TB-aEstadoCivil").val();
				nacionalidad = $("#TB-aNacionalidad").val();
				causa = $("#TB-aCausa").val();
				partida = $("#TB-aPartida").val();
				fecd = $("#TB-aFecha").val();
				hora = $("#TB-aHora").val();
				dni = $("#TB-aDni").val();
				//alert("hora ex:t " + hora);
				empresa = $("#TB-aEmpresaFunebre").val();
			}

		
			//alert(con);

			//alert("insertar: " + importe);
			var total = Number($("#TOTAL-1").val());
			//alert("insertar: " + total);

			var importe = Number(valor);
			//alert("insertar: " + importe);
			total = total + importe;
			//alert("insertar sumado: " + total);

			_html = "";
			_html += "<tr id='detail-form-row-" + rows + "'>";
			_html += "   <td><a href='#' onClick=\"javascript:deleteRow('detail-form-row-" + rows + "','detail-imp-" + rows + "','" + rows + "');return false;\">eliminar</a></td>";
			_html += "   <td id='detail-form-row-" + rows + "-id'>" + rows + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-con'>" + con + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-imp'>" + valor;
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-id-" + rows + "' name='detail-id-" + rows + "' value='" + rows + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-con-" + rows + "' name='detail-con-" + rows + "' value='" + con + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-imp-" + rows + "' name='detail-imp-" + rows + "' value='" + valor + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-secc-" + rows + "' name='detail-secc-" + rows + "' value='" + seccion + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-sep-" + rows + "' name='detail-sep-" + rows + "' value='" + sepultura + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-lote-" + rows + "' name='detail-lote-" + rows + "' value='" + lote + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-aper-" + rows + "' name='detail-aper-" + rows + "' value='" + apertura + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-secc2-" + rows + "' name='detail-secc2-" + rows + "' value='" + seccion2 + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-sep2-" + rows + "' name='detail-sep2-" + rows + "' value='" + sepultura2 + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-op-" + rows + "' name='detail-op-" + rows + "' value='"+OP+"'></input>";

			
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-tipo-" + rows + "' name='detail-tipo-" + rows + "' value='" + tipo + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-nom-" + rows + "' name='detail-nom-" + rows + "' value='" + nombre + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-edad-" + rows + "' name='detail-edad-" + rows + "' value='" + edad + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-ec-" + rows + "' name='detail-ec-" + rows + "' value='" + estadoCivil + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-nac-" + rows + "' name='detail-nac-" + rows + "' value='" + nacionalidad + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-causa-" + rows + "' name='detail-causa-" + rows + "' value='" + causa + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-partida-" + rows + "' name='detail-partida-" + rows + "' value='" + partida + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-fecd-" + rows + "' name='detail-fecd-" + rows + "' value='" + fecd + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-hora-" + rows + "' name='detail-hora-" + rows + "' value='" + hora + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-empresa-" + rows + "' name='detail-empresa-" + rows + "' value='" + empresa + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-dni-" + rows + "' name='detail-dni-" + rows + "' value='" + dni + "'></input>";


			_html += "</td>";
			_html += "</tr>";
			//alert(_html);

			$("#OPER-COUNTER").val(rows);
			$("#TOTAL-1").val(total);
			$("#PESOS").val(total);
			$("#table-detail").append(_html);

			insertPagoACuentaYAlertas(idlote, idOption);

			break;
		case 6:
			//alert("Reducciones");
			var jsP = $("#OPER-PRECIOS").val().replace("[", "").replace("]", "");
			var obj = JSON.parse(jsP);

			//alert(obj.PLACAS_CENICEROS);

			var valor = 0;
			var lote = $("#SELECT-LOTE option:selected").val();
			var nameOption = $("#SELECT-LOTE option:selected").text();
			var cadena = nameOption.split("|");

			var seccion = cadena[0].replace(/_/g, "");
			var sepultura = cadena[1].replace(/_/g, "");
			var nombre = cadena[3].replace(/_/g, "");
			var tipo = cadena[2].replace(/ /g, "");
			var apertura = cadena[4].replace(/_/g, "").replace(/ /g, "");
			var idlote = cadena[5].replace(/_/g, "").replace(/ /g, "");
			var cantidad = "";

			if (tipo == "UR" || tipo == "UA") { alert("ATENCION: ya es una urna"); return;}

			if (apertura == "1") { valor = obj.RED_3; cantidad = "tres"; }
			else if (apertura == "2") { valor = obj.RED_2; cantidad = "dos"; }
			else { valor = obj.RED_1; cantidad = "una"; }

			//alert("valor: ->" + cadena[0].replace(/_/g,"") + "<-");
			var con = "Reducción "+cantidad+" Sección "+seccion+" Sepultura Nº "+sepultura+" Apertura "+apertura+" : "+ nombre;
			//alert(con);

			//alert("insertar: " + importe);
			var total = Number($("#TOTAL-1").val());
			//alert("insertar: " + total);

			var importe = Number(valor);
			//alert("insertar: " + importe);
			total = total + importe;
			//alert("insertar sumado: " + total);

			_html = "";
			_html += "<tr id='detail-form-row-" + rows + "'>";
			_html += "   <td><a href='#' onClick=\"javascript:deleteRow('detail-form-row-" + rows + "','detail-imp-" + rows + "','" + rows + "');return false;\">eliminar</a></td>";
			_html += "   <td id='detail-form-row-" + rows + "-id'>" + rows + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-con'>" + con + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-imp'>" + valor;
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-id-" + rows + "' name='detail-id-" + rows + "' value='" + rows + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-con-" + rows + "' name='detail-con-" + rows + "' value='" + con + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-imp-" + rows + "' name='detail-imp-" + rows + "' value='" + valor + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-secc-" + rows + "' name='detail-secc-" + rows + "' value='" + seccion + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-sep-" + rows + "' name='detail-sep-" + rows + "' value='" + sepultura + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-lote-" + rows + "' name='detail-lote-" + rows + "' value='" + lote + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-aper-" + rows + "' name='detail-aper-" + rows + "' value='" + apertura + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-op-" + rows + "' name='detail-op-" + rows + "' value='RD'></input>";

			_html += "</td>";
			_html += "</tr>";
			//alert(_html);

			$("#OPER-COUNTER").val(rows);
			$("#TOTAL-1").val(total);
			$("#PESOS").val(total);
			$("#table-detail").append(_html);
			insertPagoACuentaYAlertas(idlote, idOption);
			break;
		case 7:
			//Uso de Capilla
			var jsP = $("#OPER-PRECIOS").val().replace("[", "").replace("]", "");
			var obj = JSON.parse(jsP);
			//alert(obj.ARR_NODISI);

			var valor = obj.USOCAPILLA;

			//alert("valor: ->" + valor + "<-");
			var con = "Uso de la Capilla";

			//alert("insertar: " + importe);
			var total = Number($("#TOTAL-1").val());
			//alert("insertar: " + total);

			var importe = Number(valor);
			//alert("insertar: " + importe);
			total = total + importe;
			//alert("insertar sumado: " + total);

			_html = "";
			_html += "<tr id='detail-form-row-" + rows + "'>";
			_html += "   <td><a href='#' onClick=\"javascript:deleteRow('detail-form-row-" + rows + "','detail-imp-" + rows + "','" + rows + "');return false;\">eliminar</a></td>";
			_html += "   <td id='detail-form-row-" + rows + "-id'>" + rows + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-con'>" + con + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-imp'>" + valor;
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-id-" + rows + "' name='detail-id-" + rows + "' value='" + rows + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-con-" + rows + "' name='detail-con-" + rows + "' value='" + con + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-imp-" + rows + "' name='detail-imp-" + rows + "' value='" + valor + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-secc-" + rows + "' name='detail-secc-" + rows + "' value=''></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-sep-" + rows + "' name='detail-sep-" + rows + "' value=''></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-lote-" + rows + "' name='detail-lote-" + rows + "' value=''></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-op-" + rows + "' name='detail-op-" + rows + "' value='CA'></input>";

			_html += "</td>";
			_html += "</tr>";
			//alert(_html);

			$("#OPER-COUNTER").val(rows);
			$("#TOTAL-1").val(total);
			$("#PESOS").val(total);
			$("#table-detail").append(_html);
			break;
		case 8:
			//Transf. titul. / duplicado
			var jsP = $("#OPER-PRECIOS").val().replace("[", "").replace("]", "");
			var obj = JSON.parse(jsP);
			//alert(obj.ARR_NODISI);

			var valor = obj.TITULO;

			//alert("valor: ->" + valor + "<-");
			var con = "Duplicado/Transferencia de Título";

			//alert("insertar: " + importe);
			var total = Number($("#TOTAL-1").val());
			//alert("insertar: " + total);

			var importe = Number(valor);
			//alert("insertar: " + importe);
			total = total + importe;
			//alert("insertar sumado: " + total);

			_html = "";
			_html += "<tr id='detail-form-row-" + rows + "'>";
			_html += "   <td><a href='#' onClick=\"javascript:deleteRow('detail-form-row-" + rows + "','detail-imp-" + rows + "','" + rows + "');return false;\">eliminar</a></td>";
			_html += "   <td id='detail-form-row-" + rows + "-id'>" + rows + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-con'>" + con + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-imp'>" + valor;
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-id-" + rows + "' name='detail-id-" + rows + "' value='" + rows + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-con-" + rows + "' name='detail-con-" + rows + "' value='" + con + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-imp-" + rows + "' name='detail-imp-" + rows + "' value='" + valor + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-secc-" + rows + "' name='detail-secc-" + rows + "' value=''></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-sep-" + rows + "' name='detail-sep-" + rows + "' value=''></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-lote-" + rows + "' name='detail-lote-" + rows + "' value=''></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-op-" + rows + "' name='detail-op-" + rows + "' value='TI'></input>";

			_html += "</td>";
			_html += "</tr>";
			//alert(_html);

			$("#OPER-COUNTER").val(rows);
			$("#TOTAL-1").val(total);
			$("#PESOS").val(total);
			$("#table-detail").append(_html);

			break;
		case 9:
			//varios
			var importe = Number($("#TB-importe").val());
			var detalle = $("#TB-detalle").val();
			//alert("insertar: " + importe);
			var total = Number($("#TOTAL-1").val());
			//alert("insertar: " + total);
			total = total + importe;
			//alert("insertar sumado: " + total);

			_html = "";
			_html += "<tr id='detail-form-row-" + rows + "'>";
			_html += "   <td><a href='#' onClick=\"javascript:deleteRow('detail-form-row-" + rows + "','detail-imp-" + rows + "','" + rows + "');return false;\">eliminar</a></td>";
			_html += "   <td id='detail-form-row-" + rows + "-id'>" + rows + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-con'>" + detalle + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-imp'>" + importe;
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-id-" + rows + "' name='detail-id-" + rows + "' value='" + rows + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-con-" + rows + "' name='detail-con-" + rows + "' value='" + detalle + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-imp-" + rows + "' name='detail-imp-" + rows + "' value='" + importe + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-secc-" + rows + "' name='detail-secc-" + rows + "' value=''></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-sep-" + rows + "' name='detail-sep-" + rows + "' value=''></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-lote-" + rows + "' name='detail-lote-" + rows + "' value=''></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-op-" + rows + "' name='detail-op-" + rows + "' value='VA'></input>";

			_html += "</td>";
			_html += "</tr>";
			//alert(_html);

			$("#OPER-COUNTER").val(rows);
			$("#TOTAL-1").val(total);
			$("#PESOS").val(total);
			$("#table-detail").append(_html);
			break;
		case 10:
			/*Pagos a cuenta*/

			var importe = Number($("#TB-importe").val());
			//alert("insertar: " + importe);
			var total = Number($("#TOTAL-1").val());
			//alert("insertar: " + total);
			total = total + importe;
			//alert("insertar sumado: " + total);

			_html = "";
			_html += "<tr id='detail-form-row-" + rows + "'>";
			_html += "   <td><a href='#' onClick=\"javascript:deleteRow('detail-form-row-" + rows + "','detail-imp-" + rows + "','" + rows + "');return false;\">eliminar</a></td>";
			_html += "   <td id='detail-form-row-" + rows + "-id'>" + rows + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-con'>Pago a cuenta: sección sepultura</td>";
			_html += "   <td id='detail-form-row-" + rows + "-imp'>" + importe;
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-id-" + rows + "' name='detail-id-" + rows + "' value='" + rows + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-con-" + rows + "' name='detail-con-" + rows + "' value='Pago a cuenta: sección sepultura'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-imp-" + rows + "' name='detail-imp-" + rows + "' value='" + importe + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-secc-" + rows + "' name='detail-secc-" + rows + "' value=''></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-sep-" + rows + "' name='detail-sep-" + rows + "' value=''></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-lote-" + rows + "' name='detail-lote-" + rows + "' value=''></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-op-" + rows + "' name='detail-op-" + rows + "' value='PC'></input>";

			_html += "</td>";
			_html += "</tr>";
			//alert(_html);

			$("#OPER-COUNTER").val(rows);
			$("#TOTAL-1").val(total);
			$("#PESOS").val(total);
			$("#table-detail").append(_html);
			break;
		case 11:
			//Cenizas
			var jsP = $("#OPER-PRECIOS").val().replace("[", "").replace("]", "");
			//alert(jsP);

			var obj = JSON.parse(jsP);
			//alert("parseado");
			//alert(obj.ID);
			//alert(obj.ARR_NODISI);

			var tiene = $("input:radio[name=rbles]:checked").val();
			//alert("tiene " + tiene);
			var dis = $("input:radio[name=rbldis]:checked").val();
			//alert("dis " + dis);
			var valor = 0;

			if (tiene == "S" && dis == "S") {
				valor = obj.CENIZAS1;
			}
			else if (tiene== "S" && dis == "N") {
				valor = obj.CENIZAS3;
			}
			else if (tiene == "N" && dis == "S") {
				valor = obj.CENIZAS2;
			}
			else if (tiene == "N" && dis == "N") {
				valor = obj.CENIZAS4;
			}
			else {
				valor = 0;
			}

			//alert("valor: ->" + valor + "<-");
			var con = "Inhumación de Cenizas en \n el Jardín de los Recuerdos";

			//alert("insertar: " + importe);
			var total = Number($("#TOTAL-1").val());
			//alert("insertar: " + total);

			var importe = Number(valor);
			//alert("insertar: " + importe);
			total = total + importe;
			//alert("insertar sumado: " + total);

			_html = "";
			_html += "<tr id='detail-form-row-" + rows + "'>";
			_html += "   <td><a href='#' onClick=\"javascript:deleteRow('detail-form-row-" + rows + "','detail-imp-" + rows + "','" + rows + "');return false;\">eliminar</a></td>";
			_html += "   <td id='detail-form-row-" + rows + "-id'>" + rows + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-con'>"+con+"</td>";
			_html += "   <td id='detail-form-row-" + rows + "-imp'>" + valor;
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-id-" + rows + "' name='detail-id-" + rows + "' value='" + rows + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-con-" + rows + "' name='detail-con-" + rows + "' value='" + con + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-imp-" + rows + "' name='detail-imp-" + rows + "' value='" + valor + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-secc-" + rows + "' name='detail-secc-" + rows + "' value=''></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-sep-" + rows + "' name='detail-sep-" + rows + "' value=''></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-lote-" + rows + "' name='detail-lote-" + rows + "' value=''></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-op-" + rows + "' name='detail-op-" + rows + "' value='CE'></input>";

			_html += "</td>";
			_html += "</tr>";
			//alert(_html);

			$("#OPER-COUNTER").val(rows);
			$("#TOTAL-1").val(total);
			$("#PESOS").val(total);
			$("#table-detail").append(_html);
			

			break;
		case 12:
			//alert("Placas ceniceros");

			//var jsP = $("#OPER-PRECIOS").val().replace("[", "").replace("]", "");
			//var obj = JSON.parse(jsP);

			////alert(obj.PLACAS_CENICEROS);

			//var valor = obj.PLACAS_CENICEROS;
			//var lote = $("#SELECT-LOTE option:selected").val();
			//var nameOption = $("#SELECT-LOTE option:selected").text();
			//var cadena = nameOption.split("|");

			//var seccion = cadena[0].replace(/_/g, "");
			//var sepultura = cadena[1].replace(/_/g, "");
			//var nombre = cadena[3].replace(/_/g, "");

			////alert("valor: ->" + cadena[0].replace(/_/g,"") + "<-");

			var valor = Number($("#TB-importe").val());

			var con = "Placas Ceniceros";
			//alert(con);

			//alert("insertar: " + importe);
			var total = Number($("#TOTAL-1").val());
			//alert("insertar: " + total);

			var importe = Number(valor);
			//alert("insertar: " + importe);
			total = total + importe;
			//alert("insertar sumado: " + total);

			_html = "";
			_html += "<tr id='detail-form-row-" + rows + "'>";
			_html += "   <td><a href='#' onClick=\"javascript:deleteRow('detail-form-row-" + rows + "','detail-imp-" + rows + "','" + rows + "');return false;\">eliminar</a></td>";
			_html += "   <td id='detail-form-row-" + rows + "-id'>" + rows + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-con'>" + con + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-imp'>" + valor;
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-id-" + rows + "' name='detail-id-" + rows + "' value='" + rows + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-con-" + rows + "' name='detail-con-" + rows + "' value='" + con + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-imp-" + rows + "' name='detail-imp-" + rows + "' value='" + valor + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-op-" + rows + "' name='detail-op-" + rows + "' value='PL'></input>";

			_html += "</td>";
			_html += "</tr>";
			//alert(_html);

			$("#OPER-COUNTER").val(rows);
			$("#TOTAL-1").val(total);
			$("#PESOS").val(total);
			$("#table-detail").append(_html);

			//insertPagoACuentaYAlertas(lote, idOption);

			break;
		case 13:
			/*Donaciones*/
			
			var importe = Number($("#TB-importe").val());
			//alert("insertar: " + importe);
			var total = Number($("#TOTAL-1").val());
			//alert("insertar: " + total);
			total = total + importe;
			//alert("insertar sumado: " + total);

			_html = "";
			_html += "<tr id='detail-form-row-" + rows + "'>";
			_html += "   <td><a href='#' onClick=\"javascript:deleteRow('detail-form-row-" + rows + "','detail-imp-" + rows + "','" + rows + "');return false;\">eliminar</a></td>";
			_html += "   <td id='detail-form-row-" + rows + "-id'>" + rows + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-con'>Donación</td>";
			_html += "   <td id='detail-form-row-" + rows + "-imp'>" + importe;
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-id-" + rows + "'  name='detail-id-" + rows + "' value='" + rows + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-con-" + rows + "'  name='detail-con-" + rows + "' value='Donación'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-imp-" + rows + "' name='detail-imp-" + rows + "' value='" + importe + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-secc-" + rows + "' name='detail-secc-" + rows + "' value=''></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-sep-" + rows + "' name='detail-sep-" + rows + "' value=''></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-lote-" + rows + "' name='detail-lote-" + rows + "' value=''></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-op-" + rows + "' name='detail-op-" + rows + "' value='DO'></input>";

			_html += "</td>";
			_html += "</tr>";
			//alert(_html);

			$("#OPER-COUNTER").val(rows);
			$("#TOTAL-1").val(total);
			$("#PESOS").val(total);
			$("#table-detail").append(_html);
			break;
		case 14:
			var importe = Number($("#TB-importe").val());
			var detalle = $("#TB-detalle").val();
			//alert("insertar: " + importe);
			var total = Number($("#TOTAL-1").val());
			//alert("insertar: " + total);
			total = total + importe;
			//alert("insertar sumado: " + total);

			_html = "";
			_html += "<tr id='detail-form-row-" + rows + "'>";
			_html += "   <td><a href='#' onClick=\"javascript:deleteRow('detail-form-row-" + rows + "','detail-imp-" + rows + "','" + rows + "');return false;\">eliminar</a></td>";
			_html += "   <td id='detail-form-row-" + rows + "-id'>" + rows + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-con'>" + detalle + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-imp'>" + importe;
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-id-" + rows + "' name='detail-id-" + rows + "' value='" + rows + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-con-" + rows + "' name='detail-con-" + rows + "' value='" + detalle + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-imp-" + rows + "' name='detail-imp-" + rows + "' value='" + importe + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-secc-" + rows + "' name='detail-secc-" + rows + "' value=''></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-sep-" + rows + "'  name='detail-sep-" + rows + "' value=''></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-lote-" + rows + "' name='detail-lote-" + rows + "' value=''></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-op-" + rows + "' name='detail-op-" + rows + "' value='JA'></input>";

			_html += "</td>";
			_html += "</tr>";
			//alert(_html);

			$("#OPER-COUNTER").val(rows);
			$("#TOTAL-1").val(total);
			$("#PESOS").val(total);
			$("#table-detail").append(_html);
			break;
		case 15:
			
			var importe = Number($("#TB-importe").val());
			var detalle = $("#TB-detalle").val();
			//alert("insertar: " + importe);
			var total = Number($("#TOTAL-1").val());
			//alert("insertar: " + total);
			total = total + importe;
			//alert("insertar sumado: " + total);

			_html = "";
			_html += "<tr id='detail-form-row-" + rows + "'>";
			_html += "   <td><a href='#' onClick=\"javascript:deleteRow('detail-form-row-" + rows + "','detail-imp-" + rows + "','" + rows + "');return false;\">eliminar</a></td>";
			_html += "   <td id='detail-form-row-" + rows + "-id'>" + rows + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-con'>" + detalle + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-imp'>" + importe;
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-id-" + rows + "' name='detail-id-" + rows + "' value='" + rows + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-con-" + rows + "' name='detail-con-" + rows + "' value='" + detalle + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-imp-" + rows + "' name='detail-imp-" + rows + "' value='" + importe + "'></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-secc-" + rows + "' name='detail-secc-" + rows + "' value=''></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-sep-" + rows + "' name='detail-sep-" + rows + "' value=''></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-lote-" + rows + "' name='detail-lote-" + rows + "' value=''></input>";
			_html += "<input type=text class='form-control text dbase' style='display: none' id='detail-op-" + rows + "' name='detail-op-" + rows + "' value='RC'></input>";

			_html += "</td>";
			_html += "</tr>";
			//alert(_html);

			$("#OPER-COUNTER").val(rows);
			$("#TOTAL-1").val(total);
			$("#PESOS").val(total);
			$("#table-detail").append(_html);

			break;
		case 16:
			//alert("insertar 16");
			var importe = Number($("#TB-importe").val());

			var jsP = $("#OPER-PRECIOS").val().replace("[", "").replace("]", "");
			var obj = JSON.parse(jsP);

			

			/*el anterior pisa el valor con el precio.....*/
			//importe = obj.LIBRO;

			//alert("insertar: " + importe);
			var total = Number($("#TOTAL-1").val());
			//alert("insertar: " + total);
			total = total + importe;
			//alert("insertar sumado: " + total);

			_html = "";
			_html += "<tr id='detail-form-row-" + rows + "'>";
			_html += "   <td><a href='#' onClick=\"javascript:deleteRow('detail-form-row-" + rows + "','detail-imp-" + rows + "','" + rows + "');return false;\">eliminar</a></td>";
			_html += "   <td id='detail-form-row-" + rows + "-id'>" + rows + "</td>";
			_html += "   <td id='detail-form-row-" + rows + "-con'>Libro</td>";
			_html += "   <td id='detail-form-row-" + rows + "-imp'>" + importe;
			_html += "<input type=text data-type='text' class='form-control text dbase' style='display: none' id='detail-id-" + rows + "' name='detail-id-" + rows + "' value='" + rows + "'>";
			_html += "<input type=text data-type='text' class='form-control text dbase' style='display: none' id='detail-con-" + rows + "' name='detail-con-" + rows + "' value='Libro'>";
			_html += "<input type=text data-type='text' class='form-control text dbase' style='display: none' id='detail-imp-" + rows + "' name='detail-imp-" + rows + "' value='" + importe + "'>";
			_html += "<input type=text data-type='text' class='form-control text dbase' style='display: none' id='detail-secc-" + rows + "' name='detail-secc-" + rows + "' value=''>";
			_html += "<input type=text data-type='text' class='form-control text dbase' style='display: none' id='detail-sep-" + rows + "' name='detail-sep-" + rows + "' value=''>";
			_html += "<input type=text data-type='text' class='form-control text dbase' style='display: none' id='detail-lote-" + rows + "' name='detail-lote-" + rows + "' value=''>";
			_html += "<input type=text data-type='text' class='form-control text dbase' style='display: none' id='detail-op-" + rows + "' name='detail-op-" + rows + "' value='LB'>";
			
			_html += "</td>";
			_html += "</tr>";
			//alert(_html);
			
			$("#OPER-COUNTER").val(rows);
			$("#TOTAL-1").val(total);
			$("#PESOS").val(total);
			$("#table-detail").append(_html);
			
			break;

	}

	adjustTotalzPlain(0);

}

function getLoteFilter() {
	var _html = "";
	_html += "<div class='col-md-10'>"
	_html += _TOOLS.getComboFromList("Sort", "Ordenar por ", 3, "ID", "TITULAR,RESPONSABL,ID", "Titular,Responsable,Lote", "N ", "", "N", " class='form-select form-select-sm' ","N");
	_html += "&nbsp;&nbsp;";
	_html += _TOOLS.getTextBox("seccion", "Sección&nbsp;&nbsp;", 3, "", "N", "class=''");
	_html += "&nbsp;&nbsp;";
	_html += _TOOLS.getTextBox("sepultura", "Sepultura&nbsp;&nbsp;", 3, "", "N", "class=''");
	_html += "&nbsp;&nbsp;";
	_html += _TOOLS.getTextBox("responsable", "Responsable&nbsp;&nbsp;", 3, "", "N", "class=''");
	_html += "&nbsp;&nbsp;";
	_html += _TOOLS.getTextBox("titular", "Titular&nbsp;&nbsp;", 3, "", "N", "class=''");
	_html += "&nbsp;&nbsp;";
	_html += "<button type='button' class='btn-raised' id='SEARCH-BTN' name='SEARCH-BTN' onclick=javascript:buscarOnClick();><i class='material-icons'>done</i>OK</button>";
	_html += "</div>"
	_html += "<div class='col-md-8'>";
	_html += "<label for='LOTE-SELECT'>Seleccione Lote</label>";
	_html += "<select class='form-control select dbase' name='SELECT-LOTE' id='SELECT-LOTE'  onchange=javascript:selectLoteOnChange();>";
	_html += "</select>";
	_html += "<div class='invalid-feedback invalid-TEST-FIELD-1 d-none'></div>";
	_html += "</div>";
	_html += "<br/>";
	return _html;
}

function getLoteFallecidosFilter() {
	var _html = "";
	_html += "<div class='col-md-10'>"
	_html += _TOOLS.getComboFromList("Sort", "Ordenar por ", 3, "ID", "TITULAR,RESPONSABL,ID", "Titular,Responsable,Lote", "N ", "", "N", " class='form-select form-select-sm' ", "N");
	_html += "&nbsp;&nbsp;";
	_html += _TOOLS.getTextBox("seccion", "Sección&nbsp;&nbsp;", 3, "", "N", "class=''");
	_html += "&nbsp;&nbsp;";
	_html += _TOOLS.getTextBox("sepultura", "Sepultura&nbsp;&nbsp;", 3, "", "N", "class=''");
	_html += "&nbsp;&nbsp;";
	_html += _TOOLS.getTextBox("sNombre", "Nombre&nbsp;&nbsp;", 3, "", "N", "class=''");
	_html += "&nbsp;&nbsp;";
	_html += "<button type='button' class='btn-raised' id='SEARCH-BTN' name='SEARCH-BTN' onclick=javascript:buscarOnClickFallecidos();><i class='material-icons'>done</i>OK</button>";
	_html += "</div>"
	_html += "<div class='col-md-8'>";
	_html += "<label for='LOTE-SELECT'>Seleccione Lote</label>";
	_html += "<select class='form-control select dbase' name='SELECT-LOTE' id='SELECT-LOTE'  onchange=javascript:selectLoteOnChange();>";
	_html += "</select>";
	_html += "<div class='invalid-feedback invalid-TEST-FIELD-1 d-none'></div>";
	_html += "</div>";
	_html += "<br/>";
	return _html;
}

function selectOperOnChange () {
	//alert("sarasa change 1111");
	//alert("recibo: " + $("#NRO_RECIBO").val());
	//alert("id: " + $("#SELECT-OPER option:selected").val());
	$('#OPER-ADD-BTN').prop('disabled', false);

	var idOption = Number($("#SELECT-OPER option:selected").val());
	switch (idOption) {
		case 1:
			//Conservacion
			//alert("conservacion");
			var _html = "<br/>";
			_html = getLoteFilter();
			//alert(_html);
			$('#OPER-ADD-BTN').prop('disabled', true);
			_html += "<div id='OPER-CONTAINER-DETAIL' name='OPER-CONTAINER-DETAIL'></div>";
			$("#OPER-CONTAINER").html(_html);

			break;
		case 2:
			//Renovacion
			//alert("Renovacion");
			var _html = "<br/>";
			_html = getLoteFilter();
			_html += _TOOLS.getComboFromList("cboYrs", "Años ", 3, "10", "1,2,3,4,5,10,50,99", "1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;,2,3,4,5,10,50,99", "N ", "", "N", " width=100px ","N");
			
			
			//alert(_html);
			$('#OPER-ADD-BTN').prop('disabled', true);
			_html += "<div id='OPER-CONTAINER-DETAIL' name='OPER-CONTAINER-DETAIL'></div>";
			$("#OPER-CONTAINER").html(_html);
			break;
		case 3:
			//Arrendamiento
			var _html = "<br/>";
			_html = getLoteFilter();
			
			_html += _TOOLS.getComboFromList("cboYrs", "Duración ", 3, "15", "15,50,99", "15 años &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;,50 años,99 años", "N ", "", "N", " width=100px  onchange=javascript:selectDuracionOnChange();","N");

			//alert(_html);
			$('#OPER-ADD-BTN').prop('disabled', true);
			_html += "<div id='OPER-CONTAINER-DETAIL' name='OPER-CONTAINER-DETAIL'></div>";
			$("#OPER-CONTAINER").html(_html);

			break;
		case 4:
			//alert("Inhumaciones");
			var _html = "<br/>";
			_html = getLoteFilter();

			//_html += _TOOLS.getComboFromList("cboYrs", "Duración ", 3, "-", "0,10,15,50,99", "-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;,10 años,15 años,50 años,99 años", "N ", "", "N", " width=100px  onchange=javascript:selectDurecionOnChange();", "N");

			//alert(_html);
			$('#OPER-ADD-BTN').prop('disabled', true);
			_html += "<div id='OPER-CONTAINER-DETAIL' name='OPER-CONTAINER-DETAIL'></div>";
			$("#OPER-CONTAINER").html(_html);

			break;
		case 5:
			var optionName1 = $("#SELECT-OPER option:selected").text();
			if (optionName1 == "Traslado Interno") {
				var _html = "<br/>";
				_html = getLoteFallecidosFilter();

				//_html += _TOOLS.getComboFromList("cboYrs", "Duración ", 3, "-", "0,10,15,50,99", "-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;,10 años,15 años,50 años,99 años", "N ", "", "N", " width=100px  onchange=javascript:selectDurecionOnChange();", "N");

				//alert(_html);
				$('#OPER-ADD-BTN').prop('disabled', true);
				_html += "<div id='OPER-CONTAINER-DETAIL' name='OPER-CONTAINER-DETAIL'></div>";
				$("#OPER-CONTAINER").html(_html);
				//alert("Translados interno ");
			}
			else {
				var _html = "<br/>";
				_html = getLoteFilter();

				//_html += _TOOLS.getComboFromList("cboYrs", "Duración ", 3, "-", "0,10,15,50,99", "-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;,10 años,15 años,50 años,99 años", "N ", "", "N", " width=100px  onchange=javascript:selectDurecionOnChange();", "N");

				//alert(_html);
				$('#OPER-ADD-BTN').prop('disabled', true);
				_html += "<div id='OPER-CONTAINER-DETAIL' name='OPER-CONTAINER-DETAIL'></div>";
				$("#OPER-CONTAINER").html(_html);
				//alert("Translados Externo ");
			}
			
			break;
		case 6:
			var _html = "<br/>";
			_html = getLoteFallecidosFilter();

			//_html += _TOOLS.getComboFromList("cboYrs", "Duración ", 3, "-", "0,10,15,50,99", "-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;,10 años,15 años,50 años,99 años", "N ", "", "N", " width=100px  onchange=javascript:selectDurecionOnChange();", "N");

			//alert(_html);
			$('#OPER-ADD-BTN').prop('disabled', true);
			_html += "<div id='OPER-CONTAINER-DETAIL' name='OPER-CONTAINER-DETAIL'></div>";
			$("#OPER-CONTAINER").html(_html);

			//alert("Reducciones");
			break;
		case 7:
			//Uso de Capilla
			//no tiene carga de datos
			$("#OPER-CONTAINER").html("");
			break;
		case 8:
			//Transf. titul. / duplicado
			//no tiene carga de datos
			$("#OPER-CONTAINER").html("");
			break;
		case 9:
			/*varios*/
			var _html = "<br/>";
			_html += _TOOLS.getTextBox("detalle", "Detalle", 8, "", "Y","class='form-control text dbase'");
			_html += "<br/>";
			_html += _TOOLS.getTextBox("importe", "Precio Unitario", 3, "0", "Y", "class='form-control text dbase'");
			//alert(_html);
			$("#OPER-CONTAINER").html(_html);
			break;
		case 10:
			//Pagos a Cuenta*/
			var _html = "<br/>";
			_html += _TOOLS.getTextBox("importe", "Precio Unitario", 3, "0", "Y", "class='form-control text dbase'");
			//alert(_html);
			$("#OPER-CONTAINER").html(_html);
			break;
		case 11:
			//alert("Cenizas");

			var _html = "<br/>";
			_html += _TOOLS.getRadioYesNoButton("rbles", "¿Posee lote en el cementerio? ", 8, "N", "S", "N", "Si ", "No ");
			_html += "<br/>";
			_html += _TOOLS.getRadioYesNoButton("rbldis", "¿Es disidente? ", 8, "N", "S", "N", "Si ", "No ");
			//alert(_html);
			$("#OPER-CONTAINER").html(_html);

			break;
		case 12:
			//alert("Placas ceniceros");
			var _html = "<br/>";
			//_html = getLoteFilter();

			//_html += _TOOLS.getComboFromList("cboYrs", "Duración ", 3, "-", "0,10,15,50,99", "-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;,10 años,15 años,50 años,99 años", "N ", "", "N", " width=100px  onchange=javascript:selectDurecionOnChange();", "N");

			var jsP = $("#OPER-PRECIOS").val().replace("[", "").replace("]", "");
			var obj = JSON.parse(jsP);

			var _html = "<br/>";
			_html += _TOOLS.getTextBox("importe", "Precio Unitario", 3, obj.PLACAS_CENICEROS, "Y", "class='form-control text dbase'");

			//alert(_html);
			//$('#OPER-ADD-BTN').prop('disabled', true);
			_html += "<div id='OPER-CONTAINER-DETAIL' name='OPER-CONTAINER-DETAIL'></div>";
			$("#OPER-CONTAINER").html(_html);
			break;
		case 13:
			/*donaciones*/
			var _html = "<br/>";
			_html += _TOOLS.getTextBox("importe", "Precio Unitario", 3, "0", "Y", "class='form-control text dbase'");
			//alert(_html);
			$("#OPER-CONTAINER").html(_html);
			break;
		case 14:
			/*jardinera*/
			var jsP = $("#OPER-PRECIOS").val().replace("[", "").replace("]", "");
			var obj = JSON.parse(jsP);

			var _html = "<br/>";
			_html += _TOOLS.getTextBox("detalle", "Detalle", 8, "Jardinera", "Y", "class='form-control text dbase'");
			_html += "<br/>";
			_html += _TOOLS.getTextBox("importe", "Precio Unitario", 3, obj.JARDINERIA, "Y", "class='form-control text dbase'");
			//alert(_html);
			$("#OPER-CONTAINER").html(_html);
			break;
		case 15:
			/*renovacion a cuenta*/
			var _html = "<br/>";
			_html += _TOOLS.getTextBox("detalle", "Detalle", 8, "", "Y", "class='form-control text dbase'");
			_html += "<br/>";
			_html += _TOOLS.getTextBox("importe", "Precio Unitario", 3, "0", "Y", "class='form-control text dbase'");
			//alert(_html);
			$("#OPER-CONTAINER").html(_html);
			break;
		case 16:
			/*libro*/
			var jsP = $("#OPER-PRECIOS").val().replace("[", "").replace("]", "");
			var obj = JSON.parse(jsP);

			var _html = "<br/>";
			_html += _TOOLS.getTextBox("importe", "Precio Unitario", 3, obj.LIBRO, "Y", "class='form-control text dbase'");
			//alert(_html);
			$("#OPER-CONTAINER").html(_html);
			break;

	}

}


