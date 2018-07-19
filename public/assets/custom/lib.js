/**
 |---------------------------------------------------------------------
 | Main application helper
 |---------------------------------------------------------------------
 |
 */

String.prototype.getFileExtension = function() {
    return /(?:\.([^.]+))?$/.exec(this.toString())[1];
}

Number.prototype.getFileExtension = Number.prototype.getFileSizeFormatted = function(decimals) {
    bytes = this.toString();
    if(bytes == 0) return '0 Byte';
    var k = 1024;
    var dm = decimals + 1 || 1;
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
    var i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
}

var App = function() {

    var self = this, debug = true, instanceOfDialogFrame;

    this.init = function () {

        // init on load
        this.initSwitch();

        // Overriding jQuery.validation method
        if ( typeof $.validator !== 'undefined' )
        {
            $.validator.methods.email = function (value, element) {
                return this.optional(element) || /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
            }
        }
    }

    this.url = function( path ) {
        if ( typeof path === 'undefined' )
            path = '';
        var u = $('body').data('url');
        u = u.substr( u.length - 1) == '/' ? u : u + "/";
        path = path && path.substr(0,1) == '/' ? path.substr(1, path.length) : path;
        return u + path;
    }

    this.assetUrl = function (path) {
        if (typeof path === 'undefined')
            path = '';
        var u = $('body').data('assets-url');
        // console.log(u, path);
        u = u && u.substr(u.length - 1) == '/' ? u : u + "/";
        path = path && path.substr(0, 1) == '/' ? path.substr(1, path.length) : path;
        return u + path;
    }

    this.visit = function (url) {
        location.href = url;
    }

    this.back = function () {
        if (typeof document.referrer == 'undefined' || !document.referrer) {
            window.history.go(-1);
        }
        else {
            window.location.href = document.referrer;
        }
    }

    this.cookie = function (name) {
        var value = "; " + document.cookie;
        var parts = value.split("; " + name + "=");
        if (parts.length == 2) return parts.pop().split(";").shift();
    }

    this.logDebug = function (data) {
        if (typeof console !== 'undefined' && console.log && self.debug) {
            console.info(data);
        }
    }

    this.logError = function (data) {
        if (typeof console !== 'undefined' && console.log) {
            console.error(data);
        }
    }

    this.ajax = function (url, method, data, onSuccess, onError, beforeSend, onComplete, inlineElement) {
        var assestUrl = this.assetUrl('/assets/custom/img/hourglass.gif');
        jQuery.ajaxSetup({
            headers: {
                'X-XSRF-Token': $('meta[name="_token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: url,
            type: method,
            data: data,
            dataType: 'json',
            beforeSend: function (jqXHR, settings) {
                
                self.blockUI();
                
                if (typeof beforeSend != 'undefined' && typeof beforeSend == 'function') {
                    beforeSend(jqXHR, settings);
                }
            },
            complete: function (jqXHR, textStatus) {
                
                self.unblockUI();
                
                if (typeof onComplete != 'undefined' && typeof onComplete == 'function') {
                    onComplete(jqXHR, textStatus);
                }
            },
            success: function (data, textStatus, jqXHR) {
                if (typeof onSuccess != 'undefined' && typeof onSuccess == 'function' ) {
                    onSuccess(data, textStatus, jqXHR);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                var response = (json = self.toJSON(jqXHR.responseText, true)) ? json : jqXHR.responseText;
                var error = {
                    'status': textStatus,
                    'message': errorThrown,
                    'response': response,
                    'jsonType': typeof response == 'object'
                };
                if (typeof onError != 'undefined' && typeof onError == 'function' ) {
                     onError(error, jqXHR, textStatus, errorThrown);
                }
            }
        });
    }

    this.toJSON = function( data, onErrorLogError ) {
        try {
            return $.parseJSON(data);
        } catch(e) {
            if ( typeof onErrorLogError !== 'undefined' && onErrorLogError )
                return false;
            self.logError({'error': "Unable to parse data into JSON format.", 'data': data} );
        }
        return false;
    }

    this.hideAlert = function( context ) {
        var $alert;
        if ( typeof context !== 'undefined' )
            $alert = $('.alert', context);
        else
            $alert = $('.alert');
        $alert.fadeOut();
    }

    /**
     ** Show alert message
     *
     * @param container
     * @param type "danger", "warning", "success", "info"
     * @param message
     * @param dismisable
     * @param dismissTime
     */
    this.showAlert = function( container, type, message, dismisable, dismissTime ) {
        container = container ? container : ".alert-container";
        var $container = $( container );
        dismisable = typeof dismisable == 'undefined' ? true : dismisable;
        dismissTime = typeof dismissTime != 'undefined' && dismissTime > 0 ? dismissTime : false;
        var dismisable_div = dismisable ? ' alert-dismissable' : '';
        var dismisable_button = dismisable ? ' alert-dismissable' : '';
        var heading = "";
        switch(type) {
            case 'danger': heading = '<i class="fa-lg fa fa-exclamation-triangle" style="display:inline-block;vertical-align: top; margin-top: 4px;"></i>'; break;
            case 'warning': heading = '<i class="fa-lg fa fa-warning" style="display:inline-block;vertical-align: top; margin-top: 4px;"></i>'; break;
            case 'success': heading = '<i class="fa-lg fa fa-check" style="display:inline-block;vertical-align: top; margin-top: 4px;"></i>'; break;
            case 'info': heading = '<i class="fa-lg fa fa-info-circle" style="display:inline-block;vertical-align: top; margin-top: 4px;"></i>'; break;
            default: heading = "";
        }

        // building html
        var  html = '<div class="alert alert-' + type + ( dismisable ? ' alert-dismissable' : '') + '">';
        if ( dismisable ) {
            html += '<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>';
        }
        html += '<strong>' + heading + '</strong> ' + message + '</div>';

        // populating
        if ($container.find(".alert").length == 0) {
            $(html).hide().appendTo($container).fadeIn('fast');
        } else {
            $container.find(".alert").fadeOut('fast', function () {
                $container.html("");
                $(html).hide().appendTo($container).fadeIn('fast');
            });
        }

        if ( dismissTime ) {
            setTimeout(function(){
                $(container).fadeOut('fast');
            }, dismissTime);
        }
    }

    this.validate = function(formElement, options) {
        formElement = typeof formElement === 'object' ? formElement : $(formElement);
        options = $.extend(true, {
            errorElement: 'span',
            errorClass: 'help-block error-help-block',
            focusInvalid: false,
            ignore: [],
            invalidHandler: function(event, validator) {
                this.showAlert(null, 'danger', 'The form has some errors. Please correct them and try again.');
                //console.log( validator.numberOfInvalids() );
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            success: function (label, element) {
                $(element).closest('.form-group').removeClass('has-error'); //.addClass('has-success');
            },
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length || element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                this.hideAlert();
                form.submit();
            }
        }, options);

        $.validator.methods.email = function (value, element) {
            return this.optional(element) || /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(value);
        }
        formElement.validate(options);
    }

    this.confirm = function ( message, onYes, onNo, labelYes, labelNo ) {
        message = typeof message == 'undefined' || message == "" ? 'Are you sure?' : message;
        labelYes = typeof labelYes == 'undefined' || labelYes == "" ? 'Yes' : labelYes;
        labelNo = typeof labelNo == 'undefined' || labelNo == "" ? 'No' : labelNo;
        // event = typeof event == 'undefined' ? false : $(event);
        
            var el = document.createElement('span'),
            t = document.createTextNode(message);
            el.style.cssText = 'color:#F6BB42';
            el.appendChild(t);

            swal({
                title: "Confirm",
                content: {
                    element: el,
                },
                // text: message,
                icon: "warning",
                buttons: {
                    cancel: {
                        text: labelNo,
                        value: null,
                        visible: true,
                        className: "",
                        closeModal: false,
                    },
                    confirm: {
                        text: labelYes,
                        value: true,
                        visible: true,
                        className: "",
                        closeModal: false
                    }
                }
            }).then(isConfirm => {
                if (isConfirm) {
                    onYes();
                } else {
                    onNo();
                }
            });
    }

    this.select2 = function (element, url_or_data, placeholder, multiple, minimumLength) {
        var options = {
            width: "off",
            ajax: {
                url: url_or_data,
                dataType: 'json',
                delay: 150,
                data: function (params) {
                    return {
                        search: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, page) {
                    // parse the results into the format expected by Select2.
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data
                    return {
                        results: data.items
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) {
                return markup;
            }, // let our custom formatter work
            minimumInputLength: typeof minimumLength == 'undefined' ? 0 : minimumLength,
            templateResult: function (response) {
                return response.name;
            },
            templateSelection: function (response) {
                return response.name || response.text;
            }
        };

        if ( !url_or_data ) {
            delete options.ajax;
        }

        if ( typeof url_or_data === 'object' ) {
            options.data = url_or_data;
        }

        if (placeholder != 'undefined') {
            options.placeholder = placeholder;
        }
        if (multiple != 'undefined') {
            options.multiple = multiple;
            options.tags = true;
        }
        // if (data !== 'undefined') {
        //     options.data = data;
        // }
        jQuery(element).select2(options);
    }

    this.parseErrors = function(errors) {
        var html = "Please correct the following error(s):<br>";
        if (typeof errors === 'object') {
            html += "<ul style='display:inline-block'>";
            for (var i in errors) {
                html += "<li>" + (typeof errors[i] === "string" ? errors[i] : errors[i][0]) + "</li>";
            }
            html += "</ul>";
        }
        else {
            html += errors;
        }
        return html;
    }

    this.alert = function(options) {
        options = $.extend(true, {
            container: "", // alerts parent container(by default placed after the page breadcrumbs)
            place: "append", // "append" or "prepend" in container 
            type: 'success', // alert's type
            message: "", // alert's message
            close: true, // make alert closable
            reset: true, // close all previouse alerts first
            focus: true, // auto scroll to the alert after shown
            closeInSeconds: 0, // auto close after defined seconds
            icon: "" // put icon before the message
        }, options);

        var id = 'prefix_' + Math.floor(Math.random() * (new Date()).getTime());

        var html = '<div id="' + id + '" class="alert alert-' + options.type + ' mb-2">' + (options.close ? '<button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>' : '') + (options.icon !== "" ? '<i class="fa-lg fa fa-' + options.icon + '"></i>  ' : '') + options.message + '</div>';

        if (options.reset) {
            $('.custom-alerts').remove();
        }

        if (!options.container) {
            if ($('body').hasClass("page-container-bg-solid") || $('body').hasClass("page-content-white")) {
                $('.page-title').after(html);
            } else {
                if ($('.page-bar').length > 0) {
                    $('.page-bar').after(html);
                } else {
                    $('.page-breadcrumb').after(html);
                }
            }
        } else {
            if (options.place == "append") {
                $(options.container).append(html);
            } else {
                $(options.container).prepend(html);
            }
        }

        if (options.focus) {
            this.scrollTo($('#' + id));
        }

        if (options.closeInSeconds > 0) {
            setTimeout(function() {
                $('#' + id).remove();
            }, options.closeInSeconds * 1000);
        }

        return id;
    }

    // wrApper function to scroll(focus) to an element
    this.scrollTo = function(el, offeset) {
        var pos = (el && el.length > 0) ? el.offset().top : 0;
        if (el) {
            pos = pos - $('body.scrollTo').height();
            pos = pos + (offeset ? offeset : -1 * el.height());
        }

        $('html,body').animate({
            scrollTop: pos
        }, 'slow');
    }

    this.blockPage = function (message, loader) {
        message = typeof message == 'undefined' || "" ? "" : message;
        if (loader) {
            //$('.ajax-loader').fadeIn();
        }
        $.blockUI({message: message});
    }

    this.unblockPage = function () {
        //$('.ajax-loader').fadeOut();
        $.unblockUI();
    }

    // wrApper function to  block element(indicate loading)
    this.blockUI = function(options) {
        options = $.extend(true, {}, options);
        var html = '';
        if (options.animate) {
            html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '">' + '<div class="block-spinner-bar"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>' + '</div>';
        } else if (options.iconOnly) {
            html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><img src="' + this.getGlobalImgPath() + 'loading-spinner-grey.gif" align=""></div>';
        } else if (options.textOnly) {
            html = '<div class="loading-message ' + (options.boxed ? 'loading-message-boxed' : '') + '"><span>&nbsp;&nbsp;' + (options.message ? options.message : 'LOADING...') + '</span></div>';
        } else {
            html = '<div class="ft-refresh-cw icon-spin font-medium-2"></div>';
        }

        if (options.target) { // element blocking
            var el = $(options.target);
            if (el.height() <= ($(window).height())) {
                options.cenrerY = true;
            }
            el.block({
                message: html,
                baseZ: options.zIndex ? options.zIndex : 1000,
                centerY: options.cenrerY !== undefined ? options.cenrerY : false,
                css: {
                    top: '10%',
                    border: '0',
                    padding: '0',
                    backgroundColor: 'none'
                },
                overlayCSS: {
                    backgroundColor: options.overlayColor ? options.overlayColor : '#555',
                    opacity: options.boxed ? 0.05 : 0.1,
                    cursor: 'wait'
                }
            });
        } else { // page blocking
            $.blockUI({
                message: html,
                baseZ: options.zIndex ? options.zIndex : 1000,
                css: {
                    border: '0',
                    padding: '0',
                    backgroundColor: 'none'
                },
                overlayCSS: {
                    backgroundColor: options.overlayColor ? options.overlayColor : '#555',
                    opacity: options.boxed ? 0.05 : 0.1,
                    cursor: 'wait'
                }
            });
        }
    }

    // wrApper function to  un-block element(finish loading)
    this.unblockUI = function(target) {
        if (target) {
            $(target).unblock({
                onUnblock: function() {
                    $(target).css('position', '');
                    $(target).css('zoom', '');
                }
            });
        } else {
            $.unblockUI();
        }
    }

    this.initSwitch = function(){
        if( $('.switch:checkbox').length )
            $('.switch:checkbox').checkboxpicker();
    }

    this.changeStatus = function(route){
        $(document).on('change', '.status-chkbx', function(e) {
            var $this = $(this);
            var data = { '_id': $this.data('id'),'_model': $this.data('model'),'status': $this.is(':checked') ? 'on' : 'off' };
            console.log(data);
            self.ajax(route, 'POST', data, null, function(res) {
                console.log(res);
                self.showAlert( null, 'danger', res.message);
                $this.prop('checked', !$this.prop('checked'));
            }, null, null, $this.closest('.demo-checkbox'));
        });
    }


}

var app = new App();
app.init();
