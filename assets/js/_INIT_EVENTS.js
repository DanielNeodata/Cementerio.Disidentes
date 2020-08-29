(function () {
	var today = new Date();
	$.getScript("./assets/js/AJAX.js?" + today.toDateString()).done(function (script, textStatus) {
		$.getScript("./assets/js/TOOLS.js?" + today.toDateString()).done(function (script, textStatus) {
			$.getScript("./assets/js/FUNCTIONS.js?" + _TOOLS.UUID()).done(function (script, textStatus) {
				moment().tz("America/Argentina/Buenos_Aires").format();
				window.addEventListener("dragover", function (e) { e = e || event; e.preventDefault(); }, false);
				window.addEventListener("drop", function (e) { e = e || event; e.preventDefault(); }, false);

				//$(document).off("keyup keypress").on("keyup keypress", function (e) {
				//	var keyCode = (e.keyCode || e.which);
				//	if (keyCode === 13) { e.preventDefault(); return false; }
				//});
				//$("body").off("keyup", ".textarea").on("keyup", ".textarea", function (e) {
				//	var keyCode = (e.keyCode || e.which);
				//	if (keyCode === 13) {
				//		$(this).val($(this).val() + "\r\n");
				//		e.preventDefault();
				//		return true;
				//	}
				//});

				$("body").off("keyup", ".search-trigger").on("keyup", ".search-trigger", function (e) {
					var keyCode = (e.keyCode || e.which);
					if (keyCode === 13) { _FUNCTIONS.onBrowserSearch($(".btn-browser-search")); }
				});
				$("body").off("change", ".search-trigger").on("change", ".search-trigger", function () {
					if ($(this).is("select") === true) { _FUNCTIONS.onBrowserSearch($(".btn-browser-search")); }
				});
				$("body").off("click", ".btn-login").on("click", ".btn-login", function () {
					_FUNCTIONS.onLogin($(this)).then(function (data) { _AJAX.UiLogged({}); });
				});
				$("body").off("click", ".btn-logout").on("click", ".btn-logout", function () {
					_FUNCTIONS.onLogout($(this));
				});
				$("body").off("click", ".btn-menu-open").on("click", ".btn-menu-open", function (e) {
					_FUNCTIONS.onMenuOpen($(this), e);
				});
				$("body").off("click", ".btn-menu-close").on("click", ".btn-menu-close", function (e) {
					_FUNCTIONS.onMenuClose($(this), e);
				});
				$("body").off("click", ".btn-menu-click").on("click", ".btn-menu-click", function (e) {
					_FUNCTIONS.onMenuClick($(this));
				});
				$("body").off("click", ".btn-record-edit").on("click", ".btn-record-edit", function (e) {
					_FUNCTIONS.onRecordEdit($(this));
				});
				$("body").off("click", ".btn-check-paycode").on("click", ".btn-check-paycode", function (e) {
					_FUNCTIONS.onCheckPaycode($(this));
				});
				$("body").off("click", ".btn-record-remove").on("click", ".btn-record-remove", function (e) {
					_FUNCTIONS.onRecordRemove($(this));
				});
				$("body").off("click", ".btn-record-offline").on("click", ".btn-record-offline", function (e) {
					_FUNCTIONS.onRecordOffline($(this));
				});
				$("body").off("click", ".btn-record-online").on("click", ".btn-record-online", function (e) {
					_FUNCTIONS.onRecordOnline($(this));
				});
				$("body").off("click", ".btn-record-process").on("click", ".btn-record-process", function (e) {
					_FUNCTIONS.onRecordProcess($(this));
				});
				$("body").off("click", ".btn-abm-accept").on("click", ".btn-abm-accept", function (e) {
					_FUNCTIONS.onAbmAccept($(this));
				});
				$("body").off("click", ".btn-abm-cancel").on("click", ".btn-abm-cancel", function (e) {
					_FUNCTIONS.onAbmCancel($(this));
				});
				$("body").off("click", ".btn-browser-search").on("click", ".btn-browser-search", function (e) {
					_FUNCTIONS.onBrowserSearch($(this));
				});
				$("body").off("click", ".btn-brief").on("click", ".btn-brief", function (e) {
					_FUNCTIONS.onBriefModal($(this));
				});
				$("body").off("click", ".btn-verify-signs").on("click", ".btn-verify-signs", function (e) {
					_FUNCTIONS.onVerifySigns($(this));
				});
				$("body").off("click", ".btn-close-modal").on("click", ".btn-close-modal", function (e) {
					$($(this).attr("data-click")).click();
					_FUNCTIONS.onDestroyModal(".modal");
				});
				$("body").off("click", ".btn-upload").on("click", ".btn-upload", function (e) {
					$($(this).attr("data-click")).click();
				});
				$("body").off("click", ".btn-upload-reset").on("click", ".btn-upload-reset", function (e) {
					_FUNCTIONS.onResetSelectedFile($(this));
				});
				$("body").off("click", ".btn-upload-delete").on("click", ".btn-upload-delete", function (e) {
					_FUNCTIONS.onDeleteSelectedFile($(this));
				});
				$("body").off("change", ".btn-pick-files-image").on("change", ".btn-pick-files-image", function (e) {
					_FUNCTIONS.onProcessSelectedFiles($(this));
				});
				$("body").off("change", ".btn-pick-files-image_apaisada").on("change", ".btn-pick-files-image_apaisada", function (e) {
					_FUNCTIONS.onProcessSelectedFiles($(this));
				});
				$("body").off("change", ".btn-folders-files-folders").on("change", ".btn-folders-files-folders", function (e) {
					_FUNCTIONS.onProcessSelectedFilesFolders($(this));
				});
				$("body").off("change", ".id_type_command").on("change", ".id_type_command", function (e) {
					_FUNCTIONS.onTypeCommandChange($(this));
				});
				$("body").off("click", ".btn-message-external").on("click", ".btn-message-external", function (e) {
					_FUNCTIONS.onFolderMessagesModal($(this));
				});
				$("body").off("click", ".btn-message-read").on("click", ".btn-message-read", function (e) {
					_FUNCTIONS.onMessageRead($(this));
				});
				$("body").off("click", ".btn-record-check").on("click", ".btn-record-check", function (e) {
					_FUNCTIONS.onCheckRecord($(this));
				});
				$("body").off("click", ".btn-external-link").on("click", ".btn-external-link", function () {
					_FUNCTIONS.onAddLinkExternal($(this));
				});
			});
		});
	});
})();

