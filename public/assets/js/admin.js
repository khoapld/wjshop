/*jshint multistr: true */

$(function () {
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

    // Load form validation
    LoadBootstrapValidatorScript(FormValidator);

    //$('.form-control').tooltip();
    LoadSelect2Script(FormSelect2);

    // Add drag-n-drop feature to boxes
    WinMove();

    $(document).on('click', 'a', function () {
        $(this).attr('disabled', true);
    });
    $(document).on('click', 'a[target="_blank"]', function () {
        $(this).attr('disabled', false);
    });

    // submit form
    var formName = [
        'update-config-form',
        'update-username-form', 'update-email-form', 'update-user-form', 'update-password-form',
        'update-product-form',
        'create-group-fb-form', 'feed-fb-form'
    ];
    for (var i = 0; i < formName.length; i++) {
        $('#' + formName[i]).on('submit', function (event) {
            event.preventDefault();
            var $form = $(this);
            SubmitForm($form);
        });
    }
});

//
//  Dynamically load jQuery Select2 plugin
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
//
function LoadBootstrapValidatorScript(callback) {
    if (!$.fn.bootstrapValidator) {
        $.getScript('/plugins/bootstrapvalidator/js/bootstrapValidator.min.js').done(function() {
            $.getScript('/plugins/bootstrapvalidator/js/language/' + locale + '.js', callback);
        });
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
    $('select').select2();
    $('select[id="category_id"]').select2({placeholder: "Select Category"});
}

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
    $.fn.bootstrapValidator.DEFAULT_OPTIONS = $.extend({}, $.fn.bootstrapValidator.DEFAULT_OPTIONS, {
        message: 'The field is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        }
    });

    // Update config form validator
    $('#update-config-form').bootstrapValidator({
        fields: {
            email: {
                validators: {
                    notEmpty: {},
                    emailAddress: {}
                }
            },
            shop_name: {
                validators: {
                    notEmpty: {},
                    stringLength: {max: 255}
                }
            },
            telephone: {
                validators: {
                    notEmpty: {},
                    digits: {},
                    stringLength: {max: 12}
                }
            },
            address: {
                validators: {
                    stringLength: {max: 255}
                }
            },
            fb_url: {
                validators: {
                    uri: {}
                }
            }
        }
    }).on('success.form.bv', function (e, data) {
        e.preventDefault();
    }).on('error.field.bv', function (e, data) {
        data.bv.disableSubmitButtons(false);
    }).on('success.field.bv', function (e, data) {
        data.bv.disableSubmitButtons(false);
    });

    // Update username form validator
    $('#update-username-form').bootstrapValidator({
        fields: {
            username: {
                validators: {
                    notEmpty: {},
                    stringLength: {min: 6, max: 50},
                    regexp: {regexp: /^[a-z0-9]+$/}
                }
            }
        }
    }).on('success.form.bv', function (e) {
        e.preventDefault();
    });

    // Update email form validator
    $('#update-email-form').bootstrapValidator({
        fields: {
            email: {
                validators: {
                    notEmpty: {},
                    emailAddress: {}
                }
            }
        }
    }).on('success.form.bv', function (e) {
        e.preventDefault();
    });

    // Update user info form validator
    $('#update-user-form').bootstrapValidator({
        fields: {
            username: {
                validators: {
                    notEmpty: {},
                    stringLength: {min: 6, max: 50},
                    regexp: {regexp: /^[a-z0-9]+$/}
                }
            },
            email: {
                validators: {
                    notEmpty: {},
                    emailAddress: {}
                }
            },
            full_name: {
                validators: {
                    stringLength: {max: 255}
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
                    digits: {},
                    stringLength: {max: 12}
                }
            },
            address: {
                validators: {
                    stringLength: {max: 255}
                }
            }
        }
    }).on('success.form.bv', function (e) {
        e.preventDefault();
    });

    // Update password form validator
    $('#update-password-form').bootstrapValidator({
        fields: {
            password: {
                validators: {
                    notEmpty: {},
                    stringLength: {min: 8, max: 50},
                    regexp: {regexp: /^[a-zA-Z0-9]+$/},
                    identical: {field: 'confirmPassword'}
                }
            },
            confirm_password: {
                validators: {
                    notEmpty: {},
                    identical: {field: 'password'}
                }
            }
        }
    }).on('success.form.bv', function (e) {
        e.preventDefault();
    });

    // Create category form validator
    $('#create-category-form').bootstrapValidator({
        fields: {
            category_name: {
                validators: {
                    notEmpty: {},
                    stringLength: {max: 255}
                }
            }
        }
    }).on('success.form.bv', function (e, data) {
        e.preventDefault();
    }).on('error.field.bv', function (e, data) {
        data.bv.disableSubmitButtons(false);
    }).on('success.field.bv', function (e, data) {
        data.bv.disableSubmitButtons(false);
    });

    // Create product form validator
    $('#create-product-form').bootstrapValidator({
        fields: {
            category_ids: {
                validators: {
                    notEmpty: {}
                }
            },
            product_name: {
                validators: {
                    notEmpty: {},
                    stringLength: {max: 255}
                }
            },
            product_description: {
                validators: {
                    stringLength: {max: 1024}
                }
            }
        }
    }).on('success.form.bv', function (e, data) {
        e.preventDefault();
    }).on('error.field.bv', function (e, data) {
        data.bv.disableSubmitButtons(false);
    }).on('success.field.bv', function (e, data) {
        data.bv.disableSubmitButtons(false);
    });

    // Update product form validator
    $('#update-product-form').bootstrapValidator({
        fields: {
            'category_ids[]': {
                validators: {
                    notEmpty: {}
                }
            },
            product_name: {
                validators: {
                    notEmpty: {},
                    stringLength: {max: 255}
                }
            },
            product_description: {
                validators: {
                    stringLength: {max: 1024}
                }
            }
        }
    }).on('success.form.bv', function (e, data) {
        e.preventDefault();
    }).on('error.field.bv', function (e, data) {
        data.bv.disableSubmitButtons(false);
    }).on('success.field.bv', function (e, data) {
        data.bv.disableSubmitButtons(false);
    });

    // Feed FB form validator
    $('#feed-fb-form').bootstrapValidator({
        fields: {
            message: {
                validators: {
                    notEmpty: {},
                    stringLength: {max: 10000}
                }
            },
            link: {
                validators: {
                    notEmpty: {},
                    uri: {}
                }
            }
        }
    }).on('success.form.bv', function (e, data) {
        e.preventDefault();
    }).on('error.field.bv', function (e, data) {
        data.bv.disableSubmitButtons(false);
    }).on('success.field.bv', function (e, data) {
        data.bv.disableSubmitButtons(false);
    });
}

/*-------------------------------------------
 Function for Form upload page
 ---------------------------------------------*/
function FormUpload(option) {
    var form = $('#' + option.form);
    $('#' + option.el).fineUploader({
        autoUpload: false,
        multiple: (typeof option.multiple === 'undefined' ? false : true),
        //element: document.getElementById(option.el),
        template: option.template,
        form: {
            element: option.form,
            interceptSubmit: (typeof option.interceptSubmit === 'undefined' ? true : false)
        },
        classes: {
            success: 'alert alert-success',
            fail: 'alert alert-error'
        },
        validation: {
            allowedExtensions: ['jpeg', 'jpg', 'gif', 'png'],
            sizeLimit: 5120000
        },
        showMessage: function (message) {
            if (typeof option.type !== 'undefined' && option.type === 'create-category-photo') {
                var id = form.find('input[name="id"]').val();
                if (id !== '' && message === 'No files to upload.') {
                    formData = form.serialize();
                    url = form.attr('action');
                    var posting = $.post(url, formData);
                    posting.done(function (responseJSON) {
                        if (responseJSON.errors) {
                            var msg = '';
                            $.each(responseJSON.errors, function (index, value) {
                                msg += value + '\n\r';
                            });
                            show_alert_error(msg);
                        } else if (responseJSON.success) {
                            show_alert_success(responseJSON.msg);
                            $('#add-category .box-content').fadeOut();
                            $('#add-category .collapse-link > i').attr('class', 'fa fa-chevron-down');

                            var block = $('#category-list').find('tr#category-' + responseJSON.category.id);
                            block.attr('data-parent-id', responseJSON.category.parent_category_id);
                            block.attr('data-category-name', responseJSON.category.category_name);
                            block.find('td.category_name > a > span').html(responseJSON.category.category_name_display);
                            $('select[name="parent_category_id"]').find('option[value="' + responseJSON.category.id + '"]').text(responseJSON.category.category_name_display);
                            $('#create-category-form').find('div.main-icon > img').attr('src', responseJSON.category.no_image);
                            $('#create-category-form').find('input[name="id"]').val('');

                            resetForm($('#create-category-form'));
                        } else {
                            show_alert_error(responseJSON.error);
                        }
                    });
                } else {
                    show_alert_error(message);
                }
            } else {
                show_alert_error(message);
            }
        },
        request: {
            inputName: option.inputName
        },
        callbacks: {
            onUpload: function () {
                if (typeof option.type !== 'undefined' && option.type === 'create-product-photo') {
                    form.find('textarea[name="product_info"]').val(tinyMCE.activeEditor.getContent());
                }
            },
            onSubmitted: function () {
                form.find('.main-icon').hide();
            },
            onCancel: function () {
                form.find('.main-icon').show();
            },
            onComplete: function (id, name, responseJSON, xhr) {
                if (typeof option.type !== 'undefined' && option.type === 'create-sub-product-photo') {
                    show_alert_success(responseJSON.msg, 500);
                } else {
                    show_alert_success(responseJSON.msg);
                }

                if (responseJSON.errors) {
                    var msg = '';
                    $.each(responseJSON.errors, function (index, value) {
                        msg += value + '\n\r';
                    });
                    show_alert_error(msg);
                } else if (responseJSON.success) {
                    var html = '';
                    if (typeof option.type !== 'undefined' && option.type === 'update-user-icon') {
                        $('div.avatar > img, div.main-icon > img').attr('src', responseJSON.photo_name);
                    } else if (typeof option.type !== 'undefined' && option.type === 'create-category-photo') {
                        $('#add-category .box-content').fadeOut();
                        $('#add-category .collapse-link > i').attr('class', 'fa fa-chevron-down');
                        show_alert_success(responseJSON.msg);
                        if (responseJSON.category.type === 'new') {
                            html = '<tr id="category-' + responseJSON.category.id +
                                    '" data-id="' + responseJSON.category.id +
                                    '" data-parent-id="' + responseJSON.category.parent_category_id +
                                    '" data-category-name="' + responseJSON.category.category_name + '"> \
                                        <td class="category_name"> \
                                            <a href="/admin/product/category/' + responseJSON.category.id + '"> \
                                                <img class="img-rounded" src="' + responseJSON.category.category_photo_display + '"> \
                                                <span>' + responseJSON.category.category_name_display + '</span> \
                                            </a> \
                                        </td> \
                                        <td class="text-center"> \
                                            <div class="toggle-switch-status toggle-switch-primary-status"> \
                                                <label> \
                                                    <input type="checkbox" name="status"> \
                                                    <div class="toggle-switch-inner-status"></div> \
                                                    <div class="toggle-switch-switch-status"><i class="fa fa-check"></i></div> \
                                                </label> \
                                            </div> \
                                        </td> \
                                        <td class="text-center"><button type="button" class="btn btn-danger edit">Edit</button></td> \
                                    </tr>';
                            $('#category-list').append(html);
                            $('select[name="parent_category_id"]').append('<option value="' + responseJSON.category.id + '">' + responseJSON.category.category_name_display + '</option>');
                        } else {
                            var block = $('#category-list').find('tr#category-' + responseJSON.category.id);
                            block.attr('data-parent-id', responseJSON.category.parent_category_id);
                            block.attr('data-category-name', responseJSON.category.category_name);
                            block.find('img').attr('src', responseJSON.category.category_photo_display);
                            block.find('td.category_name > a > span').html(responseJSON.category.category_name_display);
                            $('select[name="parent_category_id"]').find('option[value="' + responseJSON.category.id + '"]').text(responseJSON.category.category_name_display);
                            form.find('div.main-icon > img').attr('src', responseJSON.category.no_image);
                            form.find('input[name="id"]').val('');
                        }
                        resetForm(form);
                    } else if (typeof option.type !== 'undefined' && option.type === 'create-product-photo') {
                        location = '/admin/product/' + responseJSON.product.id;
                    } else if (typeof option.type !== 'undefined' && option.type === 'update-product-photo') {
                        form.find('div.main-icon > img').attr('src', responseJSON.photo_name);
                    } else if (typeof option.type !== 'undefined' && option.type === 'create-sub-product-photo') {
                        html = '<tr id="photo-' + responseJSON.photo_id + '" data-id="' + responseJSON.photo_id + '"> \
                                        <td class="text-center"> \
                                            <img class="img-rounded" src="' + responseJSON.photo_name + '"> \
                                        </td> \
                                        <td class="text-center"><button type="button" class="btn btn-danger delete-btn">Delete</button></td> \
                                    </tr>';
                        $('#sub-photo-list').append(html);
                    }
                } else {
                    show_alert_error(responseJSON.error);
                }
                $('li.qq-file-id-' + id).find('a#qq-cancel-link')[0].click();
            }
        }
    });
}

//
// Helper for run TinyMCE editor with textarea's
//
function TinyMCEStart(elem, mode) {
    var plugins = [];
    var toolbar = '';
    if (mode === 'basic') {
        plugins = [
            'advlist autolink lists link charmap preview anchor',
            'searchreplace visualblocks code',
            'insertdatetime media table contextmenu paste'
        ];
        toolbar = 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | preview';
    }
    tinymce.init({
        selector: elem,
        plugins: plugins,
        toolbar: toolbar
    });
}

//
// Submit Form function
//
function SubmitForm($form) {
    if ($form.attr('id') === 'update-product-form') {
        $form.find('textarea[name="product_info"]').val(tinyMCE.activeEditor.getContent());
    }
    var fName = $form.attr('id'),
            formData = $form.serialize(),
            url = $form.attr('action');
    if (typeof url === 'undefined') {
        url = $form.attr('j_action');
    }
    $form.find('.error').empty();
    $form.find('button').attr('disabled', 'disabled');

    var posting = $.post(url, formData);
    posting.done(function (data) {
        if (data.success) {
            if (fName === 'update-password-form') {
                resetForm($form);
            } else if (fName === 'create-group-fb-form') {
                $form.find('input').val('');
                var html = '<tr data-id="' + data.group.id + '">\
                                <td>' + data.group.name + '</td>\
                                <td class="text-center">\
                                    <button type="button" class="btn btn-danger delete-btn">Delete</button>\
                                </td>\
                            </tr>';
                $('#group-fb-list').prepend(html);
            }
            $form.find('div').removeClass('has-success');
            show_alert_success(data.success);
        } else if (data.error) {
            if (fName === 'create-group-fb-form') {
                $form.find('input').val('');
            }
            show_alert_error(data.error);
        } else if (data.errors) {
            var msg = '';
            $.each(data.errors, function (index, value) {
                $form.find('input[name="' + index + '"]').parents('div.form-group').removeClass('has-success').addClass('has-error');
                $form.find('input[name="' + index + '"]').next().removeClass('glyphicon-ok').addClass('glyphicon-remove');
                msg += value + '\n\r';
            });
            show_alert_error(msg);
        }
        $form.find('button').removeAttr('disabled');
    });
}

function resetForm(form, value) {
    if (typeof value === 'undefined') {
        value = '';
    }
    form.bootstrapValidator('resetForm', true);
    LoadSelect2Script(form.find('select').select2('val', value));
}

function show_alert_success(msg, time) {
    $('#alert div.modal-content').html('<div class="alert alert-success text-center">' + msg + '</div>');
    $('#alert').modal('show');
    if (typeof time === 'undefined') {
        time = 1000;
    }
    setTimeout(function () {
        $('#alert').modal('hide');
    }, time);
}

function show_alert_error(msg, time) {
    $('#alert div.modal-content').html('<div class="alert alert-danger text-center">' + msg + '</div>');
    $('#alert').modal('show');
    if (typeof time === 'undefined') {
        time = 1000;
    }
    setTimeout(function () {
        $('#alert').modal('hide');
    }, time);
}
