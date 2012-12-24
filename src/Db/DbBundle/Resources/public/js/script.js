document.addEventListener('DOMContentLoaded', init);

function init() {
	initConfirmationForms();
}

function initConfirmationForms() {
	var checks = document.querySelectorAll('form.form-confirmation span > input[type="checkbox"].confirmation');
	for (var i = 0; i < checks.length; i++) {
		form = checks[i].form;
		if (!form._inited) {
			if (!form._checks) {
				form._checks = new Array();
			}
			form.addEventListener('submit', confirmationFormSubmit);
			form._checks.push(checks[i]);
			checks[i].parentNode.style.display = 'none';
			form._inited = true;
		}
	}
}

function confirmationFormSubmit() {
	if (confirm(this.title ? this.title : "Na pewno?")) {
		for (var i = 0; i < this._checks.length; i++) {
			this._checks[i].checked = 'checked';
		}
	}

	return false;
}