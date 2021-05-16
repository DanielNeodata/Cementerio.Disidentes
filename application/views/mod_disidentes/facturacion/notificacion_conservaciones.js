function generateCsv(el,fileName) {

	var link = document.createElement("a");
	link.href = 'data:text/csv,' + encodeURIComponent(el);
	link.download = fileName+".csv";
	link.click();
}


function showReport() {
	//alert("report");
	var desde = $('#TB-DESDE').val();
	var hasta = $('#TB-HASTA').val();
	var cantidad_cartas = $('#TB-CANTIDAD_CARTAS').val();

	var IDMODELO = $('#id_modelo option:selected').val();

	var sepChar = $('#TB-SEPARADOR').val();;


	var fecha = $('#TB-FECHA').val();

	const fechahasta = new Date(fecha + ' 00:00:00');
	var fechahastastr = _TOOLS.getFormattedDate(fechahasta, "dmy", "/");

	var recalcula = "N";


	if ($('#recalcula').is(":checked")) {
		recalcula = "S";
	}

	var destino = $("input:radio[name=DESTINO]:checked").val();

	if (typeof destino === "undefined") {
		destino = "C";
	}


	var modo = $("input:radio[name=MODO]:checked").val();

	if (typeof modo === "undefined") {
		modo = "T";
	}

	if (modo == "C" && IDMODELO == 0) { alert("Debe elegir un modelo de notificación para los correos"); return;}


	//alert("Modelo: " + IDMODELO+" d: " + desde + " h: " + hasta + " r: " + recalcula + " f: " + fechahastastr + " Des: " + destino + " modo: " + modo + " Cant Cartas: " + cantidad_cartas);

	var myJSON = '{"DESDE":"' + desde + '", "HASTA":"' + hasta + '", "RECALCULA":"' + recalcula + '", "FECHA":"' + fechahastastr + '", "DESTINO":"' + destino + '", "MODO":"' + modo + '", "CANTIDAD_CARTAS":"' + cantidad_cartas + '", "IDMODELO":"' + IDMODELO + '"}';
	var myObj = JSON.parse(myJSON);
	//alert("report2");

	var newline = "\r\n";


	_AJAX.UiGetNotificacionConservaciones(myObj).then(function (datajson) {
		var _html = "";
		//alert("JSON: " + JSON.stringify(datajson.notificaciones));
		
		var titulo = "";
		var _header = "";
		var _footer = "";

		//alert("sarasa");

		if (destino == "I" || destino == "P") {
			var email = "";
			var titular = "";
			titulo = "";
			_header = "<pre style='word-wrap: break-word; white-space: pre-wrap; '>";
			_footer = "</pre>";

			$.each(datajson.notificaciones, function (j, val1) {
				try {
					email = val1.EMAIL;
					email = email.replace(/;/g, ' ').replace(/,/g, ' ');

				} catch (error1) { email = ""; }

				try {
					titular = val1.TITULAR;
					titular = titular.replace(/;/g, ' ').replace(/,/g, ' ');
				} catch (error2) { titular = "";}

				_html += email + sepChar + titular + newline;
				
			});
			_html = _header + _html + _footer;
			//alert(_html);

			var win = window.open("", "Reporte", "toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1024,height=768,top=" + (screen.height - 0) + ",left=" + (screen.width - 0));
			win.document.body.innerHTML = "<html><title>Notificación de Conservaciones</title><body>" + _html + "</body></html>";


			//alert("2");
		}

		if (modo == "C" && (destino == "C" || destino == "X" || destino == "Z")) {
			//alert("emails");
			titulo = "";
			_header = "<pre style='word-wrap: break-word; white-space: pre-wrap; '>";
			_footer = "</pre>";
			_html = "<h1>Se generaron <b>" + datajson.emails[0]["cantidad"] + "</b> emails a enviar, en forma exitosa</h1>";
			var win = window.open("", "Reporte", "toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1024,height=768,top=" + (screen.height - 0) + ",left=" + (screen.width - 0));
			win.document.body.innerHTML = "<html><title>Notificación de Conservaciones</title><body>" + _html + "</body></html>";
		}

		if ((destino == "C" || destino == "X" || destino == "Z") && modo!="C") {
			var direccion = "";
			var titular = "";
			var localidad = "";
			var cod_postal = "";
			var seccion = "";
			var sepultura = "";
			var importe = 0;
			var cod_postal = "";
			var vence;

			titulo = "";
			_header = "<pre style='word-wrap: break-word; white-space: pre-wrap; '>";
			_footer = "</pre>";

			_html += "TITULAR" + sepChar + "DIRECCION" + sepChar + " LOCALIDAD" + sepChar + " COD_POSTAL" + sepChar + " SECCION" + sepChar + " SEPULTURA" + sepChar + " DESDE" + sepChar + " HASTA" + sepChar +" IMPORTE " + newline;

			var hoy = _TOOLS.getTodayDate("dma", "/");

			//alert(hoy);

			$.each(datajson.notificaciones, function (j, val1) {
				try {
					direccion = val1.DIRECCION;
					direccion = direccion.replace(/;/g, ' ').replace(/,/g, ' ');
				} catch (errord) { direccion = ""; }
				try {
					titular = val1.TITULAR;
					titular = titular.replace(/;/g, ' ').replace(/,/g, ' ');
					//alert("titi2 :" +titular);

				} catch (errort) { titular = ""; }
				try {
					localidad = val1.LOCALIDAD;
					localidad = localidad.replace(/;/g, ' ').replace(/,/g, ' ');
				} catch (errorl) { localidad = ""; }
				try {
					cod_postal = val1.COD_POSTAL;
					cod_postal = cod_postal.replace(/;/g, ' ').replace(/,/g, ' ');
				} catch (errorcp) { cod_postal = ""; }
				try {
					seccion = val1.SECCION;
					seccion = seccion.replace(/;/g, ' ').replace(/,/g, ' ');
				} catch (errorsec) { seccion = ""; }
				try {
					sepultura = val1.SEPULTURA;
					sepultura = sepultura.replace(/;/g, ' ').replace(/,/g, ' ');
				} catch (errorsep) { sepultura = ""; }
				try {
					importe = val1.IMPORTE;
				} catch (errori) { importe = "N/A"; }
				try {
				vence = val1.ULTBIMPAGO;
				} catch (errorv) { vence = "N/A"; }

				//alert("asasas");

				_html += titular + sepChar + direccion + sepChar + localidad + sepChar + cod_postal + sepChar + seccion + sepChar + sepultura + sepChar + _TOOLS.getTextAsFormattedDate(vence,"dma","/") + sepChar + hoy + sepChar + _TOOLS.showNumber(importe, 2, "", 0) + newline;

			});
			//alert("asasas");
			generateCsv(_html,"etiquetas");

			_html = _header + _html + _footer;
			//alert(_html);

			var win2 = window.open("", "Reporte", "toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1024,height=768,top=" + (screen.height - 0) + ",left=" + (screen.width - 0));
			win2.document.body.innerHTML = "<html><title>Notificación de Conservaciones</title><body>" + _html + "</body></html>";


			//alert("2");
		}
		//alert("fin");
	});

}

