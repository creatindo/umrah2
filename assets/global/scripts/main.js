var main = {
    submitKomentar: function(formObj) {
        var formdata = formObj.serialize();
        var btnObj = formObj.find('button[type=submit]');

        $.ajax({
            url: formObj.attr('action'),
            dataType: 'json',
            data: formdata,
            method: 'POST',
            beforeSend: function (e) {
                btnObj.button('loading');
            },
            error: function (e) {
                console.log(e);
                btnObj.button('reset');
                main.alertMessage('Oops!', 'Maaf, telah terjadi kesalahan.', 'error');
            },
            success: function(response) {
                main.checkAuth(response);

                console.log(response);
                btnObj.button('reset');
                if (response.success == true) {
                    main.alertMessage('Sukses!', response.message, 'success', {
                        'onHidden': function() {
                            location.reload();
                        }
                    });
                    main.resetForm(formObj);
                } else {
                    main.alertMessage('Peringatan!', response.message, 'error');
                }
            }
        });
    },
    submitLogin: function (formObj) {
        var formdata = formObj.serialize();
        var btnObj = formObj.find('button[type=submit]');

        $.ajax({
            url: formObj.attr('action'),
            dataType: 'json',
            data: formdata,
            method: 'POST',
            beforeSend: function (e) {
                btnObj.button('loading');
            },
            error: function (e) {
                console.log(e);
                btnObj.button('reset');
                main.alertMessage('Oops!', 'Maaf, telah terjadi kesalahan.', 'error');
            },
            success: function(response) {
                console.log(response);
                if (response.success == true) {
                    location.href = response.last_url;
                } else {
                    btnObj.button('reset');
                    main.alertMessage('Error!', response.message, 'error');
                }
            }
        });
    },
    checkAuth: function(response) {
        if (response.relogin != null) {
            $('#modal_login').modal('show');
        }
    },
    submitRating: function(formObj) {
        var formdata = formObj.serialize();
        var btnObj = formObj.find('button[type=submit]');

        $.ajax({
            url: formObj.attr('action'),
            dataType: 'json',
            data: formdata,
            method: 'POST',
            beforeSend: function (e) {
                btnObj.button('loading');
            },
            error: function (e) {
                console.log(e);
                btnObj.button('reset');
                main.alertMessage('Oops!', 'Maaf, telah terjadi kesalahan.', 'error');
            },
            success: function(response) {
                main.checkAuth(response);

                console.log(response);
                btnObj.button('reset');
                if (response.success == true) {
                    main.alertMessage('Sukses!', response.message, 'success', {
                        'onHidden': function() {
                            location.reload();
                        }
                    });
                } else {
                    main.alertMessage('Peringatan!', response.message, 'error');
                }
            }
        });
    },
    alertMessage: function(title, msg, type, options) {
        toastr.options = {
          'closeButton': true,
          'debug': false,
          'positionClass': 'toast-top-right',
          'onclick': null,
          'showDuration': '500',
          'hideDuration': '500',
          'timeOut': '2500',
          'extendedTimeOut': '500',
          'showEasing': 'swing',
          'hideEasing': 'linear',
          'showMethod': 'fadeIn',
          'hideMethod': 'fadeOut'
        }

        if (options != null) {
            $.extend(toastr.options, options);
        }

        // console.log(toastr.options);

        toastr[type](msg, title);
    },
    resetForm: function(formObj) {
        formObj.find('input[type=text], input[type=hidden], textarea, input[type=password]').val('');
    },
    validateForm: function(formObj, rules, submitHandler) {
        var error = $('.alert-danger', formObj);
        var success = $('.alert-success', formObj);
        formObj.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: true, // do not focus the last invalid input
            // ignore: "",  // validate all fields including form hidden input
            rules: rules,
            
            messages: { // custom messages for radio buttons and checkboxes
                    'no_antrian': {
                        required: "Silahkan pilih nomor antrian !",
                    }
                },
            invalidHandler: function (event, validator) { //display error alert on form submit              
                success.hide();
                error.show();
                App.scrollTo(error, -200);
            },
            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-error'); // set error class to the control group
            },
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length) { 
                    error.insertAfter(element.parent());      // radio/checkbox?
                } else if (element.hasClass('select2-hidden-accessible')) {     
                    error.insertAfter(element.next('span'));  // select2
                } else if (element.attr("data-error-container")) { 
                    error.appendTo(element.attr("data-error-container"));
                } else if (element.parents('.radio-list').size() > 0) { 
                    error.appendTo(element.parents('.radio-list').attr("data-error-container"));
                } else if (element.parents('.radio-inline').size() > 0) { 
                    error.appendTo(element.parents('.radio-inline').attr("data-error-container"));
                } else if (element.parents('.checkbox-list').size() > 0) {
                    error.appendTo(element.parents('.checkbox-list').attr("data-error-container"));
                } else if (element.parents('.checkbox-inline').size() > 0) { 
                    error.appendTo(element.parents('.checkbox-inline').attr("data-error-container"));
                } else {                                      
                    error.insertAfter(element);               // default
                }
            },
            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-error'); // set error class to the control group
            },
            success: function (label) {
                label
                    .closest('.form-group').removeClass('has-error'); // set success class to the control group
            },
            submitHandler: function(form) {
                error.hide();
                if (typeof submitHandler === "function") { 
                   submitHandler(formObj);
                }
                // submitHandler(formObj)
            }
        });
    },
    pesanOnline: function(layanaDetailId) {
        // $('#modal_pesan').modal('show');
        $.ajax({
            url: siteUrl + '/reservasi/layanan_detail/' + layanaDetailId,
            method: 'GET',
            beforeSend: function (e) {},
            error: function (e) {
                console.log(e);
                main.alertMessage('Peringatan!', 'Maaf, telah terjadi kesalahan.', 'error');
            },
            success: function(response) {
                // console.log(response);
                if (response.indexOf('relogin') >= 0) {
                    var resp = $.parseJSON(response);

                    $('#modal_pesan').modal('hide');
                    main.checkAuth(resp);
                    main.alertMessage('Peringatan!', resp.message, 'error');
                } else {
                    $('#modal_pesan .modal-content').html(response);
                }
            }
        });
    },

    submitAjax: function(formObj,options,extend_data) {
        var formData = formObj.serialize();
        var btnObj = formObj.find('button[type=submit]');

        //add data
        if (typeof extend_data !== 'undefined') {
            formData += extend_data;
        }

        // default settings
        options = $.extend(true, {
            url: formObj.attr('action'),
            dataType: "json",
            data: formData,
            type: "post",
            beforeSend: function (e) {
                btnObj.button('loading');
            },
            error: function (e) {
                // console.log(e);
                main.alertMessage('Oops!', 'Maaf, telah terjadi kesalahan.', 'error');
            },
            success: function(response) {
                console.log(response);
                if (response.success == true) {
                    main.alertMessage('Sukses!', response.message, 'success', {
                        'timeOut': 5000,
                        'onHidden': function() {
                            if (response.hasOwnProperty('url')) {
                                location.href = response.url
                            }
                        }
                    });
                    if (response.reset == true) {
                        main.resetForm(formObj);
                    }
                } else {
                    
                    main.alertMessage('Peringatan!', response.message, 'error');
                }
            },
            complete:function (e) {
                btnObj.button('reset');
            }
        }, options);
    
        $.ajax(
            options
        );
    },

    submitAjaxModal: function(formObj,options={}) {

        var btnObj = formObj.find('button[type=submit]');

        if(formObj.attr('enctype')=="multipart/form-data"){
            var formData = new FormData(formObj[0]);
            options['cache'] = false;
            options['contentType'] = false;
            options['processData'] = false; 
        }else{
            var formData = formObj.serialize();
        }
        // console.log(formData);

        $(".help-block-error" , formObj).remove();
        $(".form-group" , formObj).removeClass('has-error');
        // default settings
        options = $.extend(true, {
            url: formObj.attr('action'),
            dataType: "json",
            data: formData,
            type: "post",
            
            beforeSend: function (e) {
                btnObj.button('loading');
            },
            error: function (e) {
                // console.log(e);
                main.alertMessage('Oops!', 'Maaf, telah terjadi kesalahan.', 'error');
            },
            success: function(response) {
                // console.log(response);
                if (response.success == true) {
                    main.alertMessage('Sukses!', response.message, 'success', {
                        'timeOut': 1000,
                        'onHidden': function() {
                            if (response.hasOwnProperty('url')) {
                                location.href = response.url
                            }
                        }
                    });
                    if (response.reset == true) {
                        main.resetForm(formObj);
                    }
                    // if (typeof options._dataTable !== 'undefined') {
                    //     options._dataTable.getDataTable().ajax.reload();
                    // }
                    //execute function dengan pengembalian parameter
                    if (options.f_response) {
                        if (typeof options.f_response === "function") { 
                            options.f_response(response);
                        }
                    }
                    // execute function tanpa respone
                    if (options.f_success) {
                        if (typeof options.f_success === "function") { 
                            options.f_success();
                        }
                    }
                    formObj.parents('.modal').modal('hide');
                    // console.log(formObj);
                } else {
                    if (response.message) {
                        main.alertMessage('Peringatan!', response.message , 'error');
                    }
                    // var field_name = response.message.;
                    if (response.field_error) {
                        $.each(response.field_error, function(k, v) {
                            var element = $("[name='"+k+"']" , formObj);
                            // console.log(element);
                            var error = $("<span/>")   // creates a div element
                                             .addClass("help-block help-block-error")   // add a class
                                             .html(v);

                            element.closest('.form-group').addClass('has-error');
                            // element.closest('.help-block').remove();

                            if (element.parent('.input-group').length) { 
                                error.insertAfter(element.parent());      // radio/checkbox?
                            } else if (element.hasClass('select2-hidden-accessible')) {     
                                error.insertAfter(element.next('span'));  // select2
                            } else {                                      
                                error.insertAfter(element);               // default
                            }
                        });
                    }
                }
            },
            complete:function (e) {
                btnObj.button('reset');
            }
        }, options);
    
        $.ajax(
            options
        );
    },

    dropdownAjax: function(targetObj,send_data,url) {
        targetObj.html("<option value='' >Loading...</option>");
        targetObj.select2("val", "");
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: send_data,
            beforeSend: function (e) {
                targetObj.prop("disabled", true);
            }
        })
        .done(function(response) {
            console.log("success");
            if(response){
                if (response.length > 0 ) {
                    targetObj.html("<option value='' >Pilih</option>");
                    
                    for(i=0;i<response.length;i++){
                        var option = "<option value='"+response[i]['id']+"' ";
                        option += " >"+response[i]['nama']+"</option>";
                        targetObj.append(option);
                    }
                    targetObj.prop("disabled", false);
                }else{
                    targetObj.html("<option value='' >Tidak ada data</option>");
                }
                targetObj.select2("val", "");
            }
        })
        .fail(function(response) {
            console.log('error');
            // main.alertMessage('Oops!', response.message, 'warning');
        })
        .always(function() {
            // console.log("complete");
        });
        
    },
    simpleDatatable: function (options) {
        var TableDatatablesAjax = function (options) {
            var grid = new Datatable();
            grid.init({
                src: options.src,
                dataTable: {  
                    "ajax": {
                        "url": options.url, // ajax source
                    },
                    "order": [
                        [1, "asc"]
                    ]// set first column as a default sort by asc
                }
            });
        }
        jQuery(document).ready(function() {
           TableDatatablesAjax(options);
        });
    },

    loadPage: function (el,url) {
        el.html("");
        App.blockUI({
            target: el,
            // boxed: true,
            // overlayColor: 'none',
            animate: true
        });
        setTimeout(function(){
            el.load(url,function(result){
                // App.unblockUI(el);
            });
        }, 500);
    },

};

jQuery(document).ready(function() {

});


