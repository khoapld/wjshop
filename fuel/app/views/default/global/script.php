<?php

echo Asset::js([
    '//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.6.0/underscore-min.js',
    '//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js',
//    '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js',
//    '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/i18n/jquery.ui.datepicker-ja.js',
]);

//echo Asset::js('bootstrap.min.js');
echo Asset::js('app.js');
