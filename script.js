function data_dump_on_mouse_over() {
	this.classList.add('hover');
	event.stopPropagation();
}

function data_dump_on_mouse_out() {
	this.classList.remove('hover');
}

function data_dump_toggle() {
	this.classList.toggle('data_dump_hidden');
	event.stopPropagation();
}
function data_dump_toggle_all() {
	if(this.classList.contains('data_dump_hidden')) {
		this.querySelectorAll('.data_dump_type_array, .data_dump_type_object, .data_dump_type_json, .data_dump_type_xml').forEach(function(div) {
			div.classList.remove('data_dump_hidden');
		});
		this.classList.remove('data_dump_hidden');
	} else {
		var hide = true;
		this.querySelectorAll('.data_dump_type_array, .data_dump_type_object, .data_dump_type_json, .data_dump_type_xml').forEach(function(div) {
			if(div.classList.contains('data_dump_hidden')) {
				hide = false;
				div.classList.remove('data_dump_hidden');
			}
		});
		if(hide) {
			this.classList.add('data_dump_hidden');
		}
	}
	event.stopPropagation();
	event.preventDefault();
}

function data_dump_enable_context_menu() {
	event.stopPropagation();
}

function data_dump_copy() {
	if(typeof navigator.clipboard != 'undefined') {
		navigator.clipboard.writeText(this.textContent);
	} else {
		alert('This functionnality is not available in your browser');
	}
	event.stopPropagation();
}

function data_dump_complex_copy() {
	var d = this.parentElement;
	while((d = d.nextElementSibling) && !d.classList.contains('data_dump_complex_origin'));
	if(d) {
		if(typeof navigator.clipboard != 'undefined') {
			navigator.clipboard.writeText(d.textContent);
		} else {
			alert('This functionnality is not available in your browser');
		}
	}
	event.stopPropagation();
}

function data_dump_init() {
	document.querySelectorAll('.data_dump_parent.data_dump_type_array:not(.data_dump_treated), .data_dump_parent.data_dump_type_object:not(.data_dump_treated), .data_dump_parent.data_dump_type_json:not(.data_dump_treated), .data_dump_parent.data_dump_type_xml:not(.data_dump_treated)').forEach(function(div) {
		div.addEventListener('mouseover', data_dump_on_mouse_over);
		div.addEventListener('mouseout', data_dump_on_mouse_out);
		div.classList.add('data_dump_treated');
		div.addEventListener('click', data_dump_toggle);
		div.addEventListener('contextmenu', data_dump_toggle_all);
	});
	document.querySelectorAll('.data_dump_type_boolean > .data_dump_content:not(.data_dump_treated), .data_dump_type_integer > .data_dump_content:not(.data_dump_treated), .data_dump_type_double > .data_dump_content:not(.data_dump_treated), .data_dump_type_string > .data_dump_content:not(.data_dump_treated), .data_dump_type_resource > .data_dump_content:not(.data_dump_treated), .data_dump_type_NULL > .data_dump_content:not(.data_dump_treated), .data_dump_type_unknown > .data_dump_content:not(.data_dump_treated)').forEach(function(div) {
		div.addEventListener('click', data_dump_copy);
		div.addEventListener('contextmenu', data_dump_enable_context_menu);
		div.classList.add('data_dump_treated');
	});
	document.querySelectorAll('.data_dump_complex_type:not(.data_dump_treated)').forEach(function(div) {
		div.addEventListener('click', data_dump_complex_copy);
		div.addEventListener('contextmenu', data_dump_enable_context_menu);
		div.classList.add('data_dump_treated');
	});
}
