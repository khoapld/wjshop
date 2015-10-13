<?php

return array(
    '_root_' => 'home/index', // The default route
    '_403_' => 'home/not_found', // The main 404 route
    '_404_' => 'home/not_found',
    '_500_' => 'home/not_found',
    // admin
    'admin/signin' => 'admin/auth/signin',
    'admin/signout' => 'admin/auth/signout',
    'admin' => 'admin/dashboard',
    'admin/product' => 'admin/product/index',
    'admin/product/list' => 'admin/product/list',
    'admin/product/new' => 'admin/product/new',
    'admin/product/create' => 'admin/product/create',
    'admin/product/update' => 'admin/product/update',
    'admin/product/main_photo' => 'admin/product/main_photo',
    'admin/product/sub_photo' => 'admin/product/sub_photo',
    'admin/product/status' => 'admin/product/status',
    'admin/product/sort_sub_photo' => 'admin/product/sort_sub_photo',
    'admin/product/delete_sub_photo' => 'admin/product/delete_sub_photo',
    'admin/product/(:any)' => 'admin/product/edit/$1',
    // client
    'signin' => 'auth/signin',
    'signup' => 'auth/signup',
    'signout' => 'auth/signout',
);
