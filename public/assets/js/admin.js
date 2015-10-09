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

    // Add slider for change test input length
    //FormLayoutExampleInputLength($(".slider-style"));

    // Initialize datepicker
    //$('#input_date').datepicker({setDate: new Date()});

    // Load Timepicker plugin
    //LoadTimePickerScript(DemoTimePicker);
    // Add tooltip to form-controls

    // Load Datatables and run plugin on tables 
    //LoadDataTablesScripts(DataTable);

    // Load form validation
    LoadBootstrapValidatorScript(FormValidator);

    //$('.form-control').tooltip();
    LoadSelect2Script(FormSelect2);

    // Add drag-n-drop feature to boxes
    WinMove();

    $(document).on('click', 'a', function () {
        $(this).attr('disabled', true);
    });

    // submit form
    var formName = [
        'update-username-form', 'update-email-form', 'update-user-form', 'update-password-form',
        'update-product-form'
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
//  Dynamically load DataTables plugin
//  homepage: http://datatables.net v1.9.4 license - GPL or BSD
//
function LoadDataTablesScripts(callback) {
    function LoadDatatables() {
        $.getScript('/plugins/datatables/jquery.dataTables.js', function () {
            $.getScript('/plugins/datatables/ZeroClipboard.js', function () {
                $.getScript('/plugins/datatables/TableTools.js', function () {
                    $.getScript('/plugins/datatables/dataTables.bootstrap.js', callback);
                });
            });
        });
    }
    if (!$.fn.dataTables) {
        LoadDatatables();
    }
    else {
        if (callback && typeof (callback) === "function") {
            callback();
        }
    }
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
    $('select').select2();
    $('select[id="category_id"]').select2({placeholder: "Select Category"});
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
    $.fn.bootstrapValidator.DEFAULT_OPTIONS = $.extend({}, $.fn.bootstrapValidator.DEFAULT_OPTIONS, {
        message: 'The field is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        }
    });

    // Update username form validator
    $('#update-username-form').bootstrapValidator({
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
    }).on('success.form.bv', function (e) {
        e.preventDefault();
    });

    // Update email form validator
    $('#update-email-form').bootstrapValidator({
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
    }).on('success.form.bv', function (e) {
        e.preventDefault();
    });

    // Update user info form validator
    $('#update-user-form').bootstrapValidator({
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
    }).on('success.form.bv', function (e) {
        e.preventDefault();
    });

    // Update password form validator
    $('#update-password-form').bootstrapValidator({
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
    }).on('success.form.bv', function (e) {
        e.preventDefault();
    });

    // Create category form validator
    $('#create-category-form').bootstrapValidator({
        fields: {
            category_name: {
                message: 'The category name is not valid',
                validators: {
                    notEmpty: {
                        message: 'The category name is required and can\'t be empty'
                    },
                    stringLength: {
                        max: 255,
                        message: 'The product name must be less than 255 characters long'
                    }
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
                message: 'The category is not valid',
                validators: {
                    notEmpty: {
                        message: 'The category is required and can\'t be empty'
                    }
                }
            },
            product_name: {
                message: 'The product name is not valid',
                validators: {
                    notEmpty: {
                        message: 'The product name is required and can\'t be empty'
                    },
                    stringLength: {
                        max: 255,
                        message: 'The product name must be less than 255 characters long'
                    }
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
    $('#update-product-form').bootstrapValidator({
        fields: {
            'category_ids[]': {
                message: 'The category is not valid',
                validators: {
                    notEmpty: {
                        message: 'The category is required and can\'t be empty'
                    }
                }
            },
            product_name: {
                message: 'The product name is not valid',
                validators: {
                    notEmpty: {
                        message: 'The product name is required and can\'t be empty'
                    },
                    stringLength: {
                        max: 255,
                        message: 'The product name must be less than 255 characters long'
                    }
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
 Function for Categpry upload page
 ---------------------------------------------*/
function CategoryUpload() {
    var uploader = new qq.FineUploader({
        autoUpload: false,
        multiple: false,
        element: document.getElementById('category-qq-uploader'),
        template: 'category-qq-template',
        form: {
            element: 'create-category-form'
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
            show_alert_error(message);
        },
        request: {
            inputName: 'category_photo'
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
                    $('#add-category .box-content').fadeOut();
                    $('#add-category .collapse-link > i').attr('class', 'fa fa-chevron-down');
                    show_alert_success(responseJSON.error);
                    if (responseJSON.category.type === 'new') {
                        var html = '<tr id="category-' + responseJSON.category.id +
                                '" data-id="' + responseJSON.category.id +
                                '" data-parent-id="' + responseJSON.category.parent_category_id +
                                '" data-category-name="' + responseJSON.category.category_name + '"> \
                                        <td class="category_name">\n\
                                            <img class="img-rounded" src="' + responseJSON.category.category_photo_display + '"> \
                                            <span>' + responseJSON.category.category_name_display + '</span> \
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
                        block.find('td.category_name > span').html(responseJSON.category.category_name_display);
                        $('select[name="parent_category_id"]').find('option[value="' + responseJSON.category.id + '"]').text(responseJSON.category.category_name_display);
                        $('#create-category-form').find('div#main-icon > img').attr('src', responseJSON.category.no_image);
                        $('#create-category-form').find('input[name="id"]').val('');
                    }
                    resetForm($('#create-category-form'));
                } else if (responseJSON.error) {
                    show_alert_error(responseJSON.error);
                }
                $('a#qq-cancel-link')[0].click();
            }
        }
    });
}

/*-------------------------------------------
 Function for Product upload page
 ---------------------------------------------*/
function ProductUpload() {
    var uploader = new qq.FineUploader({
        autoUpload: false,
        multiple: false,
        element: document.getElementById('product-qq-uploader'),
        template: 'product-qq-template',
        form: {
            element: 'create-product-form'
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
            show_alert_error(message);
        },
        request: {
            inputName: 'main_photo'
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
                    show_alert_success(responseJSON.error);

                    location = '/admin/product';
                } else if (responseJSON.error) {
                    show_alert_error(responseJSON.error);
                }
                $('a#qq-cancel-link')[0].click();
            }
        }
    });
}

/*-------------------------------------------
 Function for Product upload page
 ---------------------------------------------*/
function FormUpload(option) {
    var uploader = new qq.FineUploader({
        autoUpload: false,
        multiple: false,
        element: document.getElementById(option.el),
        template: option.template,
        form: {
            element: option.form
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
            show_alert_error(message);
        },
        request: {
            inputName: option.inputName
        },
        callbacks: {
            onSubmitted: function () {
                $('#main-icon').hide();
            },
            onCancel: function () {
                $('#main-icon').show();
            },
            onComplete: function (id, name, responseJSON, xhr) {
                if (responseJSON.errors) {
                    var msg = '';
                    $.each(responseJSON.errors, function (index, value) {
                        msg += value + '\n\r';
                    });
                    show_alert_error(msg);
                } else if (responseJSON.success) {
                    if (typeof option.type !== 'undefined' && option.type === 'update-user-icon') {
                        $('div.avatar > img, div#main-icon > img').attr('src', responseJSON.photo_name);
                    }
                    if (typeof option.type !== 'undefined' && option.type === 'create-product-photo') {
                        location = '/admin/product';
                    }
                    show_alert_success(responseJSON.msg);
                } else {
                    show_alert_error(responseJSON.error);
                }
                $('a#qq-cancel-link')[0].click();
            }
        }
    });
}

//
// Function for table, located in element with id = datatable
//
function DataTable() {
    $.extend($.fn.dataTable.defaults, {
        bInfo: false,
        bSort: false,
        bPaginate: false
    });
    var asInitVals = [];
    var oTable = $('#datatable').dataTable({
        "aaSorting": [[0, "asc"]],
        "sDom": "<'box-content'<'col-sm-6'f><'col-sm-6 text-right'l><'clearfix'>>rt<'box-content'<'col-sm-6'i><'col-sm-6 text-right'p><'clearfix'>>",
        "sPaginationType": "bootstrap",
        "oLanguage": {
            "sSearch": "",
            "sLengthMenu": '_MENU_'
        },
        "bAutoWidth": false
    });
    var header_inputs = $("#datatable thead input");
    header_inputs.on('keyup', function () {
        /* Filter on the column (the index) of this element */
        oTable.fnFilter(this.value, header_inputs.index(this));
    }).on('focus', function () {
        if (this.className === "search_init") {
            this.className = "";
            this.value = "";
        }
    }).on('blur', function (i) {
        if (this.value === "") {
            this.className = "search_init";
            this.value = asInitVals[header_inputs.index(this)];
        }
    });
    header_inputs.each(function (i) {
        asInitVals[i] = this.value;
    });
    $('.dataTables_filter').each(function () {
        $(this).find('label input[type=text]').attr('placeholder', 'Search');
    });
}

//
// Helper for run TinyMCE editor with textarea's
//
function TinyMCEStart(elem, mode) {
    var plugins = [];
    if (mode === 'basic') {
        var plugins = [
            'advlist autolink lists link charmap preview anchor',
            'searchreplace visualblocks code',
            'insertdatetime media table contextmenu paste'
        ];
        var toolbar = 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | preview';
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
    var $form = $form,
            fName = $form.attr('id'),
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
            }
            $form.find('div').removeClass('has-success');
            show_alert_success(data.success);
        } else if (data.error) {
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
    LoadSelect2Script($('select').select2('val', value));
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
