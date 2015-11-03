/*scroll to top*/
$(document).ready(function () {
    $(function () {
        $.scrollUp({
            scrollName: 'scrollUp', // Element ID
            scrollDistance: 300, // Distance from top/bottom before showing element (px)
            scrollFrom: 'top', // 'top' or 'bottom'
            scrollSpeed: 300, // Speed back to top (ms)
            easingType: 'linear', // Scroll to top easing (see http://easings.net/)
            animation: 'fade', // Fade, slide, none
            animationSpeed: 200, // Animation in speed (ms)
            scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
            //scrollTarget: false, // Set a custom target element for scrolling to the top
            scrollText: '<i class="fa fa-angle-up"></i>', // Text for element, can contain HTML
            scrollTitle: false, // Set a custom <a> title if required.
            scrollImg: false, // Set true to use image
            activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
            zIndex: 2147483647 // Z-Index for the overlay
        });
    });

    $('#contact-form').on('submit', function (event) {
        event.preventDefault();
        var $form = $(this),
                formData = $form.serialize(),
                url = $form.attr('action');

        $form.find('.error').empty();
        $form.find('button').attr('disabled', 'disabled');
        $form.find('.success').empty();

        var posting = $.post(url, formData);
        posting.done(function (data) {
            if (typeof data.errors !== 'undefined') {
                $.each(data.errors, function (index, value) {
                    $form.find('.error.' + index).html(value);
                });
            } else {
                $form.find('input').val('');
                $form.find('textarea').val('');
                $form.find('.success').html(data.success);
            }
            $form.find('button').removeAttr('disabled').removeClass('loading');
        });
    });
});
