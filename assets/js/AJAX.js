_AJAX = {
	/**
	 * /
	 * GENERAL
	 */
	_pre: "",
    _waiter: false,
	server: (window.location.protocol + "//" + window.location.host + "/"),
	_here: (window.location.protocol + "//" + window.location.host + "/"),
	_remote_mode: (typeof window.parent.ripple === "undefined"),
	_ready: false,
	_user_firebase: null,
	_uid: null,
	_id_app: null,
	_id_channel: null,
	_channels: {},
	_id_user_active: null,
	_id_type_user_active: null,
	_username_active: null,
	_master_account: null,
	_image_active: null,
	_master_image_active: null,
	_language: "es-ar",
	_token_authentication: "",
	_token_authentication_created: "",
	_token_authentication_expire: "",
	_token_transaction: "",
	_token_transaction_created: "",
	_token_transaction_expire: "",
	_token_push: null,
	_model: null,
	_function: null,
	_module: null,
	_start_time: 0,
	forcePost: function (_path, _target, _parameters) {
		$("#forcedPost").remove();
		var _html = ("<form id='forcedPost' method='post' action='" + _AJAX.server + _path + "' target='" + _target + "'>");
		$.each(_parameters, function (key, value) {
			if (key == "where") { value = _TOOLS.utf8_to_b64(value); }
			_html += ("<input type='hidden' id='" + key + "' name='" + key + "' value='" + value + "'></input>");
		});
		_html += "</form>";
		$("body").append(_html);
		setTimeout(function () { $("#forcedPost").submit(); }, 1000);
	},
	formatFixedParameters: function (_json) {
		try {
			_AJAX._user_firebase.getIdToken().then(function (data) {
				_AJAX._token_push = data;
			}).catch(function (data) {
				_AJAX._token_push = "";
			});
		} catch (rex) {
			_AJAX._token_push = null;
		} finally {
			_json["token_push"] = _AJAX._token_push;
			_json["language"] = _AJAX._language;
			_json["token_authentication"] = _AJAX._token_authentication;
			_json["id_app"] = _AJAX._id_app;
			if (_AJAX._id_user_active == "" || _AJAX._id_user_active == null) { _AJAX._id_user_active = 0;}
			_json["id_user_active"] = _AJAX._id_user_active;
			_json["username_active"] = _AJAX._username_active;
			if (_json["id_app"] == undefined) { _json["id_app"] = _AJAX._id_app; }
			if (_json["id_type_user_active"] == undefined) { _json["id_type_user_active"] = _AJAX._id_type_user_active; }
			if (_json["id_channel"] == undefined) { _json["id_channel"] = _AJAX._id_channel; }
			if (_json["model"] == undefined) { _json["module"] = _AJAX.model; }
			if (_json["module"] == undefined) { _json["module"] = _AJAX._module; }
			if (_json["function"] == undefined) { _json["function"] = _AJAX._function; }
			if (_json["table"] == undefined) { _json["table"] = ""; }
			if (_json["method"] == undefined) { _json["method"] = "api.backend/neocommand"; }
			return _json;
		}
	},
	initialize: function (_user_firebase) {
		if (_AJAX._user_firebase == null) { _AJAX._user_firebase = _user_firebase; }
		_AJAX._ready = true;
	},
	ExecuteDirect: function (_json, _method) {
		return new Promise(
			function (resolve, reject) {
				try {
					_AJAX.Execute(_AJAX.formatFixedParameters(_json)).then(function (datajson) {
						if (datajson.status != undefined) {
							if (datajson.status == "OK") {
								$(".raw-username_active").html(_AJAX._username_active);
								resolve(datajson);
							} else {
								reject(datajson);
							}
						} else {
							resolve(datajson);
						}
					});
				} catch (rex) {
					reject(rex);
				}
			});
	},
	Execute: function (_json) {
		_AJAX._start_time = new Date().getTime();
		return new Promise(
			function (resolve, reject) {
				try {
					if (!_AJAX._ready) { _AJAX.initialize(null); }
					$(".raw-raw-request").html(_TOOLS.prettyPrint(_json));
					//alert(_AJAX.server + "->" + _json.method);
					var ajaxRq = $.ajax({
						type: "POST",
						dataType: "json",
						url: (_AJAX.server + _json.method),
						data: _json,
						beforeSend: function () {_AJAX.onBeforeSendExecute(); },
						complete: function () { _AJAX.onCompleteExecute(); },
						error: function (xhr, ajaxOptions, thrownError) {reject(thrownError);},
						success: function (datajson) {
							_AJAX.onSuccessExecute(datajson, _json)
								.then(function (datajson) { resolve(datajson); })
								.catch(function (err) { reject(err); });
						}
					});
				} catch (rex) {
					reject(rex);
				}
			}
		)
	},
	Load: function (_file) {
		return new Promise(
			function (resolve, reject) {
				var ajaxRq = $.ajax({
					type: "GET",
					timeout: 10000,
					dataType: "html",
					async: false,
					cache: false,
					url: _file,
					success: function (data) { resolve(data); },
					error: function (xhr, msg) { reject(msg); }
				});
			});
	},
	onBeforeSendExecute: function () {
		$(".waiter").removeClass("d-none");
		$(".wait-menu-ajax").html("<img src='" + _AJAX._pre + "./assets/img/menu.gif' style='height:24px'/>");
		$(".wait-search-ajax").html("<img src='" + _AJAX._pre + "./assets/img/search.gif' style='height:25px;width:50px;'/>");
		$(".wait-accept-ajax").html("<img src='" + _AJAX._pre + "./assets/img/accept.gif' style='height:25px;width:65px;'/>");
		if (_AJAX._waiter) {
			$(".wait-ajax").html("<img src='" + _AJAX._pre + "./assets/img/wait.gif' style='height:36px;'/>");
			$.blockUI({ message: '<img src="' + _AJAX._pre + './assets/img/wait.gif" />', css: { border: 'none', backgroundColor: 'transparent', opacity: 1, color: 'transparent' } });
		}
	},
	onCompleteExecute: function () {
		var request_time = ((new Date().getTime() - _AJAX._start_time) / 1000);
		$(".img-master").attr("src", _AJAX._master_image_active);
		$(".img-user").attr("src", _AJAX._image_active);
		$(".elapsed-time").html("Respuesta en " + request_time + " s");
		$(".waiter").html("");
		$(".status-ajax-calls").removeClass("d-none");
		if (_AJAX._waiter) { $.unblockUI(); }
		_AJAX._waiter = false;
	},
	onSuccessExecute: function (datajson, _json_original) {
		return new Promise(
			function (resolve, reject) {
				try {
					if (datajson["message"] == "Records") { datajson["message"] = "";}
					$(".raw-raw-response").html(_TOOLS.prettyPrint(datajson));
					$(".raw-message").html(datajson["code"] + ": " + datajson["message"]);
					if (datajson["status"] == "OK") {
						$(".status-last-call").removeClass("badge-danger").addClass("badge-success");
						$(".status-message").removeClass("d-sm-inline");
						//if (parseInt(_AJAX._doc_editor) == 1) { $(".editor-mode").removeClass("d-none"); } else { $(".editor-mode").addClass("d-none"); }
						//if (parseInt(_AJAX._doc_reviser) == 1) { $(".reviser-mode").removeClass("d-none"); } else { $(".reviser-mode").addClass("d-none"); }
						//if (_AJAX._doc_publisher == 1) { $(".publisher-mode").removeClass("d-none"); } else { $(".publisher-mode").addClass("d-none"); }
					} else {
						$(".status-last-call").removeClass("badge-success").addClass("badge-danger");
						$(".status-message").html(datajson["code"] + ": " + datajson["message"]).addClass("d-sm-inline");
					}
					$(".status-last-call").html(datajson["status"]);
					if (datajson == null) {
						datajson = { "results": null };
						resolve(datajson);
					} else {
						if (datajson.compressed == null) { datajson.compressed = false; }
						if (datajson.compressed == undefined) { datajson.compressed = false; }
						if (datajson != null && datajson.compressed) {
							var zip = new JSZip();
							JSZip.loadAsync(atob(datajson.message)).then(function (zip) {
								zip.file("compressed.tmp").async("string").then(
									function success(content) {
										datajson.message = content;
										resolve(datajson);
									},
									function error(err) { reject(err); });
							});
						} else {
							if (datajson.message != "") { _FUNCTIONS.onAlert({ "message": datajson.message, "class": "alert-danger" }); }
							switch (parseInt(datajson.code)) {
								case 5400:
									_AJAX.UiReAuthenticate({}).then(function (data) {
										_FUNCTIONS.onStatusAuthentication(data);
										_AJAX.Execute(_json_original);
									})
									break;
								case 5200:
								case 5401:
									var _title = (datajson.code + ": " + datajson.message);
									var _body = "<p class='text-monospace'>Ha cambiado su token de autenticación.</p>";
									_body += "<p class='text-monospace'>Esto puede haberse debido a: ";
									_body += "<li>Sus credenciales fueron usadas en otro dispositivo estando la actual sesión activa</li>";
									_body += "<li>Desde administración, se ha modificado su perfil de seguridad</li>";
									_body += "</p > ";
									_body += "<p class='text-monospace'>Por favor autentíquese nuevamente, para seguir en este dispositivo.</p>";
									_FUNCTIONS.onInfoModal({ "title": _title, "body": _body });
									_FUNCTIONS.onReloadInit();
									break;
								default:
									resolve(datajson);
									break;
							}
						}
					}
				} catch (rex) {
					reject(rex);
				}
			}
		)
	},

	/**
	 * /
	 * MOD_BACKEND
	 */

	/*
	 * eventos app para traer datos del backend 
	 */

	UiGetReciptDetails: function (_json) {
		//alert("VAR UiGetReciptDetails: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		//alert("JSON UiGetReciptDetails: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "getReciptDetail";
				_json["module"] = "mod_disidentes";
				_json["table"] = "Sac_facturacion_recibos";
				_json["model"] = "Sac_facturacion_recibos";
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},

	UiGetAsientoDetails: function (_json) {
		//alert("VAR UiGetReciptDetails: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		//alert("JSON UiGetReciptDetails: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "getAsientoDetail";
				_json["module"] = "mod_disidentes";
				_json["table"] = "CON_Encabezados";
				_json["model"] = "Sac_funcavanzadas_asientos";
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},

	UiGetLibroDiario: function (_json) {
		//alert("VAR UiGetReciptDetails: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		//alert("JSON UiGetReciptDetails: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "GetLibroDiario";
				_json["module"] = "mod_disidentes";
				_json["table"] = "CON_Encabezados";
				_json["model"] = "Funciones_avanzadas";
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},

	UiGetLibroDiarioHistorico: function (_json) {
		//alert("VAR UiGetReciptDetails: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		//alert("JSON UiGetReciptDetails: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "GetLibroDiarioHistorico";
				_json["module"] = "mod_disidentes";
				_json["table"] = "CON_Encabezados";
				_json["model"] = "Funciones_avanzadas";
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},

	UiGetLibroMayorHistorico: function (_json) {
		//alert("VAR UiGetReciptDetails: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		//alert("JSON UiGetReciptDetails: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "GetLibroMayorHistorico";
				_json["module"] = "mod_disidentes";
				_json["table"] = "CON_Encabezados";
				_json["model"] = "Funciones_avanzadas";
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},

	UiGetBalanceHistorico: function (_json) {
		//alert("VAR UiGetReciptDetails: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		//alert("JSON UiGetReciptDetails: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "GetBalanceHistorico";
				_json["module"] = "mod_disidentes";
				_json["table"] = "CON_Encabezados";
				_json["model"] = "Funciones_avanzadas";
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},

	UiGetLibroMayor: function (_json) {
		//alert("VAR UiGetReciptDetails: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		//alert("JSON UiGetReciptDetails: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "GetLibroMayor";
				_json["module"] = "mod_disidentes";
				_json["table"] = "CON_Encabezados";
				_json["model"] = "Funciones_avanzadas";
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},

	UiGetBalance: function (_json) {
		//alert("VAR UiGetReciptDetails: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		//alert("JSON UiGetReciptDetails: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "GetBalance";
				_json["module"] = "mod_disidentes";
				_json["table"] = "CON_Encabezados";
				_json["model"] = "Funciones_avanzadas";
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},

	UiReciptSearchLote: function (_json) {
		//alert("VAR UiReciptSearchLote: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		//alert("JSON UiReciptSearchLote: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "ReciptSearchLote";
				_json["module"] = "mod_disidentes";
				_json["table"] = "Sac_facturacion_recibos";
				_json["model"] = "Sac_facturacion_recibos";
				_json["method"] = "api.backend/neocommand";

				//alert("VAR UiReciptSearchLote11111: " + _json);

				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},

	UiReciptSearchLoteFallecidos: function (_json) {
		//alert("VAR UiReciptSearchLote: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		//alert("JSON UiReciptSearchLote: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "ReciptSearchLoteFallecidos";
				_json["module"] = "mod_disidentes";
				_json["table"] = "Sac_facturacion_recibos";
				_json["model"] = "Sac_facturacion_recibos";
				_json["method"] = "api.backend/neocommand";

				//alert("VAR UiReciptSearchLote11111: " + _json);

				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},

	UiGetRecibo: function (_json) {
		//alert("VAR UiGetRecibo: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		//alert("JSON UiGetRecibo: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "getRecipt";
				_json["module"] = "mod_disidentes";
				_json["table"] = "vw_SacRecibos";
				_json["model"] = "Sac_facturacion_recibos";
				_json["method"] = "api.backend/neocommand";

				//alert("VAR UiReciptSearchLote11111: " + _json);

				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},

	UiGetLote: function (_json) {
		//alert("VAR UiReciptSearchLote: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		//alert("JSON UiReciptSearchLote: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "GetLote";
				_json["module"] = "mod_disidentes";
				_json["table"] = "Sac_Lotes";
				_json["model"] = "Sac_Lotes";
				_json["method"] = "api.backend/neocommand";

				//alert("VAR UiReciptSearchLote11111: " + _json);

				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},

	UiGetArrendamientosXFecha: function (_json) {
		//alert("VAR UiReciptSearchLote: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		//alert("JSON UiReciptSearchLote: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "GetArrendamientosXFecha";
				_json["module"] = "mod_disidentes";
				_json["table"] = "SAC_Enca";
				_json["model"] = "Sac_facturacion_recibos";
				_json["method"] = "api.backend/neocommand";

				//alert("VAR UiReciptSearchLote11111: " + _json);

				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiGetRenocacionesXFecha: function (_json) {
		//alert("VAR UiReciptSearchLote: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		//alert("JSON UiReciptSearchLote: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "GetRenocacionesXFecha";
				_json["module"] = "mod_disidentes";
				_json["table"] = "SAC_Enca";
				_json["model"] = "Sac_facturacion_recibos";
				_json["method"] = "api.backend/neocommand";

				//alert("VAR UiReciptSearchLote11111: " + _json);

				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiGetEstadisticasGenerales: function (_json) {
		//alert("VAR UiReciptSearchLote: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		//alert("JSON UiReciptSearchLote: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "GetEstadisticasGenerales";
				_json["module"] = "mod_disidentes";
				_json["table"] = "SAC_Enca";
				_json["model"] = "Sac_facturacion_recibos";
				_json["method"] = "api.backend/neocommand";

				//alert("VAR UiReciptSearchLote11111: " + _json);

				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},

	UiGetNotificacionConservaciones: function (_json) {
		//alert("VAR UiGetNotificacionConservaciones: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		//alert("JSON UiGetNotificacionConservaciones: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "GetNotificacionConservaciones";
				_json["module"] = "mod_disidentes";
				_json["table"] = "SAC_EstaLote";
				_json["model"] = "Facturacion";
				_json["method"] = "api.backend/neocommand";

				//alert("VAR UiReciptSearchLote11111: " + _json);

				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},

	UiGetNotificacionRenovaciones: function (_json) {
		//alert("VAR UiGetNotificacionConservaciones: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		//alert("JSON UiGetNotificacionConservaciones: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "GetNotificacionRenovaciones";
				_json["module"] = "mod_disidentes";
				_json["table"] = "SAC_EstaLote";
				_json["model"] = "Facturacion";
				_json["method"] = "api.backend/neocommand";

				//alert("VAR UiReciptSearchLote11111: " + _json);

				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},

	UiGetLotesParaRecibotarjetas: function (_json) {
		//alert("VAR UiGetNotificacionConservaciones: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		//alert("JSON UiGetNotificacionConservaciones: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "GetLotesParaRecibotarjetas";
				_json["module"] = "mod_disidentes";
				_json["table"] = "SAC_EstaLote";
				_json["model"] = "Facturacion";
				_json["method"] = "api.backend/neocommand";

				//alert("VAR UiReciptSearchLote11111: " + _json);

				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiProcesarLotesParaRecibotarjetas: function (_json) {
		//alert("VAR UiGetNotificacionConservaciones: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		//alert("JSON UiGetNotificacionConservaciones: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "ProcesarLotesParaRecibotarjetas";
				_json["module"] = "mod_disidentes";
				_json["table"] = "SAC_EstaLote";
				_json["model"] = "Facturacion";
				_json["method"] = "api.backend/neocommand";

				//alert("VAR UiReciptSearchLote11111: " + _json);

				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},

	UiGetRubros: function (_json) {
		//alert("VAR UiReciptSearchLote: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		//alert("JSON UiReciptSearchLote: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "GetRubrosByFilter";
				_json["module"] = "mod_disidentes";
				_json["table"] = "CON_Rubros";
				_json["model"] = "Con_rubros";
				_json["method"] = "api.backend/neocommand";

				//alert("VAR UiReciptSearchLote11111: " + _json);

				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiGetRubrosHistoricos: function (_json) {
		//alert("VAR UiReciptSearchLote: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		//alert("JSON UiReciptSearchLote: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "GetRubrosHistoricosByFilter";
				_json["module"] = "mod_disidentes";
				_json["table"] = "CON_Rubros";
				_json["model"] = "Con_rubros";
				_json["method"] = "api.backend/neocommand";

				//alert("VAR UiReciptSearchLote11111: " + _json);

				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiGetCuentas: function (_json) {
		//alert("VAR UiReciptSearchLote: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		//alert("JSON UiReciptSearchLote: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "GetCuentasByFilter";
				_json["module"] = "mod_disidentes";
				_json["table"] = "CON_Cuentas";
				_json["model"] = "Con_cuentas";
				_json["method"] = "api.backend/neocommand";

				//alert("VAR UiReciptSearchLote11111: " + _json);

				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiGetCuentasHistorico: function (_json) {
		//alert("VAR UiReciptSearchLote: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		//alert("JSON UiReciptSearchLote: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "GetCuentasHistoricoByFilter";
				_json["module"] = "mod_disidentes";
				_json["table"] = "CON_Cuentas";
				_json["model"] = "Con_cuentas";
				_json["method"] = "api.backend/neocommand";

				//alert("VAR UiReciptSearchLote11111: " + _json);

				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiGetPlanDeCuentasHistorico: function (_json) {
		//alert("VAR UiReciptSearchLote: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		//alert("JSON UiReciptSearchLote: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "GetPlanDeCuentasHistoricoByFilter";
				_json["module"] = "mod_disidentes";
				_json["table"] = "CON_Cuentas";
				_json["model"] = "Con_cuentas";
				_json["method"] = "api.backend/neocommand";

				//alert("VAR UiReciptSearchLote11111: " + _json);

				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiGetPlanDeCuentas: function (_json) {
		//alert("VAR UiReciptSearchLote: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		//alert("JSON UiReciptSearchLote: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "GetPlanCuentasByFilter";
				_json["module"] = "mod_disidentes";
				_json["table"] = "CON_Cuentas";
				_json["model"] = "Con_cuentas";
				_json["method"] = "api.backend/neocommand";

				//alert("VAR UiReciptSearchLote11111: " + _json);

				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiGetSac_Lotes: function (_json) {
		alert("VAR: " + _json);
		//var json_obj = JSON.parse(_json);
		//alert("json obj" + json_obj);
		alert("JSON: " + JSON.stringify(_json));
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "getCustom";
				_json["module"] = "mod_disidentes";
				_json["table"] = "sac_lotes";
				_json["model"] = "sac_lotes";
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},

/*
 * FIN eventos app para traer datos del backend
 */

	UiGet: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "get";
				_AJAX._waiter = false;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiSave: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "save"; //function
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiOffline: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "offline"; //function
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiOnline: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "online"; //function
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiDelete: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "delete"; //function
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiProcess: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "process"; //function
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiForm: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["method"] = "api.backend/neocommand"; //method
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiBrow: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "brow";
				_json["method"] = "api.backend/neocommand"; //method
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiEdit: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "edit";
				_json["method"] = "api.backend/neocommand"; //method
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiExcel: function (_json) {
		_json["mode"] = "download"; // TOque aca!
		_json["exit"] = "download";
		_json["function"] = "excel";
		_AJAX.forcePost('api.backend/neocommand', '_blank', _AJAX.formatFixedParameters(_json));
	},
	UiMailAll: function (_json) {
		/*_json["mode"] = "download"; // TOque aca!
		_json["exit"] = "download";
		_json["function"] = "processBatchMail";
		_AJAX.forcePost('api.backend/neocommand', '_blank', _AJAX.formatFixedParameters(_json));
		*/
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "processBatchMail";
				_json["method"] = "api.backend/neocommand"; //method
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});

	},
	UiPdf: function (_json) {
		_json["mode"] = "view";
		_json["exit"] = "download";
		_json["function"] = "pdf";
		_AJAX.forcePost('api.backend/neocommand', '_blank', _AJAX.formatFixedParameters(_json));
	},
	UiAuthenticate: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["try"] = "LOCAL";
				//_json["try"] = "LDAP";
				_json["method"] = "api.backend/authenticate"; //method
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) {
					resolve(data);
				}).catch(function (err) {
					reject(err);
				});
			});
	},
	UiReAuthenticate: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["method"] = "api.backend/reAuthenticate"; //method
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiLogged: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["method"] = "api.backend/logged"; //method
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiLogout: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["method"] = "api.backend/logout"; //method
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiMessageRead: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "messageRead";
				_json["module"] = "mod_backend";
				_json["table"] = "messages_attached";
				_json["model"] = "messages_attached";
				_json["method"] = "api.backend/neocommand"; //method
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiMessagesNotification: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["function"] = "notifications";
				_json["module"] = "mod_backend";
				_json["table"] = "messages_attached";
				_json["model"] = "messages_attached";
				_json["method"] = "api.backend/neocommand"; //method
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiSendExternal: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["module"] = "mod_backend";
				_json["table"] = "external";
				_json["model"] = "external";
				_json["method"] = "api.backend/neocommand"; //method
				_AJAX.ExecuteDirect(_json, null).then(function (data) { resolve(data); }).catch(function (err) { reject(err); });
			});
	},
	UiLogGeneral: function (_json) {
		return new Promise(
			function (resolve, reject) {
				_json["method"] = "api.backend/logGeneral";
				_AJAX._waiter = true;
				_AJAX.ExecuteDirect(_json, null).then(function (data) {
					resolve(data);
				}).catch(function (err) {
					reject(err);
				});
			});
	},

	
};
