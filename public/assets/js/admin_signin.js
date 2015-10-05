$(function () {

    $('#signin-form').on('submit', function (event) {
        event.preventDefault();
        var $form = $(this),
                formData = $form.serialize(),
                url = $form.attr('action');

        $form.find('.error').empty();
        $form.find('button').attr('disabled', 'disabled');

        var posting = $.post(url, formData);
        posting.done(function (data) {
            if (typeof data.errors !== 'undefined') {
                $.each(data.errors, function (index, value) {
                    $form.find('.error.' + index).html(value);
                });
            } else {
                location = '/admin';
            }
            $form.find('button').removeAttr('disabled').removeClass('loading');
        });
    });

});
