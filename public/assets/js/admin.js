$(function () {

    // submit form
    var formName = [
        'update-username-form', 'update-email-form', 'update-user-form', 'update-password-form'
    ];
    for (var i = 0; i < formName.length; i++) {
        $('#' + formName[i]).on('submit', function (event) {
            event.preventDefault();
            var $form = $(this);
            SubmitForm($form);
        });
    }

    var height = window.innerHeight - 49;
    $('#main').css('min-height', height)
            .on('click', '.expand-link', function (e) {
                var body = $('body');
                e.preventDefault();
                var box = $(this).closest('div.box');
                var button = $(this).find('i');
                button.toggleClass('fa-expand').toggleClass('fa-compress');
                box.toggleClass('expanded');
                body.toggleClass('body-expanded');
                var timeout = 0;
                if (body.hasClass('body-expanded')) {
                    timeout = 100;
                }
                setTimeout(function () {
                    box.toggleClass('expanded-padding');
                }, timeout);
                setTimeout(function () {
                    box.resize();
                    box.find('[id^=map-]').resize();
                }, timeout + 50);
            })
            .on('click', '.collapse-link', function (e) {
                e.preventDefault();
                var box = $(this).closest('div.box');
                var button = $(this).find('i');
                var content = box.find('div.box-content');
                content.slideToggle('fast');
                button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
                setTimeout(function () {
                    box.resize();
                    box.find('[id^=map-]').resize();
                }, 50);
            })
            .on('click', '.close-link', function (e) {
                e.preventDefault();
                var content = $(this).closest('div.box');
                content.remove();
            });

    $('.show-sidebar').on('click', function (e) {
        e.preventDefault();
        $('div#main').toggleClass('sidebar-show');
        setTimeout(MessagesMenuWidth, 250);
    });

    // Create Wysiwig editor for textare
    //TinyMCEStart('#wysiwig_simple', null);
    //TinyMCEStart('#wysiwig_full', 'extreme');
    // Add slider for change test input length
    //FormLayoutExampleInputLength($(".slider-style"));
    // Initialize datepicker
    //$('#input_date').datepicker({setDate: new Date()});
    // Load Timepicker plugin
    //LoadTimePickerScript(DemoTimePicker);
    // Add tooltip to form-controls
    //$('.form-control').tooltip();
    LoadSelect2Script(FormSelect2);

    // Load form validation
    LoadBootstrapValidatorScript(FormValidator);

    // Add drag-n-drop feature to boxes
    WinMove();

    // Load and run Uploader
    LoadFineUploader(IconUpload);


});

/*-------------------------------------------
 Function for Icon upload page
 ---------------------------------------------*/
function IconUpload() {
    var uploader = new qq.FineUploader({
        autoUpload: false,
        multiple: false,
        element: document.getElementById('update-icon-uploader'),
        template: 'update-icon-qq-template',
        form: {
            element: 'update-icon-qq-form'
        },
        classes: {
            success: 'alert alert-success',
            fail: 'alert alert-error'
        },
        validation: {
            allowedExtensions: ['jpeg', 'jpg', 'gif', 'png'],
            sizeLimit: 5120000,
            itemLimit: 1
        },
        showMessage: function (message) {
            show_alert_error(message);
        },
        request: {
            inputName: 'user_photo',
            endpoint: '/admin/profile/update_icon'
        },
        callbacks: {
            onSubmitted: function () {
                $('#main-icon').hide();
            },
            onCancel: function () {
                $('#main-icon').show();
            },
            onComplete: function (id, name, responseJSON, xhr) {
                if (responseJSON.success) {
                    $('div.avatar > img, div#main-icon > img').attr('src', responseJSON.photo_name);
                    show_alert_success(responseJSON.error);
                } else {
                    show_alert_error(responseJSON.error);
                }
                $('a#qq-cancel-link')[0].click();
            }
        }
    });
}

//  Dynamically load Widen FineUploader
//  homepage: https://github.com/Widen/fine-uploader  v5.0.1 license - GPL3
//
function LoadFineUploader(callback) {
    if (!$.fn.fineuploader) {
        $.getScript('/plugins/fineuploader/jquery.fineuploader-5.0.1.min.js', callback);
    }
    else {
        if (callback && typeof (callback) === "function") {
            callback();
        }
    }
}

//
//  Dynamically load jQuery Select2 plugin
//  homepage: https://github.com/ivaynberg/select2  v3.4.5  license - GPL2
//
function LoadSelect2Script(callback) {
    if (!$.fn.select2) {
        $.getScript('/plugins/select2/select2.min.js', callback);
    }
    else {
        if (callback && typeof (callback) === "function") {
            callback();
        }
    }
}

//
//  Dynamically load Bootstrap Validator Plugin
//  homepage: https://github.com/nghuuphuoc/bootstrapvalidator
//
function LoadBootstrapValidatorScript(callback) {
    if (!$.fn.bootstrapValidator) {
        $.getScript('/plugins/bootstrapvalidator/js/bootstrapValidator.min.js', callback);
    }
    else {
        if (callback && typeof (callback) === "function") {
            callback();
        }
    }
}

//
//  Helper for correct size of Messages page
//
function MessagesMenuWidth() {
    var W = window.innerWidth;
    var W_menu = $('#sidebar-left').outerWidth();
    var w_messages = (W - W_menu) * 16.666666666666664 / 100;
    $('#messages-menu').width(w_messages);
}

// Run Select2 plugin on elements
function FormSelect2() {
    //$('#s2_group').select2({placeholder: "Select Group"});
    $('#s2_group').select2();
    $('#s2_gender').select2();
    $('#s2_year').select2({placeholder: 'Year'});
    $('#s2_month').select2({placeholder: 'Month'});
    $('#s2_day').select2({placeholder: 'Day'});
}

// Run timepicker
//function DemoTimePicker() {
//    $('#input_time').timepicker({setDate: new Date()});
//}

//
//  Function maked all .box selector is draggable, to disable for concrete element add class .no-drop
//
function WinMove() {
    $('div.box').not('.no-drop')
            .draggable({
                revert: true,
                zIndex: 2000,
                cursor: "crosshair",
                handle: '.box-name',
                opacity: 0.8
            })
            .droppable({
                tolerance: 'pointer',
                drop: function (event, ui) {
                    var draggable = ui.draggable;
                    var droppable = $(this);
                    var dragPos = draggable.position();
                    var dropPos = droppable.position();
                    draggable.swap(droppable);
                    setTimeout(function () {
                        var dropmap = droppable.find('[id^=map-]');
                        var dragmap = draggable.find('[id^=map-]');
                        if (dragmap.length > 0 || dropmap.length > 0) {
                            dragmap.resize();
                            dropmap.resize();
                        }
                        else {
                            draggable.resize();
                            droppable.resize();
                        }
                    }, 50);
                    setTimeout(function () {
                        draggable.find('[id^=map-]').resize();
                        droppable.find('[id^=map-]').resize();
                    }, 250);
                }
            });
}
//
// Swap 2 elements on page. Used by WinMove function
//
jQuery.fn.swap = function (b) {
    b = jQuery(b)[0];
    var a = this[0];
    var t = a.parentNode.insertBefore(document.createTextNode(''), a);
    b.parentNode.insertBefore(a, b);
    t.parentNode.insertBefore(b, t);
    t.parentNode.removeChild(t);
    return this;
};

//
// form validator function
//
function FormValidator() {
    $('#update-username-form').bootstrapValidator({
        message: 'This value is not valid',
        fields: {
            username: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'The username is required and can\'t be empty'
                    },
                    stringLength: {
                        min: 6,
                        max: 50,
                        message: 'The username must be more than 6 and less than 50 characters long'
                    },
                    regexp: {
                        regexp: /^[a-z0-9]+$/,
                        message: 'The username can only consist of alphabetical, number'
                    }
                }
            }
        }
    });
    $('#update-email-form').bootstrapValidator({
        message: 'This value is not valid',
        fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required and can\'t be empty'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            }
        }
    });
    $('#update-user-form').bootstrapValidator({
        message: 'This value is not valid',
        fields: {
            username: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'The username is required and can\'t be empty'
                    },
                    stringLength: {
                        min: 6,
                        max: 50,
                        message: 'The username must be more than 6 and less than 50 characters long'
                    },
                    regexp: {
                        regexp: /^[a-z0-9]+$/,
                        message: 'The username can only consist of alphabetical, number'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'The email address is required and can\'t be empty'
                    },
                    emailAddress: {
                        message: 'The input is not a valid email address'
                    }
                }
            },
            full_name: {
                message: 'The full name is not valid',
                validators: {
                    stringLength: {
                        max: 255,
                        message: 'The full name must be less than 255 characters long'
                    }
                }
            },
            birthday: {
                validators: {
                    date: {
                        format: 'YYYY/MM/DD',
                        separator: '/'
                    }
                }
            },
            telephone: {
                validators: {
                    digits: {
                        message: 'The value can contain only digits'
                    },
                    stringLength: {
                        max: 12,
                        message: 'The telephone must be less than 12 characters long'
                    }
                }
            },
            address: {
                message: 'The address is not valid',
                validators: {
                    stringLength: {
                        max: 255,
                        message: 'The address must be less than 255 characters long'
                    }
                }
            }
        }
    });
    $('#update-password-form').bootstrapValidator({
        message: 'This value is not valid',
        fields: {
            password: {
                validators: {
                    notEmpty: {
                        message: 'The password is required and can\'t be empty'
                    },
                    stringLength: {
                        min: 8,
                        max: 50,
                        message: 'The password must be more than 8 and less than 50 characters long'
                    },
                    regexp: {
                        regexp: /^[a-zA-Z0-9]+$/,
                        message: 'The password can only consist of alphabetical, number'
                    },
                    identical: {
                        field: 'confirmPassword',
                        message: 'The password and its confirm are not the same'
                    }
                }
            },
            confirm_password: {
                validators: {
                    notEmpty: {
                        message: 'The confirm password is required and can\'t be empty'
                    },
                    identical: {
                        field: 'password',
                        message: 'The password and its confirm are not the same'
                    }
                }
            }
        }
    });
}

//
// Submit Form function
//
function SubmitForm($form) {
    var $form = $form,
            fName = $form.attr('id'),
            formData = $form.serialize(),
            url = $form.attr('action');
    if (typeof url === 'undefined') {
        url = $form.attr('j_action');
    }
    $form.find('.error').empty();
    $form.find('button').attr('disabled', 'disabled');
    if (fName === 'change-icon-photo-form') {
        $('#' + fName).ajaxSubmit({
            url: url,
            complete: function (xhr) {
                $form.find('button').removeAttr('disabled');
            }
        });
    } else {
        var posting = $.post(url, formData);
        posting.done(function (data) {
            if (data.success) {
                if (fName === 'update-password-form') {
                    $form.find('input').val('');
                }
                $form.find('div').removeClass('has-success');
                show_alert_success(data.success);
            } else if (data.errors) {
                var msg = '';
                $.each(data.errors, function (index, value) {
                    $form.find('input[name="' + index + '"]').parents('div.form-group').removeClass('has-success').addClass('has-error');
                    msg += value + '\n\r';
                });
                show_alert_error(msg);
            }
            $form.find('button').removeAttr('disabled');
        });
    }

}

function show_alert_success(msg) {
    $('#alert').modal('show');
    $('#alert').on('shown.bs.modal', function () {
        $('#alert div.modal-content').html('<div class="alert alert-success text-center">' + msg + '</div>');
    });
    $('#alert').on('hidden.bs.modal', function () {
        $('#alert div.modal-content').html('');
    });
}

function show_alert_error(msg) {
    $('#alert').modal('show');
    $('#alert').on('shown.bs.modal', function () {
        $('#alert div.modal-content').html('<div class="alert alert-danger text-center">' + msg + '</div>');
    });
    $('#alert').on('hidden.bs.modal', function () {
        $('#alert div.modal-content').html('');
    });
}

