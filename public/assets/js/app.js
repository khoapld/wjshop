$(function () {
    // submit form
    var formName = [
        "form-signin", "form-signup", "form-create-expense"
    ];
    for (var i = 0; i < formName.length; i++) {
        $(document).on("submit", "#" + formName[i], function (event) {
            event.preventDefault();
            var $form = $(this);
            submit_form($form);
        });
    }

    $(document).on("click", "#create-expense", function (event) {
        event.preventDefault();
        $('#create-expense').addClass('disabled');
        $('#create-expense-form').prepend('<form id="form-create-expense" class="form-inline" method="POST" action="/create_expense">' +
                '<div class="form-group col-md-4">' +
                '<label class="sr-only">Expense Name</label>' +
                '<input type="text" class="form-control" placeholder="Expense Name" name="expense_name">' +
                '</div>' +
                '<div class="form-group col-md-4">' +
                '<label class="sr-only">Expense Price</label>' +
                '<input type="text" class="form-control" placeholder="Expense Price" name="expense_price">' +
                '</div>' +
                '<button type="submit" id="btn-create-expense" class="btn btn-primary">Create</button>' +
                '<div class="form-group col-md-4">' +
                '<label class="text-danger error expense_name"></label>' +
                '</div>' +
                '<div class="form-group col-md-4">' +
                '<label class="text-danger error expense_price"></label>' +
                '</div>' +
                '</form>');
    });
});

function submit_form($form) {
    var $form = $form,
            fName = $form.attr("id"),
            formData = $form.serialize(),
            url = $form.attr("action");
    if (typeof url === "undefined") {
        url = $form.attr("j_action");
    }

    if (fName === "form-create-expense") {
        var expensePrice = $form.find('input[name=expense_price]').val();
        if (expensePrice > 10000000) {
            if (!confirm('Do you sure this expense is ' + expensePrice + ' VND?'))
                return false;
        }
    }

    $form.find(".error").empty();
    $form.find("button").attr("disabled", "disabled").addClass("loading");

    var posting = $.post(url, formData);
    posting.done(function (data) {
        if (typeof data.errors !== 'undefined') {
            $.each(data.errors, function (index, value) {
                $form.find(".error." + index).html(value);
            });
        } else {
            if (fName === "form-signin") {
                location = "/";
                return false;
            } else if (fName === "form-signup") {
                location = "/";
                return false;
            } else if (fName === "form-create-expense") {
                $('#create-expense').removeAttr("disabled").removeClass('disabled');
                $form.remove();
                $('#expense-list').html(data);
            }
        }
        $form.find("button").removeAttr("disabled").removeClass("loading");
    });

}
