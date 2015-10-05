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
    // client
    'signin' => 'auth/signin',
    'signup' => 'auth/signup',
    'signout' => 'auth/signout',
);
