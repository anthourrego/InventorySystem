let lastFocus = null;
let lastFocusValue = "";

const formatoPesos = new Intl.NumberFormat('es-CO', {
	style: 'currency',
	currency: 'COP',
	minimumFractionDigits: 2
});

$(function(){
	$(document).on("click", ".inputFocusSelect", function(e) {
		e.preventDefault();
    $(this).trigger("select");
  }).on("focus", function(){
    $(this).trigger("select");
  });

	$(document).on("focusin, click", ".lastFocus", function(){
		lastFocus = $(this);
		lastFocusValue = $(this).val().trim();
		if(lastFocusValue == null){
			lastFocusValue = '';
			lastFocus = null;
		}
	});
});

$(document).on('keydown', "input:not(button, [type=search], .flexdatalist-alias,  .dataTables_filter input), select", function (evt) {
	if (evt.keyCode == 13) {
		var fields = $(this).parents('form:eq(0),body').find('input,a,select,button,textarea').filter(':visible:not([disabled])');
		var index = fields.index(this);

		if (index > -1 && (index + 1) < fields.length) {
			if (!fields.eq(index + 1).attr('disabled')) {
				if (fields.eq(index).is('button')) {
					fields.eq(index).click();
				} else {
					setTimeout(function () {
						fields.eq(index + 1).focus();
					}, 0);
				}
			} else {
				var self = this;
				setTimeout(function () {
					$(self).change().focusout();
				}, 0);
			}
		} else if ((index + 1) == fields.length) {
			var self = this;
			setTimeout(function () {
				$(self).change().focusout();
			}, 0);
		}
		return false;
	}
});

document.addEventListener('DOMContentLoaded', function (e) {
  alertify.defaults.theme.ok = "btn btn-primary";
  alertify.defaults.theme.cancel = "btn btn-danger";
  alertify.defaults.theme.input = "form-control";
  alertify.defaults.glossary.ok = '<i class="fas fa-check"></i> Aceptar';
  alertify.defaults.glossary.cancel = '<i class="fas fa-times"></i> Cancelar';

  $(document).on({
    ajaxStart: function() {
      $("#cargando").removeClass('d-none');
    },
    ajaxStop: function() {
      $("#cargando").addClass('d-none');
    },
    ajaxError: function(funcion, request, settings){
      $("#cargando").removeClass('d-none');
      alertify.globalAlert('Error', request.responseText, function(){
        this.destroy();
      });
      console.error(funcion);
      console.error(request);
      console.error(settings);
    }
  });

  window.onerror = function() {
    $("#cargando").addClass('d-none');
  };

  $("#cerrarSesion").click(function (e) {
    e.preventDefault();
    alertify.globalConfirm(`<i class="fas fa-sign-out-alt nav-icon"></i> Cerrar sesión`, '¿Está seguro de cerrar sesión?', function () {
      $.ajax({
        type: "POST",
        url: base_url() + "Home/cerrarSesion",
        cache: false,
        contentType: false,
        dataType: 'json',
        processData: false,
        data: {},
        beforeSend: function () { },
        success: function (data) {
          if (data.success) {
            window.location.href = base_url();
          } else {
            alertify.warning(data.msj);
          }
        },
        error: () => alertify.error("Error al cerrar sesion."),
        complete: function () { }
      });
    }, function () { });
  });

	//Solo deja escribir números
	$(".soloNumeros").keypress(function(e){
		var keynum = window.event ? window.event.keyCode : e.which;
		if ((keynum == 8) || (keynum == 46))
			return true;
			return /\d/.test(String.fromCharCode(keynum));
	})
	
	//Solo permite alfanumerico
	$(".soloLetras").keypress(function(e){
		key = e.keyCode || e.which;
		tecla = String.fromCharCode(key).toLowerCase();
		letras = "abcdefghijklmnopqrstuvwxyz-_1234567890";
		especiales = "8-37-39-46";
	
		tecla_especial = false
		for(var i in especiales){
				 if(key == especiales[i]){
						 tecla_especial = true;
						 break;
				 }
		 }
	
		 if(letras.indexOf(tecla)==-1 && !tecla_especial){
				 return false;
		 }
	});

	$(".soloLetrasEspacio").keypress(function(e){
		key = e.keyCode || e.which;
		tecla = String.fromCharCode(key).toLowerCase();
		letras = "abcdefghijklmnopqrstuvwxyz1234567890 ";
		especiales = "8-37-39-46";
	
		tecla_especial = false
		for(var i in especiales){
				 if(key == especiales[i]){
						 tecla_especial = true;
						 break;
				 }
		 }
	
		 if(letras.indexOf(tecla)==-1 && !tecla_especial){
				 return false;
		 }
	});

	$(".soloLetrasEspacioCaracteres").keypress(function(e){
		key = e.keyCode || e.which;
		tecla = String.fromCharCode(key).toLowerCase();
		letras = "abcdefghijklmnopqrstuvwxyz1234567890 -_#|";
		especiales = "8-37-39-46";
	
		tecla_especial = false
		for(var i in especiales){
				 if(key == especiales[i]){
						 tecla_especial = true;
						 break;
				 }
		 }
	
		 if(letras.indexOf(tecla)==-1 && !tecla_especial){
				 return false;
		 }
	});
	
});

alertify.globalConfirm || alertify.dialog('globalConfirm', function () {

	var autoConfirm = {
		timer: null,
		index: null,
		text: null,
		duration: null,
		task: function (event, self) {
			if (self.isOpen()) {
				self.__internal.buttons[autoConfirm.index].element.innerHTML = autoConfirm.text + ' (&#8207;' + autoConfirm.duration + '&#8207;) ';
				autoConfirm.duration -= 1;
				if (autoConfirm.duration === -1) {
					clearAutoConfirm(self);
					var button = self.__internal.buttons[autoConfirm.index];
					var closeEvent = createCloseEvent(autoConfirm.index, button);

					if (typeof self.callback === 'function') {
						self.callback.apply(self, [closeEvent]);
					}
					//close the dialog.
					if (closeEvent.close !== false) {
						self.close();
					}
				}
			} else {
				clearAutoConfirm(self);
			}
		}
	};

	function clearAutoConfirm(self) {
		if (autoConfirm.timer !== null) {
			clearInterval(autoConfirm.timer);
			autoConfirm.timer = null;
			self.__internal.buttons[autoConfirm.index].element.innerHTML = autoConfirm.text;
		}
	}

	function startAutoConfirm(self, index, duration) {
		clearAutoConfirm(self);
		autoConfirm.duration = duration;
		autoConfirm.index = index;
		autoConfirm.text = self.__internal.buttons[index].element.innerHTML;
		autoConfirm.timer = setInterval(delegate(self, autoConfirm.task), 1000);
		autoConfirm.task(null, self);
	}


	return {
		main: function (_title, _message, _onok, _oncancel) {
			var title, message, onok, oncancel;
			switch (arguments.length) {
			case 1:
				message = _title;
				break;
			case 2:
				message = _title;
				onok = _message;
				break;
			case 3:
				message = _title;
				onok = _message;
				oncancel = _onok;
				break;
			case 4:
				title = _title;
				message = _message;
				onok = _onok;
				oncancel = _oncancel;
				break;
			}
			this.set('title', title);
			this.set('message', message);
			this.set('onok', onok);
			this.set('oncancel', oncancel);
			return this;
		},
		setup: function () {
			return {
				buttons: [
					{
						text: alertify.defaults.glossary.ok,
						key: 13,
						className: alertify.defaults.theme.ok,
					},
					{
						text: alertify.defaults.glossary.cancel,
						key: 27,
						invokeOnClose: true,
						className: alertify.defaults.theme.cancel,
					}
				],
				focus: {
					element: 0,
					select: false
				},
				options: {
					maximizable: false,
					resizable: false
				}
			};
		},
		build: function () {
			//nothing
		},
		prepare: function () {
			//nothing
		},
		setMessage: function (message) {
			this.setContent(message);
		},
		settings: {
			message: null,
			labels: null,
			onok: null,
			oncancel: null,
			defaultFocus: null,
			reverseButtons: null,
		},
		settingUpdated: function (key, oldValue, newValue) {
			switch (key) {
			case 'message':
				this.setMessage(newValue);
				break;
			case 'labels':
				if ('ok' in newValue && this.__internal.buttons[0].element) {
					this.__internal.buttons[0].text = newValue.ok;
					this.__internal.buttons[0].element.innerHTML = newValue.ok;
				}
				if ('cancel' in newValue && this.__internal.buttons[1].element) {
					this.__internal.buttons[1].text = newValue.cancel;
					this.__internal.buttons[1].element.innerHTML = newValue.cancel;
				}
				break;
			case 'reverseButtons':
				if (newValue === true) {
					this.elements.buttons.primary.appendChild(this.__internal.buttons[0].element);
				} else {
					this.elements.buttons.primary.appendChild(this.__internal.buttons[1].element);
				}
				break;
			case 'defaultFocus':
				this.__internal.focus.element = newValue === 'ok' ? 0 : 1;
				break;
			}
		},
		callback: function (closeEvent) {
			clearAutoConfirm(this);
			var returnValue;
			switch (closeEvent.index) {
			case 0:
				if (typeof this.get('onok') === 'function') {
					returnValue = this.get('onok').call(this, closeEvent);
					if (typeof returnValue !== 'undefined') {
						closeEvent.cancel = !returnValue;
					}
				}
				break;
			case 1:
				if (typeof this.get('oncancel') === 'function') {
					returnValue = this.get('oncancel').call(this, closeEvent);
					if (typeof returnValue !== 'undefined') {
						closeEvent.cancel = !returnValue;
					}
				}
				break;
			}
		},
		hooks:{
			onshow: function(){
				this.elements.footer.style.display="block";
				this.elements.header.setAttribute("style", "border: 1px solid #e5e5e5 !important;");
				this.elements.content.setAttribute("style", "padding: 16px 24px 16px 16px !important;");
			}
		},
		autoOk: function (duration) {
			startAutoConfirm(this, 0, duration);
			return this;
		},
		autoCancel: function (duration) {
			startAutoConfirm(this, 1, duration);
			return this;
		}
	};
});

alertify.globalAlert ||  alertify.dialog('globalAlert', function () {
	return {
		main: function (_title, _message, _onok) {
			var title, message, onok;
			switch (arguments.length) {
			case 1:
				message = _title;
				break;
			case 2:
				if (typeof _message === 'function') {
					message = _title;
					onok = _message;
				} else {
					title = _title;
					message = _message;
				}
				break;
			case 3:
				title = _title;
				message = _message;
				onok = _onok;
				break;
			}
			this.set('title', title);
			this.set('message', message);
			this.set('onok', onok);
			return this;
		},
		setup: function () {
			return {
				buttons: [
					{
						text: alertify.defaults.glossary.ok,
						key: 27,
						invokeOnClose: true,
						className: alertify.defaults.theme.ok,
					}
				],
				focus: {
					element: 0,
					select: false
				},
				options: {
					maximizable: false,
					resizable: false
				}
			};
		},
		build: function () {
			// nothing
		},
		prepare: function () {
			//nothing
		},
		setMessage: function (message) {
			this.setContent(message);
		},
		settings: {
			message: undefined,
			onok: undefined,
			label: undefined,
		},
		settingUpdated: function (key, oldValue, newValue) {
			switch (key) {
			case 'message':
				this.setMessage(newValue);
				break;
			case 'label':
				if (this.__internal.buttons[0].element) {
					this.__internal.buttons[0].element.innerHTML = newValue;
				}
				break;
			}
		},
		callback: function (closeEvent) {
			if (typeof this.get('onok') === 'function') {
				var returnValue = this.get('onok').call(this, closeEvent);
				if (typeof returnValue !== 'undefined') {
					closeEvent.cancel = !returnValue;
				}
			}
		},
		hooks:{
			onshow: function(){
				this.elements.footer.style.display="block";
				this.elements.header.setAttribute("style", "border: 1px solid #e5e5e5 !important;");
				this.elements.content.setAttribute("style", "padding: 16px 24px 16px 16px !important;");
			}
		},
	};
});

alertify.busquedaAlert || alertify.dialog('busquedaAlert',function factory(){
	return {
		main:function(content){
			this.setContent(content);
		},
		setup:function(){
			return {
				options:{
					maximizable:false,
					resizable:false,
					padding:false,
					title: 'Búsqueda'
				}
			};
		},
		hooks:{
			onshow: function(){
				busquedaModal = true;
				this.elements.footer.style.display="none";
			},
			onclose:function(){
				if (busquedaModal) {
					lastFocus.val(lastFocusValue).change();
				}
				alertify.busquedaAlert().set({onshow:null});
				$(".ajs-modal").unbind();
				delete alertify.ajaxAlert;
				$("#tblBusqueda").unbind().remove();
				setTimeout(function(){
					alertify.busquedaAlert().destroy();
				},300);
				busquedaModal = false;
			}
		}
	};
});