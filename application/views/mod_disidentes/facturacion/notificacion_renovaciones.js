

function generateCsv(el, fileName) {

	var link = document.createElement("a");
	link.href = 'data:text/csv,' + encodeURIComponent(el);
	link.download = fileName + ".csv";
	link.click();
}


function showReport() {

	var desde = $('#TB-DESDE').val();
	var hasta = $('#TB-HASTA').val();

	var IDMODELO = $('#id_modelo option:selected').val();
	var sepChar = $('#TB-SEPARADOR').val();
	var destino = $("input:radio[name=DESTINO]:checked").val();

	if (typeof destino === "undefined") {
		destino = "C";
	}


	var modo = $("input:radio[name=MODO]:checked").val();

	if (typeof modo === "undefined") {
		modo = "T";
	}

	//alert("desde: " + desde + " hasta " + hasta);

	var fechahastastr = _TOOLS.getTextAsFormattedDate(hasta, "ymd", "-");
	var fechahastastr1 = _TOOLS.getTextAsFormattedDate(hasta, "dmy", "/");


	var fechadesdestr = _TOOLS.getTextAsFormattedDate(desde, "ymd", "-");
	var fechadesdestr1 = _TOOLS.getTextAsFormattedDate(desde, "dmy", "/");


	if (modo == "C" && IDMODELO == 0) { alert("Debe elegir un modelo de notificación para los correos"); return; }


	//alert("Modelo: " + IDMODELO + " d: " + fechadesdestr + " h: " + fechahastastr + " Des: " + destino + " modo: " + modo) ;

	var myJSON = '{"DESDE":"' + fechadesdestr + '", "HASTA":"' + fechahastastr + '", "DESTINO":"' + destino + '", "MODO":"' + modo + '", "IDMODELO":"' + IDMODELO + '"}';
	var myObj = JSON.parse(myJSON);
	//alert("report2");

	var newline = "\r\n";



	_AJAX.UiGetNotificacionRenovaciones(myObj).then(function (datajson) {
		var _html = "";
		//alert("JSON: " + JSON.stringify(datajson.notificaciones));

		var titulo = "";
		var _header = "";
		var _footer = "";
		var fechav = "";
		var email = "";
		//alert("sarasa json");
		var titulo = "" + fechadesdestr1 + " al " + fechahastastr1;

		_html += "<br/><table style='width: 100%;padding: 10px' border=0>";
		_html += "<tr><th style='text-align:left;border-bottom: 2px solid black'>Vencimiento</th><th style='text-align:left;border-bottom: 2px solid black'>Sección</th><th style='text-align:left;border-bottom: 2px solid black'>Sepultura</th><th style='text-align:left;border-bottom: 2px solid black'>Titular</th></tr>";
		var filas = Number(0);

		if ((destino == "I" || destino == "P" || destino == "Z") && (modo == "S" || modo == "T" || modo == "C")) {

			$.each(datajson.notificaciones, function (j, val1) {
				try {
					fechav = _TOOLS.getTextAsFormattedDate(val1.VENCIMIENTO, "dmy", "/");
				} catch (error) { fechav = "N/A"; }


				if (modo == "S") {

					email = val1.EMAIL;
					if (email == "") { email = val1.RES_EMAIL;}
					//alert(email);
					if (email != "") {
						_html += "<tr><td style='text-align:left;'>" + fechav + "</td><td style='text-align:left;'>" + val1.SECCION + "</td><td style='text-align:left;'>" + val1.SEPULTURA + "</td><td style='text-align:left;'>" + val1.TITULAR + "</td></tr>";
						filas++;
					}
				}
				else {
					_html += "<tr><td style='text-align:left;'>" + fechav + "</td><td style='text-align:left;'>" + val1.SECCION + "</td><td style='text-align:left;'>" + val1.SEPULTURA + "</td><td style='text-align:left;'>" + val1.TITULAR + "</td></tr>";
					filas++;
				}

			});
			_html += "<tr><td style='text-align:left;border-top: 2px solid black'> </td><td style='text-align:left;border-top: 2px solid black'></td><td style='text-align:left;border-top: 2px solid black'>** TOTAL: " + filas + " lote(s) **</td><td style='text-align:left;border-top: 2px solid black'></td><td style='text-align:left;border-top: 2px solid black'></td><td style='text-align:left;border-top: 2px solid black'></td><td style='text-align:left;border-top: 2px solid black'></td></tr>";
			_html += "</table>";

			////$("#REPORT-CONTAINER").html(_html);

			var win = window.open("", "Reporte", "toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1024,height=768,top=" + (screen.height - 0) + ",left=" + (screen.width - 0));
			win.document.body.innerHTML = "<html><title>LISTADO DE VENCIMIENTOS DE RENOVACION</title><body><img src='" + _AJAX._here + "/assets/img/print.jpg' style='height:35px;' onclick='window.print();'/><br/><br/>Cementerio Disidentes <br/> Fecha: " + _TOOLS.getTodayDate("dmy", "/") + "<br/><br/> <center><h3 class='m-0 p-0' style='font-weight: bold; color: rgb(0,71,186);'>LISTADO DE VENCIMIENTOS DE RENOVACION <br/> DEL: " + titulo + "</h3></center>" + _html + "</body></html>";

		}

		if ((destino == "C" || destino == "X")) {
			var direccion = "";
			var titular = "";
			var localidad = "";
			var cod_postal = "";
			var seccion = "";
			var sepultura = "";
			var importe = 0;
			var cod_postal = "";
			var vence;
			var anosrenova = "";
			var anosarrend = "";
			var nrotit = "";
			var ulbim = "";
			var bimven = "";
			var resp = "";
			var tel = "";
			var res_tel = "";
			var res_dir = "";
			var res_cod_pos = "";
			var res_locali = "";
			var sector = "";
			var tipo = "";

			titulo = "";
			_header = "<pre style='word-wrap: break-word; white-space: pre-wrap; '>";
			_footer = "</pre>";
			_html = "VENCIMIENTO" + sepChar + "ANOSRENOVA" + sepChar + "ANOSARREND" + sepChar + "NROTITULO" + sepChar + "ULTBIMPAGO" + sepChar + "BIMVENCIDO" + sepChar + "SECCION" + sepChar + "SEPULTURA" + sepChar + "SECTOR" + sepChar + "TIPO" + sepChar + "TITULAR" + sepChar + "DIRECCION" + sepChar + "COD_POSTAL" + sepChar + "LOCALIDAD" + sepChar + "TELEFONO" + sepChar + "RESPONSABL" + sepChar + "RES_DIRECC" + sepChar + "RES_CODPOS" + sepChar + "RES_LOCALI" + sepChar + "RES_TELEFO" + newline;

			var hoy = _TOOLS.getTodayDate("dma", "/");

			//alert(hoy);

			$.each(datajson.notificaciones, function (j, val1) {

				try {
					res_tel = val1.RES_TELEFO;
					res_tel = res_tel.replace(/;/g, ' ').replace(/,/g, ' ');
				} catch (errorte) { tel = ""; }

				try {
					res_dir = val1.RES_DIRECC;
					res_dir = res_dir.replace(/;/g, ' ').replace(/,/g, ' ');
				} catch (errordd) { res_dir = ""; }
				try {
					resp = val1.RESPONSABL;
					resp = resp.replace(/;/g, ' ').replace(/,/g, ' ');
					//alert("titi2 :" +titular);

				} catch (errortp) { resp = ""; }
				try {
					res_locali = val1.RES_LOCALI;
					res_locali = res_locali.replace(/;/g, ' ').replace(/,/g, ' ');
				} catch (errorl23) { res_locali = ""; }
				try {
					res_cod_pos = val1.RES_CODPOS;
					res_cod_pos = res_cod_pos.replace(/;/g, ' ').replace(/,/g, ' ');
				} catch (errorcpr) { res_cod_pos = ""; }
				/**********************************/
				try {
					tel = val1.TELEFONO;
					tel = tel.replace(/;/g, ' ').replace(/,/g, ' ');
				} catch (errorte) { tel = ""; }

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
					ultbim = val1.ULTBIMPAGO;
				} catch (errorv1) { ultbim = "N/A"; }
				try {
					vence = val1.VENCIMIENTO;
				} catch (errorv2) { vence = "N/A"; }

				try {
					anosrenova = val1.ANOSRENOVA;
				} catch (errorv3) { anosrenova = "N/A"; }
				try {
					anosarrend = val1.ANOSARREND;
				} catch (errorv4) { anosarrend = "N/A"; }
				try {
					nrotit = val1.NROTITULO;
				} catch (errorv5) { nrotit = "N/A"; }

				try {
					bimven = val1.BIMVENCIDO;
				} catch (errorv6) { bimven = "N/A"; }

				try {
					tipo = val1.TIPO;
				} catch (errorv7) { tipo = "N/A"; }

				try {
					sector = val1.SECTOR;
					sector = sector.replace(/;/g, ' ').replace(/,/g, ' ');
				} catch (errorsep2) { sector = ""; }

				//alert("asasas");

				_html += _TOOLS.getTextAsFormattedDate(vence, "dma", "/") + sepChar + anosrenova + sepChar + anosarrend + sepChar + nrotit + sepChar + _TOOLS.getTextAsFormattedDate(ultbim, "dma", "/") + sepChar + bimven + sepChar + seccion + sepChar + sepultura + sepChar + sector + sepChar + tipo + sepChar + titular + sepChar + direccion + sepChar + cod_postal + sepChar + localidad + sepChar + tel + sepChar + resp + sepChar + res_dir + sepChar + res_cod_pos + sepChar + res_locali + sepChar + res_tel + newline;

			});
			//alert("asasas");
			generateCsv(_html, "etiquetas");

			_html = _header + _html + _footer;
			//alert(_html);

			var win2 = window.open("", "Reporte", "toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=1024,height=768,top=" + (screen.height - 0) + ",left=" + (screen.width - 0));
			win2.document.body.innerHTML = "<html><title>Notificación de Conservaciones</title><body>" + _html + "</body></html>";


			//alert("2");
		}
		//alert("fin");
	});

}

