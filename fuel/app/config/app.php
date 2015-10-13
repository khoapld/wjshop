<?php

return array(
    'image' => array(
        'icon' => 160,
        'category' => 320,
        'product' => 320,
        'photo' => array('l' => '1024', 'm' => '640', 's' => '320'),
    ),
    'path' => array(
        'no_icon' => 'assets/img/no_icon.png',
        'no_image' => 'assets/img/no_image.png',
        'icon' => 'upload/icon/',
        'category' => 'upload/category/',
        'product' => 'upload/product/',
        'root_photo' => 'upload/photo/',
        'photo' => 'upload/photo/s/',
    ),
    'user' => array(
        'group' => array(
            '100' => 'Administrator',
            '200' => 'Member',
            '300' => 'Banned',
            '400' => 'Deleted'
        ),
        'gender' => array(
            0 => 'Both',
            1 => 'Male',
            2 => 'Female'
        ),
    ),
    'category' => array(
        'status' => array(
            1 => 'Show',
            2 => 'Hide'
        ),
    ),
    'product' => array(
        'status' => array(
            1 => 'Show',
            2 => 'Hide'
        ),
    ),
);
